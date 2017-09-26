<?php
namespace Workflow;

use App\Entry,App\Flowlink,App\Emp,App\ProcessVar,App\EntryData,App\Proc;
use DB,Auth;

use Workflow\Traits\WorkflowTrait;

class Workflow implements WorkflowInterface{
	use WorkflowTrait;

	/**
	 * [getNextAuditorIds 获得下一步审批人员工id
	 * @return []
	 */
	protected function getProcessAuditorIds(Entry $entry,$process_id){
		$auditor_ids=[];
		//查看是否自动选人
		if($flowlink=Flowlink::where('type','Sys')->where('process_id',$process_id)->first()){
			if($flowlink->auditor=='-1000'){
				//发起人
				$auditor_ids[]=$entry->emp_id;
			}

			if($flowlink->auditor=='-1001'){
				//发起人部门主管
				if(empty($entry->emp->dept)){
					return $auditor_ids;
				}
				$auditor_ids[]=$entry->emp->dept->director_id;
			}

			if($flowlink->auditor=='-1002'){
				//发起人部门经理
				if(empty($entry->emp->dept)){
					return $auditor_ids;
				}
				$auditor_ids[]=$entry->emp->dept->manager_id;
			}
		}else{
			//并行
			if($flowlink=Flowlink::where('type','Emp')->where('process_id',$process_id)->first()){
				//指定员工
				$auditor_ids=array_merge($auditor_ids,explode(',',$flowlink->auditor));
			}

			if($flowlink=Flowlink::where('type','Dept')->where('process_id',$process_id)->first()){
				//指定部门
				$dept_ids=explode(',',$flowlink->auditor);

				$emp_ids=Emp::whereIn('dept_id',$dept_ids)->get()->pluck('id')->toArray();

				$auditor_ids=array_merge($auditor_ids,$emp_ids);
			}

			if($flowlink=Flowlink::where('type','Role')->where('process_id',$process_id)->first()){
				//指定角色
			}
		}

		return array_unique($auditor_ids);

	}

	/**
	 * [setFirstProcessAuditor 初始流转]
	 * @param [type] $entry    [description]
	 * @param [type] $flowlink [description]
	 */
	public function setFirstProcessAuditor(Entry $entry,Flowlink $flowlink){
		$process_id=$process_name=null;
	    if(!Flowlink::where('type','!=','Condition')->where('process_id',$flowlink->process_id)->first()){
	        //第一步未指定审核人 自动进入下一步操作
	        $entry->procs()->create([
	            'flow_id'=>$entry->flow_id,
	            'process_id'=>$flowlink->process_id,
	            'process_name'=>$flowlink->process->process_name,
	            'emp_id'=>$entry->emp_id,
	            'emp_name'=>$entry->emp->name,
	            'dept_name'=>$entry->emp->dept->dept_name,
	            'auditor_id'=>$entry->emp_id,
	            'auditor_name'=>$entry->emp->name,
	            'auditor_dept'=>$entry->emp->dept->dept_name,
	            'status'=>9,
	            'circle'=>$entry->circle,
	            'concurrence'=>time()
	        ]);

	        $auditor_ids=$this->getProcessAuditorIds($entry,$flowlink->next_process_id);

	        $process_id=$flowlink->next_process_id;
	        $process_name=$flowlink->next_process->process_name;
	        $entry->process_id=$flowlink->next_process_id;
	    }else{
	        $auditor_ids=$this->getProcessAuditorIds($entry,$flowlink->process_id);

	        $process_id=$flowlink->process_id;
	        $process_name=$flowlink->process->process_name;

	        $entry->process_id=$flowlink->process_id;
	    }

	    //步骤流转
	    //步骤审核人
	    $auditors=Emp::whereIn('id',$auditor_ids)->get();
	    if($auditors->count()<1){
	        throw new \Exception("下一步骤未找到审核人", 1);
	    }
	    $time=time();
	    foreach($auditors as $v){
	        $entry->procs()->create([
	            'flow_id'=>$entry->flow_id,
	            'process_id'=>$process_id,
	            'process_name'=>$process_name,
	            'emp_id'=>$v->id,
	            'emp_name'=>$v->name,
	            'dept_name'=>$v->dept->dept_name,
	            'status'=>0,
	            'circle'=>$entry->circle,
	            'concurrence'=>$time
	        ]);
	    }

	    $entry->save();
	}

	/**
	 * [flowlink 流转]
	 * @param  [type] $process_id [description]
	 * @return [type]             [description]
	 */
	public function flowlink($process_id){
	    $proc=Proc::with('entry.emp.dept')->where(['emp_id'=>Auth::id()])->where(["status"=>0])->findOrFail($process_id);

	    if(Flowlink::where(['process_id'=>$proc->process_id,"type"=>"Condition"])->count()>1){
	        //有条件 TODO 多个变量字段 待处理
	        $var=ProcessVar::where(['process_id'=>$proc->process_id])->first(); //$var->expression_field  $var->expression_field_value
	        //当前步骤判断的变量 需要根据 $var->expression_field（如请假 day） 去查当前工作流提交的表单数据 里的值 TODO
	        $value=EntryData::where(['entry_id'=>$proc->entry_id,'field_name'=>$var->expression_field])->value('field_value');

	        $flowlinks=Flowlink::where(['process_id'=>$proc->process_id,"type"=>"Condition"])->get();
	        // $$var->expression_field_value=$var->expression_field_value;
	        $flowlink=null;
	        $field=$var->expression_field;
	        foreach($flowlinks as $v){
	            // $day=2;
	            // eval('$res='.'$day>1 AND $day<3;');
	            // dd($res);
	            if(empty($v->expression)){
	                throw new \Exception('未设置流转条件，无法流转，请联系流程设置人员',1);
	            }

	            if($v->expression=='1'){
	            	$flowlink=$v;
	            	break;
	            }else{
	            	$$field=$value;
		            eval('$res='.$v->expression.';');
		            if($res){
		                $flowlink=$v;
		                break;
		            }
	            }
	            
	        }

	        if(empty($flowlink)){
	        	throw new \Exception('未满足流转条件，无法流转到下一步骤，请联系流程设置人员',1);
	        }

	        $auditor_ids=$this->getProcessAuditorIds($proc->entry,$flowlink->next_process_id);
	        if(empty($auditor_ids)){
	        	throw new \Exception("下一步骤未找到审核人", 1);
	        }

	        $auditors=Emp::whereIn('id',$auditor_ids)->get();

	        if($auditors->count()<1){
	            throw new \Exception("下一步骤未找到审核人", 1);
	        }

	        $time=time();
	        foreach($auditors as $v){
	            Proc::create([
	                'entry_id'=>$proc->entry_id,
	                'flow_id'=>$proc->flow_id,
	                'process_id'=>$flowlink->next_process_id,
	                'process_name'=>$flowlink->next_process->process_name,
	                'emp_id'=>$v->id,
	                'emp_name'=>$v->name,
	                'dept_name'=>$v->dept->dept_name,
	                'circle'=>$proc->entry->circle,
	                'status'=>0,
	                'is_read'=>0,
	                'concurrence'=>$time
	            ]);
	        }

	        $proc->entry->update([
	            'process_id'=>$flowlink->next_process_id
	        ]);

	        //判断是否存在父进程
	        if($proc->entry->pid>0){
	            $proc->entry->parent_entry->update([
	                'child'=>$flowlink->next_process_id
	            ]);
	        }

	    }else{
	        $flowlink=Flowlink::where(['process_id'=>$proc->process_id,"type"=>"Condition"])->first();

	        if($flowlink->process->child_flow_id>0){
	            // 创建子流程
	            if(!$child_entry=Entry::where(['pid'=>$proc->entry->id,'circle'=>$proc->entry->circle])->first()){
	                $child_entry=Entry::create([
	                    'title'=>$proc->entry->title,
	                    'flow_id'=>$flowlink->process->child_flow_id,
	                    'emp_id'=>$proc->entry->emp_id,
	                    'status'=>0,
	                    'pid'=>$proc->entry->id,
	                    'circle'=>$proc->entry->circle,
	                    'enter_process_id'=>$flowlink->process_id,
	                    'enter_proc_id'=>$proc->id,
	                ]);
	            }
	            
	            $child_flowlink=Flowlink::where(['flow_id'=>$flowlink->process->child_flow_id,'type'=>'Condition'])->whereHas('process',function($query){
	                $query->where('position',0);
	            })->orderBy("sort","ASC")->first();

	            $this->setFirstProcessAuditor($child_entry,$child_flowlink);

	            $child_entry->parent_entry->update([
	                'child'=>$child_entry->process_id
	            ]);

	        }else{
	            if($flowlink->next_process_id==-1){
	                //最后一步
	                $proc->entry()->update([
	                    'status'=>9,
	                    'process_id'=>$flowlink->process_id
	                ]);

	                //子流程结束
	                if($proc->entry->pid>0){
	                    if($proc->entry->enter_process->child_after==1){
	                        //同时结束父流程
	                        $proc->entry->parent_entry->update([
	                            'status'=>9,
	                            'child'=>0
	                        ]);
	                    }else{
	                        //进入设置的父流程步骤
	                        if($proc->entry->enter_process->child_back_process>0){
	                        	$this->goToProcess($proc->entry->parent_entry,$proc->entry->enter_process->child_back_process);
	                            $proc->entry->parent_entry->process_id=$proc->entry->enter_process->child_back_process;
	                        }else{
	                        	//默认进入父流程步骤下一步
	                        	$parent_flowlink=Flowlink::where(['process_id'=>$proc->entry->enter_process->id,"type"=>"Condition"])->first();

	                        	//判断是否为最后一步
	                        	if($parent_flowlink->next_process_id==-1){
	                        		$proc->entry->parent_entry->update([
			                            'status'=>9,
			                            'child'=>0,
			                            'process_id'=>$proc->entry->enter_process->child_back_process
			                        ]);
			                        //流程结束通知
	    							$proc->entry->emp->notify(new \App\Notifications\Flowfy(Proc::find($proc->id)));
	                        	}else{
	                        		$this->goToProcess($proc->entry->parent_entry,$parent_flowlink->next_process_id);

	                                $proc->entry->parent_entry->process_id=$parent_flowlink->next_process_id;
	                                $proc->entry->parent_entry->status=0;
	                        	}
	                        }

	                        $proc->entry->parent_entry->child=0;
	                        
	                        $proc->entry->parent_entry->save();
	                    }
	                    
	                }else{
	                	//流程结束通知
	    				$proc->entry->emp->notify(new \App\Notifications\Flowfy(Proc::find($proc->id)));
	                }
	            }else{
	                //'entry_id','flow_id','process_id','emp_id','status','content','is_read'
	                $auditor_ids=$this->getProcessAuditorIds($proc->entry,$flowlink->next_process_id);
	                $auditors=Emp::whereIn('id',$auditor_ids)->get();

	                if($auditors->count()<1){
	                    throw new \Exception("下一步骤未找到审核人", 1);
	                }
	                foreach($auditors as $v){
	                    Proc::create([
	                        'entry_id'=>$proc->entry_id,
	                        'flow_id'=>$proc->flow_id,
	                        'process_id'=>$flowlink->next_process_id,
	                        'process_name'=>$flowlink->next_process->process_name,
	                        'emp_id'=>$v->id,
	                        'emp_name'=>$v->name,
	                        'dept_name'=>$v->dept->dept_name,
	                        'circle'=>$proc->entry->circle,
	                        'status'=>0,
	                        'is_read'=>0
	                    ]);
	                }

	                $proc->entry->update([
	                    'process_id'=>$flowlink->next_process_id
	                ]);

	                //判断是否存在父进程
	                if($proc->entry->pid>0){
	                    $proc->entry->parent_entry->update([
	                        'child'=>$flowlink->next_process_id
	                    ]);
	                }
	            }
	        }
	    }

	    Proc::where(['entry_id'=>$proc->entry_id,'process_id'=>$proc->process_id,'circle'=>$proc->entry->circle,'status'=>0])->update([
	        'status'=>9,
	        'auditor_id'=>\Auth::id(),
	        'auditor_name'=>\Auth::user()->name,
	        'auditor_dept'=>\Auth::user()->dept->dept_name,
	        'content'=>\Request::input('content',''),
	    ]);

	}

	/**
	 * [goToProcess 前往固定流程步骤]
	 * @param  [type] $entry      [description]
	 * @param  [type] $process_id [description]
	 * @return [type]             [description]
	 */
	protected function goToProcess(Entry $entry,$process_id){
	    $auditor_ids=$this->getProcessAuditorIds($entry,$process_id);

	    $auditors=Emp::whereIn('id',$auditor_ids)->get();

	    if($auditors->count()<1){
	        throw new \Exception("下一步骤未找到审核人", 1);
	    }
	    $time=time();
	    foreach($auditors as $v){
	        Proc::create([
	            'entry_id'=>$entry->id,
	            'flow_id'=>$entry->flow_id,
	            'process_id'=>$process_id,
	            'process_name'=>Process::find($process_id)->process_name,
	            'emp_id'=>$v->id,
	            'emp_name'=>$v->name,
	            'dept_name'=>$v->dept->dept_name,
	            'circle'=>$entry->circle,
	            'status'=>0,
	            'is_read'=>0,
	            'time'=>$time,
	        ]);
	    }
	}
}
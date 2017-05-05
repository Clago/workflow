<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flow,App\Flowlink,App\Process,App\Dept,App\Emp;
use DB;

class FlowlinkController extends Controller
{
    public function pifu(Request $request,$id){

    }

    public function update(Request $request){
        try{
            DB::beginTransaction();
            // process_info:{"9023":{"top":175,"left":492,"process_to":[]},"9024":{"top":427,"left":453,"process_to":[]},"9026":{"top":328,"left":865,"process_to":[]},"9028":{"top":244,"left":201,"process_to":[]},"9033":{"top":427,"left":572,"process_to":[]},"9036":{"top":162,"left":1105,"process_to":[]},"9037":{"top":109,"left":235,"process_to":[]},"9038":{"top":91,"left":460,"process_to":[]},"9074":{"top":201,"left":117,"process_to":[]},"9075":{"top":264,"left":435,"process_to":[]},"9076":{"top":112,"left":764,"process_to":[]}}
        
            //保存流程设计
            $flow_id=$request->input('flow_id',0);

            //TODO 更新flow 表 jsplumb json数据. 更新流程轨迹 flowlink表 type=Condition
            
            $process_info=json_decode($request->input('process_info',[]),true);

            //删除节点后保存 过滤掉删除节点
            // if($del_process_id=session('del_process_id')){
            //     foreach($process_info as $k=>$v){
            //         if($k==$del_process_id){
            //             unset($process_info[$k]);
            //         }
            //     }
            //     session()->forget('del_process_id');
            // }

            if(!empty($process_info)){
                $flow=Flow::findOrFail($flow_id);

                //更新flow 表 jsplumb json数据
                $jsplumb=json_decode($flow->jsplumb,true);
                $jsplumb['total']=count($process_info);

                foreach($process_info as $k=>$v){
                    //更新flow 表 jsplumb json数据
                    // dump($v);
                    foreach($jsplumb['list'] as $i=>$j){
                        if($k==$j['id']){
                            $process=Process::where(['id'=>$k])->first();
                            // dd($process);
                            $process->update([
                                'style'=>'width:'.$process->style_width.'px;height:'.$process->style_width.'px;line-height:30px;color:'.$process->style_color.';left:'.$v['left'].'px;top:'.$v['top'].'px;',
                                'position_left'=>$v['left'].'px',
                                'position_top'=>$v['top'].'px'
                            ]);

                            $jsplumb['list'][$i]['process_to']=implode(',',$v['process_to']);
                            $jsplumb['list'][$i]['style']='width:'.$process->style_width.'px;height:'.$process->style_height.'px;line-height:30px;color:'.$process->style_color.';left:'.$v['left'].'px;top:'.$v['top'].'px;';
                            
                        }
                    }

                    //更新流程轨迹 flowlink表 type=Condition
                    $old_process_ids=Flowlink::where(['flow_id'=>$flow_id,'type'=>'Condition','process_id'=>$k])->pluck('next_process_id')->toArray();

                    if(!empty($v['process_to'])){

                        if($v['process_to']!=$old_process_ids){
                            //有变动
                            //新增连线
                            $adds=array_diff($v['process_to'],$old_process_ids);
                            foreach($adds as $a){
                                Flowlink::create([
                                    'flow_id'=>$flow_id,
                                    'type'=>'Condition',
                                    'process_id'=>$k,
                                    'next_process_id'=>$a,
                                    'sort'=>100
                                ]);
                            }

                            //删除的连线
                            $dels=array_diff($old_process_ids,$v['process_to']);
                            Flowlink::where(['flow_id'=>$flow_id,'type'=>'Condition','process_id'=>$k])->whereIn('next_process_id',$dels)->delete();
                        }
                    }else{
                        if(count($old_process_ids)>1){
                            //只保留一个
                            $old_id=array_pop($old_process_ids);

                            Flowlink::where(['flow_id'=>$flow_id,'type'=>'Condition','process_id'=>$k])->whereIn('next_process_id',$old_process_ids)->delete();

                            Flowlink::where(['flow_id'=>$flow_id,'type'=>'Condition','process_id'=>$old_id])->update([
                                'next_process_id'=>-1,
                            ]);
                        }else{
                            if(Flowlink::where(['flow_id'=>$flow_id,'type'=>'Condition','process_id'=>$k])->first()){
                                Flowlink::where(['flow_id'=>$flow_id,'type'=>'Condition','process_id'=>$k])->update([
                                    'next_process_id'=>-1,
                                ]);
                            }else{
                                Flowlink::create([
                                    'flow_id'=>$flow_id,
                                    'type'=>'Condition',
                                    'process_id'=>$k,
                                    'next_process_id'=>-1,
                                    'sort'=>100
                                ]);
                            }
                        }
                    }
                }
                $flow->jsplumb=json_encode($jsplumb);
                $flow->is_publish=0;
                $flow->save();
            }

            DB::commit();
            return response()->json(['status_code'=>0,'message'=>'更新成功']);
        }catch(\Eexception $e){
            DB::rollabck();
            dd($e);
        }
    }


    //权限
    //部门
    public function dept(Request $request){
        $depts=Dept::recursion(Dept::with(['director','manager'])->orderBy('rank','ASC')->get());
        return view('flowlink.dept')->with(compact('depts'));
    }

    //角色 TODO
    public function role(Request $request){
        return view('flowlink.role');
    }

    //员工
    public function emp(Request $request,$id){
        $depts=Dept::recursion(Dept::with(['director','manager'])->orderBy('rank','ASC')->get());
        $emps=Emp::get();
        //当前节点
        $process=Process::findOrFail($id);
        //当前选择员工
        $select_emps=Emp::whereIn('id',explode(',',Flowlink::where('type','Emp')->where('process_id',$process->id)->value('auditor')))->get();
        return view('flowlink.emp')->with(compact('depts','emps','select_emps'));
    }
}

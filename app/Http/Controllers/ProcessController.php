<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Flow,App\Process,App\Flowlink,App\Emp,App\ProcessVar,App\Dept;
use DB;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            //{"status":1,"msg":"success","info":{"id":"9036","flow_id":1660,"process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"","style":"left:1105px;top:162px;color:#0e76a8;"}}
            $data=$request->all();

            $flow=Flow::findOrFail($data['flow_id']);

            // {"total":9,"list":[{"id":"9023","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"icon-lock","style":"width:30px;height:30px;line-height:30px;color:#78a300;left:492px;top:175px;"},{"id":"9024","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"icon-star","style":"width:120px;height:30px;line-height:30px;color:#0e76a8;left:453px;top:427px;"},{"id":"9025","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"9023,9026","icon":"icon-heart","style":"width:120px;height:30px;line-height:30px;color:#f70;left:871px;top:219px;"},{"id":"9026","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"icon-star","style":"width:120px;height:30px;line-height:30px;color:#0e76a8;left:865px;top:328px;"},{"id":"9028","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"icon-star","style":"width:120px;height:30px;line-height:30px;color:#0e76a8;left:201px;top:244px;"},{"id":"9033","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"icon-star","style":"width:120px;height:30px;line-height:30px;color:#0e76a8;left:572px;top:427px;"},{"id":"9036","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"icon-star","style":"width:120px;height:30px;line-height:30px;color:#0e76a8;left:1105px;top:162px;"},{"id":"9037","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"icon-star","style":"width:120px;height:30px;line-height:30px;color:#0e76a8;left:235px;top:109px;"},{"id":"9038","flow_id":"1660","process_name":"\u65b0\u5efa\u6b65\u9aa4","process_to":"","icon":"icon-star","style":"width:120px;height:30px;line-height:30px;color:#0e76a8;left:460px;top:91px;"}]}

            $process=Process::create([
                'flow_id'=>$flow->id,
                'process_name'=>'新建步骤',
                'style'=>'width:30px;height:30px;line-height:30px;color:#78a300;left:'.$data['left'].';top:'.$data['top'].';',
                'position_left'=>$data['left'],
                'position_top'=>$data['top']
            ]);

            if($flow->jsplumb==''){
                //第一次新建
                $jsplumb=[
                    'total'=>1,
                    "list"=>[],
                ];
            }else{
                //更新
                $jsplumb=json_decode($flow->jsplumb,true);
            }

            $jsplumb['list'][]=[
                'id'=>$process->id,
                'flow_id'=>$flow->id,
                'process_name'=>$process->process_name,
                'process_to'=>'',
                'icon'=>'',
                'style'=>$process->style
            ];

            $flow->jsplumb=json_encode($jsplumb);
            $flow->is_publish=0;
            $flow->save();

            $res=[
                "status_code"=>0,
                "message"=>'success',
                'data'=>[
                    'id'=>$process->id,
                    'flow_id'=>$flow->id,
                    'process_name'=>$process->process_name,
                    'process_to'=>'',
                    'icon'=>'',
                    'style'=>'left:'.$data['left'].';top:'.$data['top'].';color:#0e76a8;'
                ]
            ];
            DB::commit();
            return response()->json($res);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with(['status_code'=>-1,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $data=$request->all();

            DB::beginTransaction();
            //更新当前步骤的基本信息以及样式
            $process_name=$request->input('process_name','');
            $style_color=$request->input('style_color','');
            $style_icon=$request->input('style_icon','');
            $style_height=$request->input('style_height','');
            $style_width=$request->input('style_width','');

            $process=Process::findOrFail($id);

            if(in_array($data['process_position'], [9])){
                if(Flowlink::where('process_id',$id)->where("type","Condition")->count()>1){
                    return redirect()->back()->with(['status_code'=>1,'message'=>'该节点是分支节点，不能设置为结束或起始步骤']);
                }
            }

            if(in_array($data['process_position'], [0])){
                Process::where(['flow_id'=>$process->flow_id,'position'=>0])->update([
                    'position'=>1
                ]);

                Process::where(['flow_id'=>$process->flow_id,'id'=>$id])->update([
                    'position'=>0
                ]);
            }

            $process->update([
                'process_name'=>$process_name,
                'style_color'=>$style_color,
                'style_height'=>$style_height,
                'style_width'=>$style_width,
                'style'=>'width:'.$style_width.'px;height:'.$style_height.'px;line-height:30px;color:'.$style_color.';left:'.$process->position_left.';top:'.$process->position_top.';',
                'icon'=>$style_icon,
                'position'=>$data['process_position'],
                'child_flow_id'=>$data['child_flow_id'],
                'child_after'=>$data['child_after'],
                'child_back_process'=>$data['child_back_process']
            ]);

            // 同步更新jsplumb json数据
            $flow=Flow::findOrFail($process->flow_id);
            $jsplumb=json_decode($flow->jsplumb,true);

            foreach($jsplumb['list'] as $k=>$v){
                if($v['id']==$id){
                    $jsplumb['list'][$k]['process_name']=$process->process_name;
                    $jsplumb['list'][$k]['style']=$process->style;
                    $jsplumb['list'][$k]['icon']=$process->icon;
                }
            }

            $flow->jsplumb=json_encode($jsplumb);
            $flow->is_publish=0;
            $flow->save();

            //更新步骤 流转条件 process_condition
            $process_condition=explode(',', trim($request->input('process_condition',',')));

            foreach($process_condition as $v){
                //获取流转设置的表达式'$day' > '3'  AND '$day' <= '14'
                if($exp=$request->input('process_in_set_'.$v,'')){
                    //匹配变量
                    // $exp='$day > 3  AND $day <= 14';
                    preg_match_all("/\\$(\w+)/", $exp, $variables);

                    // dd($variables);
                    
                    if(empty($variables) && empty($variables[1])){
                        throw new \Exception("非法参数", 1);
                    }

                    $fields=$flow->template->template_form->pluck('field')->toArray();
                    
                    foreach($variables[1] as $var){

                        if(!in_array($var, $fields)){
                            throw new \Exception("非法参数", 1);
                        }

                        if(!ProcessVar::where(['expression_field'=>$var,'process_id'=>$id])->first()){
                            ProcessVar::create([
                                'process_id'=>$id,
                                'flow_id'=>$flow->id,
                                'expression_field'=>$var
                            ]);
                        }
                    }


                    //当前流转
                    $link=Flowlink::where(['flow_id'=>$flow->id,'process_id'=>$id,'next_process_id'=>$v])->firstOrFail();

                    $exp=str_replace(PHP_EOL," ",str_replace("'", "", $exp));
                    $link->update([
                        'expression'=>$exp
                    ]);
                }
            }

            //权限处理
            if($data['auto_person']!=0){
                //系统自动选人
                if($flowlink=Flowlink::where(['flow_id'=>$flow->id,'type'=>'Sys','process_id'=>$id])->first()){
                    $flowlink->update([
                        'auditor'=>$data['auto_person']
                    ]);
                }else{
                    Flowlink::create([
                        'flow_id'=>$flow->id,
                        'type'=>'Sys',
                        'process_id'=>$id,
                        'auditor'=>$data['auto_person'],
                        'next_process_id'=>0,
                        'sort'=>100
                    ]);
                }

                Flowlink::where(['flow_id'=>$flow->id,'process_id'=>$id])->where('type','!=','Condition')->where('type','!=','Sys')->delete();
                
            }else{
                //指定角色
                if($role_ids=$data['range_role_ids']){
                    if($flowlink=Flowlink::where(['flow_id'=>$flow->id,'type'=>'Role','process_id'=>$id])->first()){
                        $flowlink->update([
                            'auditor'=>$role_ids
                        ]);
                    }else{
                        Flowlink::create([
                            'flow_id'=>$flow->id,
                            'type'=>'Role',
                            'process_id'=>$id,
                            'auditor'=>$role_ids,
                            'next_process_id'=>0,
                            'sort'=>100
                        ]);
                    }
                }else{
                    Flowlink::where(['flow_id'=>$flow->id,'process_id'=>$id])->where('type','Role')->delete();
                }

                //指定部门
                if($dept_ids=$data['range_dept_ids']){
                    if($flowlink=Flowlink::where(['flow_id'=>$flow->id,'type'=>'Dept','process_id'=>$id])->first()){
                        $flowlink->update([
                            'auditor'=>$dept_ids
                        ]);
                    }else{
                        Flowlink::create([
                            'flow_id'=>$flow->id,
                            'type'=>'Dept',
                            'process_id'=>$id,
                            'auditor'=>$dept_ids,
                            'next_process_id'=>0,
                            'sort'=>100
                        ]);
                    }  
                }else{
                    Flowlink::where(['flow_id'=>$flow->id,'process_id'=>$id])->where('type','Dept')->delete();
                }

                //指定员工
                if($emp_ids=$data['range_emp_ids']){
                    if($flowlink=Flowlink::where(['flow_id'=>$flow->id,'type'=>'Emp','process_id'=>$id])->first()){
                        $flowlink->update([
                            'auditor'=>$emp_ids
                        ]);
                    }else{
                        Flowlink::create([
                            'flow_id'=>$flow->id,
                            'type'=>'Emp',
                            'process_id'=>$id,
                            'auditor'=>$emp_ids,
                            'next_process_id'=>0,
                            'sort'=>100
                        ]);
                    }
                }else{
                    Flowlink::where(['flow_id'=>$flow->id,'process_id'=>$id])->where('type','Emp')->delete();
                }
            }            


            DB::commit();

            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        DB::beginTransaction();
        try{
            $data=$request->all();

            $flow=Flow::findOrFail($data['flow_id']);

            Flowlink::where(['flow_id'=>$flow->id,'process_id'=>$id])->delete();

            Flowlink::where(['flow_id'=>$flow->id,'next_process_id'=>$id])->update([
                'next_process_id'=>-1
            ]);

            $process=Process::where(['flow_id'=>$flow->id])->findOrFail($id);

            $process->delete();

            $jsplumb=json_decode($flow->jsplumb,true);

            foreach($jsplumb['list'] as $k=>$v){
                if($v['id']==$id){
                    unset($jsplumb['list'][$k]);
                }
            }

            $flow->jsplumb=json_encode($jsplumb);
            $flow->is_publish=0;
            $flow->save();

            // session(['del_process_id'=>$id]);
            
            DB::commit();
            return response()->json(['status_code'=>0,'message'=>'删除成功']);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with(['status_code'=>-1,'message'=>$e->getMessage()]);
        }
    }

    public function attribute(Request $request){
        $id=$request->input('id',0);
        $process=Process::findOrFail($id);

        //当前步骤的下一步操作
        $next_process=Flowlink::where(['process_id'=>$process->id,'flow_id'=>$process->flow_id,'type'=>'Condition'])->get();

        $beixuan_process=Flowlink::where(['flow_id'=>$process->flow_id,'type'=>'Condition'])->where('process_id','<>',$process->id)->whereNotIn('process_id',$next_process->pluck('next_process_id'))->get();

        //流程模板 表单字段
        $flow=Flow::findOrFail($process->flow_id);
        $fields=$flow->template?$flow->template->template_form:[];

        //当前选择员工
        $select_emps=Emp::whereIn('id',explode(',',Flowlink::where('type','Emp')->where('process_id',$process->id)->value('auditor')))->get();

        $sys=Flowlink::where(['process_id'=>$process->id,'flow_id'=>$process->flow_id,'type'=>'Sys'])->value('auditor');

        $select_depts=Dept::whereIn('id',explode(',',Flowlink::where('type','Dept')->where('process_id',$process->id)->value('auditor')))->get();

        $flows=Flow::where('is_publish',1)->where('id','<>',$process->flow_id)->get();

        $processes=Process::where('flow_id',$process->flow_id)->get();

        $can_child=Flowlink::where(['process_id'=>$process->id,"type"=>"Condition"])->count()==1;

        return view('partials.attribute')->with(compact('process','next_process','beixuan_process','fields','select_emps','sys','select_depts','flows','processes','can_child'));
    }

    public function condition(Request $request){
        // {"2":{"desc":"不符合条件时的提示","option":"<option value=\"'data_1' = '33'  AND\">'爱好' = '33' AND<\/option><option value=\"'data_2' = '44'\">'姓名' = '44'<\/option>"}}
        
        $flow_id=$request->input('flow_id');
        $process_id=$request->input('process_id');
        $next_process_id=$request->input('next_process_id');

        //当前流转
        $flowlink=Flowlink::where(['process_id'=>$process_id,'next_process_id'=>$next_process_id,'flow_id'=>$flow_id,'type'=>'Condition'])->firstOrFail();
        
        $data=[];

        $fields=Flow::findOrFail($flow_id)->template->template_form;
        $expression=str_replace($fields->pluck('field')->toArray(), $fields->pluck('field_name')->toArray(), str_replace('$','',$flowlink->expression));
        
        $data[$flowlink->next_process_id]=[
            'desc'=>$expression,
            'option'=>''
        ];
        

        return response()->json($data);
    }

    public function setFirst(Request $request){
        $flow_id=$request->input('flow_id',0);
        $process_id=$request->input('process_id',0);

        if(Flowlink::where('process_id',$process_id)->where("type","Condition")->where('next_process_id','>','-1')->count()>1){
            return response()->json([
                'status_code'=>1,
                'message'=>'该节点是分支节点，不能设置为结束步骤'
            ]);
        }

        Process::where(['flow_id'=>$flow_id,'position'=>0])->update([
            'position'=>1
        ]);

        Process::where(['flow_id'=>$flow_id,'id'=>$process_id])->update([
            'position'=>0
        ]);

        return response()->json([
            'status_code'=>0
        ]);
    }

    public function setLast(Request $request){
        $flow_id=$request->input('flow_id',0);
        $process_id=$request->input('process_id',0);

        if(Flowlink::where('process_id',$process_id)->where("type","Condition")->where('next_process_id','>','-1')->count()>1){
            return response()->json([
                'status_code'=>1,
                'message'=>'该节点是分支节点，不能设置为结束步骤'
            ]);
        }

        Process::where(['flow_id'=>$flow_id,'position'=>0])->update([
            'position'=>1
        ]);

        Process::where(['flow_id'=>$flow_id,'id'=>$process_id])->update([
            'position'=>9
        ]);

        return response()->json([
            'status_code'=>0
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Flow,App\Flowlink,App\FlowType,App\Template,App\Entry,App\Process;
use DB,Auth;

class FlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flows=Flow::orderBy('id','DESC')->get();
        return view('flow.index')->with(compact('flows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templates=Template::get();
        $flow_types=FlowType::get();
        return view('flow.create')->with(compact('templates','flow_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'flow_name'=>'required',
            'template_id'=>'required',
        ]);
        Flow::create($request->all());

        return redirect()->route('flow.index')->with(['success'=>1,'message'=>'添加成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flow=Flow::findOrFail($id);
        return view('flow.show')->with(compact('flow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function flowdesign(Request $request,$id)
    {
        if($request->method('GET')){
            // $expresion_field='day';
            // $$expresion_field=2;
            // eval('$res='.'$day>1 AND $day<3;');
            // dd($res);
            $flow=Flow::findOrFail($id);
            return view('flow.design')->with(compact('flow'));
        }
    }

    public function edit(Request $request,$id)
    {

        $flow=Flow::findOrFail($id);
        $templates=Template::get();
        $flow_types=FlowType::get();
        return view('flow.edit')->with(compact('flow','templates','flow_types'));

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
        $flow=Flow::findOrFail($id);
        $flow->update($request->all());

        return redirect()->route('flow.index')->with(['success'=>1,'message'=>'更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flow=Flow::findOrFail($id);

        if(Entry::where('flow_id',$flow->id)->first()){
            return response()->json([
                'error'=>1,
                'msg'=>'该流程已经被使用，不能删除'
            ]);
        }

        if(Process::where('child_flow_id',$flow->id)->first()){
            return response()->json([
                'error'=>1,
                'msg'=>'该流程已经被使用，不能删除'
            ]);
        }

        $flow->process()->delete();
        $flow->process_var()->delete();
        $flow->delete();

        return response()->json([
            'error'=>0,
            'msg'=>'流程删除成功'
        ]);

    }

    public function publish(Request $request){
        try{
            $flow_id=$request->input('flow_id',0);
            $flow=Flow::findOrFail($flow_id);

            if(Flowlink::where(['flow_id'=>$flow->id,'type'=>'Condition'])->count()<=1){
                return response()->json([
                    'status_code'=>1,
                    'message'=>'发布失败，至少两个步骤'
                ]);
            }

            if(Flowlink::where(['flow_id'=>$flow->id,'type'=>'Condition','next_process_id'=>-1])->count()>1){
                return response()->json([
                    'status_code'=>1,
                    'message'=>'发布失败，有步骤没有连线'
                ]);
            }

            if(!Flowlink::whereHas('process',function($query){
                $query->where('position',0);
            })->where('flow_id',$flow_id)->first()){
                return response()->json([
                    'status_code'=>1,
                    'message'=>'发布失败，请设置起始步骤'
                ]);
            }

            // if(!Flowlink::whereHas('process',function($query){
            //     $query->where('position',9);
            // })->first()){
            //     return response()->json([
            //         'status_code'=>1,
            //         'message'=>'发布失败，请设置结束步骤'
            //     ]);
            // }

            $flowlinks=Flowlink::where(['flow_id'=>$flow->id,'type'=>'Condition'])->whereHas('process',function($query){
                $query->where('position','!=',0);
            })->get();

            foreach($flowlinks as $v){
                if(!Flowlink::where(['flow_id'=>$flow->id,'process_id'=>$v->process_id])->where('type','!=','Condition')->whereHas('process',function($query){
                    $query->where('position','!=',0);
                })->first()){
                    return response()->json([
                        'status_code'=>1,
                        'message'=>'发布失败，请给设置步骤审批权限'
                    ]);
                }
            }

            $flow->is_publish=1;
            $flow->save();
            return response()->json([
                'status_code'=>0,
                'message'=>'发布成功'
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with(['status_code'=>1,'message'=>$e->getMessage()]);
        }
    }
}

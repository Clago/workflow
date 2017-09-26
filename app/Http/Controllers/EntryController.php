<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Flow,App\Entry,App\Flowlink,App\Proc,App\EntryData,App\Emp;
use Auth,DB,Workflow;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $flow_id=$request->get('flow_id');
        $flow=Flow::where('is_publish',1)->findOrFail($flow_id);
        $form_html=$flow->template?generateHtml($flow->template):'';
        return view('entry.create')->with(compact("flow","form_html"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();

        try{

            DB::beginTransaction();

            $flow=Flow::where('is_publish',1)->findOrFail($data['flow_id']);

            $flowlink=Flowlink::where(['flow_id'=>$data['flow_id'],'type'=>'Condition'])->whereHas('process',function($query){
                $query->where('position',0);
            })->orderBy("sort","ASC")->first();

            $entry=Entry::create([
                'title'=>$data['title'],
                'flow_id'=>$data['flow_id'],
                'emp_id'=>Auth::id(),
                'circle'=>1,
                'status'=>0
            ]);

            //进程初始化
            //第一步看是否指定审核人
            
            Workflow::setFirstProcessAuditor($entry,$flowlink);

            // dd($data);
            //流程表单数据插入 TODO
            if(isset($data['tpl'])){
                $res=[];
                foreach($data['tpl'] as $k=>$v){
                    if($files=$request->file('tpl')){
                        if(isset($files[$k])){
                            $destinationPath = './uploads/flow/' . date('Y-m') . '/';
                            $filename = uniqid() . '.' . $files[$k]->extension();
                            $files[$k]->move($destinationPath, $filename);
                            $v=substr($destinationPath, 1).$filename;
                        }
                    }
                    $res[]=[
                        'entry_id'=>$entry->id,
                        'flow_id'=>$entry->flow_id,
                        'field_name'=>$k,
                        'field_value'=>is_array($v)?implode('|', $v):$v
                    ];
                }

                EntryData::insert($res);
            }
            $entry->save();
            DB::commit();
            return redirect()->to('/');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with(['success'=>-1,'message'=>$e->getMessage()]);
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
        $entry=Entry::findOrFail($id);

        $form_html=$entry->flow->template?generateHtml($entry->flow->template,$entry->entry_data):'';

        return view('entry.show')->with(compact('entry','form_html'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entry=Entry::findOrFail($id);
        $entry_data=$entry->entry_data;

        $form_html=generateHtml($entry->flow->template,$entry_data);

        return view('entry.edit')->with(compact('entry','form_html'));
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
        $data=$request->all();

        $entry=Entry::findOrFail($id);

        $entry->update($data);

        //流程表单数据插入 TODO
        if(isset($data['tpl'])){
            $res=[];
            foreach($data['tpl'] as $k=>$v){
                //处理图片
                if($files=$request->file('tpl')){
                    if(isset($files[$k])){
                        $destinationPath = './uploads/flow/' . date('Y-m') . '/';
                        $filename = uniqid() . '.' . $files[$k]->extension();
                        $files[$k]->move($destinationPath, $filename);
                        $v=substr($destinationPath, 1).$filename;
                    }
                }
                EntryData::updateOrCreate(['entry_id'=>$entry->id,'field_name'=>$k],[
                    'flow_id'=>$entry->flow_id,
                    'field_value'=>is_array($v)?implode('|', $v):$v,
                    'created_at'=>\Carbon\Carbon::now(),
                    'updated_at'=>\Carbon\Carbon::now(),
                ]);
            }
        }

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function resend(Request $request){
        $entry_id=$request->input('entry_id',0);

        try{
            DB::beginTransaction();
            $entry=Entry::where(['status'=>-1])->findOrFail($entry_id);

            $flow=Flow::where('is_publish',1)->findOrFail($entry->flow_id);

            $flowlink=Flowlink::where(['flow_id'=>$entry->flow_id,'type'=>'Condition'])->whereHas('process',function($query){
                $query->where('position',0);
            })->orderBy("sort","ASC")->first();

            $entry->circle=$entry->circle+1;
            $entry->child=0;
            $entry->status=0;
            $entry->save();

            //进程初始化
            Workflow::setFirstProcessAuditor($entry,$flowlink);

            DB::commit();

            return redirect()->back();

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with(['success'=>-1,'message'=>$e->getMessage()]);
        }
        
    }

    public function cancel(Request $request){
        $entry_id=$request->input('entry_id',0);

        try{
            DB::beginTransaction();
            $entry=Entry::where(['status'=>-1])->findOrFail($entry_id);

            $entry->status=-2;

            $entry->save();
            DB::commit();

            return redirect()->back();

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with(['success'=>-1,'message'=>$e->getMessage()]);
        }
        
    }
}

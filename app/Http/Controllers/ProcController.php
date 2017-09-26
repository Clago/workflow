<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry,App\Proc,App\Flowlink,App\ProcessVar,App\Flow,App\EntryData,App\Emp;
use DB,Auth,Workflow;

class ProcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $entry_id=$request->input('entry_id',0);

        $entry=Entry::findOrFail($entry_id);

        if($entry->pid>0){
            $entry_id=$entry->pid;
        }

        $procs=Proc::select(DB::raw("min(id) id,entry_id,process_id,process_name,GROUP_CONCAT(emp_name) emp_name,auditor_name,status,content,max(updated_at) updated_at"))->with('entry')->where(['entry_id'=>$entry_id])->groupBy('process_id','concurrence','circle')->orderBy('id','ASC')->get();

        return view('proc.index')->with(compact('procs'));
    }

    public function children(Request $request)
    {
        $entry_id=$request->input('entry_id',0);

        $procs=Proc::select(DB::raw("GROUP_CONCAT(id) id,entry_id,process_id,process_name,GROUP_CONCAT(emp_name) emp_name,auditor_name,status,content,created_at"))->with('entry')->where(['entry_id'=>$entry_id])->groupBy('process_id','concurrence','circle')->orderBy('id','ASC')->get();

        return view('proc.index')->with(compact('procs'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proc=Proc::findOrFail($id);

        $entry=Entry::findOrFail($proc->entry_id);

        if($entry->pid>0){
            $form_html=$entry->parent_entry->flow->template?generateHtml($entry->parent_entry->flow->template,$entry->parent_entry->entry_data):'';
        }else{
            $form_html=$entry->flow->template?generateHtml($entry->flow->template,$entry->entry_data):'';
        }

        return view('proc.show')->with(compact('proc','entry','form_html'));
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
        //
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

    public function pass(Request $request,$id){
        DB::beginTransaction();
        try{
            Workflow::pass($id);
            
            DB::commit();
        }catch(\Exception $e){
            dd($e);
            DB::rollback();
            return response()->json(['status_code'=>0,'message'=>$e->getMessage()]);
        }
        
        return response()->json(['status_code'=>0]);
    }

    public function unpass(Request $request,$id){
        DB::beginTransaction();
        try{
            Workflow::unpass($id);

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with(['success'=>-1,'message'=>$e->getMessage()]);
        }
        
        return response()->json(['status_code'=>0]);
    }
}

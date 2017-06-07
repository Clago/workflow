<?php
namespace Workflow\Traits;

use App\Proc;
use Auth,Request;

trait WorkflowTrait{
	public function pass($process_id){
		(new static)->flowlink($process_id);
	}

	public function unpass($proc_id){
		$proc=Proc::where(['emp_id'=>Auth::id()])->where(["status"=>0])->findOrFail($proc_id);

        //驳回
        Proc::where(['entry_id'=>$proc->entry_id,'process_id'=>$proc->process_id,'circle'=>$proc->entry->circle,'status'=>0])->update([
            'status'=>-1,
            'auditor_id'=>Auth::id(),
            'auditor_name'=>Auth::user()->name,
            'auditor_dept'=>Auth::user()->dept->dept_name,
            'content'=>Request::input('content',''),
        ]);

        $proc->entry()->update([
            'status'=>-1
        ]);

        //判断是否存在父进程
        if($proc->entry->pid>0){
            $proc->entry->parent_entry->update([
                'status'=>-1,
                'child'=>$proc->process_id
            ]);
        }

        $proc->entry->emp->notify(new \App\Notifications\Flowfy(Proc::find($proc->id)));
	}
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Entry,App\Proc,App\Flowlink,App\ProcessVar,App\Flow,App\EntryData,App\Emp;

use Auth,DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //我的申请
        $entries=Entry::with(["emp","procs"=>function($query){
            $query->orderBy("id",'DESC')->take(1);
        },"process"])->where(['emp_id'=>Auth::id(),'pid'=>0])->orderBy('id','DESC')->get();

        // dd($entries);
        
        //我的待办
        $procs=Proc::with(["emp","entry"=>function($query){
            $query->with("emp");
        }])->where(['emp_id'=>Auth::id(),'status'=>0])->orderBy("is_read","ASC")->orderBy("status","ASC")->orderBy("id","DESC")->get();

        //工作流 分组TODO
        $flows=Flow::where(['is_publish'=>1,'is_show'=>1])->orderBy('id','ASC')->get();
        $handle_procs=Proc::with(["emp","entry"=>function($query){
            $query->with("emp");
        }])->where(['emp_id'=>Auth::id()])->where('status','!=',0)->orderBy('entry_id','DESC')->orderBy("id","ASC")->get()->groupBy('entry_id');

        // dd($handle_procs);

        return view('home')->with(compact("entries","procs","flows","handle_procs"));
    }
}

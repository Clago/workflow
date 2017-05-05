<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proc extends Model
{
    protected $table="proc";

    protected $fillable=['entry_id','flow_id','process_id','process_name','emp_id','status','content','is_read','emp_name','dept_name','auditor_id','auditor_name','auditor_dept','circle','beizhu','concurrence'];

    public function emp(){
    	return $this->belongsTo("App\Emp","emp_id");
    }

    public function entry(){
    	return $this->belongsTo("App\Entry","entry_id");
    }

    public function process(){
    	return $this->belongsTo("App\Process","process_id");
    }

    public function flow(){
    	return $this->belongsTo("App\Flow","flow_id");
    }

    public function procs(){
    	return $this->hasMany('App\Proc','entry_id');
    }
}

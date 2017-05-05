<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $table="entry";

    protected $fillable=['title','flow_id','emp_id','status','process_id','circle','enter_process_id','child','pid','enter_proc_id'];

    public function flow(){
        return $this->belongsTo("App\Flow","flow_id");
    }

    public function emp(){
    	return $this->belongsTo("App\Emp","emp_id");
    }

    public function procs(){
    	return $this->hasMany("App\Proc","entry_id");
    }

    public function process(){
    	return $this->belongsTo("App\Process","process_id");
    }

    public function entry_data(){
        return $this->hasMany("App\EntryData","entry_id");
    }

    public function parent_entry(){
        return $this->belongsTo('App\Entry','pid');
    }

    public function children(){
        return $this->hasMany('App\Entry','pid');
    }

    public function enter_process(){
        return $this->belongsTo('App\Process','enter_process_id');
    }

    public function child_process(){
        return $this->belongsTo('App\Process','child');
    }
}

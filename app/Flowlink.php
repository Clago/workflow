<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flowlink extends Model
{
    protected $table="flowlink";

    protected $fillable=['flow_id','type','process_id','next_process_id','status','auditor','expression','sort'];

    public function process(){
    	return $this->belongsTo('App\Process','process_id');
    }

    public function next_process(){
    	return $this->belongsTo('App\Process','next_process_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    protected $table="flow";

    protected $fillable=['flow_no','flow_name','template_id','flowchart','jsplumb','is_publish','is_show','type_id'];

    public function process(){
    	return $this->hasMany('App\Process','flow_id');
    }

    public function process_var(){
        return $this->hasMany('App\ProcessVar','flow_id');
    }

    public function template(){
    	return $this->belongsTo('App\Template','template_id');
    }

    public function flow_type(){
    	return $this->belongsTo('App\FlowType','type_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowType extends Model
{
    protected $table="flow_type";

    public function flow(){
    	return $this->hasMany('App\Flow','type_id');
    }
}

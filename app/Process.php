<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table="process";

    protected $fillable=['flow_id','process_name','limit_time','type','icon','description','style','style_color','style_height','style_width','position_left','position_top','position','child_flow_id','child_after','child_back_process'];

    public function flow(){
    	return $this->belongsTo('App\Flow','flow_id');
    }
}

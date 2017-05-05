<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessVar extends Model
{
    protected $table="process_var";

    public $timestamps=false;

    protected $fillable=['process_id','flow_id','expression_field','description'];
}

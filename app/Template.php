<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table="template";

    protected $fillable=['template_name'];

    public function template_form(){
    	return $this->hasMany('App\TemplateForm','template_id');
    }
}

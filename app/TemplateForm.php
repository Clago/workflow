<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateForm extends Model
{
    protected $table="template_form";

    protected $fillable=['template_id','field','field_name','field_type','field_value','field_default_value','sort'];

    public function template(){
    	return $this->belongsTo('App\Template','template_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryData extends Model
{
    protected $table="entry_data";

    protected $fillable=['entry_id','flow_id','field_name','field_value'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    protected $table="dept";

    protected $fillable=['dept_name','manager_id','pid','director_id','mannager','rank'];

    // 递归处理部门
    public static function recursion($depts,$html='├──',$pid=0,$level=0){
    	

    	$data=[];
    	foreach($depts as $k=>$v){
    		if($v['pid']==$pid){
    			$v['html']=str_repeat($html, $level);
                $v['level']=$level+1;
    			$data[]=$v;
    			unset($depts[$k]);
    			$data=array_merge($data,self::recursion($depts,$html,$v['id'],$level+1));
    		}
    	}

    	return $data;
    }

    public function director(){
    	return $this->belongsTo('App\Emp','director_id');
    }

    public function manager(){
    	return $this->belongsTo('App\Emp','manager_id');
    }
}

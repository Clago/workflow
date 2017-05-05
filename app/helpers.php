<?php
/**
 * [generateHtml description]
 * @return [string] [description]
 */
function generateHtml($template,$entry_data=null){
	$template_forms=$template->template_form()->orderBy('sort','asc')->orderBy('id','DESC')->get();
	return view('template.tpl',['template_forms'=>$template_forms,'entry_data'=>$entry_data])->render();
}

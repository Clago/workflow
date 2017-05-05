<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware'=>['auth']],function(){
	Route::get('/', 'HomeController@index');

	Route::post('/pass/{id}','ProcController@pass');
	Route::post('/unpass/{id}','ProcController@unpass');

	Route::get('/entry/resend','EntryController@resend');
	Route::get('/entry/cancel','EntryController@cancel');
	Route::resource('entry','EntryController');

	Route::resource('emp','EmpController');

	Route::post('/flow/publish','FlowController@publish');
	Route::get('/flow/flowchart/{id}','FlowController@flowdesign');
	Route::resource('flow','FlowController');

	Route::get('/template/generate/{id}','TemplateController@generate');
	Route::resource('template','TemplateController');
	Route::resource('template_form','TemplateFormController');

	Route::resource('dept','DeptController');

	Route::post('process/con','ProcessController@condition');
	Route::get('process/attribute','ProcessController@attribute');

	Route::post('process/begin','ProcessController@setFirst');
	Route::post('process/stop','ProcessController@setLast');

	Route::resource('process','ProcessController');

	Route::get('/flowlink/auth/dept/{id}','FlowlinkController@dept');
	Route::get('/flowlink/auth/role/{id}','FlowlinkController@role');
	Route::get('/flowlink/auth/emp/{id}','FlowlinkController@emp');
	Route::post('flowlink','FlowlinkController@update');

	Route::get('proc/children','ProcController@children');
	Route::resource('proc','ProcController');
});

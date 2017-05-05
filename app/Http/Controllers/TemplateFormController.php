<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Template,App\TemplateForm;
use Form;

class TemplateFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $template_id=$request->get('template_id',0);
        $template=Template::findOrFail($template_id);
        $template_forms=TemplateForm::with('template')->where('template_id',$template_id)->orderBy('sort','ASC')->orderBy('id','DESC')->get();

        return view('template_form.index')->with(compact('template_forms','template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Template::findOrFail($request->input('template_id'));
        return view('template_form.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();

        $this->validate($request,[
            'field_name'=>'required',
            'field'=>'required',
            'field_type'=>'required',
        ]);

        TemplateForm::create($data);

        return redirect()->route('template_form.index',['template_id'=>$data['template_id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template_form=TemplateForm::findOrFail($id);
        return view('template_form.edit')->with(compact('template_form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->all();

        $this->validate($request,[
            'field_name'=>'required',
            'field'=>'required',
            'field_type'=>'required',
        ]);

        $template_form=TemplateForm::findOrFail($id);

        $template_form->update($data);

        return redirect()->route('template_form.index',['template_id'=>$template_form->template_id])->with(['success'=>1,'message'=>'更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template_form=TemplateForm::findOrFail($id);

        $template_form->delete();

        return response()->json([
            'error'=>0,
            'msg'=>'模板控件删除成功'
        ]);
    }
}

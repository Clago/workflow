<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Template,App\Flow;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates=Template::orderBy('id','DESC')->get();
        return view('template.index')->with(compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'template_name'=>'required',
        ],[
            'template_name.required'=>'模板名称不能为空'
        ]);

        Template::create($request->all());

        return redirect()->route('template.index')->with(['success'=>1,'message'=>'添加成功']);
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
        $template=Template::findOrFail($id);
        return view('template.edit')->with(compact('template'));
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
        $this->validate($request,[
            'template_name'=>'required',
        ],[
            'template_name.required'=>'模板名称不能为空'
        ]);

        $template=Template::findOrFail($id)->update($request->all());

        return redirect()->route('template.index')->with(['success'=>1,'message'=>'更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template=Template::findOrFail($id);

        if(Flow::where('template_id',$template->id)->first()){
            return response()->json([
                'error'=>1,
                'msg'=>'该模板正在被使用，不能删除'
            ]);
        }

        $template->delete();
        $template->template_form()->delete();

        return response()->json([
            'error'=>0,
            'msg'=>'模板删除成功'
        ]);
    }

    //废弃 动态生成html
    public function generate(Request $request,$id){
        $template=Template::findOrFail($id);
        $fields=$template->template_form;

        $html='';

        foreach($fields as $v){
            switch ($v->field_type) {
                case 'text':
                    $html.='<div class="form-group">
                                <label>'.$v->field_name.'</label>
                                <input type="text" class="form-control" placeholder="'.$v->field_name.'" name="tpl['.$v->field.']">
                            </div>';
                    break;
                case 'textarea':
                    $html.='<div class="form-group">
                                <label>'.$v->field_name.'</label>
                                <textarea rows="3" class="form-control" placeholder="'.$v->field_name.'" name="tpl['.$v->field.']"></textarea>
                            </div>';
                    break;
                case 'radio':
                    # code...
                    break;
                case 'checkbox':
                    # code...
                    break;
                case 'file':
                    # code...
                    break;
            }
        }

        file_put_contents(resource_path().'/views/template/tpl'.$template->id.'.blade.php', $html);

        return redirect()->route('template.index');
    }
}

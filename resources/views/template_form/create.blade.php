@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>添加表单控件</h3>
        <form action="{{route('template_form.store')}}" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label>控件名称</label>
            <input type="text" class="form-control"  name="field_name" placeholder="控件名称">
          </div>

          <div class="form-group">
            <label>字段名</label>
            <input type="text" class="form-control"  name="field" placeholder="字段名">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">字段类型</label>
            <select class="form-control" name="field_type">
              <option value="text">文本框</option>
              <option value="select">下拉框</option>
              <option value="radio">单选</option>
              <option value="checkbox">多选</option>
              <option value="textarea">多行文本框</option>
              <option value="date">日期</option>
              <option value="file">文件</option>
            </select>
          </div>

          <div class="form-group">
            <label>字段值</label>
            <textarea class="form-control"  name="field_value" placeholder="字段值"  rows="3">
            </textarea>
          </div>

          <div class="form-group">
            <label>默认值</label>
            <input type="text" class="form-control"  name="field_default_value" placeholder="默认值">
          </div>

          <div class="form-group">
            <label>排序</label>
            <input type="text" class="form-control"  name="sort" placeholder="排序" value="50">
          </div>

          {{csrf_field()}}
          <input type="hidden" name="template_id" value="{{Request::get('template_id')}}">
          <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
@endsection

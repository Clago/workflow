@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>{{$entry->title}}</h3>
        <form action="/entry/{{$entry->id}}" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">标题</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="标题" value="{{$entry->title}}">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">工作流</label>
            <select class="form-control">
              <option>{{$entry->flow->flow_name}}</option>
            </select>
          </div>
          
          {!! $form_html !!}

          {{csrf_field()}}
          {{method_field('PUT')}}
          
          <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
@endsection

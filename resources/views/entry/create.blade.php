@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>{{$flow->flow_name}}</h3>
        <form action="/entry" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">标题</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="标题">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">工作流</label>
            <select class="form-control" name="flow_id">
              <option value="{{$flow->id}}">{{$flow->flow_name}}</option>
            </select>
          </div>
          
          {!! $form_html !!}

          {{csrf_field()}}
          
          <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
@endsection

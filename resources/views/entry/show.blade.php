@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>{{$entry->title}}</h3>
        <form>
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
          
          <button type="button" class="btn btn-default" id="dialog_close">关闭</button>
        </form>
    </div>
</div>

<script type="text/javascript">
  $(function(){
    $("#dialog_close").on("click",function(){
            window.close();
        });
  });
</script>
@endsection

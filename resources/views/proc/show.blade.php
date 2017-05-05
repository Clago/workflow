@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>{{$entry->emp->name}}：{{$entry->title}} </h3>
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

          <div class="form-group">
            <label>批复意见</label>
            <textarea rows="3" class="form-control" placeholder="批复意见" name="content"></textarea>
          </div>

          {{csrf_field()}}
            
          <input type="hidden" name="proc_id" value="{{$proc->id}}">

          <button type="button" class="btn btn-default" id="next">通过进入下一步</button>

          <button type="button" class="btn btn-default" id="back">驳回</button>
        </form>
    </div>
</div>

<script type="text/javascript">
  $(function(){
    var proc_id=$('input[name=proc_id]').val();
    $('#next').on('click',function(){
      $.ajax({
        type:'POST',
        dataType:'JSON',
        url:'/pass/'+proc_id,
        data:{
          content:$('textarea[name=content]').val(),
        },
        success:function(res){
          if(res.status_code==0){
            window.opener.refresh();
            window.close();
          }
        }
      })
    });

    $('#back').on('click',function(){
      $.ajax({
        type:'POST',
        dataType:'JSON',
        url:'/unpass/'+proc_id,
        data:{
          content:$('textarea[name=content]').val(),
        },
        success:function(res){
          if(res.status_code==0){
            window.opener.refresh();
            window.close();
          }
        }
      })
    });
  });
</script>
@endsection

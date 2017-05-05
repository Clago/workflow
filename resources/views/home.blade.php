@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">管理面板</div>
            <div class="panel-body">
              <a class="label label-danger" href="{{route('emp.index')}}">员工管理</a>
              <a class="label label-danger" href="{{route('dept.index')}}">部门管理</a>
              <a class="label label-danger" href="{{route('flow.index')}}">流程管理</a>
              <a class="label label-danger" href="{{route('template.index')}}">模板管理</a>
            </div>
        </div>
      </div>
      <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">工作流</div>
            <div class="panel-body">
              @foreach($flows as $v)
              <a class="label label-danger" href="{{route('entry.create',['flow_id'=>$v->id])}}">{{$v->flow_name}}</a>
              @endforeach
            </div>
          </div>
      </div>

    </div>
    

    
    <div class="row">
       <div class="panel panel-info">
          <div class="panel-heading">我的申请</div>
<!--           <div class="panel-body">
            
           </div> -->
           <table class="table table-bordered">
            <thead>
                <tr>
                  <th>标题</th>
                  <th>发起人</th>
                  <th>当前位置</th>
                  <th>当前状态</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                @if($entries->count()>0)
                @foreach($entries as $v)
                <tr>
                  <th scope="row">{{$v->title}}</th>
                  <td>{{$v->emp->name}}</td>
                  <td>
                    @if($v->child>0)
                    <span class="text text-danger">子流程({{$v->child_process->flow->flow_name}}):</span>{{$v->child_process->process_name}}
                    @else
                    {{$v->process->process_name}}
                    @endif
                  </td>
                  <td>
                      @if($v->status==0)
                        <button class="btn btn-xs btn-info">进行中</button>
                      @elseif($v->status==9)
                        <button class="btn btn-xs btn-success">通过</button>
                      @elseif($v->status==-1)
                        <button class="btn btn-xs btn-danger">驳回</button>
                      @elseif($v->status==-2)
                        <button class="btn btn-xs btn-danger">已撤销</button>
                      @elseif($v->status==-9)
                        <button class="btn btn-xs btn-danger">草稿</button>
                      @endif
                  </td>
                  <td>
                      @if($v->status==-1)
                      <a href="{{route('entry.edit',['id'=>$v->id])}}" class="btn btn-xs btn-danger">编辑</a>
                      <a href="/entry/resend?entry_id={{$v->id}}" class="btn btn-xs btn-warning">重新发起</a>
                      <a href="/entry/cancel?entry_id={{$v->id}}" class="btn btn-xs btn-info">撤销</a>
                      @endif
                      <button onclick="superDialog('/entry/{{$v->id}}','','');" class="btn btn-xs btn-info entry-detail">详情</button>
                      <button onclick="superDialog('/proc?entry_id={{$v->id}}')" class="btn btn-xs btn-primary">进程明细</button>
                  </td>
                </tr>
                @endforeach
                @else
                <td colspan="5">暂无申请</td>
                @endif
              </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-warning">
            <div class="panel-heading">待办事项</div>
            <table class="table table-bordered">
            <thead>
                <tr>
                  <th>标题</th>
                  <th>发起人</th>
                  <th>流程位置</th>
                  <th>流程</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                @if($procs->count()>0)
                @foreach($procs as $v)
                <tr>
                  <td scope="row">{{$v->entry->title}}</td>
                  <td>{{$v->entry->emp->name}}</td>
                  <td>{{$v->process_name}}</td>
                  <td>{{$v->flow->flow_name}}</td>
                  <td>
                      @if($v->status==0)
                        <!-- 进行中. <a href="/pass/{{$v->id}}">通过</a> <a href="/unpass/{{$v->id}}">不通过</a> -->
                         <button onclick="superDialog('/proc/{{$v->id}}','','');" class="btn btn-xs btn-warning entry-detail">批复</button>
                      @elseif($v->status==9)
                        已处理(通过)
                      @elseif($v->status==-1)
                        已处理(驳回)
                      @endif
                      <button onclick="superDialog('/proc?entry_id={{$v->entry->id}}')" class="btn btn-xs btn-primary">进程明细</button>
                  </td>
                </tr>
                @endforeach
                @else
                <td colspan="5">暂无待办事项</td>
                @endif
              </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-success">
          <div class="panel-heading">已处理事项</div>
          @foreach($handle_procs as $v)
          <div class="alert alert-info" role="alert">
            <h3><i></i>{{$v->first()->entry->emp->name}}:{{$v->first()->entry->title}} (<small><a href="javascript:;" onclick="superDialog('/proc?entry_id={{$v->first()->entry_id}}')">{{$v->count()}}</a></small>)</h3>
            <ul>
              @foreach($v as $v2)
              <li>
                <p>
                  <strong>@if($v2->status==9)<span class="text text-success">通过</span>@elseif($v2->status==-1)<span class="text text-danger">驳回</span>@endif
                  </strong> <small>{{$v2->auditor_name}}</small> - {{$v2->process_name}}  <span>{{$v2->created_at}}</span>
                </p>
              </li>
              @endforeach
            </ul>
          </div>
          @endforeach

        </div>
    </div>
</div>

<script type="text/javascript">
    /*页面回调执行    callbackSuperDialog
    if(window.ActiveXObject){ //IE  
        window.returnValue = globalValue
    }else{ //非IE  
        if(window.opener) {  
            window.opener.callbackSuperDialog(globalValue) ;  
        }
    }  
    window.close();
*/
function callbackSuperDialog(selectValue){
     var aResult = selectValue.split('@leipi@');
     $('#'+window._viewField).val(aResult[0]);
     $('#'+window._hidField).val(aResult[1]);
    //document.getElementById(window._hidField).value = aResult[1];
    
}

function refresh(){
  location.reload();
}
/**
 * 弹出窗选择用户部门角色
 * showModalDialog 方式选择用户
 * URL 选择器地址
 * viewField 用来显示数据的ID
 * hidField 隐藏域数据ID
 * isOnly 是否只能选一条数据
 * dialogWidth * dialogHeight 弹出的窗口大小
 */
function superDialog(URL,viewField,hidField,isOnly,dialogWidth,dialogHeight)
{
    dialogWidth || (dialogWidth = 1200)
    ,dialogHeight || (dialogHeight = 600)
    ,loc_x = (window.innerWidth-dialogWidth)/2
    ,loc_y = (window.innerHeight-dialogHeight)
    ,window._viewField = viewField
    ,window._hidField= hidField;
    // loc_x = document.body.scrollLeft+event.clientX-event.offsetX;
    //loc_y = document.body.scrollTop+event.clientY-event.offsetY;
    if(window.ActiveXObject){ //IE  
        var selectValue = window.showModalDialog(URL,self,"edge:raised;scroll:1;status:0;help:0;resizable:1;dialogWidth:"+dialogWidth+"px;dialogHeight:"+dialogHeight+"px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
        if(selectValue){
            callbackSuperDialog(selectValue);
        }
    }else{  //非IE 
        var selectValue = window.open(URL, 'newwindow','height='+dialogHeight+',width='+dialogWidth+',top='+loc_y+',left='+loc_x+',toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');  
    
    }
}
</script>
@endsection

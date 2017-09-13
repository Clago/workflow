@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
       <div class="panel panel-info">
          <div class="panel-heading">进程明细</div>
<!--           <div class="panel-body">
            
           </div> -->
           <table class="table table-bordered">
            <thead>
                <tr>
                  <th>标题</th>
                  <th>发起人</th>
                  <th>当前位置</th>
                  <th>审核人</th>
                  <th>操作人</th> 
                  <th>批复内容</th>
                  <th>操作时间</th>
                  <th>当前状态</th>
                </tr>
              </thead>
              <tbody>
                @foreach($procs as $v)
                <tr>
                  <td scope="row">{{$v->entry->title}}</td>
                  <td>{{$v->entry->emp->name}}</td>
                  <td>
                    <span class="text text-danger">{{$v->process_name}}</span>
                  </td>
                  <td>{{$v->emp_name}}</td>
                  <td>{{$v->auditor_name?:'等待审核'}}</td>
                  <td>{{$v->content?:'-'}}</td>
                  <td>
                    @if($v->status==0)
                     -
                    @else
                    {{$v->updated_at}}
                    @endif
                  </td>
                  <td>
                      @if($v->status==0)
                        <button class="btn btn-xs btn-info">进行中</button>
                      @elseif($v->status==9)
                        <button class="btn btn-xs btn-success">通过</button>
                      @elseif($v->status==-1)
                        <button class="btn btn-xs btn-danger">驳回</button>
                      @endif
                      @if($child=\App\Entry::where('pid',$v->entry->id)->whereIn('enter_proc_id',explode(',',$v->id))->first())
                      <a href="/proc/children?entry_id={{$child->id}}" class="btn btn-xs btn-primary">子流程</a>
                      @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

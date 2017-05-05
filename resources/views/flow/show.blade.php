@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="row">
         <div class="panel panel-info">
            <div class="panel-heading">
              <span class="text text-danger">{{$flow->flow_name}}</span> 工作流程图

              <a href="{{route('flow.index')}}" class="btn btn-xs btn-primary">返回流程列表</a>
            </div> 

            <div class="panel-body">
                <div id="diagram"></div>
             </div>
          </div>
      </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="/vendor/flowchart/src/raphael-min.js"></script>
<script src="/vendor/flowchart/release/flowchart.min.js"></script>

<script>
// st=>start: Start:>http://www.google.com[blank]
// e=>end:>http://www.google.com
// op1=>operation: My Operation
// sub1=>subroutine: My Subroutine
// cond=>condition: Yes
// or No?:>http://www.google.com
// io=>inputoutput: catch something...

// st->op1->cond
// cond(yes)->io->e
// cond(no)->sub1(right)->op1
  // var diagram = flowchart.parse('st=>start: 员工提交申请\n' +
  //                               'e=>end: 综管报备\n' +
  //                               'sub1=>operation: 部门经理审核\n' +
  //                               'cond=>condition: 部门主管审核 \n' +
  //                               '[天数<3天]?'+
  //                               '\n' +
  //                               'st->cond\n' +
  //                               'cond(yes)->e\n' + // conditions can also be redirected like cond(yes, bottom) or cond(yes, right)
  //                               'cond(no)->sub1->e');// the other symbols too...
  var diagram = flowchart.parse('{!!$flow->flowchart!!}');// the other symbols too...
  diagram.drawSVG('diagram');
</script>
@endsection

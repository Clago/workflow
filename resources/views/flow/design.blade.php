<!DOCTYPE HTML>
<html>
 <head>
    
  <title>流程设计</title>
  <meta name="keyword" content="流程设计器">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/vendor/flowdesign/Public/css/bootstrap/css/bootstrap.css?2025" rel="stylesheet" type="text/css" />
    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" href="/vendor/flowdesign/Public/css/bootstrap/css/bootstrap-ie6.css?2025">
    <![endif]-->
    <!--[if lte IE 7]>
    <link rel="stylesheet" type="text/css" href="/vendor/flowdesign/Public/css/bootstrap/css/ie.css?2025">
    <![endif]-->
    <link href="/vendor/flowdesign/Public/css/site.css?2025" rel="stylesheet" type="text/css" />


    <script type="text/javascript">
        /*var _root='http://flow/index.php?s=/',_controller = 'index';*/
    </script>
    

<link rel="stylesheet" type="text/css" href="/vendor/flowdesign/Public/js/flowdesign/flowdesign.css" media="screen" />

<!--select 2-->
<link rel="stylesheet" type="text/css" href="/vendor/flowdesign/Public/js/jquery.multiselect2side/css/jquery.multiselect2side.css" media="screen" />

 </head>
<body>

<!-- fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">

    
    <div class="container">

      <div class="pull-right">
        <button class="btn btn-info" type="button" id="leipi_save">保存设计</button>
        @if($flow->is_publish<1)
        <button class="btn btn-danger" type="button" id="leipi_clear">发布流程</button>
        @endif
      </div>

      <div class="nav-collapse collapse">
        <ul class="nav">
             <li><a href="{{route('flow.index')}}">工作流</a></li>
            <li><a href="javascript:;">正在设计【{{$flow->flow_name}}流程】</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>


  

<!-- Modal -->
<div id="alertModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>消息提示</h3>
  </div>
  <div class="modal-body">
    <p>提示内容</p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">我知道了</button>
  </div>
</div>

<!-- attributeModal -->
<div id="attributeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-350px">
  <div class="modal-body" style="max-height:600px;"><!-- body --></div>
</div>

<!--contextmenu div-->
<div id="processMenu" style="display:none;">
  <ul>
    <li id="attribute"><i class="icon-cog"></i>&nbsp;<span class="_label">属性</span></li>
    <!-- <li id="setting"><i class=" icon-wrench"></i>&nbsp;<span class="_label">设置</span></li> -->
    <!-- <li id="addson"><i class="icon-plus"></i>&nbsp;<span class="_label">添加子步骤</span></li> -->
    <!-- <li id="copy"><i class="icon-check"></i>&nbsp;<span class="_label">复制</span></li> -->
    <li id="delete"><i class="icon-trash"></i>&nbsp;<span class="_label">删除</span></li>
    <!-- <li id="begin"><i class="icon-play"></i>&nbsp;<span class="_label">保存</span></li> -->
    <!-- <li id="stop"><i class="icon-stop"></i>&nbsp;<span class="_label">设最后一步</span></li> -->
  </ul>
</div>
<div id="canvasMenu" style="display:none;">
  <ul>
    <li id="add"><i class="icon-plus"></i>&nbsp;<span class="_label">添加步骤</span></li>
    <li id="save"><i class="icon-ok"></i>&nbsp;<span class="_label">保存设计</span></li>
    <li id="refresh"><i class="icon-refresh"></i>&nbsp;<span class="_label">刷新 F5</span></li>
    <!-- <li id="paste"><i class="icon-share"></i>&nbsp;<span class="_label">粘贴</span></li> -->
    <li id="help"><i class="icon-search"></i>&nbsp;<span class="_label">帮助</span></li>
  </ul>
</div>
<!--end div--> 

<div class="container mini-layout" id="flowdesign_canvas">
<!--div class="process-process btn" style="left: 189px; top: 340px;"><span class="process-num badge badge-inverse"><i class="icon-star icon-white"></i>3</span> 步骤3</div-->
</div> <!-- /container -->
 
   

<script type="text/javascript" src="/vendor/flowdesign/Public/js/jquery-1.7.2.min.js?2025"></script>
<script type="text/javascript" src="/vendor/flowdesign/Public/css/bootstrap/js/bootstrap.min.js?2025"></script>

<script type="text/javascript" src="/vendor/flowdesign/Public/js/jquery-ui/jquery-ui-1.9.2-min.js?2025" ></script>
<script type="text/javascript" src="/vendor/flowdesign/Public/js/jsPlumb/jquery.jsPlumb-1.3.16-all-min.js?2025"></script>
<script type="text/javascript" src="/vendor/flowdesign/Public/js/jquery.contextmenu.r2.js?2025"></script>
<!--select 2-->
<script type="text/javascript" src="/vendor/flowdesign/Public/js/jquery.multiselect2side/js/jquery.multiselect2side.js?2025" ></script>

<script type="text/javascript" src="/vendor/flowdesign/Public/js/flowdesign/leipi.flowdesign.v2.js?2025"></script>
<script type="text/javascript" src="/vendor/layer/src/layer.js"></script>
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
    dialogWidth || (dialogWidth = 800)
    ,dialogHeight || (dialogHeight = 600)
    ,loc_x = 500
    ,loc_y = 40
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
$(function(){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  var alertModal = $('#alertModal'),attributeModal =  $("#attributeModal");
  //消息提示
  mAlert = function(messages,s)
  { 
      if(!messages) messages = "";
      if(!s) s = 2000;
      alertModal.find(".modal-body").html(messages);
      alertModal.modal('toggle');
      setTimeout(function(){alertModal.modal("hide")},s);
  }
  //属性设置
  attributeModal.on("hidden", function() {
      $(this).removeData("modal");//移除数据，防止缓存
  });
  ajaxModal = function(url,fn)
  {
      url += url.indexOf('?') ? '&' : '?';
      url += '_t='+ new Date().getTime();
      attributeModal.modal({
        remote:url
      })
      //加载完成执行
      if(fn)
      {
        attributeModal.on('shown',fn);
      }

      
  }

function page_reload()
{
    location.reload();
}

 

  /*
  php 命名习惯 单词用下划线_隔开
  js 命名习惯：首字母小写 + 其它首字线大写
  */
    /*步骤数据*/
    var the_flow_id = {{$flow->id}}
    var processData = {!!$flow->jsplumb?:'{}'!!};
    /*创建流程设计器*/
    var _canvas = $("#flowdesign_canvas").Flowdesign({
                      "processData":processData
                      /*画面右键*/
                      ,canvasMenus:{
                        "add": function(t) {
                            var mLeft = $("#jqContextMenu").css("left"),mTop = $("#jqContextMenu").css("top");
                            // var url = "/Flowdesign/add_process.html";
                            var url="{{route('process.store')}}";
                            $.post(url,{"flow_id":the_flow_id,"left":mLeft,"top":mTop},function(data){
                                console.log(data)
                                if(data.status_code==0){
                                  if(!_canvas.addProcess(data.data)){
                                    mAlert("添加失败");
                                  }
                                }else {
                                  mAlert(data.message);
                                }
                               
                            },'json');

                        },
                        "save": function(t) {
                            var processInfo = _canvas.getProcessInfo();//连接信息
                            var url = "/Flowdesign/save_canvas.html";
                            $.post(url,{"flow_id":the_flow_id,"process_info":processInfo},function(data){
                                mAlert(data.msg);
                            },'json');
                        },
                         //刷新
                        "refresh":function(t){_canvas.refresh();},
                        "paste": function(t) {
                            var pasteId = _canvas.paste();//右键当前的ID
                            if(pasteId<=0)
                            {
                              alert("你未复制任何步骤");
                              return ;
                            }
                            alert("粘贴:" + pasteId);
                        },
                        "help": function(t) {
                           
                            alert("查看帮助");
                        }
                       
                      }
                      /*步骤右键*/
                      ,processMenus: {
                          "setting": function(t) {
                              var activeId = _canvas.getActiveId();//右键当前的ID
                              alert("设置:"+activeId);
                          },
                          "begin":function(t)
                          {
                              // var activeId = _canvas.getActiveId();//右键当前的ID
                              // // alert("设为第一步:"+activeId);
                              // $.post('/process/begin',{"flow_id":the_flow_id,"process_id":activeId},function(data){
                              //     layer.msg('设置成功');
                              // },'json');
                              var processInfo = _canvas.getProcessInfo();//连接信息
                              var url = "/flowlink";
                              $.post(url,{"flow_id":the_flow_id,"process_info":processInfo},function(data){
                                  // location.reload();
                                  layer.msg('保存成功');
                              },'json');
                          },
                          // "stop":function(t)
                          // {
                          //     var activeId = _canvas.getActiveId();//右键当前的ID
                          //     // alert("设为最后一步:"+activeId);
                          //     $.post('/process/stop',{"flow_id":the_flow_id,"process_id":activeId},function(data){
                          //         if(data.status_code==0){
                          //           layer.msg('设置成功');
                          //         }else{
                          //           layer.msg(data.message);
                          //         }
                          //     },'json');
                          // },
                          "addson":function(t)
                          {
                              var activeId = _canvas.getActiveId();//右键当前的ID
                              alert("添加子步骤:"+activeId);
                          },
                          "copy":function(t)
                          {
                              //var activeId = _canvas.getActiveId();//右键当前的ID
                              _canvas.copy();//右键当前的ID
                              alert("复制成功");
                          },
                          "delete":function(t)
                          {
                            if(confirm("你确定删除步骤吗？")){
                                var activeId = _canvas.getActiveId();//右键当前的ID
                                // alert("删除:"+activeId);
                                $.ajax({
                                  type:'DELETE',
                                  dataType:'json',
                                  url:'/process/'+activeId,
                                  data:{
                                    flow_id:the_flow_id
                                  },
                                  success:function(res){
                                      _canvas.delProcess(activeId);
                                      // var processInfo = _canvas.getProcessInfo();//连接信息
                                      // var url = "/flowlink";
                                      // $.post(url,{"flow_id":the_flow_id,"process_info":processInfo},function(data){
                                      //     // location.reload();
                                      //     layer.msg('删除成功');
                                      // },'json');
                                      layer.msg('删除成功,页面即将刷新',function(){
                                          location.reload();
                                      });
                                  }
                                });
                            }
                          },
                          "attribute":function(t)
                          {
                              var activeId = _canvas.getActiveId();//右键当前的ID
                              //alert("属性:"+activeId);
                              
                              ajaxModal('/process/attribute?id='+activeId,function(){
                                //alert('加载完成执行')
                              });

                              
                          }
                      }
                      ,fnRepeat:function(){
                        //alert("步骤连接重复1");//可使用 jquery ui 或其它方式提示
                        mAlert("步骤连接重复了，请重新连接");
                        
                      }
                      ,fnClick:function(){
                          // alert("单击了节点");
                          var activeId = _canvas.getActiveId();//右键当前的ID
                          //alert("属性:"+activeId);
                          
                          ajaxModal('/process/attribute?id='+activeId,function(){
                            //alert('加载完成执行')
                          });
                      }
                      ,fnDbClick:function(){
                          // alert("双击了节点");
                      }
                  });


    /*保存*/
    $("#leipi_save").bind('click',function(){
        var processInfo = _canvas.getProcessInfo();//连接信息
        var url = "/flowlink";
        $.post(url,{"flow_id":the_flow_id,"process_info":processInfo},function(data){
            // location.reload();
            layer.msg('保存成功');
        },'json');
    });
    /*清除*/
    $("#leipi_clear").bind('click',function(){
        // if(_canvas.clear())
        // {
        //   //alert("清空连接成功");
        //   mAlert("清空连接成功，你可以重新连接");
        // }else
        // {
        //   //alert("清空连接失败");
        //   mAlert("清空连接失败");
        // }
        // layer.msg('发布流程');
        $.post('/flow/publish',{"flow_id":the_flow_id},function(data){
            // console.log(data)
            if(data.status_code==0){
              layer.msg('发布成功',function(){
                location.reload();
              });
            }else {
              layer.msg(data.message);
            }
           
        },'json');
    });


  
});

 
</script>

</body>
</html>
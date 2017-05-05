
<!DOCTYPE HTML>
<html>
 <head>
    
    <title> Flowdesign.leipi.org</title>
    <meta name="keywords" content="流程设计器,Web Flowdesign,Flowdesigner,专业流程设计器,WEB流程设计器">
    <meta name="description" content="国内最容易使用和开发的流程设计器，你可以在此基础上任意修改使功能无限强大！">
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="leipi.org">

    
<link href="/vendor/flowdesign/Public/css/bootstrap/css/bootstrap.css?2025" rel="stylesheet" type="text/css" />
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="/Public/css/bootstrap/css/bootstrap-ie6.css?2025">
<![endif]-->
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="/Public/css/bootstrap/css/ie.css?2025">
<![endif]-->
<!--select 2-->
<link rel="stylesheet" type="text/css" href="/vendor/flowdesign/Public/js/jquery.multiselect2side/css/jquery.multiselect2side.css" media="screen" />
<link href="/vendor/flowdesign/Public/css/site.css?2025" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/vendor/flowdesign/Public/js/jquery-1.7.2.min.js?2025"></script>
<script type="text/javascript" src="/vendor/flowdesign/Public/css/bootstrap/js/bootstrap.min.js?2025"></script>
<!--select 2-->
<script type="text/javascript" src="/vendor/flowdesign/Public/js/jquery.multiselect2side/js/jquery.multiselect2side.js?2025" ></script>

<script type="text/javascript">
    var _root='http://flowdesign.leipi.org/',_controller = 'demo';
</script>

<style>
/*自定义 multiselect2side */
.ms2side__div{border: 0px solid #333;padding-top: 30px; margin-left: 25px;}
.ms2side__div select{height: auto;height:320px;}
.ms2side__header {
    margin-left: 3px;
    margin-top:-20px;
    margin-bottom: 5px;
    width: 180px;
    height: 20px;
}
.ms2side__div select {
    width: 180px;
    float: left;
}

.dialog_main{margin:5px 0 0 5px;}
</style>

 </head>
<body>


	



<div class="container dialog_main">

<form class="form-search" id="dialog_search">
    <select name="" class="input-small">
        <option value="1">用户</option>
        <option value="2">部门</option>
        <option value="3">角色</option>
    </select>
      <input type="text" >
      <button type="submit" class="btn">搜索</button>
</form>

<div class="row">
    <div class="span2">
        <p>部门筛选</p>
        <select name="" multiple="multiple" size="18" style="width: 180px;">
            <option value="">全部部门</option>
            <option value="">&nbsp;&nbsp;&nbsp;&nbsp;|-PHP部</option>
            <option value="">&nbsp;&nbsp;&nbsp;&nbsp;|-JAVA部</option>
            <option value="">&nbsp;&nbsp;&nbsp;&nbsp;|-NET部</option>
            <option value="">&nbsp;&nbsp;&nbsp;&nbsp;|-C部</option>
        </select>
    </div>
    <div class="span6">
        <select name="dialog_searchable" id="dialog_searchable" multiple="multiple" style="display:none;">
            <option value="all">【全部】</option>
            <option value="10" selected="selected">测试1</option>
            <option value="11">测试2</option>
            <option value="12">测试3</option>
        </select>
    </div>
</div>
<div class="row span7">
<div class="pull-right">
    <button class="btn btn-info" type="button" id="dialog_confirm">确定</button>
    <button class="btn" type="button" id="dialog_close">取消</button>
</div>
<div  class="pull-left offset2">
    <input type="radio" checked="checked">用户
    <input type="radio" >部门
    <input type="radio" >角色
</div>

</div>
</div><!--end container-->






    

<script type="text/javascript">
    $(function(){
          $('#dialog_searchable').multiselect2side({
            selectedPosition: 'right',
            moveOptions: false,
            labelsx: '备选',
            labeldx: '已选',
            autoSort: true
            //,autoSortAvailable: true
        });
        //搜索用户
        $("#dialog_search").on("submit",function(){
            
            //ajax data
            var data = [{"vlaue":"100","text":"搜索1"},{"vlaue":"101","text":"搜索2"}];//test
            
            var optionList = [];
            for(var i=0;i<data.length;i++){
                optionList.push('<option value="');
                optionList.push(data[i].value);
                optionList.push('">');
                optionList.push(data[i].text);
                optionList.push('</option>');
            }
            $('#searchablems2side__sx').html(optionList.join(''));
            
            //阻止表单提交
            return false;
        });
        
        
        $("#dialog_confirm").on("click",function(){
            var nameText = [];
            var idText = [];
            var globalValue = '@leipi@';
            if(!$('#dialog_searchable').val())
            {
                //alert("未选择");//这里不提示了，万一他要清空呢
            }else
            {
                $('#dialog_searchable option').each(function(){
                if($(this).attr("selected"))
                {
                    if($(this).val()=='all')//有全部，其它就不要了
                    {
                        nameText = [];
                        idText = [];
                        nameText.push($(this).text());
                        idText.push($(this).val());
                        return false;
                    }
                    nameText.push($(this).text());
                    idText.push($(this).val());
                }
                });
                globalValue = nameText.join(',') + '@leipi@' + idText.join(',');
            }
            //这里不用 json了，数据库 也是用 , 号隔开保存的
            //var jsonText = JSON.stringify(nameText) + JSON.stringify(idText);

            
            if(window.ActiveXObject){ //IE  
                window.returnValue = globalValue
            }else{ //非IE  
                if(window.opener) {  
                    window.opener.callbackSuperDialog(globalValue) ;  
                }
            }  
            window.close();
            
            
        });
        $("#dialog_close").on("click",function(){
            window.close();
        });
    });
</script>



    

</body>
</html>
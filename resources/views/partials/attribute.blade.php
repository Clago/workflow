<ul class="nav nav-tabs" id="attributeTab">
  <li class="active"><a href="#attrBasic">常规</a></li>
  <li><a href="#attrForm">表单</a></li>
  <li><a href="#attrPower">权限</a></li>
  <!-- <li><a href="#attrOperate">操作</a></li> -->
  <li id="tab_attrJudge"><a href="#attrJudge">转出条件</a></li>
  <li><a href="#attrStyle">样式</a></li>
</ul>

<form class="form-horizontal"  method="post" id="flow_attribute" name="flow_attribute" action="{{route('process.update',['id'=>$process->id])}}">
  <div class="tab-content">
    <div class="tab-pane active" id="attrBasic">

          <div class="control-group">
            <label class="control-label" for="process_name">步骤名称</label>
            <div class="controls">
              <input type="text" id="process_name" name="process_name" placeholder="步骤名称" value="{{$process->process_name}}">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label">步骤类型</label>
            <div class="controls">
              <label class="radio inline">
                <input type="radio" readonly name="process_position" value="1"  @if($process->position==1) checked="checked" @endif>正常步骤
              </label>
              @if($can_child)
              <label class="radio inline">
                <input type="radio" name="process_position" value="2" @if($process->position==2) checked="checked" @endif>转入子流程
              </label>
              @endif
              <label class="radio inline">
                <input type="radio" readonly name="process_position" value="0" @if($process->position==0) checked="checked" @endif >第一步
              </label>

            </div>
          </div>
<hr/>

        <div id="current_flow" @if($process->position==2) class="hide" @endif>
          <div class="offset1">
            <select multiple="multiple" size="6" name="process_to[]" id="process_multiple">
              @foreach($next_process as $v)
              @if($v->next_process)
              <option value="{{$v->next_process_id}}" selected="selected">{{$v->next_process->process_name}}</option>
              @endif
              @endforeach
              
              @foreach($beixuan_process as $v)
              <option value="{{$v->process_id}}">{{$v->process->process_name}}</option>
              @endforeach
            </select>
          </div>
        </div> 

        <div id="child_flow"  @if($process->position==2) class="show" @else class="hide" @endif>
           <div class="control-group">
            <label class="control-label" >子流程</label>
            <div class="controls">
              <select name="child_flow_id" >
                <option value="0">--请选择--</option>
                @foreach($flows as $v)
                <option value="{{$v->id}}" @if($process->child_flow_id==$v->id) selected="selected" @endif >{{$v->flow_name}}</option>
                @endforeach
              </select>
            </div>
          </div>

           <div class="control-group" class="hide">
            <label class="control-label" >子流程结束后动作</label>
            <div class="controls">
              <label class="radio inline">
                <input type="radio" name="child_after" value="1" @if($process->child_after==1) checked @endif>
                同时结束父流程
              </label>
              <label class="radio inline">
                <input type="radio" name="child_after" value="2" @if($process->child_after==2) checked @endif>
                返回父流程步骤
              </label>
            </div>
          </div>

          <div class="control-group @if($process->child_after==1) hide @endif" id="child_back_id">
            <label class="control-label" >返回步骤</label>
            <div class="controls">
              <select name="child_back_process" >
                <option value="0">--默认--</option>
                @foreach($processes as $v)
                <option value="{{$v->id}}" @if($process->child_back_process==$v->id) selected="selected" @endif >{{$v->process_name}}</option>
                @endforeach
              </select>
              <span class="help-inline">默认为当前步骤下一步</span>
            </div>
          </div>

        </div> 



    </div><!-- attrBasic end -->

    <div class="tab-pane" id="attrForm">



<table class="table table-condensed table-bordered table-hover" >
    <tr>
      <th style="text-align:center">字段名称</th>
      <th style="text-align:center">控件类型</th>
    </tr>
    <tbody>

<!-- 这里是表单设计器的字段 start -->
@foreach($fields as $v)
<tr>
  <td style="text-align:center">{{$v->field_name}}</td>
  <td style="text-align:center">{{$v->field_type}}</td>
</tr>
@endforeach
<!-- 这里是表单设计器的字段 end -->


    </tbody>
</table>



    </div><!-- attrForm end -->
    

    <div class="tab-pane" id="attrPower">

        <div class="control-group">
            <label class="control-label" >自动选人</label>
            <div class="controls">
              <select name="auto_person" id="auto_person_id">
                <option value="0">不自动选人</option>
                <!-- <option value="-1000">发起人</option> -->
                <option value="-1001" @if($sys=='-1001') selected="selected" @endif>发起人的部门主管</option>
                <option value="-1002" @if($sys=='-1002') selected="selected" @endif>发起人的部门经理</option>
              </select>
              <span class="help-inline">预先设置自动选人，更方便转交工作</span>
            </div>
            <!-- <div class="controls hide" id="auto_unlock_id" >
              <label class="checkbox">
                <input type="checkbox" name="auto_unlock" value="1" checked="checked">允许更改
              </label>
            </div> -->

            <div id="auto_person_4" class="hide">
              <div class="control-group">
                <label class="control-label">指定主办人</label>
                <div class="controls">
                    <input type="text" placeholder="指定主办人" name="auto_sponsor_uids"> <a href="javascript:void(0);">选择</a>
                </div> 
              </div>
              <div class="control-group">
                <label class="control-label">指定经办人</label>
                <div class="controls">
                    <input type="text" placeholder="指定经办人" name="auto_respon_uids"> <a href="javascript:void(0);">选择</a>
                </div> 
              </div>
            </div>
            <div id="auto_person_5" class="hide">
              <div class="control-group">
                <label class="control-label">指定角色</label>
                <div class="controls">
                    <input type="text" placeholder="指定角色" name="auto_role_ids"> <a href="javascript:void(0);">选择</a>
                </div> 
              </div>
            </div>



          </div>
<hr/>
<h4>授权范围</h4>
          <div class="control-group">
            <label class="control-label">授权人员</label>
            <div class="controls">
                <input type="hidden" name="range_emp_ids" id="range_emp_ids" value="{{$select_emps->implode('id',',')}}">
                <input class="input-xlarge" readonly="readonly" type="text" placeholder="选择人员" name="range_emp_text" id="range_emp_text" value="{{$select_emps->implode('name',',')}}"> <a href="javascript:void(0);" class="btn" onclick="superDialog('/flowlink/auth/emp/{{$process->id}}','range_emp_text','range_emp_ids');">选择</a>
            </div> 
          </div>

          <div class="control-group">
            <label class="control-label">授权部门</label>
            <div class="controls">
                <input type="hidden" name="range_dept_ids" id="range_dept_ids" value="{{$select_depts->implode('id',',')}}">
                <input class="input-xlarge" readonly="readonly" type="text" placeholder="选择部门" name="range_dept_text" id="range_dept_text" value="{{$select_depts->implode('dept_name',',')}}"> <a href="javascript:void(0);" class="btn" onclick="superDialog('/flowlink/auth/dept/{{$process->id}}','range_dept_text','range_dept_ids');">选择</a>
            </div> 
          </div>

          <div class="control-group hide">
            <label class="control-label">授权角色</label>
            <div class="controls">
                <input type="hidden" name="range_role_ids" id="range_role_ids" value="">
                <input class="input-xlarge" readonly="readonly" type="text" placeholder="选择角色" name="range_role_text" id="range_role_text" value=""> <a href="javascript:void(0);" class="btn" onclick="superDialog('/flowlink/auth/role/{{$process->id}}','range_role_text','range_role_ids');">选择</a>
            </div> 
          </div>


          <div class="control-group">
            <div class="controls">
                <span class="help-block">当需要手动选人时，则授权范围生效</span>
            </div> 
          </div>
          


    </div><!-- attrPower end -->


    <div class="tab-pane hide" id="attrOperate">

        <div class="control-group">
          <label class="control-label" >交接方式</label>
          <div class="controls">
            <select name="process_mode" >
              <option value="0">明确指定主办人</option>
              <option value="1">先接收为主办人</option>
            </select>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <label class="checkbox">
                <input type="checkbox" name="agent_pass" value="is_process">经办人可以转交下一步
              </label>
          </div>
        </div>
<hr/>

        <div class="control-group">
          <label class="control-label" >会签方式</label>
          <div class="controls">
            <select name="con_sign" >
              <option value="1">允许会签</option>
              <option value="2">禁止会签</option>
              <option value="3">强制会签</option>
            </select>
            <span class="help-inline">如果设置强制会签，则本步骤全部人都会签后才能转交或办结</span>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" >可见性</label>
          <div class="controls">
            <select name="con_sign_vsb" >
              <option value="1">总是可见</option>
              <option value="2">本步骤之间经办人不可见</option>
              <option value="3">其它步骤不可见</option>
            </select>
          </div>
        </div>


<hr/>

        <div class="control-group">
          <label class="control-label" >回退方式</label>
          <div class="controls">
            <select name="con_sign_vsb" >
              <option value="1">不允许</option>
              <option value="2">允许回退上一步</option>
              <option value="3">允许回退之前步骤</option>
            </select>
          </div>
        </div>


    </div><!-- attrOperate end -->



    <div class="tab-pane" id="attrJudge">

       
    <table class="table" >
      <thead>
        <tr>
          <th style="width:100px;">转出步骤</th>
          <th>转出条件设置</th>
        </tr>
      </thead>
      <tbody>


<tr id="tpl" class="hide">    
<td style="width: 100px;">@text</td>
<td>
    <table class="table table-condensed">
    <tbody>
      <tr>
        <td>
            <select id="field_@a" class="input-medium">
              <option value="">选择字段</option>
              <!-- 表单字段 start -->
                @foreach($fields as $v)
                <option value="${{$v->field}}">{{$v->field_name}}</option>
                @endforeach
              <!-- 表单字段 end -->  
            </select>
            <select id="condition_@a" class="input-small">
        <option value="==">等于</option>
        <option value="!=">不等于</option>
        <option value=">">大于</option>
        <option value="<">小于</option>
        <option value=">=">大于等于</option>
        <option value="<=">小于等于</option>
        <!-- <option value="include">包含</option>
        <option value="exclude">不包含</option> -->
            </select>
            <input type="text" id="item_value_@a" class="input-small">
            <select id="relation_@a" class="input-small">
        <option value="AND">与</option>
        <option value="OR">或者</option>
            </select>
        </td>
        <td>
            <div class="btn-group">
        <button type="button" class="btn btn-small" onclick="fnAddLeftParenthesis('@a')">（</button>
        <button type="button" class="btn btn-small" onclick="fnAddRightParenthesis('@a')">）</button>
        <button type="button" onclick="fnAddConditions('@a')" class="btn btn-small">新增</button>
            </div>
        </td>
       </tr>
       <tr>
        <td>
            <select id="conList_@a" multiple="" style="width: 100%;height: 80px;"></select>
        </td>
        <td>
            <div class="btn-group">
        <button type="button" onclick="fnDelCon('@a')" class="btn btn-small">删行</button>
        <button type="button" onclick="fnClearCon('@a')" class="btn btn-small">清空</button>
            </div>
        </td>
      </tr>
      <tr>
        <td>
            <input id="process_in_desc_@a" type="text" name="process_in_desc_@a" style="width:98%;">
            <input name="process_in_set_@a" id="process_in_set_@a" type="hidden">
        </td>
        <td>
            <span class="xc1">当前条件</span>
        </td>
      </tr>
    </tbody>
    </table>
</td>
</tr>


  </tbody>
  <tbody id="ctbody">

  </tbody>
</table>
<input type="hidden" name="process_condition" id="process_condition">






    </div><!-- attrJudge end -->
    <div class="tab-pane" id="attrStyle">

        <div class="control-group">
          <label class="control-label" for="process_name">尺寸</label>
          <div class="controls">
            <input type="text" class="input-small" name="style_width" id="style_width" placeholder="宽度PX" value="{{$process->style_width}}"> X <input type="text" class="input-small" name="style_height" id="style_height" placeholder="高度PX" value="{{$process->style_height}}">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="process_name">字体颜色</label>
          <div class="controls">
            <input type="text" class="input-small" name="style_color" id="style_color" placeholder="#000000" value="{{$process->style_color}}">
            <div class="colors" org-bind="style_color">
                <ul>
                  <li class="Black active" org-data="#000" title="Black">1</li>
                  <li class="red" org-data="#d54e21" title="Red">2</li>
                  <li class="green" org-data="#78a300" title="Green">3</li>
                  <li class="blue" org-data="#0e76a8" title="Blue">4</li>
                  <li class="aero" org-data="#9cc2cb" title="Aero">5</li>
                  <li class="grey" org-data="#73716e" title="Grey">6</li>
                  <li class="orange" org-data="#f70" title="Orange">7</li>
                  <li class="yellow" org-data="#fc0" title="Yellow">8</li>
                  <li class="pink" org-data="#ff66b5" title="Pink">9</li>
                  <li class="purple" org-data="#6a5a8c" title="Purple">10</li>
                </ul>
            </div>

          </div>
        </div>

 

        <div class="control-group">
          <label class="control-label" for="process_name"><span class="process-flag badge badge-inverse"><i class="icon-star-empty icon-white" id="style_icon_preview"></i></span> 图标</label>
          <div class="controls">
            <input type="text" class="input-medium" name="style_icon" id="style_icon" placeholder="icon" value="{{$process->icon}}">
            <div class="colors" org-bind="style_icon">
                <ul>
                  <li class="Black active" org-data="icon-star-empty" title="Black"><i class="icon-star-empty icon-white"></i></li>
                  <li class="red" org-data="icon-ok" title="Red"><i class="icon-ok icon-white"></i></li>
                  <li class="green" org-data="icon-remove" title="Green"><i class="icon-remove icon-white"></i></li>
                  <li class="blue" org-data="icon-refresh" title="Blue"><i class="icon-refresh icon-white"></i></li>
                  <li class="aero" org-data="icon-plane" title="Aero"><i class="icon-plane icon-white"></i></li>
                  <li class="grey" org-data="icon-play" title="Grey"><i class="icon-play icon-white"></i></li>
                  <li class="orange" org-data="icon-heart" title="Orange"><i class="icon-heart icon-white"></i></li>
                  <li class="yellow" org-data="icon-random" title="Yellow"><i class="icon-random icon-white"></i></li>
                  <li class="pink" org-data="icon-home" title="Pink"><i class="icon-home icon-white"></i></li>
                  <li class="purple" org-data="icon-lock" title="Purple"><i class="icon-lock icon-white"></i></li>
                </ul>
            </div>
          </div>
        </div>

<!-- 不太完善，隐藏
         <div class="control-group">
          <label class="control-label">CSS3 图形</label>
          <div class="controls">
            <select name="style_graph" id="style_graph">
              <option value="">矩形</option>
              <option value="circle">圆形</option>
              <option value="oval">椭圆</option>
              <option value="hexagon">菱形</option>
            </select>
            <span class="help-inline">CSS3仅支持部分浏览器</span>
          </div>
        </div> -->




    </div><!-- attrStyle end -->
  </div>


<div>
  <hr/>
  <span class="pull-right">
      <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
      {{csrf_field()}}
      {{method_field('PUT')}}
      <button class="btn btn-primary" type="submit" id="attributeOK">确定保存</button>
  </span>
</div>
</form>
<!-- <iframe id="hiddeniframe" style="display: none;" name="hiddeniframe"></iframe> -->


<script type="text/javascript">
  var flow_id = {{$process->flow_id}};//流程ID
  var process_id = {{$process->id}};//步骤ID
 // var get_con_url = "/index.php?s=/index/get_con";//获取条件
  var get_con_url = "/process/con";//获取条件

/*确定保存时调用的方式*/
function saveAttribute(msg)
{
    $("#attributeModal").modal("hide");
    location.reload();
}




//-----条件设置--strat----------------
    function _id(id) {
        return !id ? null : document.getElementById(id);
    }
    function trim(str) {
        return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
    }

    function fnCheckExp(text){
        //检查公式
        if( text.indexOf("(")>=0 ){
            var num1 = text.split("(").length;
            var num2 = text.split(")").length;
            if( num1!=num2 ) {
                return false;
            }
        }
        return true;
    }
    /**
     * 增加左括号表达式，会断行
     */
    function fnAddLeftParenthesis(id){
        var oObj = _id('conList_' + id);
        var current = 0;
        if(oObj.options.length>0){ //检查是否有条件
            for ( var i = 0;i < oObj.options.length;i++ ){
                if( oObj.options[i].selected ) {
                    current = oObj.selectedIndex;
                    break;
                }
            }
            if(current==0){
                current = oObj.options.length-1;
            }
        } else { //有条件才能添加左括号表达式
            alert("请先添加条件，再选择括号");
            return;
        }
        var sText = oObj.options[current].text;
        //已经有条件的话
        if( (trim(sText).substr(-3,3) == 'AND') || (trim(sText).substr(-2,2) == 'OR') ){
            alert("无法编辑已经存在关系的条件");
            return;
        }
        var sRelation = _id('relation_'+id).value;
        if( sText.indexOf('(')>=0 ){
            if( !fnCheckExp(sText) ){
                alert("条件表达式书写错误,请检查括号匹配");
                return;
            } else {
                sText = sText + " " + sRelation;
            }
        } else {
            sText = sText + " " + sRelation;
        }
        oObj.options[current].text = sText;
       // $('#conList_'+id+' option').eq(current).text(sText)
       $('#conList_'+id).append('<option value="( ">( </option>');

       /* var oMyop = document.createElement('option');
        oMyop.text = "( ";
        var nPos = oObj.options.length;
        oObj.appendChild(oMyop,nPos);*/

    }
    /**
     * 增加右括号表达式
     */
    function fnAddRightParenthesis(id){
        var oObj = _id('conList_' + id);
        var current = 0;
        if( oObj.options.length>0 ){
            for ( var i = 0;i < oObj.options.length;i++ ){
                if( oObj.options[i].selected ) {
                    current = oObj.selectedIndex;
                    break;
                }
            }
            if( current == 0 ){
                current = oObj.options.length-1;
            }
        } else {
            alert("请先添加条件，再选择括号");
            return;
        }
        var sText = oObj.options[current].text;
        if( (trim(sText).substr(-3,3)=='AND') || (trim(sText).substr(-2,2)=='OR') ){
            alert("无法编辑已经存在关系的条件");
            return;
        }
        if( (trim(sText).length==1) ){
            alert("请添加条件");
            return;
        }
        if( !fnCheckExp(sText) ){
            sText = sText + ")";
        }
        oObj.options[current].text = sText;
    }
    function fnAddConditions(id){
        var sField = $('#field_'+id).val(),sField_text = $('#field_'+id).find('option:selected').text(),sCon = $('#condition_'+id).val(),sValue = $('#item_value_'+id).val();

        var bAdd = true;
        if( sField!=='' && sCon!=='' && sValue!=='' ){
            var oObj = _id('conList_'+id);

            if( oObj.length>0 ){
                var sLength = oObj.options.length;
                var sText = oObj.options[sLength-1].text;
                if(!fnCheckExp(sText)){
                    bAdd = false;
                }
            }
            if( sValue.indexOf("'")>=0 ){
                alert("值中不能含有'号");
                return;
            }
            var sNewText = "'" + sField + "' " + sCon + " '" + sValue + "'";
            var sNewText_text = "'" + sField_text + "' " + sCon + " '" + sValue + "'";
            for( var i=0;i<oObj.options.length;i++ ){
                if( oObj.options[i].value.indexOf(sNewText)>=0 ){
                    alert("条件重复");
                    return;
                }
            }
            
            var sRelation = $('#relation_'+id).val();

            if( bAdd ){
                //var oMyop = document.createElement('option');
                var nPos = oObj.options.length;
                //oMyop.text = sNewText_text;
               // oMyop.value = sNewText;
                //oObj.appendChild(oMyop,nPos);
                $('#conList_'+id).append('<option value="'+sNewText+'">'+sNewText_text+'</option>');
                if( nPos>0 ){
                    oObj.options[nPos-1].text += "  " + sRelation;
                    oObj.options[nPos-1].value += "  " + sRelation;
                }
            } else {

                if( trim(oObj.options[sLength-1].text).length==1 ){
                    oObj.options[sLength-1].text += sNewText_text;
                    oObj.options[sLength-1].value += sNewText;
                } else {
                    oObj.options[sLength-1].text += " " + sRelation + " " + sNewText_text;
                    oObj.options[sLength-1].value += " " + sRelation + " " + sNewText;
                }
            }
        } else {
            alert("请补充完整条件");
            return;
        }
    }
    function fnDelCon(id){
        var oObj = _id('conList_'+id);
        var maxOpt = oObj.options.length;
        if(maxOpt<0) maxOpt = 0;

        for (var i = 0;i < oObj.options.length;i++ ){
            if( oObj.options[i].selected ) {
                if((i+1)==maxOpt){
                    if(typeof oObj.options[i-1] !== 'undefined'){
                        oObj.options[i-1].text = oObj.options[i-1].text.replace(/(AND|OR)$/,'');
                        oObj.options[i-1].value = oObj.options[i-1].value.replace(/(AND|OR)$/,'');
                    }
                }
                oObj.removeChild(oObj.options[i]);
                i--;
            }
        }
    }
    function fnClearCon(id){
        $('#conList_' + id).html('');
    }



    //根据基本信息的下一步骤，设置《条件设置》tab的条件列表
    function fnSetCondition(){
        if($("#process_multiple option").length<=0)
        {
            $('#tab_attrJudge').hide();
        }else
        {
            var ids = '';
            $('#ctbody').html('');
            $('#tab_attrJudge').show();
            if($("#process_multiple option:selected").length>1){
              $("#process_multiple option").each(function(){
                  if($(this).val()>0 && $(this).attr("selected")){
                      var id = $(this).val(),
                          text=$(this).text(),
                          node = $('#tpl').html();

                      var s = node.replace(/\@a/g,id);
                      if(id!=0){
                          text = '<span class="badge badge-inverse">' +id+'</span><br/>' +text;
                      }
                      s = s.replace(/\@text/g,text);
                      s = "<tr>"+s+"<tr>";
                      $('#ctbody').append(s);
                      ids += id +',';
                      //flow_id 是流程设计的ID，  process_id 是步骤ID
                      if(get_con_url)
                      {
                          //var get_con_url = "/index.php?s=/index/get_con/flow_id/62/process_id/"+id+".html";
                          $.post(get_con_url,{"flow_id":flow_id,"process_id":process_id,'next_process_id':id},function(data){
                              $.each(data,function(i,n){
                                  if(i==id && _id('conList_'+i )){
                                      $('#conList_'+i).append(n.option);
                                      $('#process_in_desc_'+i).val(n.desc);
                                  }
                              })
                          },'json');
                      }
                  }
              });
              if(ids)
              {
                  $("#process_condition").val(ids);
              }
            }
            
  
        }
    }
    

//-----条件设置--end----------------


$(function(){

  //TAB
  $('#attributeTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
      if($(this).attr("href")=='#attrJudge')
      {
          //加载下一步数据 处理 决策项目 
      }
  })

  //步骤类型
  $('input[name="process_position"]').on('click',function(){
     
      if($(this).val()=='2')
      {
          $('#current_flow').hide();
          $('#child_flow').show();
      }else
      {
          $('#current_flow').show();
          $('#child_flow').hide();
      }
  });
  //返回步骤
  $('input[name="child_after"]').on('click',function(){
     
      if($(this).val()==2)
      {
          $("#child_back_id").show();
      }else
      {
          $("#child_back_id").hide();
      }
  });
  
  //选人方式
  $("#auto_person_id").on('change',function(){
      var apid = $(this).val();
      if(apid>0)
      {
          $('#auto_unlock_id').show();
      }else
      {
          $('#auto_unlock_id').hide();
      }
      if(apid==4)//指定用户
      {
          $("#auto_person_4").show();
      }else
      {
          $("#auto_person_4").hide();
      }
      if(apid==5)//指定角色
      {
          $("#auto_person_5").show();
      }else
      {
          $("#auto_person_5").hide();
      }


  });
 
  //步骤select 2
  $('#process_multiple').multiselect2side({
      selectedPosition: 'left',
      moveOptions: false,
      labelTop: '最顶',
      labelBottom: '最底',
      labelUp: '上移',
      labelDown: '下移',
      labelSort: '排序',
      labelsx: '<i class="icon-ok"></i> 下一步步骤',
      labeldx: '<i class="icon-list"></i> 其他步骤',
      autoSort: false,
      autoSortAvailable: false,
      minSize: 7
    });


  
    /*---------表单字段 start---------*/
  //可写字段
  function write_click(e){
      var id = $(e).attr('key');
      if(!$(e).attr('disabled')){
          if($(e).attr('checked')){
              $('#secret_'+id).attr({'disabled':true,'checked':false});
          } else {
              $('#secret_'+id).removeAttr('disabled').attr('checked',false);
          }
      }
  }
  //保密字段
  function secret_click(e){
      var id = $(e).attr('key');

      if(!$(e).attr('disabled')){
          if($(e).attr('checked')){
              $('#write_'+id).attr({'disabled':true,'checked':false});
          } else {
              $('#write_'+id).removeAttr('disabled').attr('checked',false);
          }
      }
  }
  //checkbox全选及反选操作
  function icheck(ac,op){
      if(ac=='write'){
          $("input[name='write[]']").each(function(){
              if(this.disabled !== true){
                  this.checked = op;
              }
              write_click(this);
          })
      } else if(ac == 'secret') {
          $("input[name='secret[]']").each(function(){
              if(this.disabled !== true){
                  this.checked = op;
              }
              secret_click(this);
          })
      }
  }

  $('#write').click(function(){
      if($(this).attr('checked')){
          icheck('write',true);
          $('#secret').attr({'disabled':true,'checked':false});
          $('#check').attr('checked',false).removeAttr('disabled');
      } else {
          icheck('write',false);
          $('#secret').attr('checked',false).removeAttr('disabled');
          $('#check').attr({'disabled':true,'checked':false});
      }
  })
  $('#secret').click(function(){
      if($(this).attr('checked')){
          icheck('secret',true)
          $('#write').attr({'disabled':true,'checked':false});
      } else {
          icheck('secret',false);
          $('#write').attr('checked',false).removeAttr('disabled');
      }
  })

  $("input[name='write[]']").click(function(){
      write_click(this);
      $('#write').removeAttr('disabled');
      if($('#write').attr('checked')==true){
          $('#write').attr('checked',false)
      }
  })
  $("input[name='secret[]']").click(function(){
      secret_click(this);
      $('#secret').removeAttr('disabled');
      if($('#secret').attr('checked')==true){
          $('#secret').attr('checked',false)
      }
  })
  /*---------表单字段 end---------*/

  /*样式*/
  $('.colors li').click(function() {
      var self = $(this);
      if (!self.hasClass('active')) {
        self.siblings().removeClass('active');
      }
      var color = self.attr('org-data') ? self.attr('org-data') : '';

     
      var parentDiv = self.parents(".colors");
      var orgBind = parentDiv.attr("org-bind");
      if(orgBind == 'style_icon')
      {
          /*$("#"+orgBind).css({ color:'#fff',background: color });*/
          $("#"+orgBind).val(color);
          $("#style_icon_preview").attr("class",color + " icon-white");
      }else//颜色
      {
          $("#"+orgBind).css({ color:'#fff',background: color });
          $("#"+orgBind).val(color);
      }
      self.addClass('active');
  });

   //条件设置
  fnSetCondition();


  //表单提交前检测
  $("#flow_attribute").submit(function(){
      //条件检测
      var cond_data  = $("#process_condition").val();
      if( cond_data !== ''){
          var pcarr = cond_data.split(',');
          for( var i = 0;i < pcarr.length;i++ ){
              if( pcarr[i]!=='' ){
                  var obj = _id('conList_'+pcarr[i]);
                  if(obj.length>0){
                      var constr = '';
                      for( var j=0;j<obj.options.length;j++){
                          constr += obj.options[j].value+'\n';
                          if(!fnCheckExp(constr)){
                              alert("条件表达式书写错误,请检查括号匹配");
                              $('#condition').click();
                              return false;
                          }
                      }
                      _id('process_in_set_'+pcarr[i]).value = constr;
                  } else {
                      _id('process_in_set_'+pcarr[i]).value = '';
                  }
              }
          }
      }

  });


})
</script>
@if(empty($entry_data))

@foreach($template_forms as $v)
@if($v->field_type=='text')
<div class="form-group">
    <label>{{$v->field_name}}</label>
    <input type="text" class="form-control" placeholder="{{$v->field_name}}" name="tpl[{{$v->field}}]">
</div>
@elseif($v->field_type=='textarea')
<div class="form-group">
	<label>{{$v->field_name}}</label>
	<textarea rows="3" class="form-control" placeholder="{{$v->field_name}}" name="tpl[{{$v->field}}]"></textarea>
</div>
@elseif($v->field_type=='date')
<div class="form-group">
    <label>{{$v->field_name}}</label>
    <input type="date" class="form-control" placeholder="{{$v->field_name}}" name="tpl[{{$v->field}}]">
</div>
@elseif($v->field_type=='select')
<div class="form-group">
    <label>{{$v->field_name}}</label>
    <select class="form-control" name="tpl[{{$v->field}}]">
      <?php
      	$options=explode("\r\n", $v->field_value);
      ?>
      <option value="">请选择{{$v->field_name}}</option>
      @foreach($options as $op)
	  <option value="{{$op}}" @if($v->field_default_value==$op) selected="selected" @endif>{{$op}}</option>
	  @endforeach
	</select>
</div>
@elseif($v->field_type=='checkbox')
<div class="form-group">
	<?php
      	$checkbox=explode("\r\n", $v->field_value);
    ?>
    <label>{{$v->field_name}}</label>
    @foreach($checkbox as $c)
    <label class="checkbox-inline">
	  <input type="checkbox"  value="{{$c}}" name="tpl[{{$v->field}}][]"> {{$c}}
	</label>
	@endforeach
</div>
@elseif($v->field_type=='radio')
<div class="form-group">
	<?php
      	$radios=explode("\r\n", $v->field_value);
    ?>
    <label>{{$v->field_name}}</label>
    @foreach($radios as $r)
    <label class="radio-inline">
	  <input type="radio" name="tpl[{{$v->field}}]" value="{{$r}}"> {{$r}}
	</label>
	@endforeach
</div>
@elseif($v->field_type=='file')
<div class="form-group">
    <label for="exampleInputFile">{{$v->field_name}}</label>
    <input type="file" id="exampleInputFile">
    <!-- <p class="help-block">Example block-level help text here.</p> -->
 </div>
@endif
@endforeach

@else
@foreach($template_forms as $v)
<?php
	$field_value=$entry_data->where('field_name',$v->field)->first()?$entry_data->where('field_name',$v->field)->first()->field_value:'';
?>
@if($v->field_type=='text')
<div class="form-group">
    <label>{{$v->field_name}}</label>
    <input type="text" class="form-control" placeholder="{{$v->field_name}}" name="tpl[{{$v->field}}]" value="{{$field_value}}">
</div>
@elseif($v->field_type=='textarea')
<div class="form-group">
	<label>{{$v->field_name}}</label>
	<textarea rows="3" class="form-control" placeholder="{{$v->field_name}}" name="tpl[{{$v->field}}]">{{$field_value}}</textarea>
</div>
@elseif($v->field_type=='date')
<div class="form-group">
    <label>{{$v->field_name}}</label>
    <input type="date" class="form-control" placeholder="{{$v->field_name}}" name="tpl[{{$v->field}}]" value="{{$field_value}}">
</div>
@elseif($v->field_type=='select')
<div class="form-group">
    <label>{{$v->field_name}}</label>
    <select class="form-control" name="tpl[{{$v->field}}]">
      <?php
      	$options=explode("\r\n", $v->field_value);
      ?>
      <option value="">请选择{{$v->field_name}}</option>
      @foreach($options as $op)
	  <option value="{{$op}}" @if($field_value==$op) selected="selected" @endif>{{$op}}</option>
	  @endforeach
	</select>
</div>
@elseif($v->field_type=='checkbox')
<div class="form-group">
	<?php
      	$checkbox=explode("\r\n", $v->field_value);
      	$field_arr=explode("|",$field_value);
    ?>
    <label>{{$v->field_name}}</label>
    @foreach($checkbox as $c)
    <label class="checkbox-inline">
	  <input type="checkbox"  value="{{$c}}" name="tpl[{{$v->field}}][]" @if(in_array($c,$field_arr)) checked="checked" @endif > {{$c}}
	</label>
	@endforeach
</div>
@elseif($v->field_type=='radio')
<div class="form-group">
	<?php
      	$radios=explode("\r\n", $v->field_value);
    ?>
    <label>{{$v->field_name}}</label>
    @foreach($radios as $r)
    <label class="radio-inline">
	  <input type="radio" name="tpl[{{$v->field}}]" value="{{$r}}" @if($field_value==$r) checked="checked" @endif> {{$r}}
	</label>
	@endforeach
</div>
@elseif($v->field_type=='file')
<div class="form-group">
    <label>{{$v->field_name}}</label>
    <input type="file" name="tpl[{{$v->field}}]">
    @if(!empty($field_value))
    <a target="_blank" href="{{asset($field_value)}}">查看文件</a>
    @endif
    <!-- <p class="help-block">Example block-level help text here.</p> -->
 </div>
@endif
@endforeach
@endif
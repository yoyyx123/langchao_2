<div class="row" style="text-align:center;">
     <h2>绩效查询</h2>
</div>
<div class="row">
    <div class="box col-md-8">
    <table> 
        <tr>
          <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">部门</div>
              <select  class="form-control department_id" name="department_id" id="department_id">
                <option value="">无</option>
                <?php foreach ($department_list as $key => $value) {
                if(($user_data['position2']==1||$user_data['position2']==2)&&$user_data['department']==$value['id']){
                ?>
                    <option value="<? echo $value['id'];?>" <?if(isset($department_id)&&$department_id==$value['id']){echo "selected=selected";}?>><?echo $value['name'];?></option>
               <?}elseif($user_data['position2']==3||$user_data['position2']==4){?>
                    <option value="<? echo $value['id'];?>" <?if(isset($department_id)&&$department_id==$value['id']){echo "selected=selected";}?>><?echo $value['name'];?></option>
                <?php }} ?>
              </select>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">开始时间</div>
              <input class="form-control form_datetime" type="text" value="<?if(isset($start_time)){echo $start_time;}?>" name="start_time" id="start_time">
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">结束时间</div>
              <input class="form-control form_datetime" type="text" value="<?if(isset($end_time)){echo $end_time;}?>" name="end_time" id="end_time">
            </div>
          </div>
        </td>        
        <td></td>
      </tr>
      <tr>
        <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">使用人</div>
              <select  class="form-control user_id" name="user_id" id="user_id">
                <?if(isset($user_id)&&$user_id=='all'){
                    echo "<option value='all' selected=selected>全部</option>";
                  }elseif(isset($user_id)){
                    echo "<option value='".$user_id."'selected=selected>".$name."</option>";
                  }else{
                    echo "<option value=''>无</option>";
                  }

                ?>
              </select>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">客户简称</div>
              <input class="form-control" type="text" value="<?if(isset($short_name)){echo $short_name;}?>" name="short_name" id="short_name">
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">时间间隔</div>
              <select  class="form-control" name="time_step" id="time_step">
                <option value="day" <?if(isset($time_step)&&$time_step=="day"){echo "selected=selected";}?>>天</option>
                <option value="month" <?if(isset($time_step)&&$time_step=="month"){echo "selected=selected";}?>>月</option>
                <option value="season" <?if(isset($time_step)&&$time_step=="season"){echo "selected=selected";}?>>季度</option>
                <option value="half_year" <?if(isset($time_step)&&$time_step=="half_year"){echo "selected=selected";}?>>半年</option>
                <option value="year" <?if(isset($time_step)&&$time_step=="year"){echo "selected=selected";}?>>年</option>                
              </select>
            </div>
          </div>
        </td>        
        <td>
         <div class="form-group">
            <div class="input-group">
              <a class="btn btn-info do_search">查询</a>
            </div>
          </div>
        </td>
        </tr>
    </table>
</div>     

</div>

<div id="event_type" class="box col-md-8 event_type" style="display:none1">
  <table class="table table-bordered">
    <tr>
      <td>故障分类</td>
      <td>
        <input type="radio" id="f_radio_all" class="f_radio_all" name="f_radio">全部
        <input type="radio" id="f_radio_one" class="f_radio_one" name="f_radio" checked>指定
      </td>
      <td  id="event_type_list" class="event_type_list"></td>     
    </tr>
  </table>
</div>

<div class="row event_info" id="event_info">
  <?php
  if(isset($info_list)&&!empty($info_list)&&isset($is_search)){
  ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>序号</th>
                <th>汇总序列</th>
                <th>次数</th>
                <th>数值显示</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($info_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $key;?></td>
                <td><?php echo $value;?></td>
                <td></td>
            </tr>
            <? } ?>
            <tr align="center">
                <td>合计</td>
                <td>全部</td>
                <td><?php echo $count;?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
  <?php }elseif(isset($is_search)){?>
    <p>查询不到绩效信息!</p>
  <?php }?>   
</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url("ctl=search&act=data_export");?>';
    var getobj = {};
    getobj.user_id=$('#user_id').val();
    getobj.department_id=$('#department_id').val();
    getobj.event_month=$('#event_month').val();
    getobj.data_type=$('#data_type').val();
    getobj.is_search=1;;
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

<?if(isset($department_id)){?>
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'search', 'act'=>'get_department_change_result'))?>",
                data: "&department_id="+<?echo $department_id;?>,
                success: function(result){
                    var data = eval("("+result+")");
                    $(".user_id").empty();
                    if(data['user_list']){
                      $(".user_id").append('<option value="all">全部</option>');
                    }
                    $.each(data['user_list'], function(key,value){
                      if(value['id']==<?echo$user_id;?>){
                        $(".user_id").append('<option value="'+value['id']+'" selected=selected>'+value['name']+'</option>');
                      }else{
                        $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');                  
                      }
                    });
                    if(data['event_list']){
                        $(".event_type").css('display', '1');                      
                    }
                    //var start = '<div class="box-content"><div class="checkbox-group">';
                    //var end = '</div></div>';
                    start ='';
                    end='';
                    var content = '';
                    $.each(data['event_list'], function(key,value){
                        content = content+"<input type='checkbox' id='event_type' class='event_type' value='"+value['id']+"' name='event_type'>"+value['name'];
                      });
                    $("#event_type_list").empty();
                    $("#event_type_list").append(start+content+end);
                }
             });  

<?}?>

$(function() {

        $('.form_datetime').datetimepicker({
            format: "yyyy-mm-dd", 
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView:2,
            forceParse: 0,
            showMeridian: 1,

        });

        $(".f_radio_all").click(function(){
            $('input[type="checkbox"]').prop("checked",true);
        })
        $(".f_radio_one").click(function(){
          $('input[type="checkbox"]').prop("checked",false);
        })

        $(".department_id").change(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'search', 'act'=>'get_department_change_result'))?>",
                data: "&department_id="+$(this).val(),
                success: function(result){
                    var data = eval("("+result+")");
                    $(".user_id").empty();
                    if(data['user_list']){
                      $(".user_id").append('<option value="all">全部</option>');
                    }
                    $.each(data['user_list'], function(key,value){

                        $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                    });
                    if(data['event_list']){
                        $(".event_type").css('display', '1');                      
                    }
                    //var start = '<div class="box-content"><div class="checkbox-group">';
                    //var end = '</div></div>';
                    start ='';
                    end='';
                    var content = '';
                    $.each(data['event_list'], function(key,value){
                        content = content+"<input type='checkbox' id='event_type' class='event_type' value='"+value['id']+"' name='event_type'>"+value['name'];
                      });
                    $("#event_type_list").empty();
                    $("#event_type_list").append(start+content+end);
                }
             });
        });              

        $(".do_search").click(function() {
            _self = this;
            department_id = $('#department_id').val();
            user_id = $('#user_id').val();
            start_time = $('#start_time').val();
            end_time = $('#end_time').val();
            time_step = $('#time_step').val();
            short_name = $('#short_name').val();
            var event_type = '';
            $("input[name='event_type']:checkbox").each(function(){ 
                if($(this).prop("checked")){
                    event_type += $(this).val()+","
                }
            })
            if (start_time == '') {
                    var n = noty({
                      text: "开始时间必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
           if (end_time == '') {
                    var n = noty({
                      text: "结束时间必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }                
            if (department_id == '') {
                    var n = noty({
                      text: "部门必选",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (user_id == '') {
                    var n = noty({
                      text: "使用人必选",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (event_type == '') {
                    var n = noty({
                      text: "故障分类必须",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }                
            var url = "<?php echo site_url(array('ctl'=>'search', 'act'=>'performance_search'))?>"+"&is_search=1&user_id="+user_id+"&department_id="+department_id+"&start_time="+start_time+"&end_time="+end_time+"&short_name="+short_name+"&time_step="+time_step+"&event_type="+event_type;
            window.location.href = url;
        });

})
</script>
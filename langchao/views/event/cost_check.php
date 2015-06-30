<div class="row" style="text-align:center;">
     <h2>费用审核</h2>
</div>
<div class="row">
    <div class="box col-md-12">
        <form class="form-inline">
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
          </div>&nbsp&nbsp
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">月份</div>
              <input id="event_month" class="form-control format_time" type="text" value="<?if(isset($event_month)){echo $event_month;}?>" name="event_month">
            </div>
          </div>&nbsp&nbsp
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">费用状态</div>
              <select class="form-control" name="cost_status" id="cost_status">
                <option value="1" <?if(isset($cost_status)&&$cost_status==1){echo "selected=selected";}?>>未审核</option>
                <option value="2" <?if(isset($cost_status)&&$cost_status==2){echo "selected=selected";}?>>待报销</option>
                <option value="3" <?if(isset($cost_status)&&$cost_status==3){echo "selected=selected";}?>>已报销</option>
              </select>
            </div>
          </div>
        &nbsp&nbsp<a class="btn btn-info do_search">查询</a>
        </form>
    </div>
</div>

<div class="row event_info" id="event_info">
    <?php
    if(isset($month_list)&&!empty($month_list)&&isset($is_event)){
    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>序号</th>
                <th>使用人</th>
                <th>月份</th>
                <th>状态</th>
                <th>预报销总额</th>
                <th>操作</th>
                <th>实际报销总额</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($month_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['name'];?></td>
                <td><?php echo $key;?></td>
                <td><?if($value['cost_status']==1){echo "未审核";}elseif($value['cost_status']==2){echo "待报销";}elseif($value['cost_status']==3){echo "已报销";}?></td>
                <td><?php echo $value['total_fee'];?></td>
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=get_event_biil_list')."&user_id=".$value['user_id']."&event_month=".$key."&cost_status=".$value['cost_status'];?>">查看</a></td>
                <td><?if($cost_status != 1){echo $value['rel_total_fee'];}?></td>
            </tr>
            <? } ?>
        <tr>
            <td colspan="7"><?php $this->load->view('elements/pager'); ?></td>
        </tr>
        </tbody>
    </table>
<?php }elseif(isset($is_event)){?>
<p>查询不到事件信息!</p>
<?php }?>

</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">


var sel_time_data = function (per_page) {
    department_id = $('#department_id').val();
    user_id = $('#user_id').val();
    event_month = $('#event_month').val();
    cost_status = $('#cost_status').val();
    var url = '<?php echo site_url("ctl=event&act=cost_check");?>'+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&cost_status="+cost_status+"&department_id="+department_id;
    var getobj = {};
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
        url: "<?php echo site_url(array('ctl'=>'user', 'act'=>'get_user_list'))?>",
        data: "&department_id="+<?echo $department_id;?>,
        success: function(result){
            var data = eval("("+result+")");
            $(".user_id").empty();
            if(data.length == 0){
              $(".user_id").append('<option value="">无</option>');
            }
            $.each(data, function(key,value){
                if(value['id']==<?echo$user_id;?>){
                $(".user_id").append('<option value="'+value['id']+'" selected=selected>'+value['name']+'</option>');
                }else{
                $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                }
            });
        }
     });

<?}?>

$(function() {

    $('.format_time').datetimepicker({
        format: "yyyy-mm",
        language:  'zh-CN',
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 3,
        forceParse: 0,
        showMeridian: 1,
        minView:3
    });

        $(".department_id").change(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'user', 'act'=>'get_user_list'))?>",
                data: "&department_id="+$(this).val(),
                success: function(result){
                    var data = eval("("+result+")");
                    $(".user_id").empty();
                    if(data.length == 0){
                      $(".user_id").append('<option value="">无</option>');
                    }
                    $.each(data, function(key,value){
                        if(<? echo $user_data['position2'];?>!=1 &&<? echo $user_data['position2'];?>!=2){
                            $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                        }else if(<? echo $user_data['position2'];?>==1 && <? echo $user_data['id'];?> == value['id']){
                            $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                        }else if(<? echo $user_data['position2'];?>==2 && <? echo $user_data['department'];?> == value['department']){
                            $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                        }
                    });
                }
             });
        });
        $(".do_search").click(function() {
            _self = this;
            department_id = $('#department_id').val();
            user_id = $('#user_id').val();
            event_month = $('#event_month').val();
            cost_status = $('#cost_status').val();
            if (user_id == '') {
                    var n = noty({
                      text: "使用人必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (user_id == '' && event_month == '' && cost_status == '' ) {
                    var n = noty({
                      text: "三项中必须填写一项",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            var url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'cost_check'))?>"+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&cost_status="+cost_status+"&department_id="+department_id;
            window.location.href = url;
            /**
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'do_event_cost_search'))?>",
                data: "is_event=1&user_id="+user_id+"&event_month="+event_month+"&cost_status="+cost_status,
                success: function(result){
                    $("#event_info").html(result);
                }
             });
          **/
        });

})
</script>

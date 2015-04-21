<div class="row" style="text-align:center;">
     <h2>事件审核</h2>
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
              <div class="input-group-addon">事件状态</div>
              <select class="form-control" name="status" id="status">
                <option value="2" <?if(isset($status)&&$status==2){echo "selected=selected";}?>>待审核</option>
                <option value="3" <?if(isset($status)&&$status==3){echo "selected=selected";}?>>已审核</option>
              </select>
            </div>
          </div>
        &nbsp&nbsp<a class="btn btn-info do_search">查询</a>
        </form>
    </div>
</div>

<div class="row event_info" id="event_info">

    <?php
    if(isset($event_list)&&!empty($event_list)&&isset($is_event)){
    ?>    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>事件列表</th>
                <th colspan="2">使用人：<?php echo $user['name'];?></th>
                <th colspan="7"></th>
            </tr>                    
            <tr>
                <th>序号</th>
                <th>日期、时间</th>
                <th>客户简称</th>
                <th>事件类型</th>
                <th>事件描述</th>
                <th>工单</th>
                <th>工时</th>
                <th>状态</th>
                <th colspan="2">操作</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($event_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['event_time'];?></td>
                <td><?php echo $value['short_name'];?></td>
                <td><?php echo $value['event_type_name'];?></td>
                <td><?php echo $value['desc'];?></td>
                <td><?php echo $value['work_order_num'];?></td>
                <td><? echo $value['worktime_count'];?></td>
                <td><?php if($value['status']==1){echo "待添加";}elseif($value['status']==2){echo "待审核";}elseif($value['status']==3){echo "已审核";}?></td>
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=check_work_order')."&event_id=".$value['id']."&user_id=".$user_id."&department_id=".$department_id."&event_month=".$event_month."&status=".$status;?>">查看</a></td>
            </tr>
            <? } ?>
        <?if(isset($status)&&$status==2){?>
        <tr>
            <td colspan="8"></td>
            <td><a class="btn btn-info do_check_all" user_id='<?php echo $value['id'];?>'>一键审核</a></td>
        </tr>
        <?}?>
        </tbody>
        <tbody>
            <tr>
                <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
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
    status = $('#status').val();    
    var url = '<?php echo site_url("ctl=event&act=event_check");?>'+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&status="+status+"&department_id="+department_id;
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
  

        <?if(isset($is_status) && $is_status == "succ"){?>
            var n = noty({
              text: "审核成功",
              type: 'success',
              layout: 'center',
              timeout: 1000,
            });
        <?}?>
        <?if(isset($is_status) && $is_status != "succ"){?>
            var n = noty({
              text: "审核失败",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
        <?}?>

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

    $(".do_check_all").click(function() {
        _self = this;
        department_id = $('#department_id').val();
        user_id = $('#user_id').val();
        event_month = $('#event_month').val();
        status = $('#status').val();        
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'do_check_all_view'))?>"+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&status="+status+"&department_id="+department_id,
            data: "",
            success: function(result){
                $("#dialog").html(result);
                $("#dialog").dialog({
                    autoOpen : false,
                    width : 900,
                    title : ('正在进行一键审核'),
                    modal: true,

                });
                $("#dialog").dialog("open");
            }
         });
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
            status = $('#status').val();
            if (user_id == '') {
                    var n = noty({
                      text: "使用人必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }            
            if (user_id == '' && event_time == '' && status == '' ) {
                    var n = noty({
                      text: "三项中必须填写一项",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            var url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'event_check'))?>"+"&is_event=1&user_id="+user_id+"&event_month="+event_month+"&status="+status+"&department_id="+department_id;
            window.location.href = url;
            /**
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'event_check'))?>",
                data: "is_event=1&user_id="+user_id+"&event_time="+event_time+"&status="+status,
                success: function(result){
                    $("#event_info").html(result);
                }
             });
            **/
        });        

})
</script>
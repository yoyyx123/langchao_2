<form class="form-horizontal do_add_event" action="<?php echo site_url('ctl=event&act=do_edit_event');?>" method="post" onsubmit="return do_add();">

<div class="box col-lg-12 col-md-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>客户全称</th>
                <td colspan="5">
                    <?echo $member['name']; ?>
                </td>
            </tr>
            <tr>
                <th width="120px">客户简称</th>
                <td colspan="5">
                    <?echo $member['short_name']; ?>
                </td>
            </tr>                          
            <tr>
                <th>部门</th>
                <td>
                    <select name="department_id" id="department_id" class="department_id">
                        <option value="">请选择</option>
                        <?php foreach ($department_list as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>" <?if($user['department']==$value['id']){echo "selected=selected";}?>><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>使用人</th>
                <td>
                    <select name="user_id" id="user_id" class="user_id">
                      <option value="<?echo $user['id'];?>"><?echo $user['name'];?></option>
                    </select>
                </td>
            </tr>            
            <tr>
                <th>事件类型</th>
                <td>
                    <select name="event_type_id" id="event_type_id">                                        
                        <?php foreach ($event_list as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>" <?if($event['event_type_id']==$value['id']){echo "selected=selected";}?>><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>  
            </tr>
            <tr>
                <th>是否驻派</th>
                <td>
                    非驻派<input type="radio" name="work_type" id="work_type" value="0" <?if($event['work_type']=="0"){echo "checked";}?>/>&nbsp&nbsp&nbsp
                    驻派<input type="radio" name="work_type" id="work_type" value="1" <?if($event['work_type']=="1"){echo "checked";}?>>
                </td>
            </tr>            
            <tr>
                <th>事件描述</th>
                <td colspan="5">
                   <textarea name="desc" id="desc"><?echo $event['desc'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>工作日区间</th>
                <td>
                    <select name="worktime_id" id="worktime_id">                                        
                        <?php foreach ($worktime_list as $key => $value) {?>
                            <option value="<?php echo $value['id']; ?>" <?if($event['worktime_id']==$value['id']){echo "selected=selected";}?>><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>事件时间</th>
                <td>
                    <input class="form_datetime" type="text" value="<?echo $event['event_time'];?>" name="event_time" id="event_time">             
                </td>            
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="id" value="<?echo $event['id']; ?>">
    <input type="hidden" name="event_month" value="<?echo $event_month; ?>">
</div>
<div class="col-lg-7 col-md-4">
    <p class="center col-md-12">
        <button type="submit" class="btn btn-primary">保存</button>&nbsp&nbsp&nbsp
    </p>
</div> 

</form>


<script type="text/javascript">
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

        $(".department_id").change(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'user', 'act'=>'get_user_list'))?>",
                data: "&department_id="+$(this).val(),
                success: function(result){
                    var data = eval("("+result+")");
                    $(".user_id").empty();                    
                    $.each(data, function(key,value){
                        $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                    });
                }
             });
        });        
})

function do_add(){
    department_id = $('#department_id').val();
    user_id = $('#user_id').val();
    event_type_id = $('#event_type_id').val();
    work_type = $('#work_type').val();
    desc = $('#desc').val();
    worktime_id = $('#worktime_id').val();
    event_time = $('#event_time').val();
    event_time_start = $('#event_time_start').val();
    event_time_end = $('#event_time_end').val();
    is_all = $('#is_all').val();


    if (department_id== '') {
            var n = noty({
              text: "请选择部门",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (user_id== '') {
            var n = noty({
              text: "请选择使用人",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }        
    if (event_type_id == '') {
            var n = noty({
              text: "请选择事件类型",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (work_type == '') {
            var n = noty({
              text: "请选择是否驻派",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (desc == '') {
            var n = noty({
              text: "请填写事件描述",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (worktime_id == '') {
            var n = noty({
              text: "请选择工作日区间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (!is_all && event_time == '') {
            var n = noty({
              text: "请填写事件时间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (is_all && event_time_start == '') {
            var n = noty({
              text: "请选择批量开始时间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }        
    if (is_all && event_time_end == '') {
            var n = noty({
              text: "请选择批量结束时间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }    
}
</script>
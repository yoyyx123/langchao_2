<div class="box col-md-7">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="3">事件数据</th>
                </tr>
            </thead>
            <tbody>
                <tr align="center">
                    <th>工单数量</th>
                    <td><?php echo $work_order_num;?>件</td>
                    <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=look_work_order&event_id='.$event["id"]);?>" target="_blank">查看</a></td>
                </tr>
                <tr align="center">
                    <th>工作时间段</th>
                    <td><?php echo $event['worktime_id_value'];?></td>
                    <td>绩效完成率</td>
                </tr>                
                <tr align="center">
                    <th>有效工时</th>
                    <td><?php echo $event['work_time'];?>小时</td>
                    <td>
                        <select name="work_performance_id" id="work_performance_id" autocomplete = "off">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['work_performance_id'])&&$check['work_performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>平时加班</th>
                    <td><?php echo $event['week_more'];?>小时</td>
                    <td>
                        <select name="workmore_performance_id" id="workmore_performance_id" autocomplete = "off">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['workmore_performance_id'])&&$check['workmore_performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>周末加班</th>
                    <td><?php echo $event['weekend_more'];?>小时</td>
                    <td>
                        <select name="weekend_performance_id" id="weekend_performance_id" autocomplete = "off">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['weekend_performance_id'])&&$check['weekend_performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>节假日加班</th>
                    <td><?php echo $event['holiday_more'];?>小时</td>
                    <td>
                        <select name="holiday_performance_id" id="holiday_performance_id" autocomplete = "off">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['holiday_performance_id'])&&$check['holiday_performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>事件反馈</th>
                    <td colspan="2">
                        <?foreach ($work_order_list as $key => $value) {
                            if($value['schedule']==0){
                                $schedule = "已完成";
                            }elseif($value['schedule']==1){
                                $schedule = "部分完成";
                            }else{
                                $schedule = "未完成";
                            }
                            echo "<a target='_blank' href='".site_url('ctl=event&act=look_work_order')."&event_id=".$event['id']."&work_order_id=".$value['id']."'>".$schedule."</a>;";
                        }?>
                    </td>
                </tr>
                <tr align="center">
                    <th>有效期状态</th>
                    <!--<td><?php if($event_less_time==0){echo "已超时";}elseif($event_less_time==1){echo "未超时";}?></td>-->
                    <td colspan="2"><?php echo $event_less_time;?></td>
                </tr>                                                                      
            </tbody>
        </table>
</div>

<div class="box col-md-7">
    <form class="form-horizontal" action="<?php echo site_url('ctl=event&act=add_check_event_info');?>" method="post"  onsubmit="return do_add();">
        <table class="table table-bordered">
            <tbody>
                <tr align="center">
                    <th>是否投诉</th>
                    <td>
                        是<input type="radio" name="is_complain" id="is_complain" value="1" <?if(isset($check)&&$check['is_complain']==1){echo "checked='checked'";}?>>
                        否<input type="radio" name="is_complain" id="is_complain" value="0" <?if(isset($check)&&$check['is_complain']==0){echo "checked='checked'";} if(!isset($check)||empty($check['is_complain'])){echo "checked='checked'";}?> >
                    </td>
                </tr>
                <tr align="center">
                    <th>是否生效</th>
                    <td>
                        是<input type="radio" name="event_status" id="event_status" value="1" <?if(isset($check)&&$check['event_status']==1){echo "checked='checked'";}if(!isset($check)||empty($check['event_status'])){echo "checked='checked'";}?>>
                        否<input type="radio" name="event_status" id="event_status" value="0" <?if(isset($check)&&$check['event_status']==0){echo "checked='checked'";}?>>
                    </td>
                </tr>
                <tr align="center">
                    <th>绩效完成率</th>
                    <td>
                    <!--
                        <select name="performance_id" id="performance_id">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['performance_id'])&&$check['performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    -->
                    </td>
                </tr>
                <tr align="center">
                    <th>备注</th>
                    <td>
                        <input type="text" name="memo" id="memo" value="<?if(isset($check)){echo $check['memo'];}?>">
                    </td>
                </tr>                                                                     
            </tbody>
        </table>
        <input type="hidden" name="event_id" id="event_id" value="<?echo $event['id'];?>">
        <input type="hidden" name="check_id" id="check_id" value="<?if(isset($check)){echo $check['id'];}?>">

        <a class="btn btn-primary do_add" onclick="do_add()"><?if($event['status']==3){echo "已审核";}if($event['status']==2){echo "审核";}?></a>&nbsp&nbsp&nbsp
        <a class="btn btn-primary do_delete" event_id='<?php echo $event['id'];?>'>删除</a>        
    </form>
</div>


<script type="text/javascript">
$(function () {
    $(".do_delete").click(function() {
     if(confirm("确认删除吗")){
        _self = this;
        url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'delete_check_event'))?>"+"&event_id="+$(this).attr('event_id')+'<?echo $back_url;?>';
        window.location.href=url;
     }else{
        return;
     }
    });
})


function do_add(){
    is_complain = $('input[name="is_complain"]:checked').val()
    //event_status = $("#event_status").val();
    event_status = $('input[name="event_status"]:checked').val()
    work_performance_id = $("#work_performance_id").val();
    workmore_performance_id = $("#workmore_performance_id").val();
    weekend_performance_id = $("#weekend_performance_id").val();
    holiday_performance_id = $("#holiday_performance_id").val();
    memo = $("#memo").val();
    event_id = $("#event_id").val();
    check_id = $("#check_id").val();
    if (is_complain== '') {
        var n = noty({
          text: "请选择是否投诉",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (event_status== '') {
        var n = noty({
          text: "请选择是否生效",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (work_performance_id== '') {
        var n = noty({
          text: "请选择有效工时绩效完成率",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (workmore_performance_id== '') {
        var n = noty({
          text: "请选择平时加班绩效完成率",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (weekend_performance_id== '') {
        var n = noty({
          text: "请选择周末加班绩效完成率",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (holiday_performance_id== '') {
        var n = noty({
          text: "请选择节假日加班绩效完成率",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }    

    var value = $(".do_add").html();

    if ("审核" == value){
        if (!confirm("确认要审核")) {
           return false;
        }
        status = 3;
    }
    if("已审核" == value){
        if (!confirm("确认要取消审核")) {
           return false;
        }
        status = 2;
    }
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=event&act=add_check_event_info');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("event_id="+event_id+"&is_complain="+is_complain+"&event_status="+event_status+"&work_performance_id="+work_performance_id+"&workmore_performance_id="+workmore_performance_id+"&weekend_performance_id="+weekend_performance_id+"&holiday_performance_id="+holiday_performance_id+"&memo="+memo+"&status="+status);
    var result = xmlhttp.responseText;
    var data = eval("("+result+")");
    if ("succ" == data.status && status==3){
        var n = noty({
          text: "审核成功！",
          type: 'success',
          layout: 'center',
          timeout: 1000,
        });
        var url = "<?echo site_url('ctl=event&act=event_check').$back_url;?>";
        url = url+"&is_status=succ";
        window.location.href = url;
        //$(".do_add").html("已审核");
        //return true;
    }

    if ("succ" == data.status && status==2){
        var n = noty({
          text: "已取消审核！",
          type: 'success',
          layout: 'center',
          timeout: 1000,
        });
        $(".do_add").html("审核");
        return true;
    }    
}
</script>
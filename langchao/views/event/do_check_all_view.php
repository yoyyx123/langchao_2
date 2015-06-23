<div class="box col-md-7">
    <form class="form-horizontal" action="<?php echo site_url('ctl=event&act=do_check_all');?>" method="post"  onsubmit="return dopost();">
        <table class="table table-bordered">
            <tbody>
                <tr align="center">
                    <th>是否投诉</th>
                    <td>
                        是<input type="radio" name="is_complain" id="is_complain" value="1">
                        否<input type="radio" name="is_complain" id="is_complain" value="0" checked='checked'>
                    </td>
                </tr>
                <tr align="center">
                    <th>是否生效</th>
                    <td>
                        是<input type="radio" name="event_status" id="event_status" value="1" checked='checked'>
                        否<input type="radio" name="event_status" id="event_status" value="0">
                    </td>
                </tr>
                <tr align="center">
                    <th>有效工时绩效完成率</th>
                    <td>
                        <select name="work_performance_id" id="work_performance_id">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['work_performance_id'])&&$check['work_performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>平时加班绩效完成率</th>
                    <td>
                        <select name="workmore_performance_id" id="workmore_performance_id">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['workmore_performance_id'])&&$check['workmore_performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>周末加班绩效完成率</th>
                    <td>
                        <select name="weekend_performance_id" id="weekend_performance_id">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['weekend_performance_id'])&&$check['weekend_performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>节假日加班绩效完成率</th>
                    <td>
                        <select name="holiday_performance_id" id="holiday_performance_id">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['holiday_performance_id'])&&$check['holiday_performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr align="center">
                    <th>备注</th>
                    <td>
                        <input type="text" name="memo" id="memo" value="">
                    </td>
                </tr>                                                                     
            </tbody>
        </table>
        <input type="hidden" name="department_id" id="department_id" value="<?echo $department_id;?>">
        <input type="hidden" name="user_id" id="user_id" value="<?echo $user_id;?>">
        <input type="hidden" name="event_month" id="event_month" value="<?echo $event_month;?>">
        <input type="hidden" name="status" id="status" value="<?echo $status;?>">
        <button class="btn btn-primary" type="submit">审核</button>
    </form>
</div>


<script type="text/javascript">

    function dopost(){
        is_complain = $('input[name="is_complain"]:checked').val()
        event_status = $('input[name="event_status"]:checked').val()
        work_performance_id = $("#work_performance_id").val();
        workmore_performance_id = $("#workmore_performance_id").val();
        weekend_performance_id = $("#weekend_performance_id").val();
        holiday_performance_id = $("#holiday_performance_id").val();
        memo = $("#memo").val();
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
    }
</script>
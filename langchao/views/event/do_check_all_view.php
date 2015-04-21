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
                    <th>绩效完成率</th>
                    <td>
                        <select name="performance_id" id="performance_id">
                            <option value="">请选择</option>
                            <?foreach ($performance_list as $key => $value) {?>
                                <option value="<?echo $value['id'];?>" <?if(isset($check['performance_id'])&&$check['performance_id']==$value['id']){echo "selected='selected'";}?>><?echo $value['name'];?>%</option>
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
        performance_id = $("#performance_id").val();
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
        if (performance_id== '') {
            var n = noty({
              text: "请选择绩效完成率",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    }
</script>
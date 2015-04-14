
<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_time_add');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return do_add();">
<div class="col-lg-7 col-md-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">日期</th>
                <td>
                    <input type="text" class="form_datetime" name="value" id="value">
                </td>
            </tr>
            <tr>
                <th width="80px">类型</th>
                <td>
                    <select name="type" id="type">
                        <option value="holiday">节日</option>
                    </select>                    
                </td>
            </tr>
            <tr>
                <th width="80px">名称</th>
                <td>
                    <input type="text" name="name" id="name">
                </td>
            </tr>
        </tbody>
    </table>

</div>
<div class="col-lg-7 col-md-4">
    <p class="center col-md-5">
        <button type="submit" class="btn btn-primary">添加</button>
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
})

function do_add(){
    value = $('#value').val();
    type = $('#type').val();
    name = $('#name').val();  
    if (name== '') {
        var n = noty({
          text: "请输入节假日名称",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (type== '') {
        var n = noty({
          text: "请选择假期类型",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (value== '') {
        var n = noty({
          text: "请选择日期",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    return true;
        
}


</script>
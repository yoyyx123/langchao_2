
<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_time_edit');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return do_add();">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">日期</th>
                <td>
                    <input type="text" class="datetime" name="value" id="value" value="<?echo $info['value']?>">
                </td>
            </tr>
            <tr>
                <th width="80px">类型</th>
                <td>
                    <select name="type" id="type" class="type">
                        <option value="weekend" <?php if($info['type']=="weekend") echo "selected='selected'"; ?>>周末</option>                        
                        <option value="holiday" <?php if($info['type']=="holiday") echo "selected='selected'"; ?>>节日</option>
                    </select>                    
                </td>
            </tr>
            <tr>
                <th width="80px">名称</th>
                <td>
                    <input type="text" name="name" id="name" value="<?echo $info['name']?>">
                </td>
            </tr>            
        </tbody>
    </table>
        <input type="hidden" name="id" id="id" value="<?php echo $info['id']?>">
        <button type="submit" class="btn btn-primary">修改</button>
</form>
<script type="text/javascript">


$(function() {


    type = $(".type").val();
    if (type == "holiday"){
        $(".datetime").addClass("form_datetime");
        $("#value").val("");
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
    }

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

        $(".type").change(function(){
            _self = this;
            type = $(this).val();
            if (type == "weekend"){
                $(".datetime").removeClass("form_datetime");
                $("#value").val("");
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
            }
            if (type == "holiday"){
                $(".datetime").addClass("form_datetime");
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
            }
        })        
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
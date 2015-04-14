
<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_custom_edit');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">城市名称</th>
                <td>
                    <input type="text" placeholder="角色名称" name="name" id="name" value="<?php echo $role['name']?>">
                </td>
            </tr>

        </tbody>
    </table>
        <input type="hidden" name="id" id="id" value="<?php echo $role['id']?>">
        <button type="submit" class="btn btn-primary">修改</button>
</form>         
<script type="text/javascript">
$(function() {
        $(".doedit").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'custom_edit'))?>"+"&id="+$(this).attr('custom_id'),
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('编辑地点'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });
})
</script>
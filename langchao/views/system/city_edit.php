
<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_city_edit');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
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
        $(".dodelete").click(function() {
         if(confirm("确认删除吗")){
            _self = this;
            url = "<?php echo site_url(array('ctl'=>'system', 'act'=>'city_delete'))?>"+"&id="+$(this).attr('city_id'),
            window.location.href=url;
         }else{
            return;
         }
        });

        $(".doadd").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'city_add'))?>",
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('添加地点'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });

        $(".doedit").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'city_edit'))?>"+"&id="+$(this).attr('city_id'),
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
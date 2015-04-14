
<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_event_edit');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">类型</th>
                <td>
                    <input type="text" placeholder="角色名称" name="name" id="name" value="<?php echo $role['name']?>">
                </td>
            </tr>
            <tr>
                <th width="80px">适用部门</th>
                <td>
                    <select name="department_id" id="department_id">
                        <option value="all">全部</option>
                        <?php foreach ($department_list as $key => $value) {?>
                        <option <?php echo "value='".$value['id']."'"; if($role['department_id']==$value['id'])echo "selected='selected'"; ?>><?php echo $value['name']?></option>
                        <?php } ?>
                    </select>                    
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
            url = "<?php echo site_url(array('ctl'=>'system', 'act'=>'event_delete'))?>"+"&id="+$(this).attr('event_id'),
            window.location.href=url;
         }else{
            return;
         }
        });

        $(".doadd").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'event_add'))?>",
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
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'event_edit'))?>"+"&id="+$(this).attr('event_id'),
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
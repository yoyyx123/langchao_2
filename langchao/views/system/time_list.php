<div class="row">
    <ul class="breadcrumb">
        <li>
            <a class="btn btn-primary doadd">添加信息</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>节假日时间管理</h4></th>
                </tr>               
                <tr>
                    <th>序号</th>
                    <th>名称</th>
                    <th>日期</th>
                    <th>类型</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($list as $key => $value) {?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $value['name'];?></td>
                    <td><?php echo $value['value'];?></td>
                    <td><?php 
                        if($value['type']=="holiday"){echo "节日";}
                        if($value['type']=="weekend"){echo "周末";}
                        if($value['type']=="h_weekend"){echo "假期周末加班";}
                     ?></td>
                    <td><a class="btn btn-info doedit" setting_id='<?php echo $value['id'];?>'>编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger dodelete" setting_id='<?php echo $value['id'];?>'>删除</a>
                    </td>
                </tr>
                
                <?php $i++;} ?>

            </tbody>
            <tbody>
                <tr>
                    <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url("ctl=system&act=time_list");?>';
    var getobj = {};
    //getobj.from_node_id=$('#from_node_id_searsh').val();
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

$(function() {
        $(".dodelete").click(function() {
         if(confirm("确认删除吗")){
            _self = this;
            url = "<?php echo site_url(array('ctl'=>'system', 'act'=>'time_delete'))?>"+"&id="+$(this).attr('setting_id'),
            window.location.href=url;
         }else{
            return;
         }
        });

        $(".doadd").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'time_add'))?>",
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('添加节假日'),
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
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'time_edit'))?>"+"&id="+$(this).attr('setting_id'),
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('编辑节假日'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });
         $(".dialog_close").click(function() {
            //$(this).dialog('close');
         });

})
</script>
 
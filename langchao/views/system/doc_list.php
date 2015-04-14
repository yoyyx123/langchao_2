<div class="row">
    <div class="box col-md-5">
    <form action="<?php echo site_url(array('ctl'=>'system', 'act'=>'doc_add'))?>" method="post" enctype="multipart/form-data" onsubmit="return do_upload();" accept-charset="utf-8">
        <table class="table table-bordered">            
            <tr>
                <th>选择文件</th>
                <th>文档名称</th>
                <th>所属部门</th>
                <th>操作</th>
            </tr>
            <tr>
                <td><input type="file" name="file" id="file" /></td>
                <td><input type="text" name="name" id="name"></td>
                <td>
                    <select name="department">
                        <?foreach ($department_list as $key => $value) {?>
                            <option value = "<?echo $value['id'];?>"><?echo $value['name'];?></option>
                        <?}?>
                    </select>
                </td>
                <td><input class="btn btn-primary" type="submit" name="submit" value="上传" /></td>
            <tr>
        </table>
    </form>        
    </div>

</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>文档管理</h4></th>
                </tr>
                <tr>
                    <th colspan="2">选择部门：</th>
                    <th>
                        <select class="form-control department" name="department">
                            <option value="all">全部</option>
                            <?foreach ($department_list as $key => $value) {?>
                                <option value = "<?echo $value['id'];?>" <?if(isset($department)&&($department==$value['id'])){echo "selected=selected";}?>><?echo $value['name'];?></option>
                            <?}?>
                        </select>                        
                    </th>
                    <th>
                    </th>
                </tr>                
                <tr>
                    <th>序号</th>
                    <th>名称</th>
                    <th>所属部门</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($list as $key => $value) {?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $value['name'];?></td>
                    <td><?php echo $value['department_name'];?></td>                    
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

$(function() {
    <?if (isset($status)){?>
        var n = noty({
          text: "<?echo $status;?>",
          type: 'success',
          layout: 'center',
          timeout: 1000,
        });
    <?}?>

        $(".department").change(function(){
            _self = this;
            var url = '<?php echo site_url("ctl=system&act=doc_list");?>';
            url = url+"&department="+$('.department').val();
            window.location.href = url;
        })

    $(".dodelete").click(function() {
     if(confirm("确认删除吗")){
        _self = this;
        url = "<?php echo site_url(array('ctl'=>'system', 'act'=>'delete_doc'))?>"+"&setting_id="+$(this).attr('setting_id');
        window.location.href=url;
     }else{
        return;
     }
    });

    $(".doedit").click(function() {
        _self = this;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'edit_doc'))?>"+"&id="+$(this).attr('setting_id'),
            data: "",
            success: function(result){
                $("#dialog").html(result);
                $("#dialog").dialog({
                    autoOpen : false,
                    width : 900,
                    title : ('修改文档信息'),
                    modal: true,

                });
                $("#dialog").dialog("open");
            }
         });
    });    

})


var sel_time_data = function (per_page) {
    var url = '<?php echo site_url("ctl=system&act=doc_list");?>';
    var getobj = {};
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

function do_upload(){
    file = $('#file').val();
    name = $('#name').val(); 
    if (file== '') {
        var n = noty({
          text: "请选择上传文件",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    if (name== '') {
        var n = noty({
          text: "请输入文档名称",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }    
    return true;
        
}
</script>
 
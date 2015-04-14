<div>
    <ul class="breadcrumb">
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>账户管理</h4></th>
                </tr>
                <tr>
                    <th>账户列表</th>
                    <th colspan="6"></th>
                    <th><input class="form-control" type="text" placeholder="短号或者姓名" name="where" id="where"></th>
                    <th><a class="btn btn-info do_search">查询</a></th>
                </tr>                
                <tr>
                    <th>序号</th>
                    <th>账户</th>
                    <th>使用人</th>
                    <th>短号</th>
                    <th>
                        <select class="form-control department">
                            <option value="all" <?if($department=='all'){echo "selected=selected";}?>>全部</option>
                            <?foreach ($department_list as $key => $value) {?>
                              <option value="<?echo $value['id'];?>" <?if($department==$value['id']){echo "selected=selected";}?>><?echo $value['name'];?></option>  
                            <?}?>
                        </select>
                    </th>                     
                    <th>状态</th>
                    <th>工作地点</th>
                    <th>工作类型</th>
                    <th>访问权限</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($user_list as $key => $value) {?>
                <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $value['username'];?></td>
                    <td><?php echo $value['name'];?></td>
                    <td><?php echo $value['short_num'];?></td>
                    <td><?php echo $value['department_name'];?></td>
                    <td><?php if('1' == $value['status']){echo "在职";}else{echo "离职";}?></td>
                    <td><?php echo $value['addr_name'];?></td>
                    <td><?php if('1' == $value['work_type']){echo "驻场";}else{echo "非驻场";}?></td>
                    <td><?php echo $value['roles_name'];?></td>
                    <td>
                        <a class="btn btn-primary do_edit" user_id='<?php echo $value['id'];?>'>编辑</a>&nbsp&nbsp
                        <a class="btn btn-primary do_delete" user_id='<?php echo $value['id'];?>'>删除</a>
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
<div id="dialog"></div>

<script type="text/javascript">

$(function() {
    <?if(isset($status)){?>
    var n = noty({
      text: "<?echo $status;?>",
      type: 'success',
      layout: 'center',
      timeout: 1000,
    });

    <?}?>

    $(".department").change(function(){
        _self = this;
        var url = '<?php echo site_url("ctl=user&act=manage");?>';
        url = url+"&department="+$('.department').val();
        window.location.href = url;
    })

    $(".do_delete").click(function() {
     if(confirm("确认删除吗")){
        _self = this;
        url = "<?php echo site_url(array('ctl'=>'user', 'act'=>'delete_user'))?>"+"&user_id="+$(this).attr('user_id');
        window.location.href=url;
     }else{
        return;
     }
    });

    $(".do_edit").click(function() {
        _self = this;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(array('ctl'=>'user', 'act'=>'edit'))?>"+"&id="+$(this).attr('user_id'),
            data: "",
            success: function(result){
                $("#dialog").html(result);
                $("#dialog").dialog({
                    autoOpen : false,
                    width : 900,
                    title : ('修改账户信息'),
                    modal: true,

                });
                $("#dialog").dialog("open");
            }
         });
    });

        $(".do_search").click(function() {
            _self = this;
            where = $('#where').val();
            if (where == '') {
                    var n = noty({
                      text: "请输入查询条件",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            var url = "<?php echo site_url(array('ctl'=>'user', 'act'=>'do_search'))?>"+"&is_search=1"+"&where="+where;
            window.location.href=url;
        });


})

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url('ctl=user&act=manage');?>';
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

</script>
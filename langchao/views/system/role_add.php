<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ctl=system&act=role_list');?>" class="btn btn-primary">返回</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i></i></h2>
            </div>
            <div class="box-content row">
                <form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_role_add');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return do_add();">
                <div class="col-lg-7 col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="80px">角色名称</th>
                                <td>
                                    <input type="text" placeholder="角色名称" name="role_name" id="role_name">
                                </td>
                            </tr>
                            <tr>
                                <th width="80px">角色身份</th>
                                <td>
                                    <select type="text" name="position2" id="position2">
                                        <option value="1">员工</option>
                                        <option value="2">部门经理</option>
                                        <option value="3">总经理</option>
                                        <option value="4">管理员</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>角色简介</th>
                                <td>
                                    <textarea type="text" placeholder="角色简介" name="role_memo" id="role_memo"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th width="80px">角色权限</th>
                                <td>
                                    <div class="box-content">
                                        <?php foreach ($ctl_list as $key => $value) {?>
                                           <div class="checkbox-group">
                                                <input class="sel-handle f_radio_all" type="checkbox" value="<?echo $value['id']?>" name="ctl[]">
                                                <?php echo $value['name']?>
                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php foreach ($value['ctl_child'] as $k => $v) {?>
                                                    <input class="f_radio_one" type="checkbox" value="<?echo $v['id']?>" name="ctl[]"><?echo $v['name']?>
                                                <?php }?>
                                                <br>
                                                <hr>
                                            </div>
                                        <?php }?>
                                    </div>
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
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">

$(function() {
    $(".f_radio_all").click(function(){
        if($(this).prop("checked")){
           $(this).parent().children('input[type="checkbox"]').prop("checked",true); 
        }else{
            $(this).parent().children('input[type="checkbox"]').prop("checked",false);
        }
        
        //$('input[type="checkbox"]').prop("checked",true);
    })
    $(".f_radio_one").click(function(){
        if($(this).prop("checked")){
           $(this).parent().children('input[class="sel-handle f_radio_all"]').prop("checked",true); 
        }
    })

})


function do_add(){
    role_name = $('#role_name').val();    
    if (role_name== '') {
            $("#userdiv").addClass("has-error");
            var n = noty({
              text: "请输入角色名称",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=system&act=check_role_name');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("role_name="+role_name);
    var status = xmlhttp.responseText;
    if (false == status){
        return true;
    }else{
        var n = noty({
          text: "角色名称已存在！",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false
    }    
}


</script>
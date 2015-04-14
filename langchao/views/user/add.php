<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ctl=home&act=index');?>">首页</a>
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
                <form class="form-horizontal" action="<?php echo site_url('ctl=user&act=do_add');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return do_add();">
                <div class="col-lg-7 col-md-4">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="80px">帐号</td>
                                <td>
                                    <div id="userdiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="帐号" name="username" id="username">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>姓名</td>
                                <td>
                                    <div id="namediv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="姓名" name="name" id="name">
                                    </div>                                    
                                </td>
                            </tr>
                            <tr>
                                <td width="80px">密码</td>
                                <td>
                                    <div id="passworddiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="密码" name="password" id="password">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>移动电话</td>
                                <td>
                                    <div id="mobilediv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="移动电话" name="mobile" id="mobile">
                                    </div>
                                </td>
                            </tr> 
                            <tr>
                                <td>集团短号</td>
                                <td>
                                    <div id="short_numdiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="集团短号" name="short_num" id="short_num">
                                    </div>
                                </td>
                            </tr>                            
                            <tr>
                                <td>部门</td>
                                <td>
                                    <div id="departmentdiv" class="input-group col-xs-8">
                                    <select name="department" id="department" class="form-control">                                        
                                       <?php foreach ($department_list as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>                                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>职位</td>
                                <td>
                                    <div id="positiondiv" class="input-group col-xs-8">
                                    <select name="position" id="position" class="form-control">                                        
                                       <?php foreach ($position_list as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>访问权限</td>
                                <td>
                                    <div id="rolesdiv" class="input-group col-xs-8">
                                    <select name="roles" id="roles" class="form-control">
                                       <?php foreach ($role_list as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['role_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </td>
                            </tr> 
                            <tr>
                                <td>企业邮箱</td>
                                <td>
                                    <div id="emaildiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="企业邮箱" name="email" id="email">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>工作地点</td>
                                <td>
                                    <div id="addrdiv" class="input-group col-xs-8">
                                    <select name="addr" id="addr" class="form-control">
                                       <?php foreach ($city_list as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </td>
                            </tr>  
                            <tr>
                                <td>工作类型</td>
                                <td>
                                    <div id="work_typediv" class="input-group col-xs-8">
                                    非驻场<input type="radio" name="work_type" id="work_type" value="0" checked/>&nbsp&nbsp&nbsp
                                    驻场<input type="radio" name="work_type" id="work_type" value="1">
                                    </div>
                                </td>
                            </tr>  
                            <tr>
                                <td>基础报销</td>
                                <td>
                                    <div id="expensesdiv" class="input-group col-xs-8">
                                    <input type="text"  class="form-control" placeholder="基础报销" name="expenses" id="expenses" disabled="disabled">
                                    </div>
                                </td>
                            </tr>  
                            <tr>
                                <td>上下班时间</td>
                                <td>
                                    <div id="work_timediv" class="input-group col-xs-4">
                                    <select name="work_time" id="work_time" class="form-control">
                                       <?php foreach ($worktime_list as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </td>
                            </tr>  
                            <tr>
                                <td>状态</td>
                                <td>
                                    <div id="statusdiv" class="input-group col-xs-4">
                                    在职<input type="radio" name="status" id="status" value="1" checked="checked">&nbsp&nbsp&nbsp
                                    离职<input type="radio" name="status" id="status" value="0">
                                    </div>
                                </td>
                            </tr>  
                        </tbody>
                    </table>

                </div>
                <div class="col-xs-6 col-md-4" style="text-align:center;">
                    <div >
                        <div class="caption">
                            <p> </p>
                            <p>&nbsp</p>
                            <img id="img_input" name="img" height="200px"  src="" />
                        </div>
                        <div class="caption">
                            <p> </p>
                            <p>&nbsp</p>
                            <p>
                                <input id="img" type="file" size="45" name="img" class="input" onchange="previewImg()">
                            </p>
                            <p>*只能上传大小1M以内的jpg/png 图片</p>
                        </div>
                    </div>
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

$(function () {

    $("#work_typediv :radio").change(function (){
        work_type = $('input[name="work_type"]:checked').val();
        if(work_type=='1'){
            $("#expenses").removeAttr("disabled");
        }else{
            $("#expenses").attr("disabled", true);
            $("#expenses").val() = "";
        }
    });

})

function edit_passwd(){

    old_password = $('#old_password').val();
    new_password = $('#new_password').val();
    new_password_confirm = $('#new_password_confirm').val();
    if (old_password== '') {
            $("#passworddiv").addClass("has-error");
            var n = noty({
              text: "请输入密码",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (new_password == '') {
            $("#new_pwddiv").addClass("has-error");
            var n = noty({
              text: "请输入新密码",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (new_password_confirm == '') {
            $("#cnew_pwddiv").addClass("has-error");
            var n = noty({
              text: "请输入确认密码",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if(new_password != new_password_confirm){
            $("#cnew_pwddiv").addClass("has-error");
            var n = noty({
              text: "两次密码输入不一致",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }        

    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=user&act=check_passwd');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("passwd="+old_password);
    var status = xmlhttp.responseText;
    if ('succ' != status){
        $("#passworddiv").addClass("has-error");
        var n = noty({
          text: "原始密码错误，请确认后输入！",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false
    }
    $.post( 
        "<?php echo site_url('ctl=user&act=edit_passwd');?>",
        {old_password:old_password,new_password:new_password},
        function(result){
            if (result=='succ'){
                window.location.reload();
            }else{
                var n = noty({
                  text: "密码修改失败",
                  type: 'error',
                  layout: 'center',
                  timeout: 1000,
                });
            }
    });

}

function previewImg(){
    f = document.getElementById("img").files[0];
    var src = window.URL.createObjectURL(f);
    document.getElementById("img_input").src = src;
}

function check_img(){
    f = document.getElementById("img").files[0];
    if(f){
        return true;
    }else{
        return false;
    }
}

function do_add(){
    username = $('#username').val();
    name = $('#name').val();
    password = $('#password').val();
    mobile = $('#mobile').val();
    short_num = $('#short_num').val();
    department = $('#department').val();
    position = $('#position').val();
    email = $('#email').val();
    roles = $('#roles').val();
    addr = $('#addr').val();
    work_type = $('input[name="work_type"]:checked').val();
    expenses = $('#expenses').val();
    work_time = $('#work_time').val();
    status = $('input[name="status"]:checked').val();;
    if (username== '') {
            $("#userdiv").addClass("has-error");
            var n = noty({
              text: "请输入用户名",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (name== '') {
            $("#namediv").addClass("has-error");
            var n = noty({
              text: "请输入姓名",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }        
    if (password == '') {
            $("#passworddiv").addClass("has-error");
            var n = noty({
              text: "请输入密码",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (mobile == '') {
            $("#mobilediv").addClass("has-error");
            var n = noty({
              text: "请输入手机号",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (short_num == '') {
            $("#short_numdiv").addClass("has-error");
            var n = noty({
              text: "请输入企业短号",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (department == '') {
            $("#departmentdiv").addClass("has-error");
            var n = noty({
              text: "请输入部门",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (position == '') {
            $("#positiondiv").addClass("has-error");
            var n = noty({
              text: "请输入职位",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (roles == '') {
            $("#rolesdiv").addClass("has-error");
            var n = noty({
              text: "请选择权限",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }        
    if (email == '') {
            $("#emaildiv").addClass("has-error");
            var n = noty({
              text: "请输入企业邮箱",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (addr == '') {
            $("#addrdiv").addClass("has-error");
            var n = noty({
              text: "请输入工作地点",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (work_type == '') {
            $("#work_typediv").addClass("has-error");
            var n = noty({
              text: "请输入工作类型",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (work_type=='1' && expenses == '') {
            $("#expensesdiv").addClass("has-error");
            var n = noty({
              text: "请输入基础报销",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (work_time == '') {
            $("#work_timediv").addClass("has-error");
            var n = noty({
              text: "请输入工作时间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (status == '') {
            $("#statusdiv").addClass("has-error");
            var n = noty({
              text: "请输入在职状态",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    img_status = check_img();
    if(!img_status){
        var n = noty({
          text: "请选择上传图片",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }

    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=user&act=check_username');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("username="+username);
    var status = xmlhttp.responseText;
    if (false == status){
        return true;
    }else{
        var n = noty({
          text: "帐号名已存在！",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false
    }    
}


</script>
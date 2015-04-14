<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ctl=home&act=index');?>" class="btn btn-primary">返回首页</a>
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

                <div class="col-lg-7 col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="80px">帐号</td>
                                <td><?php echo $user_data['username'];?></td>
                            </tr>
                            <tr>
                                <td>姓名</td>
                                <td><?php echo $user_data['name'];?></td>
                            </tr>
                            <tr>
                                <td width="80px">密码</td>
                                <td>
                                    ******&nbsp&nbsp&nbsp
                                    <a class="btn btn-info btn-setting" href="#">修改</a>
                                </td>
                            </tr>
                            <tr>
                                <td>移动电话</td>
                                <td><?php echo $user_data['mobile'];?></td>
                            </tr> 
                            <tr>
                                <td>集团短号</td>
                                <td><?php echo $user_data['short_num'];?></td>
                            </tr>                            
                            <tr>
                                <td>部门</td>
                                <td><?php echo $user_data['department_name'];?></td>
                            </tr>
                            <tr>
                                <td>职位</td>
                                <td><?php echo $user_data['position_name'];?></td>
                            </tr>                            
                            <tr>
                                <td>企业邮箱</td>
                                <td><?php echo $user_data['email'];?></td>
                            </tr>                              
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-6 col-md-4" style="text-align:center;">
                    <div >
                        <div class="caption">
                            <p> </p>
                            <p>&nbsp</p>
                            <img height="200px"  src="<?php echo base_url('upload/img/userlogo').'/'.$user_data['img'];?>" />
                        </div>
                        <div class="caption">
                            <p> </p>
                            <p>&nbsp</p>
                            <p>
                                <input id="img" type="file" size="45" name="img" class="input">
                                <button class="button" id="buttonUpload" onclick="return ajaxFileUpload();">保存</button>
                            </p>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>密码重置</h3>
            </div>
            <div class="modal-body">
               <fieldset>
                    <div id="passworddiv" class="input-group input-group-lg">
                        <span class="input-group-addon">原密码</span>
                            <input type="password" class="form-control" placeholder="原密码" name="old_password" id="old_password">
                    </div>
                    <div class="clearfix"></div><br>

                    <div id="new_pwddiv" class="input-group input-group-lg">
                        <span class="input-group-addon">新密码</span>
                        <input type="password" class="form-control" placeholder="新密码" name="new_password" id="new_password">
                    </div>
                    <div class="clearfix"></div><br>
                    <div id="cnew_pwddiv" class="input-group input-group-lg">
                        <span class="input-group-addon">新密码确认</span>
                        <input type="password" class="form-control" placeholder="新密码确认" name="new_password_confirm" id="new_password_confirm">
                    </div>
                    <span class="help-block" id="err_msg" style="color:red;"></span>
                    <div class="clearfix"></div><br>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="return edit_passwd();">保存</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

$(function () {

    $('#old_password').blur(function (){
        if ($('#old_password').val() == '') {
            $("#passworddiv").addClass("has-error");
        }else{
            $("#passworddiv").removeClass("has-error");
            $("#passworddiv").addClass("has-success");
        }

    })

    $('#new_password').blur(function (){
        if ($('#new_password').val() == '') {
            $("#new_pwddiv").addClass("has-error");
        }else{
            $("#new_pwddiv").removeClass("has-error");
            $("#new_pwddiv").addClass("has-success");
        }

    })

    $('#new_password_confirm').blur(function (){
        if ($('#new_password_confirm').val() == '') {
            $("#cnew_pwddiv").addClass("has-error");
        }else if($('#new_password').val() != $('#new_password_confirm').val()){
            $("#cnew_pwddiv").addClass("has-error");
            var n = noty({
              text: "两次密码输入不一致",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
        }else{
            $("#cnew_pwddiv").removeClass("has-error");
            $("#cnew_pwddiv").addClass("has-success");
        }

    })
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


function ajaxFileUpload(){
    $.ajaxFileUpload({
        url:"<?php echo site_url('ctl=user&act=edit_user_img');?>",
        secureuri:false,
        fileElementId:'img',
        dataType: 'json',
        success: function (data)
              {
                if('succ' == data.status){
                    var n = noty({
                      text: "头像上传成功",
                      type: 'success',
                      layout: 'center',
                      timeout: 1000,
                    });
                }else{
                    alert(data.msg);
                }
                location.reload(true);
              }
           })

    return false;
} 
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>上海浪潮工贸有限公司</title>
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="上海浪潮工贸有限公司">

    <!-- The styles -->
    <link id="bs-css" href="<?php echo base_url('/statics/css/bootstrap-cerulean.min.css'); ?>" rel="stylesheet">

    <link href="<?php echo base_url('/statics/css/charisma-app.css'); ?>" rel="stylesheet">
    <link href='<?php echo base_url('/statics/bower_components/fullcalendar/dist/fullcalendar.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/bower_components/fullcalendar/dist/fullcalendar.print.css'); ?>' rel='stylesheet' media='print'>
    <link href='<?php echo base_url('/statics/bower_components/chosen/chosen.min.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/bower_components/colorbox/example3/colorbox.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/bower_components/responsive-tables/responsive-tables.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/jquery.noty.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/noty_theme_default.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/elfinder.min.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/elfinder.theme.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/jquery.iphone.toggle.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/uploadify.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/animate.min.css'); ?>' rel='stylesheet'>

    <!-- jQuery -->
    <script src="<?php echo base_url('/statics/bower_components/jquery/jquery.min.js'); ?>"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('/statics/js/html5.js'); ?>"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="<?php echo base_url('/statics/img/favicon.ico'); ?>">

</head>

<body>
<div class="ch-container">
    <div class="row">
        
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>上海浪潮工贸有限公司</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-4 center">
            <div id="alert-info" class="alert alert-info" role="alert">
                请用您的用户名密码的登录
            </div>
            <form class="form-horizontal" action="<?php echo site_url('ctl=user&act=do_login');?>" method="post" onsubmit="return do_login();">
                <fieldset>
                    <div id="userdiv" class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                            <input type="text" class="form-control" placeholder="用户名" name="user_name" id="user_name">
                    </div>
                    <div class="clearfix"></div><br>

                    <div id="passworddiv" class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" class="form-control" placeholder="密码" name="password" id="password">
                    </div>
                    <div class="clearfix"></div><br>
                    <div id="mobilediv" class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-phone red"></i></span>
                        <input type="text" class="form-control" placeholder="手机号" name="mobile" id="mobile">
                        <span class="input-group-btn"><button class="btn btn-default" id="captcha_b" type="button" onclick="send_captcha()";>点击获取动态密码</button></span>
                    </div>
                    <span class="help-block" id="captcha_warning" style="color:red;"></span>
                    <div class="clearfix"></div><br>                    
                    <div id="captchadiv" class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-comment red"></i></span>
                        <input type="text" class="form-control" placeholder="动态密码" name="sms_captcha" id="sms_captcha">
                    </div>
                    <div class="clearfix"></div><br>
                    <!--
                    <div class="input-prepend">
                        <label class="remember" for="remember"><input type="checkbox" id="remember"> Remember me</label>
                    </div>
                    -->
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary">登录</button>
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</div>



<script src="<?php echo base_url('/statics/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>

<script src="<?php echo base_url('/statics/js/jquery.cookie.js'); ?>"></script>
<script src="<?php echo base_url('/statics/bower_components/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/bower_components/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/bower_components/fullcalendar/dist/fullcalendar.min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/bower_components/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/js/jquery.dataTables.min.js'); ?>"></script>

<script src="<?php echo base_url('/statics/bower_components/chosen/chosen.jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/bower_components/colorbox/jquery.colorbox-min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/js/jquery.noty.js'); ?>"></script>
<script src="<?php echo base_url('/statics/bower_components/responsive-tables/responsive-tables.js'); ?>"></script>
<script src="<?php echo base_url('/statics/bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/js/jquery.raty.min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/js/jquery.iphone.toggle.js'); ?>"></script>
<script src="<?php echo base_url('/statics/js/jquery.autogrow-textarea.js'); ?>"></script>
<script src="<?php echo base_url('/statics/js/jquery.uploadify-3.1.min.js'); ?>"></script>
<script src="<?php echo base_url('/statics/js/jquery.history.js'); ?>"></script>
<script src="<?php echo base_url('/statics/js/charisma.js'); ?>"></script>

<script type="text/javascript">

var wait = 60;

$(function () {

    $('#user_name').blur(function (){
        if ($('#user_name').val() == '') {
            $("#userdiv").addClass("has-error");
        }else{
            $("#userdiv").removeClass("has-error");
        }

    })

    $('#password').blur(function (){
        if ($('#password').val() == '') {
            $("#passworddiv").addClass("has-error");
        }else{
            $("#passworddiv").removeClass("has-error");
        }

    })

    $('#mobile').blur(function (){
        if ($('#mobile').val() == '') {
            $("#mobilediv").addClass("has-error");
        }else{
            $("#mobilediv").removeClass("has-error");
        }

    })

    $('#sms_captcha').blur(function (){
        if ($('#sms_captcha').val() == '') {
            $("#captchadiv").addClass("has-error");
        }else{
            $("#captchadiv").removeClass("has-error");
        }

    })

    if(getCookie('captcha_staus') == -1){
        var tmp = (Date.parse(new Date()) - getCookie('captcha_time'))/1000;
        if (tmp>wait){
            wait = 0;
        }else{
            wait = wait-tmp;
            $("#captcha_warning").text('验证码有效期为30分钟，请尽快使用！');
        }
        time();        
    }
})

function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg))
 
        return unescape(arr[2]); 
    else 
        return null; 
} 

function send_captcha(){
    var user_name = $("#user_name").val();
    var mobile = $("#mobile").val();
    if(!user_name){
        $("#userdiv").addClass("has-error");
        var n = noty({
              text: "请输入用户名",
              type: 'error',
              layout: 'center',
              timeout: 1000,
        });return false;
    }
    if(!mobile){
        $("#mobilediv").addClass("has-error");
        var n = noty({
              text: "请输入手机号",
              type: 'error',
              layout: 'center',
              timeout: 1000,
        });return false;
    }else{
        $("#mobilediv").removeClass("has-error");
        $.post( 
            "<?php echo site_url('ctl=user&act=send_captcha');?>",
            {user_name:user_name,mobile:mobile},
            function(result){
                if (result=='succ'){
                    $("#alert-info").removeClass("alert-danger");
                    $("#alert-info").removeClass("alert-info");
                    $("#alert-info").addClass("alert-success");
                    $("#alert-info").html('动态密码发送成功');
                    $("#captcha_warning").text('验证码有效期为30分钟，请尽快使用！');
                    
                    document.cookie="captcha_staus=-1";
                    document.cookie="captcha_time="+Date.parse(new Date());
                    time();                      
                }else if(result=='error'){
                    var n = noty({
                          text: "用户名或手机号码错误",
                          type: 'error',
                          layout: 'center',
                          timeout: 1000,
                    });
                }else{
                    $("#alert-info").addClass("alert-danger");
                    $("#alert-info").html('动态密码发送失败');
                }
        });
    }

}



function time(){  
   if (wait == 0) {  
       document.cookie="captcha_staus=1";
       $("#captcha_b").removeAttr("disabled");
       $("#captcha_b").text("点击获取动态密码");  
       wait = 60;  
   } else {  
       $("#captcha_b").attr("disabled", true);  
       $("#captcha_b").text(wait + "秒后,重新获取验证码"); 
       wait--;
       setTimeout(function () { time()},1000);
   }
}


function do_login(){
    user_name = $('#user_name').val();
    password = $('#password').val();
    mobile = $('#mobile').val();
    sms_captcha = $('#sms_captcha').val();
    if (user_name== '') {
            $("#userdiv").addClass("has-error");
            var n = noty({
              text: "请输入用户名",
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
    if (sms_captcha == '') {
            $("#captchadiv").addClass("has-error");
            var n = noty({
              text: "请输入动态验证码",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }

    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=user&act=check_login');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("user_name="+user_name+"&password="+password+"&mobile="+mobile+"&sms_captcha="+sms_captcha);
    var status = xmlhttp.responseText;
    if ("succ" == status){
        return true;
    }else{
        $("#alert-info").addClass("alert-danger");
        $("#alert-info").html('登录失败！请检查您的信息！');
        return false
    }

}



</script>

</body>
</html>

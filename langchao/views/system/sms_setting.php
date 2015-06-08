<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>短信设置</h4></th>
                </tr>               
                <tr>
                    <th>短信平台地址</th>
                    <th>短信平台id</th>
                    <th>短信平台账号</th>
                    <th>短信平台密码</th>
                    <th>是否启用短信登陆验证</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="url" id="url" value="<? echo $sms_info['url'];?>"></td>
                    <td>
                        <input type="text" name="userid" id="userid" value="<? echo $sms_info['userid'];?>">
                    </td>
                    <td> <input type="text" name="account" id="account" value="<? echo $sms_info['account'];?>"></td>
                    <td> <input type="text" name="passwd" id="passwd" value="<? echo $sms_info['passwd'];?>"></td>
                    <td>
                        启用<input type="radio" name="status" id="status" value="1" <?if($sms_info['status']=="1"){echo "checked";}?> />
                        不启用<input type="radio" name="status" id="status" value="0" <?if($sms_info['status']==0){echo "checked";}?> />
                    </td>

                    <td><a class="btn btn-info doedit">保存</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">

$(function() {

        $(".doedit").click(function() {
            _self = this;
            url = $("#url").val();
            userid = $("#userid").val();
            account = $("#account").val();
            passwd = $("#passwd").val();
            //status = $("#status").val();
            status = $("input[name='status']:checked").val();
            if(!url || !userid || !account || !passwd || !status){
                var n = noty({
                  text: "不能有空值",
                  type: 'error',
                  layout: 'center',
                  timeout: 1000,
                });
                return false;
            }
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST","<?php echo site_url('ctl=system&act=do_sms_setting');?>",false);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("userid="+userid+"&account="+account+"&passwd="+passwd+"&status="+status+"&url="+url);
            var result = xmlhttp.responseText;
            if(result =="succ"){
                var n = noty({
                  text: "修改成功",
                  type: 'success',
                  layout: 'center',
                  timeout: 1000,
                });
            }else{
                var n = noty({
                  text: "修改失败",
                  type: 'error',
                  layout: 'center',
                  timeout: 1000,
                });
                return false;
            }                    
        })

})
</script>
 
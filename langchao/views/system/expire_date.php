<div class="row">
    <div class="box col-md-7">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>事件有效期设置</h4></th>
                </tr>               
                <tr>
                    <th>名称</th>
                    <th>天数</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>事件有效期</td>
                    <td>
                        <input type="text" name="expire_date" id="expire_date" value="<? echo $expire_date;?>">
                    </td>
                    <td><a class="btn btn-info doedit">编辑</a>
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
            expire_date = $("#expire_date").val();
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST","<?php echo site_url('ctl=system&act=edit_expire_date');?>",false);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("expire_date="+expire_date);
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
 
<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_setting_add');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return do_add();">
<div class="col-lg-7 col-md-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">名称</th>
                <td>
                    <input type="text" placeholder="名称" name="name" id="name">
                </td>
            </tr>
            <tr>
                <th width="80px">类型</th>
                <td>
                    <select name="type" id="type">
                        <option value="city">地区</option>
                        <option value="custom">客户类型</option>
                        <option value="department">部门</option>
                        <option value="position">职位</option>
                        <option value="worktime">工作时间</option>
                        <option value="performance">绩效完成率</option>
                        <option value="filetype">文档类型</option>
                        <option value="membertype">客户属性</option>
                        <option value="traffic">交通方式</option>
                    </select>                    
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




<script type="text/javascript">


function do_add(){
    name = $('#name').val();
    type = $("#type ").val(); 
    if (name== '') {
            $("#userdiv").addClass("has-error");
            var n = noty({
              text: "请输入名称",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=system&act=check_setting_name');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("name="+name+"&type="+type);
    var status = xmlhttp.responseText;
    if (false == status){
        return true;
    }else{
        var n = noty({
          text: "名称已存在！",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false
    }    
}


</script>
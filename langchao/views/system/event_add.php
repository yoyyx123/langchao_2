
<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_event_add');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return do_add();">
<div class="col-lg-7 col-md-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">类型</th>
                <td>
                    <input type="text" placeholder="事件类型/故障分类" name="name" id="name">
                </td>
            </tr>
            <tr>
                <th width="80px">适用部门</th>
                <td>
                    <select name="department_id" id="department_id">
                        <option value="all">全部</option>
                        <?php foreach ($department_list as $key => $value) {?>
                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
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
    if (name== '') {
            $("#userdiv").addClass("has-error");
            var n = noty({
              text: "请输入城市名称",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=system&act=check_event_name');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("name="+name);
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

<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_role_edit');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">角色名称</th>
                <td>
                    <input type="text" placeholder="角色名称" name="role_name" id="role_name" value="<?php echo $role['role_name']?>">
                </td>
            </tr>
            <tr>
                <th width="80px">角色身份</th>
                <td>
                    <select type="text" name="position2" id="position2">
                        <option value="1" <? if($role['position2']=='1'){echo "selected=selected";}?>>员工</option>
                        <option value="2" <? if($role['position2']=='2'){echo "selected=selected";}?>>部门经理</option>
                        <option value="3" <? if($role['position2']=='3'){echo "selected=selected";}?>>总经理</option>
                        <option value="4" <? if($role['position2']=='4'){echo "selected=selected";}?>>管理员</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>角色简介</th>
                <td>
                    <textarea type="text" placeholder="角色简介" name="role_memo" id="role_memo"><?php echo $role['role_memo']?></textarea>
                </td>
            </tr>
            <tr>
                <th width="80px">角色权限</th>
                <td>
                    <div class="box-content">
                        <?php foreach ($role['ctl'] as $key => $value) {?>
                           <div class="checkbox-group">
                                <input class="sel-handle f_radio_all" type="checkbox" value="<?echo $value['id']?>" <?php if ($value['sel']=="1") echo "checked"; ?> name="ctl[]">
                                <?php echo $value['name']?>
                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php foreach ($value['ctl_child'] as $k => $v) {?>
                                    <input class="f_radio_one" type="checkbox" value="<?echo $v['id']?>" <?php if ($v['sel']=="1") echo "checked"; ?> name="ctl[]"><?echo $v['name']?>
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
        <input type="hidden" name="role_id" id="role_id" value="<?php echo $role['id']?>">
        <button type="submit" class="btn btn-primary">修改</button>
</form>         

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
</script>

<form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_setting_edit');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="80px">城市名称</th>
                <td>
                    <input type="text" placeholder="角色名称" name="name" id="name" value="<?php echo $role['name']?>">
                </td>
            </tr>
            <tr>
                <th width="80px">类型</th>
                <td>
                    <select name="type" id="type">
                        <option value="city" <?php if($role['type']=="city") echo "selected='selected'"; ?>>地区</option>
                        <option value="custom" <?php if($role['type']=="custom") echo "selected='selected'"; ?>>客户类型</option>
                        <option value="department" <?php if($role['type']=="department") echo "selected='selected'"; ?>>部门</option>
                        <option value="worktime" <?php if($role['type']=="worktime") echo "selected='selected'"; ?>>工作时间</option>
                        <option value="performance" <?php if($role['type']=="performance") echo "selected='selected'"; ?>>绩效完成率</option>
                        <option value="filetype" <?php if($role['type']=="filetype") echo "selected='selected'"; ?>>文档类型</option>
                        <option value="membertype" <?php if($role['type']=="membertype") echo "selected='selected'"; ?>>客户属性</option>
                        <option value="position" <?php if($role['type']=="position") echo "selected='selected'"; ?>>职位</option>
                    </select>                    
                </td>
            </tr> 
        </tbody>
    </table>
        <input type="hidden" name="id" id="id" value="<?php echo $role['id']?>">
        <button type="submit" class="btn btn-primary">修改</button>
</form>
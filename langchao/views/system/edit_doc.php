<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i></i></h2>
            </div>
            <div class="box-content row">
                <form class="form-horizontal" action="<?php echo site_url('ctl=system&act=do_edit_doc');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return doedit();">
                <div class="col-lg-12 col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>文档名称</td>
                                <td>
                                    <div id="namediv" class="input-group col-xs-4">
                                    <input type="text" placeholder="姓名" name="name" id="namex" value="<?echo $doc_info['name'];?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>所属部门</td>
                                <td>
                                    <div id="departmentdiv" class="input-group col-xs-4">
                                        <select name="department">
                                            <?foreach ($department_list as $key => $value) {?>
                                                <option value = "<?echo $value['id'];?>" <?if($value['id']==$doc_info['department']){echo "selected=selected";}?>><?echo $value['name'];?></option>
                                            <?}?>                                            
                                        </select>
                                    </div>
                                </td>
                            </tr>                            
                        </tbody>
                    </table>
                </div>
                <input type="hidden" value="<?echo $doc_info['id'];?>" name="id">
                <div class="col-lg-7 col-md-4">
                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary">修改</button>
                    </p>
                </div> 
            </form>         
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


function doedit(){
    name = $('#namex').val();
    if (name== '') {
            $("#namediv").addClass("has-error");
            var n = noty({
              text: "请输入文档名称",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    return true;    
}


</script>
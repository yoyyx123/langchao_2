<div>
    <ul class="breadcrumb">
        <li>
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
                <form class="form-horizontal" action="<?php echo site_url('ctl=member&act=do_add');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="return do_add();">
                <div class="col-lg-7 col-md-4">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="110px">客户编号</td>
                                <td>
                                    <div id="codediv" class="input-group col-xs-8">
                                    <input type="text"  class="form-control" placeholder="客户编号" readonly="readonly" name="code" id="code" value="<?echo $code;?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>客户全称</td>
                                <td>
                                    <div id="namediv" class="input-group col-xs-8">
                                    <input type="text"  class="form-control" placeholder="客户全称" name="name" id="name">
                                    </div>                                    
                                </td>
                            </tr>
                            <tr>
                                <td width="80px">客户简称</td>
                                <td>
                                    <div id="short_namediv" class="input-group col-xs-8">
                                    <input type="text"  class="form-control" placeholder="客户简称" name="short_name" id="short_name">
                                    </div>
                                </td>
                            </tr>                          
                            <tr>
                                <td>客户所属地</td>
                                <td>
                                    <div id="citydiv" class="input-group col-xs-8">
                                    <select name="city" id="city" class="form-control">                                        
                                       <?php foreach ($city_list as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>                                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>客户属性</td>
                                <td>
                                    <div id="member_typediv" class="input-group col-xs-8">
                                    <select name="member_type" id="member_type"  class="form-control">
                                       <?php foreach ($member_type as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </td>
                            </tr> 
                            <tr>
                                <td>地址</td>
                                <td>
                                    <div id="addrdiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="地址" name="addr" id="addr">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>公交/地铁</td>
                                <td>
                                    <div id="busdiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="公交/地铁" name="bus" id="bus">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>客户联系人</td>
                                <td>
                                    <div id="contactsdiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="客户联系人" name="contacts" id="contacts">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>联系电话</td>
                                <td>
                                    <div id="mobilediv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="联系电话" name="mobile" id="mobile">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>传真</td>
                                <td>
                                    <div id="faxdiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="传真" name="fax" id="fax">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>工程项目负责人</td>
                                <td>
                                    <div id="project_mandiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="工程项目负责人" name="project_man" id="project_man">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>联系电话</td>
                                <td>
                                    <div id="project_mobilediv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="联系电话" name="project_mobile" id="project_mobile">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>日常业务负责人</td>
                                <td>
                                    <div id="business_mandiv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="日常业务负责人" name="business_man" id="business_man">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>联系电话</td>
                                <td>
                                    <div id="business_mobilediv" class="input-group col-xs-8">
                                    <input type="text" class="form-control" placeholder="联系电话" name="business_mobile" id="business_mobile">
                                    </div>
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
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(function () {

})

function do_add(){
    code = $('#code').val();
    name = $('#name').val();
    short_name = $('#short_name').val();
    city = $('#city').val();
    member_type = $('#member_type').val();
    addr = $('#addr').val();
    bus = $('#bus').val();
    contacts = $('#contacts').val();
    mobile = $('#mobile').val();
    fax = $('#fax').val();
    project_man = $('#project_man').val();
    project_mobile = $('#project_mobile').val();
    project_mobile = $('#business_man').val();
    project_mobile = $('#business_mobile').val();

    if (code== '') {
            $("#codediv").addClass("has-error");
            var n = noty({
              text: "请输入客户编号",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (name== '') {
            $("#namediv").addClass("has-error");
            var n = noty({
              text: "请输入客户全称",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }        
    if (short_name == '') {
            $("#short_namediv").addClass("has-error");
            var n = noty({
              text: "请输入客户简称",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (city == '') {
            $("#citydiv").addClass("has-error");
            var n = noty({
              text: "请输入客户所属地",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (member_type == '') {
            $("#member_typediv").addClass("has-error");
            var n = noty({
              text: "请输入客户属性",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (addr == '') {
            $("#addrdiv").addClass("has-error");
            var n = noty({
              text: "请输入地址",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }

    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=member&act=check_code');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("code="+code);
    var status = xmlhttp.responseText;
    if (false == status){
        return true;
    }else{
        var n = noty({
          text: "客户编号已存在！",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false
    }    
}


</script>
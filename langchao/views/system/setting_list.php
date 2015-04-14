<div class="row">
    <ul class="breadcrumb">
        <li>
            <a class="btn btn-primary doadd">添加信息</a>
        </li>
    </ul>
</div>
<div class="row" style="text-align:center;">
     <h2>信息管理</h2>
</div>
<div class="row"> 
    <div class="box col-md-2">
        <input class="form-control" id="search" name="search" type="text">
    </div>
    <div class="box col-md-2">        
        <a class="btn btn-info do_search">搜索</a>
    </div>
</div>
<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2">选择类型：</th>
                    <th>
                        <select class="form-control type">
                            <option value="all" <?if(isset($type)&&$type=='all'){echo "selected=selected";}?>>全部</option>
                            <option value="city" <?if(isset($type)&&$type=='city'){echo "selected=selected";}?>>地区</option>
                            <option value="custom" <?if(isset($type)&&$type=='custom'){echo "selected=selected";}?>>客户类型</option>
                            <option value="department" <?if(isset($type)&&$type=='department'){echo "selected=selected";}?>>部门</option>
                            <option value="worktime" <?if(isset($type)&&$type=='worktime'){echo "selected=selected";}?>>工作时间</option>
                            <option value="performance" <?if(isset($type)&&$type=='performance'){echo "selected=selected";}?>>绩效完成率</option>
                            <option value="filetype" <?if(isset($type)&&$type=='filetype'){echo "selected=selected";}?>>文档类型</option>
                            <option value="position" <?if(isset($type)&&$type=='position'){echo "selected=selected";}?>>职位</option>
                            <option value="membertype" <?if(isset($type)&&$type=='membertype'){echo "selected=selected";}?>>客户属性</option>
                            <option value="traffic" <?if(isset($type)&&$type=='traffic'){echo "selected=selected";}?>>交通方式</option>
                        </select>
                    </th>
                    <th>
                    </th>
                </tr>
                <tr>
                    <th>序号</th>
                    <th>名称</th>
                    <th>类型</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($list as $key => $value) { if($value['type'] !='expire_date'){?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $value['name'];?></td>
                    <td>
                        <div class="box col-md-5">                 
                            <?php 
                                if($value['type']=="city"){echo "地区";}
                                if($value['type']=="custom"){echo "客户类型";}
                                if($value['type']=="department"){echo "部门";}
                                if($value['type']=="worktime"){echo "工作时间";}
                                if($value['type']=="performance"){echo "绩效完成率";}
                                if($value['type']=="filetype"){echo "文档类型";}
                                if($value['type']=="position"){echo "职位";}
                                if($value['type']=="membertype"){echo "客户属性";}
                                if($value['type']=="traffic"){echo "交通方式";}                                
                             ?>
                        </div>
                    </td>
                    <td><a class="btn btn-info doedit" setting_id='<?php echo $value['id'];?>'>编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-danger dodelete" setting_id='<?php echo $value['id'];?>'>删除</a>
                    </td>
                </tr>
                
                <?php $i++;}} ?>

            </tbody>
            <tbody>
                <tr>
                    <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url("ctl=system&act=setting_list");?>';
    var getobj = {};
    getobj.type=$('.type').val();
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

$(function() {

        $(".type").change(function(){
            _self = this;
            var url = '<?php echo site_url("ctl=system&act=setting_list");?>';
            url = url+"&type="+$('.type').val();
            window.location.href = url;
        })

        $(".do_search").click(function(){
            var url = '<?php echo site_url("ctl=system&act=setting_list");?>';
            if ($('#search').val() == '' ) {
                var n = noty({
                  text: "搜索内容必填",
                  type: 'error',
                  layout: 'center',
                  timeout: 1000,
                });
                return false;
                }
            url = url+"&is_search=1&search="+$('#search').val();                
            window.location.href = url;
        })

        $(".dodelete").click(function() {
         if(confirm("确认删除吗")){
            _self = this;
            url = "<?php echo site_url(array('ctl'=>'system', 'act'=>'setting_delete'))?>"+"&id="+$(this).attr('setting_id'),
            window.location.href=url;
         }else{
            return;
         }
        });

        $(".doadd").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'setting_add'))?>",
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('添加部门'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });

        $(".doedit").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'system', 'act'=>'setting_edit'))?>"+"&id="+$(this).attr('setting_id'),
                data: "",
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('编辑部门'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });
         $(".dialog_close").click(function() {
            alert(1111);
            //$(this).dialog('close');
         });

})
</script>
 
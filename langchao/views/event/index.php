<div class="row" style="text-align:center;">
     <h2>事件开设</h2>
</div>
<div class="row">
    <div class="box col-md-12">
        <form class="form-inline">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">客户简称</div>
              <input class="form-control" type="text" placeholder="" name="short_name" id="short_name">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">客户编号</div>
              <input class="form-control" type="text" placeholder="" name="code" id="code">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">客户联系人</div>
              <input class="form-control" type="text" placeholder="" name="contacts" id="contacts">
            </div>
          </div>
        &nbsp&nbsp<a class="btn btn-info do_search" member_id='<?php echo $value['id'];?>'>查询</a>
        </form>
    </div>
</div>

<div class="row member_info" id="member_info">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>客户列表</th>
                    <th colspan="7"></th>
                </tr>                
                <tr>
                    <th>序号</th>
                    <th>客户编号</th>
                    <th>客户简称</th>
                    <th>客户联系人</th>
                    <th>联系电话</th>
                    <th>客户属性</th>
                    <th>客户所属地</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($member_list as $key => $value) {?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $value['code'];?></td>
                    <td><?php echo $value['short_name'];?></td>
                    <td><?php echo $value['contacts'];?></td>
                    <td><?php echo $value['mobile'];?></td>
                    <td><?php echo $value['member_type_name'];?></td>
                    <td><?php echo $value['city_name'];?></td>
                    <td><a class="btn btn-primary do_add" member_id='<?php echo $value['id'];?>'>确认</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <?php $i++;} ?>
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
$(function() {

        $(".do_add").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'add_event'))?>",
                data: "&id="+$(this).attr('member_id'),
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('事件开设'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });

        $(".do_search").click(function() {
            _self = this;
            short_name = $('#short_name').val();
            code = $('#code').val();
            contacts = $('#contacts').val();
            if (short_name == '' && code == '' && contacts == '' ) {
                    var n = noty({
                      text: "三项中必须填写一项",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'member', 'act'=>'do_search'))?>",
                data: "is_event=1&short_name="+short_name+"&code="+code+"&contacts="+contacts,
                success: function(result){
                    $("#member_info").html(result);
                }
             });
        });        

})

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url("ctl=event&act=index");?>';
    var getobj = {};
    //getobj.from_node_id=$('#from_node_id_searsh').val();
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}
</script>
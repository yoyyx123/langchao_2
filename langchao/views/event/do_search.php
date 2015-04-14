<div class="box col-md-12">
    <?php
    if(isset($event_list)&&!empty($event_list)){
    ?>    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>事件列表</th>
                <th colspan="2">使用人：<?php echo $user['name'];?></th>
                <th colspan="7"></th>
            </tr>                    
            <tr>
                <th>序号</th>
                <th>日期、时间</th>
                <th>客户简称</th>
                <th>事件类型</th>
                <th>事件描述</th>
                <th>工单</th>
                <th>费用</th>
                <th>有效期</th>
                <th colspan="2">操作</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($event_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['event_time'];?></td>
                <td><?php echo $value['short_name'];?></td>
                <td><?php echo $value['event_type_name'];?></td>
                <td><?php echo $value['desc'];?></td>
                <td><?php echo $value['work_order_num'];?></td>
                <td></td>
                <td><?php echo $value['event_less_time'];?></td>
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=add_work_order')."&event_id=".$value['id'];?>" >添加工单</a></td>
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=edit_work_order')."&event_id=".$value['id'];?>">查看</a></td>
            </tr>
            <? } ?>
        </tbody>
        
        <tbody>
            <tr>
                <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
            </tr>
        </tbody>

        <input type="hidden" name = "user_id" id = "user_id" value="<?echo $user_id;?>">
        <input type="hidden" name = "event_time" id = "event_time" value="<?echo $event_time;?>"> 
        <input type="hidden" name = "status" id = "status" value="<?echo $status;?>">     
    </table>
<?php }else{?>
<p>查询不到事件信息!</p>
<?php }?>  
</div>
<script type="text/javascript">

var sel_time_data = function (per_page) {
    user_id = $('#user_id').val();
    event_time = $('#event_time').val();
    status = $('#status').val();    
    var url = '<?php echo site_url('ctl=event&act=do_search');?>'+"&is_event=1&user_id="+user_id+"&event_time="+event_time+"&status="+status;
    var getobj = {};
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

$(function() {

    $(".do_add").click(function() {
        _self = this;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'add_work_order'))?>",
            data: "event_id="+$(this).attr('event_id'),
            success: function(result){
                $("#dialog").html(result);
                $("#dialog").dialog({
                    autoOpen : false,
                    width : 700,
                    title : ('工单信息'),
                    modal: true,

                });
                $("#dialog").dialog("open");
            }
         });
    });
})
</script>
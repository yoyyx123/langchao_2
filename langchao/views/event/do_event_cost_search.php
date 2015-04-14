<div class="box col-md-12">
    <?php
    if(isset($month_list)&&!empty($month_list)){
    ?>    
    <table class="table table-bordered">
        <thead>            
            <tr>
                <th>序号</th>
                <th>使用人</th>
                <th>月份</th>
                <th>状态</th>
                <th>预报销总额</th>
                <th>操作</th>
                <th>实际报销总额</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($month_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['user_name'];?></td>
                <td><?php echo $key;?></td>
                <td><?if($value['cost_status']==1){echo "未审核";}elseif($value['cost_status']==2){echo "待报销";}elseif($value['cost_status']==3){echo "已报销";}?></td>
                <td><?php echo $value['total_fee'];?></td>              
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=get_event_biil_list')."&user_id=".$value['user_id']."&event_month=".$key;?>">查看</a></td>
                <td><?php echo $value['rel_total_fee'];?></td>
            </tr>
            <? } ?>
        </tbody>
    </table>
<?php }else{?>
<p>查询不到事件信息!</p>
<?php }?>  
</div>
<script type="text/javascript">
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
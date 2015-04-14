<div class="box col-md-12">
    <?php
    if(isset($event_list)&&!empty($event_list)){
    ?>    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>事件列表</th>
                <th colspan="2"><?if($title=="user"){echo"使用人：".$user['name'];}elseif($title=="member"){echo"客户简称：".$member['short_name'];}?></th>
                <th colspan="7"></th>
            </tr>                    
            <tr>
                <th>序号</th>
                <th>日期、时间</th>
                <th>客户简称/使用人</th>
                <th>事件类型</th>
                <th>事件描述</th>
                <th>报修症状</th>
                <th>故障分析</th>
                <th>解决方案</th>
                <th>事件状态</th>
                <th>报销状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($event_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['event_time'];?></td>
                <td><?php echo $value['short_name'];?>/<?php echo $value['user_name'];?></td>
                <td><?php echo $value['event_type_name'];?></td>
                <td><?php echo $value['desc'];?></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?if($value['status']==1){echo "待添加";}elseif($value['status']==2){echo "待审核";}elseif($value['status']==3){echo "已审核";}?></td>
                <td></td>                
                <td><a class="btn btn-primary" href="<?php echo site_url('ctl=event&act=edit_work_order')."&event_id=".$value['id'];?>">查看</a></td>
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
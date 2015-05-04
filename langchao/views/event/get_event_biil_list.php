<div class="row" style="text-align:center;">
     <h2>费用审核</h2>
</div>

<div class="row member_info" id="member_info">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>月份</th>
                    <th><? echo $event_month;?></th>
                    <th>使用人</th>
                    <th><?echo $user_info['name']?></th>
                    <th>合计</th>
                    <th><?echo $total;?></th>
                    <th>
                        <?if($is_cost !=1){?>
                            <a class="btn btn-primary change_event_status" id="change_event_status">进行报销</a>
                        <?}else{?>
                            <a class="btn btn-info change_event_status" id="change_event_status">已报销</a>
                        <?}?>
                    </th>
                    <th colspan="13"></th>
                </tr>                
                <tr>
                <th>序号</th>
                <th>日期</th>
                <th>出发时间</th>
                <th>到达时间</th>
                <th>起始地</th>
                <th>目的地</th>
                <th>交通方式</th>
                <th>交通费</th>
                <th>交通确认金额</th>
                <th>住宿费</th>
                <th>住宿确认金额</th>
                <th>加班餐费</th>
                <th>餐费确认金额</th>
                <th>其他费用</th>
                <th>其他确认金额</th>
                <th>备注</th>
                <th>单据编号</th>
                <th>事件关联</th>
                <th>审核</th>
                <th>小计</th>                
                </tr>
            </thead>
            <tbody>
                <? $i=1; foreach ($bill_list as $key => $val) {?>
                <tr align="center" id="1">
                    <td><?echo $i;?></td>
                    <td><?echo $val['date2'];?></td>
                    <td><?echo $val['go_time'];?></td>
                    <td><?echo $val['arrival_time'];?></td>
                    <td><?echo $val['start_place'];?></td>
                    <td><?echo $val['arrival_place'];?></td>
                    <td><?echo $val['transportation_name'];?></td>
                    <td><?echo $val['transportation_fee'];?></td>
                    <td><input type="text" style="width:60px" name="rel_transportation" id="rel_transportation" value="<?echo $val['rel_transportation'];?>"></td>
                    <td><?echo $val['hotel_fee'];?></td>
                    <td><input type="text" style="width:60px" name="rel_hotel" id="rel_hotel" value="<?echo $val['rel_hotel'];?>"></td>
                    <td><?echo $val['food_fee'];?></td>
                    <td><input type="text" style="width:60px" name="rel_food" id="rel_food" value="<?echo $val['rel_food'];?>"></td>
                    <td><?echo $val['other_fee'];?></td>
                    <td><input type="text" style="width:60px" name="rel_other" id="rel_other" value="<?echo $val['rel_other'];?>"></td>
                    <td><?echo $val['memo'];?></td>
                    <td><?echo $val['bill_no'];?></td>
                    <td><a class="btn btn-primary do_look"  bill_id="<?echo $val['id'];?>" href="<?php echo site_url('ctl=event&act=look_work_order&event_id='.$val["event_id"]);?>" target="_blank">查看</a></td>
                    <?if($val['status'] !=2){?>
                        <td><a class="btn btn-info do_check" bill_id="<?echo $val['id'];?>" id="do_check">审核</a></td>
                    <?}else{?>
                        <td><a class="btn btn-primary do_check" bill_id="<?echo $val['id'];?>" id="do_check">已审核</a></td>
                    <?}?>
                    <td><div id="xiaoji" <?if($val['status'] !=2){echo "style='display:none'";}?>><?echo $val['bill_total'];?></div></td>                    
                </tr>
                <? $i++;}?>
                <tr>
                    <td colspan="19"></td>
                    <td><a class="btn btn-info do_check_all" bill_id="<?echo $val['id'];?>" id="do_check_all">一键审核</a></td>
                    
   
                </tr>
            </tbody>
        </table>
        <input class="event_month" type="hidden" value="<?php echo $event_month;?>">
        <input class="user_id" type="hidden" value="<?php echo $user_info["id"];?>">
    </div>
</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
$(function() {
        $(".do_check_all").click(function(){
            if(!confirm("确定要审核全部")){
                    return false;
                }
            event_month = $('.event_month').val();
            user_id = $('.user_id').val();
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST","<?php echo site_url('ctl=event&act=check_all_bill_order');?>",false);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("event_month="+event_month+"&user_id="+user_id+"&status=2");
            var result = xmlhttp.responseText;
            var data = eval("("+result+")");
            if ("succ" == data.status){
                var n = noty({
                  text: "全部审核成功！",
                  type: 'success',
                  layout: 'center',
                  timeout: 1000,
                });
                window.location.reload();
                //return true;
            }
        })
        $(".change_event_status").click(function() {
            _self = this;
            event_month = $('.event_month').val();
            user_id = $('.user_id').val();
            var value = $(".change_event_status").html();
            if ("进行报销" == value){
                if(!confirm("确认要报销")){
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'change_event_cost_status'))?>",
                    data: "event_month="+event_month+"&user_id="+user_id+"&status=3",
                    success: function(result){
                        if(result="succ"){
                            $("#change_event_status").removeClass("btn-primary");
                            $("#change_event_status").addClass("btn-info");
                            $("#change_event_status").html("已报销");
                        }
                    }
                 });                
            }
            if ("已报销" == value){
                if(!confirm("确认要取消报销")){
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'change_event_cost_status'))?>",
                    data: "event_month="+event_month+"&user_id="+user_id+"&status=2",
                    success: function(result){
                        if(result="succ"){
                            $("#change_event_status").removeClass("btn-info");
                            $("#change_event_status").addClass("btn-primary");
                            $("#change_event_status").html("进行报销");
                        }
                    }
                 });                
            }

        });

        $(".do_check").click(function() {
            _self = this;
            var id = $(this).attr('bill_id');
            var rel_transportation = $(this).parent().parent().find("#rel_transportation").val();
            var rel_hotel = $(this).parent().parent().find("#rel_hotel").val();
            var rel_food = $(this).parent().parent().find("#rel_food").val();
            var rel_other = $(this).parent().parent().find("#rel_other").val();
            var xiaoji = $(this).parent().parent().find("#xiaoji");
            
            var params = "status=2&id="+id;
            if (rel_transportation||rel_hotel||rel_food||rel_other){
                params = params+"&rel_transportation="+rel_transportation+"&rel_hotel="+rel_hotel+"&rel_food="+rel_food+"&rel_other="+rel_other;
            }
            var value = $(_self).parent().find("#do_check").html();
            if ("审核" == value){
                if(confirm("确认要审核")){
                    params = params+"&status=2";
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'update_bill_order_status'))?>",
                        data: params,
                        success: function(result){
                            if(result=="succ"){
                                //$(_self).parent().find("#do_check").removeClass("do_check");
                                $(_self).parent().find("#do_check").removeClass("btn-info");
                                $(_self).parent().find("#do_check").addClass("btn-primary");
                                $(_self).parent().find("#do_check").html("已审核");
                                xiaoji.removeAttr("style");
                                location.reload();
                            }
                        }
                     });
                }                
            }
            if ("已审核" == value){
                if(confirm("确认要取消审核")){
                    params = params+"&status=1";
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url(array('ctl'=>'event', 'act'=>'update_bill_order_status'))?>",
                        data: params,
                        success: function(result){
                            if(result=="succ"){
                                //$(_self).parent().find("#do_check").removeClass("do_check");
                                $(_self).parent().find("#do_check").removeClass("btn-primary");
                                $(_self).parent().find("#do_check").addClass("btn-info");
                                $(_self).parent().find("#do_check").html("审核");
                                xiaoji.attr("style","display:none");
                                location.reload();
                            }
                        }
                     });                
                }                
            }            

        });        

})
</script>

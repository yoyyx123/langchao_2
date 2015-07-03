<style type="text/css">
input{width:95px;}
select{width:60px;}
</style>



<? $i=0;foreach ($work_order_list as $key => $value) {
    $i++;
?>
<form class="form-horizontal-<?echo $i;?>" action="<?php echo site_url('ctl=event&act=do_edit_work_order');?>" method="post"  onsubmit="return do_add();">

<div class="box col-lg-12 col-md-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>事件类型</th>
                <td>
                    <?echo $event['event_type_name']; ?>
                </td>
                <th>客户部门</th>
                <td>
                    <input type="text" style="width:160px" name="custom_department" id="custom_department" value="<?echo $value['custom_department'];?>">
                </td>
            </tr>
            <tr>
                <th>到达时间(签到)</th>
                <td>
                    <input type="text" style="width:160px" class="format_time" name="arrive_time" id="arrive_time" value="<?echo $value['arrive_time'];?>">
                </td>
                <th>离场时间(签退)</th>
                <td>
                    <input type="text" style="width:160px" class="format_time" name="back_time" id="back_time" value="<?echo $value['back_time'];?>">
                </td>
            </tr>
            <tr>
                <th>保修症状</th>
                <td colspan="3">
                    <textarea  name="symptom"  rows="3" cols="50"><?echo $value['symptom'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>故障分类</th>
                <td>
                   日常<input type="radio" name="failure_mode" id="failure_mode" value="0" <?if($value['failure_mode']==0){?>checked="checked"<?}?> />
                </td>
                <td>
                   软件<input type="radio" name="failure_mode" id="failure_mode" value="1" <?if($value['failure_mode']==1){?>checked="checked"<?}?> />
                </td>
                <td>
                   硬件<input type="radio" name="failure_mode" id="failure_mode" value="2" <?if($value['failure_mode']==2){?>checked="checked"<?}?>/>
                </td>
            </tr>
            <tr>
                <th>故障等级</th>
                <td>
                   一级<input type="radio" name="failure_level" id="failure_level" value="0" <?if($value['failure_level']==0){echo 'checked="checked"';}?>>
                </td>
                <td>
                   二级<input type="radio" name="failure_level" id="failure_level" value="1" <?if($value['failure_level']==1){echo 'checked="checked"';}?>>
                </td>
                <td>
                   三级<input type="radio" name="failure_level" id="failure_level" value="2" <?if($value['failure_level']==2){echo 'checked="checked"';}?>>
                </td>
            </tr>
            <tr>
                <th>故障分析</th>
                <td colspan="3">
                    <textarea name="failure_analysis" id="failure_analysis" rows="3" cols="50"><?echo $value['failure_analysis'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>风险预测</th>
                <td colspan="3">
                    <textarea  name="risk_profile" id="risk_profile" rows="3" cols="50" ><?echo $value['risk_profile'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>解决方案</th>
                <td colspan="3">
                    <textarea  name="solution" id="solution" rows="3" cols="50" ><?echo $value['solution'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>使用人描述</th>
                <td colspan="3">
                    <textarea  name="desc" id="desc" rows="3" cols="50" ><?echo $value['desc'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>事件反馈</th>
                <td>
                   已完成<input type="radio" name="schedule" id="schedule" value="0" <?if($value['schedule']==0){echo 'checked="checked"';}?>>
                </td>
                <td>
                   部分完成<input type="radio" name="schedule" id="schedule" value="1" <?if($value['schedule']==1){echo 'checked="checked"';}?>>
                </td>
                <td>
                   未完成<input type="radio" name="schedule" id="schedule" value="2" <?if($value['schedule']==2){echo 'checked="checked"';}?>>
                </td>
            </tr>
            <tr>
                <th>备注</th>
                <td colspan="3">
                    <textarea  name="memo" id="memo" rows="3" cols="50"><?echo $value['memo'];?></textarea>
                </td>
            </tr>

        </tbody>
    </table>

</div>
<input type="hidden" name="back_url" value="<?php echo $back_url;?>">
<div class="col-lg-7 col-md-4">
    <p class="center col-md-12">
        <input type="hidden" id="work_order_id" name="work_order_id" value="<?echo $value['id']; ?>">
        <input type="hidden" id="event_id" name="event_id" value="<?echo $event['id']; ?>">
        <input type="hidden" id="event_time" value="<?echo $event['event_time']; ?>">
        <button type="submit" class="btn btn-primary">编辑</button>&nbsp&nbsp&nbsp
        <button type="button" class="btn btn-info delete_work_order">删除</button>&nbsp&nbsp&nbsp
        <a class="btn btn-info" href="<?php echo $back_url;?>">返回</a>
    </p>
</div>
</form>
<div class="row">
<div class="col-sm-12 col-md-12">
    <input type="hidden" id="work_order_id_2" name="work_order_id_2" value="<?echo $value['id']; ?>">

    <table class="table-bordered table-striped table-condensed">
        <thead>
            <tr class="CaseRow">
                <th align="center" colspan="15">去程费用</th>
            </tr>
            <tr class="CaseRow">
                <th>序号</th>
                <th>出发时间</th>
                <th>到达时间</th>
                <th>起始地</th>
                <th>目的地</th>
                <th>交通方式</th>
                <th>交通费</th>
                <th>住宿费</th>
                <th>加班餐费</th>
                <th>其他费用</th>
                <th>备注</th>
                <th>业务员</th>
                <th>单据编号</th>
                <th colspan="2"><a class="btn btn-info" type_id ="0" onclick="add_td(this)">添加一行</a></th>
            </tr>
        </thead>
        <tbody>
            <?if (isset($value['bill_order_list']) && !empty($value['bill_order_list'])){?>
                <? $i=1; foreach ($value['bill_order_list'] as $key => $val) {?>
                <?if($val['type']==0){?>
                <tr align="center" id="<?echo $i;?>">
                    <td><?echo$i;?></td>
                    <td><input type="text" name="go_time" class="format_time" style="width:135px" id="go_time" value="<?echo $val['go_time'];?>"></td>
                    <td><input type="text" name="arrival_time" class="format_time" style="width:135px" id="arrival_time" value="<?echo $val['arrival_time'];?>"></td>
                    <td><input type="text" name="start_place" id="start_place" value="<?echo $val['start_place'];?>"></td>
                    <td><input type="text" name="arrival_place" id="arrival_place" value="<?echo $val['arrival_place'];?>"></td>
                    <td>
                        <select name="transportation" id="transportation">
                            <?foreach ($traffic_list as $k => $tmp) {?>
                            <option value="<?echo $tmp['id'];?>" <?if($val['transportation']==$tmp['id']){echo "selected=selected";}?>><?echo $tmp['name'];?></option>
                            <?}?>
                        </select>
                    </td>
                    <td><input type="text" name="transportation_fee" id="transportation_fee" style="width:45px" value="<?echo $val['transportation_fee'];?>"></td>
                    <td><input type="text" name="hotel_fee" id="hotel_fee" style="width:45px" value="<?echo $val['hotel_fee'];?>"></td>
                    <td><input type="text" name="food_fee" id="food_fee" style="width:45px" value="<?echo $val['food_fee'];?>"></td>
                    <td><input type="text" name="other_fee" id="other_fee" style="width:45px" value="<?echo $val['other_fee'];?>"></td>
                    <td><input type="text" name="memo" id="memo" value="<?echo $val['memo'];?>"></td>
                    <td><input type="text" name="use_person" id="use_person" value="<?echo $val['use_person'];?>"></td>
                    <td><input type="text" name="bill_no" id="bill_no" value="<?echo $val['bill_no'];?>"></td>
                    <td><a class="btn btn-primary do_save" type_id ="0" bill_id="<?echo $val['id'];?>" onclick="do_save(this)">编辑</a></td>
                    <td><a class="btn btn-primary" id = "do_delete" type_id ="0" bill_id="<?echo $val['id'];?>" onclick="do_delete(this)">删除</a></td>
                </tr>
                <?}$i++;}}else{?>
                <?}?>
        </tbody>
    </table>
    </p>
        <table class="table-bordered table-striped table-condensed">
        <thead>
            <tr class="CaseRow">
                <th align="center" colspan="15">返程费用</th>
            </tr>
            <tr class="CaseRow">
                <th>序号</th>
                <th>出发时间</th>
                <th>到达时间</th>
                <th>起始地</th>
                <th>目的地</th>
                <th>交通方式</th>
                <th>交通费</th>
                <th>住宿费</th>
                <th>加班餐费</th>
                <th>其他费用</th>
                <th>备注</th>
                <th>业务员</th>
                <th>单据编号</th>
                <th colspan="2"><a class="btn btn-info" type_id ="1" onclick="add_td(this)">添加一行</a></th>
            </tr>
        </thead>
        <tbody>
            <?if (isset($value['bill_order_list']) && !empty($value['bill_order_list'])){?>
            <?$n=1;foreach ($value['bill_order_list'] as $key => $val) {
            ?>
            <?if($val['type']==1){?>
            <tr align="center" id="<?echo $n;?>">
                <td><?echo $n;?></td>
                <td><input type="text" name="go_time" style="width:135px" class="format_time" id="go_time" value="<?echo $val['go_time'];?>"></td>
                <td><input type="text" name="arrival_time" style="width:135px" class="format_time" id="arrival_time" value="<?echo $val['arrival_time'];?>"></td>
                <td><input type="text" name="start_place" id="start_place" value="<?echo $val['start_place'];?>"></td>
                <td><input type="text" name="arrival_place" id="arrival_place" value="<?echo $val['arrival_place'];?>"></td>
                <td>
                    <select name="transportation" id="transportation">
                        <?foreach ($traffic_list as $k => $tmp) {?>
                        <option value="<?echo $tmp['id'];?>" <?if($val['transportation']==$tmp['id']){echo "selected=selected";}?>><?echo $tmp['name'];?></option>
                        <?}?>
                    </select>
                </td>
                <td><input type="text" name="transportation_fee" id="transportation_fee" style="width:45px" value="<?echo $val['transportation_fee'];?>"></td>
                <td><input type="text" name="hotel_fee" id="hotel_fee" style="width:45px" value="<?echo $val['hotel_fee'];?>"></td>
                <td><input type="text" name="food_fee" id="food_fee" style="width:45px" value="<?echo $val['food_fee'];?>"></td>
                <td><input type="text" name="other_fee" id="other_fee" style="width:45px" value="<?echo $val['other_fee'];?>"></td>
                <td><input type="text" name="memo" id="memo" value="<?echo $val['memo'];?>"></td>
                <td><input type="text" name="use_person" id="use_person" value="<?echo $val['use_person'];?>"></td>
                <td><input type="text" name="bill_no" id="bill_no" value="<?echo $val['bill_no'];?>"></td>
                <td><a class="btn btn-primary do_save" type_id ="1" bill_id="<?echo $val['id'];?>" onclick="do_save(this)">编辑</a></td>
                <td><a class="btn btn-primary" id = "do_delete" type_id ="1" bill_id="<?echo $val['id'];?>" onclick="do_delete(this)">删除</a></td>
            </tr>
            <?}$n++;}}else{?>
            <?}?>
        </tbody>
    </table>

</div>
</div>



<div class="row">
</div>
<?}?>
<!--
<div>
    <ul class="breadcrumb">
        <li>
            <a class="btn btn-info" href="<?php echo $back_url;?>">返回</a>
        </li>
    </ul>
</div>
-->
<script type="text/javascript">
$(function() {
    $('.format_time').datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss",
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
    });

    <?if(isset($status) && $status=="succ"){?>
    var n = noty({
      text: "事件添加成功",
      type: 'success',
      layout: 'center',
      timeout: 1000,
    });
    <?}?>


    $(".delete_work_order").click(function() {
        var work_order_id = $(this).parent().children('input[id="work_order_id"]').val();
        event_id = $('#event_id').val();
        $('#arrive_time').val();
     if(confirm("确认删除工单吗")){
        _self = this;
        url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'delete_work_order'))?>"+"&work_order_id="+work_order_id+"&event_id="+event_id;
        window.location.href=url;
     }else{
        return;
     }
    });


})



function do_add(){
    arrive_time = $('#arrive_time').val();
    back_time = $('#back_time').val();
    failure_mode = $('#failure_mode').val();
    desc = $('#desc').val();
    schedule = $('input[name="schedule"]:checked').val();
    memo = $('#memo').val();

    arrive_date = arrive_time.substr(0, 10);
    back_date = back_time.substr(0, 10);
    event_time = $('#event_time').val();
    if (arrive_time== '') {
            var n = noty({
              text: "请输入到达时间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (back_time== '') {
            var n = noty({
              text: "请输入离场时间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if(event_time != arrive_date){
        var n = noty({
          text: "到达时间必须为事件时间",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    /*
    if(event_time != back_date){
        var n = noty({
          text: "离场时间必须为事件时间",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false;
    }
    */
    if (failure_mode== '') {
            var n = noty({
              text: "请选择故障分类",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (desc== '') {
            var n = noty({
              text: "请输入使用人描述",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (schedule== '') {
            var n = noty({
              text: "请选择事件反馈",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (memo== '' &&(schedule=='1'||schedule=='2')) {
            var n = noty({
              text: "备注必填",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    return true;
}



function add_td(atable){
    var type_id = $(atable).attr('type_id');
    var ObjTb = $(atable).parent().parent().parent().parent();
    var id = ObjTb.find("tr:last").attr('id');
    if(!id){
        id = 0;
    }
    var NId = parseInt(id)+1;
    //var str = 'onclick="laydate({istime: true, format: "YYYY-MM-DD hh:mm:ss"})"';
    var TrContent = '<tr id="'+NId+'"><td>'+NId+'</td><td><input type="text" style="width:135px" name="go_time" id="go_time" class="format_time"></td><td><input style="width:135px" type="text" name="arrival_time" id="arrival_time" class="format_time"></td><td><input type="text" name="start_place" id="start_place"></td><td><input type="text" name="arrival_place" id="arrival_place"></td><td><select id="transportation" name="transportation"><?foreach ($traffic_list as $k => $tmp) {?><option value="<?echo $tmp["id"];?>" selected=selected><?echo $tmp["name"];?></option><?}?></select></td><td><input type="text" name="transportation_fee" id="transportation_fee" value="0" style="width:45px" ></td><td><input type="text" name="hotel_fee" id="hotel_fee" value="0" style="width:45px" ></td><td><input type="text" name="food_fee" id="food_fee" value="0" style="width:45px" ></td><td><input type="text" name="other_fee" value="0" id="other_fee" style="width:45px" ></td><td><input type="text" name="memo" id="memo"></td><td><input type="text" name="use_person" id="use_person"></td><td><input type="text" name="bill_no" id="bill_no"></td><td><a class="btn btn-primary do_save" type_id="'+type_id+'" bill_id="" onclick="do_save(this)">保存</a></td><td><a class="btn btn-primary" id="do_delete" type_id="'+type_id+'" bill_id="" onclick="do_delete(this)">删除</a></td></tr>';
    $(atable).parent().parent().parent().parent().find("tbody").append(TrContent);
    $('.format_time').datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss",
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        pickerPosition: 'bottom-right',
    });
}
function do_delete(atable){
    var bill_id = $(atable).attr('bill_id');
    if(bill_id !=""){
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST","<?php echo site_url('ctl=event&act=delete_biil_order');?>",false);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("bill_id="+bill_id);
        var result = xmlhttp.responseText;
        if(result =="succ"){
            var n = noty({
              text: "删除成功",
              type: 'success',
              layout: 'center',
              timeout: 1000,
            });
        }else{
            var n = noty({
              text: "删除失败",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    }
    $(atable).parent().parent().remove()
}
function do_save(atable){
    work_order_id = $(atable).parent().parent().parent().parent().parent().find("#work_order_id_2").val();
    go_time = $(atable).parent().parent().find("#go_time").val();
    arrival_time = $(atable).parent().parent().find('#arrival_time').val();
    start_place = $(atable).parent().parent().find('#start_place').val();
    arrival_place = $(atable).parent().parent().find('#arrival_place').val();
    transportation = $(atable).parent().parent().find('#transportation').val();
    transportation_fee = $(atable).parent().parent().find('#transportation_fee').val();
    hotel_fee = $(atable).parent().parent().find('#hotel_fee').val();
    food_fee = $(atable).parent().parent().find('#food_fee').val();
    other_fee = $(atable).parent().parent().find('#other_fee').val();
    memo = $(atable).parent().parent().find('#memo').val();
    use_person = $(atable).parent().parent().find('#use_person').val();
    bill_no = $(atable).parent().parent().find('#bill_no').val()
    var bill_id = $(atable).attr('bill_id');
    var type_id = $(atable).attr('type_id');
    var SaveObj = $(atable)
    var DelObj = $(atable).parent().parent().find("#do_delete")
    /**
    if (hotel_fee== '' || isNaN(hotel_fee)) {
            var n = noty({
              text: "请输入住宿费",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (food_fee== '' || isNaN(food_fee)) {
            var n = noty({
              text: "请输入餐费",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    **/
    /**
    if (other_fee== '' || isNaN(other_fee)) {
            var n = noty({
              text: "请输入其他费用",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    **/
    if (go_time== '') {
            var n = noty({
              text: "请输入出发时间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (arrival_time== '') {
            var n = noty({
              text: "请输入到达时间",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (start_place== '') {
            var n = noty({
              text: "请输入起始地",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (arrival_place== '') {
            var n = noty({
              text: "请输入目的地",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (transportation== '') {
            var n = noty({
              text: "请选择交通方式",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if (transportation_fee== '' || isNaN(transportation_fee)) {
            var n = noty({
              text: "请输入交通费",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
        }
    if(use_person == ''){
        var n = noty({
              text: "请输入业务员",
              type: 'error',
              layout: 'center',
              timeout: 1000,
            });
            return false;
    }
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","<?php echo site_url('ctl=event&act=add_biil_order');?>",false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("type="+type_id+"&bill_id="+bill_id+"&work_order_id="+work_order_id+"&go_time="+go_time+"&arrival_time="+arrival_time+"&start_place="+start_place+"&arrival_place="+arrival_place+"&transportation="+transportation+"&transportation_fee="+transportation_fee+"&hotel_fee="+hotel_fee+"&food_fee="+food_fee+"&other_fee="+other_fee+"&memo="+memo+"&use_person="+use_person+"&bill_no="+bill_no);
    var result = xmlhttp.responseText;
    var data = eval("("+result+")");
    if ("succ" == data.status){
        SaveObj.attr({bill_id:data.id});
        DelObj.attr({bill_id:data.id});
        var n = noty({
          text: "保存成功！",
          type: 'success',
          layout: 'center',
          timeout: 1000,
        });
        $(".do_save").html("编辑");
        return true;
    }else{
        var n = noty({
          text: "保存失败！",
          type: 'error',
          layout: 'center',
          timeout: 1000,
        });
        return false
    }
}


</script>
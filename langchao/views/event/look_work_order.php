<style type="text/css">
input{width:95px;}
select{width:60px;}
</style>

<div>
    <ul class="breadcrumb">
        <li>
            <!--<a class="btn btn-info" href="<?php echo $back_url;?>">返回</a>-->
        </li>
    </ul>
</div>

<? foreach ($work_order_list as $key => $value) {
?>
<form class="form-horizontal" action="<?php echo site_url('ctl=event&act=do_edit_work_order');?>" method="post"  onsubmit="return do_add();">

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
                    <textarea  name="symptom" rows="1" cols="50"><?echo $value['symptom'];?></textarea>
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
                    <textarea name="failure_analysis" id="failure_analysis" rows="1" cols="50"><?echo $value['failure_analysis'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>风险预测</th>
                <td colspan="3">
                    <textarea  name="risk_profile" id="risk_profile" rows="1" cols="50" ><?echo $value['risk_profile'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>解决方案</th>
                <td colspan="3">
                    <textarea  name="solution" id="solution" rows="1" cols="50" ><?echo $value['solution'];?></textarea>
                </td>
            </tr>
            <tr>
                <th>使用人描述</th>
                <td colspan="3">
                    <textarea  name="desc" id="desc" rows="1" cols="50" ><?echo $value['desc'];?></textarea>
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
                    <textarea  name="memo" id="memo" rows="1" cols="50"><?echo $value['memo'];?></textarea>
                </td>
            </tr>

        </tbody>
    </table>
    <input type="hidden" id="work_order_id" name="work_order_id" value="<?echo $value['id']; ?>">
    <input type="hidden" id="event_id" name="event_id" value="<?echo $event['id']; ?>">
</div>
<div class="col-lg-7 col-md-4">
    <p class="center col-md-12">
    </p>
</div>
</form>
<div class="row col-sm-12 col-md-12">
    <table class="table-bordered table-striped table-condensed" width="300">
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
                <th>使用人</th>
                <th>单据编号</th>
            </tr>
        </thead>
        <tbody>
            <?if (isset($value['bill_order_list']) && !empty($value['bill_order_list'])){?>
                <? $i=1; foreach ($value['bill_order_list'] as $key => $val) {?>
                <?if($val['type']==0){?>
                <tr align="center" id="<?echo $i;?>">
                    <td><?echo$i;?></td>
                    <td><input type="text" style="width:140px" name="go_time" class="format_time" id="go_time" value="<?echo $val['go_time'];?>"></td>
                    <td><input type="text" style="width:140px" name="arrival_time" class="format_time" id="arrival_time" value="<?echo $val['arrival_time'];?>"></td>
                    <td><input type="text" name="start_place" id="start_place" value="<?echo $val['start_place'];?>"></td>
                    <td><input type="text" name="arrival_place" id="arrival_place" value="<?echo $val['arrival_place'];?>"></td>
                    <td>
                        <select name="transportation" id="transportation">
                            <?foreach ($traffic_list as $k => $tmp) {?>
                            <option value="<?echo $tmp['id'];?>" <?if($val['transportation']==$tmp['id']){echo "selected=selected";}?>><?echo $tmp['name'];?></option>
                            <?}?>
                        </select>
                    </td>
                    <td><input type="text" style="width:55px" name="transportation_fee" id="transportation_fee" value="<?echo $val['transportation_fee'];?>"></td>
                    <td><input type="text" style="width:55px" name="hotel_fee" id="hotel_fee" value="<?echo $val['hotel_fee'];?>"></td>
                    <td><input type="text" style="width:55px" name="food_fee" id="food_fee" value="<?echo $val['food_fee'];?>"></td>
                    <td><input type="text" style="width:55px" name="other_fee" id="other_fee" value="<?echo $val['other_fee'];?>"></td>
                    <td><input type="text" name="memo" id="memo" value="<?echo $val['memo'];?>"></td>
                    <td><input type="text" name="use_person" id="use_person" value="<?echo $val['use_person'];?>"></td>                   
                    <td><input type="text" name="bill_no" id="bill_no" value="<?echo $val['bill_no'];?>"></td>
                </tr>
                <?}$i++;}}else{?>
                <?}?>
        </tbody>
    </table>
    </p>
        <table class="table-bordered table-striped table-condensed" width="300">
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
                <th>使用人</th>
                <th>单据编号</th>
            </tr>
        </thead>
        <tbody>
            <?if (isset($value['bill_order_list']) && !empty($value['bill_order_list'])){?>
            <?$n=1;foreach ($value['bill_order_list'] as $key => $val) {
            ?>
            <?if($val['type']==1){?>
            <tr align="center" id="<?echo $n;?>">
                <td><?echo $n;?></td>
                <td><input type="text" style="width:140px" name="go_time" class="format_time" id="go_time" value="<?echo $val['go_time'];?>"></td>
                <td><input type="text" style="width:140px" name="arrival_time" class="format_time" id="arrival_time" value="<?echo $val['arrival_time'];?>"></td>
                <td><input type="text" name="start_place" id="start_place" value="<?echo $val['start_place'];?>"></td>
                <td><input type="text" name="arrival_place" id="arrival_place" value="<?echo $val['arrival_place'];?>"></td>
                <td>
                    <select name="transportation" id="transportation">
                        <?foreach ($traffic_list as $k => $tmp) {?>
                        <option value="<?echo $tmp['id'];?>" <?if($val['transportation']==$tmp['id']){echo "selected=selected";}?>><?echo $tmp['name'];?></option>
                        <?}?>
                    </select>
                </td>
                <td><input type="text" style="width:55px" name="transportation_fee" id="transportation_fee" value="<?echo $val['transportation_fee'];?>"></td>
                <td><input type="text" style="width:55px" name="hotel_fee" id="hotel_fee" value="<?echo $val['hotel_fee'];?>"></td>
                <td><input type="text" style="width:55px" name="food_fee" id="food_fee" value="<?echo $val['food_fee'];?>"></td>
                <td><input type="text" style="width:55px" name="other_fee" id="other_fee" value="<?echo $val['other_fee'];?>"></td>
                <td><input type="text" name="memo" id="memo" value="<?echo $val['memo'];?>"></td>
                <td><input type="text" name="use_person" id="use_person" value="<?echo $val['use_person'];?>"></td>                
                <td><input type="text" name="bill_no" id="bill_no" value="<?echo $val['bill_no'];?>"></td>
            </tr>
            <?}$n++;}}else{?>
            <?}?>
        </tbody>
    </table>

</div>

<?}?>
<div class="row" style="text-align:center;">
     <h2>数据导出</h2>
</div>


<div class="row event_info" id="event_info">
  <?php
  if(isset($info_list)&&!empty($info_list)&&isset($is_search)){
    if($data_type=="work_time"){
  ?>    
    <table class="table table-bordered">
        <thead>
            <tr>
              <th>月份</th>
              <th colspan="2"><?echo $event_month;?></th>
              <th>状态</th>
              <th></th>
              <th colspan="5"></th>
            </tr>          
            <tr>
                <th>序号</th>
                <th>使用人</th>
                <!--<th>日期</th>-->
                <th>到场时间</th>
                <th>离场时间</th>
                <th>事件描述</th>
                <!--<th>工时</th>-->
                <th>工作日工时</th>
                <th>平时加班</th>
                <th>周末加班</th>
                <th>节日加班</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($info_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><? echo $i;?></td>
                <td><? echo $name;?></td>
                <!--<td><? echo $value['date'];?></td>-->
                <td><? echo $value['arrive_time'];?></td>
                <td><? echo $value['back_time'];?></td>
                <td><? echo $value['desc'];?></td>
                <!--<td><? echo $value['worktime_count'];?></td>-->
                <td><? echo $value['work_time'];?></td>
                <td><?echo $value['week_more'];?></td>
                <td><?echo $value['weekend_more'];?></td>
                <td><?echo $value['holiday_more'];?></td>
            </tr>
            <? } ?>
        </tbody>
          <tbody>
              <tr>
                  <td colspan="8"><?php $this->load->view('elements/pager'); ?></td>
                  <td><a class="btn btn-info do_export">导出</a></td>
              </tr>
          </tbody>
    </table>
    <?}elseif ($data_type=="fee") {?>
      <table class="table table-bordered">
          <thead>
              <tr>
                <th>月份</th>
                <th><?echo $event_month;?></th>
                <th>状态</th>
                <th></th>
                <th colspan="9"></th>
              </tr>
              <tr>
                  <th>序号</th>
                  <th>使用人</th>
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
              </tr>
          </thead>
          <tbody>

              <? $i=0; foreach ($info_list as $key => $val) {
                    $i+=1
              ?>
                <tr align="center">
                    <td><? echo $i;?></td>
                    <td><? echo $name;?></td>
                    <td><? echo $val['go_time'];?></td>
                    <td><? echo $val['arrival_time'];?></td>
                    <td><?echo $val['start_place'];?></td>
                    <td><?echo $val['arrival_place'];?></td>
                    <td><?echo $val['transportation_name'];?></td>
                    <td><?echo $val['transportation_fee'];?></td>
                    <td><?echo $val['hotel_fee'];?></td>
                    <td><?echo $val['food_fee'];?></td>
                    <td><?echo $val['other_fee'];?></td>
                    <td><?echo $val['memo'];?></td>
                    <td><?echo $val['use_person'];?></td>
                    <td><?echo $val['bill_no'];?></td>
                </tr>
              <? } ?>
          </tbody>
          
          <tbody>
              <tr>
                  <td colspan="12"><?php $this->load->view('elements/pager'); ?></td>
                  <td><a class="btn btn-info do_export">导出</a></td>
              </tr>
          </tbody>
      </table>      
    <?}?>
  <?php }elseif(isset($is_search)){?>
    <p>查询不到事件信息!</p>
  <?php }?>


<input type="hidden" id="user_id" name="user_id" value="<?echo $user_id;?>">
<input type="hidden" id="department_id" name="department_id" value="<?echo $department_id;?>">
<input type="hidden" id="event_month" name="event_month" value="<?echo $event_month;?>">
<input type="hidden" id="data_type" name="data_type" value="<?echo $data_type;?>">
<input type="hidden" id="is_search" name="is_search" value="1">
</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url("ctl=search&act=do_data_export");?>';
    var getobj = {};
    getobj.user_id=$('#user_id').val();
    getobj.department_id=$('#department_id').val();
    getobj.event_month=$('#event_month').val();
    getobj.data_type=$('#data_type').val();
    getobj.is_search=$('#is_search').val();
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

$(function() {
        $(".do_export").click(function() {
            _self = this;
            user_id = $('#user_id').val();
            department_id = $('#department_id').val();
            event_month = $('#event_month').val();
            data_type = $('#data_type').val();
            is_search = $('#is_search').val();            
            var url = "<?php echo site_url(array('ctl'=>'search', 'act'=>'do_data_export'))?>"+"&is_export=1&is_search=1&user_id="+user_id+"&department_id="+department_id+"&event_month="+event_month+"&data_type="+data_type;
            window.location.href = url;
          })
})

</script>
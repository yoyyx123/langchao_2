<div class="row" style="text-align:center;">
     <h2>数据导出</h2>
</div>
<div class="row">
    <div class="box col-md-8">
    <table> 
        <tr>
          <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">部门</div>
              <select  class="form-control department_id" name="department_id" id="department_id">
              <option value="">请选择</option>
                <?if($user_data['position2']==3||$user_data['position2']==4){?>
                <option value="all">全部</option>
                <?}?>
                <?php foreach ($department_list as $key => $value) {
                if(($user_data['position2']==1||$user_data['position2']==2)&&$user_data['department']==$value['id']){
                ?>
                    <option value="<? echo $value['id'];?>" <?if(isset($department_id)&&$department_id==$value['id']){echo "selected=selected";}?>><?echo $value['name'];?></option>
               <?}elseif($user_data['position2']==3||$user_data['position2']==4){?>
                    <option value="<? echo $value['id'];?>" <?if(isset($department_id)&&$department_id==$value['id']){echo "selected=selected";}?>><?echo $value['name'];?></option>
                <?php }} ?>
              </select>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">月份</div>
              <input class="form-control form_datetime" type="text" value="<?if(isset($event_month)){echo $event_month;}?>" name="event_month" id="event_month">
            </div>
          </div>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">使用人</div>
              <select  class="form-control user_id" name="user_id" id="user_id">
                <?if(isset($user_id)&&$user_id=='all'){
                    echo "<option value='all' selected=selected>全部</option>";
                  }elseif(isset($user_id)){
                    echo "<option value='".$user_id."'selected=selected>".$name."</option>";
                  }else{
                    echo "<option value=''>无</option>";
                  }

                ?>
              </select>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="input-group">
            <div class="input-group-addon">数据列别</div>
              <select  class="form-control" name="data_type" id="data_type">
                <option value="work_time" <?if(isset($data_type)&&$data_type=="work_time"){echo "selected=selected";}?>>工时</option>
                <option value="fee" <?if(isset($data_type)&&$data_type=="fee"){echo "selected=selected";}?>>报销费用</option>
              </select>
            </div>
          </div>
        </td>        
        <td>
         <div class="form-group">
            <div class="input-group">
              <a class="btn btn-info do_search">查询</a>
            </div>
          </div>
        </td>
        </tr>
    </table>
</div>     

</div>

<div class="row event_info" id="event_info">
  <?php
  if(isset($info_list)&&!empty($info_list)&&isset($is_search)){
    if($data_type=="work_time"){
  ?>    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>序号</th>
                <th>月份</th>
                <th>使用人</th>
                <th>状态</th>
                <th>工时</th>
                <th>工作日工时</th>
                <th>平时加班时间</th>
                <th>周末加班时间</th>
                <th>节日加班时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($info_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><?php echo $i;?></td>
                <td><?php echo $value['event_month'];?></td>
                <td><?php echo $value['name'];?></td>
                <td>未报销<?php echo $value['no_status'];?>/已报销<?php echo $value['cost_status'];?></td>
                <td><?php echo $value['worktime_count'];?></td>
                <td><?php echo $value['work_time'];?></td>
                <td><?echo $value['week_more'];?></td>
                <td><?echo $value['weekend_more'];?></td>
                <td><?echo $value['holiday_more'];?></td>
                <td><a class="btn btn-info do_check" department_id='<?echo $department_id;?>' user_id='<?echo $value['user_id'];?>' event_month='<?echo $event_month;?>' data_type='<?echo $data_type;?>'>查看</a></td>
            </tr>
            <? } ?>
        </tbody>
        
        <tbody>
            <tr>
                <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
                <td><a class="btn btn-info do_export">全部导出</a></td>
            </tr>
        </tbody>
    </table>
    <?}elseif ($data_type=="fee") {?>
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>序号</th>
                  <th>月份</th>
                  <th>使用人</th>
                  <th>状态</th>
                  <th>交通费</th>
                  <th>住宿费</th>
                  <th>加班餐费</th>
                  <th>其他费用</th>
                  <th>操作</th>
              </tr>
          </thead>
          <tbody>

              <? $i=0; foreach ($info_list as $key => $value) {
                  $i+=1
              ?>
              <tr align="center">
                  <td><?php echo $i;?></td>
                  <td><?php echo $value['event_month'];?></td>
                  <td><?php echo $value['name'];?></td>
                  <td>未报销<?php echo $value['no_status'];?>/已报销<?php echo $value['cost_status'];?></td>
                  <td><?php echo $value['transportation_fee'];?></td>
                  <td><?echo $value['hotel_fee'];?></td>
                  <td><?echo $value['food_fee'];?></td>
                  <td><?echo $value['other_fee'];?></td>
                  <td><a class="btn btn-info do_check" department_id='<?echo $department_id;?>' user_id='<?echo $value['user_id'];?>' event_month='<?echo $event_month;?>' data_type='<?echo $data_type;?>'>查看</a></td>
              </tr>
              <? } ?>
          </tbody>
          
          <tbody>
              <tr>
                  <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
                  <td><a class="btn btn-info do_export">全部导出</a></td>
              </tr>
          </tbody>

      </table>      
    <?}?>
  <?php }elseif(isset($is_search)){?>
    <p>查询不到事件信息!</p>
  <?php }?>   
</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url("ctl=search&act=data_export");?>';
    var getobj = {};
    getobj.user_id=$('#user_id').val();
    getobj.department_id=$('#department_id').val();
    getobj.event_month=$('#event_month').val();
    getobj.data_type=$('#data_type').val();
    getobj.is_search=1;;
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}


<?if(isset($department_id)){?>
    $.ajax({
        type: "POST",
        url: "<?php echo site_url(array('ctl'=>'user', 'act'=>'get_user_list'))?>",
        data: "&department_id=<?echo $department_id;?>",
        success: function(result){
            var data = eval("("+result+")");
            $(".user_id").empty();
            if(result){
              $(".user_id").append('<option value="all">全部</option>');
            }
            $.each(data, function(key,value){
                if(value['id']=='<?echo$user_id;?>'){
                $(".user_id").append('<option value="'+value['id']+'" selected=selected>'+value['name']+'</option>');
                }else{
                $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');                  
                }
            });
        }
     });   

<?}?>

$(function() {

        $('.form_datetime').datetimepicker({
            format: "yyyy-mm", 
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 3,
            minView:3,
            forceParse: 0,
            showMeridian: 1,

        });

        $(".department_id").change(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'user', 'act'=>'get_user_list'))?>",
                data: "&department_id="+$(this).val(),
                success: function(result){
                    var data = eval("("+result+")");
                    $(".user_id").empty();
                    if(result){
                      $(".user_id").append('<option value="all">全部</option>');
                    }
                    $.each(data, function(key,value){

                        $(".user_id").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                    });
                }
             });            
        });              

        $(".do_search").click(function() {
            _self = this;
            department_id = $('#department_id').val();
            user_id = $('#user_id').val();
            event_month = $('#event_month').val();
            data_type = $('#data_type').val();            
            if (event_month == '') {
                    var n = noty({
                      text: "月份必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (department_id == '') {
                    var n = noty({
                      text: "部门必选",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (user_id == '' && department_id !='all') {
                    var n = noty({
                      text: "使用人必选",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (data_type == 'work_time' && <?echo $user_data['position2'];?>==1){
                    var n = noty({
                      text: "员工没有导出权限",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;              
            }
            var url = "<?php echo site_url(array('ctl'=>'search', 'act'=>'data_export'))?>"+"&is_search=1&user_id="+user_id+"&department_id="+department_id+"&event_month="+event_month+"&data_type="+data_type;
            window.location.href = url;
        });
        
        $(".do_check").click(function() {
            _self = this;
            department_id = $(this).attr('department_id');
            user_id = $(this).attr('user_id');
            event_month = $(this).attr('event_month');
            data_type = $(this).attr('data_type');           
            if (event_month == '') {
                    var n = noty({
                      text: "y月份必填",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (department_id == '') {
                    var n = noty({
                      text: "部门必选",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }
            if (user_id == '') {
                    var n = noty({
                      text: "使用人必选",
                      type: 'error',
                      layout: 'center',
                      timeout: 1000,
                    });
                    return false;
                }                
            var url = "<?php echo site_url(array('ctl'=>'search', 'act'=>'do_data_export'))?>"+"&is_search=1&user_id="+user_id+"&department_id="+department_id+"&event_month="+event_month+"&data_type="+data_type;
            window.location.href = url;
        });

$(function() {
        $(".do_export").click(function() {
            _self = this;
            user_id = $('#user_id').val();
            department_id = $('#department_id').val();
            event_month = $('#event_month').val();
            data_type = $('#data_type').val();
            is_search = $('#is_search').val();            
            var url = "<?php echo site_url(array('ctl'=>'search', 'act'=>'do_data_export_all'))?>"+"&is_export=1&is_search=1&user_id="+user_id+"&department_id="+department_id+"&event_month="+event_month+"&data_type="+data_type;
            window.location.href = url;
          })
})

})
</script>
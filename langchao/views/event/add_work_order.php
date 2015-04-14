<div>
    <ul class="breadcrumb">
        <li>
            <a class="btn btn-info" href="<?php echo $back_url;?>">返回</a>
        </li>
    </ul>
</div>


<form class="form-horizontal" action="<?php echo site_url('ctl=event&act=do_add_work_order');?>" method="post"  onsubmit="return do_add();">

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
                    <input type="text" name="custom_department" id="custom_department" class="custom_department">
                </td>
            </tr>
            <tr>
                <th>到达时间(签到)</th>
                <td>
                    <input class="arrive_time" type="text" value="" name="arrive_time" id="arrive_time">
                </td>
                <th>离场时间(签退)</th>
                <td>
                    <input type="text" name="back_time" id="back_time" class="back_time">
                </td>                
            </tr>
            <tr>
                <th>保修症状</th>
                <td colspan="3">
                    <textarea  name="symptom" rows="3" cols="50"></textarea>
                </td>
            </tr>            
            <tr>
                <th>故障分类</th>
                <td>
                   日常<input type="radio" name="failure_mode" id="failure_mode" class="failure_mode" value="0" checked="checked">
                </td>
                <td>
                   软件<input type="radio" name="failure_mode" id="failure_mode" class="failure_mode" value="1">
                </td>
                <td>
                   硬件<input type="radio" name="failure_mode" id="failure_mode" class="failure_mode" value="2">
                </td>
            </tr>
            <tr>
                <th>故障等级</th>
                <td>
                   一级<input type="radio" name="failure_level" id="work_type" class="work_type" value="0">
                </td>
                <td>
                   二级<input type="radio" name="failure_level" id="failure_level" class="work_type" value="1">
                </td>
                <td>
                   三级<input type="radio" name="failure_level" id="failure_level" class="work_type" value="2" checked="checked">
                </td>
            </tr>
            <tr>
                <th>故障分析</th>
                <td colspan="3">
                    <textarea name="failure_analysis" id="failure_analysis" class="failure_analysis" rows="3" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th>风险预测</th>
                <td colspan="3">
                    <textarea  name="risk_profile" id="risk_profile" class="risk_profile"rows="3" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th>解决方案</th>
                <td colspan="3">
                    <textarea  name="solution" id="solution" class="solution"rows="3" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th>使用人描述</th>
                <td colspan="3">
                    <textarea  name="desc" id="desc" class="desc" rows="3" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th>事件反馈</th>
                <td>
                   已完成<input type="radio" name="schedule" id="schedule" class="schedule" value="0" checked="checked">
                </td>
                <td>
                   部分完成<input type="radio" name="schedule" id="schedule" class="schedule" value="1">
                </td>
                <td>
                   未完成<input type="radio" name="schedule" id="schedule" class="schedule" value="2">
                </td>
            </tr>
            <tr>
                <th>备注</th>
                <td colspan="3">
                    <textarea  name="memo" id="memo" class="memo" rows="3" cols="50"></textarea>
                </td>
            </tr>

        </tbody>
    </table>
    <input type="hidden" name="event_id" value="<?echo $event['id']; ?>">
    <input type="hidden" name="back_url" value="<?echo $back_url; ?>">
</div>
<div class="col-lg-7 col-md-4">
    <p class="center col-md-12">
        <button type="submit" class="btn btn-primary">添加</button>&nbsp&nbsp&nbsp
    </p>
</div> 

</form>


<script type="text/javascript">

$(function() {

    $('.arrive_time').datetimepicker({
        format: "yyyy-mm-dd hh:ii:00", 
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,

    });

    $('.back_time').datetimepicker({
        format: "yyyy-mm-dd hh:ii:00", 
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
      text: "工单删除成功",
      type: 'success',
      layout: 'center',
      timeout: 1000,
    });
    <?}?>    

})        




function do_add(){
    arrive_time = $('#arrive_time').val();
    back_time = $('#back_time').val();
    failure_mode = $('#failure_mode').val();
    desc = $('#desc').val();
    schedule = $('input[name="schedule"]:checked').val();
    memo = $('#memo').val();
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
</script>
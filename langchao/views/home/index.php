<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ctl=user&act=info');?>" class="btn btn-primary">个人设置</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i></i></h2>
            </div>
            <div class="box-content row">
                <div class="col-lg-3 col-md-2" style="text-align:center;">
                    <img height="150px" src="<?php echo base_url('upload/img/userlogo').'/'.$user_data['img'];?>" />
                </div>
                <div class="col-lg-9 col-md-10">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="80px">帐号</td>
                                <td><?php echo $user_data['username'];?></td>
                                <td width="80px">登录时间</td>
                                <td><?php echo $user_data['login_time'];?></td>
                            </tr>
                            <tr>
                                <td>姓名</td>
                                <td><?php echo $user_data['name'];?></td>
                                <td>集团短号</td>
                                <td><?php echo $user_data['short_num'];?></td>
                            </tr>
                            <tr>
                                <td>部门</td>
                                <td><?php echo $user_data['department_name'];?></td>
                                <td>职位</td>
                                <td><?php echo $user_data['position_name'];?></td>
                            </tr>
                            <tr>
                                <td>移动电话</td>
                                <td><?php echo $user_data['mobile'];?></td>
                                <td>企业邮箱</td>
                                <td><?php echo $user_data['email'];?></td>
                            </tr>                              
                        </tbody>                       
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="1" style="text-align:center;">系统提示</th>
                    <th  colspan="7" style="text-align:center;">当前已有<?echo $expire_count;?>件工单超时，请补填！</th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="7" style="text-align:center;">当前已有<?echo $warning_count;?>件工单即将超时，请抓紧填写！</th>
                </tr>  
                <tr>
                    <th>待填工单</th>
                    <th colspan="7"></th>
                </tr>                
                <tr>
                    <th>序号</th>
                    <th>时间</th>
                    <th>客户简称</th>
                    <th>事件类型</th>
                    <th>使用人</th>
                    <th>事件描述</th>
                    <th>有效期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <? $i=1;foreach ($event_list as $key => $value) {
                    if($value['status'] ==1){
                ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value['event_time'];?></td>
                        <td><?php echo $value['short_name'];?></td>
                        <td><?php echo $value['event_type_name'];?></td>
                        <td><?php echo $value['user_name'];?></td>
                        <td><?php echo $value['desc'];?></td>
                        <td><?php if($value['event_less_time'] <0){echo "已超时".abs($value['event_less_time'])."天";}else{echo $value['event_less_time'];}?></td>
                        <td><a class="btn btn-primary add_work_order" event_id="<?echo $value['id']?>">查看</a></td>
                    </tr>
                <?$i++;}}?>
            </tbody>
            <tbody>
                <tr>
                    <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



<script type="text/javascript">
$(function() {

        $(".add_work_order").click(function() {
            _self = this;
            var event_id = $(this).attr('event_id');
            var back_url = "<?php echo site_url(array('ctl'=>'home', 'act'=>'index'))?>";
            var url = "<?php echo site_url(array('ctl'=>'event', 'act'=>'add_work_order'))?>"+"&event_id="+event_id+"&back_url="+escape(back_url);
            window.location.href=url;
        });    
})


var sel_time_data = function (per_page) {
    var url = '<?php echo site_url('ctl=home&act=index');?>';
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
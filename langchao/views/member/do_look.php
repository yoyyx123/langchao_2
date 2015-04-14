<div class="box col-lg-7 col-md-7">
    <?php
    if(isset($member)&&!empty($member)){
    ?>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th width="110px">客户编号</th>
                <td colspan="5">
                    <?echo $member['code']; ?>
                </td>
            </tr>
            <tr>
                <th>客户全称</th>
                <td colspan="5">
                    <?echo $member['name']; ?>
                </td>
            </tr>
            <tr>
                <th width="80px">客户简称</th>
                <td colspan="5">
                    <?echo $member['short_name']; ?>
                </td>
            </tr>                          
            <tr>
                <th>客户属性</th>
                <td>
                    <?echo $member['member_type_name']; ?>
                </td>                
                <th>客户所属地</th>
                <td>
                    
                    <?echo $member['city_name']; ?>
                </td>  
            </tr>
            <tr>
                <th>地址</th>
                <td colspan="5">
                    <?echo $member['addr']; ?>
                </td>
            </tr>
            <tr>
                <th>公交/地铁</th>
                <td colspan="5">
                    <?echo $member['bus']; ?>
                </td>
            </tr>
            <tr>
                <th>客户联系人</th>
                <td>
                    <?echo $member['contacts']; ?>
                </td>
                <th>工程项目负责人</th>
                <td>
                    <?echo $member['project_man']; ?>
                </td>
                <th>日常业务负责人</th>
                <td>
                    <?echo $member['business_man']; ?>
                </td>                
            </tr>
            <tr>
                <th>联系电话</th>
                <td>
                    <?echo $member['mobile']; ?>
                </td>
                <th>联系电话</th>
                <td>
                    <?echo $member['project_mobile']; ?>
                </td>
                <th>联系电话</th>
                <td>
                    <?echo $member['business_mobile']; ?>
                </td>                              
            </tr>
            <tr>
                <th>传真</th>
                <td>
                    <?echo $member['fax']; ?>
                </td>
            </tr>                                                                                                                                                                                                                           
        </tbody>
    </table>


    <table class="table table-bordered  table-striped">
        <thead>
            <tr>
                <th>近期事件</th>
                <th colspan="7"></th>
            </tr>                    
            <tr>
                <th>序号</th>
                <th>日期</th>
                <th>事件类型</th>
                <th>事件描述</th>
                <th>工单使用人</th>
                <th>事件状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>

            <? $i=0; foreach ($event_list as $key => $value) {
                $i+=1
            ?>
            <tr align="center">
                <td><? echo $i;?></td>
                <td><? echo $value['event_time'];?></td>
                <td><? echo $value['event_type_name'];?></td>
                <td><? echo $value['desc'];?></td>
                <td><? echo $value['name'];?></td>
                <td><?if($value['status']==1){echo "待添加";}if($value['status']==2){echo "待审核";}?></td>
                <td><a class="btn btn-primary" target="_blank" href="<?php echo site_url('ctl=event&act=look_work_order')."&event_id=".$value['id'];?>">查看</a></td>
            </tr>
            <? } ?>
        </tbody>
    </table>      
<?php }else{?>
<p>查询不到客户信息!</p>
<?php }?>
</div>
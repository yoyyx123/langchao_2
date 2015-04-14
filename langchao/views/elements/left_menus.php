<!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li >
                            <a href="<?php echo site_url('ctl=home&act=index');?>"><span>首页</span></a>
                        </li>
                        <? foreach ($menu_list as $key => $value) {?>                        
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span><?echo $value['name'];?></span></a>
                            <ul class="nav nav-pills nav-stacked">
                            <?if(isset($value['child'])){foreach ($value['child'] as $k => $val) {?>
                                <li><a href='<?php echo site_url("ctl=".$val['ctl_file']."&act=".$val['ctl_act']);?>'><?echo $val['name'];?></a></li>
                            <?}}?>
                            </ul>                              
                        </li>
                        <?}?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->
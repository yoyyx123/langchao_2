<!-- topbar starts -->
<div class="navbar navbar-default" role="navigation">

    <div class="navbar-inner">
        <button type="button" class="navbar-toggle pull-left animated flip">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo site_url('ctl=home&act=index');?>"> <img alt="Charisma Logo" src="<?php echo base_url('/statics/img/logo20.jpg'); ?>" class="hidden-xs"/>
            <span>浪潮工贸</span></a>

        <!-- user dropdown starts -->
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"><?php echo $user_data['name'];?></span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('ctl=user&act=info');?>">个人设置</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo site_url('ctl=user&act=logout');?>">退出</a></li>
            </ul>
        </div>
        <!-- user dropdown ends -->

        <ul class="collapse navbar-collapse nav navbar-nav top-menu">
            <li>
                <form class="navbar-search pull-left">
                    <input placeholder="Search" class="search-query form-control col-md-10" name="query"
                           type="text">
                </form>
            </li>
        </ul>

    </div>
</div>
<!-- topbar ends -->

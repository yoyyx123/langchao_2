<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>上海浪潮工贸有限公司</title>
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="上海浪潮工贸有限公司">

    <!-- The styles -->
    <link id="bs-css" href="<?php echo base_url('/statics/css/bootstrap-cerulean.min.css'); ?>" rel="stylesheet">

    <link href="<?php echo base_url('/statics/css/charisma-app.css'); ?>" rel="stylesheet">
    <link href='<?php echo base_url('/statics/bower_components/fullcalendar/dist/fullcalendar.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/bower_components/fullcalendar/dist/fullcalendar.print.css'); ?>' rel='stylesheet' media='print'>
    <link href='<?php echo base_url('/statics/bower_components/chosen/chosen.min.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/bower_components/colorbox/example3/colorbox.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/bower_components/responsive-tables/responsive-tables.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/jquery.noty.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/noty_theme_default.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/elfinder.min.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/elfinder.theme.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/jquery.iphone.toggle.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/uploadify.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/animate.min.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/jquery-ui.css'); ?>' rel='stylesheet'>
    <link href='<?php echo base_url('/statics/css/jquery-ui.css'); ?>' rel='stylesheet'>


    <link href='<?php echo base_url('/statics/css/bootstrap-datetimepicker.min.css'); ?>' rel='stylesheet'>
    <link rel="stylesheet/less" type="text/css" href="<?php echo base_url('/statics/css/build_standalone.less'); ?>">
    <!-- jQuery -->
    <script src="<?php echo base_url('/statics/bower_components/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('/statics/js/jquery-ui.js'); ?>"></script>
    <script src="<?php echo base_url('/statics/js/ajaxfileupload.js'); ?>"></script>


   <script src="<?php echo base_url('/statics/js/bootstrap-datetimepicker.js');?>"></script>
   <script src="<?php echo base_url('/statics/js/bootstrap-datetimepicker.zh-CN.js');?>"></script>
   <script src="<?php echo base_url('/statics/js/laydate/laydate.js');?>"></script>

    
    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('/statics/js/html5.js'); ?>"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
<?php $this->load->view('elements/header.php'); ?>
<div class="ch-container">
    <div class="row">
        <?php $this->load->view('elements/left_menus.php'); ?>
        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <?php echo $content_for_layout; ?>
            <!-- content ends -->
        </div>
    </div>
<?php $this->load->view('elements/footer.php'); ?>
</body>
</html>


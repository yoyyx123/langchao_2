<div class="row">
    <table>
        <tbody>
	        <tr>
	            <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
	        </tr>
        </tbody>             
    </table>	
     <div class="box col-md-12">
        <div class="box col-lg-2 col-md-2"></div>
        <div class="box col-md-7  col-md-7">
            <iframe width="100%" height="100%" src="<?echo (str_replace('.xlsx', '.htm', $path));?>"></iframe>
        </div>
        <div class="box col-md-3 col-lg-3"></div>
    </div>
</div>
<input type='hidden' id="id" value="<?echo $id;?>">



<div id="dialog" title="窗口打开" style="display:none;">
</div>


<script src="<?php echo base_url('/statics/bower_components/jquery/jquery.min.js'); ?>"></script>
<script type="text/javascript">

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url('ctl=cloud&act=doc_look');?>';
    var getobj = {};
    getobj.id=$('#id').val();
    if(per_page>0){
        getobj.per_page=per_page;
    }
    jQuery.each(getobj, function(k,v) {
        url = url+"&"+k+"="+v;
    });
    window.location.href = url;
}

</script>
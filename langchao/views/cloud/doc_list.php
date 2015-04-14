<div class="row">
    <div class="box col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center;"><h4>文档下载</h4></th>
                </tr>               
                <tr>
                    <th>序号</th>
                    <th>名称</th>
                    <th>浏览次数</th>
                    <th>下载次数</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($doc_list as $key => $value) {?>
                <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $value['name'];?></td>
                    <td><?php echo $value['look'];?></td>
                    <td><?php echo $value['download'];?></td>
                    <td>
                        <?if ($value['type'] != 'doc'){?>
                        <a class="btn btn-info" href="<?php echo site_url(array('ctl'=>'cloud', 'act'=>'doc_look')).'&id='.$value['id'] ?>" target="_blank" doc_id='<?php echo $value['id'];?>'>预览</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?}?>                        
                        <a class="btn btn-primary download" doc_id='<?php echo $value['id'];?>'>下载</a>
                    </td>
                </tr>
                <?php $i++;} ?>
            </tbody>
            <tbody>
                <tr>
                    <td colspan="10"><?php $this->load->view('elements/pager'); ?></td>
                </tr>
            </tbody>             
        </table>
    </div>
</div>



<div id="dialog" title="窗口打开" style="display:none;">
</div>

<script type="text/javascript">
$(function() {
        $(".download").click(function() {
            _self = this;
            url = "<?php echo site_url(array('ctl'=>'cloud', 'act'=>'doc_download'))?>"+"&id="+$(this).attr('doc_id')+"&type=download",
            window.location.href=url;
        });

        $(".dolook").click(function() {
            _self = this;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(array('ctl'=>'cloud', 'act'=>'doc_look'))?>",
                data: "id="+$(this).attr('doc_id'),
                success: function(result){
                    $("#dialog").html(result);
                    $("#dialog").dialog({
                        autoOpen : false,
                        width : 700,
                        title : ('修改客户信息'),
                        modal: true,

                    });
                    $("#dialog").dialog("open");
                }
             });
        });

})

var sel_time_data = function (per_page) {
    var url = '<?php echo site_url('ctl=member&act=manage');?>';
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
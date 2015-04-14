<?php echo $this->pagination->create_links();?> 总共 <?php echo $page_count;?> 页
<select onchange="sel_time_data(this.value)">
	<?php for($i=1;$i<=$page_count;$i++){?>
	<?if(isset($row_num) && !empty($row_num)){?>
	<option value="<?php echo $row_num*($i-1);?>" <?php if(isset($getdata['per_page']) && $getdata['per_page'] == $row_num*($i-1)){echo 'selected';}?> ><?php echo $i;?></option>
	<?}else{?>	
	<option value="<?php echo ROW_SHOW_NUM*($i-1);?>" <?php if(isset($getdata['per_page']) && $getdata['per_page'] == ROW_SHOW_NUM*($i-1)){echo 'selected';}?> ><?php echo $i;?></option>
	<?php }}?>
</select>
共 <?php echo $total_rows;?> 条
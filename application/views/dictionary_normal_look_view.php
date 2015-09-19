<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />


<script src="lib/jquery.js"              	  type="text/javascript"></script>
<script src="js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="js/Public.js"                    type="text/javascript"></script>
<script src="lib/jquery.jgrowl.js"             type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("select[name='name_type']").change(function(){ //事件發生  
		var url=$(this).find('option:selected').val();  
		location.href='<?php echo site_url('dictionary/normal')?>'+'/'+url;
	});  
	
	$("#bt_addValue").click(function(){ //事件發生
		var url=$("select[name='name_type']").find('option:selected').val(); 
		location.href='<?php echo site_url('dictionary/normalAdd')?>'+'/'+url;
	});
	
	$("#bt_addType").click(function(){ //事件發生
		location.href='<?php echo site_url('dictionary/normalAddNewType')?>';
	});
});  

function onOrderClick(order_by)
{
	var sort_order='<?php echo $sort_order;?>';
	if(sort_order == 'desc')
		sort_order='asc';
	else
		sort_order='desc';
	var url=$("select[name='name_type']").find('option:selected').val(); 
	location.href='<?php echo site_url('dictionary/normal')?>'+'/'+url+'/'+order_by+'/'+sort_order;
}
</script>
</head>
<body>
<div class="page_main page_tops">
	 <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 查看字典</div>
         <div class="nav_other"></div>
	</div>
	<div class="func-panel">
			 <div class="left">
			 	 <?php echo form_dropdown("name_type",$nameTypeItems['nameTypeOptions'],$nameTypeItems['nameDefaultType']);?>
			 </div>
			 <div align='right' class="right">
             	 <input id='bt_addType' type="button" name="btnSearch" value="添加项" class="btnAdd"/>
				 <input id='bt_addValue' type="button" name="btnSearch" value="添加值" class="btnAdd"/>       
				 <input  id='bt_del' type="button" name="btnSearch" value="删除 " class="btnDel" />
			 </div>
            <div style="clear:both;"></div> 
	</div>	
	<div class="work-list">
		<table class="dataTable" cellspacing="0" style="width:100%;">
        <thead>
			<tr class="dataHead">
				<td align="center" scope="col" style="width:20px;">
                    <input id="cbSelectAll" name="cbAll" type="checkbox" value="0" />
                </td>
                <td scope="col" style="width:20px;display:none"><a onClick="onOrderClick('name_id')">ID</a></td>
                <td scope="col" style="width:28px;"><a onClick="onOrderClick('name_value')">键值</a></td>
                <td scope="col"><a onClick="onOrderClick('name_text')">名字</a></td>
                <td scope="col" style="width:28px;">修改</td>
			</tr>
           </thead>
       		<tbody>
           <?php foreach($list_data as $item){?>
            <tr class='c1' onMouseOut="ChangeStyle(this,'c1')" onMouseOver="ChangeStyle(this,'c2')" style="cursor:hand;">
                <td align="center" style="width:20px;">
                    <input name="cbData" type="checkbox" id="" value="1001" />
                </td>
                <td align="center" style="display:none" width="20px"><?php echo $item['name_id'];?></td>
                <td align="center" style="width:28px;"><?php echo $item['name_value'];?></td>
                <td align="center"><?php echo $item['name_text'];?></td>
                <td align="center" style="width:28px;"><a href="<?php echo site_url('dictionary/normalModify/'.$item['name_id'])?>"><img src='images/edit.gif' border=0 title='修改' /></a></td>
            </tr>    
            <?php }?> 
            </tbody>
		</table>
        
		<div class="work-pagination">
				<?php if(strlen($pagination)) {?>
					<font color="blue" size="1px"></font> </span><?php echo $pagination;?>
				<?php } ?>
		</div>
	</div>
</div>
<input type='hidden' id='bt_del_post_url' value='<?php echo site_url("dictionary/ajaxDel");?>'>
</body>
</html>
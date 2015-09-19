<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

<script src="js/jquery-1.6.4.js" type="text/javascript"></script>
<script src="js/Public.js"  type="text/javascript"></script>
<script src="js/work.js"  type="text/javascript"></script>
<script src="js/call.js"  type="text/javascript"></script>
<script>
	$(document).ready(function(){
		$('#bt_del').click(function(){
			$ids=[];
			var datas=getSelectedItem();
			//$req={'ids':[]};
			//$req.ids=datas;
			$('#example tbody tr').each(function(i){			
				var id = this.id;
				if($(this).children("td").children(":checkbox").attr("checked"))
					$ids.push(id);
					alert(id);
				
			});
			alert($ids);		
			//$.post("<?php //echo site_url('role/ajax_delete')?>",$req,function(res){	
				//if(res.ok)
					//location.href="<?php //echo site_url('role/look')?>";						
			//});
			
		});
	});

</script>
</head>
<body>
<div class="page_main page_tops">
	    <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 角色管理</div>
         <div class="nav_other"></div>
		</div>
	<div class="func-panel">
			 <div class="left">角色ID: <input type="text" id="search_text">
			 	<input type="button" name="btnSearch" value="搜索" class="btnSearch"/>
			 </div>
			 <div align='right' class="right">
				 <input  type="button" name="btnSearch" value="添加" class="btnAdd" onClick="javascript:location.href= '<?php echo site_url("role/add")?>'"/>
				 <input  id='bt_del' type="button" name="btnSearch" value="删除 " class="btnDel" />
                 <input  id='bt_del_post_url' type='hidden' value='<?php echo site_url("role/ajax_delete");?>'>
			 </div>		
			 <div style="clear:both;"></div>  
	</div>	
			 
	<div class="work-list" style="width:100%">
    	
		<table id="example" class="dataTable" cellpadding="0" cellspacing="0" >
        	<thead>
			<tr  class="dataHead">
				<td id="cbAll" align="center" scope="col" style="width:20px;">
                    <input  name="cbAll" type="checkbox" value="0" />
                </td>
                 <?php foreach($columns as $key=>$value){?>
	                <td scope="col" class="sort_<?php echo $sort_order?>" >
	                    <?php echo anchor('role/look/0/'.$value.'/'.($sort_order == 'asc'?'desc':'asc'),$key,'title="News title"');?>
	                </td>
                <?php } ?> 
                <td scope="col">修改
                </td>
			</tr>
            </thead>
            <tbody>
			<?php foreach($list_data as $item){?>
				<tr id ="<?php echo $item->id;?>" style="cursor:hand;">
					<td align="center" style="width:20px;">
	                    <input name="cbData" type="checkbox"></td>
	                <td align='center' ><?php echo $item->id;?></td>
	                <td align='center' ><?php echo $item->role_name;?></td>
	                <td align='center' ><?php echo $item->role_stime;?></td>    
	                <td align="center" style="width:40px;"><a href="<?php echo site_url('role/modify/'.$item->id)?>"><img src='images/edit.gif' border=0 title='修改' /></a></td>
				</tr>
			<?php }?>
            </tbody>
		</table>
        	<div class="work-pagination">
				<?php if(strlen($pagination)) {?>
					<font color="blue" size="1px">分页:</font> </span><?php echo $pagination;?>
				<?php } ?>
			</div>
	</div>
</div>
</body>
</html>

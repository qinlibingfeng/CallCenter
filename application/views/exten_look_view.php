<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />


<script src="<?php echo $this->config->item('base_url') ?>/www/js/jquery-1.6.4.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/Public.js"  type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/work.js"  type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/call.js"  type="text/javascript"></script>

</head>
<body>
<div class="page_main page_tops">
	 <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：<a href="Index.php">首页</a> &gt; 分机管理</div>
         <div class="nav_other"></div>
		</div>
	<div class="func-panel">
			 <div class="left">分机名: <input type="text" id="search_text">
			 	<input type="button" name="btnSearch" value="搜索" class="btnSearch"/>
			 </div>
			 <div align='right' class="right">
				 <input  type="button" name="btnSearch" value="添加" class="btnAdd" onClick="javascript:location.href= '<?php echo site_url("exten/add")?>'"/>
				 <input  id='bt_del' type="button" name="btnSearch" value="删除 " class="btnDel" />
			 </div>		
			 <div style="clear:both;"></div>  
	</div>	
			 
	<div class="work-list" style="width:100%">
    	
		<table class="dataTable" cellspacing="0"  style="width:100%;">
        	<thead>
			<tr class="dataHead">
				<td align="center" scope="col" style="width:20px;">
                    <input id="cbSelectAll" name="cbAll" type="checkbox" value="0" />
                </td>
                 <?php foreach($columns as $key=>$value){?>
	                <td scope="col" class="sort_<?php echo $sort_order?>" >
	                    <?php echo anchor('exten/look/0/'.$value.'/'.($sort_order == 'asc'?'desc':'asc'),$key,'title="News title"');?>
	                </td>
                <?php } ?> 
                <td scope="col">修改
                </td>
			</tr>
            </thead>
            <tbody>
			<?php foreach($list_data as $item){?>
				<tr  style="cursor:hand;">
					<td align="center" style="width:20px;">
	                    <input name="cbData" type="checkbox"></td>
	                <td align='center' ><?php echo $item->ext;?></td>
	                <td align='center' ><?php echo $item->devicetype;?></td>
	                      
	                <td align="center" style="width:40px;"><a href="<?php echo site_url('exten/modify/'.$item->ext)?>"><img src='images/edit.gif' border=0 title='修改' /></a></td>
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

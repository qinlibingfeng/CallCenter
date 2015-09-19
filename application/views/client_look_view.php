<html>
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
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 所有客户</div>
         <div class="nav_other"></div>
		</div>
	<div class="func-panel">
			 <div class="left">用户名: <input type="text" id="search_text">
			 	<input type="button" name="btnSearch" value="搜索" class="btnSearch"/>
			 </div>
			 <div align='right' class="right">
				 <input  type="button" name="btnSearch" value="添加" class="btnAdd" onClick="javascript:location.href= '<?php echo site_url("client/add")?>'"/>
				 <input  id='bt_del' type="button" name="btnSearch" value="删除 " class="btnDel" />
			 </div>		
			 <div style="clear:both;"></div>  
	</div>	
			 
	<div class="work-list" style="width:100%">
		<table class="dataTable" cellspacing="0" rules="all" border="1"  style="width:100%;border-collapse:collapse;">
			<tr>
				<th align="center" scope="col" style="width:20px;">
                    <input id="cbSelectAll" name="cbAll" type="checkbox" value="0" />
                </th>
                 <?php foreach($columns as $key=>$value){?>
	                <th scope="col" class="sort_<?php echo $sort_order?>" >
	                    <?php echo anchor('client/look/0/'.$value.'/'.($sort_order == 'asc'?'desc':'asc'),$key,'title="News title"');?>
	                </th>
                <?php } ?> 
                
                <th scope="col">呼叫
                </th>
                <th scope="col">修改
                </th>
			</tr>
			<?php foreach($list_data as $item){?>
				<tr class='c1' onMouseOut="ChangeStyle(this,'c1')" onMouseOver="ChangeStyle(this,'c2')" style="cursor:hand;">
					<td align="center" style="width:20px;">
	                    <input name="cbData" type="checkbox"></td>
	                <td align='center' style='width:70px'><?php echo $item->name;?></td>
	                <td align='center' style='width:80px'><?php echo $item->cell_phone;?></td>
	                <td align='center' ></td>	              
	                 <td align="center" style="width:40px;"><a onclick='call("<?php echo $item->cell_phone;?>")'><img src='images/dxzx.png' border=0 title='呼叫' /></a></td>
	                <td align="center" style="width:40px;"><a href="<?php echo site_url('client/modify/'.$item->id)?>"><img src='images/edit.gif' border=0 title='修改' /></a></td>
				</tr>
			<?php }?>
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
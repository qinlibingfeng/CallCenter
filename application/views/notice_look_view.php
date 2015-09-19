<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

<script src="<?php echo $this->config->item('base_url') ?>/www/js/jquery-1.6.4.js"              type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/Public.js"                    type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/work.js"                      type="text/javascript"></script>
<script>
	function onPreviewNotice(noticeId,noticeTitle){
		window.parent.iAddTab(noticeTitle,"<?php echo site_url('notice/preview')?>"+"/"+noticeId);
	}
</script>
</head>
<body>
<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 系统公告</div>
         <div class="nav_other"></div>
	</div>
	<div class="func-panel">
			 <div class="left">标题: <input type="text" id="search_text">
			 	<input type="button" name="btnSearch" value="搜索" class="btnSearch"/>
			 </div>
			 <div align='right' class="right">
				 <input  type="button" name="btnSearch" value="添加 " onClick="javascript:location.href= '<?php echo site_url("notice/add"."/".$agentId )?>'"  class="btnAdd"/>
				 <input  id='bt_del' type="button" name="btnSearch" value="删除 " class="btnDel" />
			 </div>
             <div style="clear:both;"></div> 
	</div>	
	 <table width="100%" cellpadding="0" cellspacing="0" class="dataTable" id="data_table3">
			<thead>
            <tr class="dataHead">
				<td style="width:20px">
                    <input id="cbSelectAll" name="cbAll" type="checkbox" value="0" />
                </td>
                <?php foreach($columns as $key=>$value){?>
	                <td  class="sort_<?php echo $sort_order?>" >
	                    <?php echo anchor('notice/look/'.$agentId.'/0/'.$value.'/'.($sort_order == 'asc'?'desc':'asc'),$key,'title="News title"'); ?>
	                </td>
                <?php } ?>      
                <td style="width:40px">修改
                </td>
             </tr>
			</thead>
			<?php foreach($list_data as $item){?>
				<tr  style="cursor:hand;">
					<td>
	                    <input name="cbData" type="checkbox" id="" value="1001" />
	                </td>
	                <td><?php echo $item['notice_id'];?></td>
	                <td><a href="javascript:onPreviewNotice('<?php echo $item['notice_id'];?>','<?php echo $item['notice_title'];?>')" ><?php echo $item['notice_title'];?></a></td>
                    <td><?php echo $item['notice_ctime'];?></td>
                    <td><a href="<?php echo site_url('notice/modify/'.$item['notice_id'].'/'.$agentId);?>"><img src='images/edit.gif' border=0 title='修改' /></a></td>
				</tr>
		  	<?php }?>
		</table>
		<div class="work-pagination">
				<?php if(strlen($pagination)) {?>
					<font color="blue" size="1px">分页:</font> </span><?php echo $pagination;?>
				<?php } ?>
		</div>
</div>

<input type='hidden' id='bt_del_post_url' value='<?php echo site_url("notice/ajax_del");?>'>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link href="css/main.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.6.4.js"              type="text/javascript"></script>
<script src="js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="js/Public.js"                    type="text/javascript"></script>
<script src="js/work.js"                      type="text/javascript"></script>
</head>
<body>
<div class="page_main page_tops">
	 <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 时钟</div>
         <div class="nav_other"></div>
	</div>
	<div class="func-panel">
			 <div class="left">标题: <input type="text" id="search_text">
			 	<input type="button" name="btnSearch" value="搜索" class="btnSearch"/>
			 </div>
			 <div align='right' class="right">
				 <input  type="button" name="btnSearch" value="添加 " onClick="javascript:location.href= '<?php echo site_url("plan/clockAdd")?>'"  class="btnAdd"/>
				 <input  id='bt_del' type="button" name="btnSearch" value="删除 " class="btnDel" />
			 </div>
             <div style="clear:both;"></div> 
	</div>	

		<table class="dataTable" cellspacing="0"   style="width:100%;border-collapse:collapse;">
        <thead>
			<tr class="dataHead">
				<td align="center" scope="col" style="width:20px;">
                    <input id="cbSelectAll" name="cbAll" type="checkbox" value="0" />
                </td>
                <td scope="col" style="width:20px;">ID</td>
                <td scope="col" style="width:28px;">启用</td>
                <td scope="col">内容</th>
                <td scope="col" style="width:28px;">修改</td>
			</tr>
           </thead>
           <tbody>
            <?php foreach($list_data as $item) {?>
            <tr>
                <td align="center" style="width:20px;">
                    <input name="cbData" type="checkbox" id="" value="1001" />
                </td>
                <td align="center" width="20px"><?php echo $item['id'];?></td>
                <td align="center" style="width:28px;"><?php echo $item['enable']==0?'否':'是';?> </td>
                <td align="center"><?php echo $item['title'];?> </td>
                <td align="center" style="width:28px;"><a href="<?php echo site_url('plan/clockModify/'.$item['id']);?>"><img src='images/edit.gif' border=0 title='修改' /></a></td>
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

<input type='hidden' id='bt_del_post_url' value='<?php echo site_url("notice/ajax_del");?>'>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link href="css/main.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.6.4.js"              type="text/javascript"></script>
<script src="js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="js/Public.js"                    type="text/javascript"></script>
<script>
	$(document).ready(function(){
		$('#btnModifyAdmin').click(function(){
			location.href="<?php echo site_url('user/modify/1000/1000/');?>";
		});
	});
</script>
</head>
<body>
<div class="page_main page_tops">
    <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 系统管理</div>
         <div class="nav_other"></div>
	</div>
    <div class="func-panel">
                 <div class="left">用户名: <input type="text" id="search_text">
                    <input type="button" name="btnSearch" value="搜索" class="btnSearch"/>
                 </div>
                 <div align='right' class="right">
                 	 <?php echo $agentId=='1000'?'<input  type="button" id="btnModifyAdmin" value="admin" class="btnAdd"/>':'' ?>
                
                     <input  type="button" name="btnSearch" value="添加 " onClick="javascript:location.href= '<?php echo site_url("user/add")."/".$agentId;?>'"  class="btnAdd"/>
                     <input  id='bt_del' type="button" name="btnSearch" value="删除 " class="btnDel" />
                 </div>
                  <div style="clear:both;"></div>            
        </div>  	
	 <table width="100%" cellpadding="0" cellspacing="0" class="dataTable" id="data_table3">
			<thead>
            	<tr class="dataHead">
                    <td  scope="col" style="width:20px;">
                        <input id="cbSelectAll" name="cbAll" type="checkbox" value="0" >
                    </td>
                    <?php foreach($columns as $key=>$value){?>
                        <td scope="col" class="sort_<?php echo $sort_order?>" >
                            <?php echo anchor("system/user/$agentId/0/".$value.'/'.($sort_order == 'asc'?'desc':'asc'),$key,'title="News title"');?>
                        </td>
                    <?php } ?>      
                    <td scope="col">修改
                    </td>
                </tr>
			</thead>
            <tbody>
			<?php foreach($list_data as $item){?>
				<tr>
					<td  style="width:20px;">
	                     <?php echo ($item->code==$agentId)?'':'<input name="cbData" type="checkbox"/>';?>
	                </td>
	                <td style="width:100px;"><?php echo $item->code;?></td>
	                <td  style="width:100px;"><?php echo $item->name;?></td><td>
	                    <span id=""><?php echo $item->department_name;?></span>
	                </td>
                    <td>
	                    <span id=""><?php echo $item->role_name;?></span>
	                </td>                    
                    <td style="width:40px;">
                     <?php echo '<a href="'.site_url('user/modify/'.$item->code.'/'.$agentId).'"><img src=\'images/edit.gif\' border=0 title=\'修改\' /></a>';?>                
                    </td>
				</tr>
		  	<?php }?>
            </tbody>
		</table>
		<div class="work-pagination">
				<?php if(strlen($pagination)) {?>
					<font color="blue" size="1px">分页:</font> </span><?php echo $pagination;?>
				<?php } ?>
		</div>
<input type='hidden' id='bt_del_post_url' value='<?php echo site_url("user/ajax_del");?>'>
</div>
</body>
</html>
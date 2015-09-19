<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>

<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />


<script src="js/jquery-1.6.4.js" type="text/javascript"></script>
<script src="js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="js/Public.js"  type="text/javascript"></script>
<script src="js/agent.js"  type="text/javascript"></script>

<script>
$(document).ready(function(){
	$('#js_goback').click(function(){
		window.history.go(-1);
	});
});
</script>
</head>
<body>
 <?php echo form_open(site_url('dictionary/'.$dst))?>
<div class='page_main page_tops'>
     <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt;  <?php echo $title?></div>
         <div class="nav_other"></div>
	</div>
	<div class="func-panel">
		<div class='left'>   
			
        </div>
		<div align='right' class='right'>
			<input type='submit' value='保存'  class='btnSave'/>
			<input id='js_goback' type='button' onClick="javascript:location.href= '<?php echo site_url("dictionary/normal")?>'" value='返回' class='btnDel'/>
		</div>
        <div style="clear:both"></div>
	</div>
	<div class='work-list'>	
    		<center><p><font color="#FF0000"><?php echo validation_errors(); ?></font></p></center>
            <?php if($error != ''){?>
           	 <center><p><font color="#FF0000"><?php echo $error;?></font></p></center>
            <?php }?>
			  <fieldset ><legend onClick="show_div('data_table1');">添加项</legend>
				<table class='property'>
                	<tr><td class="name">添加项:</td><td colspan="3"><input name="name_type_text" type="text" value="" /></td></tr>
					<tr>
						<td class='name'>键值:</td>
                        <td class='value'><input name='key' value='' style='width:99%;' type='text'></td>
                        <td class='name'>名字:</td>
                        <td class='value'><input name='name'  value='' style='width:99%;'></td>
					</tr>	
				</table>
			</fieldset>
	</div>  
</div>
 <?php echo form_close()?>
</body>
</html>
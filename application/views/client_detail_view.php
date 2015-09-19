<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo base_url() ?>/www/"/>

<link rel="stylesheet" href="css/work.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/bt.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/list.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/examples.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/examples.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/jquery.jgrowl.css" type="text/css" media="screen"/>

<script src="lib/jquery.js" type="text/javascript"></script>
<script src="lib/jquery.jgrowl.js" type="text/javascript"></script>
<script src="js/bt.js" type="text/javascript"></script>
<script src="js/Public.js" type="text/javascript"></script>
</head>
<body>
	<div class='work-space'>
		<div class='work-title'>客户资料 >> 个人信息</div>
	<?php echo form_open(site_url("client/".$dst))?>
		<div class="func-panel">
			 <div class="left"></div>
			 <div align='right' class="right">
				 <input  type="submit" value="保存"   class="btnSave"/>
                 <input  type='button' value='返回'  onclick='javascript:location.href="<?php echo site_url('client/look');?>"' class='btnDel'/>
			 </div>
			 <div style=”clear:both”></div> 
		</div>	
		<div class='work-list'  style='margin-top:8px;'>
			<div class='panelOne'>
				<div class='title'>&nbsp;&nbsp;&nbsp;&nbsp;<a id='panelOneTitle'>详细资料</a></div>
				<div class='content' style="width:100%">
					<table  class='property' >
					<tr>
						<td class='name' >真实姓名:</td><td class='value'> <input name='name'  style='width:100%;' value='<?php echo isset($item[0]->name)?$item[0]->name:'' ;?>'  type='text'></td>
						<td class='name'>性别:</td><td class='value'><input name='sex' value='' style='width:100%;' type='text'></td>
					</tr>
					<tr>
						<td class='name'>联系电话: </td><td class='value'> <input name='phone'  value="<?php echo isset($item[0]->cell_phone)?$item[0]->cell_phone:'';?>" style='width:100%;' type='text'></td>
						<td class='name'>手机:</td><td class='value'><input name='cell_phone' value='' style='width:100%;' type='text'></td>
					</tr>
					<tr>
						<td class='name'>邮箱:</td><td class='value'><input name='email' value=''  style='width:100%;' type='text'></td>
						<td class='name'>QQ(MSN):</td><td class='value'><input name='qq' value='' style='width:100%;'  type='text'></td>
					</tr>
				</table>
				</div>
			</div>
		</div>
		<?php echo form_close()?>
	</div>
</body>
</html>
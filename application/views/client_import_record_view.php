<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link rel="stylesheet" href="css/work.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/bt.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/list.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/examples.css" type="text/css" media="screen" />

<script src="<?php echo $this->config->item('base_url') ?>/www/js/jquery-1.6.4.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/Public.js"  type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/work.js"    type="text/javascript"></script>
</head>
<body>
<div class='work-space'>
	<div class="work-title">客户资料  >> 导入记录</div>
	<div class="func-panel">
			 <div class="left">
			 </div>
			 <div align='right' class="right">
				 <input  type="button" name="btnSearch" value="导入客户 " class="btnAdd" onClick="javascript:location.href='<?php echo site_url("client/import")?>'"/>
				 <input  id='bt_del' type="button" name="btnSearch" value="撤销 " class="btnUndo" />
			 </div>
	</div>		
	<div class='work-list'>
		<table class="gv" cellspacing="0" rules="all" border="1" id="ctl00_Contentplaceholder3_gvList" style="width:100%;border-collapse:collapse;">
			<tr>
				<th align="center" scope="col" style="width:20px;">
                    <input id="cbSelectAll" name="cbAll" type="checkbox" value="0" />
                </th>
                <th scope="col">编号
                </th>
                <th scope="col">操作员
                </th>
                <th scope="col">导入时间
                </th>
                <th scope="col">源文件
                </th>
                <th scope="col">地址
                </th>
			</tr>
			<tr class='c1' onMouseOut="ChangeStyle(this,'c1')" onMouseOver="ChangeStyle(this,'c2')" style="cursor:hand;">
				<td align="center" style="width:20px;">
                    <input name="cbData" type="checkbox" id="ctl00_Contentplaceholder3_gvList_ctl03_cbSelect" value="1001" />
              	<td align='center' style='width:70px'></td>
                <td align='center' style='width:70px'>欧阳修顺</td>
                <td align='center' style='width:120px'>2011-09-11 21:00:00</td>
                <td align='center' style=''></td>	              
                <td align='center' ></td>
			</tr>	
		</table>
	</div>
</div>
</body>
</html>

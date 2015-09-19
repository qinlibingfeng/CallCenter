<html>
<head>
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="icon" href="" mce_href="" type="image/x-icon">
<link rel="shortcut icon" href="" mce_href="" type="image/x-icon">
<script src="js/jquery-1.6.4.js"              type="text/javascript"></script>
<script>
	function onProxyEvent(type,msg){
		//var  json_msg=eval( '( '+msg+' )' ); 
		alert(msg)
	}
</script>	
</head>
<body>
<?php echo form_open('login/log')?>
<div align="center" style="padding-top:200">
	<div id="main" style="width:414">
	<div id="main-top"><img width=414 src="images/login_01.png"></div>
	<div>
		<div style="float:left;height:147"><img style="width:9;height:147" src="images/login_02.png"></div>
		<div style="float:left;height:147"><div><img style="width:97;height:98" src="images/login_03.jpg"></div><div><img style="width:97;height:49" src="images/login_15.png"></div></div>
		<div style="float:left;height:147"><img style="width:71;height:147" src="images/login_04.png"></div>
		<div style="float:left;height:147">			
			<div align=left style="background-image: url(images/login_07.png);"><input type="text" name="name" style="width:172" class="blackInput"></div>
			<div ><img height=10 width=172 src="images/login_07.png"></div>
			<div align=left style="background-image: url(images/login_09.png);">
				<input type="password"  name="passwd" style="width:172;height:21" class="blackInput">
			</div>
			<div><img height=5 width=172  src="images/login_09.png"></div>
			<div><img height=31 width=172  src="images/login_09.png"></div>
			<div><img height=10 width=172  src="images/login_09.png"></div>
			<div align=left>
				<div style="float:left;">
				<input type="image" src="images/login_16.png" onClick="submit()"></div>
				<div style="float:left"><img height=25 width=104 src="images/login_09.png"></div>
			</div>
			<div align=left><img height=19 width=172 src="images/login_18.png"></div>
		</div>	
		<div style="float:left;height:147"><img style="width:65;height:147" src="images/login_06.png"></div>
	</div>
</div>
</div>
<?php echo form_close()?>


</body>
</html>

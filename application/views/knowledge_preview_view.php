<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo base_url() ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

</head>
<body>
	<div>
        <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 浏览公告</div>
         <div class="nav_other"></div>
		</div>   
        <div class="layout-middle"></div>
		<div class='work-list'  style='width:100%;margin-top:8px;'>  
                <?php  echo isset($html)?$html:"";?>		
		</div>
	</div>
</body>
</html>

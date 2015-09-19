<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>
<link rel="stylesheet" href="www/css/zTree.css" type="text/css">
<link rel="stylesheet" href="www/css/ztree/zTreeStyle/zTreeStyle.css" type="text/css">
<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
<style>
	.dynamictable{ border:#000;}    	
</style> 
<style>
    	.dui-control{
			width:160px;
		}
		
		.person-info{
			font-size:14px;
			color:#0088DD;
		}
		.panelOne{
			margin-left:10px;
			margin-right:10px;
		}
</style> 
<script type="text/javascript" src="www/lib/jquery-1.6.4.js"></script>
<script type="text/javascript" src="www/lib/jquery.ztree.core-3.0.min.js"></script>
<script type="text/javascript" src="www/lib/myDynamicUI/dynamicUI.js" ></script>
<title>无标题文档</title>
<script>
$(document).ready(function(){
	$("#dynamicDiv").dynamicui({
		'elements':[[{colspan:1,lspace:0,type:3,name:'名字',id:'client_name',value:{default:'ysc',values:[{"id":"8","pId":"5","name":"\u79d1\u5fb7\u5b66\u9662","open":true},{"id":"26","pId":"5","name":"\u5b66\u96621","open":true},{"id":"27","pId":"26","name":"2","open":true}]}},{colspan:1,lspace:0,type:2,name:'专业',id:'client_major',value:{default:'文科',values:[{index:'文科',text:'文科'},{index:'理科',text:'理科'}]}}],[{colspan:3,lspace:0,type:4,name:'radio',id:'client_bmlx',value:{default:0,values:[{index:0,text:'文科'},{index:1,text:'理科'}]}}]]
	});
	
	$("#dynamicDiv").dynamicui.getIntDatas();
	$("#dynamicDiv").dynamicui.getTextDatas();
});
</script>
</head>

<body>
<table border="8" class="dynamictable" id="dynamicDiv"><tbody></tbody></table>
</body>
</html>
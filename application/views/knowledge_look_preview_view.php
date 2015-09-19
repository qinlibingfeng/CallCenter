<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>

<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />

<link rel="stylesheet" href="www/lib/ztree/css/demo.css" type="text/css">
<link rel="stylesheet" href="www/lib/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    
<script type="text/javascript" src="www/lib/ztree/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="www/lib/ztree/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="www/lib/ztree/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="www/lib/ztree/jquery.ztree.exedit-3.5.js"></script>


<style type="text/css" title="currentStyle">
			@import "www/lib/dataTable/css/demo_page.css";
			@import "www/lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
html{ height:100%;}
body { height:100%;}
</style>
<script>

var setting = {
			data: {
				simpleData: {
					enable: true
				}
			},
			view: {
				dblClickExpand: false
			},	
			callback: {
				onClick: zTreeOnClick
			}
		};

		zNodes=<?php echo json_encode($treeData);?>;	
		
		function zTreeOnClick(event, treeId, treeNode) {
			if(treeNode.isParent){
				zTree.expandNode(treeNode);
				return;	
			}
				
			var req={id:''};
			req.id=treeNode.dId;
			$.post("<?php echo site_url('knowledge/ajaxGetHtmlByTreeId')?>",req,function(res){	
				$('#pcontent').html(res.html);				  							
			});  		
		}

		var zTree;
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			zTree = $.fn.zTree.getZTreeObj("treeDemo");
			rMenu = $("#rMenu");
		});	
</script>
 
<style type="text/css">
div#rMenu {position:absolute; visibility:hidden; top:0; background-color: #555;text-align: left;padding: 2px;}
div#rMenu ul li{
	margin: 1px 0;
	padding: 0 5px;
	cursor: pointer;
	list-style: none outside none;
	background-color: #DFDFDF;
}
#treeDemo{
	width:200px;
	height:100%;
	border:0  #FFF;
}
	</style>   
</head>
<body scroll="auto">
<input id='agentId' type="hidden" value="<?php  echo $agentId;?>">
<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 所有客户</div>
         <div class="nav_other"></div>
	</div>
    <div class="layout-middle"></div>
    <div id="example" style='float:left; height:100%;'>
       	 	<ul id="treeDemo" class="ztree"></ul>
    		</ul>
   	</div>
    <div>
         <center>  
           <div id="pcontent"> </div>  
          </center>
           
    </div>
      
</div>

</body>
</html>
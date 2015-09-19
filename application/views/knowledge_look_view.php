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
			check: {
				enable: true
			},
			edit: {
				enable: true
			},		
			callback: {
				onDblClick: zTreeOnDblClick,
				onRightClick: OnRightClick,
				onNodeCreated: zTreeOnNodeCreated,
				onRemove: zTreeOnRemove,
				onRename: zTreeOnRename
			}
		};

		var zNodes =[
			{id:1, name:"无1右键菜单 1", open:true, noR:true,
				children:[
					   {id:11212, name:"节点 1-1", noR:true},
					   {id:12, name:"节点 1-2", noR:true}

				]},
			{id:2, name:"右键操作 2", open:true,
				children:[
					   {id:21, name:"节点 2-1"},
					   {id:22, name:"节点 2-2"},
					   {id:23, name:"节点 2-3"},
					   {id:24, name:"节点 2-4"}
				]},
			{id:3, name:"右键操作 3", open:true,
				children:[
					   {id:31, name:"节点 3-1"},
					   {id:32, name:"节点 3-2"},
					   {id:33, name:"节点 3-3"},
					   {id:34, name:"节点 3-4"}
				]}
  	 	];
		
		
		zNodes=<?php echo json_encode($treeData);?>;	
		
		function zTreeOnDblClick(event, treeId, treeNode) {
			window.parent.iAddTab("知识库","<?php echo site_url('knowledge/modifyLook/');?>"+'/'+treeNode.dId);
		}
		
		function zTreeOnNodeCreated(event, treeId, treeNode){
			
		}
		function zTreeOnRemove(event, treeId, treeNode){		
			$.post("<?php echo site_url('knowledge/ajaxDelKnowledgeTreeNode')?>",{dId:treeNode.dId},function(ret){
				
			});				
		}
		function zTreeOnRename(event, treeId, treeNode,isCancel){
			if(!isCancel){
				$.post("<?php echo site_url('knowledge/ajaxRenameKnowledgeTreeNode')?>",{dId:treeNode.dId,name:treeNode.name},function(ret){
					
				});	
			}
			
		}
		
		function OnRightClick(event, treeId, treeNode) {
			if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
				zTree.cancelSelectedNode();
				showRMenu("root", event.clientX, event.clientY);
			} else if (treeNode && !treeNode.noR) {
				zTree.selectNode(treeNode);
				showRMenu("node", event.clientX, event.clientY);
			}
		}

		function showRMenu(type, x, y) {
			$("#rMenu ul").show();
			if (type=="root") {
				$("#m_del").hide();
				$("#m_check").hide();
				$("#m_unCheck").hide();
			} else {
				$("#m_del").show();
				$("#m_check").show();
				$("#m_unCheck").show();
			}
			rMenu.css({"top":y+"px", "left":x+"px", "visibility":"visible"});

			$("body").bind("mousedown", onBodyMouseDown);
		}
		function hideRMenu() {
			if (rMenu) rMenu.css({"visibility": "hidden"});
			$("body").unbind("mousedown", onBodyMouseDown);
		}
		function onBodyMouseDown(event){
			if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length>0)) {
				rMenu.css({"visibility" : "hidden"});
			}
		}
		var addCount = 1;
		function addTreeNode() {
			hideRMenu();
			
			var newNode = { name:"增加" + (addCount++),dId:"test eName"};
			var sNode=zTree.getSelectedNodes()[0];
			if (sNode) {		
				$.post("<?php echo site_url('knowledge/ajaxAddKnowledgeTreeNode')?>",{pid:sNode.dId},function(ret){
					if(ret.isOk){
						newNode.dId=ret.dId;
						newNode.checked = zTree.getSelectedNodes()[0].checked;
						zTree.addNodes(zTree.getSelectedNodes()[0], newNode);
					}			
				});				
			} else {
				$.post("<?php echo site_url('knowledge/ajaxAddKnowledgeTreeNode')?>",{pid:0},function(ret){
					if(ret.isOk){
						newNode.dId=ret.dId;
						zTree.addNodes(null, newNode);
					}
					
				});	
			}
		}
		function removeTreeNode() {
			hideRMenu();
			var nodes = zTree.getSelectedNodes();
			if (nodes && nodes.length>0) {
				if (nodes[0].children && nodes[0].children.length > 0) {
					var msg = "要删除的节点是父节点，如果删除将连同子节点一起删掉。\n\n请确认！";
					if (confirm(msg)==true){
						zTree.removeNode(nodes[0]);
					}
				} else {
					zTree.removeNode(nodes[0]);
				}
			}
		}
		function checkTreeNode(checked) {
			var nodes = zTree.getSelectedNodes();
			if (nodes && nodes.length>0) {
				zTree.checkNode(nodes[0], checked, true);
			}
			hideRMenu();
		}
		function resetTree() {
			hideRMenu();
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
		}

		var zTree, rMenu;
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
	width:500px;
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
    	<div id="example" style='display:block'>
       	 	<ul id="treeDemo" class="ztree"></ul>
    	</ul>
   </div>
</div>
<div id="rMenu">
	<ul>
		<li id="m_add" onclick="addTreeNode();">增加节点</li>
		<li id="m_del" onclick="removeTreeNode();">删除节点</li>
		<li id="m_check" onclick="checkTreeNode(true);">Check节点</li>
		<li id="m_unCheck" onclick="checkTreeNode(false);">unCheck节点</li>
		<li id="m_reset" onclick="resetTree();">恢复zTree</li>
	</ul>
</div>
</body>
</html>
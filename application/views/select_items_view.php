<!DOCTYPE html>
<HTML>
 <HEAD>
  <TITLE> ZTREE DEMO </TITLE>
  <meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
  <base href="<?php echo base_url() ?>www/"/>
  <link rel="stylesheet" href="css/ztree/demo.css" type="text/css">
  <link rel="stylesheet" href="css/ztree/zTreeStyle/zTreeStyle.css" type="text/css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.ztree.core-3.0.min.js"></script>
  <script type="text/javascript" src="js/jquery.ztree.excheck-3.0.min.js"></script>
  
  <SCRIPT LANGUAGE="JavaScript">	
  		<!--
		var setting = {
			view: {
				selectedMulti: false
			},
			check: {
				enable: true
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				onCheck: onCheck
			}
		};

		var zNodes =[
			/*{ id:21, pId:2, name:"没有 checkbox 3"},
			{ id:2, pId:0, name:"随意勾选 父 2", open:true},
		
			{ id:22, pId:2, name:"随意勾选 子 3", open:true},
			{ id:221, pId:22, name:"随意勾选 孙 3", checked:true},
			{ id:222, pId:22, name:"随意勾选 孙 4"},
			{ id:223, pId:22, name:"没有 checkbox 4"},
			{ id:23, pId:2, name:"随意勾选 子 4", checked:true}*/
		];

		var zNodes=<?php echo $tree_nodes;?>;
		var clearFlag = false;
		function onCheck(e, treeId, treeNode) {
			
		}
		function createTree() {
			treeObj=$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			
		}

		$(document).ready(function(){
			createTree();			
			$("#init").bind("change", createTree);
			$("#last").bind("change", createTree);
			
		});
		
		function getSelectedAgents()
		{
		    var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
			var items= treeObj.getCheckedNodes(true);
			var data=new Array();
			for (var i in items)
			{
				if(items[i].level != 0)
					data.push(items[i].id);	
			}		
			return data;
		}
		function getSelectedAgentsName()
		{
			var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
			var items= treeObj.getCheckedNodes(true);
			var data=new Array();
			for (var i in items)
			{
				if(items[i].level != 0)
					data.push(items[i].name);	
			}		
			
			return data;
		}
		function getRoleId(){	
			return '<?php echo isset($role_id)?$role_id:"";?>';
		}
		function getConType(){
			return '<?php echo isset($con_type)?$con_type:"";?>';
		}
		
		function getAajxUrl(){
			return '<?php echo site_url('role/ajax_edit')?>';
		}
		//-->
	</SCRIPT>
 </HEAD>
<BODY scroll="no" style="border:0px; margin:0px;">
 <ul id="treeDemo" style="margin:0px;border:0px; width:190px;height:260px;" class="ztree"></ul>
</BODY>
</HTML>

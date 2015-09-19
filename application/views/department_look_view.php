<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo base_url() ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
<link rel="stylesheet" href="lib/jquery.jgrowl.css" type="text/css" media="screen" />
<link rel='stylesheet' href='lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css'/>
<style>
.page_main .index_wel{height:30px;display: inline-block;margin-right: auto;margin-left: auto;background: url(images/main_top_bg.jpg) repeat-x left top;width:100%;padding:4px 0 2px 10px;}
body{background:url(images/index_welcome_bgjpg.jpg) no-repeat right bottom;}
</style>
<style type="text/css" title="currentStyle">
			@import "lib/dataTable/css/demo_page.css";
			@import "lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="lib/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/work.js"></script>
<script type='text/javascript' src='lib/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type="text/javascript" src="lib/dataTable/js/jquery.dataTables.js"  ></script>
<script>

$(document).ready(function(){
	$('#btnAdd').click(function(){
		$("#inputData").dialog({
						autoOpen:true,
						modal: true,
						buttons:{
							"确认": function(){
									$req={'departmentName':''};
									$req.departmentName=$('#departmentName').attr('value');
									
									if($req.departmentName == ''){
										alert('部门名字不能为空');
										return;
									}
									$dialogHd=$(this);
									$.post("<?php echo site_url('department/ajaxAddDepartment')?>",$req,function($res){
										if($res.ok){												
											$dialogHd.dialog('destroy');
											alert('添加成功');
											refreashTable();
										}else{
											alert('添加失败');
										}									
									});		
							},
							"取消": function(){
								$(this).dialog( "close" );
							}
						},
						close: function(){
							$(this).dialog('destroy');
						}
				});		
	});
	$('#btnDel').click(function(){
			$ids=[];
			var datas=getSelectedItem();
			for(var i in datas){				
				var $item=[];
				$item.push('or');
				$item.push('varchar');
				$item.push('department_id');
				$item.push(datas[i]);	
				$ids.push($item);
			}
			$req={'ids':[]};
			$req.ids=$ids;
			$.post("<?php echo site_url('department/ajaxDelDepartment')?>",$req,function(res){	
				if(res.ok)
					refreashTable();								
			}); 

	});
	
	function refreashTable(){
		var oTable = $('#example').dataTable();
		oTable.fnDestroy();	
		$('#example').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"aoColumnDefs": [
				{
					"fnRender": function ( oObj ) {
						return '<input type=\"checkbox\"  value="'+ oObj.aData[0] +'"> ';
					},
					"aTargets": [0]
				}
			],
			"iDisplayLength": 25,
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers
			  //$('td:eq(1)', nRow).html("<a href='javascript:onClickNoticeTitle(\""+aData[1]+"\",\""+aData[0]+"\")'>"+aData[1]+"</a>");
    		},
			"aoColumns": [{"bSortable":false,"mDataProp":"0"},{"mDataProp":"1"},{"mDataProp":"2"}],
			"sAjaxSource": "<?php echo site_url('department/ajaxLook')?>",
			"oLanguage": {"sUrl": "<?php echo $this->config->item('base_url')?>/www/lib/dataTable/de_DE.txt"}
		});
	}
	
	refreashTable();
	
   }); 
</script>
</head>
<body>
<div id='inputData' style='width:300px;height:400px;display:none'><center>部门名称:<input id='departmentName' value=''/></center></div>
 	<div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 部门管理</div>
         <div class="nav_other"></div>
	</div>
    <div class="func-panel">
                 <div class="left">
                 </div>
                 <div align='right' class="right">
                     <input  id='btnAdd' type="button" name="btnAdd" value="添加 "/>
                     <input  id='btnDel' type="button" name="btnDel" value="删除 " class="btnDel" />
                 </div>
                  <div style="clear:both;"></div>            
        </div>
     <div>
<table width="100%" cellpadding="0" cellspacing="0" class="example" id="example">
                <thead>
                  <tr align="left" class="dataHead">
                  	<th id="cbAll" width="20px"><input   type="checkbox" value="全选" /></td>
                    <td width="40px">编号</td>
                    <td>部门名称</td>          
                </tr>
                </thead>
                <tbody>                
                </tbody>   
 	</table>
 	</div>
</body>

</html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo base_url() ?>/www/"/>

<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
<link rel='stylesheet' href='lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css' media="screen"/>
<script type="text/javascript" src="lib/jquery-1.6.4.js"></script>
<script type='text/javascript' src='lib/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type='text/javascript' src='lib/jquery/jquery.json-2.3.min.js'></script>
<style>
.view_data{width:100%}
</style>
<script>
function onAddAgentToRole(viewDataId,url){
				$("#cimport_frame").attr("src",url);
				$("#addAgentDialogDiv" ).dialog({
						autoOpen:true,
						modal: true,
						buttons:{
							"确认": function(){
								var data=document.getElementById("cimport_frame").contentWindow.getSelectedAgentsName();
								$("#"+viewDataId).attr('value', data.toString());
								$(this).dialog('destroy');
							},
							"取消": function(){
								$(this).dialog( "close" );
							}
						},
						close: function(){
							$(this).dialog('destroy');
						}
				});	
}

</script>
</head>
<body>
<div id="addAgentDialogDiv" style="display:none;height:340px;"><iframe id="cimport_frame" frameborder='0' style="margin:0px;" width="201px" height="280px" scrolling="no" name="cimport_frame"  ></iframe></div>
<?php echo form_open($dst)?>
<div class='"page_main page_tops"'>
		 <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 角色信息</div>
         <div class="nav_other"></div>
		</div>	
		<div class="func-panel">
			 <div ></div>
			 <div align='right'>
				 <input  type="submit" value="保存"   class="btnSave"/>
                 <input  type='button' value='返回'  onclick='javascript:location.href="<?php echo site_url('role/look');?>"' class='btnDel'/>
			 </div>
		</div>	
		<div>
                <fieldset><legend onClick="show_div('data_table2');">编辑角色</legend>
                <center><p><font color="#FF0000"><?php echo validation_errors(); ?></font></p></center>
                <center>
               		<div style='width:100%;' align="left">
                	<p>角色名称：<input name='role_name' size='30px' type='text' value='<?php echo $role_name;?>' size="10px"/></p>  </div>            
					<table width="100%" class='property'>      	
                    	<tr><th width="60px">权限</th><th width="30px">可用</th><th width="auto"> 可操作的项</th><th width="30px">编辑</th></tr>
                       	<tr><td>删除客户</td>
                            <td><?php echo form_checkbox('delete_agent_check', '1', $isCallDelClient);?></td>
                            <td colspan="2">               	
                            </td>
                         </tr>
                         <tr><td>导出客户</td>
                            <td><?php echo form_checkbox('export_client_check', '1', $isCanExportClient);?></td>
                            <td colspan="2">               	
                            </td>
                         </tr>
                         <tr><td>功能菜单</td>
                            <td><input name='look_client_check' type='checkbox'></td>
                            <td>
                            	<input id="func_view_data" name="look_func_data" class="view_data" type='text' value='<?php echo $look_func_data['names']; ?>'></td>
                            <td width="30px">
                                <input name='add_agent'  type="button" onClick="onAddAgentToRole('func_view_data','<?php echo site_url('role/select_items/3/'.$role_id)?>')" class='btnAdd' value="编辑">
                            </td>
                         </tr>
                        <tr><td>查询客户</td>
                            <td><input name='look_client_check' type='checkbox'></td>
                            <td> 
                            	<input id="lookClientView"  name="look_client_agnet_data" class="view_data"  type='text' value='<?php echo $look_client_agent_data ?>'></td>
                            <td>
                                <input name='add_agent'  onClick="onAddAgentToRole('lookClientView','<?php echo site_url('role/select_items/0/'.$role_id)?>')"  type="button"  class='btnAdd' value="编辑">
                             </td>
                         </tr>
                        <tr><td>通话记录</td>
                        	<td><input name='look_record_check' type='checkbox'></td>
                            <td>
                            	<input id="look_record_view" name="look_record_agnet_data" class="view_data"  type='text' value='<?php echo $look_record_agent_data;?>'>
                            </td>
                            <td>
                             	<input type="button"  onClick="onAddAgentToRole('look_record_view','<?php echo site_url('role/select_items/1/'.$role_id)?>')"  name='add_agent' value="编辑" class='btnAdd'>
                             </td>
                         </tr>
                           <tr><td>工单查看</td>
                        	<td><input name='order_check' type='checkbox'></td>
                            <td>
                            	<input id="order_view" name="order_agnet_data" class="view_data"  type='text' value='<?php echo $order_agent_data;?>'>
                            </td>
                            <td>
                             	<input type="button"  onClick="onAddAgentToRole('order_view','<?php echo site_url('role/select_items/2/'.$role_id)?>')"  name='add_agent' value="编辑" class='btnAdd'>
                             </td>
                         </tr>
                    </table>
                </center>
                </fieldset>
		</div>
        <?php echo form_close()?>
</div>

</body>
</html>
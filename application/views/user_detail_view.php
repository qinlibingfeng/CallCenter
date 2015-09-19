<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>

<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

<script src="<?php echo $this->config->item('base_url') ?>/www/js/jquery-1.6.4.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/Public.js"  type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>/www/js/agent.js"  type="text/javascript"></script>
</head>
<body>

<?php echo form_open($bt_func)?> 
<div class='page_main page_tops'>
	<div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 坐席用户</div>
         <div class="nav_other"></div>
	</div>   
	<div class='func-panel'>
		<div class='panel-left'></div>
		<div align='right' class='panel-right'>
			<input type='submit' value='保存'  class='btnSave'/>
			<input type='button' onClick="javascript:location.href= '<?php echo site_url("system/user"."/".$agentId)?>'" value='返回' class='btnDel'/>
		</div>
	</div>
    <div>
    		<center><p><font color="#FF0000"><?php echo validation_errors(); ?></font></p></center>
            <center><p><font color="#FF0000"><?php echo isset($error)?$error:''; ?></font></p></center>
            <fieldset><legend onClick="show_div('data_table2');">基本信息</legend>  
				<table class='property' >
					<tr>
						<td class='name'>坐席编号:</td>
                        <td class='value'> <input name='code' <?php echo isset($item[0]->code) ? "disabled='false'":"";?>  value='<?php echo isset($item[0])?$item[0]->code:"";?>' style='width:100%' type='text'></td>
                        <td class='name'>所在部门:</td>
                        		<td class='value'>
                        	 			<select name='department'  style='width:100%;height:20px'>
                                            <?php foreach($department_items as $ditem){ ?> 
                                            	<option value ="<?php echo $ditem['name_value'];?>"><?php echo $ditem['name_text'];?></option>
                                            <?php } ?>												
                                        </select>
                        </td>
					</tr>
					<tr>
						<td class='name'>用户密码:</td><td class='value'><input name='fpasswd' value='<?php echo isset($item[0])?$item[0]->passwd:"";?>'  style='width:100%'  type='text'></td>
						<td class='name'>所属角色:</td>
                        <td class='value'>
                                        <select name='role'  style='width:100%;height:20px'>
                                            <?php foreach($role_items as $role_item){ ?> 
                                            <option value ="<?php echo $role_item['id'];?>"><?php echo $role_item['name'];?></option>
                                            <?php } ?>												
                                        </select>
                                        
                        </td>
                     </tr>
					<tr>
                    	<td class='name'>重复输入:</td><td class='value'><input name='spasswd' value='<?php echo isset($item[0])?$item[0]->passwd:"";?>'  style='width:100%'  type='text'></td>
						<td class="name"></td>
                        <td class="value"></td>
					</tr>
				</table>



    </fieldset>
    <br>

  <fieldset><legend onClick="show_div('data_table2');">详细信息</legend>      	
				<table class='property'>            	
					<tr>
						<td class='name'>真实姓名:</td>
                        <td class='value'><input  <?php echo (isset($item[0]->name) && $item[0]->name=='admin')?"disabled='false'":"";?>  name='name'  value='<?php echo isset($item[0])?$item[0]->name:"";?>' style='width:100%' type='text'></td>
						<td class='name'>性别:</td>
                        <td class='value'><input id='sex' style='width:100%' type='text'></td>
					</tr>
					<tr>
						<td class='name'>联系电话:</td><td class='value'><input id='phone' name='phone'  value='<?php echo isset($item[0])?$item[0]->phone:"";?>' style='width:100%' type='text'></td>
						<td class='name'>手机:</td><td class='value'><input id='cell_phone' name='cell_phone' value='<?php echo isset($item[0])?$item[0]->cell_phone:"";?>' style='width:100%' type='text'></td>
					</tr>
					<tr>
						<td class='name'>号码前缀:</td><td class='value'><input id='phone_prefix' name='phone_prefix' value='<?php echo isset($item[0])?$item[0]->phone_prefix:"";?>' style='width:100%' type='text'></td>
						<td class='name'>PBX:</td><td class='value'><input id='pbx' name='pbx' value='<?php echo isset($item[0])?$item[0]->pbx:"";?>' style='width:100%' type='text'></td>
					</tr>
				</table>
                </fieldset>
 <?php echo form_close()?>
 </div>
 </div>
</body>
</html>
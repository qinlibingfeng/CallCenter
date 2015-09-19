<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo base_url() ?>/www/"/>

<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
<script type='text/javascript' src='lib/jquery.js'></script>
<script type='text/javascript' src='js/work.js'></script>
<script type='text/javascript' src='lib/extenal.js'></script>
<script>
$(document).ready(function(){
	
	//$("#vicidial_campaign_id").val(window.parent.parent.document.getElementById('vicidial_campaign_id').value);
	$('#btnSaveClient').click(function(){
		var $req={'field':[],'fieldValue':[],'agentId':'', 'campaignId':''};
		$req.field=['client_name','client_person_card','client_phone','client_cell_phone'];
		$req.fieldValue=jQuery.parseJSON(getDatas($req.field,0));
		$req.agentId="<?php echo $agentId;?>";
		$req.campaignId=window.parent.parent.document.getElementById('vicidial_campaign_id').value;
		var phone=$('#client_phone').attr('value');
		var cellPhone=$('#client_cell_phone').attr('value');

		if(phone==='' && cellPhone === ''){
			alert("电话不能同时为空");
			return;
		}
		if( (phone!=''&&!isDigit(phone)) || (cellPhone&&!isDigit(cellPhone))){
			alert('请输入正确的电话号码');
			return;
		}
	
		$.post("<?php echo site_url('client/ajaxAdd')?>",$req,function(res){
			if(res.ok){
				location.href=res.nextUrl;
			}else{
				alert(res.fail);
			}
		});
	});
});
</script>
</head>
<body>
	<div>
	<div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 添加客户</div>
         <div class="nav_other"></div>   
	</div>
		<div class="func-panel" style="height:24px">
			 <div class="left">
             </div>
			 <div align='right' class="right">
				 <input  id='btnSaveClient' type="button" value="保存"   class="btnSave"/>
                 <input  type='button' value='返回'   class='btnDel'/>
			 </div>
			 <div style=”clear:both”></div> 
		</div>	
      <br>
      <br>
	<div class='panelOne'>
        <fieldset><legend onClick="show_div('data_table2');">客户资料</legend>
					<table  class='property' >
					<tr>
						<td class='name' >真实姓名:</td><td class='value'> <input id='client_name' name='name'  style='width:100%;' value='<?php echo isset($item[0]->name)?$item[0]->name:'' ;?>'  type='text'></td>
						<td class='name'>身份证:</td><td class='value'><input id='client_person_card' name='sex' value='' style='width:100%;' type='text'></td>
					</tr>
					<tr>
						<td class='name'>固话: </td><td class='value'> <input id='client_phone' name='phone'  value="<?php echo isset($item[0]->cell_phone)?$item[0]->cell_phone:'';?>" style='width:100%;' type='text'></td>
						<td class='name'>手机:</td><td class='value'><input id='client_cell_phone' name='cell_phone' value='' style='width:100%;' type='text'></td>
					</tr>
				</table>

				</fieldset>
		</div>
	</div>
</body>
</html>
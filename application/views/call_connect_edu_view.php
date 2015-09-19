<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
	<base href="<?php echo $this->config->item('base_url') ?>/"/>
	<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="www/css/zTree.css" type="text/css">
	<link rel="stylesheet" href="www/css/ztree/zTreeStyle/zTreeStyle.css" type="text/css">
    <link rel='stylesheet' href='www/lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css' media="screen"/>
	<style>
    	.bussiness-control{
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
<style type="text/css" title="currentStyle">
			@import "www/lib/dataTable/css/demo_page.css";
			@import "www/lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
</style>
	<script type="text/javascript" src="www/lib/jquery-1.6.4.js"></script>
    <script type="text/javascript" src="www/lib/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="www/lib/jquery.ztree.core-3.0.min.js"></script>
    <script type="text/javascript" src="www/js/multi-select.js"></script>
    <script type="text/javascript" src="www/js/work.js"></script>
    <script type="text/javascript" src="www/js/call.js"></script>
    <script type="text/javascript" src="www/lib/jgrowl/jquery.jgrowl.js"></script>
    <script type='text/javascript' src='www/lib/jquery.timers.js'></script>
    <script type='text/javascript' src='www/lib/jquery/jquery-ui-1.8.16.custom.js'></script>
    <script type="text/javascript" src="www/lib/dataTable/js/jquery.dataTables.js"  ></script>
    
    <script>	
		function webCallPhone(id){
				var number=$('#'+id).attr('value');				
			    number=number.replace(/[\D]/g,'');
				if(number != ''){
					$('#'+id).attr('value',number);
					window.parent.iUpdateTabTitle(number);
					call(number);
				}
		}	

			
$(document).ready(function(){
			$('body').everyTime('10s',function(){
				$.jGrowl("超过5分钟，请留意时间！",{'theme':'jGrowl bottom-right'});
			},1);
			
			setDatePickerLanguageCn();			
			$("#yuyue-ymd").datepicker(); 
			$('#btnYuyue').click(function(){
				$("#yuyue-dialog" ).dialog({
						autoOpen:true,
						height: 140,
						width: 300,
						modal: true,
						buttons:{
							"确认": function(){
									$req={'content':'','time':'','client_id':''}
									$req.client_id=$('#clientBh').attr('value');
									$req.content=$('#yuyue-content').attr('value');
									$req.time=getYmdhmDateString('yuyue-ymd','yuyue-hour','yuyue-min');
									//设置预约时间
									$.post('<?php echo site_url("communicate/ajaxSetYuyueTime")?>',$req,function(){
									
									});
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
			});
			
			$('#client_major_fir').click(function(){
				onSelectClick("client_major_fir");
			});
			$('#client_major_sec').click(function(){
				onSelectClick('client_major_sec');
			});
			$('#client_major_thir').click(function(){
				onSelectClick('client_major_thir');
			});
			
			var id_map={client_major_fir:{tree_id:"tClientMajorFirst",div_id:"dClientMajorFirst"},client_major_sec:{tree_id:"tClientMajorSec",div_id:"dClientMajorSec"},client_major_thir:{tree_id:"tClientMajorThird",div_id:"dClientMajorThird"}};	
			multi_select_init(id_map);
			var req={'tx':'院校'};	
			
			//获取专业树
			$.post("<?php echo site_url('dictionary/ajaxGetTreeData')?>",req,function(res){	
					multi_select_add("tClientMajorFirst",res); 	
					multi_select_add("tClientMajorSec",res);
					multi_select_add("tClientMajorThird",res);						
			}); 
						
			$('#agentId').attr('value','<?php echo $agentId;?>');
			
		
			$('#nextClient').click(function(){
				var req={'agentId':'','clientBh':'0'};
				req.agentId=$('#agentId').attr('value');
				req.clientBh=$('#clientBh').attr('value');
				$.post("<?php echo site_url('communicate/ajaxNextClient')?>",req,function(res){	
					 if(res.nextUrl != '')	
					 	location.href=res.nextUrl;	  							
				});  
			});
			
			$('#clientBh').attr('value',"<?php echo $clientBh;?>");
			$('#phoneNumber').attr('value',"<?php echo $phoneNumber;?>");
			$('#callFrom').attr('value',"<?php echo $from?>");
			
		    createGroupRadio('#cgZsjd','client_zsjd','招生阶段',"<?php echo site_url('dictionary/ajaxGetKeyValue')?>",<?php echo isset($clientItem[0]['client_zsjd'])?$clientItem[0]['client_zsjd']:0?>);
			createGroupRadio('#cgKhxx','client_khxx','客户选项',"<?php echo site_url('dictionary/ajaxGetKeyValue')?>",<?php echo isset($clientItem[0]['client_khxx'])?$clientItem[0]['client_khxx']:0?>);
			
			createGroupRadio('#cgBmlx','client_bmlx','报名方式',"<?php echo site_url('dictionary/ajaxGetKeyValue')?>",<?php echo isset($clientItem[0]['client_bmlx'])?$clientItem[0]['client_bmlx']:0?>);
			createGroupRadio('#cgGtzt','client_gtzt','沟通状态',"<?php echo site_url('dictionary/ajaxGetKeyValue')?>",<?php echo isset($clientItem[0]['client_gtzt'])?$clientItem[0]['client_gtzt']:0?>);
			
			$('#btnSave').click(function(){			
			    var datas={'agentId':'','uniqueid':'','columText':{'colum':[],'datas':[]},'columInt':{'colum':[],'datas':[]},'from':'','clientBh':'','phone':''};
				datas.agentId=$('#agentId').attr('value');
				datas.from=$('#callFrom').attr('value');
				datas.clientBh=$('#clientBh').attr('value');
				datas.phone=$('#phoneNumber').attr('value');
				datas.uniqueid=$('#uniqueid').attr('value');
				var columText=['client_name','client_sex','client_nation','client_email','client_birth','client_height','client_weight','client_see','client_receiver','client_cell_phone','client_phone','client_address','client_post_code','client_person_card','client_phone_owner','client_compete_school','client_letter_advice','client_study_professional_grade','client_study_grade','client_major_fir','client_major_sec','client_major_thir','client_major_type','client_student_type','client_come_probility','client_education_background','client_note'];
				
				
				datas.columText.colum=columText;
				//alert(getDatas(columText,0));
				datas.columText.datas=jQuery.parseJSON(getDatas(columText,0));
							
				datas.columInt.colum=['client_zsjd','client_khxx','client_bmlx','client_gtzt'];
				datas.columInt.datas=jQuery.parseJSON(getDatas(datas.columInt.colum,3));
						
				$.post("<?php echo site_url('communicate/ajaxCommunicateSave')?>",datas,function(res){	
					 if(res.ok){
					 	alert('成功保存');
					 }
					 if(res.clientBh){
					 	$('#clientBh').attr('value',res.clientBh);
					 }			  							
				});  
				
			});
			
		$('#connectInfoTable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers

			  

			  if(aData[1] == 0)
			 	 $('td:eq(1)', nRow).html("呼入");
			  else
			  	 $('td:eq(1)', nRow).html("呼出");
			
			  $('td:eq(4)', nRow).html("<a href='javascript:listenRecord(\""+aData[4]+"\")'>收听</a>");
			  
    		},"aoColumns": [
				{"bSortable":false,"mDataProp":"0"},
				{"mDataProp":"1"},
				{"mDataProp":"2"},
				{"mDataProp":"3"},
				{"mDataProp":"4"}
			],"fnServerParams": function (aoData) {
				var externData={ "name": "agentId", "value": "my_value" };
				externData.value="<?php echo $agentId;?>";
				aoData.push(externData);
			},
			"sAjaxSource": "<?php echo site_url('communicate/ajaxCommunicateRecord')?>",
			"oLanguage": {"sUrl": "<?php echo $this->config->item('base_url')?>/www/lib/dataTable/de_DE.txt"}
    	});
	});
    </script>
 
</head>
<body>
<input id="agentId"  type="hidden" value="">
<input id='callFrom' type='hidden' value="<?php echo isset($from)?$from:''?>"/>
<input id='clientBh' type="hidden" vaule="<?php echo isset($clientBh)?$clientBh:''?>"/>
<input id='phoneNumber' type="hidden" value="<?php echo isset($phoneNumber)?$phoneNumber:''?>"/>
<input id='uniqueid' type="hidden" value="<?php echo isset($uniqueid)?$uniqueid:''?>"/>
<div id="dClientMajorFirst" class="menuContent" style=" display:none;position: absolute;">
	<ul id="tClientMajorFirst" class="ztree" style="margin-top:0; width:160px;"></ul>
</div>
<div id="dClientMajorSec" class="menuContent" style=" display:none;position: absolute;">
	<ul id="tClientMajorSec" class="ztree" style="margin-top:0; width:160px;"></ul>
</div>
<div id="dClientMajorThird" class="menuContent" style=" display:none;position: absolute;">
	<ul id="tClientMajorThird" class="ztree" style="margin-top:0; width:160px;"></ul>
</div>

<div id="yuyue-dialog"  style="display:none">
	预约内容:<input id="yuyue-content" type="text" style="width:180px" value="" />
    <br>
	预约时间:<input id='yuyue-ymd' type="text" style="width:90px" value="<?php echo $yuyue['ymh']?>">&nbsp;<?php echo form_dropdown('s_hour',$yuyue['hourOptions'],$yuyue['hourDef'],'id="yuyue-hour"')?>&nbsp;<?php echo form_dropdown('s_min',$yuyue['minOptions'],$yuyue['minDef'],'id="yuyue-min"')?>
</div>

<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 正在沟通</div>
         <div class="nav_other"></div>
        
	</div>		
     <div class="func-panel">
                    <div class='left'>&nbsp;&nbsp;&nbsp;基本信息</div>
                    <div class="right" align="right">
                    <input id="nextClient" type="button" value="下一个">&nbsp 
                    <input id="btnSave" type="button" value="保存">&nbsp;
                    <input id="btnYuyue" type="button" value="预约">&nbsp;
                     
                   <div style="clear:both"></div>						
    </div> 
    
        <div class='content'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名: <span class="person-info"><?php echo isset($clientItem[0])?$clientItem[0]['client_name']:''; ?></span>&nbsp;所属坐席：<span class="person-info"><?php echo isset($clientItem[0])?$clientItem[0]['client_agent']:''; ?></span> &nbsp;电话：<span class="person-info"><?php echo isset($clientItem[0])?$clientItem[0]['client_phone']:''; ?> </span> &nbsp; 地址： <span class="person-info"><?php echo isset($clientItem[0]['client_address'])?$clientItem[0]['client_address']:'';?></span></div>

		<div class='work-list'>			
			<div class='tabs' style="padding-left:40px">		
				<ul class="idTabs">   
                	<li><a href="#personInfo">个人资料</a></li> 	    
                	<li><a href="#bussniessInfo">报考信息</a></li>	             	          
					<li><a href="#connectInfo">沟通记录</a></li> 	
                    <li><a href="#helprDoc"> 沟通技巧</a></li>  	                   
				</ul> 
			</div>
			<br>
			<br>
			<div id="personInfo" class="panelOne">
						<table  width="100%">
							<tr>
								<td class='name'>姓名:</td><td class='value'><input id="client_name" class="bussiness-control"   value="<?php echo isset($clientItem[0]['client_name'])? $clientItem[0]['client_name']:''?>" type='text'></td>
								<td class='name'>性别:</td><td class='value'><select id='client_sex' class="bussiness-control"><option><?php echo isset($clientItem[0]['client_sex'])? $clientItem[0]['client_sex']:''?></option><option>男</option><option>女</option></select></td>
                                <td class='name'>民族:</td>
                                <td class='value'><?php echo form_dropdown('nation', $nationOptions,  $nationDef, 'id="client_nation" class="bussiness-control"')?></td>
							</tr>
                            <tr>
							  <td class='name'>身份证:</td><td class='value'><input id='client_person_card' name='sex' class="bussiness-control" type='text' value="<?php echo isset($clientItem[0]['client_person_card'])? $clientItem[0]['client_person_card']:''?>"></td>
								
                               <td class='name'>邮箱:</td><td class='value'><input id='client_email' name='email' class="bussiness-control" type='text' value="<?php echo isset($clientItem[0]['client_email'])? $clientItem[0]['client_email']:''?>"></td>
								<td class='name'>生日:</td><td class='value'><input id='client_birth' name='sex' class="bussiness-control" type='text' value="<?php echo isset($clientItem[0]['client_birth'])? $clientItem[0]['client_birth']:''?>"></td>
							</tr>
                            <tr>
								<td class='name'>身高:</td><td class='value'><input id='client_height' name='name'  class="bussiness-control" value="<?php echo isset($clientItem[0]['client_height'])?$clientItem[0]['client_height']:''?>" type='text'></td>
								<td class='name'>体重:</td><td class='value'><input id='client_weight' name='sex' class="bussiness-control" value="<?php echo isset($clientItem[0]['client_weight'])?$clientItem[0]['client_weight']:''?>"   type='text'></td>
                                <td class='name'>视力:</td><td class='value'><input id='client_see' name='name'  class="bussiness-control" value="<?php echo isset($clientItem[0]['client_see'])?$clientItem[0]['client_see']:''?>" type='text'></td>
							</tr>
                            
							<tr>
                            	<td class='name'>手机:&nbsp;<a href="javascript:webCallPhone('client_cell_phone')"><img src="www/images/dxzx.png"></a></td><td class='value'><input id='client_cell_phone' name='cell_phone' class="bussiness-control" type='text' value="<?php echo isset($phoneNumber)? $phoneNumber:''?>"></td>
								<td class='name'>固话:&nbsp;<a href="javascript:webCallPhone('client_phone')"><img src="www/images/dxzx.png"></a></td><td class='value'> <input id='client_phone' name='phone' class="bussiness-control"  type='text' value="<?php echo isset($clientItem[0]['client_phone'])? $clientItem[0]['client_phone']:''?>" /> </td>
								
                                <td class='name'>联系人:</td><td class='value'><input id='client_phone_owner' name='cell_phone' class="bussiness-control" value="<?php echo isset($clientItem[0]['client_phone_owner'])? $clientItem[0]['client_phone_owner']:''?>" type='text'></td>
							</tr>
							<tr>
		
								<td class='name'>地址:</td><td class='value'><textarea id='client_address' class="bussiness-control" style="height:50px"><?php echo isset($clientItem[0]['client_address'])?$clientItem[0]['client_address']:''?></textarea></td>
                                <td class='name'>邮编:</td><td class='value'><input id='client_post_code' name='sex' class="bussiness-control" type='text' value="<?php echo isset($clientItem[0]['client_post_code'])? $clientItem[0]['client_post_code']:''?>"></td>
                                <td class='name'>收件人:</td><td class='value'><input id='client_receiver' name='sex' class="bussiness-control" type='text' value="<?php echo isset($clientItem[0]['client_post_code'])? $clientItem[0]['client_post_code']:''?>"></td>
							</tr>
						</table>
						
						<br>
			</div> 
            <div id="connectInfo" class='panelOne'>
            	<table width="100%" id="connectInfoTable"><thead><tr align="left" class="dataHead">
                <td width="120px" >对方电话</td>
                <td width="80px">通话类型</td>
                <td width="120px">沟通时间</td>
                <td>沟通内容</td>
                <td width="60px">录音</td>
              </tr></thead></table>
			</div>
            <div id="bussniessInfo" class='panelOne'>       
				<table width="100%"><tr><td class='name'>学历:</td><td class='value'  ><?php echo form_dropdown('educationBackgroud', $educationBackgroudOptions, $educationBackgroudDef,  'id="client_education_background" class="bussiness-control"');?></td><td class='name'>专业类型:</td><td class='value'><?php echo form_dropdown('majorType', $majorTypeOptions, $majorTypeDef,  'id="client_major_type" class="bussiness-control"')?></td><td  class='name'> 报考类型:</td><td class='value'><?php echo form_dropdown('studentType', $studentTypeOptions, $studentTypeDef,  'id="client_student_type" class="bussiness-control"')?></td></tr>
                <tr><td class='name' >文化成绩:</td><td class='value'><input id='client_study_grade' class="bussiness-control" type="text" value="<?php echo isset($clientItem[0]['client_study_grade'])?$clientItem[0]['client_study_grade']:''?>"></td><td class='name'>专业成绩:</td><td  class='value' ><input type="text" id='client_study_professional_grade' class="bussiness-control" value="<?php echo isset($clientItem[0]['client_study_professional_grade'])?$clientItem[0]['client_study_professional_grade']:''?>" /> </td>
                <td class='name'>竞争院校:</td><td class='value'><?php echo form_dropdown('competeSchool', $competeSchoolOptions, $competeSchoolDef,  'id="client_compete_school" class="bussiness-control"');?></td></tr>
                   	<td class='name' >专业一:</td><td  class='value' > <input id="client_major_fir" class="bussiness-control"   type="text" value="<?php echo isset($clientItem[0]['client_major_fir'])?$clientItem[0]['client_major_fir']:''?>"></td><td  class="name">专业二:</td><td class='value'><input id="client_major_sec" type="text" class="bussiness-control" value="<?php echo isset($clientItem[0]['client_major_sec'])?$clientItem[0]['client_major_sec']:''?>" ></td><td class="name"> 专业三:</td><td class="value"  ><input  id="client_major_thir" class="bussiness-control" value="<?php echo isset($clientItem[0]['client_major_thir'])?$clientItem[0]['client_major_thir']:''?>" type="text"></td></tr>
             	<td class="name" >到校几率:</td><td class="value"><input id='client_come_probility' class="bussiness-control"  type="text" value="<?php echo isset($clientItem[0]['client_come_probility'])?$clientItem[0]['client_come_probility']:''?>"></td><td class="name">通知书:</td><td class="value"  ><input id='client_letter_advice' class="bussiness-control"    type="text" value="<?php echo isset($clientItem[0]['client_letter_advice'])?$clientItem[0]['client_letter_advice']:''?>"></td>
             	<td class="name">&nbsp;</td><td  class="value" >&nbsp;</td></tr>
                        <tr><td class="name">报名方式:</td><td id="cgBmlx" colspan="5"></td><tr>
                <tr><td class="name">客户选项:</td><td id='cgKhxx' colspan="5"></td><tr>
        
                <tr><td class="name">招生阶段:</td><td id="cgZsjd" colspan="5"></td><tr>
                <tr><td class="name">沟通状态:</td><td id="cgGtzt" colspan="5"></td><tr>
                <tr><td class="name"> </td><td colspan="5"><textarea  id="client_note" style="width:300px;height:40px"><?php echo isset($clientItem[0]['client_note'])?$clientItem[0]['client_note']:'';?></textarea></td></tr>
                </table>	
               	
			</div>
             <div id="helprDoc" class='panelOne'>
			</div>
		</div>
	</div>
    
  
</body>
</html>
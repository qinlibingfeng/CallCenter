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
    <script type="text/javascript" src="www/lib/myDynamicUI/dynamicUI.js" ></script>  
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
		function onagentClick(name)
		{
			//alert("<?php echo site_url("+url+");?>");
			alert(name);
			//confirm(name);
			
			//if(name !="")
			//	window.parent.iAddTab(name,url);
			//else
			//	window.parent.iAddTab("未命名",url);	
		}

		function webVoipCallPhone(id){
				var number=$('#'+id).attr('value');						
			    number=number.replace(/[\D]/g,'');
				if(number != ''){
					$('#'+id).attr('value',number);
					window.parent.iUpdateTabTitle(number);
					call('4'+number);
				}
		}		
		function updateUniqueid(uniqueid){	
			$('#uniqueid').attr('value',uniqueid);
		}
		$(document).ready(function(){
			//$('body').everyTime('10s',function(){
				//$.jGrowl("超过5分钟，请留意时间！",{'theme':'jGrowl bottom-right'});
			//},1);	
			
			//填充work-reviever
			var gTargetAgents=<?php echo json_encode($targetAgents);?>;
			$.each(gTargetAgents,function(index,row){
				if(row.name_text !='全部'){
					if(row.name_text != '未填写')
						$('#workOrder-reciever').append("<option value='"+row.name_value+"'>"+row.name_text+"</option>");
						else
						$('#workOrder-reciever').append("<option selected='selected' value='"+row.name_value+"'>"+row.name_text+"</option>");
				}
			});
			//填充坐席
			var gTargetAgents2=<?php echo json_encode($targetAgents);?>;
			$.each(gTargetAgents2,function(index,row){
				if(row.name_text !='全部'){
					if(row.name_text != '未填写')						
						$('#Orderform-reciever').append("<option value='"+row.name_value+"'>"+row.name_text+"</option>");
						else						
						$('#Orderform-reciever').append("<option selected='selected' value='"+row.name_value+"'>"+row.name_text+"</option>");
				}
			});
			
			
			
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

			//订单开始*********************************************************************************
			$('#btnCreatOrderForm').click(function(){
				//alert("保存订单");
				//$('#btnSave').click();
				$("#createOrderForm-dialog" ).dialog({
						autoOpen:true,
						height: 400,
						width: 750,
						modal: true,						
						buttons:{
						"确认": function(){									
								$req={};
								var bessDatas=$('#bussniessInfoTable').dynamicui.getTextDatas('#bussniessInfoTable');
								$req.ids=bessDatas.ids;
								$req.values=bessDatas.values;
								$req.uniqueid=$("#uniqueid").attr('value');
								$req.client_id=$('#clientBh').attr('value');
								$req.owner=$('#agentId').attr('value');	
								$req.form_agent=$('#agentId').attr('value');							
																
								//设置预约时间
								$.post('<?php echo site_url("order/createOrderform")?>',$req,function(res){
									if(res.isOk){
										alert('生成订单成功');
									}
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
			//订单结束*********************************************************************************
			
			$('#btnCreatWorkOrder').click(function(){
				$("#createWorkOrder-dialog" ).dialog({
						autoOpen:true,
						height: 240,
						width: 300,
						modal: true,
						open: function( event, ui ) {			
							//填充工单类型
							var req={type:1,text:"工单类型"};
							$.post("<?php echo site_url("dictionary/ajaxGetKeyValue")?>",req,function(ret){
								$.each(ret,function(index,row){
									if(row.name_text != '未填写')
										$('#orderType').append("<option value='"+row.name_text+"'>"+row.name_text+"</option>");
										else
										$('#orderType').append("<option selected='selected' value='"+row.name_text+"'>"+row.name_text+"</option>");
								});
							});
							
							//获取反应问题值
							$('#orderContent').attr('value',$("#client_note").val());	
							
						},
						buttons:{
							"确认": function(){	
									$req={'reciever':'','lastTime':'','ids':[],'values':[],'client_id':'','owner':'','orderType':'','orderContent':'','phone':'','name':''};
									$req.reciever=$('#workOrder-reciever').attr('value');
									$req.lastTime=getYmdhmDateString('workOrder-ymd','workOrder-hour','workOrder-min');	
									var bessDatas=$('#bussniessInfoTable').dynamicui.getTextDatas('#bussniessInfoTable');
									$req.ids=bessDatas.ids;
									$req.values=bessDatas.values;
									
									$req.client_id=$('#clientBh').attr('value');
									$req.owner=$('#agentId').attr('value');	
										
									$req.phone=$("#phoneNumber").attr('value');
									$req.name=$("#client_name").attr('value');
									
									$req.orderType=$('#orderType').val();	
									$req.orderContent=$('#orderContent').val();	
																	
									//设置预约时间
									$.post('<?php echo site_url("order/createOrder")?>',$req,function(res){
										if(res.isOk){
											alert('生成工单成功');
										}
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
			
				
			$('#btnBack').click(function(){
				window.history.back();
			});
				
			$('#nextClient').click(function(){
				var req={'agentId':'','clientBh':'0'};
				req.agentId=$('#agentId').attr('value');
				req.clientBh=$('#clientBh').attr('value');
				$.post("<?php echo site_url('communicate/ajaxNextClient')?>",req,function(res){	
					 if(res.nextUrl != '')	
					 	location.href=res.nextUrl;	
					 else
					 	alert("无待沟通客户");  							
				});  
			});
			
			$('#agentId').attr('value','<?php echo $agentId;?>');
			$('#clientBh').attr('value',"<?php echo $clientBh;?>");
			$('#phoneNumber').attr('value',"<?php echo $phoneNumber;?>");
			
			$('#callFrom').attr('value',"<?php echo $from?>");
			
	
		  	$('#baseInfoTable').dynamicui(<?php echo json_encode($baseInfo);?>);
			
			$('#bussniessInfoTable').dynamicui(<?php echo json_encode($bussniessInfo);?>);
			$('#client_cell_phone').attr('value',"<?php echo $phoneNumber;?>");
			$('#btnSave').click(function(){	
	
			  var datas={'agentId':'','uniqueid':'','columText':{'colum':[],'datas':[]},'columInt':{'colum':[],'datas':[]},'from':'','clientBh':'','phone':'','campaignId':''};
				datas.agentId=$('#agentId').attr('value');
				datas.from=$('#callFrom').attr('value');
				datas.clientBh=$('#clientBh').attr('value');
				datas.phone=$('#phoneNumber').attr('value');
				datas.uniqueid=$('#uniqueid').attr('value');

				datas.campaignId=window.parent.parent.document.getElementById('vicidial_campaign_id').value;
				
				var baseDatas=$('#baseInfoTable').dynamicui.getTextDatas('#baseInfoTable');	
				

				//var bessDatas=$('#bussniessInfoTable').dynamicui.getTextDatas('#bussniessInfoTable');
				
				//datas.columText.colum=baseDatas.ids.concat(bessDatas.ids);
				//datas.columText.datas=baseDatas.values.concat(bessDatas.values);
				datas.columText.colum=baseDatas.ids;
				datas.columText.datas=baseDatas.values;

				datas.columInt.colum=[];
				datas.columInt.datas=[];
		
				$.post("<?php echo site_url('communicate/ajaxCommunicateSave')?>",datas,function(res){	
					 if(res.ok){
					 	alert('成功保存');
					 }else
					 {
					 	alert(res);
						}
					 if(res.clientBh){
					 	$('#clientBh').attr('value',res.clientBh);
					 }			  							
				});  
				
			});
		$("#btnAddWaitComm").click(function(){
			$('#btnSave').click();
			if(confirm("确定要添加正在沟通的客户吗？")){
				$req={'phone_number':''};
				$req.phone_number=$("#client_cell_phone").val();
				
				$.post("<?php echo site_url('client/ajaxGetClientID')?>",$req,function(res){
					if(res.ok){
						var $client_id=res.data;						
						var $datas = new Array();
						$datas.push($client_id);
						$req2={'ids':[]};					
						$req2.ids=$datas;
						$.post("<?php echo site_url('client/ajaxAddWaitComm')?>",$req2,function(res){
							if(res.ok)	
								alert("添加成功");
						}); 
					}								
				}); 			 
			}
		});
		
			
		$('#connectInfoTable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers
			  if(aData[2] == "callin")
			 	 $('td:eq(2)', nRow).html("呼入");
			  else
			  	 $('td:eq(2)', nRow).html("呼出");
			 
				$('td:eq(5)', nRow).html("<a href='javascript:onagentClick(\""+aData[5]+"\")'>查看</a>");

			  $('td:eq(6)', nRow).html("<a href='javascript:listenRecord(\""+aData[6]+"\")'>收听</a>");
			  
    		},"aoColumns": [
				{"bSortable":false,"mDataProp":"0"},
				{"mDataProp":"1"},
				{"mDataProp":"2"},
				{"mDataProp":"3"},
				{"mDataProp":"4"},
				{"mDataProp":"5"},
				{"mDataProp":"6"}
			],"fnServerParams": function (aoData) {
				var externData={ "name": "agentId", "value": "my_value" };
				var externPhoneData={"name": "phone", "value": "<?php echo isset($clientItem[0]['client_phone'])?$clientItem[0]['client_phone']:'';?>" };
				var externCellPhoneData={ "name": "cellPhone", "value": "<?php echo isset($clientItem[0]['client_cell_phone'])?$clientItem[0]['client_cell_phone']:'';?>" };
				
				externData.value="<?php echo $agentId;?>";
				aoData.push(externData);
				aoData.push(externPhoneData);
				aoData.push(externCellPhoneData);
	
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

<div id="yuyue-dialog"  style="display:none">
	预约内容:<input id="yuyue-content" type="text" style="width:180px" value="" />
    <br>
	预约时间:<input id='yuyue-ymd' type="text" style="width:90px" value="<?php echo $yuyue['ymh']?>">&nbsp;<?php echo form_dropdown('s_hour',$yuyue['hourOptions'],$yuyue['hourDef'],'id="yuyue-hour"')?>&nbsp;<?php echo form_dropdown('s_min',$yuyue['minOptions'],$yuyue['minDef'],'id="yuyue-min"')?>
</div>
<div id="createWorkOrder-dialog"  style="display:none">
	反应问题:<textarea id="orderContent"></textarea><br />	
    工单类型:<select id="orderType"></select>&nbsp;&nbsp;&nbsp; 接收人:<select id="workOrder-reciever"></select> <br>
	截止时间:<input id='workOrder-ymd' type="text" style="width:90px" value="<?php echo $yuyue['ymh']?>">&nbsp;<?php echo form_dropdown('s_hour',$yuyue['hourOptions'],$yuyue['hourDef'],'id="workOrder-hour"')?>&nbsp;<?php echo form_dropdown('s_min',$yuyue['minOptions'],$yuyue['minDef'],'id="workOrder-min"')?>
</div>

<div id="createOrderForm-dialog" title="订单"  style="display:none">
<table  id="bussniessInfoTable" width="100%">
<tbody></tbody>	
</table>

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
					<!--<input  id='btnAddWaitComm' type="button" name="btnSearch" value="待沟通添加 " class="btnDel" />
                    <input id="btnCreatWorkOrder" type="button" value="生成工单">&nbsp-->
					<input id="btnCreatOrderForm" type="button" value="保存订单">&nbsp
                    <input id="nextClient" type="button" value="下一个">&nbsp 
                    <input id="btnSave" type="button" value="保存">&nbsp;
                    <input id="btnYuyue" type="button" value="预约">&nbsp;
                    <input style="display:None" id="btnBack" type="button" value="返回"></div>            
                   <div style="clear:both"></div>						
    </div> 
    
        <div class='content'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名:
         <span class="person-info"><?php echo isset($clientItem[0])?$clientItem[0]['client_name']:''; ?></span>&nbsp;
         所属坐席：<span class="person-info"><?php echo isset($clientItem[0]['client_agent'])?$clientItem[0]['client_agent']:''; ?></span> &nbsp;
         电话：<span class="person-info"><?php echo isset($clientItem[0])?$clientItem[0]['client_cell_phone']:''; ?> </span> &nbsp;
         地址： <span class="person-info"><?php echo isset($clientItem[0]['client_address'])?$clientItem[0]['client_address']:'';?> &nbsp; </span> 
         号码归属地：<span class="person-info"><?php echo $gsd;?></span></div>

		<div class='work-list'>			
			<div class='tabs' style="padding-left:40px">		
				<ul class="idTabs">   
                	<li><a href="#personInfo">个人资料</a></li> 	    	 
                	<li><a href="#bussniessInfo">业务信息</a></li>	       	          
					<li><a href="#connectInfo">沟通记录</a></li> 	
                    <li><a href="#helprDoc"> 知识库</a></li>  	                   
				</ul> 
			</div>
			<br>
			<br>
			<div id="personInfo" class="panelOne">
						<table  id="baseInfoTable" width="100%">
                        <tbody></tbody>	
						</table>
						<br>
			</div> 
            <div id="connectInfo" class='panelOne'>
            	<table width="100%" id="connectInfoTable"><thead><tr align="left" class="dataHead">
                <td width="100px">坐席</td>
                <td width="120px" >对方电话</td>
                <td width="80px">通话类型</td>
                <td width="120px">沟通时间</td>
                <td width="120px">保存时间</td>
                <td>通话内容</td>
                <td width="60px">录音</td>
              </tr></thead></table>
			</div>
			<!--
            <div id="bussniessInfo" class='panelOne'>       
				<table id="bussniessInfoTable" width="100%">
                 <tbody></tbody>
                </table>
               	
			</div>-->
            <div id="helprDoc" class='panelOne'>
            	
			</div>
		</div>
	</div>
    
  
</body>
</html>
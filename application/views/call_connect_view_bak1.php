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
		
		
		function checkInput(){	
			var steps = $("#loan_steps").val();
			switch (steps)
			{
				case '申请受理':
				{
					if($("#client_cell_phone").val()=='')
					{
						alert("请输入电话号码");
						return 0;
					}
					if($("#client_name").val()=='')
					{
						alert("请输入申请人姓名");
						return 0;
					}
					if($("#client_sfz").val()=='')
					{
						alert("请输入申请人身份证号");
						return 0;
					}
					if($("#home_address").val()=='')
					{
						alert("请输入申请人地址");
						return 0;
					}
					if($("#loan_use").val()=='')
					{
						alert("请输入贷款用途");
						return 0;
					}
					if($("#loan_mode").val()=='')
					{
						alert("请选择贷款方式");
						return 0;
					}
					
					if($("#loan_money").val()=='')
					{
						alert("请输入申请金额");
						return 0;
					}
					if($("#is_pass_first_trail").val()=='未填写')
					{
						alert("请选择是否通过初审");
						return 0;
					}
					if($("#is_pass_first_trail").val()=='否' &&  $("#not_pass_first_trail_reason").val()=='')
					{
						alert("请输入未通过初审原因");
						return 0;
					}
					if($("#accept_sub_branch").val()=='')
					{
						alert("请输入通知受理支行");
						return 0;
					}
					break;
				}
				case '调查':
				{
					if($("#is_pass_investigate").val()=='未填写')
					{
						alert("请选择是否通过支行调查");
						return 0;
					}
					
					if($("#is_pass_investigate").val()=='否' &&  $("#not_pass_reason").val()=='')
					{
						alert("请输入未通过原因");
						return 0;
					}					
				
					if($("#investigate_echo_date").val()=='')
					{
						alert("请选择结果反馈日期");
						return 0;
					}
					if($("#notify_danger_reinvestigate_date").val()=='')
					{
						alert("请选择通知风险管理再调查日期");
						return 0;
					}
					if($("#reinvestigate_result").val()=='')
					{
						alert("请输入再调查结果");
						return 0;
					}
					if($("#not_pass_reinvestigate_nofify_date").val()=='')
					{
						alert("请选择未通过调查结果通知客户日期");
						return 0;
					}
					if($("#is_not_pass_reinvestigate_nofify").val()=='未填写')
					{
						alert("请输入未通过调查的是否通知客户");
						return 0;
					}			
					break;
				}
				case '审查':
				{
					if($("#is_pass_check").val()=='未填写')
					{
						alert("请选择是否通过审查");
						return 0;
					}
					
					if($("#is_pass_check").val()=='否' &&  $("#not_pass_check_reason").val()=='')
					{
						alert("请输入未通过原因");
						return 0;
					}					
				
					if($("#not_pass_check_notify_date").val()=='')
					{
						alert("请选择未通过审查结果通知客户日期");
						return 0;
					}
					if($("#is_not_pass_check_notify").val()=='')
					{
						alert("请选择未通过审查的是否通知客户");
						return 0;
					}
				
					break;
				}
				case '审议审批':
				{
					if($("#is_pass_loan_check").val()=='未填写')
					{
						alert("请选择是否通过审批");
						return 0;
					}
					if($("#is_pass_loan_check").val()=='是' &&  $("#loan_check_money").val()=='')
					{
						alert("请输入审批金额");
						return 0;
					}		
					if($("#is_pass_loan_check").val()=='否' &&  $("#not_pass_loan_check_reason").val()=='')
					{
						alert("请输入审批未通过原因");
						return 0;
					}		
					if($("#loan_check_echo_date").val()=='')
					{
						alert("请选择结果反馈日期");
						return 0;
					}
					if($("#loan_check_notify_date").val()=='')
					{
						alert("请选择通知客户日期");
						return 0;
					}
					
				
			}
			case '限时办结':
			{
					if($("#limit_making_date").val()=='')
					{
						alert("请选择限时办结日期");
						return 0;
					}
					if($("#not_limit_making_reasion").val()=='未填写')
					{
						alert("请选择未限时办结原因");
						return 0;
					}
					if($("#not_limit_making_expound").val()=='')
					{
						alert("请输入具体说明");
						return 0;
					}
					
					
				
					break;
				}
				case '发放':
				{
					if($("#giveout_money").val()=='')
					{
						alert("请输入发放金额");
						return 0;
					}
					if($("#giveout_money_echo_date").val()=='')
					{
						alert("请选择发贷反馈日志");
						return 0;
					}
					
					
					break;
				}
				case '回访':
				{
					if($("#return_visit_date").val()=='')
					{
						alert("请选择回访日期");
						return 0;
					}
					if($("#is_trans_to_persion_acc").val()=='未填写')
					{
						alert("请选择资金是否转入本人账户");
						return 0;
					}
					if($("#is_use_with_self").val()=='未填写')
					{
						alert("请选择资金是否全部由本人使用");
						return 0;
					}
					if($("#is_satisfied_with_accept_process").val()=='未填写')
					{
						alert("请选择对贷款受理中心人员整个工作过程是否满意");
						return 0;
					}
					
					if($("#is_satisfied_with_deal_process").val()=='未填写')
					{
						alert("请选择对贷款办理支行工作人员办贷过程是否满意");
						return 0;
					}
					
					break;
				}
				default:
					break;
				
			}
			return 1;
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
									var bessDatas=$('#loanInvestigateTable').dynamicui.getTextDatas('#loanInvestigateTable');
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
			$('#loanInvestigateTable').dynamicui(<?php echo json_encode($loanInvestigate);?>);
			$('#loanRecheckTable').dynamicui(<?php echo json_encode($loanRecheck);?>);
			
			$('#loanCheckTable').dynamicui(<?php echo json_encode($loanCheck);?>);
			$('#limitMakingTable').dynamicui(<?php echo json_encode($limitMaking);?>);
			$('#loanGiveoutTable').dynamicui(<?php echo json_encode($loanGiveout);?>);
			$('#loanRevisitTable').dynamicui(<?php echo json_encode($loanRevisit);?>);
			
			
			$('#client_cell_phone').attr('value',"<?php echo $phoneNumber;?>");
			$('#btnSave').click(function(){	
	
			  var datas={'agentId':'','uniqueid':'','columText':{'colum':[],'datas':[]},'columInt':{'colum':[],'datas':[]},'from':'','clientBh':'','phone':'','campaignId':''};
				datas.agentId=$('#agentId').attr('value');
				datas.from=$('#callFrom').attr('value');
				datas.clientBh=$('#clientBh').attr('value');
				datas.phone=$('#phoneNumber').attr('value');
				datas.uniqueid=$('#uniqueid').attr('value');
				
				
				if(checkInput() == 0)
					return;
	
				
				

				datas.campaignId=window.parent.parent.document.getElementById('vicidial_campaign_id').value;
				
				var baseDatas=$('#baseInfoTable').dynamicui.getTextDatas('#baseInfoTable');	
				var bessDatas=$('#loanInvestigateTable').dynamicui.getTextDatas('#loanInvestigateTable');
				
				var bfssDatas=$('#loanRecheckTable').dynamicui.getTextDatas('#loanRecheckTable');
				var bgssDatas=$('#loanCheckTable').dynamicui.getTextDatas('#loanCheckTable');
				var bhssDatas=$('#limitMakingTable').dynamicui.getTextDatas('#limitMakingTable');
				var bissDatas=$('#loanGiveoutTable').dynamicui.getTextDatas('#loanGiveoutTable');
				var bjssDatas=$('#loanRevisitTable').dynamicui.getTextDatas('#loanRevisitTable');
				
				datas.columText.colum=baseDatas.ids.concat(bessDatas.ids).concat(bfssDatas.ids).concat(bgssDatas.ids).concat(bhssDatas.ids).concat(bissDatas.ids).concat(bjssDatas.ids);
				
				datas.columText.datas=baseDatas.values.concat(bessDatas.values).concat(bfssDatas.values).concat(bgssDatas.values).concat(bhssDatas.values).concat(bissDatas.values).concat(bjssDatas.values);

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
			
		$('#connectInfoTable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers
			  if(aData[2] == 0)
			 	 $('td:eq(2)', nRow).html("呼入");
			  else
			  	 $('td:eq(2)', nRow).html("呼出");
			 
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
    	
    	
    	var $steps = "<?php echo isset($clientItem[0])?$clientItem[0]['loan_steps']:'申请受理'; ?>";   	
    	$("#loan_steps").attr("value",$steps);
    	
    	$("#step"+$steps).click();
	
    	
    	$("#loan_steps").change(function(){
  			//更新
  			 var datas={'clientId':'','loan_steps':''};
  			 datas.clientId="<?php echo isset($clientItem[0])?$clientItem[0]['client_id']:''; ?>";
  			 datas.loan_steps=$("#loan_steps").val();
  			 
  			$.post("<?php echo site_url('communicate/ajaxCommunicateSaveStep')?>",datas,function(res){	
					 if(res.ok){
					 	$("#step"+$("#loan_steps").val()).click();
					}
					 			  							
				});  
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
<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 正在沟通</div>
         <div class="nav_other"></div>
        
	</div>		
     <div class="func-panel">
                    <div class='left'>&nbsp;&nbsp;&nbsp;基本信息</div>
                    <div class="right" align="right">
                    <input id="btnCreatWorkOrder" type="hidden" value="生成工单">&nbsp
                    
                    
                    
                    
                    <select name="loan_steps" id="loan_steps">
											<option value="申请受理">申请受理</option>
											<option value="调查">调查</option>
											<option value="审查">审查</option>
											<option value="审议审批">审议审批</option>
											<option value="限时办结">限时办结</option>
											<option value="发放">发放</option>
											<option value="回访">回访</option>
										</select>
                    
                    <input id="nextClient" type="hidden" value="下一个">&nbsp 
                    <input id="btnSave" type="button" value="保存">&nbsp;
                    <input id="btnYuyue" type="button" value="预约">&nbsp;
                    <input id="btnBack" type="button" value="返回"></div>            
                   <div style="clear:both"></div>						
    </div> 
    
        <div class='content'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名: <span class="person-info"><?php echo isset($clientItem[0])?$clientItem[0]['client_name']:''; ?></span>&nbsp;所属坐席：<span class="person-info"><?php echo isset($clientItem[0]['client_agent'])?$clientItem[0]['client_agent']:''; ?></span> &nbsp;电话：<span class="person-info"><?php echo isset($clientItem[0])?$clientItem[0]['client_phone']:''; ?> </span> &nbsp; 地址： <span class="person-info"><?php echo isset($clientItem[0]['client_address'])?$clientItem[0]['client_address']:'';?> &nbsp; </span> 号码归属地：<span class="person-info"><?php echo $gsd;?></span></div>

		<div class='work-list'>			
			<div class='tabs' style="padding-left:40px">		
				<ul class="idTabs">   
                	<li><a id= "step申请受理" href="#personInfo">贷款申请受理环节</a></li> 	    	 
                	<li><a id= "step调查" href="#loanInvestigate">贷款调查环节</a></li>	
                	<li><a id= "step审查" href="#loanRecheck">贷款审查环节</a></li>	     
                	<li><a id= "step审议审批" href="#loanCheck">贷款审议、审批环节</a></li>	  
                	<li><a id= "step限时办结" href="#limitMaking">限时办结</a></li>	   
                	
                	<li><a id= "step发放" href="#loanGiveout">贷款发放环节</a></li>	 
                	
                	<li><a id= "step回访" href="#loanRevisit">贷后回访环节</a></li>	 
 	          
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
      <div id="loanInvestigate" class='panelOne'>       
				<table id="loanInvestigateTable" width="100%">
          <tbody></tbody>
          </table>               	
			</div>
      <div id="loanRecheck" class='panelOne'>       
				<table id="loanRecheckTable" width="100%">
          <tbody></tbody>
          </table>               	
			</div>			
      <div id="loanCheck" class='panelOne'>       
				<table id="loanCheckTable" width="100%">
          <tbody></tbody>
          </table>               	
			</div>				
	    <div id="limitMaking" class='panelOne'>       
				<table id="limitMakingTable" width="100%">
          <tbody></tbody>
          </table>               	
			</div>			
	    <div id="loanGiveout" class='panelOne'>       
				<table id="loanGiveoutTable" width="100%">
          <tbody></tbody>
          </table>               	
			</div>				
			
	    <div id="loanRevisit" class='panelOne'>       
				<table id="loanRevisitTable" width="100%">
          <tbody></tbody>
          </table>               	
			</div>				
			
			
			
			
			
			
       <div id="helprDoc" class='panelOne'>
            	
			</div>
		</div>
	</div>
    
  
</body>
</html>
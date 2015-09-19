<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

<style type="text/css" title="currentStyle">
			@import "lib/dataTable/css/demo_page.css";
			@import "lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
</style>
<script src="js/jquery-1.6.4.js" 				type="text/javascript"></script>
<script src="js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="lib/dataTable/js/jquery.dataTables.js" type="text/javascript"  ></script>
<script>
var data=Array();
var agentId="<?php echo $agentId;?>";
function transfer(agent,targetAgent){
	window.external.AgentTransfer(agent,targetAgent,1);
}

function forceInsert(agent,targetAgent){
	window.external.AgentForceInsert(agent,targetAgent);
}
function hangupCall(agent,targetAgent){
	window.external.AgentHangupCall(agent,targetAgent);
}

function spyCall(agent,targetAgent){
	agent='8002';
	window.external.AgentSpyCall(agent,targetAgent);
}

function updateMonitorView(msg){
	if(msg.eventId === 8){
		data=pushAgentStatusItem(data,msg);	
	}else{
		data=pushLiveCallItem(data,msg);
	}
	$('#liveAgent').dataTable({
		"bDestroy":true,
		"aaData": data,
		"fnCreatedRow": function(nRow, aData, iDataIndex){	
			 var showbusyStime=Date.parse(aData[4]);
			 var linkStime=	Date.parse(aData[7]);
			 var loginStime=Date.parse(aData[2]);
			 var etime=new Date();
			 var showBusyTimeLen=etime.getTime()-showbusyStime;
			 var linkTimeLen=etime.getTime()-linkStime;
			 var loginTimeLen=etime.getTime()-loginStime;
			 	
			 $('td:eq(2)', nRow).html(loginTimeLen/1000);
		 	 $('td:eq(4)', nRow).html(showBusyTimeLen/1000);
			 $('td:eq(7)', nRow).html(linkTimeLen/1000);
			 
			 var doPanelHtml="<div ><a href='javascript:transfer(\""+agentId+"\",\""+aData[0]+"\")'>转接</a>&nbsp;&nbsp;<a href='javascript:forceInsert(\""+agentId+"\",\""+aData[0]+"\")'>强插</a>&nbsp;&nbsp;<a href='javascript:treeCall(\""+agentId+"\",\""+aData[0]+"\")'>三方通话</a>&nbsp;&nbsp;<a href='javascript:spyCall(\""+agentId+"\",\""+aData[0]+"\")'>监听</a>&nbsp;&nbsp;<a href='javascript:hangupCall(\""+agentId+"\",\""+aData[0]+"\")'>强拆</a></div>";
			 
			 $('td:eq(8)', nRow).html(doPanelHtml);
		 },
		"oLanguage": {"sUrl": "<?php echo $this->config->item('base_url') ?>/www/lib/dataTable/de_DE.txt"}			
	});
	
}

function pushAgentStatusItem(data,msg){
	data=clearNotLoginAgentData(data,msg);
	$.each(msg.eventEx,function(index,msgValue){
		var ret=agentExsitInData(data,msgValue[0]);
		if(ret > -1){
			data[ret][0]=msgValue[0];
			if(msgValue[1] === "true")
				data[ret][1]="是";
			else
				data[ret][1]="否";
				
			data[ret][2]=msgValue[2];
			if(msgValue[3] == "false")
				data[ret][3]="是";
			else
				data[ret][3]="否";
			data[ret][4]=msgValue[4];
		}else{	
			var newItem=Array();
			newItem[0]=msgValue[0];
			if(msgValue[1] === "true")
				newItem[1]="是";
			else
				newItem[1]="否";
				
			newItem[2]=msgValue[2];
			if(msgValue[3] == "false")
				newItem[3]="是";
			else
				newItem[3]="否";
			newItem[4]=msgValue[4];
			newItem[5]="";
			newItem[6]="";
			newItem[7]="";
			newItem[8]=agentId;
			data.push(newItem);
		}
	});		
	return data;
}

function pushLiveCallItem(data,msg){
	data=clearNotCallAgentData(data,msg);
	$.each(msg.eventEx,function(index,msgValue){
			if(msgValue[2] === "1"){
				var ret=agentExsitInData(data,msgValue[4]);	
				if(ret > -1){
					data[ret][5]="呼入";
					data[ret][6]=msgValue[3];
					data[ret][7]=msgValue[6];
				}
				
			}	
			if(msgValue[2] === "0"){
				var ret=agentExsitInData(data,msgValue[3]);	
				if(ret > -1){
					data[ret][5]="呼出";
					data[ret][6]=msgValue[4];
					data[ret][7]=msgValue[6];
				
				}
			}	
	});
	
	return data;
}
function agentExsitInData(data,e){
	var ret=-1;
	$.each(data,function(index,value){
		if(value[0] === e)
			ret=index;
	});
	return ret;
}

function clearNotLoginAgentData(data,msg){
	var ret=Array();
	$.each(data,function(index,value){
		if(agentInAgentStatusMsg(value[0],msg)){
			ret.push(value);
		}
	});
	
	return ret;
	
}

function agentInAgentStatusMsg(agentId,msg){
	var ret=false;
	$.each(msg.eventEx,function(index,msgValue){
		if(agentId === msgValue[0])
			ret=true;
	});
	return ret;
}


function clearNotCallAgentData(data,msg){

	$.each(data,function(index,value){
		if(!agentInAgentCallMsg(value[0],msg)){
			data[index][5]="";
			data[index][6]="";
			data[index][7]="";
		}
	});
	
	return data;
}

function agentInAgentCallMsg(agentId,msg){
	var ret=false;	
	$.each(msg.eventEx,function(index,msgValue){
		if(msgValue[2] === "1" && msgValue[4] === agentId)
				ret=true;
		if(msgValue[2] === "0" && msgValue[3] === agentId)
				ret=true;
	});
	
	return ret;
}
</script>
</head>
<body>
	<div class='page_main page_tops'>
		<div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_"></div>
         <div class="nav_other"></div>
	</div>
		<div class='func-panel' style="height:23px">
			<div class='left'></div>
			<div align='right' class='right'></div>
		</div>
		<div class='work-list'>
			<table id="liveAgent" width="100%">
            	 <thead><th align="left" width="60px">登陆工号</th>
                 		<th align="left" width="40px">登录</th>
                        <th align="left" width="100px">登陆时长</th>
                        <th align="left" width="40px">空闲</th>
                        <th align="left" width="100px">空闲时长</th>
                        <th align="left" width="60px">呼叫类型</th>
                        <th align="left" width="100px">通话号码</th>
                        <th align="left" width="100px">通话时长</th>
                        <th align="left">操作</th>
                        </thead>       	
                 <tbody></tbody>
            </table>
		</div>
	</div>
</body>
</html>
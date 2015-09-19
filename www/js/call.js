// JavaScript Document

function call(number)
{
	//window.parent.frames['TopFrame'].makeCall(number);
	phone=number.replace(/[\D]/g,'');
	if(phone != ''){	
		window.external.AgentHangup("");		
		window.external.AgentCall(phone,phone);
	}
}

function makeBusy(agentId,busy){
	window.external.AgentMakeBusy(agentId,busy);
}

function transfer(oldExt,newExt){
	alert(oldExt);
	window.external.AgentTransfer(oldExt,newExt,1);
}

function onClientUiCall(agent,phone){
	phone=phone.replace(/[\D]/g,'');
	if(phone != ''){
		//alert(agent);
		window.external.AgentHangup(agent);
		window.external.AgentCall(phone,phone);
	}
}
function onClientUiVoipCall(agent,phone){
	phone=phone.replace(/[\D]/g,'');
	if(phone != ''){
		window.external.AgentHangup(agent);
		window.external.AgentCall(phone,'4'+phone);
	}
}
function listenRecord($location){
			
			$("<div style='width:300px;height:400px'><center><object id='mplayer' classid='clsid:6BF52A52-394A-11D3-B153-00C04F79FAA6' id='phx' style='border:0px solid #F00;width: 200px; height: 45px; margin-bottom:-8px'><param name='URL' value='"+$location+"'/><param name='AutoStart' value='true' /></object></center></div>").dialog({
						autoOpen:true,
						modal: true,
						buttons:{
							"确认": function(){
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
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
			$("<div style='width:300px;height:400px'><center><audio id='myaudioplay' controls='controls'   src='"+$location+"'> </audio></center></div>").dialog({
						autoOpen:true,
						modal: true,
						buttons:{
							"确认": function(){
								 var oAudio = document.getElementById('myaudioplay');
								 oAudio.pause();
							   $(this).dialog('destroy');
							},
							"取消": function(){
								var oAudio = document.getElementById('audioplay');
								 oAudio.pause();
								$(this).dialog( "close" );
							}
						},
						close: function(){
							var oAudio = document.getElementById('myaudioplay');
							oAudio.pause();
							
							$(this).dialog('destroy');
						}
				});	   
   			 
}
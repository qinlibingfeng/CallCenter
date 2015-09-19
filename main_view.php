<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title></title>
<base href="<?php echo $this->config->item('base_url') ?>/www/" />
<link rel="stylesheet" href="css/examples.css" type="text/css" media="screen" />
<script src="js/jquery-1.6.4.js"              type="text/javascript"></script>
<script src="js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="js/call.js"  type="text/javascript"></script>
<script>
function on_transfer_prompt()
{
	alert('transfer');
	$.prompt('Example 2',{ buttons: { Ok: true, Cancel: false } });
}
function clearPhoneNumberPrefix(phone){
	var index=phone.indexOf('0');
	if(index === -1)
		index=phone.indexOf('');
	if(index != -1)
		return phone.substr(index);
	else
	 	return phone;
}
$(document).ready(function(){
	var $agentid="<?php echo $agent;?>"
	
	makeBusy($agentid,false);
	
	onProxyEvent=function(type,msg){
	  var  json_msg=eval( '( '+msg+' )' ); 	
	  if(json_msg.eventId === 1){		  
		  var url="";
		  var title="";
		  //建立连接
		  if(json_msg.floatInfo != 'callout'){	 
			 //来电
			  url="<?php echo site_url('communicate/connected')?>"+"/callEvent/"+json_msg.releatedNum+"/0/"+json_msg.exten+"/"+json_msg.uniqueid;
			  title=json_msg.exten;
			  if(json_msg.releatedNum == $agentid)
			    window.frames['mainFrame'].iUpdateTab(title,url);
		  }else{
		  	 //去电
			  url="<?php echo site_url('communicate/connected')?>"+"/callEvent/"+json_msg.exten+"/0/"+json_msg.releatedNum+"/"+json_msg.uniqueid;
			
			  title=json_msg.releatedNum;
			  if(json_msg.exten == $agentid)
			    window.frames['mainFrame'].iUpdateTab(title,url);
		  }	
		  
	   }
	   if(json_msg.eventId === 9){
		
	   		var url="<?php echo site_url('communicate/connected')?>"+"/callEvent/"+$agentid+"/0/"+json_msg.callerId+"/"+json_msg.uniqueid;
			var title=json_msg.callerId;
		
			window.frames['mainFrame'].iUpdateTab(title,url);
	   }
	}
});
</script>

</head>

<frameset rows="40,*,24" cols="*"  border="0"  frameBorder="no" framespacing="0">
  <frame src="<?php echo site_url("main/top/".$agent)?>" name="topFrame" scrolling="no" noresize="noresize">
  
  <frameset name="MainFrame" id="MainFrame" cols="154,8,*,0" frameborder="no" border="0" scrolling="auto" framespacing="0">
     <frame src="<?php echo site_url("main/left/".$agent)?>" name="left_menu" scrolling="auto"  noresize="">
     <frame src="<?php echo $this->config->item('base_url') ?>/www/html/control.html" name="control" scrolling="no"> 
     <frame   src="<?php echo site_url("system/tabs/".$agent) ?>" name="mainFrame" scrolling="auto" noresize="">

  <frame src="<?php echo site_url("main/foot")?>" name="footFrame" scrolling="no" noresize="noresize">
  
</frameset>

<noframes>
 <body>
    <p>本系统需要使用框架，但您的浏览器不支持框架，请升级或更换其他！</p>
  </body>
</noframes>

</html>


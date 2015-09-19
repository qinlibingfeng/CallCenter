<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>东捷科技呼叫中心</title>
<base href="<?php echo $this->config->item('base_url') ?>/www/" />

<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/left.css" type="text/css" media="screen" />
<link rel='stylesheet' href='lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css' media="screen"/>
<link rel='stylesheet' href='lib/jgrowl/jquery.jgrowl.css'   type='text/css' media="screen"/>

<script type='text/javascript' src='lib/jquery/jquery-1.5.2.min.js'></script>
<script type='text/javascript' src='lib/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type='text/javascript' src='lib/jgrowl/jquery.jgrowl.js'></script>
<script type='text/javascript' src='lib/jquery.timers.js'></script>
<script type='text/javascript' src='js/call.js'></script>
<style>
#demo {height:100%}
#tabs {height:100%;border:0; margin:0; padding-top:0px;}
#tabs li .ui-icon-close { float: left; margin: 0.4em 0.2em 0 0; cursor: pointer; }
#add_tab { cursor: pointer; }

</style>
<script language="javascript"> 
function chengeimg(){
	//alert("1111");
	//$("#menu-img").src="images/lgq-222.gif";
	//document.all.getElementById("menu-img").src = "../2.jpg";
}
	
function hidegFdBdy(){
	$(".gFdBdy").css("display","none");
}
function hideDivMenu(id){
	hidegFdBdy();
	var e=document.getElementById(id);
	e.style.display="none";
}

function showDivMenu(id){
	hidegFdBdy();
	var e=document.getElementById(id);
	/*
	if(e.style.display=="block"||e.style.display=="")
		e.style.display="none";
	else
		e.style.display="block";
	*/
	e.style.display="block";

	//$("#menu_img").src="images/lgq-lll.gif";
	//alert($("#menu_img").src);	
};
function startCalltoVici(callnum,callid){
	alert("startCalltoVici:"+callnum);
	
	//parent.pspspp(callnum);
	//parent.document.getElementById(\'MDPhonENumbeR\').value = callnum;
	//parent.NeWManuaLDiaLCalLSubmiT("NEW");
		
};
function onClickYuyue(agentId,clientId){
	$ids=[];
	var $item=[];
	$item.push('or');
	$item.push('varchar');
	$item.push('client_id');
	$item.push(clientId);	
	$ids.push($item);	
	$req={'ids':[]};
	$req.ids=$ids;
	$.post("<?php echo site_url('client/ajaxDeleteYuyueClient')?>",$req,function(res){	
		if(res.ok){
			var oTable = $('#dataList').dataTable();
			oTable.fnDestroy();	
			createTables(getSearchString());
		}										
	}); 		
	iAddTab('预约外呼','<?php echo site_url('communicate/connected')?>/manulClick/'+agentId+'/'+clientId);
}


function changeSelectDisplayNumber(){
	
	//$this->db->query("update agents set out_display_number_id = 1 where code=$user[0]")->result_array();
	/*alert("<?php echo 'update agents set out_display_number_id = "+$("#selectNumber").val()+" where code= '.$agentId;?>");*/
	$ids=[];
	var $item=[];

	$item.push('or');
	$item.push('varchar');
	$item.push('code');
	$item.push("<?php echo $agentId;?>");
	$ids.push($item);	


	$req={'ids':[],'targetAgent':[], 'targetNumberId':[]};
	$req.ids=$ids;
	$req.targetAgent="<?php echo $agentId;?>";
	$req.targetNumberId=$("#selectNumber").val();
	
	$.post("<?php echo site_url('client/ajaxSelectOutDisplayNumber')?>",$req,function(res){	
		if(res.ok){
			//alert("ok");
		}else
		{
			alert("error");
		}									
	}); 		

	
}

function showFoldClass(id){
	if($("#"+id).attr("title")=="开启"){
		$("#"+id).removeClass("opnFd");
		$("#"+id).addClass("clsFd");
		$("#"+id).attr("title","折叠");
	}else{
		$("#"+id).removeClass("clsFd");
		$("#"+id).addClass("opnFd");
		$("#"+id).attr("title","开启");
	}
};

function showDiv(id,isShow){var e=document.getElementById(id);if(!isShow){e.style.display="none"}else{e.style.display="block"}}; 
  
function addClassName(id,cl){$("#"+id).addClass("on")};
 
function removeClassName(id,cl){$("#"+id).removeClass("on")};

function nav(title,url){
	iAddTab(title,url);
}
function logout(){
		window.location="<?php echo site_url('login')?>";
};
function updateMonitorView(msg){
		//liveLook.window.updateMonitorView(msg);
		window.frames['liveLook'].updateMonitorView(msg);
}	
function get_width(){
	//document.getElementById('Menu_List');
	var menu_width = document.getElementById( "Menu_List").offsetWidth / 9;
	return menu_width;
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



$("#selectNumber").val("<?php echo $user[0]['out_display_number_id']?>");
				
				
$('.side-switcher').toggle(function(){
		$('#frame-side').animate({width: "2px"}, 300);
		$('#page-main').animate({left:"4px"}, 300);	
		$(this).animate({left: "2px"}, 300).addClass("side-close").attr("title","展开侧边栏");
	},function(){
		$('#frame-side').animate({width: "155px"}, 300);
		$('#page-main').animate({left: "157px"}, 300);
		$(this).animate({left:"155px"},300).removeClass("side-close").attr("title","收缩侧边栏");
}); 	
var $tabs = $("#tabs").tabs({
			tabTemplate: "<li><a href='#{href}'>#{label}</a><span class='ui-icon ui-icon-close'>Remove Tab</span></li>",
			add: function(event, ui) {
				
				if($tab_content === "<?php echo site_url('report/liveLook/'.$agentId);?>"){
					
					$(ui.panel).append("<iframe id='"+ui.panel.id+"-frame' scrolling='auto' noresize='noresize' name='liveLook' frameborder='0'  style='border-width:0;' height='100%' width='100%' src='"+$tab_content+"' ></iframe>" );		
				}else{
					$(ui.panel).append("<iframe  id='"+ui.panel.id+"-frame' scrolling='auto' noresize='noresize' frameborder='0'  style='border-width:0;' height='100%' width='100%' src='"+$tab_content+"'></iframe>" );	
				}		
				$tabs.tabs('select', '#' + ui.panel.id);	
			}
		});	
		
		// actual addTab function: adds new tab using the title input from the form above
		iAddTab=function addTab(title,url){
			$tab_title ="<font size=18px >"+title+"</font>" || "Tab ";
			$tab_title=title;
			$tab_content=url+"/<?php echo $agentId;?>";
			var timestamp=new Date().getTime();
		
			$tabs.tabs("add", "#tabs-"+timestamp, $tab_title);
		}
	
		iUpdateTabTitle=function updateTabTitle(ntitle){
			var selected = $tabs.tabs('option', 'selected');
			$("li a", $tabs).each(function(){	
				var index=$("li", $tabs).index($(this).parent());	
				if(index === selected){
					$(this).html(ntitle);
				}
			});	
		}	
		updateCallUniqueid=function updateTab($title,$uniqueid){
			var res=iFindTabByTitle($title);
			if(res.isFind){
				$(res.iframeId)[0].contentWindow.updateUniqueid($uniqueid);	
			}
		}
		
		function iFindTabByTitle($title){
			var index=-1;
			var iframeId="";
			var res={isFind:false,iframeId:''};
			$("li a", $tabs).each(function(){	
				if($(this).html() === $title){			
					index=$("li", $tabs).index($(this).parent());	
				}
				res.iframeId=$(this).attr("href")+'-frame';
			});	
			if(index != -1)
				res.isFind=true;
			return res;
		}
		iUpdateTab=function updateTab($title,$url){
			
			var index=-1;
			var iframeId="";
			var res=iFindTabByTitle($title);
			if(!res.isFind){
				iAddTab($title,$url);			
			}else{	
				$(res.iframeId).attr('src',$url);
			}				
			//改变原有选项卡的内容  
		}
		// close icon: removing the tab on click
		// note: closable tabs gonna be an option in the future - see http://dev.jqueryui.com/ticket/3924
	$( "#tabs span.ui-icon-close" ).live( "click", function() {
		var index = $("li", $tabs).index($( this ).parent());
		$tabs.tabs( "remove", index );
	});	
		
	var $agentid="<?php echo $agentId;?>";	
	try{
		window.external.ExtLogin($agentid,$agentid);
		makeBusy($agentid,false);
	}catch(e){}
	
	onProxyEvent=function(type,msg){
	  var  json_msg=eval( '( '+msg+' )' ); 	
	  if(json_msg.eventId === 1){		  
		  var url="";
		  var title="";	  
		  //建立连接
		  if(json_msg.floatInfo != 'callout'){	
		  	 if(json_msg.exten.substr(0,1) == '4')
			 	json_msg.exten=json_msg.exten.substr(1);
			 //来电
			  url="<?php echo site_url('communicate/connected')?>"+"/callEvent/"+json_msg.releatedNum+"/0/"+json_msg.exten+"/"+json_msg.uniqueid;
			  title=json_msg.exten;	 
			  if(json_msg.releatedNum === $agentid){
				 try{ makeBusy($agentid,true);}catch(e){};
			  	 updateCallUniqueid(title,json_msg.uniqueid);
			  }		   
		  }else{		  
		  	  //去电
			  
			  //json_msg.releatedNum=clearPhoneNumberPrefix(json_msg.releatedNum);
			  url="<?php echo site_url('communicate/connected')?>"+"/callEvent/"+json_msg.exten+"/0/"+json_msg.releatedNum+"/"+json_msg.uniqueid;	
			  
			  var  $title=json_msg.releatedNum;
			  if(json_msg.exten == $agentid){
				var res=iFindTabByTitle($title);
				if(res.isFind)
					updateCallUniqueid($title,json_msg.uniqueid);
				else
				   iAddTab($title,url);
			  }			   
		  }	  
	   }  
	   if(json_msg.eventId === 9){	
	   		
	   		var url="<?php echo site_url('communicate/connected')?>"+"/callEvent/"+$agentid+"/0/"+json_msg.callerId+"/0";
			var title=json_msg.callerId;
			iAddTab(title,url);
	   }
	   
	   if(json_msg.eventId === 21){
	   		var url="<?php echo site_url('communicate/connected')?>"+"/callEvent/"+$agentid+"/0/"+json_msg.callerId+"/"+json_msg.uniqueid;
			var title=json_msg.callerId;
			var res=iFindTabByTitle("监控操作");
			if(!res.isFind)
				iAddTab("监控操作","<?php echo site_url("report/liveLook/"); ?>");
				//iAddTab("监控操作","<?php //echo site_url("pbx/transfer/"); ?>");
	   }
	   
	   if(json_msg.eventId === 8 || json_msg.eventId === 11){
	   		updateMonitorView(json_msg);
	   }
	}
	
	//预约到期提醒
	$('body').everyTime('30s',function(){
		
		var req={'agentId':''};
		req.agentId="<?php echo $agentId;?>";
		$.post('<?php echo site_url("prompt/ajaxYuyue")?>',req,function($res){
				$.each($res,function(entryIndex,entry){
					if(entry['expire'] === false){
						$tips=entry['client_name']+" 预约时间： "+entry['client_yuyue_time']+" 过期未回访";
					}
					else{
						$tips=entry['client_name']+" 预约时间： "+entry['client_yuyue_time']+" 预约内容:"+entry['client_yuyue_content'];
					}	
					$prompTips='<a href="javascript:onClickYuyue(\''+req.agentId+'\',\''+entry['client_id']+'\')">'+$tips+'</a>';
					
					$('#yuyue-prompt').jGrowl($prompTips);
				});
		});
	});	

	var callInfo ="<?php echo isset($callInfo);?>";	

	if(callInfo){
		var iocheck = "<?php echo $callInfo["iocheck"];?>";	
		var agent_id = "<?php echo $callInfo["agent_id"];?>";	
		var phone = "<?php echo $callInfo["phone"];?>";	
		var uniqueid = "<?php echo $callInfo["uniqueid"];?>";
		

	 url="<?php echo site_url('communicate/connected')?>"+"/callEvent/"+agent_id+"/0/"+phone+"/"+uniqueid;	
	  
	  var  $title=phone;
	  if(agent_id == $agentid){
			var res=iFindTabByTitle($title);
		if(res.isFind)
			updateCallUniqueid($title,uniqueid);
		else
		   iAddTab($title,url);
	  }			   

  }
	
});
  
</script>
</head>
<body scroll="no">
<div id="yuyue-prompt" class="jGrowl bottom-right"></div>
<div id="frame-header" class="frame-header">
<div class="head_menu" ondragstart='return false' >
	<div class="logo" title="东捷科技电话外呼管理系统" onClick="tab_frame('index');"></div>
   <div class="head_info"> 
    	 <div class="round_" title="其他信息">
        	<div class="round_main">
           	  <div class="head_notice_img"><img src="images/home.png" alt="返回系统主页" /></div>
              <div style="height:32px;line-height:32px;width:28px;float:left"><a href="javascript:void(0);" onClick="onClickMax();">布局</a></div>
                
           	  <div class="head_notice_img"><img src="images/login_out.png" alt="退出登录" /></div>
              <div style="height:32px;line-height:32px;width:28px;float:left"><a href="javascript:logout();">退出</a></div>  
         	</div>
         </div>      
    	 <div class="round_" title="用户信息">
        	<div class="round_main">
            	<div class="head_notice_img"><img src="images/user_info.png" alt="用户信息" /></div>
                <div class="head_notice">
           	  <ul>
                    	<li>用户名：<a href="javascript:void(0);" title="teltion[admin]"><span id="names"><?php echo isset($user[0]['name'])?$user[0]['name']:'';?></span> [<?php echo isset($user[0]['code'])?$user[0]['code']:'';?>]</a></li>
                    	<li>角&nbsp;&nbsp;&nbsp;色：<a href="javascript:void(0);"><?php echo isset($user[0]['role_name'])?$user[0]['role_name']:'';?> </a></li>
                    </ul>
              </div>       
         	</div>
         </div>
    	 <div class="round_" title="操作面板" id="info_list">
            <div class="round_main">
           	  <div class="head_notice_img"><a href="javascript:void(0);"><img src="images/notice.png" alt="返回系统主页" /></a></div>
              <div style="height:32px;line-height:32px;width:28px;float:left"><a href="javascript:void(0);" onClick="onClickMax();">消息</a></div>
         	  </div>          
       </div>
       <div class="round_" title="外显号码" id="out_display_numbert">
     	 	 <div class="round_main">
	     	 	 		<div style="height:32px;line-height:32px;width:60px;float:left"><a>外显号码：</a></div>
              <div style="height:32px;line-height:32px;width:120px;float:left">
              	<select onchange="changeSelectDisplayNumber()" name="out_display_number_select" id="selectNumber" style="height:28px;line-height:28px;float:left">   
				          <?php	                    
					           foreach ($out_display_number as $number){
							         echo '<option value="'.$number['number_id'].'">'.$number['number_display'].'</option> ';			    
						         } 
					         ?>
		      			</select>
		      		</div>  
	      	</div>       
       </div>      
 <!--
     	 <div class="round_" title="外显号码" id="out_display_numbert">
     	 	 <div class="round_main">
	     	 		<li style="height:32px;line-height:32px;float:left">外显号码：</li>
	         	<li>
	          <select onchange="changeSelectDisplayNumber()" name="out_display_number_select" id="selectNumber" style="height:28px;line-height:28px;float:left">   
	          <?php	                    
		           foreach ($out_display_number as $number){
				         echo '<option value="'.$number['number_id'].'">'.$number['number_display'].'</option> ';			    
			         } 
		         ?>
		      	</select>  
		      	</li>   
	      	</div>       
       </div>      
     -->  
   </div>
</div>
</div>
<div class="frame-side" id="frame-side">
<div id="divLeftMenu" class="gMain">
  <div class="gLe" id="Menu_List" >
    
    <?php foreach ($items as $item){?> 
		<div class=gFd>
    	  <h3 class="gfTit" onmouseover="javascript:showDivMenu('study_<?php echo $item["item_id"]?>'); showFoldClass('fold_<?php echo $item["item_id"]?>');" onmouseout="javascript:hideDivMenu('study_<?php echo $item["item_id"]?>')">
        	   <!--<a href="javascript:void(0);" id="fold_<?php echo $item["item_id"]?>" rel="fold" class="opnFd bgF1" title="开启" hidefocus="true"></a>-->
             <img  src=" " width=128px height=33px><a href="javascript:void(0);" style="display:hidden" class="gfName" hidefocus="true"><?php echo $item["item_text"];?></a></img>
          </h3> 
  		  <ul class="gFdBdy" id="study_<?php echo $item["item_id"]?>"  style="display:none"; onmouseout="javascript:hidegFdBdy();">
               <?php foreach($item["sub_items"] as $sub_item){?>
            <li onMouseOver="javascript:showDivMenu('study_<?php echo $item["item_id"]?>');addClassName('li_<?php echo $sub_item["item_id"] ?>','on');" id="li_<?php echo $sub_item["item_id"] ?>" onMouseOut="javascript:removeClassName('li_<?php echo $sub_item["item_id"] ?>','on');" title="" rel="o_list">
            <a href="javascript:nav('<?php echo $sub_item["item_text"]?>','<?php echo $sub_item["item_url"]?>')" hidefocus="true" class="gfNm"><?php echo $sub_item["item_text"];?></a>
            </li>
             <?php } ?>
          </ul>  
    </div>
    <?php } ?>
  	</div>
</div>   
</div>
<a class="side-switcher" hidefocus="true" title="点击收缩侧边栏" href="javascript:void(0);">侧边栏</a>  
<div id="page-main" class="page-main">
	<div id="demo" >
        <div id="tabs">
             <ul>
                <li><a href="#tabs-0">首页</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>
            </ul>
            <div id="tabs-0" >
                 <iframe name='tabsBody' frameborder='0' style="border-width:0;margin-top:1px;" scrolling="no"  height="100%" width="100%" src="<?php echo site_url('system/notice/'.$agentId);?>" >
                 </iframe>
            </div>
        </div>
	</div>
</div>
<div class="footer">
	<div class="footer" oncontextmenu='return false' ondragstart='return false' onselectstart ='return false' onselect='document.selection.empty()'oncopy='document.selection.empty()' onbeforecopy='return false' onmouseup='document.selection.empty()'>
	<div class="welcome"><img src="images/welcome.jpg" width="101" height="27" /></div>
    <div class="copyright">CopyRight&copy;2010 - 2011 . All Rights Reserved(技术支持:15688880173 qq:40109903) </div>
    <div class="version"></div>
</div>
</div>
</body>
</html>
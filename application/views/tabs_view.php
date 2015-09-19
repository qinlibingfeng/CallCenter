<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>
<link rel="stylesheet" href="www/css/main.css" 	type="text/css" media="screen" />
<link rel='stylesheet' href='www/lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css' media="screen"/>
<link rel='stylesheet' href='www/lib/jgrowl/jquery.jgrowl.css'   type='text/css' media="screen"/>
<script type='text/javascript' src='www/lib/jquery/jquery-1.5.2.min.js'></script>
<script type='text/javascript' src='www/lib/jquery/jquery-ui-1.8.16.custom.js'></script>

<script type='text/javascript' src='www/lib/jgrowl/jquery.jgrowl.js'></script>

<script type='text/javascript' src='www/lib/jquery.timers.js'></script>

<style>
#demo {height:100%}
#tabs {height:100%;border:0;}
#tabs li .ui-icon-close { float: left; margin: 0.4em 0.2em 0 0; cursor: pointer; }
#add_tab { cursor: pointer; }

</style>
<script>
	function missCallProcessClick(callId,title,url){
		var req={'callId':''};
		req.callId=callId;
		$.post("<?php echo site_url("prompt/processMissCall")?>",req,function(res){
			iAddTab(title,url);
		});	
	}
	
	function updateMonitorView(msg){
		//liveLook.window.updateMonitorView(msg);
		window.frames['liveLook'].updateMonitorView(msg);
	}	
	$(function() {
		$('#agentId').attr("value","<?php echo $agentId;?>");	
		var $tab_title = "";
		var $tab_content= "";
		// tabs init with a custom tab template and an "add" callback filling in the content
		var $tabs = $("#tabs").tabs({
			tabTemplate: "<li><a href='#{href}'>#{label}</a><span class='ui-icon ui-icon-close'>Remove Tab</span></li>",
			add: function(event, ui) {
				if($tab_content === "<?php echo site_url('report/liveLook/'.$agentId);?>"){
					$(ui.panel).append("<iframe id='"+ui.panel.id+"-frame' scrolling='auto' noresize='noresize' name='liveLook' frameborder='0'  style='border-width:0;' height='100%' width='100%' src='"+$tab_content+"' ></iframe>" );		
				}else{
					$(ui.panel).append("<iframe  id='"+ui.panel.id+"-frame' scrolling='auto' noresize='noresize' frameborder='0'  style='border-width:0;' height='100%' width='100%' src='"+$tab_content+"' ></iframe>" );	
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
			$tabs.tabs("add", "#tabs-"+title+timestamp, $tab_title );
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
		
		//预约到期提醒
		$('body').everyTime('30s',function(){
			
			var req={'agentId':''};
			req.agentId="<?php echo $agentId;?>"	
			$.post('<?php echo site_url("prompt/ajaxYuyue")?>',req,function($res){
				$.each($res,function(entryIndex,entry){
					if(entry['expire'] === false){
						$tips=entry['client_name']+" 预约时间： "+entry['yuyue_time']+" 过期未回访";
					}
					else{
						$tips=entry['client_name']+" 预约时间： "+entry['yuyue_time']+" 预约内容:"+entry['yuyue_note'];
					}		
					$tips='<a href="javascript:iAddTab(\'预约外呼\',\''+'<?php echo site_url('communicate/connected')?>/manulClick/'+$('#agentId').attr('value')+'/'+entry['client_id']+'\')">'+$tips+'</a>';
					
					$('#yuyue-prompt').jGrowl($tips);	
				});
			});
			/*
			$.post('<?php //echo site_url("prompt/ajaxMissCall")?>',req,function($res){
				$.each($res,function(entryIndex,entry){
					$tips="来电号码:"+entry['phone_number']+"来电时间："+entry['link_stime'];
					$tips='<a href="javascript:missCallProcessClick(\''+entry['call_id']+'\',\'漏电回访\',\''+'<?php //echo site_url('communicate/connected')?>/callEvent/'+$('#agentId').attr('value')+'/0/'+entry['phone_number']+'/'+entry['call_id']+'\')">'+$tips+'</a>';		
					$('#yuyue-prompt').jGrowl($tips);	
				});
			});
			*/
		});
		
	});
	</script>
</head>	
<body scroll="no">

<div id="demo" >
	<div id="tabs">
		 <ul>
			<li><a href="#tabs-0">首页</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>
		</ul>
		<div id="tabs-0" >
			 <iframe name='tabsBody' frameborder='0' style="border-width:0;margin-top:1px;" scrolling="no" height="100%" width="100%" src="http://172.17.1.16/CallCenter/uploadifyV3.2/demo.php"> 
             </iframe>
		</div>
	</div>
</div>
<input id="agentId" value='1002' type="hidden">
<div id="yuyue-prompt" class="jGrowl bottom-right"></div>
</body>
</html>
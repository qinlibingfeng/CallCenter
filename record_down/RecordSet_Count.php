<?php require("./inc/config.ini.php"); 
require("./inc/pub_func.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xHTML1/DTD/xHTML1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xHTML">
<head>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
<title> <?php echo $system_name ?></title>
<link href="./css/main.css?v=<?php echo $today ?>" rel="stylesheet" type="text/css">
<link href="./css/day.css" rel="stylesheet" type="text/css">

<script src="./js/jquery-1.8.3.min.js"></script>

<script src="./js/main.js?v=<?php echo $today ?>"></script>
<script src="./js/pub_func.js?v=<?php echo $today ?>"></script>

<script>
var totay="<?php //echo date("Y-m-d"); ?>";


function get_datalist(){
	
	if($("#call_date_type").val()=="no_call_date"&&$("#phone_number").val()==""){
		
 		alert("请填写要查询的被叫号码！");
		c_phone_number_list('set_phone_number_list');
 		return false;
 	} 
  	
 	$('#load').show(); 
  	var url="action=get_record_count_list&"+$('#form1').serialize();
	//alert(url);
	//return false;
	
 	$.ajax({
		 
		url: "send.php",
		data:url,
		
 		beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
		complete :function(){$('#load').hide('100');},
		success: function(json){ 
 			   
			$("#datatable tbody tr").remove();
			
			   
			if(parseInt(json.counts)>0){
				$("#excels").hide();
				$("#excel_addr").html("");
				var tits="",td_str="",fun_str="",qua_str="";
				$.each(json.datalist, function(index,con){
					 
					do_edit="<span id='do_zip_link_"+index+"'><a href=\"javascript:void(0);\" onclick=\"do_copy_layer('"+con.campaign_id+"','"+con.status+"','"+index+"')\" title=\"点击压缩营销录音\">压缩</a></span>";
					campaign_name=con.campaign_name;
					 
					tr_str="<tr align=\"left\" >";
					if(campaign_name=="合计"||campaign_name=="总计"){
						tr_str+="<td ><strong>"+campaign_name+"</strong></td>";
					}else{
						tr_str+="<td >"+campaign_name+"</td>";
					}
					if(con.status=="合计"){
						tr_str+="<td ><strong>"+con.status+"</strong></td>";
					}else{
						tr_str+="<td >"+con.status+"</td>";
					}
					tr_str+="<td >"+con.status_name+"</td>";
					tr_str+="<td >"+con.counts+"</td>";
					tr_str+="<td ><div><img src='/images/loading.gif' style='margin:2px 2px 0 2px;' width='16' height='16' id='zip_loading_img_"+index+"'/><span id=\"do_zip_"+index+"\"></span> <a class='close'></a></div>"+do_edit+"</td></tr>";
					$("#datatable tbody").append(tr_str);
					
				}); 
				$("#datatable a.close").bind("click",function(){$(this).parent().fadeOut()}).attr("title","关闭");
			
		   }else{
			 
				tr_str="<tr><td colspan=\"12\" align=\"center\">"+json.des+"</td></tr>"
				$("#datatable").append(tr_str);
		   }  
 		   d_table_i();
			
   		},error:function(XMLHttpRequest,textStatus ){
			alert("页面请求错误，请检查重试或联系管理员！\n"+textStatus);
		}
   	});
	
}

function do_copy_layer(campaign_id,status,index){

	var p_t_px;
	($.browser.msie)?p_t_px=116+$(document).scrollTop():p_t_px=102+$(document).scrollTop();
	var p_top=$("#do_zip_link_"+index).offset().top-p_t_px;
	var p_left=$("#do_zip_link_"+index).offset().left-200;
	$("#opt_do_zip_layer").css({"top":"10","left":p_left}).animate({"top":p_top},300).fadeIn();
  	
	var tr=$("#do_zip_link_"+index).parent().parent();
	var cam=tr.children("td").eq(0).text();
	var stas=tr.children("td").eq(1).text();
	var sta=tr.children("td").eq(2).text();
	var s_date=$("#begintime").val();
 	
	if(stas=="合计"){
		zip_name=cam+"-"+s_date
	}else if(cam=="总计"){
		zip_name="录音处理-"+s_date
	}else{
		zip_name=cam+"-"+sta+"-"+s_date	
	}
	
	zip_name=zip_name.replace(/[\\|?|*|#|\/|`|&|^|$|@|%|']/g,'');
	
	$("#record_job_tit").val(zip_name).attr("title","压缩包名称："+zip_name+".zip");
	$("#opt_do_zip_con,#opt_do_zip_close").off().on("click",function(){$("#opt_do_zip_layer").fadeOut()});
	$("#record_job_btn").off().on("click",function(){do_copy(campaign_id,status,index)});
	
	//$("#test").val(p_top+" -- "+p_left+" -- "+zip_name+" -- "+$(document).scrollTop());
}

 
function do_copy(campaign_id,status,index){
	
	/*if(confirm("本操作将压缩相应录音文件到压缩包,本过程会耗费相当大的系统资源。\n\n您确定要压缩录音文件包吗？\n\n点 确定 开始，点 取消 返回！")){}else{return false;}*/
	
	if($("#call_date_type").val()=="no_call_date"&&$("#phone_number").val()==""){
		
 		alert("请填写要查询的被叫号码！");
		c_phone_number_list('set_phone_number_list');
 		return false;
 	} 
	
	$("#opt_do_zip_layer").fadeOut();
	
	$('#load').show();
	var url="action=record_copy_zip&do_campaign_id="+encodeURIComponent(campaign_id)+"&do_status="+encodeURIComponent(status)+"&job_name="+$("#record_job_tit").val()+times+"&"+$('#form1').serialize();
 	request_tip("系统正在拷贝，此过程较慢，请耐心等候...",1,800000);
	$.ajax({
		 
		url: "send.php",
		data:url,
		
		beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');$("#zip_loading_img_"+index).show().parent().fadeIn();$("#do_zip_"+index).html("")},
		complete :function(){$('#load').hide('100');},
		success: function(json){
			
		   request_tip(json.des,json.counts);
		   if(json.counts=="1"){
			   $("#copy_result").html(json.copy_result);
			   do_zip(json.job_dir,json.zip_name,json.job_id,index);
		   } 
		   
 		},error:function(XMLHttpRequest,textStatus ){
		   alert("页面请求错误，请检查重试或联系管理员!\n"+textStatus);
		}
	});		

}



function do_zip(job_dir,zip_name,job_id,index){
	
	request_tip("拷贝完成，系统正在处理压缩，请耐心等候...",1,800000);
	$('#load').show();

	//alert(job_dir);
	var url="action=do_record_job2zip&job_dir="+encodeURIComponent(job_dir)+"&zip_name="+encodeURIComponent(zip_name)+"&job_id="+job_id+times;
	//alert(url);
	//return false;
	$.ajax({
		 
		url: "send.php",
		data:url,

		beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');$("#zip_loading_img_"+index).show();},
		complete :function(){$('#load').hide('100');},
		success: function(json){ 
		
		   request_tip(json.des,json.counts);
		   if(json.counts=="1"){
			   	$("#excels").show();
				$("#zip_loading_img_"+index).hide();
 				$("#do_zip_"+index).html("&nbsp;<a href=\""+json.zip_path+"\" target=\"_blank\" title=\"点击下载录音备份\" >下载</a>");
 				
				$("#excel_addr").html("下载：<a href=\""+json.zip_path+"\" target=\"_blank\" title=\"点击下载录音备份\">"+zip_name+".zip</a>"); 
				//$("#do_zip_link_"+index).html("<a href=\""+json.zip_path+"\" target=\"_blank\" title=\"点击下载录音备份\" class=\"yellow_tip\">下载</a>");
 				setTimeout("del_zip_dir('"+job_dir+"','"+job_id+"')",1000);
 		   } 
		   
		},error:function(XMLHttpRequest,textStatus ){
		   alert("页面请求错误，请检查重试或联系管理员!\n"+textStatus);
		}
	});		 
}


function del_zip_dir(job_dir,job_id){
	
	var url="action=del_zip_dir&do_actions=job_dir&job_dir="+encodeURIComponent(job_dir)+"&job_id="+job_id+times; 
 	$.ajax({
		 
		url: "send.php",
		data:url, 
 		success: function(json){ 
 		   request_tip(json.des,json.counts);
		   $("#info_txt").html("");
		} 
	});	
}  
 

function check_form(actions){	
     
    if (actions == "search") {  		 
		$("#datatable").show();
		get_datalist();
    }
}

function truncate_record_log(){
   	
    if(confirm("您确定要清空录音处理日志吗？"))	{}else{return false;}
 	
	$('#load').show();
	var datas="action=truncate_reocrd_log"+times;
 	$.ajax({
		 
		url: "send.php",
		data:datas,
 		
		beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
		complete :function(){$('#load').hide('100');},
		success: function(json){ 
		
			request_tip(json.des,json.counts);
			 
  		},error:function(XMLHttpRequest,textStatus ){
		   alert("页面请求错误，请检查重试或联系管理员!\n"+textStatus);
		}
	});
	
}
  
function c_status_list2(actions){var diag=new Dialog("diag_status_list");diag.Width=640;diag.Height=360;diag.Title="选择呼叫结果";diag.URL="./list.php?action="+actions+"&tits="+encodeURIComponent("选择呼叫结果");diag.OKEvent=setstatus_list;diag.show()}function setstatus_list(){Zd_DW.do_setstatus_list()}

function c_phone_number_list(actions){
	
	/*var record_address = "./list2.php?action="+actions+"&tits="+encodeURIComponent("填写查询号码");
	$("#recordaddress").attr("src",record_address);
	$("#dialog-confirm-record").dialog(
	{				
		title:'11111',				     
		width:540,
		height:260
	});*/
	



  	var diag =new Dialog("diag_get_fields_list");
 	diag.Width = 540;
	diag.Height = 260;
 	diag.Title = "填写查询号码";
 	diag.URL = "./list2.php?action="+actions+"&tits="+encodeURIComponent("填写查询号码");

	
	//diag.URL = "./ll.php";
	//alert(diag.URL);

  	diag.OKEvent = set_phone_number_list;
    diag.show();	
}



 
function set_phone_number_list(){
	Zd_DW.do_phone_number_list();
} 
  
$(document).ready(function(){
   	days_ready()
    get_datalist();
	$("#excels").hide();

	$('#text_search').bind('keyup change',function(ev){
        var searchTerm = $(this).val();
        $('.search_text_zone').removeHighlight();
        if(searchTerm){$('.search_text_zone').highlight(searchTerm);}
    });
	
	$("a.sel_").click(function(event){
		
			var e=window.event || event;
			if(e.stopPropagation){
				e.stopPropagation();
			}else{
				e.cancelBubble = true;
			}
			
			get_p_data('',1);
		});
	$(".opt_f_list").click(function(event){  
		  var e=window.event || event;  
		  if(e.stopPropagation){  
			e.stopPropagation();  
		  }else{  
			e.cancelBubble = true;  
		  }  
		});

	$(document).click(function(){
		$(".opt_f_list").hide();
	});

});

function addTab(tit,url,tab){window.parent.addTab(tit,url,tab)}; 

function set_Calendar()
	{
		
		if($("#begintime").val()!=""&&$("#endtime").val()=="")
		{
			$("#endtime").val($("#begintime").val())
		}if($("#begintime").val()==""&&$("#endtime").val()!="")
				{
					$("#begintime").val($("#endtime").val())
				}
	}


function reset_form(){
	$("ul.dropdown-menu li").each(function(){
		if($(this).index()==0){
			a_link=$(this).find("a");
 			p_t=a_link.parent().parent().prev();
			p_t.attr("data_type",a_link.attr("datas"));
			t_t=a_link.html();
			p_t.children("span").html(t_t);
			t_a_t=a_link.attr("event_type");
			$("#"+t_a_t+"_type").val(a_link.attr("datas"));
		};
	});
	 	
	$("#begintime,#s_hour,#s_min,#endtime,#e_hour,#e_min,#search_accuracy").attr("disabled",false);
	$("#begintime,#endtime").val(totay);
}
function get_phone_count(){
		phone_counts=$("#phone_number2").val()?$("#phone_number2").val().trim().split("\n").length:0;
		$("#phone_counts").html(phone_counts);
	}

 function do_phone_number_list(){	//获取被叫号码

  	phones=$("#phone_number2").val();
	
 	if(phones==""){
		alert("请填写电话号码！");
		$("#phone_number2").focus();
 		return false;
	}else{
	 $("#phone_number2").val();
	
	}
	$("#phone_number").val(phones);
	if(phones!=""){
		$("#phone_number_list").val("号码："+phone_counts+" 个").attr("title","号码："+phone_counts+" 个");
		
	}else{
		$("#phone_number_list").val("").attr("title","");
	}
	$('#opt_layer_1').fadeOut(); 	
}

function get_p_data(types, lay_id) {
    
    
    $("#opt_layer_" + lay_id).show()
    
}
function get_p_data1(types, lay_id){

	$("#oot_layer_" + lay_id).show()
}

</script>
<script type="text/javascript" src="/js/calendar.js"></script>
<style>
.opt_zip_layer{width:254px;border:1px solid #81A3BB;position:fixed;background:#FFF;z-index:20;display:none;box-shadow: 0 2px 7px rgba(0, 0, 0, 0.3);right:0px;top:0px;border-radius:4px;}
.opt_zip_layer .head{background:#E6F3FA;width:100%;border-bottom:1px solid #C5C5C5;position:relative;line-height:30px;height:28px;float:left;}
.opt_zip_layer .head a.close{width:8px;height:8px;line-height:8px;background:url(/images/tips/tip_bg.gif) no-repeat 0 -26px;display:inline;position:absolute;right:10px;top:10px;cursor:pointer;font-size:1px;}
.opt_zip_layer .head a.close:hover{background-position:0 -34px;}
.opt_zip_layer .list{width:98%;position:relative;float:left;min-height:58px;max-height:58px;overflow:auto;padding:2px;}
.opt_zip_layer .list div{float:left;margin:16px 0 0 6px}
.opt_zip_layer .tri{background: url(/images/agent_c/tip_tri_bg.png) no-repeat scroll 0 0 transparent;height: 13px;overflow: hidden;position: absolute;right:36px;bottom:-13px;width: 15px;}
.opt_f_list{background-color:#dcdcdc;border:3px;height:260px;border-bottom:1px dotted #CCC;top:0px;left:100px;float:left;width:600px;}
.opt_agent_list{background-color:#dcdcdc;border:3px;height:599px;border-bottom:1px dotted #CCC;top:0px;left:100px;float:left;width:540px;}


#record_job_tit{width:156px}


.dataTable div{position:relative;width:80%;height:20px;line-height:20px;background:#FEFEE9;border:1px solid #B1B1B1;position:relative; display:none}
.dataTable a.close{width:8px;height:8px;line-height:8px;background:url(./images/tips/tip_bg.gif) no-repeat 0 -26px;display:inline;position:absolute;right:4px;top:6px;cursor:pointer;font-size:1px;}
.dataTable a.close:hover{background-position:0 -34px;}

.data_type a{line-height: 21px;text-align: center;display: inline;float: left;height: 21px;width: 75px; margin-right:6px}
.data_type a:hover{background: url(/images/timeabg.gif) no-repeat 0px 0px;}
.data_type a.select{background: url(/images/timeabg.gif) no-repeat 0px 0px;font-weight:bold;}

.hide_tit { width:120px; }
 
.opt_f_list{width:400px;border:2px solid #709CBE;position:absolute;left:10px;background:#FFF;z-index:12;margin-top:22px;display:none;box-shadow: 0 2px 7px rgba(0, 0, 0, 0.7);}
.opt_f_list ul{width:390px;position:relative;padding:4px;float:left;min-height:90px;max-height:180px;overflow:auto}
.opt_f_list li{display:inline-block;float:left;margin-right:8px;white-space: nowrap;width:31%;line-height:20px;height:20px; overflow:hidden}
.opt_f_list .head{background:#F1F7FC;width:100%;border-bottom:1px solid #C5C5C5;position:relative;line-height:25px;height:26px;float:left}
.opt_f_list .bottom{background:#F1F7FC;width:100%;border-top:1px solid #C5C5C5;position:relative;line-height:24px;height:26px;text-align:right;float:left}
.opt_f_list a.close{width:20px;height:20px;line-height:20px;background:url(/images/agent_c/ico_side.png) no-repeat -23px 0px;display:inline;position:absolute;right:6px;top:3px;cursor:pointer;font-size:1px}
.opt_f_list a.close:hover{background-position:-23px -23px}
.opt_f_list .chart_c_line{line-height:20px;height:20px;border-bottom:1px dotted #CCC;float:left;width:100%}

.opt_age_list{width:400px;border:2px solid #709CBE;position:absolute;left:10px;background:#FFF;z-index:12;margin-top:22px;display:none;box-shadow: 0 2px 7px rgba(0, 0, 0, 0.7);}
.opt_age_list ul{width:390px;position:relative;padding:4px;float:left;min-height:90px;max-height:180px;overflow:auto}
.opt_age_list li{display:inline-block;float:left;margin-right:8px;white-space: nowrap;width:31%;line-height:20px;height:20px; overflow:hidden}
.opt_age_list .head{background:#F1F7FC;width:100%;border-bottom:1px solid #C5C5C5;position:relative;line-height:25px;height:26px;float:left}
.opt_age_list .bottom{background:#F1F7FC;width:100%;border-top:1px solid #C5C5C5;position:relative;line-height:24px;height:26px;text-align:right;float:left}
.opt_age_list a.close{width:20px;height:20px;line-height:20px;background:url(/images/agent_c/ico_side.png) no-repeat -23px 0px;display:inline;position:absolute;right:6px;top:3px;cursor:pointer;font-size:1px}
.opt_age_list a.close:hover{background-position:-23px -23px}
.opt_age_list .chart_c_line{line-height:20px;height:20px;border-bottom:1px dotted #CCC;float:left;width:100%}


#opt_layer_4{width:660px;left:30px;}
#opt_layer_4_list{width:99%;position:relative;padding:4px;float:left;min-height:180px;max-height:280px;overflow:auto}

</style>
 
</head>
<body>
<div id="load" class="load_layer"><img src="/images/loading.gif"align="absmiddle"/>数据加载中...</div>
<div id="auto_save_res" class="load_layer"></div>

<div id="opt_do_zip_layer" class="opt_zip_layer">
  <div class="head"><span style="margin:0 6px 0 6px;float:left" >录音压缩包文件名</span> <a class="close" href="javascript:void(0);" title="点击取消压缩" id="opt_do_zip_close"></a> </div>
  <div class="list">
    <div>
      <input name="record_job_tit" type="text" class="input_text" id="record_job_tit" title="请输入压缩包名称" maxlength="46"  onkeyup="this.value=this.value.replace(/[\\|?|*|#|/|`|&|^|$|@|%|']/g,'')" onblur="this.value=this.value.replace(/[\\|?|*|#|/|`|&|^|$|@|%|']/g,'')" onafterpaste="this.value=this.value.replace(/[\\|?|*|#|/|`|&|^|$|@|%|']/g,'')"/> 
    </div>
    <div>
      <input type="button" name="record_job_btn" id="record_job_btn" value="开始" title="点击开始执行压缩"/>
    </div>
    <div><a href="javascript:void(0)" id="opt_do_zip_con" title="点击取消压缩">取消</a></div>
  </div>
  <div class="tri"></div>
</div>


<div class="page_main">
  <table style="display:None" border="0" cellpadding="0" cellspacing="0" class="menu_list">
  	<tr>
        <td>
        	<a href='javascript:void(0);' onclick="addTab('录音批处理1','/document/record/RecordSet.php','28')" class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  title="新建录音文件处理任务" ><img src="/images/icons/icons_54.png" style="margin-top:4px" /><b>处理任务1&nbsp;</b></a><a href='javascript:void(0);' onclick="addTab('查看处理日志','/document/record/RecordSetLog.php','set_log')"  class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false' priv="true" title="查看历史处理记录、未压缩记录处理" ><img src="/images/icons/icons_49.png" style="margin-top:4px" /><b>查看处理日志&nbsp;</b></a><a href='javascript:void(0);'  class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  onClick="truncate_record_log();" title="清空历史处理日志，将加快处理速度！"><img src="/images/icons/icons_55.png" style="margin-top:4px" /><b>清空处理日志&nbsp;</b></a>
        </td>
		</tr>
	</table>
  <table width="99%" border="0" align="center" cellpadding="0" class="blocktable" >
		<tr>
			<td>
				<div id="opt_layer_1" class="opt_f_list">
    			<form name="opt_form_1" id="opt_form_1">
      			<div class="head"><strong class="">&nbsp;选择呼叫号码</strong><a href='javascript:void(0)' hidefocus='true' class="close" title="关闭" onclick="javascript:$('#opt_layer_1').fadeOut()"></a>
      			</div>
     				<ul id="opt_layer_1_list">
        	 		<table width="100%" border="0" align="center" cellpadding=4 cellspacing=0>
								<tr>
							  	<td align="left" valign="top" class="check_items">
							  		<table width="100%" border="0" align="center" cellpadding=2 cellspacing=0>
								 
								  		<tr>
												<td width="22%" height="" align="right">电话号码：<br><span class="gray">最大支持1000个</span>
												</td>
												<td align="left" valign="middle">
													<textarea name="phone_number2" id="phone_number2" cols="50" rows="5" style="height:160px" onchange="get_phone_count()" title="点击填写要查询的电话号码，单次查询最大支持1000个！">
													</textarea>
										  		<span class="red">※</span> 
										  		<span id="phone_counts" style="color: #CC1B1B;font-family:Arial, Helvetica, sans-serif;font-size: 16px;">0</span> 行</td>
								  		</tr>  
										</table>
									</td>
								</tr>
					
							</table>
      			</ul>
      			<div class="bottom">
			        <input type="button" name="" value="选 择" onclick="do_phone_number_list()" />
			        <span style="margin-right:4px">
			        	<input type="button" name="" value="关 闭" onclick="javascript:$('#opt_layer_1').fadeOut()" />
			        </span>
			       </div>
    			</form>
  			</div>
        <fieldset>
        	<legend> 
        		<label onClick="show_div('search_list');" title="点击收缩/展开">查询选项</label>
        	</legend>
          <form action="" onSubmit=""  method="post" name="form1" id="form1">       
             <table width="100%" border="0" align="center"  cellspacing="0" id="search_list" class="search_table" >
            
               <tr>
                 <td width="10%"  align="right">被叫号码：</td>
                 <td width="" >
                 		<input name="phone_number_list" type="text" id="phone_number_list"  title="双击输入要查询的被叫号码" value="" size="14" readonly="readonly" onClick="" class="input_text2"/><a  class="sel_" hidefocus="fasle" href="javascript:void(0);" title="点击输入要查询的被叫号码" onClick=""></a>
                 </td>
	
					

                	<!-- <td  align="right">坐席工号：</td>
                 	<td ><input name="agent_name_list" type="text" class="input_text2" id="agent_name_list"  title="双击选择坐席工号" size="16" readonly="readonly"  onDblClick=""/><a class="sel_1" hidefocus="true" href="javascript:void(0);" title="点击选择坐席工号" onClick="">选择</a></td>-->

				 					<td  align="right">坐席工号：</td>
				 					<td>
				 						<select name="agent_name_list" class="agent_name_list" id="agent_name_list" >
											<option value="" selected="selected" title="请填写坐席">请填写坐席</option>
											 <?php
												global $db_conn;	
												$sql="select user,full_name from vicidial_users";
												$rows=mysqli_query($db_conn,$sql);
												$row_counts=mysqli_num_rows($rows);
												$list_arr=array();
									 
											if ($row_counts!=0) {
												while($rs= mysqli_fetch_array($rows)){ 
											?>
											<option value="<?php echo$rs["user"]; ?>"  title="<?php echo$rs["user"]; ?>"><?php echo$rs["user"]; ?></option>
											<?php
													//echo $rs["user"];
												}
											}
											?>	
										</select>		
									</td>
             
			 						<td  align="right">业务活动：</td>
							 		<td>
							 			<select name="campaign_id" class="campaign_id" id="campaign_id" >
	                    <option value="IVR_AIA" selected="selected" title="IVR_AIA">IVR_AIA</option>
											<option value="edu" title="edu">edu</option>
	                    <option value="vicitest" title="vicitest">vicitest</option>
                    </select>
       						</td>
			  			 </tr>
               
               <tr>
                 <td style="display:none" width="8%" align="right">存放目录：</td>
                 <td style="display:none" >
                 		<select name="record_path" class="s_option" id="record_path" >
                    	<option value="path_cam" selected="selected" title="按业务放置同一目录">按业务放置同一目录</option>
                    	<option value="path_cam_date" title="按业务分日期放置同一目录">按业务分日期放置同一目录</option>
                    	<option value="path_date" title="按日期放置同一目录">按日期放置同一目录</option>
                    	<option value="path_all" title="全部放置同一目录">全部放置同一目录</option>
                    </select>
                 </td>                
                               
      
                 <td align="right" style="display:none">
                    <ul class="nav nav-pills">
                      <li class="dropdown"> <a class="dropdown-toggle" data_type="call_date" href="javascript:void(0)" title="点击设定呼叫时间"> <span>选定呼叫时间</span> <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                          <li><a href="javascript:void(0);" title="选择查询指定时间范围的呼叫详单" datas="call_date" event_type="call_date">选定呼叫时间</a></li>
                          <li><a href="javascript:void(0);" title="不选定查询时间,直接搜索填写的被叫号码" datas="no_call_date" event_type="call_date">不选呼叫时间</a></li>
                        </ul>
                      </li>
                    </ul> 
                 </td>
				 				 <td  align="right">选定时间：</td>
                 <td colspan="7"><?php select_date("");?></td>
            
				

                 <td  align="right">
                 	<input type="text" class="dis_none" name="call_date_type" id="call_date_type" value="call_date" />
                 	<input type="text" class="dis_none" name="status" id="status" value="" />
                 	<input type="text" class="dis_none" name="quality_status" id="quality_status" value="" />
                 	<input type="text" class="dis_none" name="agent_list" id="agent_list" value="" />
                
				 
				 				 	<input type="text" class="dis_none" name="record_type" id="record_type" value="phone" />
                 	<input type="text" class="dis_none" name="phone_lists" id="phone_lists" value="" />
                 	<input type="text" class="dis_none" name="field_list" id="field_list" value="" />
                 	<textarea  class="dis_none"  name="phone_number" id="phone_number" value="" ></textarea>&nbsp;&nbsp;

                 	<input type="button" name="form_submit" value="提交查询" onClick="check_form('search');" style="cursor:pointer" />
                  <input type="reset" name="button" id="button" value="重置" />
				   			 </td>
               </tr>
             </table> 
       
          </form>
        </fieldset> 
				<div id="excels" style="height:22px; line-height:22px;"> 
					<span id="excel_addr" style="height:22px;line-height:22px;"></span>
					<span id="copy_result" style="height:22px; line-height:22px;margin-left:6px"></span>
					<span id="info_txt" style="height:22px;line-height:22px;margin-left:6px"></span>
				</div>
        
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="dataTable" id="datatable" >
            <thead>
                <tr align="left" class="dataHead">
                
                  <th>业务活动</th>
                  <th>状态码</th>                   
                  <th>呼叫结果</th>
                  <th>号码数量</th>
                   
                  <th align="center">操作</th>
                </tr>
            </thead>   
            <tbody>
            </tbody>
        </table>
		
					   
     	</td>
  	</tr>
 	</table>  
</div>


 




 

</body>
</html>
   

<?php require("../inc/config.ini.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xHTML1/DTD/xHTML1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xHTML">
<head>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
<title><?php echo $system_name ?></title>
<link href="/css/main.css?v=<?php echo $today ?>" rel="stylesheet" type="text/css">
<link href="/css/day.css" rel="stylesheet" type="text/css">
<script src="/js/jquery-1.8.3.min.js"></script>
<script src="/js/main.js?v=<?php echo $today ?>"></script>
<script src="/js/pub_func.js?v=<?php echo $today ?>"></script>
<script>
function GetPageCount(a_ctions,doa_ctions){
	if($("#job_id").val()!=""){}else{return false;}
	$("#a_ctions").val(a_ctions);
	$("#doa_ctions").val(doa_ctions);
  	
	var url="action=do_record_job&pages=1&actions="+a_ctions+"&do_actions="+doa_ctions+"&sorts="+$('#sorts').val()+"&order="+$('#order').val()+times+"&"+$('#form1').serialize();
 	
	$.ajax({
		
		url: "send.php",
		data: url,
 		cache: false,
 		success: function(msg){
			 
			$("#recounts").val(msg.counts);
			max_pages($("#pagesize").val());
			OutputHtml($("#pages").val(),$("#pagesize").val());
		}
	});
	 
}

function get_datalist(page_nums,a_ctions,doa_ctions,pagesize){
	
	if($("#job_id").val()!=""){}else{return false;}
	$("#do_ziped").val("0");
 	$('#load').show();
	$("#excel_addr").html('');
 	max_pages(pagesize);
 	var pages=$("#pagecounts").val();
 	if(parseInt(page_nums) < 1)page_nums = 1; 
 	if(parseInt(page_nums) > parseInt(pages)){
		page_nums = pages;
  	}; 
 	if(!(parseInt(page_nums) <= parseInt(pages))) page_nums = pages;	 
	 
  	var url="action=do_record_job&pages="+page_nums+"&actions="+a_ctions+"&do_actions="+doa_ctions+"&sorts="+$('#sorts').val()+"&order="+$('#order').val()+"&pagesize="+pagesize+times+"&"+$('#form1').serialize();
	//alert(url);
	//return false;
	
 	$.ajax({
		 
		url: "send.php",
		data:url,
		
 		beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
		complete :function(){$('#load').hide('100');},
		success: function(json){
		  
		   if (doa_ctions!="excel"){
			   $("#datatable tbody tr").remove();
			   if(parseInt(json.counts)>0){
				   
				 $("#datatable tfoot tr").show();
				 $("#excels").css("display","block");
	 	    	var tits="";td_str="";fun_str="";qua_str="",result="";
				$.each(json.datalist, function(index,con){
				
				if($("#do_ziped").val()=="0"){
					if(con.locations &&con.result=="处理成功"){
						
						td_str="<a href=\"javascript:void(0);\" onClick=\"del_('"+con.id+"');\" title=\"删除本号码及备份录音文件\">删除</a>&nbsp;<a href=\"javascript:void(0);\" onClick=\"play_wav(event,'play_layer','"+con.locations+"');\" title=\"点击收听本录音\">收听</a>&nbsp;<a href=\""+con.locations+"\" target=\"_blank\" title=\"点击下载录音\">下载</a>";
						
					}else{
						td_str="<a href=\"javascript:void(0);\" onClick=\"del_('"+con.id+"');\" title=\"删除本号码及备份录音文件\">删除</a>&nbsp;收听&nbsp;下载";
					}				
				}else{
					td_str="删除&nbsp;收听&nbsp;下载";
				}
 				tr_str="<tr align=\"left\" "+fun_str+">";
				tr_str+="<td align=\"center\"><input name=\"c_id\" type=\"checkbox\" value=\""+con.id+"\" class=\"c_id\"/></td>";
				tr_str+="<td >"+con.phone_number+"</td>";
 				tr_str+="<td >"+con.campaign_name+"</td>";
 				tr_str+="<td >"+con.user+"["+con.full_name+"]</td>";
   				tr_str+="<td >"+con.call_date+"</td>";
				tr_str+="<td >"+con.status_name+"</td>";
				tr_str+="<td >"+con.length_in_sec+"</td>";
				tr_str+="<td >"+con.record_name+"</td>";
				if(con.result=="处理成功"){
					result="<span class='green'>"+con.result+"</span>";
				}else{
					result="<span class='red'>"+con.result+"</span>";
				}
				tr_str+="<td >"+result+"</td>";
				
  				tr_str+="<td algin=\"center\">"+td_str+"</td></tr>";
				$("#datatable tbody").append(tr_str);
			}); 
   		 
			OutputHtml(page_nums,pagesize);
 			
		   }else{
				$("#excels").css("display","none");
				$("#excel_addr").html('');
				$("#datatable tfoot tr").hide();
				tr_str="<tr><td colspan=\"12\" align=\"center\">"+json.des+"</td></tr>"
				$("#datatable").append(tr_str);
		   }  
			d_table_i();
			
		} else{
		   request_tip(json.des,json.counts);
 		   $("#excel_addr").html("<a href='"+json.file_path+"' target='_blank'>"+json.file_path+"</a>");
		   
   		}
		    
  		},error:function(XMLHttpRequest,textStatus ){
			alert("页面请求错误，请检查重试或联系管理员！\n"+textStatus);
		}
   	});
	 
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
   
function check_form(actions)
 {	
   	if($("#job_name").val()==""){
		alert("请输入任务名称！");
		$("#job_name").focus();
		return false;
	}else{
		if($("#job_name").val().indexOf('\\')!=-1 || $("#job_name").val().indexOf('/')!=-1){
			alert("任务名称输入含有特殊字符 \\ /，请更正！");
			$("#job_name").select();
			return false;
		}	
	}
 	
 	if($("#phone_number_list").val()==""){
		c_phone_number('phone_number_list');
 		return false;
	}
     
	if (actions == "do_copy") {
		
		
		$("#copy_result").html();
		$('#load').show();
		var url="action=do_record_job&pages=1&actions=search&do_actions=copy"+times+"&"+$('#form1').serialize();
		//alert(url);
		request_tip("系统正在拷贝，此过程较慢，请耐心等候...",1,800000);
		$.ajax({
			 
			url: "send.php",
			data:url,
			
			beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
			complete :function(){$('#load').hide('100');},
			success: function(json){ 
				request_tip(json.des,json.counts);
				GetPageCount('search',"count");
				$("#do_zip_").bind("click",function(){check_form('do_zip');}).removeClass("zPushBtnDisabled");
				get_datalist(1,"search","list",$('#pagesize').val());
				$("#info_txt").html("<a href='javascript:void(0)' title='下载结果详单，请不要使用迅雷下载！' onclick=\"file_down('"+json.job_dir+"/说明.txt','说明.txt')\" >说明.txt</a>");
				
				if(json.counts=="1"){
					$("#copy_result").html(json.copy_result);
					$("#datatable").show();
					$("#zip_name").val(json.zip_name);
					$("#job_dir").val(json.job_dir);
				   
				}else{
					 
					$("#excels").css("display","none");
					$("#excel_addr").html('');
					$("#datatable tfoot tr").hide();
					tr_str="<tr><td colspan=\"12\" align=\"center\">"+json.des+"</td></tr>"
					$("#datatable").append(tr_str);
				} 
			   
			},error:function(XMLHttpRequest,textStatus ){
			   alert("处理超时！如果数据量较大请尝试分批次处理！\n"+textStatus);
			}
		});	
		 
     }
	 
	if (actions == "do_zip") {
		
 		$('#load').show();
		var url="action=do_record_job2zip&job_dir="+encodeURIComponent($("#job_dir").val())+"&zip_name="+encodeURIComponent($("#zip_name").val())+"&job_id="+$("#job_id").val()+times;
		//alert(url);
		//return false;
		request_tip("系统正在压缩，请耐性等待...",1,800000);
		$.ajax({
			 
			url: "send.php",
			data:url,
			
			beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
			complete :function(){$('#load').hide('100');},
			success: function(json){ 
			   request_tip(json.des,json.counts);
			   if(json.counts=="1"){
				    $("#do_zip_").unbind("click").addClass("zPushBtnDisabled");
      				$('#excel_addr').html("下载：<a href=\""+json.zip_path+"\" target=\"_blank\" title=\"点击下载录音备份\">"+$("#zip_name").val()+".zip</a>");
					$("#do_ziped").val("1");
					$("#datatable tbody tr").map(function(){
						$(this).find("td:eq(9)").html("删除&nbsp;收听&nbsp;下载");
						$(this).find("td:eq(0)").find("input[type='checkbox']").attr("disabled","disabled");
					})
					setTimeout("del_zip_dir()",1000);
 			   }else{
 					$('#excel_addr').html();
  			   } 
			   
			},error:function(XMLHttpRequest,textStatus ){
			   alert("页面请求错误，请检查重试或联系管理员!\n"+textStatus);
			}
		});	
		
     }
 }
 
 
function del_zip_dir(){
	
	var url="action=del_zip_dir&do_actions=job_dir&job_dir="+encodeURIComponent($("#job_dir").val())+"&job_id="+$("#job_id").val()+times;
	//alert(url);
 	$.ajax({
		 
		url: "send.php",
		data:url,
		
 		success: function(json){ 
 		   request_tip(json.des,json.counts);
		   $("#info_txt").html("");
		} 
	});	
} 
 
function c_phone_number(actions){
	 
	if($("#job_name").val()!=""){
		var diag =new Dialog("c_phone_number_");
		diag.Width = 580;
		diag.Height = 262;
		diag.Title = "填写被叫号码";
 		diag.URL = "/record/list.php?test=test&action="+actions+"&tits="+encodeURIComponent("填写被叫号码")+"&job_name="+encodeURIComponent($("#job_name").val())+"&job_id="+$("#job_id").val();
 		diag.OKEvent = setphone_number_list;
		diag.show();
 		
	}else{
		alert("请先填写任务名称！");
		$("#job_name").focus();
	}
}
 
function setphone_number_list(){
	Zd_DW.do_setphone_number_list();
}

   
$(document).ready(function(){
	
   var Sorts_Order=0;
	$("#datatable .dataHead th[sort]").map(function(){
		Sorts_Order=Sorts_Order+1;
		
		html=$(this).html();
		alert("111111111111");
		
		$(this).attr("id","DadaSorts_"+Sorts_Order).off().on("click",function(){
			Sorts_new("datatable",$(this).attr("id"),$("#pagesize").val());	
		}).html("<div>"+html+"<span class='sorting'></span></div>");
		
 	}) ;
   $('<input name="a_ctions" type="hidden" id="a_ctions"/> <input name="doa_ctions" type="hidden" id="doa_ctions"/> <input name="recounts" type="hidden" id="recounts"/> <input name="pages" type="hidden" id="pages" value="1"/> <input name="pagecounts" type="hidden" id="pagecounts"/><input name="pagesize" type="hidden" id="pagesize" value="20"/> <input name="sorts" type="hidden" id="sorts" value="datas.phone_number"/> <input name="order" type="hidden" id="order"/>').appendTo("body");
	$("#CheckedAll").click(function(){
		var checkbox=$('[name=c_id]:checkbox:enabled');
 		if(this.checked==true){
			$(checkbox).attr("checked",this.checked).parent().parent().addClass("click");
 		}else{
			$(checkbox).attr("checked",this.checked).parent().parent().removeClass("click");
		}
	});	
	
	
	$('#datatable').css("display","none");
	$("#excels").css("display","none");
 	days_ready();
	$("#time_len").css("display","none");
});
   
function select_time_zone(zone){
	if (zone==""){
		$("#time_len").css("display","none");
		$("#time_len").val("");
	}else{
		$("#time_len").css("display","block");
	}
}

function set_job_id(){
	
   if($("#job_name_bak").val()!=$("#job_name").val()){	
		 
		$('#datatable,#excels').css("display","none");
 		$("#a_ctions,#job_id,#doa_ctions,#recounts,#pages,#pagecounts,#order").val('');
     }
}


function del_(cid){	
 	var datas="";
 	
 	var datas="",c_id="";
 	
	if (cid!="0"&&cid!=""){
		c_id=cid;
		
	}else{
		c_id="";
 		$('input[name="c_id"]:checked').each(function(i){
			c_id+=""+$(this).val()+",";
 		}); 
		
		if(c_id!=""&&c_id.substr(c_id.length-1)==","){
			c_id=c_id.substr(0,c_id.length-1);
		}
 	}
	if (c_id==""){
		alert("请选择要删除的行！");
		return false;
	}
	datas="action=delete_record_log_file&c_id="+c_id+times;
  	//alert(datas);
    if(confirm("删除后不可恢复，您确定要删除吗？")){
 
		$('#load').show();
		$.ajax({
			 
			url: "send.php",
			data:datas,
			
			beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
			complete :function(){$('#load').hide('100');},
			success: function(json){ 
  			   request_tip(json.des,json.counts);
			   if(json.counts=="1"){
				   $("#CheckedAll").attr("checked",false);
				   GetPageCount($("#a_ctions").val(),"count");
 			   	   get_datalist($("#pages").val(),$("#a_ctions").val(),"list",$('#pagesize').val());
			   } 			   
				
			},error:function(XMLHttpRequest,textStatus ){
				alert("页面请求错误，请检查重试或联系管理员!\n"+textStatus);
			}
		});
   	}
}

function do_create_new_job(){
	if(confirm("新建处理任务将重置当前正在处理的数据！\n您确认要新建吗？")){
		document.location.reload();
		//$(":input[type!='input']","#form1").val("");
 	}
}

function addTab(tit,url,tab){window.parent.addTab(tit,url,tab)};

</script>
<script type="text/javascript" src="/js/calendar.js"></script>
 <?php check_login();?>
</head>
<body>
<div id="load" class="load_layer"><img src="/images/loading.gif"align="absmiddle"/>数据加载中...</div>
<div id="auto_save_res" class="load_layer"></div>
<div class="page_main">
  <table border="0" cellpadding="0" cellspacing="0" class="menu_list">
    <tr>
      <td colspan="2"><a href='javascript:void(0);' class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  priv="true" onclick="do_create_new_job();" title="新建处理任务！"><img src="/images/icons/icons_54.png" style="margin-top:4px" /><b>新建处理任务&nbsp;</b></a><a href='javascript:void(0);' onclick="addTab('录音批处理2','/document/record/RecordSet_Count.php','29')" class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  title="新建录音文件处理任务" ><img src="/images/icons/icons_54.png" style="margin-top:4px" /><b>处理任务2&nbsp;</b></a><a href='javascript:void(0);' onclick="addTab('查看处理日志','/document/record/RecordSetLog.php','set_log')"  class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false' priv="true" title="查看历史处理记录、未压缩记录处理" ><img src="/images/icons/icons_49.png" style="margin-top:4px" /><b>查看处理日志&nbsp;</b></a><a href='javascript:void(0);'  class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  priv="true" onclick="truncate_record_log();" title="清空历史处理日志，将加快处理速度！"><img src="/images/icons/icons_55.png" style="margin-top:4px" /><b>清空处理日志&nbsp;</b></a></td>
    </tr>
  </table>
  <table width="99%" border="0" align="center" cellpadding="0" class="blocktable" >
    <tr>
      <td >
      <fieldset>
          <legend>
          <label onclick="show_div('search_list');" title="点击收缩/展开">查询选项</label>
          </legend>
          <input name="job_dir" type="hidden" id="job_dir" value="" />
          <input name="job_name_bak" type="hidden" id="job_name_bak" value="" />
          <input name="zip_name" type="hidden" id="zip_name" value="" />
          <input name="do_ziped" type="hidden" id="do_ziped" value="0" />
          
            <form action="" onsubmit=""  method="post" name="form1" id="form1">       
                 <table width="100%" border="0" align="center"  cellspacing="0" id="search_list" class="search_table" >
                
                   <tr>
                     <td width="8%"  align="right">任务名称：</td>
                     <td ><input name="job_name" type="text" class="input_text" id="job_name" title="录音压缩文件包名称：可使用业务名称、日期等，如：福建如有传真_20110326、20110326..." size="30"  onkeyup="this.value=this.value.replace(/[\\|?|*|#|/|`|&|^|$|@|%|']/g,'')" onblur="this.value=this.value.replace(/[\\|?|*|#|/|`|&|^|$|@|%|']/g,'')" onafterpaste="this.value=this.value.replace(/[\\|?|*|#|/|`|&|^|$|@|%|']/g,'')"/></td>
                     
                     <td width="10%" align="right">业务活动：</td>
                     <td><input name="campaign_id_list" type="text" class="input_text2" id="campaign_id_list"  title="双击选择业务活动"  size="16"  readonly="readonly"  ondblclick="c_campaign_id_list('get_campaign_id_list');" /><a class="sel_" hidefocus="true" href="javascript:void(0);" title="点击选择业务活动" onclick="c_campaign_id_list('get_campaign_id_list');"></a></td>
                        
                                 
                    
                     <td width="8%"  align="right" id="td">质检结果：</td>
                     <td height="26"><input name="quality_status_list" type="text" class="input_text2" id="quality_status_list"  title="双击选择质检结果"  size="14"  readonly="readonly"  ondblclick="c_quality_status_list('get_quality_status_list');" /><a class="sel_" hidefocus="true" href="javascript:void(0);" title="点击选择质检结果" onclick="c_quality_status_list('get_quality_status_list');"></a></td>
                     <td width="8%" align="right">坐席工号：</td>
                     <td ><input name="agent_name_list" type="text" class="input_text2" id="agent_name_list"  title="双击选择坐席工号" size="16" readonly="readonly"  ondblclick="c_agent_list('get_agent_list');"/><a class="sel_" hidefocus="true" href="javascript:void(0);" title="点击选择坐席工号" onclick="c_agent_list('get_agent_list');"></a></td>
                   </tr>
                   <tr>
                   	 <td align="right">被叫号码：</td>
                     <td><input name="phone_number_list" type="text" class="input_text2" id="phone_number_list"  size="30" readonly="readonly" ondblclick="c_phone_number('phone_number_list');" onkeyup="this.value=value.replace(/[^\d|,]/g,'')" onafterpaste="this.value=value.replace(/[^\d|,]/g,'')"  /><a class="sel_" hidefocus="true" href="javascript:void(0);" title="点击填写要查找的呼叫号码" onclick="c_phone_number('phone_number_list');"></a></td>
                     <td height="26" align="right">呼叫结果：</td>
                     <td height="26"><input name="status_list" type="text" id="status_list"  title="双击选择呼叫结果" value="成功" size="14" readonly="readonly" ondblclick="c_status_list('get_status_list2');" class="input_text2"/><a class="sel_" hidefocus="true" href="javascript:void(0);" title="点击选择呼叫结果" onclick="c_status_list('get_status_list2');"></a></td>
                     
                     
                     <td width="8%"  align="right" id="">文件名称：</td>
                     <td  nowrap="nowrap">
                        <select name="record_type" class="s_option" id="record_type" >
                            <option value="phone" selected="selected" title="号码.wav">号码.wav</option>
                            <option value="phone_yyyymmdd" title="号码_年月日.wav">号码_年月日.wav</option>
                            <option value="0phone_yyyymmdd" title="0号码_年月日.wav">0号码_年月日.wav</option>
                            <option value="yyyymmdd_phone" title="年月日_号码.wav">年月日_号码.wav</option>
                            <option value="phone_hhmiss" title="号码_时分秒.wav">号码_时分秒.wav</option>
                            <option value="hhmiss_phone" title="时分秒_号码.wav">时分秒_号码.wav</option>
                            <option value="phone_yyyymmddhhmi" title="号码_年月日时分.wav">号码_年月日时分.wav</option>
                            <option value="phone_yyyymmddhhmiss" title="号码_年月日时分秒.wav">号码_年月日时分秒.wav</option>
                            <option value="0phone_yyyymmddhhmi" title="0号码_年月日时分.wav">0号码_年月日时分.wav</option>
                            <option value="0phone_yyyymmddhhmiss" title="0号码_年月日时分秒.wav">0号码_年月日时分秒.wav</option>
                            <option value="yyyymmddhhmiss_phone" title="年月日时分秒_号码.wav">年月日时分秒_号码.wav</option>
                            <option value="user_phone" title="工号_号码.wav">工号_号码.wav</option>
                            <option value="user_phone_yyyymmdd" title="工号_号码_年月日.wav">工号_号码_年月日.wav</option>
                            <option value="user_0phone_yyyymmdd" title="工号_0号码_年月日.wav">工号_0号码_年月日.wav</option>
                            <option value="user_phone_yyyymmddhhmiss" title="工号_号码_年月日时分秒.wav">工号_号码_年月日时分秒.wav</option>
                            <option value="user_0phone_yyyymmddhhmiss" title="工号_0号码_年月日时分秒.wav">工号_0号码_年月日时分秒.wav</option>
                            <option value="phone_user" title="号码_工号.wav">号码_工号.wav</option>
                            <option value="phone_user_yyyymmdd" title="号码_工号_年月日.wav">号码_工号_年月日.wav</option>
                            <option value="phone_user_yyyymmddhhmiss" title="号码_工号_年月日时分秒.wav">号码_工号_年月日时分秒.wav</option>
                            <option value="yyyymmdd_phone_user" title="年月日_号码_工号.wav">年月日_号码_工号.wav</option>
                            <option value="yyyymmddhhmiss_phone_user" title="年月日时分秒_号码_工号.wav">年月日时分秒_号码_工号.wav</option>
                            <option value="yyyymmdd_hhmiss_user_phone" title="年月日_时分秒_工号_号码.wav">年月日_时分秒_工号_号码.wav</option>
                            <option value="yyyymmdd_hhmiss_user_0phone" title="年月日_时分秒_工号_0号码.wav">年月日_时分秒_工号_0号码.wav</option>
                            <option value="yyyymmdd_hh_mi_ss_cid_phone_user" title="年月日_时_分_秒_主叫号码_号码_工号.wav">年月日_时_分_秒_主叫号码_号码_工号.wav</option>
                            <option value="yyyymmdd_hh_mi_ss_CHuser_cid_phone_user" title="年月日_时_分_秒_CH工号_主叫号码_号码_工号.wav">年月日_时_分_秒_CH工号_主叫号码_号码_工号.wav</option>
                            <option value="yyyymmdd_hh_mi_ss_CHuser_cid_0phone_user" title="年月日_时_分_秒_CH工号_主叫号码_0号码_工号.wav">年月日_时_分_秒_CH工号_主叫号码_0号码_工号.wav</option>
                            <option value="user-yyyy-mm-dd-phone" title="工号-年-月-日-号码.wav">工号-年-月-日-号码.wav</option>
                            <option value="yyyymmdd_hhmiss_qdyx_user_phone" title="日期_时分秒_qdyx_工号_号码.wav">日期_时分秒_qdyx_工号_号码.wav</option>
                            <option value="yyyymmdd_hhmiss_qdyx_user_0phone" title="日期_时分秒_qdyx_工号_0号码.wav">日期_时分秒_qdyx_工号_0号码.wav</option>
                            <option value="phone+yyyymmddhhmiss" title="号码+年月日时分秒.wav">号码+年月日时分秒.wav</option>
                            <option value="yymmdd_hhmiss_user_0phone" title="简写年月日_时分秒_工号_0号码.wav">简写年月日_时分秒_工号_0号码.wav</option>
                            <option value="yymmdd_hhmiss_user_phone" title="简写年月日_时分秒_工号_号码.wav">简写年月日_时分秒_工号_号码.wav</option>
                            <option value="user_yymmdd_hhmiss_user_0phone" title="工号_简写年月日_时分秒_工号_0号码.wav">工号_简写年月日_时分秒_工号_0号码.wav</option>
                            <option value="user_yymmdd_hhmiss_user_phone" title="工号_简写年月日_时分秒_工号_号码.wav">工号_简写年月日_时分秒_工号_号码.wav</option>
                            <option value="user_yyyymmdd_user_phone" title="工号_年月日_工号_号码.wav">工号_年月日_工号_号码.wav</option>
                            <option value="user_yyyymmdd_user_0phone" title="工号_年月日_工号_0号码.wav">工号_年月日_工号_0号码.wav</option>
                            <option value="yyyymmdd_user_phone" title="年月日_工号_号码.wav">年月日_工号_号码.wav</option>
                            <option value="yyyymmdd_user_0phone" title="年月日_工号_0号码.wav">年月日_工号_0号码.wav</option>
                            
                            <option value="first_name-phone" title="名字-号码.wav">名字-号码.wav</option>
                            <option value="first_name-0phone" title="名字-0号码.wav">名字-0号码.wav</option>
                            <option value="first_name-phone-yyyymmdd" title="名字-号码-年月日.wav">名字-号码-年月日.wav</option>
                            <option value="first_name-0phone-yyyymmdd" title="名字-0号码-年月日.wav">名字-0号码-年月日.wav</option>
                          </select>
                     </td>
                     <td width="8%"  align="right" id="td">呼叫方式：</td>
                     <td >
                        <select name="comments" id="comments" class="s_option">
                            <option value="">全部方式</option>
                            <option value="AUTO">自动</option>
                            <option value="MANUAL">手动</option>
                        </select>
                     </td>
                     
                   </tr>
                   <tr>
                     <td align="right">呼叫时间：</td>
                     <td colspan="3"><?php select_date("");?></td>
                     <td  align="right">数据范围：</td>
                 	 <td ><select name="archive" id="archive" class="s_option"> 
                        <option value="" title="查询默认表中记录">查询默认</option>
                        <option value="_archive" title="查询历史备份表中的记录">查询历史备份</option>
                    </select></td>
                     <td width="8%"  align="right">存放目录：</td>
                      <td ><select name="record_path" class="s_option" id="record_path" >
                        <option value="path_cam" selected="selected" title="按业务放置同一目录">按业务放置同一目录</option>
                        <option value="path_cam_date" title="按业务分日期放置同一目录">按业务分日期放置同一目录</option>
                        <option value="path_date" title="按日期放置同一目录">按日期放置同一目录</option>
                        <option value="path_all" title="全部放置同一目录">全部放置同一目录</option>
                       </select></td>
                      
                   </tr>
                   <tr>
                     <td height="26" align="right">
                     <input name="job_id" type="hidden" id="job_id" value="" />
                     <input type="hidden" name="status" id="status" value="CG" />
                     <input type="hidden" name="quality_status" id="quality_status" value="" />
                     <input type="hidden" name="agent_list" id="agent_list" value="" />
                     <input type="hidden" name="campaign_id" id="campaign_id" value="" />
                     <input type="hidden" name="phone_lists" id="phone_lists" value="" />
                     <input type="hidden" name="field_list" id="field_list" value="" />
                     <input type="hidden" name="phone_number" id="phone_number" value="">
                  
                     </td>
                     <td height="26" colspan="7"><input type="button" name="form_submit" value="开始处理" onclick="check_form('do_copy');" />
                       <input type="reset" name="button" id="button" value="重置" /></td>
                   </tr>
                  </table> 
          
                </form>                
          
        </fieldset>
      <div id="excels" style="height:22px; line-height:22px;"><span><a href='javascript:void(0);' id="do_zip_"  class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  title="将本次处理结果压缩为一个ZIP文件！"><img src="/images/icons/icon029a16.gif" /><b>压缩录音文件包&nbsp;</b></a></span><span id="copy_result" style="height:22px; line-height:22px;margin-left:6px"></span><span id="excel_addr" style="height:22px;line-height:22px;margin-left:6px"></span><span id="info_txt" style="height:22px;line-height:22px;margin-left:6px"></span></div>
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="dataTable" id="datatable" style="display:block">
          <thead>
            <tr align="left" class="dataHead">
              <th style="width:4%"><input name="CheckedAll" type="checkbox" id="CheckedAll" />
                <a href="javascript:void(0);" onclick="del_(0);" title="删除选定数据" style="font-weight:normal">删</a></th>
              <th sort="datas.phone_number" >被叫号码</th>
              <th sort="d.campaign_name" >业务活动</th>
              <th sort="a.user" >工号</th>
              <th sort="a.call_date" style="" >呼叫时间</th>
              <th sort="e.status_name" >呼叫结果</th>
              <th sort="c.length_in_sec">时长<strong style="font-weight:normal">(秒)</strong></th>
              <th sort="datas.record_name">文件名称</th>
              <th sort="datas.result">备份结果</th>
              <th align="center">操作</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr class='dataTableFoot'>
              <td colspan='19' align='left'><div id='dataTableFoot'><div style='float:right;' id='pagelist'></div><div style='float:left;' id='total'></div></div></td>
            </tr>
          </tfoot>
        </table></td>
    </tr>
  </table>
</div>
</body>
</html>

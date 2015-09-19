<?php require("../inc/config.ini.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xHTML1/DTD/xHTML1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xHTML">
<head>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
<title> <?php echo $system_name ?></title>
<link href="/css/main.css?v=<?php echo $today ?>" rel="stylesheet" type="text/css">
<link href="/css/day.css" rel="stylesheet" type="text/css">
<script src="/js/jquery-1.8.3.min.js"></script>
<script src="/js/main.js?v=<?php echo $today ?>"></script>
<script src="/js/pub_func.js?v=<?php echo $today ?>"></script>
<script>
function GetPageCount(a_ctions,doa_ctions)
    {
	$("#a_ctions").val(a_ctions);
	$("#doa_ctions").val(doa_ctions);
  	
	var url="action=get_record_list&pages=1&actions="+a_ctions+"&do_actions="+doa_ctions+"&sorts="+$('#sorts').val()+"&order="+$('#order').val()+times+"&"+$('#form1').serialize();
 	
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
	
 	$('#load').show();
	//$("#xls_addr,#csv_addr").html('');
 	max_pages(pagesize);
 	var pages=$("#pagecounts").val();
 	if(parseInt(page_nums) < 1)page_nums = 1; 
 	if(parseInt(page_nums) > parseInt(pages)){
		page_nums = pages;
  	}; 
 	if(!(parseInt(page_nums) <= parseInt(pages))) page_nums = pages;	 
	 
  	var url="action=get_record_list&pages="+page_nums+"&actions="+a_ctions+"&do_actions="+doa_ctions+"&sorts="+$('#sorts').val()+"&order="+$('#order').val()+"&pagesize="+pagesize+times+"&"+$('#form1').serialize();
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
				 
				$.each(json.datalist, function(index,con){
	 	    
 				tr_str="<tr align=\"left\">";
				tr_str+="<td >"+con.phone_number+"</td>";
 				tr_str+="<td >"+con.citys+"</td>";
 				tr_str+="<td >"+con.user+"["+con.full_name+"]</td>";
   				tr_str+="<td >"+con.phone_login+"</td>";
				tr_str+="<td >"+con.start_time+"</td>";
				tr_str+="<td >"+con.length_in_sec+"</td>";
				tr_str+="<td >"+con.length_in_min+"</td>";
				tr_str+="<td >"+con.comments+"</td>";
				tr_str+="<td >"+con.status_name+"</td>";
				
				if(con.locations){
					if (con.locations!="同步中"){
						tr_str+="<td ><a href=\"javascript:void(0);\" onClick=\"play_wav(event,'play_layer','"+con.locations+"');\">收听</a>&nbsp;<a href=\""+con.locations+"\" target=\"_blank\" >下载</a></td>";
					}else{
						tr_str+="<td >"+con.locations+"</td>";
					}
				}else{
  					tr_str+="<td >无</td>";
				}
				tr_str+="</tr>";
				$("#datatable tbody").append(tr_str);
			}); 
   		 
			OutputHtml(page_nums,pagesize);
 			
		   }else{
				$("#excels").css("display","none");
				$("#xls_addr,#csv_addr").html('');
				 
				$("#datatable tfoot tr").hide();
				tr_str="<tr><td colspan=\"10\" align=\"center\">"+json.des+"</td></tr>"
				$("#datatable").append(tr_str);
		   }  
	   		d_table_i();
			
		} else{
			
			request_tip(json.des,json.counts);
			if(json.counts=="1"){
			   $("#"+$("#file_type").val()+"_addr").html("下载：<a href='"+json.file_path+json.file_name+"' target='_blank'>"+json.file_name+"</a>"); 
			}else{
				$("#"+$("#file_type").val()+"_addr").html(json.des); 
			}
		   
  		}
		    
  		},error:function(XMLHttpRequest,textStatus ){
			alert("页面请求错误，请检查重试或联系管理员！\n"+textStatus);
		}
   	});
	
	 
}

function check_form(actions,file_type)
 {	
   	var agents=$("#agent_list").val();
	
 	if($("#phone_number").val()!=""&&($("#phone_number").val().substr(0,1)==","||$("#phone_number").val().substring($("#phone_number").val().length,$("#phone_number").val().length-1)==",")){
		
 		alert("被叫号码不能以英文逗号开头或结尾！");
		$("#phone_number").select();
 		return false;
 	}
	
	/*if(agents==""){
			
		alert("请选择"+$("#caller_types").html().replace("：","")+"查询！");
		$("#agent_name_list").focus();
		return false;
	}*/
 	
	if($("#time_zone").val()!=""&&$("#time_len").val()==""){
		alert("请选择时长范围数值！");
 		$("#time_len").focus();
		return false;
	}
	
    if (actions == "search") {
  		 
  		$("#datatable").show();
        GetPageCount('search',"count");get_datalist(1,"search","list",$('#pagesize').val());

    }
	 
    if (actions == "excel") {
		$("#file_type").val(file_type);
		request_tip("系统正在为您导出，此过程较慢，请耐心等候...",1,30000);
  		$("#datatable").show();
        get_datalist(1,"search","excel",$('#pagesize').val());
     }
	 
}
 
 
function change_calltype(types){
	var tit="";re_tit="";dis="";
	if(types=="in"){
		tit="外呼";
		re_tit="受理";
		dis="";
 	}else{
		tit="受理";
		re_tit="外呼";
		dis="disabled";
 	}
	$("#agent_name_list").attr("title",$("#agent_name_list").attr("title").replace(tit,re_tit));
	$("#c_agent_list_b").attr("title",$("#c_agent_list_b").attr("title").replace(tit,re_tit));
	$("#caller_types").text($("#caller_types").text().replace(tit,re_tit));
	$("#callerid").attr("disabled",dis);
}
  
 
$(document).ready(function(){
	
   var Sorts_Order=0;
   
	$("#datatable .dataHead th[sort]").map(function(){
		Sorts_Order=Sorts_Order+1;
		
		html=$(this).html();
		
		$(this).attr("id","DadaSorts_"+Sorts_Order).off().on("click",function(){
			Sorts_new("datatable",$(this).attr("id"),$("#pagesize").val());	
		}).html("<div>"+html+"<span class='sorting'></span></div>");
		
 	}) ;
   $('<input name="a_ctions" type="hidden" id="a_ctions"/> <input name="doa_ctions" type="hidden" id="doa_ctions"/> <input name="recounts" type="hidden" id="recounts"/> <input name="pages" type="hidden" id="pages" value="1"/> <input name="pagecounts" type="hidden" id="pagecounts"/><input name="pagesize" type="hidden" id="pagesize" value="20"/> <input name="sorts" type="hidden" id="sorts" value="d.start_time"/> <input name="order" type="hidden" id="order"/>').appendTo("body");

	$('#datatable').css("display","none");
	$("#excels").css("display","none");
 	days_ready();
	$("#time_len").css("display","none");
});
   
function select_time_zone(zone){
	if (zone==""){
		$("#time_zone").css("width","");
		$("#time_len").css("display","none");
		$("#time_len").val("");
	}else{
		$("#time_len").focus().css("display","block");
		$("#time_zone").css("width","78px");
	}
}
</script>
<script type="text/javascript" src="/js/calendar.js"></script>
 
</head>
<body>
<div id="load" class="load_layer"><img src="/images/loading.gif"align="absmiddle"/>数据加载中...</div>
<div id="auto_save_res" class="load_layer"></div>
<div class="page_main">
<table width="99%" border="0" align="center" cellpadding="0" class="blocktable" >
        <tr>
            <td style="">
            
            <fieldset><legend> <label onClick="show_div('search_list');" title="点击收缩/展开">查询选项</label></legend>
              <form action="" onSubmit=""  method="post" name="form1" id="form1">       
             <table width="100%" border="0" align="center"  cellspacing="0" id="search_list" class="search_table" >
            
               <tr>
                 <td width="8%"  align="right">被叫号码：</td>
                 <td ><input name="phone_number" type="text" class="input_text" id="phone_number" title="输入要查询的被叫号码，多个以英文","分隔"  size="21" onkeyup="this.value=value.replace(/[^\d|,]/g,'')" onafterpaste="this.value=value.replace(/[^\d|,]/g,'')" /></td>
                 
                 <td width="10%" align="right">号码精度：</td>
             <td><select name="search_accuracy" class="s_option" id="search_accuracy">
                    <option value="=">等于</option>
                    <option value="in">包含</option>
                    <option value="not in">不包含</option>
                    <option value="like_top">匹配开头</option>
                    <option value="like_end">匹配结尾</option>
                    <option value="like">模糊</option>
                   </select></td>
                 <td width="10%" align="right">呼叫类型：</td>
                 <td><select name="comments" id="comments" class="s_option">
                        <option value="">全部类型</option>
                        <option value="auto">自动</option>
                        <option value="MANUAL">手动</option>
                    </select></td>
                 <td width="8%" align="right">录音时长：</td>
                 <td><select name="time_zone" id="time_zone" class="s_option" title="选定时长范围" onChange="select_time_zone(this.value);" style="float:left; margin-right:2px;">
                                    <option value="" selected="selected">请选择时长范围</option>
                                    <option value="<">小于</option>
                                    <option value=">">大于</option>
                                    <option value="=">等于</option>
                                    <option value="!=">不等于</option>
                                    <option value=">=">大于等于</option>
                                    <option value="<=">小于等于</option>
                                </select>
                 <input name="time_len" id="time_len" style="float:left"  title="填写开始时长范围,单位：秒" value="" size="2" maxlength="4" onKeyUp="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" /> </td>
                 
                 
               </tr>
               <tr>
                 <td  align="right" nowrap="nowrap">呼叫时间：</td>
                 <td  colspan="3"><?php select_date("");?></td>
                 <td width="10%"  align="right" id="td">坐席工号：</td>
                 <td ><input name="agent_name_list" type="text" class="input_text2" id="agent_name_list"  title="双击选择坐席工号" size="16" readonly="readonly"  onDblClick="c_agent_list('get_agent_list');"/><a class="sel_" hidefocus="true" href="javascript:void(0);" title="点击选择坐席工号" onClick="c_agent_list('get_agent_list');"></a></td>
                 <td width="8%"  align="right" id="td"></td>
                 <td ></td>
               </tr>
               <tr>
                 <td  align="right"><input type="hidden" name="status" id="status" value="CG" />
                 <input type="hidden" name="quality_status" id="quality_status" value="" />
                 <input type="hidden" name="agent_list" id="agent_list" value="" />
                 <input type="hidden" name="campaign_id" id="campaign_id" value="" />
                 <input type="hidden" name="phone_lists" id="phone_lists" value="" />
                 <input type="hidden" name="field_list" id="field_list" value="" />
                 <input type="hidden" name="file_type" id="file_type" value="" />
                 </td>
                 <td  colspan="7"><input type="button" name="form_submit" value="提交查询" onClick="check_form('search');" style="cursor:pointer" />
                   <input type="reset" name="button" id="button" value="重置" /></td>
               </tr>
              </table> 
      
            </form>                
                
                
            </fieldset>
              
            <div id="excels"  style="height:22px; line-height:22px;"><span><a href='javascript:void(0);'  class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false' priv="true" style="" onClick="check_form('excel','xls');"><img src="/images/icons/excel.png" style="margin-top:4px"/><b>导出Xls&nbsp;</b></a><a href='javascript:void(0);'  class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false' priv="true" style="" onClick="check_form('excel','csv');"><img src="/images/icons/notebook.png"  style="margin-top:4px"/><b>导出Csv&nbsp;</b></a></span><span id="xls_addr" style="height:22px; line-height:22px;margin-left:10px"></span><span id="csv_addr" style="height:22px; line-height:22px;margin-left:10px"></span></div>
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="dataTable" id="datatable" >
                  <thead>
                    <tr align="left" class="dataHead">
             
                      <th sort="a.phone_number" >被叫号码</th>
                      <th sort="citys" >省份城市</th>
                       <th sort="d.user" >工号</th>
                      <th sort="b.phone_login">分机号</th>
                      <th sort="d.start_time"  style="" >呼叫时间</th>
                      <th sort="d.length_in_sec">时长<strong style="font-weight:normal">(秒)</strong></th>
                      <th sort="d.length_in_min">时长<strong style="font-weight:normal">(分)</strong></th>
                      <th sort="comments">呼叫方式</th>
                      <th sort="e.status_name">呼叫结果</th>                      
                      <th style="" align="center">操作</th>
                    </tr>
                  </thead>   
                    <tbody>
                    </tbody>
                    <tfoot><tr class='dataTableFoot'><td colspan='14' align='left'><div id='dataTableFoot'><div style='float:right;' id='pagelist'></div><div style='float:left;' id='total'></div></div></td></tr></tfoot>
              </table>
               
         </td>
  </tr>
 </table>  
</div>
 
</body>
</html>
   

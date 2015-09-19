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
  	
	var url="action=reocrd_job_list&pages=1&actions="+a_ctions+"&do_actions="+doa_ctions+"&sorts="+$('#sorts').val()+"&order="+$('#order').val()+times+"&"+$('#form1').serialize();
 	
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
	$("#excel_addr").html('');
 	max_pages(pagesize);
 	var pages=$("#pagecounts").val();
 	if(parseInt(page_nums) < 1)page_nums = 1; 
 	if(parseInt(page_nums) > parseInt(pages)){
		page_nums = pages;
  	}; 
 	if(!(parseInt(page_nums) <= parseInt(pages))) page_nums = pages;	 
  	 
  	var url="action=reocrd_job_list&pages="+page_nums+"&actions="+a_ctions+"&do_actions="+doa_ctions+"&sorts="+$('#sorts').val()+"&order="+$('#order').val()+"&pagesize="+pagesize+times+"&"+$('#form1').serialize();
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
				 
	 	    	var tits="",td_str="",fun_str="",qua_str="";
				$.each(json.datalist, function(index,con){
 				
				if(con.is_zip=="1"){
					is_zip="是";
  					td_str="<span id=\"set_detail_"+con.job_id+"\">详单</span>&nbsp;<a href=\""+con.zip_path+".zip\" target=\"_blank\" title=\"点击下载本次营销录音\">下载</a>";
 				}else if(con.zip_path!=""&&con.zip_path!== undefined&&con.zip_path!== null){
  					td_str="<span id=\"set_detail_"+con.job_id+"\"><a href=\"javascript:void(0);\" onclick=\"file_down('"+con.zip_path+"/说明.txt','说明.txt')\" title=\"点击下载查看本处理任务结果详单，请不要使用迅雷下载！\">详单</a></span>&nbsp;<span id='do_zip_link_"+con.job_id+"'><a href=\"javascript:void(0);\" onclick=\"do_zip('"+con.zip_path+"','"+con.job_name+"','"+con.job_id+"')\" title=\"点击压缩本次营销录音\">压缩</a></span>";
					is_zip="否";
				}else{
					is_zip="否";
					td_str="";	
				}		
				zs=con.ZS?con.ZS:0;
				cg=con.CG?con.CG:0;
				sb=con.SB?con.SB:0;
				bcz=con.BCZ?con.BCZ:0;
				wly=con.WLY?con.WLY:0;
 			 	
 				tr_str="<tr align=\"left\" >";
  				tr_str+="<td>"+con.job_name+"</td>";
 				tr_str+="<td>"+zs+"</td>";
				tr_str+="<td>"+cg+"</td>";
				tr_str+="<td>失败:"+sb+",不存在:"+bcz+",无录音:"+wly+"</td>";
				tr_str+="<td>"+con.addtime+"</td>";
				tr_str+="<td id=\"end_"+con.job_id+"\">"+con.endtime+"</td>";
				tr_str+="<td id=\"zip_"+con.job_id+"\">"+is_zip+"</td>";
				tr_str+="<td>"+con.userid+" ["+con.full_name+"]</td>";
  				tr_str+="<td><div><span id=\"do_"+con.job_id+"\"></span> <a class='close'></a></div>"+td_str+"&nbsp;<a href=\"javascript:void(0);\" onclick=\"do_del('"+con.zip_path+"','"+con.job_name+"','"+con.job_id+"')\" title=\"点击删除本次录音处理任务及录音\">删除</a></td></tr>";
				$("#datatable tbody").append(tr_str);
				
			}); 
			$("#datatable tbody a.close").off().on("click",function(){$(this).parent().fadeOut()}).attr("title","关闭");
   			OutputHtml(page_nums,pagesize);
			
		   }else{
 				$("#datatable tfoot tr").hide();
				tr_str="<tr><td colspan=\"12\" align=\"center\">"+json.des+"</td></tr>"
				$("#datatable").append(tr_str);
		   }  
 		   d_table_i();
			
		} else{
 		   $("#excel_addr").html("<a href='"+json.file_path+"' target='_blank'>"+json.file_path+"</a>");
		   request_tip(json.des,json.counts);
   		}
		    
  		},error:function(XMLHttpRequest,textStatus ){
			alert("页面请求错误，请检查重试或联系管理员！\n"+textStatus);
		}
   	});
	
}
 
function do_zip(job_dir,zip_name,job_id){
	request_tip("系统正在压缩，请稍候...",1,20000);
	$('#load').show();
	var url="action=do_record_job2zip&job_dir="+encodeURIComponent(job_dir)+"&zip_name="+encodeURIComponent(zip_name)+"&job_id="+job_id+times;
	//alert(url);
	//return false;
	$.ajax({
		 
		url: "send.php",
		data:url,
		
		beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
		complete :function(){$('#load').hide('100');},
		success: function(json){ 
		
		   request_tip(json.des,json.counts);
		   if(json.counts=="1"){
			   			   
 				$('#do_'+job_id).html("&nbsp;<a href=\""+json.zip_path+"\" target=\"_blank\" title=\"点击下载录音备份\" >下载</a>").parent().fadeIn();
				$('#do_zip_link_'+job_id).html("<a href=\""+json.zip_path+"\" target=\"_blank\" title=\"点击下载录音备份\" class='yellow_tip' >下载</a>");
				$('#zip_'+job_id).html("是"); 
				$('#end_'+job_id).html(json.endtime);
				$('#set_detail_'+job_id).html("详单");
				setTimeout("del_zip_dir('"+job_dir+"','"+job_id+"')",1000);
 		   } 
		   
		},error:function(XMLHttpRequest,textStatus ){
		   alert("页面请求错误，请检查重试或联系管理员!\n"+textStatus);
		}
	});		

}

function del_zip_dir(job_dir,job_id){
	
	var url="action=del_zip_dir&do_actions=job_dir&job_dir="+encodeURIComponent(job_dir)+"&job_id="+job_id+times;
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
 

function do_del(job_dir,zip_name,job_id){
	
	if(confirm("删除操作将一并删除录音压缩包文件！\n\n您确定要删除吗？")){
		$('#load').show();
		var url="action=del_zip_dir&job_dir="+encodeURIComponent(job_dir)+"&zip_name="+encodeURIComponent(zip_name)+"&job_id="+job_id+times;
		//alert(url);
		//return false;
		$.ajax({
			 
			url: "send.php",
			data:url,
			
			beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
			complete :function(){$('#load').hide('100');},
			success: function(json){ 
			   request_tip(json.des,json.counts);
			   if(json.counts=="1"){
				   GetPageCount($("#a_ctions").val(),"count");
				   get_datalist($("#pages").val(),$("#a_ctions").val(),"list",$('#pagesize').val());
			   } 
			   
			},error:function(XMLHttpRequest,textStatus ){
			   alert("页面请求错误，请检查重试或联系管理员!\n"+textStatus);
			}
		});		
	}
}


function check_form(actions)
 {	
     
    if (actions == "search") {
  		 
  		$("#datatable").show();
        GetPageCount('search',"count");get_datalist(1,"search","list",$('#pagesize').val());

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
			GetPageCount("search","count");
			get_datalist(1,"list","list",$('#pagesize').val());
		   
 		},error:function(XMLHttpRequest,textStatus ){
		   alert("页面请求错误，请检查重试或联系管理员!\n"+textStatus);
		}
	});
	
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
   $('<input name="a_ctions" type="hidden" id="a_ctions"/> <input name="doa_ctions" type="hidden" id="doa_ctions"/> <input name="recounts" type="hidden" id="recounts"/> <input name="pages" type="hidden" id="pages" value="1"/> <input name="pagecounts" type="hidden" id="pagecounts"/><input name="pagesize" type="hidden" id="pagesize" value="20"/> <input name="sorts" type="hidden" id="sorts" value="b.addtime"/> <input name="order" type="hidden" id="order"/>').appendTo("body");
 	
 	days_ready()
    GetPageCount("search","count");
    get_datalist(1,"list","list",$('#pagesize').val());
	
});
function addTab(tit,url,tab){window.parent.addTab(tit,url,tab)}; 
</script>
<script type="text/javascript" src="/js/calendar.js"></script>
<style>
#datatable tbody div{position:relative;width:80%;height:20px;line-height:20px;background:#FEFEE9;border:1px solid #B1B1B1;position:relative; display:none}
#datatable tbody a.close{width:8px;height:8px;line-height:8px;background:url(/images/tips/tip_bg.gif) no-repeat 0 -26px;display:inline;position:absolute;right:4px;top:6px;cursor:pointer;font-size:1px;}
#datatable tbody a.close:hover{background-position:0 -34px;}
.hide_tit{width:120px;}
</style>
 
</head>
<body>
<div id="load" class="load_layer"><img src="/images/loading.gif"align="absmiddle"/>数据加载中...</div>
<div id="auto_save_res" class="load_layer"></div>

<div class="page_main">
  <table border="0" cellpadding="0" cellspacing="0" class="menu_list">
  <tr>
        <td ><a href='javascript:void(0);' onclick="addTab('录音批处理1','/document/record/RecordSet.php','28')" class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  title="新建录音文件处理任务" ><img src="/images/icons/icons_54.png" style="margin-top:4px" /><b>处理任务1&nbsp;</b></a><a href='javascript:void(0);' onclick="addTab('录音批处理2','/document/record/RecordSet_Count.php','29')" class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  title="新建录音文件处理任务" ><img src="/images/icons/icons_54.png" style="margin-top:4px" /><b>处理任务2&nbsp;</b></a><a href='javascript:void(0);'  class='zPushBtn' hidefocus='true' tabindex='-1' onselectstart='return false'  onClick="truncate_record_log();" title="清空历史处理日志，将加快处理速度！"><img src="/images/icons/icons_55.png" style="margin-top:4px" /><b>清空处理日志&nbsp;</b></a></td>
      </tr>
    </table>
    <table width="99%" border="0" align="center" cellpadding="0" class="blocktable" >
            <tr>
            <td>

        <fieldset><legend> <label onClick="show_div('search_list');" title="点击收缩/展开">查询选项</label></legend>
            <form action="" onSubmit=""  method="post" name="form1" id="form1">       
             <table width="100%" border="0" align="center"  cellspacing="0" id="search_list" class="search_table" >
            
               <tr>
                 <td width="8%" height="26" align="right">任务名称：</td>
                 <td width="12%" height="26"><input name="job_name" type="text" class="input_text" id="job_name" title="输入要查询的任务名称"  size="21" /></td>
                 <td width="8%" height="26" align="right" id="">&nbsp;</td>
                 <td width="12%" height="26">&nbsp;</td>
                 <td width="8%" align="right">&nbsp;</td>
                 <td width="12%">&nbsp;</td>
                 <td width="8%" align="right">&nbsp;</td>
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td height="26" align="right">开始时间：</td>
                 <td height="26" colspan="7"><?php select_date("none");?></td>
               </tr>
               <tr>
                 <td height="26" align="right">&nbsp;</td>
                 <td height="26" colspan="7"><input type="button" name="form_submit" value="提交查询" onClick="check_form('search');" style="cursor:pointer" />
                   <input type="reset" name="button" id="button" value="重置" /></td>
               </tr>
              </table> 
      
            </form>
          </fieldset>      
        
        
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="dataTable" id="datatable" >
                  <thead>
                    <tr align="left" class="dataHead">
                    
                      <th sort="b.job_name" >任务名称</th>
                      <th sort="b.result" >号码数</th>                   
                      <th sort="b.result" >处理成功</th>
                      <th sort="b.result" >处理失败</th>
                      <th sort="b.addtime" >开始时间</th>
                      <th sort="b.endtime">结束时间</th>
                      <th sort="b.is_zip">压缩</th>
                      <th sort="b.userid">工号</th>
                      <th style="" align="center">操作</th>
                    </tr>
                  </thead>   
                    <tbody>
                    </tbody>
                    <tfoot><tr class='dataTableFoot'><td colspan='18'align='left'><div id="dataTableFoot"><div style="float:right;" id="pagelist" class="digg"></div><div style="float:left;" id='total'></div></div></td></tr></tfoot>
              </table>
               
         </td>
  </tr>
 </table>  
 
 <div>
 
 </div>
</div>
 
</body>
</html>
   

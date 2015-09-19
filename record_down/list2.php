<?php 
require("./inc/pub_func.php"); 
$tits=trim($_REQUEST["tits"]);
$job_name=gb2utf8(trim($_REQUEST["job_name"]));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xHTML1/DTD/xHTML1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
<title><?php echo $GLOBALS["system_name"] ?>-选择被叫号段</title>
<link href="./css/main.css?v=<?php echo $today ?>" rel="stylesheet" type="text/css">
<link href="./css/list.css?v=<?php echo $today ?>" rel="stylesheet" type="text/css" />
<link href="./js/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="./js/jquery-1.8.3.min.js"></script>
<script src="./js/pub_func.js?v=<?php echo $today ?>"></script>
<script src="./js/main.js?v=<?php echo $today ?>"></script>
<script src='./js/jquery-autocomplete/jquery.autocomplete.min.js'></script>
<style>
.s_input {
	width: 196px
}
.s_option {
	width: 202px
}
#text_search_layer {
	position: absolute;
	right: 10px;
	top: 36px
}
</style>
<script>
 

//搜索
jQuery.fn.highlight = function(pat){function innerHighlight(node, pat){var skip = 0; if (node.nodeType == 3){var pos = node.data.toUpperCase().indexOf(pat); if (pos >= 0){var spannode = document.createElement('em'); spannode.className = 'highlight'; var middlebit = node.splitText(pos); var endbit = middlebit.splitText(pat.length); var middleclone = middlebit.cloneNode(true); spannode.appendChild(middleclone); middlebit.parentNode.replaceChild(spannode, middlebit); skip = 1;} } else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)){for (var i = 0; i < node.childNodes.length; ++i){i += innerHighlight(node.childNodes[i], pat);} } return skip;} return this.each(function(){innerHighlight(this, pat.toUpperCase());});};jQuery.fn.removeHighlight = function(){function newNormalize(node){for (var i = 0, children = node.childNodes, nodeCount = children.length; i < nodeCount; i++){var child = children[i]; if (child.nodeType == 1){newNormalize(child); continue;} if (child.nodeType != 3){continue;} var next = child.nextSibling; if (next == null || next.nodeType != 3){continue;} var combined_text = child.nodeValue + next.nodeValue; new_node = node.ownerDocument.createTextNode(combined_text); node.insertBefore(new_node, child); node.removeChild(child); node.removeChild(next); i--; nodeCount--;} } return this.find("em.highlight").each(function(){var thisParent = this.parentNode; thisParent.replaceChild(this.firstChild, this); newNormalize(thisParent);}).end();}; 

function text_search(){
	var searchTerm = $('#text_search').val();
	$('.search_text_zone').removeHighlight();
	if(searchTerm){$('.search_text_zone').highlight(searchTerm );}
}


function do_setagent_list(){
 	var agent_list="";
	var agent_name="";
 	 $('#form1 input[name="agents"]:enabled:checked').each(function(i){
 
		 var list_s=$(this).val().split("|")[1];
		 agent_list+=list_s+",";
		 
		 var list_s_r=$(this).val().split("|")[0];
		 agent_name+=list_s_r+",";
  
   	}); 
 	if (agent_list!=""){agent_list=agent_list.substr(0,agent_list.length-1)}
 	$(_DialogInstance.ParentWindow.document).find("#agent_list").val(agent_list);
	
	if (agent_name!=""){agent_name=agent_name.substr(0,agent_name.length-1)}
 	$(_DialogInstance.ParentWindow.document).find("#agent_name_list").val(agent_name);
	
 	$(_DialogInstance.ParentWindow.document).find("#agent_name_list").attr("title","双击<?php echo $tits; ?>："+agent_name);
 	setTimeout('Dialog.close();',10); 
}

function dis_unactive(){
 	$(".check_items ul li[active='N']").each(function(){
 		//alert($(this).find(":input[type=checkbox]").attr("disabled"));
		if($(this).find(":input[type=checkbox]").is(":disabled")==true){
   			$(this).find(":input[type=checkbox]").attr("disabled",false);
		}else{
			$(this).find(":input[type=checkbox]").attr("disabled",true);
 		}
 		
		$(this).toggle();
	});
	 
 }
    
</script>
</head>

<body>
<div id="load" class="load_layer"><img src="/images/loading.gif"align="absmiddle"/>数据加载中...</div>
<div id="auto_save_res" class="load_layer"></div>
<?php 
  
switch($action){ 
   
case "set_phone_number_list": 
?>
<script>

$(document).ready(function(e){
 	
	phones_init_val=$(_DialogInstance.ParentWindow.document).find("#phone_number").val().trim().split(",");
	$("#phone_number").val(phones_init_val).focus();
	//$("#old_phone_number").val(phones_init_val);
	get_phone_count();
 
});

function get_phone_count(){
	phone_counts=$("#phone_number").val()?$("#phone_number").val().trim().split("\n").length:0;
 	$("#phone_counts").html(phone_counts);
}

function do_phone_number_list(){
  	phones=$("#phone_number").val();
	//old_phone_number=$("#old_phone_number").val();
	
 
 	if(phones==""){
		alert("请填写电话号码！");
		$("#phone_number").focus();
 		return false;
	}else{
	 $("#phone_number").val()
	}

 	/*
	var phone_counts=$("#phone_counts").html();
	if(!phone_counts){
		alert("电话号码填写有误，请刷新后重试！");
		$("#phone_number").focus();
 		return false;	
	}
	
	if(parseInt(phone_counts)>1000){
		alert("您填写的电话号码数量超过最大限值 1000 ！\n请删减部分号码后重试！");
		$("#phone_number").focus();
 		return false;		
	}
	*/
	/*if(phones!=old_phone_number){
		var url="action=create_phone_list_job&"+$('#form1').serialize();
		 
		$.ajax({
			 
			url: "send.php",
			data:url,		
			beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
			complete :function(){$('#load').hide('100');},
			success: function(json){ 
				
				if(json.counts=="1"){
					$(_DialogInstance.ParentWindow.document).find("#job_id").val(json.job_id);
								
					$(_DialogInstance.ParentWindow.document).find("#phone_number").val(phones);
					$(_DialogInstance.ParentWindow.document).find("#phone_number_list").val("号码："+phone_counts+" 个").attr("title","号码："+phone_counts+" 个");
					 
					setTimeout('Dialog.close();',10);
					 
				}else{
					request_tip(json.des);	
				}
						
			}
		});
	}else{
		setTimeout('Dialog.close();',10);	
	}*/
	$(_DialogInstance.ParentWindow.document).find("#phone_number").val(phones);
	if(phones!=""){
		$(_DialogInstance.ParentWindow.document).find("#phone_number_list").val("号码："+phone_counts+" 个").attr("title","号码："+phone_counts+" 个");
		if(phone_counts>1){
			$(_DialogInstance.ParentWindow.document).find("#search_accuracy").val("in");	
		}
	}else{
		$(_DialogInstance.ParentWindow.document).find("#phone_number_list").val("").attr("title","");
	}
	
	setTimeout('Dialog.close();',10);	
  	
}
</script>
<div id="load" class="load_layer"><img src="/images/loading.gif"align="absmiddle"/>数据加载中...</div>
<div id="auto_save_res" class="load_layer"></div>
<div class="page_nav">
  <div class="nav_ico"><img src="/images/page_nav_ico.jpg" /></div>
  <div class="nav_">当前位置：<a href="javascript:void(0);">数据报表</a> &gt; <?php echo $tits ?> </div>
  <div class="nav_other"><a href="javascript:void(0);" onclick="javascript:window.location.reload();"><img src="/images/page_reload.jpg" alt="刷新本页"/></a></div>
</div>
<div class="page_main">
  <fieldset>
    <legend>
    <label for="quality_status_all"><?php echo $tits ?> </label>
    </legend>
    <!--<textarea name="old_phone_number" id="old_phone_number"></textarea>-->
    <form action="" method="post" name="form1" id="form1">
      
      <table width="100%" border="0" align="center" cellpadding=4 cellspacing=0>
        <tr>
          <td align="left" valign="top" class="check_items"><table width="100%" border="0" align="center" cellpadding=2 cellspacing=0>
             
              <tr>
                <td width="22%" height="" align="right">电话号码：<br><span class="gray">最大支持1000个</span></td>
                <td align="left" valign="middle"><textarea name="phone_number" id="phone_number" cols="50" rows="5" style="height:160px" onchange="get_phone_count()" title="点击填写要查询的电话号码，单次查询最大支持1000个！"></textarea>
                  <span class="red">※</span> <span id="phone_counts" style="color: #CC1B1B;font-family:Arial, Helvetica, sans-serif;font-size: 16px;">0</span> 行</td>
              </tr>  
            </table>
			</td>
        </tr>
      </table>
    </form>
  </fieldset>
</div>
<?php 

break;

//获取导出字段列表 
case "get_lists_field":
 
$def_list_lead_arr=array(
 
	array("l_id"=>"a.phone_number","l_n"=>"电话号码","l_o"=>"T","l_s"=>"Y"),
 	array("l_id"=>"a.user","l_n"=>"工号","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"b.full_name","l_n"=>"工号姓名","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"a.call_date","l_n"=>"开始时间","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"TIMESTAMPADD(SECOND,ifnull(a.talk_length_sec,0),a.call_date)","l_n"=>"结束时间","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"IFNULL(a.length_in_sec,0)","l_n"=>"呼叫时长","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"IFNULL(a.talk_length_sec,0)","l_n"=>"通话时长","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"h.campaign_name","l_n"=>"业务活动","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"case when a.comments='auto' then '自动' else '手动' end","l_n"=>"呼叫方式","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"e.status_name","l_n"=>"呼叫结果","l_o"=>"T","l_s"=>"N"),
	array("l_id"=>"a.call_des","l_n"=>"呼叫描述","l_o"=>"T","l_s"=>"N"),  
  
	array("l_id"=>"c.title","l_n"=>"标题","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.first_name","l_n"=>"名字","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.middle_initial","l_n"=>"中间名","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.last_name","l_n"=>"姓氏","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.address1","l_n"=>"地址1","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.address2","l_n"=>"地址2","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.address3","l_n"=>"地址3","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.province","l_n"=>"省份","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.city","l_n"=>"城市","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.phone_code","l_n"=>"区号","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.state","l_n"=>"地区","l_o"=>"X","l_s"=>"N"),
 	array("l_id"=>"c.postal_code","l_n"=>"邮编","l_o"=>"X","l_s"=>"N"),
 	array("l_id"=>"c.gender","l_n"=>"性别","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.date_of_birth","l_n"=>"生日","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.alt_phone","l_n"=>"备用电话","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.email","l_n"=>"邮箱","l_o"=>"X","l_s"=>"X"),
 	array("l_id"=>"c.vendor_lead_code","l_n"=>"代理商ID","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.security_phrase","l_n"=>"安全密码","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.comments","l_n"=>"客户备注","l_o"=>"X","l_s"=>"N"),
	array("l_id"=>"c.owner","l_n"=>"归属工号","l_o"=>"X","l_s"=>"N"),
 
	array("l_id"=>"g.status_name","l_n"=>"质检结果","l_o"=>"E","l_s"=>"N"),
	array("l_id"=>"f.userid","l_n"=>"质检人","l_o"=>"E","l_s"=>"N"),
	array("l_id"=>"f.addtime","l_n"=>"质检时间","l_o"=>"E","l_s"=>"N"),
	array("l_id"=>"f.qualitydes","l_n"=>"质检描述","l_o"=>"E","l_s"=>"N"),
	array("l_id"=>$record_location,"l_n"=>"录音地址","l_o"=>"E","l_s"=>"N"),
	array("l_id"=>"a.status","l_n"=>"结果状态码","l_o"=>"E","l_s"=>"N"),
	array("l_id"=>"i.dtmf_key","l_n"=>"DTMF记录","l_o"=>"E","l_s"=>"N")
);
?>
<script> 
function do_set_export_list_(){
 	var field_list="";
	//var callstatus_name="";
	$('#form1 input[name="field"]:checked').each(function(i){
		 var list_s=$(this).val();
		 //var list_s=val_ary[1];
		 field_list+=list_s+",";
 		 
   	}); 
 	if (field_list!=""){field_list=field_list.substr(0,field_list.length-1)}else{field_list="a.phone_number as `电话号码`"}
	
 	$(_DialogInstance.ParentWindow.document).find("#field_list").val(field_list);
 	_DialogInstance.ParentWindow.check_form('excel_field');
	 
	setTimeout("Dialog.close();",10);
}

var def_list_lead_arr=<?php echo  json_encode($def_list_lead_arr);?>;
  
var lists_sub="",fs_sub="",json_field_list,c_fid; 
function change_field_list(libs_id){
	//console.log("=="+libs_id);
	lists_sub="";
	////console.log(libs_id);
	c_fid=0;
	$("#tree_data_list li").remove();
	var def_field_t="",def_field_e="";
	if((libs_id=="def"||libs_id=="")&&libs_id!=0){
		//console.log("1111"+libs_id);
		$.each(def_list_lead_arr, function(index,con){
			checked="";
			c_blue="";
			//l_id=con.l_id.replace(".","_");
			c_fid++;
			l_id="f_c_"+c_fid;
			if(con.l_s=="Y"){
				checked=' checked="checked" ';
				c_blue=' class="blue" ';
			}
			f_sub='{"f_n":"'+con.l_n+'","f_i":"'+l_id+'"},';
			lists_sub+=f_sub;
			list_str='<li title="'+con.l_n+'"><span'+c_blue+'><input type="checkbox" parentid="lists_all" id="lists_item_'+l_id+'" name="field" value="'+con.l_id+' as `'+con.l_n+'`" '+checked+'><label for="lists_item_'+l_id+'">'+con.l_n+'</label></span></li>';
			$("#tree_data_list").append(list_str);
		}); 
			
	}else{
		//console.log("2222"+libs_id);
		$.each(def_list_lead_arr, function(index,con){
			l_id=con.l_id.replace(".","_");
			c_fid++;
			l_cid="f_c_"+c_fid;
			if(con.l_o=="T"||con.l_o=="E"){
				//if(l_id!="a_phone_number"){
					checked="";
					c_blue="";
					
					if(con.l_s=="Y"){
						checked=' checked="checked" ';
						c_blue=' class="blue" ';
					}
					f_sub='{"f_n":"'+con.l_n+'","f_i":"'+l_cid+'"},';
					lists_sub+=f_sub;
					if(con.l_o=="T"){
						def_field_t+='<li title="'+con.l_n+'"><span'+c_blue+'><input type="checkbox" parentid="lists_all" id="lists_item_'+l_cid+'" name="field" value="'+con.l_id+' as `'+con.l_n+'`" '+checked+'><label for="lists_item_'+l_cid+'">'+con.l_n+'</label></span></li>';
					}else{
						def_field_e+='<li title="'+con.l_n+'"><span'+c_blue+'><input type="checkbox" parentid="lists_all" id="lists_item_'+l_cid+'" name="field" value="'+con.l_id+' as `'+con.l_n+'`" '+checked+'><label for="lists_item_'+l_cid+'">'+con.l_n+'</label></span></li>';
					}
				//}
			}
		}); 
		if(def_field_t!=""){
			$("#tree_data_list").append(def_field_t);
		}
		//console.log("--"+libs_id);
		if(libs_id==null||libs_id==""){libs_id="0";}
		$.each(json_field_list.datalist[libs_id].o_c_list, function(ci,c_con){
			
			//console.log(libs_id+"--"+c_con.f_id);
			var f_id="",f_sub="";
			
			f_id=c_con.f_id.replace(".","_");
			f_name=c_con.f_name;
			f_tit=f_name;
			tab_prex="";
			c_fid++;
			l_cid="f_c_"+c_fid;
			
			if(f_id!="call_des"&& f_id!="phone_number"){
				f_sub='{"f_n":"'+f_name+'","f_i":"'+l_cid+'"},';
				lists_sub+=f_sub;
				
				if(f_id.substr(0,6)=="custom"){
					tab_prex="j.";
				}else{
					tab_prex="c.";	
				}
				
				list_str='<li title="'+f_tit+'"><span><input type="checkbox" parentid="lists_all" id="lists_item_'+l_cid+'" name="field" value="'+tab_prex+f_id+' as `'+f_name+'`"><label for="lists_item_'+l_cid+'">'+f_tit+'</label></span></li>';
				 
				$("#tree_data_list").append(list_str);
			}
			
		});
		
		if(def_field_e!=""){
			$("#tree_data_list").append(def_field_e);
		}
	} 
	
	if(lists_sub!=""){
		lists_sub=lists_sub.substr(0,lists_sub.length-1);
		lists_ary='{"lists":['+lists_sub+']};';
		////console.log(lists_ary);
		json_list=str2json(lists_ary);
		
		$("#text_search").autocomplete(json_list.lists, {
			minChars: 0,
			max: 16,
			width: 270,
			matchContains: true,
			highlightItem: false,
			formatItem: function(row, i, max, term) {
				r_lid=row.f_i;
				r_ln=row.f_n;
				
				return "<span title='"+r_ln+"'>"+r_ln+"</span>";
			},
			formatResult: function(row){
				return row.f_n;
			} 
		}).result(function(event,data,formatted){ 
			$("#lists_item_"+data.f_i).attr("checked",true).parent().addClass("blue");
 			request_tip("已选择数据字段：<span class='font_w'>"+formatted+"</span>",1); 
			goto_anchor_autocm("lists_item_"+data.f_i); 
		});
	} 
	
	$("#tree_data_list input[type=checkbox]").click(function(){if(this.checked==true){$(this).parent().addClass("blue")}else{$(this).parent().removeClass("blue")}});

} 

function get_cam_libs_list(){
	$('#load').show();
	var cam_id=$.trim($("#campaign_id").val());
 	var url="action=get_cam_libs_list"+times;
	opt_select="";
 	$.ajax({
		url: "../lists/send.php",
		data:url,
	 
		beforeSend:function(){$('#load').css("top",$(document).scrollTop()).show('100');},
		complete :function(){$('#load').hide('100');},
		success: function(json){ 
			var c_id="",cid_index="";
			if(parseInt(json.counts)>0){
				
				json_field_list=json;
				
 				$.each(json.datalist, function(index,con){
					var libs_id=con.libs_id,libs_name=con.libs_name,opt_str="";
					opt_select="";
					c_id=con.c_id;
					//index=index+1;
					if(c_id!=null&&c_id!=""){
						var c_id_ary=c_id.split(","); 
						for(var i=0;i<c_id_ary.length;i++){ 
						   if(cam_id==c_id_ary[i]){
							   //console.log(cam_id+"--"+c_id_ary[i]);
							   opt_select=" selected='selected'";
							   cid_index=index;
							   break;
						   }
						}
					}
					opt_str="<option value='"+index+"' title='"+libs_name+"' "+opt_select+">"+libs_name+"</option>";  
					$("#libs_id").append(opt_str); 
				});
  			} 
			//console.log(cid_index);
			if(opt_select==""){cid_index="def";$("#libs_id").val("def");}
			change_field_list(""+cid_index+"");
 		} 
	});	
}
 

$(document).ready(function() {
 	var td_width=$("#text_search_layer").width();
 	$("#text_search_layer").css({"width":td_width+"px"}).scrollFollow({
		marginTop:0,
		marginRight:4,
		zindex:150
	}); 
	$('.td_underline tr[class!=dataHead]:visible:odd').addClass('alt'); 

	$("#libs_id").on("change",function(){
		change_field_list($(this).val());
	});
	get_cam_libs_list();
});

</script>
<style>
.result_list{width:100%}
.result_list li{float:left; width:60%}
</style>

<div id="load" class="load_layer"><img src="/images/loading.gif"align="absmiddle"/>数据加载中...</div>
<div class="page_nav">
  <div class="nav_ico"><img src="/images/page_nav_ico.jpg" /></div>
  <div class="nav_">当前位置：<a href="javascript:void(0);">客户清单管理</a> &gt; <?php echo $tits ?> </div>
  <div class="nav_other"><a href="javascript:void(0);" onclick="javascript:window.location.reload();"><img src="/images/page_reload.jpg" alt="刷新本页"/></a></div>
</div>
<div class="page_main">
  <input name="campaign_id" type="hidden" id="campaign_id" value="<?php echo $campaign_id ?>" />
  <input name="get_campaign" type="hidden" id="get_campaign" value="0" />
  <fieldset>
    <legend>
    <label for="quality_status_all"><?php echo $tits ?> </label>
    </legend>
    <div id="text_search_layer">
      <input name="text_search" type="text" class="input_text" id="text_search" title="请输入" size="36" maxlength="16" />
      <input name="do_text_search" id="do_text_search" type="button" value="查询" onclick="text_search()" />
    </div>
    <form action="" method="post" name="form1" id="form1">
      <input name="lead_filter_id" type="hidden" id="lead_filter_id" value="<?php echo $lead_filter_id ?>" />
      <table width="100%" border="0" align="center" cellpadding=2 cellspacing=0  class="td_underline">
        <tr >
          <td width="22%" height="24" align="right">选择自定义方案：</td>
          <td height="24"><select name="libs_id" id="libs_id" class="s_option" >
              <option value='def'>使用系统默认字段方案</option>
            </select>
            <span class="red">※</span></td>
        </tr>
        <tr>
          <td  width="22%" align="right">导出字段：<br /><span><label for="lists">全选</label><input type="checkbox" id="lists" name="" parentid="lists_" value="" onclick="CheckItemsAll('form1','lists')" /></span></td>
          <td align="left" valign="middle"><ul class="check_items"  id="tree_data_list">
            </ul></td>
        </tr>
      </table>
    </form>
  </fieldset>
</div>
<?php 
break;
 
default :

	echo "action:error";
	
}
mysqli_close($db_conn);
?>
</body>
</html>

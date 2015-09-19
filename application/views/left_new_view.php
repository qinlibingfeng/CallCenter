
<HTML xmlns="http://www.w3.org/1999/xHTML" style="overflow-x:hidden">
<head>
<meta http-equiv="Content-Type" content="text/HTML;charset=utf-8"/> 
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
<base href="<?php echo base_url()?>www/"/>
<link href="css/left.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="lib/jquery.js"></script>

<script language="javascript"> 
function nav(title,url){
	window.parent.frames['mainFrame'].iAddTab(title,url);
}
  
function showDivMenu(id){var e=document.getElementById(id);if(e.style.display=="block"||e.style.display==""){e.style.display="none"}else{e.style.display="block"}};

function showFoldClass(id){if($("#"+id).attr("title")=="开启"){$("#"+id).removeClass("opnFd");$("#"+id).addClass("clsFd");$("#"+id).attr("title","折叠")}else{$("#"+id).removeClass("clsFd");$("#"+id).addClass("opnFd");$("#"+id).attr("title","开启")}};

function showDiv(id,isShow){var e=document.getElementById(id);if(!isShow){e.style.display="none"}else{e.style.display="block"}}; 
  
function addClassName(id,cl){$("#"+id).addClass("on")};
 
function removeClassName(id,cl){$("#"+id).removeClass("on")};
/*
 var times='&times='+new Date().getTime()+'&round='+Math.random();function get_datalist(){$("#Menu_List .gFd").remove();$('#load').show();var datas="action=get_menu_list&do_actions=list"+times;$.ajax({type:"post",dataType:"json",url:"/document/data_detail/send.php",data:datas,cache:false,async:false,beforeSend:function(){$('#load').css("top",$(document).scrollTop());$('#load').show('100')},complete:function(){$('#load').hide('100')},success:function(json){if(parseInt(json.counts)>0){$.each(json.datalist,function(index,con){tr_str="",lists="";tr_str="<div class=\"gFd\">";tr_str+="<h3 class=\"gfTit\" onClick=\"javascript:showDivMenu('study_"+con.PopeID+"');showFoldClass('fold"+con.PopeID+"');\">";tr_str+="		<a href=\"javascript:void(0);\" id=\"fold"+con.PopeID+"\" rel=\"fold\" class=\"opnFd bgF1\" title=\"开启\" hidefocus=\"true\"></a>";tr_str+="<a href=\"javascript:void(0);\" class=\"gfName\" hidefocus=\"true\">"+con.PopeName+"</a></h3>";tr_str+="<ul class=\"gFdBdy\" id=\"study_"+con.PopeID+"\"  style=\"display:none\">";$.each(con.pope_list,function(det,cons){lists+="<li onMouseOver=\"addClassName('li_"+cons.PopeID_List+"','on');\" id=\"li_"+cons.PopeID_List+"\" onMouseOut=\"removeClassName('li_"+cons.PopeID_List+"','on');\" title=\""+cons.IcoInfo_List+"\" rel=\"o_list\"><b class=\"icon "+cons.IcoClass_List+"\"></b><a href=\"javascript:void(0)\" hidefocus=\"true\" onclick=\"addTab('"+cons.PopeName_List+"','"+cons.PopeLink_List+"','"+cons.PopeID_List+"','"+cons.is_re+"')\" class=\"gfNm\">"+cons.PopeName_List+"</a></li>"});tr_str+=lists;tr_str+="	</ul>";tr_str+="</div>";$("#Menu_List").append(tr_str)})}else{}},error:function(XMLHttpRequest,textStatus){alert("页面请求错误，请联系系统管理员！\n"+textStatus)}})};
 */
function addTab(tit,url,tab,is_re){window.parent.window.frames["Main"].addTab(tit,url,tab,is_re)};
 
$(document).ready(function(){
//get_datalist();
//$("#study_2,#study_6,#study_5").css("display", "block");
$("a[rel=fold]").removeClass("opnFd").addClass("clsFd").attr("title", "折叠");
$("#set_a_line_area").toggle(function() {
    $(".gFdBdy").css("display", "none");
    $("a[rel=fold]").removeClass("clsFd").addClass("opnFd").attr("title", "开启")
},
function() {
    $(".gFdBdy").css("display", "block");
    $("a[rel=fold]").removeClass("opnFd").addClass("clsFd").attr("title", "折叠")
});
 	
});
  
</script>

</head>
 
<body class="gb" style="overflow-x:hidden" oncontextmenu='return false' ondragstart='return false'> 
 
 <div id="divLeftMenu" class="gMain">
  <div class="gLe" id="Menu_List">
    <div class="gMbtn" id="set_a_line_area"></div>
    <?php foreach ($items as $item){?> 
		<div class=gFd>
    	<h3 class="gfTit" onClick="javascript:showDivMenu('study_<?php echo $item["item_id"]?>');showFoldClass('fold');">
        	<a href="javascript:void(0);" id="fold" rel="fold" class="opnFd bgF1" title="开启" hidefocus="true"></a>
            <a href="javascript:void(0);" class="gfName" hidefocus="true"><?php echo $item["item_text"];?></a>
        </h3>
       
  		      <ul class="gFdBdy" id="study_<?php echo $item["item_id"]?>"  style="display:none">
               <?php foreach($item["sub_items"] as $sub_item){?>
            <li onMouseOver="addClassName('li_<?php echo $sub_item["item_id"] ?>','on');" id="li_<?php echo $sub_item["item_id"] ?>" onMouseOut="removeClassName('li_<?php echo $sub_item["item_id"] ?>','on');" title="" rel="o_list">
            <b class="icon <?php echo $sub_item["item_logo"];?>"></b><a href="javascript:void(0)" hidefocus="true" onClick="nav('<?php echo $sub_item["item_text"]?>','<?php echo $sub_item["item_url"]?>')" class="gfNm"><?php echo $sub_item["item_text"];?></a>
            </li>
             <?php } ?>
        </ul>
      
    </div>
    <?php } ?>
  </div>
</div> 
 
</body>
</html>


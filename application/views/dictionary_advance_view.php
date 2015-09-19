<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />


<script src="lib/jquery.js"              	  type="text/javascript"></script>
<script src="js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="js/Public.js"                    type="text/javascript"></script>
<script src="lib/jquery.jgrowl.js"             type="text/javascript"></script>
<script src="js/work.js"  type="text/javascript"></script>
<script>

function onAddBtClick(type){
	if($('#'+type+"Panel").css('display') == 'none')
		$('#'+type+"Panel").css('display','block');
	else
		$('#'+type+"Panel").css('display','none');
}

function onSaveBtClick(type){
	$('#'+type+"Panel").css('display','none');
	var req={'text':'',pid:0};
	if(type == "firstBt"){
		req.pid=$('#smainBt').val();
	}else if(type == "secondBt"){
		req.pid=$('#sfirstBt').val();
	}else if(type == "thirdBt"){
		req.pid=$('#ssecondBt').val();
	}
	
	req.text=$('#'+type+"Data").attr('value');
	$.post("<?php echo site_url('dictionary/ajaxTreeSave')?>",req,function(){
		if(type == "mainBt"){
		createSelect('#smainBt','0',"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	}else if(type == "firstBt"){
		createSelect('#sfirstBt',$('#smainBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	}else if(type == "secondBt"){
		createSelect('#ssecondBt',$('#sfirstBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	}else if(type == "thirdBt"){
		createSelect('#sthirdBt',$('#ssecondBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");	
		}
	});
	
	
}

function onDelBtClick(type){
	var req={'id':-1};
	req.id=$('#s'+type).val();
	$.post("<?php echo site_url('dictionary/ajaxTreeDel')?>",req,function(){
		
		if(type == "mainBt"){
			createSelect('#smainBt','0',"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
		}else if(type == "firstBt"){
			createSelect('#sfirstBt',$('#smainBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
		}else if(type == "secondBt"){
			createSelect('#ssecondBt',$('#sfirstBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
		}else if(type == "thirdBt"){
			createSelect('#sthirdBt',$('#sthirdBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");	
		}	
	});
	
	
}	
$(document).ready(function(){
	createSelect('#smainBt','0',"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	createSelect('#sfirstBt','-1',"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	createSelect('#ssecondBt','-1',"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	createSelect('#sthirdBt','-1',"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	
	$('#smainBt').change(function(){
		createSelect('#sfirstBt',$('#smainBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
		createSelect('#ssecondBt',$('#sfirstBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
		createSelect('#sthirdBt',$('#ssecondBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	});
	
	$('#sfirstBt').change(function(){
		createSelect('#ssecondBt',$('#sfirstBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
		createSelect('#sthirdBt',$('#ssecondBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	});
	
	$('#ssecondBt').change(function(){
		createSelect('#sthirdBt',$('#ssecondBt').val(),"<?php echo site_url('dictionary/ajaxTreeGetKeyValue')?>");
	});
});
</script>
</head>
<body>
<div class="page_main page_tops">
	 <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 查看字典</div>
         <div class="nav_other"></div>
	</div>
	<div class="layout-middle">
			
	</div>	
<div style="margin-top:10px">
	  <table><tr>
             	<td> <select id="smainBt" style="width:100px"></select></td><td><a href="javascript:onAddBtClick('mainBt')"><img src="images/infoadd.gif"/></a></td><td><a href="javascript:onDelBtClick('mainBt')"><img src="images/infodel.bmp"/></a></td><td><span id="mainBtPanel" style="display:none" class="toolPanel"><input id='mainBtData' type="text"/><a href="javascript:onSaveBtClick('mainBt')"><img src="images/infosave.bmp"/></a></span></td></tr></table>
</div>
<br />
        <br />
		<center>
        	<table>
            	<tr><td width="32">首项</td><td width="215"><select id="sfirstBt" style="width:100%"></select></td>
            	<td><a href="javascript:onAddBtClick('firstBt')"><img class="btnAdd" src="images/infoadd.gif"/></a></td><td><a href="javascript:onDelBtClick('firstBt')"><img src="images/infodel.bmp" /></a></td><td><div  id="firstBtPanel" style="display:none" class="toolPanel"><input id="firstBtData" type="text" /><a href="javascript:onSaveBtClick('firstBt')"><img src="images/infosave.bmp"/></a></div></td></tr>
                <tr style="height:5px"><td colspan="4"></td></tr>
                <tr>
                <td>次项</td><td><select id="ssecondBt" style="width:100%"></select></td><td><a href="javascript:onAddBtClick('secondBt')"><img class="btnAdd" src="images/infoadd.gif"/></a></td><td><a href="javascript:onDelBtClick('secondBt')"><img src="images/infodel.bmp" /></a></td><td><div id="secondBtPanel" style="display:none"class="toolPanel"><input id="secondBtData" type="text" /><a href="javascript:onSaveBtClick('secondBt')"><img src="images/infosave.bmp"/></a></div></td></tr>
                <tr style="height:5px"><td colspan="4"></td></tr>
                <tr><td>尾项</td><td><select id="sthirdBt" style="width:100%"></select></td><td><a href="javascript:onAddBtClick('thirdBt')"><img class="btnAdd" src="images/infoadd.gif"/></a></td><td><a href="javascript:onDelBtClick('thirdBt')"><img src="images/infodel.bmp"/></a></td><td><div id="thirdBtPanel" style="display:none" class="toolPanel"><input id="thirdBtData" type="text"/><a href="javascript:onSaveBtClick('thirdBt')"><img src="images/infosave.bmp"/></a></div></td></tr>
            </table> 	      	
  </center>
</div>		
</body>
</html>
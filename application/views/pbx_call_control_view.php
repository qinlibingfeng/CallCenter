<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>
<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
<link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" media="screen" />
<link rel='stylesheet' type='text/css' href='www/lib/jquery/ui/themes/base/jquery.ui.all.css' />

<style type="text/css" title="currentStyle">
			@import "www/lib/dataTable/css/demo_page.css";
			@import "www/lib/dataTable/css/demo_table.css";
</style>
      
<script type="text/javascript" src="www/js/jquery-1.6.4.js"></script>

<script type="text/javascript" src="uploadifyV3.2/jquery.uploadify.js"></script>
<script type='text/javascript' src='www/lib/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type='text/javascript' src='www/lib/dataTable/js/jquery.dataTables.js'></script>

<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
   
   function updateTranferShow(){
	 $.post("<?php echo site_url('pbx/ajaxGetPbxAttr')?>",[],function(ret){
   		if(ret[0].pbx_is_transfer == "0"){
		 	$('#btZhiban').css('display','none');
		 	$('#btZuoxi').css('display','block');
	 	}else{
		 	$('#btZuoxi').css('display','none');
		 	 $('#btZhiban').css('display','block');
		 }
	 });
	 
	 $.post("<?php echo site_url('pbx/ajaxGetPbxAttr')?>",[],function(ret){
	  	$('#zhibanPhone').attr('value',ret[0].pbx_transfer_phone);
	  });
   }
  
	
	 updateTranferShow();
	 
	 
	 	
	 
	 $('#btZhiban').click(function(){
		$.post("<?php echo site_url('pbx/ajaxSetPbxTransferAttr')?>",{pbx_is_transfer:'0'},function(){
				
		});
		updateTranferShow();
	  });
	  
	   $('#btZuoxi').click(function(){
		  $.post("<?php echo site_url('pbx/ajaxSetPbxTransferAttr')?>",{pbx_is_transfer:'1'},function(){
			 
		  });
		 updateTranferShow();
	  });
	  $('#btSetZhibanPhone').click(function(){
		 var req={pbx_transfer_phone:''};
		 req.pbx_transfer_phone=$('#zhibanPhone').attr('value');
	 	 $.post("<?php echo site_url('pbx/ajaxSetPbxTransferPhoneAttr')?>",req,function(ret){
	  	 	alert("设置成功");
		 });
		 updateTranferShow();	
	  }); 
  $file='';
  $rules="0"; 
});
// ]]>
</script>
</head>
<body>
<div class='page_main page_tops'>
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 导入客户</div>
         <div class="nav_other"></div>
		</div>
        <div class="layout-middle"></div>
        	<input style="margin-top:1px;width:120px;height:30px" id="btZhiban"  type="button" value="值班模式" />
			<input style="margin-top:1px;width:120px;height:30px" id="btZuoxi" type="button" value="坐席模式" />
            <input style="margin-top:1px;width:120px;height:30px" id="zhibanPhone" type="text" value="" />
			<input style="margin-top:1px;width:120px;height:30px" id="btSetZhibanPhone" type="button" value="设置值班电话" />
	   	</div>
    
</div>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
	<base href="<?php echo $this->config->item('base_url') ?>/"/>
	<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="www/css/zTree.css" type="text/css">
	<link rel="stylesheet" href="www/css/ztree/zTreeStyle/zTreeStyle.css" type="text/css">
    <link rel='stylesheet' href='www/lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css' media="screen"/>
	<style>
    	.dui-control{
			width:160px;
		}
		.person-info{
			font-size:14px;
			color:#0088DD;
		}
		.panelOne{
			margin-left:10px;
			margin-right:10px;
		}
    </style> 
<style type="text/css" title="currentStyle">
			@import "www/lib/dataTable/css/demo_page.css";
			@import "www/lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
</style>
	<script type="text/javascript" src="www/lib/jquery-1.6.4.js"></script>
    <script type="text/javascript" src="www/lib/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="www/lib/jquery.ztree.core-3.0.min.js"></script>
    <script type="text/javascript" src="www/js/multi-select.js"></script>
    <script type="text/javascript" src="www/js/work.js"></script>
    <script type="text/javascript" src="www/js/call.js"></script>
    <script type="text/javascript" src="www/lib/jgrowl/jquery.jgrowl.js"></script>
    <script type='text/javascript' src='www/lib/jquery.timers.js'></script>
    <script type='text/javascript' src='www/lib/jquery/jquery-ui-1.8.16.custom.js'></script>
    <script type="text/javascript" src="www/lib/dataTable/js/jquery.dataTables.js"  ></script>
    <script type="text/javascript" src="www/lib/myDynamicUI/dynamicUI.js" ></script>  
    <script>	
	
		$(document).ready(function(){
				
			setDatePickerLanguageCn();					
			$('#orderId').attr('value','<?php echo $orderId;?>');
		
			//$('#bussniessInfoTable').dynamicui(<?php //echo json_encode($bussniessInfo);?>);
			
	});
    </script>
 
</head>
<body>
<input id="orderId"  type="hidden" value="">

<div id="yuyue-dialog"  style="display:none">
	预约内容:<input id="yuyue-content" type="text" style="width:180px" value="" />
    <br>
	预约时间:<input id='yuyue-ymd' type="text" style="width:90px" value="<?php echo $yuyue['ymh']?>">&nbsp;<?php echo form_dropdown('s_hour',$yuyue['hourOptions'],$yuyue['hourDef'],'id="yuyue-hour"')?>&nbsp;<?php echo form_dropdown('s_min',$yuyue['minOptions'],$yuyue['minDef'],'id="yuyue-min"')?>
</div>
<div id="createWorkOrder-dialog"  style="display:none">
	&nbsp;&nbsp;&nbsp;接收人:<input id="workOrder-reciever" type="text" style="width:180px" value="" />
    <br>
	截止时间:<input id='workOrder-ymd' type="text" style="width:90px" value="<?php echo $yuyue['ymh']?>">&nbsp;<?php echo form_dropdown('s_hour',$yuyue['hourOptions'],$yuyue['hourDef'],'id="workOrder-hour"')?>&nbsp;<?php echo form_dropdown('s_min',$yuyue['minOptions'],$yuyue['minDef'],'id="workOrder-min"')?>
</div>
<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 正在沟通</div>
         <div class="nav_other"></div>
        
	</div>		
     <div class="func-panel">
                    <div class='left'>&nbsp;&nbsp;&nbsp;基本信息</div>
                    <div class="right" align="right">
                    <input id="btnCreatWorkOrder" type="button" value="生成工单">&nbsp
                    <input id="nextClient" type="button" value="下一个">&nbsp 
                    <input id="btnSave" type="button" value="保存">&nbsp;
                    <input id="btnYuyue" type="button" value="预约">&nbsp;
                    <input id="btnBack" type="button" value="返回"></div>            
                   <div style="clear:both"></div>						
    </div> 
    
	<div class='work-list'>			 
            <div id="bussniessInfo" class='panelOne'>       
				<table id="bussniessInfoTable" width="100%">
                 <tbody></tbody>
                </table>
               	
			</div>
         
	</div>
</div>
    
  
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>

<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
<link rel='stylesheet' href='www/lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css' media="screen"/>

<script type="text/javascript" src="www/lib/jquery-1.5.2.min.js"></script>
<script src="www/lib/dataTable/js/jquery.dataTables.js"  type="text/javascript"></script>
<script src="www/js/work.js"  type="text/javascript"></script>
<script type='text/javascript' src='www/lib/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type='text/javascript' src='www/lib/extenal.js'></script>
<script type='text/javascript' src='www/js/work.js'></script>
<script type="text/javascript" src="www/lib/myDynamicUI/dynamicUI.js" ></script>

<style type="text/css" title="currentStyle">
			@import "www/lib/dataTable/css/demo_page.css";
			@import "www/lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
	
</style>

<script>
function onCallClick(name,url){	
	//window.parent.iAddTab('外呼',url);
	location.href=url;	
}
//招生状态赋值
function getDateString(ymd, hour, minut){
	return ymd+" "+hour+":"+minut+":00";
}
function getSearchString(){	
		var searchStr=Array();	
		var timeSearch=Array();
		timeSearch[0]="and";
		timeSearch[1]="datetime";
		timeSearch[2]="link_stime";
		timeSearch[3]=getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val());
		timeSearch[4]=getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val());
		searchStr.push(timeSearch);
		return JSON.stringify(searchStr);
}
$(document).ready(function(){
	setDatePickerLanguageCn();
	$("#start_ymd").datepicker(); 
	$("#end_ymd").datepicker();   

});
</script>    
</head>
<body>

<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 自定义报表</div>
         <div class="nav_other"></div>
	</div>
    <div class="func-panel">
			 <div class="left">
			 	<input type="button" id="btnSearch" value="搜索" class="btnSearch"/>
                <input type="button" id="btnExport" value="导出" class="btnSearch"/>
                从
                <input type="text" name="start_ymd"   id="start_ymd" value="" style="width:80px"/>
				
                <input type="text" name="end_ymd"   id="end_ymd" value="" style="width:80px"/>
  <?php echo form_dropdown('e_hour',$endTime['hourOptions'],$endTime['hourDef'],'id="e_hour"')?><?php echo form_dropdown('e_min',$endTime['minOptions'],$endTime['minDef'],'id="e_min"')?>
                
                <a id="csvUrl" href='export_datas/clients_09Apr12.csv'></a>
			 </div>
			 <div align='right' class="right">
			
			 </div>		
			 <div style="clear:both;"></div>  
	</div>	
   <div id="searchPanel" style="margin-top:5px;margin-bottom:5px">
		<table  id="searchPanelTable" width="100%">
        <tbody></tbody>	
		</table>	
   </div>
   <div id="example" style='display:block'>
          <table width="100%" cellpadding="0" cellspacing="0" border="0"  id="dataList" >
          		<thead>     	
                    <th align="left">坐席工号</th><th align="left">日期</th><th align="left">呼出接通</th><th align="left">呼出未接通</th><th align="left">呼出总计</th><th align="left">呼入接通</th><th align="left">呼入未接通</th><th align="left">呼入总计</th>
            </thead>
          </table>
      </div>
</div>
</body>
</html>
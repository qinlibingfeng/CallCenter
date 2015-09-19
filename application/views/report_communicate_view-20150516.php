<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>

<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
<link rel='stylesheet' href='www/lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css'/>

<script type="text/javascript" src="www/lib/jquery.js"></script>
<script type="text/javascript" src="www/lib/dataTable/js/jquery.dataTables.js"  ></script>
<script src="www/js/work.js"  type="text/javascript"></script>
<script type='text/javascript' src='www/lib/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type='text/javascript' src='www/lib/extenal.js'></script>
<script type='text/javascript' src='www/js/call.js'></script>
<script type='text/javascript' src='www/lib/json2.js'></script>
<style type="text/css" title="currentStyle">
			@import "www/lib/dataTable/css/demo_page.css";
			@import "www/lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
</style>

<script>
$(document).ready(function() {
	$('#agentId').attr('value','<?php echo $agentId?>');
	
	setDatePickerLanguageCn();
	$("#start_ymd").datepicker(); 
	$("#end_ymd").datepicker();  
	//招生状态赋值
	function getDateString(ymd, hour, minut){
	 	return ymd+" "+hour+":"+minut+":00";
	}	 
	
	$("#start_ymd").datepicker(); 
	$("#end_ymd").datepicker(); 
	
	var ctime=new Date();
	$("#start_ymd").attr('value', ctime.format('yyyy-MM-dd'));	
	$("#end_ymd").attr('value', ctime.format('yyyy-MM-dd'));	  
	var gTargetAgents=<?php echo json_encode($targetAgents);?>;
	$.each(gTargetAgents,function(index,row){
		if(row.name_text != '未填写')
			$('#targetAgent').append("<option value='"+row.name_value+"'>"+row.name_text+"</option>");
		else
			$('#targetAgent').append("<option selected='selected' value='"+row.name_value+"'>"+row.name_text+"</option>");
		
	});
	function getSearchString(){		
		$seachValue=$('#searchText').attr('value');			
		var searchStr=[];
		var timeSearch=[];
		timeSearch.push("and");
		timeSearch.push("datetime");
		timeSearch.push("link_stime");
			
		timeSearch.push(getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val()));
		timeSearch.push(getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val()));
		filterString={"searchType":0,"agentId":"","searchText":""};
		
		timeSearch.push(getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val()));
		timeSearch.push(getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val()));
		filterString={"searchType":1,"agentId":"","searchText":""};
		filterString.agentId=$("#agentId").attr("value");
		
		var phoneNumberSearch=["likeand","varchar","phone_number",""];	
		phoneNumberSearch[3]=$("#phoneNumberText").attr("value");
		var callTypeSearch=["and","varchar","call_type",""];
		if($("#callType").val() != "-1")
			callTypeSearch[3]=$("#callType").val();
			
		if($("#callStatus").val() != "ALL"){
			if($("#callStatus").val() === "CONNECTED")
				searchStr.push(["and","varchar","status","CONNECTED"]);
			else
				searchStr.push(["nand","varchar","status","CONNECTED"]);
		}
		
		if($("#targetAgent").val() != "全部" && $("#targetAgent").val() != "未填写"){
			var agentSearch=["and","varchar","agent",""];
			agentSearch[3]=$("#targetAgent").val();
			searchStr.push(agentSearch);
		}
		searchStr.push(callTypeSearch);
		searchStr.push(phoneNumberSearch);
		searchStr.push(timeSearch);
		filterString.searchText=searchStr;
		return JSON.stringify(filterString);
	}
	
	createTables=function (filterString){
		
		$('#dataList').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers 
			  if(aData[4] == "callin")
			  	$('td:eq(4)', nRow).html('呼入');
			  else
			  	$('td:eq(4)', nRow).html('呼出');
				
			  if(aData[5] == 'CONNECTED')
			  	$('td:eq(5)', nRow).html('接通');
			  else 
			  	$('td:eq(5)', nRow).html('未接通');	
			  
			  $('td:eq(10)', nRow).html("<a href='javascript:listenRecord(\""+aData[10]+"\")'>收听</a>&nbsp;<a href='"+aData[10]+"'>下载</a>");
			 
    		},
			"aoColumns": [
				{"bSortable":false,"mDataProp":"0"},
				{"mDataProp":"1"},
				{"mDataProp":"2"},
				{"mDataProp":"3"},
				{"mDataProp":"4"},
				{"mDataProp":"5"},
				{"mDataProp":"6"},
				{"mDataProp":"7"},
				{"mDataProp":"8"},
				{"mDataProp":"9"},
				{"mDataProp":"10"}
			],
			"iDisplayLength": 15,
			"fnServerParams": function (aoData) {
				var externData={ "name": "filterString", "value": "my_value" };
				externData.value=filterString;
				aoData.push(externData);
			},
			"sAjaxSource": "<?php echo site_url('report/ajaxReportCommunicate')?>",
			"oLanguage": {
				"sUrl": "<?php echo $this->config->item('base_url')?>/www/lib/dataTable/de_DE.txt"
			}
			
    	}); 
	}	
	createTables(getSearchString());
	
	$("#btnSearch").click(function(){
		filterString=getSearchString();
		var oTable = $('#dataList').dataTable();
		oTable.fnDestroy();	
		createTables(filterString);	
	});
	
	//高级搜索
	$("#btnAdvance").click(function(){		
		if($("#searchPanel").css("display") == "none")
			$("#searchPanel").css("display","block");
		else
			$("#searchPanel").css("display","none");
	});	
    $('#example tbody tr').live('dblclick', function(){	
		$req={'autoid':-1};
		$req.autoid=this.id;
		$.post('<?php echo site_url("report/ajaxGetOneRecord")?>',$req,function(res){
			$location="";
			$defText="评价";
			if(res[0].location)
				$location=res[0].location;
			else
				$defText="无录音";
			
			$("<div style='width:300px;height:400px'><center><object id='mplayer' classid='clsid:6BF52A52-394A-11D3-B153-00C04F79FAA6' id='phx' style='border:0px solid #F00;width: 200px; height: 45px; margin-bottom:-8px'><param name='URL' value='"+$location+"'/><param name='AutoStart' value='false' /></object> <input type='text' style='margin-top:4px;width:200px;height:44px;' value='"+$defText+"'></center></div>").dialog({
						autoOpen:true,
						modal: true,
						buttons:{
							"确认": function(){
									$(this).dialog('destroy');
							},
							"取消": function(){
								$(this).dialog( "close" );
							}
						},
						close: function(){
							$(this).dialog('destroy');
						}
				});	   
   			 });
		});
		
});
</script>    
</head>
<body>
<div><input type="hidden" value="" id="agentId"></div>
<div class="page_main page_tops" >
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 所有客户</div>
         <div class="nav_other"></div>
	</div>
    <div class="func-panel">
		  <div class="left" width="100%">
          	电话号码：<input type="text" id="phoneNumberText"> 
            呼叫类型: <select id="callType"><option value="-1" selected="selected">全部</option><option value="callout">呼出</option><option value="callin">呼入</option></select> 
            呼叫状态: <select id="callStatus"><option value="ALL" selected="selected" >全部</option><option value="CONNECTED">接通</option><option value="NOCONNECTED">未接通</option></select>  
            
            <input type="button" id="btnSearch" value="搜索" class="btnSearch"/>
            从<input type="text" name="start_ymd"   id="start_ymd" value="" style="width:80px"/>
        	<?php echo form_dropdown('s_hour',$beginTime['hourOptions'],$beginTime['hourDef'],'id="s_hour"')?><?php echo form_dropdown('s_min',$beginTime['minOptions'],$beginTime['minDef'],'id="s_min"')?>到<input type="text" name="end_ymd"   id="end_ymd" value="" style="width:80px"/>
        	<?php echo form_dropdown('e_hour',$endTime['hourOptions'],$endTime['hourDef'],'id="e_hour"')?><?php echo form_dropdown('e_min',$endTime['minOptions'],$endTime['minDef'],'id="e_min"')?>   
			 </div>
              坐席：<select id="targetAgent" name="targetAgent"></select>
			 <div align='right' class="right" ></div>	
			 <div style="clear:both;"></div>  
	</div>	
    <div id="example" style='display:block'>
          <table width="100%" cellpadding="0" cellspacing="0" border="0"  id="dataList" >
          		<thead>

					<tr>
                	  <th align="left" width=auto>坐席工号</th>
                    <th align="left" width=auto>坐席名字</th>
                    <th align="left" width=auto>对方电话</th>
                    <th align="left" width=auto>对方姓名</th>
                    <th	align="left" width=auto>类型</th>    
                    <th	align="left" width=auto>状态</th> 
                    <th align="left" width=auto>开始时间</th>
                    <th align="left" width=auto>通话时长</th>
                    <th align="left" width=auto>排队时长</th>
                    <th width="left" width=auto>400号码</th>
                 	  <th width=auto>录音</th>
                    </tr>      

                	<!--<tr>
                	  <th align="left" width="80px">坐席工号</th>
                    <th align="left" width="80px">坐席名字</th>
                    <th align="left" width="100px">对方电话</th>
                    <th align="left" width="80px">对方姓名</th>
                    <th	align="left" width="40px">类型</th>    
                    <th	align="left" width="80px">状态</th> 
                    <th align="left" width="140px">开始时间</th>
                    <th align="left" width="80px">通话时长</th>
                    <th align="left" width="80px">排队时长</th>
                    <th width="left" width="80px">400号码</th>
                 	  <th width="60px">录音</th>
                    </tr>               
                </thead>-->
          </table>
      </div>
</div>
</body>
</html>
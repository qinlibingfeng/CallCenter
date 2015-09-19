<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>

<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
<link rel='stylesheet' href='www/lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css' media="screen"/>

<script type="text/javascript" src="www/lib/jquery/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="www/lib/dataTable/js/jquery.dataTables.js"  ></script>
<script src="www/js/work.js"  type="text/javascript"></script>
<script type='text/javascript' src='www/lib/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type='text/javascript' src='www/lib/extenal.js'></script>
<script type='text/javascript' src='www/lib/myDynamicUI/dynamicUI.js'></script>
<script type='text/javascript' src='www/lib/jquery/jquery.json-2.3.min.js'></script>
<script type='text/javascript' src='www/lib/json2.js'></script>
<script type="text/javascript" src="www/lib/jquery.ztree.core-3.0.min.js"></script>
<link rel="stylesheet" href="www/css/zTree.css" type="text/css">
<link rel="stylesheet" href="www/css/ztree/zTreeStyle/zTreeStyle.css" type="text/css">
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
$(document).ready(function() {
	//给时间控件付初值
	var ctime=new Date();
	$("#s_hour").get(0).selectedIndex="00";//index为索引值
	$("#s_min").get(0).selectedIndex="00"	
	$("#start_ymd").attr('value', ctime.format('yyyy-MM-dd'));	
	$("#e_hour").get(0).selectedIndex="23";//index为索引值
	$("#e_min").get(0).selectedIndex="59"
	$("#end_ymd").attr('value', ctime.format('yyyy-MM-dd'));
	
	$('#searchPanelTable').dynamicui(<?php echo json_encode($searchPanelTableData);?>);
	//招生状态赋值
	function getDateString(ymd, hour, minut){
	 	return ymd+" "+hour+":"+minut+":00";
	}
	
	setDatePickerLanguageCn();
	$("#start_ymd").datepicker(); 
	$("#end_ymd").datepicker();   

	function getSearchString(){	
		var searchStr=[];
		var opt=<?php echo json_encode($searchPanelTableData);?>;		
		var timeSearch=[];
		timeSearch.push("and");
		timeSearch.push("datetime");
		timeSearch.push("client_ctime");
		timeSearch.push(getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val()));
		timeSearch.push(getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val()));
		searchStr.push(timeSearch);
		
		$.each(opt.elements,function(index,row){
			$.each(row,function(rowIndex,node){		 
			 	var onSearchItem=[];
				onSearchItem.push("and");
				onSearchItem.push(node.dbtype);
				onSearchItem.push(node.id);
				onSearchItem.push($("#"+node.id).val());
				if(node.type ===2 && $("#"+node.id).val() != '全部' && $("#"+node.id).val() != '未填写' ){
					searchStr.push(onSearchItem);
				}	
				if(node.type ===1 && $("#"+node.id).value != ''){
					searchStr.push(onSearchItem);
				}			
			});	
		});
		return (searchStr);
	}
	
	createTables=function (filterString){
		$('#dataList').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"fnServerParams": function (aoData) {
				var externData={"name": "filterString", "value": ""};
				externData.value=filterString;
				aoData.push(externData);
			},
			"sAjaxSource": "<?php echo site_url('report/ajaxReportCustomClientLook')?>",
			"oLanguage": {
				"sUrl": "<?php echo $this->config->item('base_url')?>/www/lib/dataTable/de_DE.txt"
			}
    	}); 
	}	
	
	createTables($.toJSON(getSearchString()));
	$("#btnSearch").click(function(){
		filterString=$.toJSON(getSearchString());
		var oTable = $('#dataList').dataTable();
		oTable.fnDestroy();	
		createTables(filterString);	
	});
	
	function refreashTable(){
		var oTable = $('#dataList').dataTable();
		oTable.fnDestroy();	
		createTables(getSearchString());
	}
		
	//导出文件
	$("#btnExport").click(function(){	
		 var req={"filterString":""}
		 var reqParam={"searchType":1,"agentId":"","searchText":[]};
		 reqParam.agentId=$('#agentId').attr('value');
		 reqParam.searchText=getSearchString();
		 req.filterString=JSON.stringify(reqParam);
		 $("#csvUrl").html("");
		 $.post("<?php echo site_url('export/ajaxClientExport')?>",req,function(res){	
			$("#csvUrl").attr("href", res.path);
			$("#csvUrl").html(res.fileName);					  							
		});  	
	});	
	
	 $('#example tbody tr').live('dblclick', function(){
		window.parent.iAddTab("详细资料","<?php echo site_url('communicate/connected') ?>/manulClick/"+$('#agentId').attr('value')+"/"+this.id);		
	  });
});
</script>    
</head>
<body>
<input id='agentId' type="hidden" value="<?php  echo $agentId;?>">
<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 自定义报表</div>
         <div class="nav_other"></div>
	</div>
    <div class="func-panel">
			 <div class="left">
                从
                <input type="text" name="start_ymd"   id="start_ymd" value="" style="width:80px"/>
				<?php echo form_dropdown('s_hour',$beginTime['hourOptions'],$beginTime['hourDef'],'id="s_hour"')?><?php echo form_dropdown('s_min',$beginTime['minOptions'],$beginTime['minDef'],'id="s_min"')?>
                到
                <input type="text" name="end_ymd"   id="end_ymd" value="" style="width:80px"/>
  <?php echo form_dropdown('e_hour',$endTime['hourOptions'],$endTime['hourDef'],'id="e_hour"')?><?php echo form_dropdown('e_min',$endTime['minOptions'],$endTime['minDef'],'id="e_min"')?>
                <input type="button" id="btnSearch" value="搜索" class="btnSearch"/>
                <input type="button" id="btnExport" value="导出" class="btnSearch"/>
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
            		<tr>      
						<?php foreach($tableHeader as $th){ 
                            echo "<th align='".$th["align"]."' width='".$th["width"]."'>".$th["name"]."</th>";
                        }?>  
                    </tr>                    
            </thead>
            <tbody></tbody>	
          </table>
      </div>
</div>
</body>
</html>
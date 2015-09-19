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
  $file='';
  $rules="0";
  $("#speedbr" ).progressbar({disabled: false });
  $('#file_upload').uploadify({
   	'swf'           : '<?php echo $this->config->item('base_url');?>/uploadifyV3.2/uploadify.swf',
    'uploader'      : '<?php echo $this->config->item('base_url');?>/uploadifyV3.2/uploadify.php',
	'buttonText': '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上传文件', 
	'auto'      : true,
	'width'		: 100,
	'height'    : 29,
	'onUploadComplete' : function(file) {
						  var p={'file':''};
						  p.file=file.name;
						  $file=file.name;
						  $(".loadLayer").css('display','block');
						  $.post("<?php echo site_url('client/ajaxUploadMap')?>",p,function(res){	
						      $(".loadLayer").css('display','none');
							  $("#importMapTable").empty();
							  var tableStr="<table class='property' ><tr><td class='name'>排重规则:</t><td class='value'> <select id='rules' name='rules' class='rulesSelect'  style='width:100%;height:20px'><option value='0'>根据号码排重</option><option value='1'>根据号码和姓名排重</option></select></td><td class='name'></td><td class='value'></td></tr>";
							  var mapField=[];        
							  $.each(res['importMap'],function(entryIndex,entry){
								if(entryIndex % 2 === 0){
									tableStr+="<tr>";
								}	
								mapField.push(entry['name']);
							    tableStr+="<td class='name'>"+entry['name']+"</td><td class='value'><select name='"+entry['dbfield']+"' class='mapSelect'  style='width:100%;height:20px'></select></td>";		
								if(entryIndex % 2 != 0){
									tableStr+="</tr>";
								}		 
							  });
							  
							 if(res['importMap'].length /2 != 0){
								 tableStr+="</tr>";
							 }	
							 tableStr+="</table>"				  
							 $("#importMapTable").append(tableStr); 
							 
								
							 $(".mapSelect").each(function (i) {
								  $objSelect=$(this);    				
								  $.each(res['excelColumns'],function(entryIndex,entry){
									 if(mapField[i] === entry['text'])
										 $objSelect.append("<option selected='selected' value='"+entry['value']+"'>"+entry['text']+"</option>");						
									 else
									     $objSelect.append("<option  value='"+entry['value']+"'>"+entry['text']+"</option>");						
								  });						  		
						 	   });
							   $('#map').css('display','block'); 
						   });  
    				 }, 
	'onSelect' : function(file) {	
						 $('#map').css('display','none');
	   					 $('#speedbr').css('display','none');
						 $('#tablePanel').css('display','none');
						 $('#successTips').css('display','none');
						 $('.mapSelect option').remove();	
    			     }  
  });
 
  $('#btImport').click(function(){
  	   $('#map').css('display','none');
	   $("#tablePanel").css('display','none');
	   //$('#speedbr').css('display','block');
	    $(".loadLayer").css('display','block');
	   $strMap="{";
	   $(".mapSelect").each(function (i) {
		    $strMap=$strMap+"'"+$(this).attr('name')+"':'"+$(this).val()+"',";				  		
	   });
	   
	   $strMap=$strMap.substring(0, $strMap.length-1);
	   $strMap=$strMap+"}";
	   $rules=$("#rules").val();
	   
	   var $campaignId=window.parent.parent.document.getElementById('vicidial_campaign_id').value;
	   var $req="{'agentId':'"+"<?php echo $agentId;?>"+"','file':'"+$file+"','dataMap':"+$strMap+",'rules':'"+$rules+"','campaignId':'"+$campaignId+"'}";  
	   
	   
	   $json=eval( '(' +$req +')' );

	   $.post("<?php echo site_url('client/doUpload')?>",$json,function(res){   
				 $(".loadLayer").css('display','none');	
				 
				 if(res.ok == 1){
					$('#successTips').html('<center>成功导入'+res.counts+'条数据</center>');
					$('#successTips').css('display','block'); 
				 }else{		 
				 	 $("#tablePanel").css('display','block');			 
				 	 var oTable = $('#dupTable').dataTable();
					 oTable.fnDestroy();		
					 var data=[[ "dd", "Internet 4.0", "Win 95+", 4, "X" ]];
					 $('#dupTable').dataTable( {
						"aaData": res.datas,
						"aoColumns": [
							{ "sTitle": "excel编号","sClass": "center","sWidth":"60px" },
							{ "sTitle": "信息","sClass": "center" }
						],
						"oLanguage": {
							"sUrl": "<?php echo $this->config->item('base_url') ?>/www/lib/dataTable/de_DE.txt"
						}						
					}); 
				 }		
	   });
  });
  $('#rules').change(function(){
  		$rules=$(this).val();
  });

  $('#dupTable').dataTable( {
        "aaData":[
            /* Reduced data set */
            [ "Trident", "Internet Explorer 4.0", "Win 95+", 4, "X" ]
        ],
        "aoColumns": [
            { "sTitle": "编号","sClass": "center","sWidth":"60px" },
            { "sTitle": "排重反馈信息","sClass": "center" }
        ],
		"oLanguage": {
      		"sUrl": "<?php echo $this->config->item('base_url') ?>/www/lib/dataTable/de_DE.txt"
    	}
		
    }); 
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
  <table style="width:100%;margin-top:15px;"><tr><td  width="125px">
  			<input id="file_upload" type="file" name="file_upload"/></td>
        	<td width="125">
        	<input style="margin-top:1px;width:120px;height:30px" id="btImport" type="button" value="导入" /></td><td><div class="loadLayer">数据加载中...</div></td></tr></table>  
    <div  id='speedbr' style="display:none"></div>
    <div id="successTips" style="display:none;margin-top:15px"></div>
    <div  id='map' class='panelOne' style="margin-top:10px;display:none">
    <fieldset><legend>设置</legend>
    		<div id="importMapTable"></div>
    </fieldset>
    </div>
    <div id="tablePanel" style='display:none'><table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="dupTable" >
    <thead><tr><td width='40px'>文档编号</td><td>排重反馈信息</td></tr></thead>
    </table></div>	
</div>
</body>
</html>
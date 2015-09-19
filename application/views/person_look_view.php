<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo base_url() ?>/www/"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

<link rel="stylesheet" href="lib/jquery.jgrowl.css" type="text/css" media="screen" />
<style>
.page_main .index_wel{height:30px;display: inline-block;margin-right: auto;margin-left: auto;background: url(images/main_top_bg.jpg) repeat-x left top;width:100%;padding:4px 0 2px 10px;}

</style>
<style type="text/css" title="currentStyle">
			@import "lib/dataTable/css/demo_page.css";
			@import "lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="lib/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/work.js"></script>
<script type="text/javascript" src="lib/dataTable/js/jquery.dataTables.js"  ></script>
<script>
function onClickNoticeTitle(noticeTitle,noticeId){
	window.parent.iAddTab(noticeTitle,"<?php echo site_url('notice/preview')?>/"+noticeId);
}

$(document).ready(function(){
	$('#notice_table1').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers
			  $('td:eq(1)', nRow).html("<a href='javascript:onClickNoticeTitle(\""+aData[1]+"\",\""+aData[0]+"\")'>"+aData[1]+"</a>");
    		},
			"fnServerParams": function (aoData) {
				var externData={ "name": "agentId", "value": "<?php echo $agentId;?>"};
				aoData.push(externData);
			},
			"aoColumns": [{"mDataProp":"0"},{"mDataProp":"1"},{"mDataProp":"2"}],
			"sAjaxSource": "<?php echo site_url('notice/ajaxLookNotice')?>",
			"oLanguage": {"sUrl": "<?php echo $this->config->item('base_url')?>/www/lib/dataTable/de_DE.txt"}
    	}); 
		$('#threedays_table').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers
    		},	"fnServerParams": function (aoData) {
				var externData={ "name": "agentId", "value": "<?php echo $agentId;?>"};
				aoData.push(externData);
			},
			"iDisplayLength": 15,
			"sAjaxSource": "<?php echo site_url('report/ajaxThreeDaysCount')?>",
			"oLanguage": {"sUrl": "<?php echo $this->config->item('base_url')?>/www/lib/dataTable/de_DE.txt"}
    	}); 
});
	
</script>
</head>
<body>
<div class="page_main page_tops">
         <div class="index_wel"><img src="images/index_wel.gif" /></div>          
<table width="99%" border="0" align="center" style="border-collapse: separate;border-spacing: 4px;">
          <tr>
            <td valign="top" style="width:50%">
          <fieldset><legend onClick="show_div('data_table1');">公告</legend>
            <table width="100%" cellpadding="0" cellspacing="0" class="dataTable" id="notice_table1">
            <thead>
              <tr align="left" class="dataHead">
                <td >公告序号</td>
                <td >公告标题</td>
                <td >创建时间</td>
              </tr>
              </thead>
             </table>       
           </fieldset>    
           </td>
            <td valign="top" style="width:50%">          
            <fieldset><legend onClick="show_div('data_table2');">当日工作量统计</legend>
             <table width="100%" cellpadding="0" cellspacing="0" class="dataTable" id="threedays_table">
                <thead>
                  <tr align="left" class="dataHead">
                    <td>坐席工号</td>
                    <td >坐席名称</td>
                    <td >呼入量</td>
                    <td >呼出量</td>  
                    <td >总计</td>                 
                </tr>
                </thead>
                <tbody>                
                </tbody>   
            </table>
            </fieldset> 
            </td>
          </tr>      
        </table>         
         
</div>
</body>
</html>
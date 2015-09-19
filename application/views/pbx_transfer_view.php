<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<script type="text/javascript" src="js/call.js"></script>
<script type="text/javascript" src="lib/dataTable/js/jquery.dataTables.js"  ></script>
<script>
$(document).ready(function(){
	$('#pbxTransferTable').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers
			  $('td:eq(2)', nRow).html("<a href='javascript:transfer(\""+<?php echo $agentId;?>+"\",\""+aData[2]+"\")'><img src='images/transferBt.png'/>转接</a>");
    		},
			"fnServerParams": function (aoData) {
				var externData={ "name": "agentId", "value": "<?php echo $agentId;?>"};
				aoData.push(externData);
			},
			"aoColumns": [{"mDataProp":"0"},{"mDataProp":"1"},{"mDataProp":"2"}],
			"sAjaxSource": "<?php echo site_url('pbx/ajaxTransferTable')?>",
			"oLanguage": {"sUrl": "<?php echo $this->config->item('base_url')?>/www/lib/dataTable/de_DE.txt"}
    	}); 

});
	
</script>
</head>
<body>
	 <table width="100%" cellpadding="0" cellspacing="0" class="dataTable" id="pbxTransferTable">
                <thead>
                  <tr align="left" class="dataHead">
                    <td width="80px"> 坐席工号</td>
                    <td >坐席名称</td>
                    <td width="100px">操作</td>       
                  </tr>
                </thead>
                <tbody>                
                </tbody>   
            </table>
</body>
</html>

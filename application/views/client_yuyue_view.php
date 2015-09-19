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
<script type='text/javascript' src='www/js/call.js'></script>
<style type="text/css" title="currentStyle">
			@import "www/lib/dataTable/css/demo_page.css";
			@import "www/lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
	
</style>

<script>

function startCall(callnum,callid){			
		window.parent.parent.document.getElementById('MDPhonENumbeR').value = callnum;
		window.parent.parent.NeWManuaLDiaLCalLSubmiT("NEW");		
}


function onCallClick(name,url){	
	if(name !="")
		window.parent.iAddTab(name,url);
	else
		window.parent.iAddTab("未命名",url);
}

$(document).ready(function() {

	setDatePickerLanguageCn();	
	createSelect('#sZsjd','招生阶段',"<?php echo site_url('dictionary/ajaxGetKeyValue')?>");
	//createSelect('#sStatus','状态',"<?php echo site_url('dictionary/ajaxGetKeyValue')?>");
	createSelect('#sAgent',$('#agentId').attr('value'),"<?php echo site_url('role/ajaxGetCAgentsCanShow')?>");
	
	//招生状态赋值
	function getDateString(ymd, hour, minut){
	 	return ymd+" "+hour+":"+minut+":00";
	}
	 
	$("#start_ymd").datepicker(); 
	$("#end_ymd").datepicker();   


	function getSearchString(){
			
		if($("#searchPanel").css("display") == "none")
			filterString='{"searchType":0,"agentId":\"'+$('#agentId').attr('value')+'\","searchText":\"'+$("#searchText").attr("value")+'\"}';
		else{			
			filterString='{"searchType":1,"agentId":\"'+$('#agentId').attr('value')+'\","searchText":[["and","varchar","client_name",\"'+$("#sName").attr("value")+'\"],["and","varchar","client_phone",\"'+$("#sPhone").attr("value")+'\"],["and","varchar","client_person_card",\"'+$("#sCard").attr("value")+'\"],["and","int","client_zsjd",-1],["and","varchar","client_agent",\"'+$("#sAgent").val()+'\"],["and","datetime","client_ctime",\"'+getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val())+'\",\"'+getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val())+'\"]]}';
		}

		return filterString;
	}
	
	createTables=function (filterString){
		$('#dataList').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"aoColumnDefs": [
				{
					"fnRender": function ( oObj ) {
						return '<input type=\"checkbox\"  value="'+ oObj.aData[0] +'"> ';
					},
					"aTargets": [0]
				}
			],
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
			  // Bold the grade for all 'A' grade browsers 
			  htmlStr='<center><a href="javascript:onCallClick(\''+aData[1]+'\',\'<?php echo site_url('communicate/connected')?>/manulClick/'+$('#agentId').attr('value')+'/'+aData[9]+'\')"><img src="www/images/dxzx.png"></img></a></center>';
			   $('td:eq(9)', nRow).html(htmlStr);
			    $('td:eq(8)', nRow).html(aData[8]+'['+aData[10]+']');
			if(aData[3]){
				// $('td:eq(3)',nRow).html('<a href="javascript:onClientUiCall(\''+$('#agentId').attr("value")+'\',\''+aData[3]+'\')">'+aData[3]+'<img src="www/images/dxzx.png"></a>');
				 
				 $('td:eq(3)',nRow).html('<a  href="javascript:;" onclick = "startCall(\''+aData[3]+'\',\''+$('#agentId').attr("value")+'\')">'+aData[3]+'<img src="www/images/dxzx.png"></a>');

			 }
			 if(aData[4]){
			 	//$('td:eq(4)',nRow).html('<a href="javascript:onClientUiCall(\''+$('#agentId').attr("value")+'\',\''+aData[4]+'\')">'+aData[4]+'<img src="www/images/dxzx.png"></a>');
			 	
			 	$('td:eq(4)',nRow).html('<a  href="javascript:;" onclick = "startCall(\''+aData[4]+'\',\''+$('#agentId').attr("value")+'\')">'+aData[4]+'<img src="www/images/dxzx.png"></a>');

			 }
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
				{"mDataProp":"9"}	
			],
			"iDisplayLength": 16,
			"fnServerParams": function (aoData) {
				var externData={ "name": "filterString", "value": "my_value" };
				externData.value=filterString;
				aoData.push(externData);
			},
			"sAjaxSource": "<?php echo site_url('client/ajaxYuyueClientLook')?>",
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
	
	//给时间控件付初值
	var ctime=new Date();
	$("#s_hour").get(0).selectedIndex="00";//index为索引值
	$("#s_min").get(0).selectedIndex="00"	
	$("#start_ymd").attr('value', ctime.format('yyyy-MM-dd'));	
	$("#e_hour").get(0).selectedIndex="23";//index为索引值
	$("#e_min").get(0).selectedIndex="59"
	$("#end_ymd").attr('value', ctime.format('yyyy-MM-dd'));	
	
	//高级搜索
	$("#btnAdvance").click(function(){		
		if($("#searchPanel").css("display") == "none")
			$("#searchPanel").css("display","block");
		else
			$("#searchPanel").css("display","none");
	});
	
	//导出文件
	$("#btnExport").click(function(){
		 var req={"filterString":""};
		 req.filterString=getSearchString();
		 $.post("<?php echo site_url('export/ajaxClientExport')?>",req,function(res){	
			 $("#csvUrl").attr("href", res.path);
			 $("#csvUrl").html("download");					  							
		});  	
	});
	
	$("#btnDelAll").click(function(){
		 if(confirm("确定要删除满足查询条件的所有客户吗？")){
			$req={'filterString':'','campaignId':''};
			$req.filterString= getSearchString();	
			$req.campaignId=window.parent.parent.document.getElementById('vicidial_campaign_id').value;
			$.post("<?php echo site_url('client/ajaxDeleteAllClient')?>",$req,function(res){	
													
			});  
		 }
	});
	
	$("#btnDel").click(function(){
		 if(confirm("确定要删除选中的客户吗？")){	 
			$ids=[];
			var datas=getSelectedItem();
			for(var i in datas){
				var $item=[];
				$item.push('or');
				$item.push('varchar');
				$item.push('client_id');
				$item.push(datas[i]);	
				$ids.push($item);
			}		
			$req={'ids':[],'campaignId':''};
			$req.ids=$ids;
			$req.campaignId=window.parent.parent.document.getElementById('vicidial_campaign_id').value;
			$.post("<?php echo site_url('client/ajaxDeleteYuyueClient')?>",$req,function(res){	
				if(res.ok){
					var oTable = $('#dataList').dataTable();
					oTable.fnDestroy();	
					createTables(getSearchString());
				}										
			}); 		 
		 }
	});
});
</script>    
</head>
<body>
<input id='agentId' type="hidden" value="<?php  echo $agentId;?>">
<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置： &gt; 所有客户</div>
         <div class="nav_other"></div>
	</div>
    <div class="func-panel">
			 <div class="left"><input type="text" id="searchText">
			 	<input type="button" id="btnSearch" value="搜索" class="btnSearch"/>
                <input type="button" id="btnAdvance" value="高级" class="btnSearch"/>
                <input type="button" id="btnDel" value="删除" class="btnSearch"/>
                <input type="button" id="btnExport" value="导出" class="btnSearch"/>
                <a id="csvUrl" href='export_datas/clients_09Apr12.csv'></a>
			 </div>
			 <div align='right' class="right">
			
			 </div>		
			 <div style="clear:both;"></div>  
	</div>	
	<div id="searchPanel" style="display:none;margin-top:5px;margin-bottom:5px">
    <table>
    	<tr><td>电话号码：</td><td><input type="text" id="sPhone" style="width:100px"></td><td>姓名：</td><td> <input type="text" id="sName" style="width:166px"></td><td>身份证:</td><td> <input type="text" id="sCard" style="width:166px" ></td><td>招生阶段：</td><td><select id="sZsjd"></select></td><td>所属坐席：</td><td><select  name="sAgent" id="sAgent">
  	  </select>
    	<td>
      </tr>        		
      <tr><td>时间类型：</td><td> <select><option value="0">导入时间</option><option value="1">最后沟通时间</option></select></td>
        <td>从</td><td><input type="text" name="start_ymd"   id="start_ymd" value="" style="width:80px"/>&nbsp;<select name='s_hour' id='s_hour' style="width:40px">
<option value='00'>00</option>
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
</select>
		<select  name='s_min' id='s_min' style="width:40px">
<option value='00'>00</option>
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='26'>26</option>
<option value='27'>27</option>
<option value='28'>28</option>
<option value='29'>29</option>
<option value='30'>30</option>
<option value='31'>31</option>
<option value='32'>32</option>
<option value='33'>33</option>
<option value='34'>34</option>
<option value='35'>35</option>
<option value='36'>36</option>
<option value='37'>37</option>
<option value='38'>38</option>
<option value='39'>39</option>
<option value='40'>40</option>
<option value='41'>41</option>
<option value='42'>42</option>
<option value='43'>43</option>
<option value='44'>44</option>
<option value='45'>45</option>
<option value='46'>46</option>
<option value='47'>47</option>
<option value='48'>48</option>
<option value='49'>49</option>
<option value='50'>50</option>
<option value='51'>51</option>
<option value='52'>52</option>
<option value='53'>53</option>
<option value='54'>54</option>
<option value='55'>55</option>
<option value='56'>56</option>
<option value='57'>57</option>
<option value='58'>58</option>
<option value='59'>59</option>
</select></td><td>到</td><td>
		<input type="text" name="end_ymd" id="end_ymd"  style="width:80px" value=""/>
       	<select name='e_hour' id='e_hour' style="width:40px">
<option value='00'>00</option>
<option value='01'>01</option>
<option value='02'>02</option>
<option value='03'>03</option>
<option value='04'>04</option>
<option value='05'>05</option>
<option value='06'>06</option>
<option value='07'>07</option>
<option value='08'>08</option>
<option value='09'>09</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
</select>
        <select  name='e_min' id='e_min' style="width:40px">
            <option value='00'>00</option>
            <option value='01'>01</option>
            <option value='02'>02</option>
            <option value='03'>03</option>
            <option value='04'>04</option>
            <option value='05'>05</option>
            <option value='06'>06</option>
            <option value='07'>07</option>
            <option value='08'>08</option>
            <option value='09'>09</option>
            <option value='10'>10</option>
            <option value='11'>11</option>
            <option value='12'>12</option>
            <option value='13'>13</option>
            <option value='14'>14</option>
            <option value='15'>15</option>
            <option value='16'>16</option>
            <option value='17'>17</option>
            <option value='18'>18</option>
            <option value='19'>19</option>
            <option value='20'>20</option>
            <option value='21'>21</option>
            <option value='22'>22</option>
            <option value='23'>23</option>
            <option value='24'>24</option>
            <option value='25'>25</option>
            <option value='26'>26</option>
            <option value='27'>27</option>
            <option value='28'>28</option>
            <option value='29'>29</option>
            <option value='30'>30</option>
            <option value='31'>31</option>
            <option value='32'>32</option>
            <option value='33'>33</option>
            <option value='34'>34</option>
            <option value='35'>35</option>
            <option value='36'>36</option>
            <option value='37'>37</option>
            <option value='38'>38</option>
            <option value='39'>39</option>
            <option value='40'>40</option>
            <option value='41'>41</option>
            <option value='42'>42</option>
            <option value='43'>43</option>
            <option value='44'>44</option>
            <option value='45'>45</option>
            <option value='46'>46</option>
            <option value='47'>47</option>
            <option value='48'>48</option>
            <option value='49'>49</option>
            <option value='50'>50</option>
            <option value='51'>51</option>
            <option value='52'>52</option>
            <option value='53'>53</option>
            <option value='54'>54</option>
            <option value='55'>55</option>
            <option value='56'>56</option>
            <option value='57'>57</option>
            <option value='58'>58</option>
            <option value='59'>59</option>
            </select></td>
<td>&nbsp;</td><td>&nbsp;</td><td></td><td></td></tr>
    </table>	
    </div>
      <div id="example" style='display:block'>
          <table width="100%" cellpadding="0" cellspacing="0" border="0"  id="dataList" >
          		<thead>
                	<tr>
                	<th id="cbAll" width="20px"><input   type="checkbox" value="全选" /></td>
                    <th  align="left" width="50px">姓名</th>
                    <th  align="left" width="40px">性别</th>
                    <th  align="left" width="100px">手机</th>
                    <th  align="left" width="100px">固话</th>
                    <th  align="left" width="200px">地址</th>    
                    <th  align="left">预约内容</th>   
                    <th  align="left" width="120px">预约时间</th>
                    <th  align="left" width="100px">所属坐席</th>
                 	<th  align="center" width="60px">操作</th>
                    </tr>               
                </thead>
          </table>
      </div>
</div>
</body>
</html>
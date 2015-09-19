<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>
<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />


<link rel='stylesheet' type='text/css' href='fullcalendar-1.5.2/jquery/ui/themes/base/jquery.ui.all.css' />
<link rel='stylesheet' type='text/css' href='fullcalendar-1.5.2/fullcalendar/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='fullcalendar-1.5.2/fullcalendar/fullcalendar.print.css' media='print' />

<script type='text/javascript' src='www/lib/extenal.js'></script>
<script type='text/javascript' src='fullcalendar-1.5.2/jquery/jquery-1.5.2.min.js'></script>
<script type='text/javascript' src='fullcalendar-1.5.2/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type='text/javascript' src='fullcalendar-1.5.2/fullcalendar/fullcalendar.min.js'></script>  
<style>
	.ui-dialog .ui-state-error { padding: .3em; }
	.validateTips { border: 1px solid transparent; padding: 0.3em; }
</style>
<script>
$(document).ready(function(){
	
		tips = $(".validateTips" );
		function updateTips( t ) {
			tips.text( t );
			setTimeout(function() {
			}, 500 );
		 }	
		 function checkDateTime()
		 {
			var s_time=getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val());
			var e_time=getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val());
			if($.fullCalendar.parseDate(e_time) < $.fullCalendar.parseDate(s_time))
			{
				updateTips('结束时间必须大于等于开始时间');
				return false;
			}
			return true;
		 }
		 function checkTitle()
		 {
			 if($('#content').attr('value') == ''){
			 	updateTips('标题不能为空');
				return false;
			 }
			 return true;
		 }
		 function getDateString(ymd, hour, minut)
		 {
			 return ymd+" "+hour+":"+minut;
		 }
		 function init_dialog_form(calEvent)
		 {
			 $("#content").attr('value', calEvent.title); 
			 var start_time=new Date(calEvent.start);
			 $("#s_hour").get(0).selectedIndex=start_time.getHours();//index为索引值
			 $("#s_min").get(0).selectedIndex=start_time.getMinutes();
			 $("#start_ymd").attr('value', start_time.format('yyyy-MM-dd'));	
			 
			 var end_time=new Date(calEvent.start);
			 if(calEvent.end)
			 	end_time=new Date(calEvent.end);
			 $("#e_hour").get(0).selectedIndex=end_time.getHours();//index为索引值
			 $("#e_min").get(0).selectedIndex=end_time.getMinutes();
			 $("#end_ymd").attr('value', end_time.format('yyyy-MM-dd'));	
		 }
		 
		 function delete_calendar(calEvent)
		 {
			$.post('<?php echo site_url("plan/ajaxCalendarDel");?>',{'id':calEvent.id});
			$('#calendar').fullCalendar( 'refetchEvents' );	
			return true;
		 }
		 
		 function addCalendar()
		 {
			var s_time=getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val());
			var e_time=getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val());
			var post_data={
						   'title':$('#content').attr('value'),
						   'start':s_time,
						   'end':e_time
						  };
			$.post('<?php echo site_url("plan/ajaxCalendarAdd");?>',post_data);
			$('#calendar').fullCalendar( 'refetchEvents' );
			return true;
		 }
		 
		 function update_calendar(calEvent)
		 {		 	
		 	var s_time=getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val());
			var e_time=getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val());
			//更新数据
			var post_data={'id':calEvent.id,
						   'title':$('#content').attr('value'),
						   'start':s_time,
						   'end':e_time
						  };
			$.post('<?php echo site_url("plan/ajax_calendar_modify");?>',post_data);
			$('#calendar').fullCalendar('refetchEvents' );
			return true;
		 }
		 
         $.datepicker.regional['zh-CN'] =
		 {
			clearText: '清除', clearStatus: '清除已选日期',
			closeText: '关闭', closeStatus: '不改变当前选择',
			prevText: '&lt;上月', prevStatus: '显示上月',
			nextText: '下月&gt;', nextStatus: '显示下月',
			currentText: '今天', currentStatus: '显示本月',
			monthNames: ['一月','二月','三月','四月','五月','六月',
			'七月','八月','九月','十月','十一月','十二月'],
			monthNamesShort: ['一','二','三','四','五','六',
			'七','八','九','十','十一','十二'],
			monthStatus: '选择月份', yearStatus: '选择年份',
			weekHeader: '周', weekStatus: '年内周次',
			dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
			dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
			dayNamesMin: ['日','一','二','三','四','五','六'],
			dayStatus: '设置 DD 为一周起始', dateStatus: '选择 m月 d日, DD',
			dateFormat: 'yy-mm-dd', firstDay: 1,
			initStatus: '请选择日期', isRTL: false
	   };
	   
	   var nevent_start='';
	   var nevent_end='';
	   var nevent_title='';
	   
   	   $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
       $("#start_ymd").datepicker(); 
	   $("#end_ymd").datepicker();
	    	 
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
			monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
  			dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
  			today: ["今天"],
  			buttonText: {today: '今天',prev: '上一',next: '下一',month:'每月',agendaWeek:'每周',agendaDay:'每日'},
			eventClick: function(calEvent, jsEvent, view) {		
				$('#dialog-form').attr('title','修改事件');
				$('#del_bt').css('display','block');					
				init_dialog_form(calEvent);	
				$("#dialog-form" ).dialog({
						autoOpen:true,
						height: 300,
						width: 350,
						modal: true,
						buttons: {
							"确认": function(){	
								bRes=false;
								if($('#is_del').attr('checked')){
									bRes=delete_calendar(calEvent);
								}
								else{
									bRes=checkDateTime();
									bRes=checkTitle();
									if(bRes)
										bRes=update_calendar(calEvent);
								}
								if(bRes)									
									$( this ).dialog("close" );
							},
							"取消": function(){
								$(this).dialog( "close" );
							}
						},
						close: function(){
							$(this).dialog('destroy');
						}
				});	
    		},
			dayClick: function(date, allDay, jsEvent, view) {
				$('#dialog-form').attr('title','添加事件');
				$('#del_bt').css('display','none');
				$('#start_ymd').attr('value', date.format('yyyy-MM-dd'));
				$('#end_ymd').attr('value', date.format('yyyy-MM-dd'));
				$( "#dialog-form" ).dialog({
						autoOpen:true,
						height: 300,
						width: 350,
						modal: true,
						buttons:{
							"确认": function(){	
								bRes=checkDateTime();
								bRes=checkTitle();
								if(bRes)
									bRes=addCalendar();
								if(bRes)
									$( this ).dialog("close" );
							},
							"取消": function(){
								$(this).dialog( "close" );
							}
						},
						close: function(){
							$(this).dialog('destroy');
						}
				});	
    		},
			editable: true,
			events: {
				url: '<?php echo site_url("plan/ajax_calendar_events")?>',
				type: 'POST',
				data: {
					custom_param1: 'something',
					custom_param2: 'somethingelse'
				},
				error: function() {
					alert('there was an error while fetching events!');
				},
				color: 'yellow',   // a non-ajax option
				textColor: 'black' // a non-ajax option
				}
        		
		});
		
	});
</script>
</head>
<body>
<div id="dialog-form" title="修改计划" style="display:none">
	<p class="validateTips"></p>
	<form>
		<fieldset>
		<label for="lcontent">标题</label><br>
		<input type="text" name="content"  id="content" class="text ui-widget-content ui-corner-all" /><br>
		<label for="from">从</label><br>
		<input type="text" name="start_ymd" id="start_ymd" value="" class="text ui-widget-content ui-corner-all" />
		<select name='s_hour' id='s_hour'>
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
		<select  name='s_min' id='s_min'>
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
</select>
        <br>
		<label for="to">到</label><br>
		<input type="text" name="end_ymd" id="end_ymd" class="text ui-widget-content ui-corner-all" value=""/>
       	<select name='e_hour' id='e_hour'>
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
        <select  name='e_min' id='e_min'>
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
            </select>
        <br>
        <br>
		<div id='del_bt'>删除<input id='is_del' type="checkbox" /></div>
		</fieldset>
	</form>
</div>

<div class="work-space">
	<div >
   		<div id='calendar'></div>
	</div>
</div>

</body>
</html>
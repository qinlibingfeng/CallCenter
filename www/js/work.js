function getYmdhmDateString(ymd, hour, minut){
		return $('#'+ymd).attr('value')+" "+$('#'+hour).val()+":"+$('#'+minut).val()+":00";
}
function openClientExportDialog(){
	alert("hello");
}
$(document).ready(function(){
	//list高亮与checkbox	   		
	var aSelected = [];	
	$('#cbAll').bind('click',function(){		
		if(!$(this).children(':checkbox').attr("checked")){	
			$('#example tbody tr').each(function(i){		
				 var id = this.id;
				 var index = jQuery.inArray(id, aSelected);    
				 if ( index != -1 ) {
					 aSelected.splice(index, 1);
				 }	
				if($(this).children("td").children(":checkbox").attr("checked"))
					$(this).toggleClass('dataTable over');
			});
			
			$('#example tbody tr td :checkbox').attr("checked",false);
			
		}else{
			
			$('#example tbody tr').each(function(i){			
				var id = this.id;
				var index = jQuery.inArray(id, aSelected);    
				if ( index === -1 ) {
					aSelected.push(id);
				}
				if(!$(this).children("td").children(":checkbox").attr("checked"))
					$(this).toggleClass('dataTable over');
				
			});
			$('#example tbody tr td :checkbox').attr("checked",true);
			
		}	
	});
	
	$('#example tbody tr td :checkbox').live('change',function(){
			$thisRow=$(this).parent().parent();
			var id = $thisRow.attr('id');
			$thisRow.toggleClass('dataTable over');
			if($(this).attr('checked')){
				var index = jQuery.inArray(id, aSelected);    
				if (index == -1) {
					aSelected.push(id);
				}
			}
			 else {
				var index = jQuery.inArray(id, aSelected);    
				if (index != -1) {
					aSelected.splice(index, 1);
				}
				
			}
	});
	
	getSelectedItem=function(){
		var rsSelected=[];
		$('#example tbody tr').each(function(i){			
			var id = this.id;
			if($(this).children("td").children(":checkbox").attr("checked"))
				rsSelected.push(id);
				
		});
		return rsSelected;
	}
  	
	setDatePickerLanguageCn=function(){
		   //本地化datepicker
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
	   	$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
	   }
	   	createGroupRadio=function(id,group,text,url,def){
			var def=(typeof(def)== "undefined ")? 0:def; 
					//招生阶段赋值
			var radioGroups='';
			var req={'type':1,'text':''};
			req.text=text;
			 $.post(url,req,function(res){									
				  $.each(res,function(entryIndex,entry){
					if(entry['name_value'] == def)					 
						radioGroups=radioGroups+'<input type="radio" checked="checked" name="'+group+'" value="'+entry['name_value']+'"/>'+entry['name_text']+"&nbsp;";	
					else
						radioGroups=radioGroups+'<input type="radio" name="'+group+'" value="'+entry['name_value']+'"/>'+entry['name_text']+"&nbsp;";	
				  });	
				   $(id).html(radioGroups);		
				 });
		}
		
		createSelect=function(id,text,url,def){
				var def=(typeof(def)== "undefined ")? "全部":def; 
				 var req={'type':1,'text':''};
				 req.text=text;
					 					 
				 $(id+" option").remove();							
				 $.post(url,req,function(res){	
				 	  $(id).append("<option value='-1'>全部</option>");						
					  $.each(res,function(entryIndex,entry){		 
					  	 if(entry['name_text'] == def)
						 	$(id).append("<option  selected='selected' value='"+entry['name_value']+"'>"+entry['name_text']+"</option>");						
						 else					 
						 	$(id).append("<option value='"+entry['name_value']+"'>"+entry['name_text']+"</option>");						
					  });						  							
				});  
			}
		
	getDatas=function(column,type){
				var ret='[';
				$.each(column,function(index,entry){	
								
						if(type == 0){			
							ret+='"'+$('#'+entry).attr('value')+'",';
						}
						
						if(type == 1){
							ret+=$('#'+entry).val()+',';	
						}
						if(type == 2){
							ret+='"'+$('#'+entry).find("option:selected").text()+'",';
						}
						
						if(type == 3){
							ret+='"'+$('input[name="'+entry+'"]').filter(':checked').val()+'",';
						}					
						
				});	
				
				if(ret !=='[')
					ret=ret.substring(0, ret.length-1);
				ret+=']';
				return ret;
	}	
});

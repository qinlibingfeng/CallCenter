// JavaScript Document
(function($){	
	function debug($obj) {    
		if (window.console && window.console.log)    
		  window.console.log($obj);    
  	};
	$.fn.dynamicui=function(options){
		var $this=$(this);	
		var opt=$.extend({},$.fn.dynamicui.defaults,options);
		debug(opt);

		//绘制元素
		$.each(opt.elements,function(index,obj){
			$this.find("tbody").append(addOneRow($this,obj));
		});
		
		//自定义事件处理
		custom(opt.elements);		
	};
	
	$.fn.dynamicui.defaults={
		
	};
	
	$.fn.dynamicui.getIntDatas=function(){	
		return [];
	};
	
	$.fn.dynamicui.getTextDatas=function(id){	
			var ret={ids:[],values:[]};
			$(id).find(".dui-control").each(function(){
				ret.ids.push($(this).attr('id'));			
				ret.values.push($(this).val());
			});
			
			return ret;
	};
	
	function addOneRow($this,$obj){
		var htmlText="<tr>";
		$.each($obj,function(index,element){
			htmlText+=addOneElement($this,element);	
		});
		htmlText+="</tr>"
		return htmlText;
	}
	
	function addOneElement($this,$obj){
		var htmlText="";
		//console.log("1111111111111111111111");

		if($obj.type === 1 || $obj.type === 3){	
		
			if($obj.id === 'client_phone' || $obj.id === 'client_cell_phone'){
				//文本
				htmlText="<td class='dui-name'>"+$obj.name+"<a href='javascript:webCallPhone(\""+$obj.id+"\")'><img src='www/images/dxzx.png'></a></td><td  class='dui-value' colspan='"+$obj.colspan+"'> <input class='dui-control' id='"+$obj.id+"' type='text' value='"+$obj.value.defaultValue+"'></td>";
				
			}else{
				//文本
				htmlText="<td class='dui-name'>"+$obj.name+"</td><td  class='dui-value' colspan='"+$obj.colspan+"'> <input class='dui-control' id='"+$obj.id+"' type='text' value='"+$obj.value.defaultValue+"'></td>";
			}			
		}else if($obj.type === 2){
		
			//下拉菜单
			htmlText+="<td class='dui-name'>"+$obj.name+"</td><td class='dui-value' colspan='"+$obj.colspan+"'><select class='dui-control' id='"+$obj.id+"'>";	
			$.each($obj.value.values,function(index,elem){
				if(elem['name_value'] === $obj.value.defaultValue)
					htmlText+="<option  selected='selected' value='"+elem['name_value']+"'>"+elem['name_text']+"</option>";
				else
					htmlText+="<option   value='"+elem['name_value']+"'>"+elem['name_text']+"</option>";
			});
			htmlText+="</select></td>";
		}else if($obj.type === 4){
		
			htmlText+="<td class='dui-name'>"+$obj.name+"</td><td class='dui-value' colspan='"+$obj.colspan+"'>";
			//单选按键组
			$.each($obj.value.values,function(entryIndex,entry){
					if(entry['name_value'] === $obj.value.defaultValue)					 					htmlText+='<input type="radio" checked="checked" name="'+$obj.id+'" value="'+entry['name_value']+'"/>'+entry['name_text']+"&nbsp;";	
					else
						htmlText+='<input type="radio" name="'+$obj.id+'" value="'+entry['name_value']+'"/>'+entry['name_text']+"&nbsp;";	
				  });
			htmlText+="</td>";
		}else if($obj.type === 5 || $obj.type === 6){
			
			if($obj.width != ""){
				htmlText+="<td class='dui-name'>"+$obj.name+"</td><td><textarea class='dui-control' style='width:"+$obj.width+";height:"+$obj.height+"' id='"+$obj.id+"'>"+$obj.value.defaultValue+"</textarea></td>";
			}else{
				htmlText+="<td class='dui-name'>"+$obj.name+"</td><td><textarea class='dui-control'  id='"+$obj.id+"'>"+$obj.value.defaultValue+"</textarea></td>";
			}
		}else if($obj.type === 7){
			htmlText="<td class='dui-name'>"+$obj.name+"<a href='javascript:webCallPhone(\""+$obj.id+"\")'><img src='www/images/dxzx.png'></a>&nbsp;&nbsp;<a href='javascript:webVoipCallPhone(\""+$obj.id+"\")'>voip<img src='www/images/dxzx.png'></a></td><td  class='dui-value' colspan='"+$obj.colspan+"'> <input class='dui-control' id='"+$obj.id+"' type='text' value='"+$obj.value.defaultValue+"'></td>";
		}
			
		for(var i=0; i<$obj.lspace; i++){	
			htmlText+="<td></td>";
		}
		
		return htmlText;
	}	
	
	function custom(elements){
		$.each(elements,function(index,row){
			$.each(row,function(index,elem){
				if(elem.type === 3){
					customTreeElem(elem,getTreeSetting());
				}else if(elem.type === 6){
					var setting={view:{dblClickExpand: false},data:{simpleData: {enable: true}},callback: {beforeClick: beforeClick,onClick:onTreeClickAllValue}};
					customTreeElem(elem,setting);
				}
			});
		});
	}
	
	function customTreeElem($obj,$setting){
		$("body").append('<div id="'+$obj.id+'div" class="menuContent" style="display:none;position: absolute; heigth:200px;"><ul id="'+$obj.id+'tree" class="ztree" style="margin-top:0;"></ul></div>');			
		
		$.fn.zTree.init($("#"+$obj.id+"tree"), $setting, $obj.value.values);
		$("#"+$obj.id).click(function(){
			debug("click");
			$gSelectedId=$obj.id;
			hideTreeMenu();
			showTreeMenu($obj.id);
		});		
	}
	
	function getSelectedId(){
		return $gSelectedId;
	}	
	function getTreeSetting(){
		return {view: {dblClickExpand: false},data:{simpleData: {enable: true}},callback: {beforeClick: beforeClick,onClick: onClick}};
	}
	function beforeClick(){
	}
	function onTreeClickAllValue(){
		var zTree = $.fn.zTree.getZTreeObj(getSelectedId()+"tree"),
		nodes = zTree.getSelectedNodes(),

		v = "";
		nodes.sort(function compare(a,b){return a.id-b.id;});
		var sNode=null;
		for (var i=0, l=nodes.length; i<l; i++) {
			sNode=nodes[i];
		}
		if(sNode){
			v=sNode.name;
			sNode=sNode.getParentNode();
		}
		while(sNode){
			v=sNode.name+v;
			sNode=sNode.getParentNode();
		}
		var cityObj = $("#"+getSelectedId());
		cityObj.attr("value", v);
	}
	function onClick(){
		var zTree = $.fn.zTree.getZTreeObj(getSelectedId()+"tree"),
		nodes = zTree.getSelectedNodes(),
		v = "";
		nodes.sort(function compare(a,b){return a.id-b.id;});
		for (var i=0, l=nodes.length; i<l; i++) {
			v += nodes[i].name + ",";
		}
		if (v.length > 0 ) v = v.substring(0, v.length-1);

		var cityObj = $("#"+getSelectedId());
		cityObj.attr("value", v);
	}
	
	function showTreeMenu(id){
	var cityObj = $("#"+id);
	var cityOffset = $("#"+id).offset();
	
	$("#"+id+"div").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px",display:"block"}).slideDown("fast");

	$("body").bind("mousedown", onBodyDown);
}
	function hideTreeMenu(){
		$(".menuContent").fadeOut("fast");
		$("body").unbind("mousedown", onBodyDown);
	}
	function onBodyDown(event){	
		if (!(event.target.id == "menuBtn" || $(event.target).parents(".menuContent").length>0)) {
			hideTreeMenu();
		}
	}
	
	
})(jQuery);

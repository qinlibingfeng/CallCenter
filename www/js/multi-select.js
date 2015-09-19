
var setting = {
	view: {
		dblClickExpand: false
	},
	data: {
		simpleData: {
			enable: true
		}
	},
	callback: {
		beforeClick: beforeClick,
		onClick: onClick
	}
};

var id_map=null		
var	current_select_id=null;
function beforeClick(treeId, treeNode) 
{
	var check = (treeNode && !treeNode.isParent);
	return check;
}

function onClick(e, treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj(id_map[current_select_id]["tree_id"]),
	nodes = zTree.getSelectedNodes(),
	v = "";
	nodes.sort(function compare(a,b){return a.id-b.id;});
	for (var i=0, l=nodes.length; i<l; i++) {
		v += nodes[i].name + ",";
	}
	if (v.length > 0 ) v = v.substring(0, v.length-1);
	var cityObj = $("#"+current_select_id);
	cityObj.attr("value", v);
}

function onSelectClick(id)
{
	current_select_id=id;
	hideMenu();
	showMenu(id);
}

function showMenu(id) {
	var cityObj = $("#"+id);
	var cityOffset = $("#"+id).offset();
	
	$("#"+id_map[id]["div_id"]).css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px",display:"block"}).slideDown("fast");

	$("body").bind("mousedown", onBodyDown);
}
function hideMenu() {
	$(".menuContent").fadeOut("fast");
	$("body").unbind("mousedown", onBodyDown);
}

function onBodyDown(event) 
{	
	if (!(event.target.id == "menuBtn" || $(event.target).parents(".menuContent").length>0)) {
		hideMenu();
	}
}

function multi_select_add(id,nodes)
{
	$.fn.zTree.init($("#"+id), setting, nodes);
}

function multi_select_init(map)
{
	id_map=map;
}
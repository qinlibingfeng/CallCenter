
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
	<META HTTP-EQUIV="Expires" CONTENT="0">

	<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
	<base href="<?php echo $this->config->item('base_url') ?>/"/>

	<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
	<script type="text/javascript" src="www/lib/jquery/jquery-1.5.2.min.js"></script>



	<title>左右布局（右侧定宽，左侧自适应宽）</title>
	<style type="text/css">
		body{font:12px arial;background:#fff;margin:0}

		#header{height:50px;background:#fff;text-align:center;line-height:50px;margin-bottom:10px}

		#side{width:40%;height:400px;background:#fff;float:left;margin-left:10px}

		#content{width:50%;float:left;margin-left:10px}
		#body_content{width:80%;float:center}
		#content_inner{height:400px;background:#fff;margin-right:20px}

		#footer{height:50px;color:#fff;background:#fff;margin-top:10px}
		.clear{clear:both}
	</style>
	
</head>

<body>
<div id="header">
	添加、删除自定义字段后请： <a href='<?php echo site_url('createdatabase/create')?>'>同步数据库</a>
</div>

<div id="body_content">
<div id="side" >
	<div>已存在字段：</div>
	<table id="side_tab" class="dataTable">

	<tr><td><font size="4">字段名</font></td><td><font size="4">操作</font></td></tr>
	<tbody> </tbody>

	</table>
</div>
<div id="content" >
	<div>添加字段：</div>
		<div id="content_inner" border-width:thin; background:yellow;>
		<form mothod="post">

			<table id="content_tab" class="dataTable" border="5px">
				<tr><td><font size="4">字段属性</font></td><td><font size="4">属性值</font></td></tr>
				<tr><td><font size="4">字段名称</font></td><td><input id="client_name" type="text" name="name" value="请输入……" /></td></tr>
				<tr><td><font size="4">字段标题</font></td><td><input id="client_colspan"  type="text" name="colspan" /></td></tr>
				<tr><td><font size="3">字段类型</font></td><td>
				<select name="type" id="client_type">
					<option value="2" selected="">下拉框</option>
					<option value="1">文本编辑框</option>
					<option value="5">文本编译域</option>
					<option value="6">文本地址域</option>

				</select>
				</td></tr>
				<tr><td><font size="4">valuesource</font></td><td><input type="text" name="valuesource" id="client_valuesource" /></td></tr>
				<tr><td><font size="4">字段ID</font></td><td><input id="client_id" type="text" name="id" /></td></tr>
				<tr><td><font size="4">字段存入名</font></td><td><input  id="client_dbfield" type="text" name="dbfield" /></td></tr>
				<tr><td><font size="4">长度</font></td><td><input  id="client_width" type="text" name="width" /></td></tr>
				<tr><td><font size="4">高度</font></td><td><input id="client_height" type="text" name="height" /></td></tr>
				<tr><td><font size="4">lspace</font></td><td><input id="client_lspace" type="text" name="lspace" /></td></tr>
				
				<tr><td colspan="2" align="center"  ><input type="button" value="添加" onclick="add_field()" /></td></tr>
				

				</table>
			  
			</form>
		</div>
</div>
</div>
</body>

<script language="JavaScript">


	$(document).ready(function(){
			display_field(<?php echo json_encode($list);?>);
			
	});
	function display_field(list){ //显示字段名
		$("#side_tab  tr:not(:first)").empty();
		$.each(list, function(index,values){
			var str = '<tr><td><font size="4">'+index.substr(0,index.length-1)+'</font></td>';
			if(values == 'client_cell_phone')
			{
				str += '<td><font size="4">默认字段</font><td></tr>';
			}else{
				str += '<td><a onclick=del_ssh("'+values+'")><font size="4">删除字段</font></a><td></tr>';
			}

			//$("#side_tab tbody").append(str);
			$("#side_tab tr:last").after(str);

		});
	}

	function add_field(){


			if($('#client_name').val() == "" || $('#client_id').val()=="" ||$("#client_dbfield").val()==""){
				alert("请添加必填项！！");
				return 0;
			}
		var req = {'client_name':'','client_id':'','client_type':'','client_colspan':'','client_valuesource':'','client_height':'','client_width':'','client_dbfield':'','client_lspace':''};
		req.client_name =$('#client_name').val();
		req.client_id =$('#client_id').val();
		req.client_type =$("#client_type").val();
		req.client_colspan =$("#client_colspan").val();
		req.client_valuesource =$("#client_valuesource").val();
		req.client_height =$("#client_height").val();
		req.client_width =$("#client_width").val();
		req.client_dbfield =$("#client_dbfield").val();
		req.client_lspace =$("#client_lspace").val();

		var url="<?php echo site_url('communicate/ajaxAddClient')?>";
		$.post(url,req,function(data){

			//alert(data);
			alert(data.res);
			if(data.cont){
				display_field(data.data);
			}

		},"json");

	}
	function del_ssh(value){
		var req = {'client':value};

		var url = "<?php echo site_url('communicate/ajaxDeleteClient')?>";
		$.post(url,req,function(data){
				display_field(data.data);
				},"json");
	}
</script>
</html>






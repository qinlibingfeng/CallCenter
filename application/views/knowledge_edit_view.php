<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>
<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />


<script src="www/js/jquery-1.6.4.js"              type="text/javascript"></script>
<script src="www/js/jquery-impromptu.3.1.min.js"  type="text/javascript"></script>
<script src="www/js/Public.js"                    type="text/javascript"></script>
<script src="www/js/work.js"                      type="text/javascript"></script>

<script charset="utf-8" src="kindeditor-4.0.3/kindeditor.js"></script>
<script charset="utf-8" src="kindeditor-4.0.3/lang/zh_CN.js"></script>
<script>
        var editor;
        KindEditor.ready(function(K) {
                editor = K.create('#editor_id');
        });

$(document).ready(function(){
	$("#doButton").click(function(){
		var req={id:"<?php echo $id;?>",title:'',html:''};
		req.title=$('#title').attr('value');
		req.html=$('#editor_id').text();
	
		$.post("<?php echo site_url('knowledge/ajaxModify')?>",req,function(ret){
					
		});	
	});
});
</script>
</head>
<body>
<div class="page_main page_tops">
    <div class="page_nav">
         <div class="nav_ico"><img src="images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 知识库</div>
         <div class="nav_other"></div>
	</div>
    <div class="func-panel" style="width:100%;height:23px"></div>
	<div class="work-list">
    <?php echo form_open(site_url("knowledge/doModify/".$id)) ?>
    	<table style="margin-left:30px;margin-top:30px;">
        	<tr><td align="center">标题</td><td><input id="title" type="text" name='title'  readonly="readonly"  value="<?php echo isset($title)?$title:'';?>" width="100%"></td></tr>
            <tr><td align="center">内容</td>
            	<td><textarea id="editor_id" name="content" style="width:700px;height:240px;">
                    	<?php  echo isset($html)?$html:"";?>
					</textarea>
                </td>
            </tr>
            <tr><td colspan="2" align="center"><input type="submit"  value="提交"><input type="button" value="返回" onclick='javascript:location.href="<?php echo site_url('notice/look/'.$agentId);?>"'></td></tr>
        </table>
      <?php echo form_close()?>
	</div>
</div>
</body>
</html>
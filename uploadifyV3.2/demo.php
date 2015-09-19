<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script type="text/javascript" src="/CallCenter/www/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="/CallCenter/uploadifyV3.2/jquery.uploadify.js"></script>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
	$("#file_upload").uploadify({
        height        : 30,
        swf           : '/CallCenter/uploadifyV3.2/uploadify.swf',
        uploader      : '/CallCenter/uploadifyV3.2/uploadify.php',
        width         : 100,
		auto		  :true
		
    }); 
 
});
// ]]>
</script>
</head>

<body>
1212
<input id="file_upload" type="file" name="file_upload" />
</body>
</html>
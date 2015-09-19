<html>
<body>
<?php echo $title?>
<?php echo form_open('login/add')?>
<p>用户名：<?php echo form_input('name')?></p>
<p>密码：<?php echo form_password('passwd')?></p>
<p>确认：<?php echo form_password('passwd2')?></p>
<?php echo form_submit('submit','注册')?>
<?php echo form_close()?>
</body>
</html>


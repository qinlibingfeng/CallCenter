<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xHTML1/DTD/xHTML1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xHTML">
<head>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
<title> 东捷科技电话外呼管理系统</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
<base href="<?php echo $this->config->item('base_url') ?>/www/"/>
<link href="css/main.css" rel="stylesheet" type="text/css">
<link rel="icon" href="" mce_href="" type="image/x-icon">
<link rel="shortcut icon" href="" mce_href="" type="image/x-icon">

<style type="text/css">
html{height:100%;}
body{background: url(images/top_bg.jpg) no-repeat center -10px;height:100%}
.login_form{height: 270px;width: 618px;margin-right: auto;margin-left: auto;padding-top: 160px;position: relative;}
.login_form .login_2{background: url(images/login_bg_2.jpg) no-repeat left top;height: 100px;width: 618px;}
.login_form .login_user{float: left;height: 28px;width: 300px;position: relative;background: url(images/login_input_user.jpg) no-repeat left 1px;margin-top: 20px;margin-left:104px;display: inline;text-align: left;padding-left: 2px;padding-top: 2px;}
.login_form .login_pass{float: left;height: 28px;width: 300px;position: relative;background: url(images/login_input_pass.jpg) no-repeat left 1px;margin-top: 6px;margin-left: 104px;display: inline;text-align: left;padding-left: 2px;padding-top: 2px;}
.login_form #username,.login_form #password{font-size: 14px;line-height: 20px;background: #003B65;height: 19px;width: 110px;border-style: none;padding-left: 4px;color: #FFF;}
.login_form .login_3{background: url(images/login_bg_3.jpg) no-repeat left top;height: 56px;width: 558px;padding-left: 60px;padding-top: 4px;}
.login_form .login_sub{float: left;height: 26px;width: 80px;display: inline;margin-right: 14px;}
.login_form .login_foot{background: url(images/login_foot.jpg) no-repeat center top;height: 60px;width: 618px;text-align: center;padding-top: 12px;color: #666;}
.borders{padding:10px;border: 1px solid #aecbd4; height:220px; width:240px;background:#FCFDFE;}
/*.load_layer{right:6px;position: absolute;top:6px;background:#FFFF99;border:1px solid #999;line-height:20px;height: 20px;padding:2px 4px 0 4px; z-index:200;float:left;display:inline;}
.load_layer img{margin-right:4px;margin-top:-2px !important;_margin-top:-1px;}*/
</style>
<script src="lib/jquery.js"></script>


</head>
<body>

<div id="auto_save_res" class="load_layer"></div>

<div class="login_form">
<?php echo form_open('login/log')?>

        <div class="login_1"><img src="images/login_bg_1.jpg" width="618" height="64" /></div>
        <div class="login_2">
        <div class="login_user"><input name="name" id="username" title="请输入您的用户名" maxlength="16" value="admin" /></div>
          <div class="login_pass"><input name="passwd" type="password" id="password" title="请输入您的密码" maxlength="12"/></div>
     </div>

        <div class="login_3">
       	  <div class="login_sub">
       	    <input name="imageField" type="image" id="imageField" src="images/login_sumit.jpg" alt="点击登陆" onclick="fLoginFormSubmit();return false;" />
        	</div>
            <div class="login_sub">
              <input name="reset" type="image" id="reset" src="images/login_reset.jpg" alt="重置取消" onClick="javascript:document.getElementById('form1').reset();return false"/>
            </div>
        
        </div>
        
        <div class="login_foot">CopyRight&copy;2010 - 2011  东捷科技. All Rights Reserved </div>

  </form>

</div>

  
</body>
</html>

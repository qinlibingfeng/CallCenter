<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo base_url()?>www/"/>

<link href="css/main.css" rel="stylesheet" type="text/css">
<style>
.head_menu .logo{float:left;height:34px;width:264px;margin-top:5px;background:url(images/logo_call_out.png) no-repeat left -1px!important;_background-image:none;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/logo_call_out.png',sizingMethod='crop');display:inline;margin-left:4px;cursor:pointer;}
.head_menu .head_info{float:right;height:40px;}
.head_menu .round_{background:url(images/head_menu_bg.png) no-repeat right bottom;float:right;height:32px;margin-top:2px;margin-right:6px;display:inline;position:relative;overflow:hidden;}
.head_menu .round_ .round_main{background:url(images/head_menu_bg.png) no-repeat left top;height:32px;padding-right:4px;float:left;padding-left:4px;}
.head_menu .head_info #callnumber{line-height:18px;height:18px;margin-top:4px;background:#FFF;font-size:14px;}
.head_menu .head_notice_img{float:left;height:22px;width:24px;margin-top:2px;padding-top:4px;}
.head_menu .head_notice{float:left;width:140px;}
.head_menu .head_notice ul{height:28px;overflow:hidden;margin-top:3px;}
.head_menu .head_notice li{line-height:14px;text-align:left;display:inline;float:left;height:14px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:140px;}
.head_menu .head_notice li:after{content:"...";}
.s_option{width:160px; height:20px; margin-top:7px}
</style>
<script src="js/jquery-1.6.4.js" 	type="text/javascript"></script>
<script src="lib/jquery.jgrowl.js" 	type="text/javascript"></script>
<script>
	function onClickMax(){
		window.parent.frames['control'].shift_status();
	}
	
	function logout(){
		window.parent.location="<?php echo site_url('login')?>"
	}
	
	function onClickTransfer(){
		window.parent.frames['mainFrame'].iAddTab('转接坐席',"<?php echo site_url("pbx/transfer/".$agentId)?>");
	}
	
</script>
</head>
<body>
<input name="notic_num" id="notic_num" type="hidden" value=""/>
  
<div id="auto_save_res" class="load_layer"></div>
<div class="head_menu" ondragstart='return false'  >
	<div class="logo" title="首创科技电话外呼管理系统" onClick="tab_frame('index');"></div>
    <div class="head_info">
         
    	 <div class="round_" title="其他信息">
        	<div class="round_main">
           	  <div class="head_notice_img"><img src="images/home.png" alt="返回系统主页" /></div>
              <div style="height:32px;line-height:32px;width:28px;float:left"><a href="javascript:void(0);" onClick="onClickMax();">布局</a></div>
                
           	  <div class="head_notice_img"><img src="images/login_out.png" alt="退出登录" /></div>
              <div style="height:32px;line-height:32px;width:28px;float:left"><a href="javascript:void(0);" onClick="logout();">退出</a></div>  
         	</div>
         </div>      
    	 <div class="round_" title="用户信息">
        	<div class="round_main">
            	<div class="head_notice_img"><img src="images/user_info.png" alt="用户信息" /></div>
                <div class="head_notice">
           	  <ul>
                    	<li>用户名：<a href="javascript:void(0);" title="teltion[admin]"><span id="names"><?php echo isset($user[0]['name'])?$user[0]['name']:'';?></span> [<?php echo isset($user[0]['code'])?$user[0]['code']:'';?>]</a></li>
                    	<li>角&nbsp;&nbsp;&nbsp;色：<a href="javascript:void(0);"><?php echo isset($user[0]['role_name'])?$user[0]['role_name']:'';?> </a></li>
 
                    </ul>
              </div>
                
         	</div>
         </div>
 
    	 <div class="round_" title="操作面板" id="info_list">
            <div class="round_main">
           	  <div class="head_notice_img"><a href="javascript:void(0);"><img src="images/notice.png" alt="返回系统主页" /></a></div>
              <div style="height:32px;line-height:32px;width:28px;float:left"><a href="javascript:void(0);" onClick="onClickMax();">消息</a></div>
             
                
         	</div>
          
         </div>
      
     </div>
</div>
 
</body>
</html>
<script>



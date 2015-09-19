<?php
error_reporting(E_ALL || ~E_NOTICE);

if(!isset($_SESSION)) { 
	session_start(); 
}
 
//清除缓存
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

//编码
header("content-type:text/html;charset=utf-8");

//默认时区  
$cfg_cli_time = 8;
date_default_timezone_set("PRC");
 
//系统信息
$system_name="亚铭科技电话营销管理系统";
$system_version="v2013-08";
$system_company="&copy; 2013-2014 亚铭科技";
$system_copy_year="";
$system_contact="";

//数据库连接
$db_host = "172.17.1.90";
$db_server_ip = "172.17.1.90";

/**************/
$db__port = "";
$db__name = "asterisk";
$db__user = "cron";
$db__pass = "1234";
/**************/ 
 
//服务器数量
$server_count=1; 
$three_server_ip="";
$three_server_type="windows";

//管理后台地址
$admin_server_home = "http://172.17.1.90/default.php";

//AGC后台地址
$agc_server_home = "http://172.17.1.90/agc_cn/vicidial.php";
 
//默认操作系统 windows/centos
$sys_os = "centos";

//是否在质检时将不合格成功改成失败  Y/N
$change_status = "Y";

//是否在坐席页显示呼叫记录tab  Y/N
$show_his_tab = "Y";

//录音文件地址及端口号
if($sys_os=="centos"){
	
 	$record_ip="http://77.36.0.225/RECORDINGS/";
	$record_web="http://77.36.0.225/records/";
	
	$record_location="replace(d.location,'".$record_ip."','".$record_web."') ";
	
	$record_dir_first='/var/spool/asterisk/monitorDONE/';//录音文件首目录
	$record_dir_second='';//录音文件备份目录
	
}else{
	
	$record_ip="192.168.17.253/";
	$record_web="http://192.168.17.253:8006/";	
	$record_location="case when left(d.location,4)='http' then '同步中' else replace(d.location,'".$record_ip."','".$record_web."') end ";
	
	$record_dir_first="E:\\\\records\\\\";//录音文件首目录
	$record_dir_second="";//录音文件备份目录
}

//结束用户的会话状态
function exitUser(){
	 
	session_unregister('username');
	session_unregister('fullname');
	session_unregister('userid');
	session_unregister('user_group');
	//DropCookie('agentid');
	//DropCookie('LoginTime');
	$_SESSION = array();
	session_unset();
    session_destroy();
}

function check_login(){
	 
	if ($_SESSION["username"]==""){
		echo ("<script>setTimeout(\"parent.location.href='/default.php?action=loginout';\",5)</script>");
		die();
	}	
}

//生成日期查询选择框
function select_date($def=""){
	if($def!=""){
		$nowdate="";
	}else{
		$nowdate=date("Y-m-d");
	}
	
 	$str="<input name='begintime' id='begintime' size='13' title='选择开始时间' readonly='readonly' value='$nowdate' onblur='set_Calendar()'/><img src='/images/Calendar.gif' align='absmiddle' vspace='1' style='position:relative; left:-20px; margin-right:-20px; cursor:pointer;' onblur=\"set_Calendar()\"/>\n";
	
	$str.="<select name='s_hour' class='select' id='s_hour'>\n";
 
  	for ($i=0;$i<=23;$i++){
	  $k=substr(100+$i,-2);
	  $str.="<option value='$k'>$k</option>\n";
	}
 
$str.="</select>\n";
$str.="<select  name='s_min' class='select' id='s_min'>\n";
  	for ($i=0;$i<=59;$i++){
		$k=substr(100+$i,-2);
		$str.="<option value='$k'>$k</option>\n";
	}
	
$str.="</select>\n";
$str.="至\n";
$str.="<input name='endtime' id='endtime' size='13' readonly='readonly' title='选择结束时间' value='$nowdate'   onblur='set_Calendar()'/><img src='/images/Calendar.gif' align='absmiddle' vspace='1' style='position:relative; left:-20px; margin-right:-20px; cursor:pointer;' onblur=\"set_Calendar()\" />\n";
$str.="<select name='e_hour' class='select' id='e_hour'>\n";

  	for ($i=23;$i>=0;$i--){
  		$k=substr(100+$i,-2);
  		$str.="<option value='$k'>$k</option>\n";
  	}
	
$str.="</select>\n";
$str.="<select  name='e_min' class='select' id='e_min'>\n";
  
  	for ($i=59;$i>=0;$i--){
  		$k=substr(100+$i,-2);
		$str.="<option value='$k'>$k</option>\n";
  	}
	$str.="</select>\n";
 	echo $str;
}

?>

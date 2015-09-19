
<?php
set_time_limit(60);
ob_implicit_flush(false);

//session_start();
header("Content-type:text/html; charset=UTF-8");
/*
foreach($argv  as $val)
{
	$get_arg[] =$val;
}
*/

//$mobile=$get_arg[1];
//$mobile='05474525343';
$mobile='13176661665';

function Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
}


function xml_to_array($xml){
	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
	if(preg_match_all($reg, $xml, $matches)){
		$count = count($matches[0]);
		for($i = 0; $i < $count; $i++){
		$subxml= $matches[2][$i];
		$key = $matches[1][$i];
			if(preg_match( $reg, $subxml )){
				$arr[$key] = xml_to_array( $subxml );
			}else{
				$arr[$key] = $subxml;
			}
		}
	}
	return $arr;
}
define('BASEPATH', str_replace("\\", "/", '/var/www/html/ccms/CallCenter'));
require("/var/www/html/ccms/CallCenter/application/config/database.php"); 
$server_ip = $db['default']['hostname'];
$server_dbname = $db['default']['database'];
$server_login = $db['default']['username']; 
$server_pass = $db['default']['password'];
	

if(empty($mobile)){
	exit('手机号码不能为空');
}	


echo $server_ip.' '.$server_dbname.' '.$server_login.' '.$server_pass.'<br />';
$linkV=mysql_connect($server_ip, $server_login,$server_pass);
mysql_query(" SET NAMES 'utf8' ");

if (!$linkV) {die("Could not connect: $server_ip|$server_dbname|$server_login|$server_pass" . mysql_error());}
echo "Connected successfully\n<BR>\n";
mysql_select_db("$server_dbname", $linkV);


if(!preg_match("/^1/", $mobile)||  strlen($mobile)!= 11){
	exit('号码不为手机');
}
$mobile_code = substr($mobile,0,7);

$stmt='SELECT count(*), sms_address.sms_address FROM sms_address LEFT JOIN data_code_area  ON sms_address.sms_address_name = data_code_area.area_name WHERE data_code_area.area_code ="'.$mobile_code.'";';

$rslt=mysql_query($stmt, $linkV);	
$row=mysql_fetch_row($rslt);
$found_count = $row[0];

if($found_count  <= 0)
{
	$stmt='SELECT count(*), sms_address.sms_address FROM sms_address WHERE  sms_address_default= "Y"';
	$rslt=mysql_query($stmt, $linkV);		
	$row=mysql_fetch_row($rslt);
	$sms_address = $row[1];
}else{
	
	$sms_address = $row[1];
}


$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";

$mobile_code = 11111;

/*
if(empty($_SESSION['send_code']) or $send_code!=$_SESSION['send_code']){
	//防用户恶意请求
	exit('请求超时，请刷新页面后重试');
}
*/
//$post_data = "account=cf_djie&password=75f68964718d2213f010f345135422d4&mobile=".$mobile."&content=".$sms_address;

$post_data = "account=cf_djie&password=75f68964718d2213f010f345135422d4&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
//密码可以使用明文密码或使用32位MD5加密
echo $post_data;

$gets =  xml_to_array(Post($post_data, $target));

echo $gets['SubmitResult']['msg'];


?>
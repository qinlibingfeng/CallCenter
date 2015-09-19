<?php
require("config.ini.php");
 
/*if($db__port==""){*/
	$databa_ymkj__port = "";
/*}else{
	$databa_ymkj__port = $db__port;
}
*/
if($db__name==""){
	$databa_ymkj__name = "asterisk";
}else{
	$databa_ymkj__name = $db__name;
}
 
if($db__user==""){
	$databa_ymkj__user = "cron";
}else{
	$databa_ymkj__user = $db__user;
}

if($db__pass==""){
	$databa_ymkj__pass = "1234";
}else{
	$databa_ymkj__pass = $db__pass;
}
  
//数据库
$db_conn = mysqli_connect("$db_host$databa_ymkj__port", "$databa_ymkj__user", "$databa_ymkj__pass");

if (!$db_conn) {
    $json_data = "{";
    $json_data .= "\"counts\":\"0\",";
    $json_data .= "\"des\":" . json_encode("数据库连接错误:".mysqli_connect_error()) . "";
    $json_data .= "}";
    
    echo $json_data;
	
    die();
} 
mysqli_select_db($db_conn, $databa_ymkj__name);
mysqli_query($db_conn, "SET NAMES utf8");

//禁止 session.auto_start

/*if ( ini_get('session.auto_start') != 0 )
{
exit('<a href="session_auto_start">php.ini session.auto_start must is 0 ! </a>');
}

//检查和注册外部提交的变量
foreach($_REQUEST as $_k=>$_v){

if( strlen($_k)>0 && eregi('^(cfg_|GLOBALS)',$_k) ){
exit('Request var not allow!');
}
}
*/

//是否启用mb_substr替换cn_substr来提高效率
function _RunMagicQuotes(&$svar){
    if (!get_magic_quotes_gpc()) {
        if (is_array($svar)) {
            foreach ($svar as $_k => $_v)
                $svar[$_k] = _RunMagicQuotes($_v);
        } else {
            $svar = addslashes($svar);
        }
    }
    return $svar;
}

//获得当前的脚本网址
function GetCurUrl(){
    if (!empty($_SERVER["REQUEST_URI"])) {
        $scriptName = $_SERVER["REQUEST_URI"];
        $nowurl     = $scriptName;
    } else {
        $scriptName = $_SERVER["PHP_SELF"];
        if (empty($_SERVER["QUERY_STRING"])) {
            $nowurl = $scriptName;
        } else {
            $nowurl = $scriptName . "?" . $_SERVER["QUERY_STRING"];
        }
    }
    return $nowurl;
}

//获取半角字符
function GetAlabNum($fnum){
    $nums  = array(
        "０",
        "１",
        "２",
        "３",
        "４",
        "５",
        "６",
        "７",
        "８",
        "９"
    );
    //$fnums = "0123456789";
    $fnums = array(
        "0",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9"
    );
    $fnum  = str_replace($nums, $fnums, $fnum);
    $fnum  = ereg_replace("[^0-9\.-]", '', $fnum);
    if ($fnum == '') {
        $fnum = 0;
    }
    return $fnum;
}


//文本转HTML
function Text2Html($txt){
    $txt = str_replace("  ", "　", $txt);
    $txt = str_replace("<", "&lt;", $txt);
    $txt = str_replace(">", "&gt;", $txt);
    $txt = preg_replace("/[\r\n]{1,}/isU", "<br/>\r\n", $txt);
    return $txt;
}

//中文截取2，单字节截取模式
//如果是request的内容，必须使用这个函数
function cn_substrR($str, $slen, $startdd = 0){
    $str = cn_substr(stripslashes($str), $slen, $startdd);
    return addslashes($str);
}

//中文截取2，单字节截取模式
function cn_substr($str, $slen, $startdd = 0){
    global $cfg_soft_lang;
    if ($cfg_soft_lang == 'utf-8') {
        return cn_substr_utf8($str, $slen, $startdd);
    }
    $restr   = '';
    $c       = '';
    $str_len = strlen($str);
    if ($str_len < $startdd + 1) {
        return '';
    }
    if ($str_len < $startdd + $slen || $slen == 0) {
        $slen = $str_len - $startdd;
    }
    $enddd = $startdd + $slen - 1;
    for ($i = 0; $i < $str_len; $i++) {
        if ($startdd == 0) {
            $restr .= $c;
        } else if ($i > $startdd) {
            $restr .= $c;
        }
        
        if (ord($str[$i]) > 0x80) {
            if ($str_len > $i + 1) {
                $c = $str[$i] . $str[$i + 1];
            }
            $i++;
        } else {
            $c = $str[$i];
        }
        
        if ($i >= $enddd) {
            if (strlen($restr) + strlen($c) > $slen) {
                break;
            } else {
                $restr .= $c;
                break;
            }
        }
    }
    return $restr;
}


//utf-8中文截取，单字节截取模式
function cn_substr_utf8($str, $length, $start = 0){
    if (strlen($str) < $start + 1) {
        return '';
    }
    preg_match_all("/./su", $str, $ar);
    $str  = '';
    $tstr = '';
    
    //为了兼容mysql4.1以下版本,与数据库varchar一致,这里使用按字节截取
    for ($i = 0; isset($ar[0][$i]); $i++) {
        if (strlen($tstr) < $start) {
            $tstr .= $ar[0][$i];
        } else {
            if (strlen($str) < $length + strlen($ar[0][$i])) {
                $str .= $ar[0][$i];
            } else {
                break;
            }
        }
    }
    return $str;
}


function FloorTime($seconds){
    $times   = '';
    $days    = floor(($seconds / 86400) % 30);
    $hours   = floor(($seconds / 3600) % 24);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = floor($seconds % 60);
    if ($seconds >= 1)
        $times .= $seconds . '秒';
    if ($minutes >= 1)
        $times = $minutes . '分钟 ' . $times;
    if ($hours >= 1)
        $times = $hours . '小时 ' . $times;
    if ($days >= 1)
        $times = $days . '天';
    if ($days > 30)
        return false;
    $times .= '前';
    return str_replace(" ", '', $times);
}

//获取loadiden
function getiden($agentid){
    if ($agentid == '') {
        $agentid = '0';
    }
    
    //$now_time=str_replace(' ','',str_replace(':','',str_replace('-','',date('Y-m-d H:m:s'))));
    $now_time = date("YmdHis");
    $now_time = $agentid . '-' . $now_time . '-' . rand(10000, 99999);
    
    return $now_time;
    
}

//
function GetIP(){
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if (!empty($_SERVER["REMOTE_ADDR"])) {
        $cip = $_SERVER["REMOTE_ADDR"];
    } else {
        $cip = '';
    }
    preg_match("/[\d\.]{7,15}/", $cip, $cips);
    $cip = isset($cips[0]) ? $cips[0] : 'unknown';
    unset($cips);
    return $cip;
}

function ExecTime(){
    $time = explode(" ", microtime());
    $usec = (double) $time[0];
    $sec  = (double) $time[1];
    return $sec + $usec;
}

function PutCookie($key, $value, $kptime = 0, $pa = "/"){
    global $cfg_cookie_encode;
    setcookie($key, $value, time() + $kptime, $pa);
    setcookie($key . '__ckMd5', substr(md5($cfg_cookie_encode . $value), 0, 16), time() + $kptime, $pa);
}

function DropCookie($key){
    setcookie($key, '', time() - 360000, "/");
    setcookie($key . '__ckMd5', '', time() - 360000, "/");
}


function GetCookie($key){
    global $cfg_cookie_encode;
    if (!isset($_COOKIE[$key]) || !isset($_COOKIE[$key . '__ckMd5'])) {
        return '';
    } else {
        if ($_COOKIE[$key . '__ckMd5'] != substr(md5($cfg_cookie_encode . $_COOKIE[$key]), 0, 16)) {
            return '';
        } else {
            return $_COOKIE[$key];
        }
    }
}


// $rptype = 0 表示仅替换 html标记
// $rptype = 1 表示替换 html标记同时去除连续空白字符
// $rptype = 2 表示替换 html标记同时去除所有空白字符
// $rptype = -1 表示仅替换 html危险的标记
function HtmlReplace($str, $rptype = 0){
    $str = stripslashes($str);
    
    if ($rptype == 0) {
        $str = htmlspecialchars($str);
    } else if ($rptype == 1) {
        $str = htmlspecialchars($str);
        $str = str_replace("　", ' ', $str);
        $str = ereg_replace("[\r\n\t ]{1,}", ' ', $str);
    } else if ($rptype == 2) {
        $str = htmlspecialchars($str);
        $str = str_replace("　", '', $str);
        $str = ereg_replace("[\r\n\t ]", '', $str);
    } else if ($rptype == 3) {
        //$str = htmlspecialchars($str);
        //$str = str_replace("　",'',$str);
        $str = str_replace("<br/>", chr(10), $str);
        $str = str_replace("'", "’", $str);
    } else {
        $str = ereg_replace("[\r\n\t ]{1,}", ' ', $str);
        $str = eregi_replace('script', 'ｓｃｒｉｐｔ', $str);
        $str = eregi_replace("<[/]{0,1}(link|meta|ifr|fra)[^>]*>", '', $str);
        //$str = str_replace("<br/>",chr(10),$str);
    }
    return addslashes($str);
}

//UTF-8 转GB编码
function utf82gb($utfstr){
    if (function_exists('iconv')) {
        return iconv('utf-8', 'gbk//ignore', $utfstr);
    }
    global $UC2GBTABLE;
    $okstr = "";
    if (trim($utfstr) == "") {
        return $utfstr;
    }
    if (empty($UC2GBTABLE)) {
        $filename = "./data/gb2312-utf8.dat";
        $fp       = fopen($filename, "r");
        while ($l = fgets($fp, 15)) {
            $UC2GBTABLE[hexdec(substr($l, 7, 6))] = hexdec(substr($l, 0, 6));
        }
        fclose($fp);
    }
    $okstr = "";
    $ulen  = strlen($utfstr);
    for ($i = 0; $i < $ulen; $i++) {
        $c  = $utfstr[$i];
        $cb = decbin(ord($utfstr[$i]));
        if (strlen($cb) == 8) {
            $csize = strpos(decbin(ord($cb)), "0");
            for ($j = 0; $j < $csize; $j++) {
                $i++;
                $c .= $utfstr[$i];
            }
            $c = utf82u($c);
            if (isset($UC2GBTABLE[$c])) {
                $c = dechex($UC2GBTABLE[$c] + 0x8080);
                $okstr .= chr(hexdec($c[0] . $c[1])) . chr(hexdec($c[2] . $c[3]));
            } else {
                $okstr .= "&#" . $c . ";";
            }
        } else {
            $okstr .= $c;
        }
    }
    $okstr = trim($okstr);
    return $okstr;
}

//GB转UTF-8编码
function gb2utf8($gbstr){
    if (function_exists('iconv')) {
        return iconv('gbk', 'utf-8//ignore', $gbstr);
    }
    global $CODETABLE;
    if (trim($gbstr) == "") {
        return $gbstr;
    }
    if (empty($CODETABLE)) {
        $filename = "./data/gb2312-utf8.dat";
        $fp       = fopen($filename, "r");
        while ($l = fgets($fp, 15)) {
            $CODETABLE[hexdec(substr($l, 0, 6))] = substr($l, 7, 6);
        }
        fclose($fp);
    }
    $ret  = "";
    $utf8 = "";
    while ($gbstr != '') {
        if (ord(substr($gbstr, 0, 1)) > 0x80) {
            $thisW = substr($gbstr, 0, 2);
            $gbstr = substr($gbstr, 2, strlen($gbstr));
            $utf8  = "";
            @$utf8 = u2utf8(hexdec($CODETABLE[hexdec(bin2hex($thisW)) - 0x8080]));
            if ($utf8 != "") {
                for ($i = 0; $i < strlen($utf8); $i += 3)
                    $ret .= chr(substr($utf8, $i, 3));
            }
        } else {
            $ret .= substr($gbstr, 0, 1);
            $gbstr = substr($gbstr, 1, strlen($gbstr));
        }
    }
    return $ret;
}

//编码转换
function escape($str){
    preg_match_all("/[x80-xff].|[x01-x7f]+/", $str, $r);
    $ar = $r[0];
    foreach ($ar as $k => $v) {
        if (ord($v[0]) < 128)
            $ar[$k] = rawurlencode($v);
        else
            $ar[$k] = "%u" . bin2hex(iconv("UTF-8", "UCS-2", $v));
    }
    return join("", $ar);
}

//过滤用于搜索的字符串
function FilterSearch($keyword){
    global $cfg_soft_lang;
    if ($cfg_soft_lang == 'utf-8') {
        $keyword = ereg_replace("[\"\r\n\t\$\\><']", '', $keyword);
        if ($keyword != stripslashes($keyword)) {
            return '';
        } else {
            return $keyword;
        }
    } else {
        $restr = '';
        for ($i = 0; isset($keyword[$i]); $i++) {
            if (ord($keyword[$i]) > 0x80) {
                if (isset($keyword[$i + 1]) && ord($keyword[$i + 1]) > 0x40) {
                    $restr .= $keyword[$i] . $keyword[$i + 1];
                    $i++;
                } else {
                    $restr .= ' ';
                }
            } else {
                if (eregi("[^0-9a-z@#\.]", $keyword[$i])) {
                    $restr .= ' ';
                } else {
                    $restr .= $keyword[$i];
                }
            }
        }
    }
    return $restr;
}

//处理禁用HTML但允许换行的内容
function TrimMsg($msg){
    $msg = trim(stripslashes($msg));
    $msg = nl2br(htmlspecialchars($msg));
    $msg = str_replace("  ", "&nbsp;&nbsp;", $msg);
    return addslashes($msg);
}


//邮箱格式检查
function CheckEmail($email){
    return eregi("^[0-9a-z][a-z0-9\._-]{1,}@[a-z0-9-]{1,}[a-z0-9]\.[a-z\.]{1,}[a-z]$", $email);
}

function encodeUTF8($array){
    foreach ($array as $key => $value) {
        if (!is_array($value)) {
            $array[$key] = mb_convert_encoding($value, "UTF-8", "GBK");
        } else {
            encodeUTF8($array[$key]);
        }
    }
    return $array;
}

//时间格式化
function format_date($STRING1){
    $STRING1 = str_replace("-0", "-", $STRING1);
    $STR     = strtok($STRING1, "-");
    $STRING2 = $STR . "年";
    $STR     = strtok("-");
    $STRING2 .= $STR . "月";
    $STR = strtok(" ");
    $STRING2 .= $STR . "日";
    return $STRING2;
}

function format_date_short1($STRING1){
    $STRING1 = str_replace("-0", "-", $STRING1);
    $STR     = strtok($STRING1, "-");
    $STRING2 = $STR . "年";
    $STR     = strtok("-");
    $STRING2 .= $STR . "月";
    return $STRING2;
}

function format_date_short2($STRING1){
    $STRING1 = str_replace("-0", "-", $STRING1);
    $STR     = strtok($STRING1, "-");
    $STR     = strtok("-");
    $STRING2 .= $STR . "月";
    $STR = strtok(" ");
    $STRING2 .= $STR . "日";
    return $STRING2;
}

function get_week($STRING1){
    $STR   = strtok($STRING1, "-");
    $YEAR  = $STR;
    $STR   = strtok("-");
    $MONTH = $STR;
    $STR   = strtok(" ");
    $DAY   = $STR;
    $TIME1 = mktime(0, 0, 0, $MONTH, $DAY, $YEAR);
    switch (date("w", $TIME1)) {
        case 0:
            return "日";
        case 1:
            return "一";
        case 2:
            return "二";
        case 3:
            return "三";
        case 4:
            return "四";
        case 5:
            return "五";
        case 6:
            return "六";
    }
}

function format_money($STR){
    if ($STR == "") {
        return "";
    }
    if ($STR == ".00") {
        return "0.00";
    }
    $TOK = strtok($STR, ".");
    if (strcmp($STR, $TOK) == "0") {
        $STR .= ".00";
    } else {
        $TOK = strtok(".");
        $I   = 1;
        for (; $I <= 2 - strlen($TOK); ++$I) {
            $STR .= "0";
        }
    }
    if (substr($STR, 0, 1) == ".") {
        $STR = "0" . $STR;
    }
    return $STR;
}

//创建录音备份存放目录
function create_record_dir($job_id, $job_name){
    $job_id_dir = "./data/record/" . date("Ymd");
    $dir        = $job_id_dir . "/" . utf82gb($job_name);
    if (!is_dir($job_id_dir)) {
        mkdir($job_id_dir, 0777);
    }
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    } else {
        deldir($dir);
        mkdir($dir, 0777);
    }
    
    return $dir;
}

//创建EXCEL存放目录
function create_dir(){
    $year_dir  = "./data/down/" . date("Y");
    $month_dir = $year_dir . "/" . date("m");
    $day_dir   = $month_dir . "/" . date("d");
    
    if (!is_dir($year_dir)) {
        mkdir($year_dir, 0777);
    }
    if (!is_dir($month_dir)) {
        mkdir($month_dir, 0777);
    }
    if (!is_dir($day_dir)) {
        mkdir($day_dir, 0777);
    }
    return $day_dir;
}
//删除文件夹及其目录下文件
function deldir($dir){
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }
    
    closedir($dh);
    
    if (rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}


//获取Excel路径
function excel_file($file_name, $file_type = "xls"){
   
    $date_path = create_dir() . "/";
    $filename  = iconv("utf-8", "gb2312", $file_name);
    $filename  = $filename . date("YmdHis") . "." . $file_type;
    $file_path = $date_path . $filename;
    $file_arr  = array(
        $filename,
        $date_path,
        $file_path
    );
    return $file_arr;
}

//$file_type xls excel_2003;txt 文本文档;Default xls
function save_detail_excel($sql, $file_name, $file_type = "xls"){
    global $db_conn;
    if ($sql <> "") {
        set_time_limit(0);
        ini_set('memory_limit', '600M');
        $rows            = mysqli_query($db_conn, $sql);
        $row_counts_list = mysqli_num_rows($rows);
        $field_count     = mysqli_num_fields($rows);
        $fields          = mysqli_fetch_fields($rows);
        
        if ($row_counts_list != 0) {
            //文档类型
            if ($file_type == "xls") {
                //记录集个数小于2000，使用phpexcel生成xls
                
                /*if ($row_counts_list<2000 and $field_count<12) {
                include("../plugin/excel.php");
                //当前活动表
                $objPHPExcel->setActiveSheetIndex(0);
                //sheet表名
                $objPHPExcel->getActiveSheet()->setTitle("".$file_name."");
                $field_count2=$field_count-1;
                $objPHPExcel->getActiveSheet()->setSharedStyle($excel_tit_left, "A1:$tit_arr[$field_count2]1");	
                $objPHPExcel->getActiveSheet()->setSharedStyle($excel_list_left, "A2:$tit_arr[$field_count2]".($row_counts_list+1));
                for ($i=0;$i<$field_count;$i++){
                $objPHPExcel->getActiveSheet()->setCellValue("$tit_arr[$i]1","".$fields[$i]->name."");
                }
                $i=1;
                while($rs= mysqli_fetch_array($rows)){ 
                $i+=1;
                for ($k=0;$k<$field_count;$k++){
                
                $objPHPExcel->getActiveSheet()->getCell($tit_arr[$k].$i)->setValueExplicit($rs[$k], PHPExcel_Cell_DataType::TYPE_STRING);
                
                }
                //if($i%100==0){
                //	ob_flush();
                //	flush();
                //}
                }
                $objPHPExcel->setActiveSheetIndex(0);
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $file_path=excel_file("".$file_name."_","xls");
                $objWriter->save(str_replace('.php', '.xls',$file_path[2]));
                
                }else{*/
                //记录集个数大于2000，使用XML生成xls
                include("Spreadsheet/Excel/Writer.php");
                $file_path = excel_file("" . $file_name . "_", "xls");
                $workbook  = new Spreadsheet_Excel_Writer($file_path[2]);
                $workbook->setCustomColor(20, 146, 208, 80);
                $format_title_sty =& $workbook->addformat(array(
                    'Size' => 10,
                    'Bold' => 1,
                    'Border' => 1,
                    'FgColor' => 20,
                    'FontFamily' => utf82gb("宋体")
                ));
                $format_cont_sty =& $workbook->addformat(array(
                    'Size' => 10,
                    'Border' => 1,
                    'FontFamily' => utf82gb("宋体")
                ));
                
                $sheet_rows = 40000; //单Sheet记录集个数
                $sheet_id   = 0;
                $i          = 0;
                $sheet_i    = 0;
                
                while ($rs = mysqli_fetch_array($rows)) {
                    $i++;
                    $sheet_i++;
                    $row_ = $i % $sheet_rows;
                    
                    if ($row_ == 1) {
                        if ($row_counts_list < $sheet_rows + 1) {
                            $sheet_id = "";
                        } else {
                            $sheet_id++;
                        }
                        $sheets =& $workbook->addWorksheet("" . utf82gb($file_name . $sheet_id) . "");
                        
                        for ($f = 0; $f < $field_count; $f++) {
                            $sheets->writeString(0, $f, utf82gb($fields[$f]->name), $format_title_sty);
                        }
                        $sheet_i = 1;
                    }
                    
                    for ($k = 0; $k < $field_count; $k++) {
                        $sheets->writeString($sheet_i, $k, utf82gb($rs[$k]), $format_cont_sty);                       
                    }
                }
                $workbook->close();
                //}		
                
            } elseif ($file_type == "xml_xls") {
                $file_type = "xls";
                $file_path = excel_file("" . $file_name . "_", $file_type);
                $fp        = fopen($file_path[2], "w");
                
                $sheet_rows = 40000; //单Sheet记录集个数
                
                $xml_head = "<?xml version=\"1.0\"?>\n<?mso-application progid=\"Excel.Sheet\"?>\n<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\"><DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\"><Title>详单数据导出</Title><Author>亚铭科技</Author><Category>详单、汇总</Category>\n<Company>亚铭科技</Company></DocumentProperties>\n<OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\"><AllowPNG/> <RemovePersonalInformation/></OfficeDocumentSettings><ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\"> <WindowHeight>8010</WindowHeight><WindowWidth>14805</WindowWidth><WindowTopX>240</WindowTopX><WindowTopY>105</WindowTopY>\n<ProtectStructure>False</ProtectStructure><ProtectWindows>False</ProtectWindows></ExcelWorkbook>\n<Styles>\n<Style ss:ID=\"Default\" ss:Name=\"Normal\"><Alignment ss:Vertical=\"Bottom\"/><Borders/><Font ss:FontName=\"宋体\" x:CharSet=\"134\" ss:Size=\"10\" ss:Color=\"#000000\"/><Interior/><NumberFormat/><Protection/></Style><Style ss:ID=\"s71\"><Alignment ss:Vertical=\"Center\"/><Borders><Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/><Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/><Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/><Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/></Borders><Font ss:FontName=\"宋体\" x:CharSet=\"134\" ss:Color=\"#000000\"/><NumberFormat ss:Format=\"@\"/></Style><Style ss:ID=\"s72\"><Alignment ss:Vertical=\"Center\"/><Borders>\n<Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/><Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>\n <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/><Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/></Borders><Font ss:FontName=\"宋体\" x:CharSet=\"134\" ss:Color=\"#000000\" ss:Bold=\"1\"/> <Interior ss:Color=\"#92D050\" ss:Pattern=\"Solid\"/><NumberFormat ss:Format=\"@\"/></Style></Styles>";
                
                fwrite($fp, $xml_head);
                
                for ($i = 0; $i < $field_count; $i++) {
                    $filed_list .= "<Cell ss:StyleID=\"s72\"><Data ss:Type=\"String\">" . $fields[$i]->name . "</Data></Cell>";
                }
                $xml_sheet_head_row = "<Row>" . $filed_list .= "</Row>";
                
                $i        = 0;
                $sheet_id = 0;
                
                while ($rs = mysqli_fetch_array($rows)) {
                    $i++;
                    $style  = "";
                    $f_list = "";
                    $row_   = $i % $sheet_rows;
                    
                    if ($row_ == 1) {
                        if ($row_counts_list < $sheet_rows + 1) {
                            $sheet_id = "";
                        } else {
                            $sheet_id++;
                        }
                        
                        fwrite($fp, "\n<Worksheet ss:Name=\"" . $file_name . $sheet_id . "\">\n<Table x:FullRows=\"1\"  ss:DefaultRowHeight=\"15\">" . $xml_sheet_head_row);
                        ob_flush();
                        flush();
                    }
                    
                    for ($k = 0; $k < $field_count; $k++) {
                        $f_list .= "<Cell ss:StyleID=\"s71\"><Data ss:Type=\"String\">" . $rs[$k] . "</Data></Cell>";
                    }
                    
                    fwrite($fp, "<Row>" . $f_list . "</Row>");
                    
                    if ($row_ == 0) {
                        fwrite($fp, "</Table>\n<WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\"><Unsynced/><Print><ValidPrinterInfo/>\n<PaperSizeIndex>9</PaperSizeIndex>\n<HorizontalResolution>-3</HorizontalResolution><VerticalResolution>0</VerticalResolution></Print><Selected/><Panes><Pane><Number>3</Number><ActiveCol>1</ActiveCol></Pane></Panes><ProtectObjects>False</ProtectObjects><ProtectScenarios>False</ProtectScenarios></WorksheetOptions></Worksheet>\n\n");
                        
                    }
                    
                }
                
                if ($row_ < $sheet_rows) {
                    fwrite($fp, "</Table>\n<WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\"><Unsynced/><Print><ValidPrinterInfo/>\n<PaperSizeIndex>9</PaperSizeIndex>\n<HorizontalResolution>-3</HorizontalResolution><VerticalResolution>0</VerticalResolution></Print><Selected/><Panes><Pane><Number>3</Number><ActiveCol>1</ActiveCol></Pane></Panes><ProtectObjects>False</ProtectObjects><ProtectScenarios>False</ProtectScenarios></WorksheetOptions></Worksheet>\n\n");
                }
                
                fwrite($fp, "</Workbook>");
                fclose($fp);
                
                unset($xml_head);
                unset($filed_list);
                unset($f_list);
                
            } elseif ($file_type == "csv") {
                //生成Csv文档
                $file_path = excel_file("" . $file_name . "_", $file_type);
                $fp        = fopen($file_path[2], "w");
                
                for ($i = 0; $i < $field_count; $i++) {
                    $filed_list .= $fields[$i]->name . ",";
                }
                fwrite($fp, utf82gb($filed_list) . "\n");
                
                $i = 1;
                while ($rs = mysqli_fetch_array($rows)) {
                    $f_list = "";
                    $i++;
                    for ($k = 0; $k < $field_count; $k++) {
                        $f_list .= $rs[$k] . ",";
                    }
                    $row_list = $f_list . "\n";
                    
                    fwrite($fp, utf82gb($row_list));
                    
                    if ($i % 100 == 0) {
                        ob_flush();
                        flush();
                    }
                }
                fclose($fp);
                
                unset($f_list);
                unset($row_list);
                
            } elseif ($file_type == "txt_n") {
                $file_path = excel_file("" . $file_name . "_", "txt");
                $fp        = fopen($file_path[2], "w");
                
                
                $filed_list = "C011|130002|861300005101|dxhbfc|客户姓名|客户姓别|客户生日|客户手机号|销售日期|0|职业";
                
                fwrite($fp, utf82gb($filed_list) . "\r\n");
                
                $i = 1;
                while ($rs = mysqli_fetch_array($rows)) {
                    $f_list = "";
                    $i++;
                    for ($k = 0; $k < $field_count; $k++) {
                        $f_list .= $rs[$k] . "|";
                    }
                    
                    $row_list = substr($f_list, 0, -1) . "\r\n";
                    
                    fwrite($fp, utf82gb($row_list));
                    
                    if ($i % 100 == 0) {
                        ob_flush();
                        flush();
                    }
                    
                }
                fclose($fp);
                
                unset($f_list);
                unset($row_list);
                
            } else {
                //生成TXT文档
                $file_path = excel_file("" . $file_name . "_", $file_type);
                $fp        = fopen($file_path[2], "w");
                
                for ($i = 0; $i < $field_count; $i++) {
                    $filed_list .= $fields[$i]->name . "\t";
                }
                fwrite($fp, utf82gb($filed_list) . "\r\n");
                
                $i = 1;
                while ($rs = mysqli_fetch_array($rows)) {
                    $f_list = "";
                    $i++;
                    for ($k = 0; $k < $field_count; $k++) {
                        $f_list .= $rs[$k] . "\t";
                    }
                    $row_list = $f_list . "\r\n";
                    
                    fwrite($fp, utf82gb($row_list));
                    
                    if ($i % 100 == 0) {
                        ob_flush();
                        flush();
                    }
                    
                }
                fclose($fp);
                
                unset($f_list);
                unset($row_list);
            }
            
            $do_res = array(
                "counts" => "1",
                "file_path" => gb2utf8(str_replace("./data/", "/data/", $file_path[1])),
                "file_name" => gb2utf8($file_path[0]),
                "des" => "文件导出完成，请点击下载！"
            );
            
        } else {
            $do_res = array(
                "counts" => "0",
                "file_path" => "",
                "file_name" => "",
                "des" => "未找到符合条件的数据..."
            );
        }
    } else {
        $do_res = array(
            "counts" => "-1",
            "file_path" => "",
            "file_name" => "",
            "des" => "数据查询条件有误，请检查后重试..."
        );
    }
    return $do_res;
    mysqli_free_result($rows);
}

//录音备份名称规则
function record_type($phone, $user, $call_date, $cid, $type){
	
    $yyyy = date("Y", strtotime($call_date));
    $mm   = substr(100 + date("m", strtotime($call_date)), -2);
    $dd   = substr(100 + date("d", strtotime($call_date)), -2);
    $hh   = substr(100 + date("H", strtotime($call_date)), -2);
    $mi   = substr(100 + date("i", strtotime($call_date)), -2);
    $ss   = substr(100 + date("s", strtotime($call_date)), -2);
    
    $type = str_replace("user", $user, $type);
    $type = str_replace("phone", $phone, $type);
    $type = str_replace("yyyy", $yyyy, $type);
    $type = str_replace("mm", $mm, $type);
    $type = str_replace("dd", $dd, $type);
    $type = str_replace("hh", $hh, $type);
    $type = str_replace("mi", $mi, $type);
    $type = str_replace("ss", $ss, $type);
	$type = str_replace("cid", $cid, $type);
    
    return $type;
    unset($type);
}

//获取用户资料Sesion
function re_info($info, $phone_number, $is_re = "n"){
    global $ask_list_ary;
    $field_n_a = array();
    $field_v_a = array();
    
    $field_n_a2 = array();
    $field_v_a2 = array();
    
    if ($is_re == "y") {
        foreach ($ask_list_ary as $field_v => $field_n) {
            array_push($field_n_a, "--" . $field_n . "--");
            if ($field_n == "换行符") {
                array_push($field_v_a, "<br/>");
            }else if($field_n == "电话号码"){
                array_push($field_v_a, "&nbsp;<span class=\"red f_p_n\">" . $_SESSION[$field_v . "_" . $phone_number] . "</span>&nbsp;");
            }else{
                array_push($field_v_a, "&nbsp;<span class=\"red\">" . $_SESSION[$field_v . "_" . $phone_number] . "</span>&nbsp;");
            }
        }
        
        $info = str_replace($field_n_a, $field_v_a, $info);
        
    } else {
        foreach ($ask_list_ary as $field_v => $field_n) {
            array_push($field_n_a2, "--" . $field_n . "--");
            //if($field_n=="换行符"){
            //array_push($field_v_a2,"<br/>");
            //}else{
            array_push($field_v_a2, "&nbsp;<span class=\"red\">--" . $field_n . "--</span>&nbsp;");
            //}
        }
        
        $info = str_replace($field_n_a2, $field_v_a2, $info);
    }
    return $info;
    
    unset($field_n_a2);
    unset($field_v_a2);
    unset($field_n_a);
    unset($field_v_a);
}


//公共查询变量
$action     = strtolower(trim($_REQUEST["action"]));
$do_actions = trim($_REQUEST["do_actions"]);
$actions    = trim($_REQUEST["actions"]);

$phone_number = trim($_REQUEST["phone_number"]);
$telno        = trim($_REQUEST["telno"]);
$campaign_id  = trim($_REQUEST["campaign_id"]);
$status       = trim($_REQUEST["status"]);
$agentid      = trim($_REQUEST["agentid"]);
$comments     = trim($_REQUEST["comments"]);
$agent_list   = trim($_REQUEST["agent_list"]);
$phone_login  = trim($_REQUEST["phone_login"]);
$cid          = trim($_REQUEST["c_id"]);
$time_len     = trim($_REQUEST["time_len"]);
$time_zone    = trim($_REQUEST["time_zone"]);
$exists       = trim($_REQUEST["exists"]);

$quality_status = trim($_REQUEST["quality_status"]);

$uniqueid      = trim($_REQUEST["uniqueid"]);
$vicidial_id   = trim($_REQUEST["vicidial_id"]);
$user          = trim($_REQUEST["user"]);
$lead_id       = trim($_REQUEST["lead_id"]);
$list_id       = trim($_REQUEST["list_id"]);
$campaign_name = gb2utf8(trim($_REQUEST["campaign_name"]));
$qualitydes    = trim($_REQUEST["qualitydes"]);
$quserid       = trim($_REQUEST["quserid"]);
$call_des  = trim($_REQUEST["call_des"]);

$pages    = trim($_REQUEST["pages"]);
$sorts    = trim($_REQUEST["sorts"]);
$order    = trim($_REQUEST["order"]);
$pagesize = trim($_REQUEST["pagesize"]);

if (!$pagesize || !is_numeric($pagesize)) {
    $pagesize = 15;
}
if (!$pages || !is_numeric($pages)) {
    $pages = 1;
}
if (!$order) {
    $order = "desc";
}
if ($sorts != "") {
    $sort_sql = " order by " . $sorts . " " . $order . " ";
} else {
    $sort_sql = "";
}

$today = date("Y-m-d");

$s_date = trim($_REQUEST["begintime"]);
$s_hour = trim($_REQUEST["s_hour"]);
$s_min  = trim($_REQUEST["s_min"]);
$e_date = trim($_REQUEST["endtime"]);
$e_hour = trim($_REQUEST["e_hour"]);
$e_min  = trim($_REQUEST["e_min"]);

$full_name   = trim($_REQUEST["full_name"]);
$phone_lists = trim($_REQUEST["phone_lists"]);
$city        = trim($_REQUEST["city"]);

$search_accuracy = trim($_REQUEST["search_accuracy"]);

$start_date = $s_date . " " . $s_hour . ":" . $s_min . ":00";
$end_date   = $e_date . " " . $e_hour . ":" . $e_min . ":59";

if ($s_date == "" && $e_date == "") {
    $start_date = $today . " 00:00:01";
    $end_date   = $today . " 23:59:59";
}

$username     = trim($_REQUEST["username"]);
$userpass     = trim($_REQUEST["userpass"]);
$quality_user = trim($_REQUEST["quality_user"]);

//录音备份
$job_name = utf82gb(trim($_REQUEST["job_name"]));
$job_id   = trim($_REQUEST["job_id"]);
$phones   = trim($_REQUEST["phones"]);

//判断是否为月统计
$data_type   = trim($_REQUEST["data_type"]);
$report_type = trim($_REQUEST["report_type"]);
if (strpos($data_type, "month") > -1) {
    $g_type = "7";
} else {
    $g_type = "10";
}
//问卷调查相关变量
$ask_id    = trim($_REQUEST["ask_id"]);
$que_id    = trim($_REQUEST["que_id"]);
$form_id   = trim($_REQUEST["form_id"]);
$ask_title = trim($_REQUEST["ask_title"]);
$show_info = trim($_REQUEST["show_info"]);
$info_list = trim($_REQUEST["info_list"]);
$info_name = trim($_REQUEST["info_name"]);
$postion   = trim($_REQUEST["postion"]);
$ask_des   = trim($_REQUEST["ask_des"]);
$yes_des   = trim($_REQUEST["yes_des"]);
$no_des    = trim($_REQUEST["no_des"]);
$ask_type  = trim($_REQUEST["ask_type"]);

$que_type  = trim($_REQUEST["que_type"]);
$que_title = trim($_REQUEST["que_title"]);
$que_des   = trim($_REQUEST["que_des"]);
$step_turn = trim($_REQUEST["step_turn"]);
$form_list = trim($_REQUEST["form_list"]);
$is_break  = trim($_REQUEST["is_break"]);
$break_pos = trim($_REQUEST["break_pos"]);
$break_des = trim($_REQUEST["break_des"]);
$form_size = trim($_REQUEST["form_size"]);
$is_end    = trim($_REQUEST["is_end"]);

$user_level = trim($_REQUEST["user_level"]);
$user_group = trim($_REQUEST["user_group"]);
$file_type  = trim($_REQUEST["file_type"]);

//问卷页客户资料字段
$ask_list_ary = array(
    "phone_number" => "电话号码",
    "title" => "标题",
    "first_name" => "名字",
    "middle_initial" => "中间名",
    "last_name" => "姓氏",
    "province" => "省份",
    "city" => "城市",
    "state" => "地区",
    "address1" => "地址1",
    "address2" => "地址2",
    "address3" => "地址3",
    "postal_code" => "邮编",
    "gender" => "性别",
    "date_of_birth" => "生日",
    "alt_phone" => "备用电话",
    "email" => "邮箱",
    "vendor_lead_code" => "代理商ID",
    "security_phrase" => "安全密码",
    "comments" => "描述",
    "owner" => "所有者",
    "user" => "工号",
    "fullname" => "工号姓名",
    "<br/>" => "换行符"
);

//详单资料导出字段
$field_ary = array(
    "a.user" => "工号",
    "b.full_name" => "工号姓名",
    "b.phone_login" => "分机号",
    "a.call_date" => "开始时间",
	"TIMESTAMPADD(SECOND,ifnull(a.talk_length_sec,0),a.call_date)" => "结束时间",
	"IFNULL(a.length_in_sec,0)" => "呼叫时长",
    "IFNULL(a.talk_length_sec,0)" => "通话时长",
    "h.campaign_name" => "业务活动",
    "case when a.comments=·auto· then ·自动· else ·手动· end" => "呼叫方式",
    "e.status_name" => "呼叫结果",
	"a.call_des" => "呼叫描述",
    "c.title" => "标题",
    "c.first_name" => "名字",
    "c.middle_initial" => "中间名",
    "c.last_name" => "姓氏",
    "c.address1" => "地址1",
    "c.address2" => "地址2",
    "c.address3" => "地址3",
    "c.province" => "省份",
    "c.city" => "城市",
    "c.phone_code" => "区号",
    "c.state" => "地区",
    "c.postal_code" => "邮编",
    "c.gender " => "性别",
    "c.date_of_birth " => "生日",
    "c.alt_phone" => "备用电话",
    "c.email" => "邮箱",
    "c.vendor_lead_code" => "代理商ID",
    "c.security_phrase" => "安全密码",
    "c.comments" => "客户备注",
    "c.owner" => "所有者",	
    "g.status_name" => "质检结果",
    "f.userid" => "质检人",
    "f.addtime" => "质检时间",
    "f.qualitydes" => "质检描述",
    str_replace("'","·",$record_location)=> "录音地址",
    "a.status" => "结果状态码",
	"i.dtmf_key" => "DTMF记录"
);

//筛选客户资料字段
$filter_list_ary = array(
    "list_id" => "客户清单ID",
    "lead_id" => "电话号码ID",
    "phone_number" => "电话号码",
    "status" => "呼叫结果",
    "entry_date" => "导入时间",
    "last_local_call_time" => "呼叫时间",
    "title" => "标题",
    "first_name" => "名字",
    "middle_initial" => "中间名",
    "last_name" => "姓氏",
    "address1" => "地址1",
    "address2" => "地址2",
    "address3" => "地址3",
    "city" => "城市",
    "state" => "地区",
    "postal_code" => "邮编",
    "province" => "省份",
    "gender" => "性别",
    "date_of_birth" => "生日",
    "alt_phone" => "备用电话",
    "email" => "邮箱",
    "comments" => "描述",
    "user" => "工号"
);

?>
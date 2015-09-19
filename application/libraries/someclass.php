<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Someclass {

    function __construct()
    {
    	require_once ('inc/aql.php');
		//require_once 'inc/aql_confparser.php';	
    }
    
    function name()
    {	
    	set_include_path(get_include_path().PATH_SEPARATOR .BASEPATH.'libraries/inc');
    
    	$aql = new aql;
		$aql->set('basedir','/etc/asterisk/');	
		$db = $aql->query("insert into t9.conf set callerid=\"'99' <99>\",section='555'");
		echo $aql->errstr;
		print_r($db);
    	return 'name';	
    }
}


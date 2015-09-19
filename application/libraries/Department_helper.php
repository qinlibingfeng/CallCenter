<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Department_helper{

	function __construct(){
	
	}
	
	function getDepartmentMembers(){
		$ret=array();
		
		$CI =&get_instance();
		$CI->load->model('Department_model');	
		
		$q=$CI->Department_model->getDatas();
		
		foreach($q as $item){
			array_push($ret,array('name_value'=>$item['department_id'],'name_text'=>$item['department_name']));
		}
	
		return $ret;
	}
	
	function getDepartmentMembersById($id){
		$ret=array();
		$CI =&get_instance();
		$CI->load->model('Department_model');	
		$allData=$CI->Department_model->getDatas();
		
		$data=$CI->Department_model->getDatasById($id);
		$datas=array_merge($data, $allData);
		foreach($datas as $item){
			array_push($ret,array('name_value'=>$item['department_id'],'name_text'=>$item['department_name']));
		}
	
		return $ret;
		
	} 
}
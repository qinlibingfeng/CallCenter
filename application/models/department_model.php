<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDatas(){
		return $this->db->select('*')->from('department')->get()->result_array();
	}
	
	function getDatasById($id){
		return $this->db->select('*')->from('department')->where('department_id',$id)->get()->result_array();
	}
	
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Function_panel_model extends CI_Model{
	public function __construct(){
         parent::__construct();      
    }
    public function get_items($filter=null){	
		 return $this->db->query("select * from function_panel order by p_id asc,sort desc");
	}
	
}
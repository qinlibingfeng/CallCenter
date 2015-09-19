<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
	}
	
	function test_role()
	{
		$params = array('agent_id' => '100002');
		$this->load->library('role', $params );
		$this->role->set_name('100002');
		echo $this->role->get_name();
	}
	
	function test_ztree($from='look_client_pre',$role_id='')
	{
		$this->load->model('Users_model');
		$data['tree_nodes']=$this->Users_model->get_json_tree();
		$data['role_id']='10002';
		$data['con_type']='type';
		$this->load->view('users_browser', $data);
	}
	
	function test_echo()
	{
		$this->load->library('firephp');
		$this->firephp->log('121212');
	}
	function test_dyfunc(){	
	}
	function test_dynamicui(){
		$this->load->library('dynamicui',array("agentId"=>"1000"));
		$modelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($modelName);
		//echo $this->$modelName->getBaseInfoTableData();
		$data=$this->$modelName->getAllClientSearchData();
		print_r($data);
		$this->load->view("dynamic_ui_view");	
	}


	function test_datepicker(){	
		$this->load->view("test_datepicker");
	}
	
	function test_newui($agent){
		
		$this->load->library('func_helper');		
		$this->load->library('Agent_helper', array('agent_id'=>$agent));	
		
		$role_id=$this->agent_helper->get_roleid();
		if($role_id != -1){		
			$this->load->library('Role_helper',array('role_id'=>$role_id));
			$this->role_ids=$this->role_helper->get_assocatie_func_ids();
			$data["items"]=$this->func_helper->get_items(null);
		}
		$data['agentId']=$agent;
		$this->load->view("new_main_view.php",$data);
	}
	function test_ui(){
		$this->load->view("test_uiitem_view.php");
	}
}
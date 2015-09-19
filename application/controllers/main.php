<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller{
	private $role_ids;
	
	public function  index($agent){
	    $data['base_view_url']=$this->config->item("base_url")."/application/views";
		if ($this->session->userdata('is_login')){
			$data['agent']=$agent;
			$this->load->view('main_view',$data);
		}else{
			//echo  '你没有权限，请先登录！';
			$data['agent']=$agent;
			$this->load->view('main_view',$data);
		}
	}
	public function top($agent){	
		$this->load->model('Pbx_model');
		$data['user']=$this->db->query("select code,name,role_name from agents left join role on role_id=role.id where code=$agent")->result_array();
		$data['agentId']=$agent;
		if($data){
			$this->load->view("top_view",$data);
		}
		else{
			$this->load->view('top_view');
		}
	}
	public function filter_item($row)
	{		
		if ($row->p_id == 0)
		{
			if(in_array($row->id,$this->role_ids['pids']))
				return true;
		}
		else
		{
			if(in_array($row->id,$this->role_ids['ids']))
				return true;
		}
		return false;
	}
	public function left($agent){	
		$this->load->library('func_helper');		
		$this->load->library('Agent_helper', array('agent_id'=>$agent));	
		$role_id=$this->agent_helper->get_roleid();
		if($role_id != -1)
		{		
			$this->load->library('Role_helper',array('role_id'=>$role_id));
			$this->role_ids=$this->role_helper->get_assocatie_func_ids();
			$data["items"]=$this->func_helper->get_items($this);
			$this->load->view("left_new_view",$data);
		}
		else
			echo 'not find role';
		
		
	}
	
	public function foot(){
		$this->load->view("foot_view");
	}
}


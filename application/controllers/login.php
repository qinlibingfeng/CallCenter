<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(BASEPATH."../console.php"); 
error_reporting(E_ERROR);
parse_str($_SERVER['QUERY_STRING'], $_GET);


class login extends CI_Controller{
	private $role_ids;
	public function __construct(){
		parent::__construct();
		$users=$this->load->model("Pbx_model");
	;
	}
	public function  index(){
		$this->load->view('login_new_view');
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
	
	public  function  vici_login($usr,$passwd){
		

	if ($this->Users_model->check_agents($usr,$passwd)){
			$session['is_login']=true;
			$session['login_id']=$usr;
	
			$data=$this->Pbx_model->get_pbx_reginfo($session['login_id']);
			$agent=$data['agent'];

			$this->load->library('func_helper');		
			$this->load->library('Agent_helper', array('agent_id'=>$agent));		
			$role_id=$this->agent_helper->get_roleid();
			if($role_id != -1){		
				$this->load->library('Role_helper',array('role_id'=>$role_id));
				$this->role_ids=$this->role_helper->get_assocatie_func_ids();
				$data["items"]=$this->func_helper->get_items($this);
			}
				
			$data['agentId']=$agent;
			$data['user']=$this->db->query("select code,name,role_name,out_display_number_id from agents left join role on role_id=role.id where code=$agent")->result_array();
			$data['agentId']=$agent;
			
			$data['out_display_number']=$this->db->query("select number_id,number_display from out_display_number")->result_array();
		

			$this->load->view("new_main_view.php",$data);
			////$this->session->set_userdata($session);
			//$this->load->view("main_view", $data);
			
			return;			
		}		

		redirect('login');			
	}

	public  function  call_search($usr,$passwd, $iocheak, $agent_id, $phone, $uniqueid){
	
		if ($this->Users_model->check()){
			$session['is_login']=true;
			$session['login_id']=$usr;
	
			$data=$this->Pbx_model->get_pbx_reginfo($session['login_id']);
			$agent=$data['agent'];

			$this->load->library('func_helper');		
			$this->load->library('Agent_helper', array('agent_id'=>$agent));		
			$role_id=$this->agent_helper->get_roleid();
			if($role_id != -1){		
				$this->load->library('Role_helper',array('role_id'=>$role_id));
				$this->role_ids=$this->role_helper->get_assocatie_func_ids();
				$data["items"]=$this->func_helper->get_items($this);
			}
				
			$data['agentId']=$agent;
			$data['user']=$this->db->query("select code,name,role_name,out_display_number_id from agents left join role on role_id=role.id where code=$agent")->result_array();
			$data['agentId']=$agent;
			
			
			$data['callInfo']= array('iocheak'=>$iocheak, 'agent_id'=>$agent_id, 'phone'=>$phone, 'uniqueid'=>$uniqueid);
			
			$this->load->view("new_main_view.php",$data);
			////$this->session->set_userdata($session);
			//$this->load->view("main_view", $data);
			
			return;			
		}		

		redirect('login');			
	}
	
	
	public  function  log(){
		$this->form_validation->set_rules('name', '用户名', 'required');
		$this->form_validation->set_rules('passwd', '密码', 'required');
		if ($this->form_validation->run()){
			if ($this->Users_model->check()){
				$session['is_login']=true;
				$session['login_id']=$this->input->post('name');
				$data=$this->Pbx_model->get_pbx_reginfo($session['login_id']);
				$agent=$data['agent'];
				$this->load->library('func_helper');		
				$this->load->library('Agent_helper', array('agent_id'=>$agent));		
				$role_id=$this->agent_helper->get_roleid();
				if($role_id != -1){		
					$this->load->library('Role_helper',array('role_id'=>$role_id));
					$this->role_ids=$this->role_helper->get_assocatie_func_ids();
					$data["items"]=$this->func_helper->get_items($this);
				}
					
				$data['agentId']=$agent;
				$data['user']=$this->db->query("select code,name,role_name,out_display_number_id from agents left join role on role_id=role.id where code=$agent")->result_array();
				$data['agentId']=$agent;
				
				$data['out_display_number']=$this->db->query("select number_id,number_display from out_display_number")->result_array();
			

				$this->load->view("new_main_view.php",$data);
				////$this->session->set_userdata($session);
				//$this->load->view("main_view", $data);
				
				return;			
			}		
		}
		redirect('login');			
	}
	public  function  comments(){
			
		$data['client_name']=$_REQUEST['name'];
		$data['client_colspan']=$_REQUEST['colspan'];
		$data['client_type']=$_REQUEST['type'];
		$data['client_valuesource']=$_REQUEST['valuesource'];
		$data['client_id']=$_REQUEST['id'];
		$data['client_dbfield']=$_REQUEST['dbfield'];
		$data['client_width']=$_REQUEST['width'];
		$data['client_height']=$_REQUEST['height'];
		$data['client_lspace']=$_REQUEST['lspace'];
		$buf['str']=$data;

		$this->load->view("dial_custom",$buf);
	
	}
	public  function  delete($values){
			$data = "./layoutxml/beijing-jiaoyu.xml";
			$xml = simplexml_load_file($data);		//创建 SimpleXML对象
			$cout_row = count($xml->baseInfoTable->row); //计算row的个数
			for($i=0;$i<$cout_row;$i++)
			{	
				$root = $xml->baseInfoTable->row[$i];
				$cout_item = count($xml->baseInfoTable->row[$i]->item); //计算item的个数
				for($j=0;$j<$cout_item;$j++)
				{				
					$vas = $root->item[$j];
					//$ssh = $vas->id;
					//echo $ssh."<br />";
					if($xml->baseInfoTable->row[$i]->item[$j]->id == $values)
					{
						if($cout_item==1)
						{
							//echo $ssh."<br />";
							unset($xml->baseInfoTable->row[$i]);
						}
						else
						{
							//echo $ssh."<br />";
							unset($xml->baseInfoTable->row[$i]->item[$j]);
						}
					}
				}
			}
			$xml->asXML($data);
			echo "删除成功！！";
	}
	
	public	function add(){	
		if ($this->Users_model->add()){
			redirect('login');
		}else{
			$data['title']='注册';
			$this->load->view('sign_view',$data);
		}
	}
	public  function  signup(){
		$data['title']='注册页面';
		$this->load->view('sign_view',$data);
	}
	public  function  login_out(){
		$this->session->sess_destroy();
		redirect('login');
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$users=$this->load->model("Users_model");
		$this->load->model('Exten_model');
		$this->load->library('pagination');
	}
	public function navLook($agentId){
		$this->look();
	}
	
	public function add($agentId,$error='')
	{	
		$this->load->library('Role_helper',array('role_id'=>''));
		$this->load->library('Department_helper');
		
		//验证成功
		$data['bt_func']=site_url('user/insert/'.$agentId);
		$data['title']='添加坐席';
		
		$data['ext_items']=$this->Exten_model->get_unarrange();
		$data['role_items']=$role_all=$this->role_helper->get_roles();
	
		$data['department_items']=$this->department_helper->getDepartmentMembers();
		//print_r($data['department_items']);
		$data['agentId']=$agentId;
		$data['error']=$error;
		$this->load->view('user_detail_view', $data);
	}
	
	public function modify($code,$agentId)
	{
		$this->load->library('Agent_helper', array('agent_id'=>$code));	
		$this->load->library('Department_helper');	
		
		$role_id=$this->agent_helper->get_roleid();
		$this->load->library('Role_helper',array('role_id'=>$role_id));
		$data['bt_func']=site_url('user/update/'.$code.'/'.$agentId);
		$data['title']='修改坐席';
		
		//$unarrange=$this->Exten_model->get_unarrange();
		//$already_associate=$this->Exten_model->associate_with($code);
		
		//合并$already_associate和$unarrange $already_associat作为已选项显示
		//$data['ext_items']=array_merge($already_associate, $unarrange);
		//获得与agent关联的role
		$role_arrange=$this->agent_helper->get_role();
		
		$role_all=$this->role_helper->get_roles();
		$data['role_items']=array_merge($role_arrange, $role_all);
		
		$data['item']=$this->Users_model->get_byid($code);

		$data['department_items']=$this->department_helper->getDepartmentMembersById($data['item'][0]->department_id);
		$data['agentId']=$agentId;
		$this->load->view('user_detail_view', $data);
		
	}
	public function update($code,$agentId)
	{	
	    $this->set_rules();
		if ($this->form_validation->run() == FALSE){
			$this->modify($code,$agentId);
		}
		else{
			if($this->Users_model->update($code,$agentId)){
				redirect(site_url('system/user'."/$agentId"));
			}
			else
				$this->modify($code,$agentId);
		}		
	}
	
	private	function set_rules()
	{
		$this->form_validation->set_rules('name', '真实姓名', 'required');
		$this->form_validation->set_rules('fpasswd', '密码', 'required|matches[spasswd]');
		$this->form_validation->set_rules('spasswd', '密码确认', 'required');
	}
	
	public  function insert($agentId)
	{
		$this->set_rules();
		$this->form_validation->set_rules('code', '坐席编号', 'required|numeric');
		if ($this->form_validation->run() == FALSE){
			//重定向到add界面
			$this->add($agentId);
		}
		else{
			$ret= $this->Users_model->getNameValueById($this->input->post('code'));
		
			if($ret == false){
				if($this->Users_model->add($agentId)){
						//到查看坐席界面
						redirect(site_url('system/user'.'/'.$agentId));
					}
					else{
						//重定向到add界面
						$this->add($agentId);
					}		
			}else{
				$this->add($agentId,'坐席已存在');
			}
		}
	}
	
	public function ajax_add()
	{		
		$this->load->library('firephp');
		$this->load->library('exten');
		
		header('Content-Type: application/json',true);	 	
		$data=$this->input->post();
			
		$this->firephp->info($data);
		
		//添加分机
		if (strlen($data['code']) >1 && $this->exten->create_defalut($data['code']))
		{
			//插入坐席信息到数据库
			$this->Users_model->add($data);
			$res=array('res'=>1);
			echo json_encode($res);
		}
		else
		{
			$res=array('res'=>0);
			echo json_encode($res);
		}
	}
	public function ajax_modify(){
		
	}
	public function ajax_del()
	{
		$this->load->library('firephp');	
		header('Content-Type: application/json',true);	 	
		$data=$this->input->post();		
		$this->firephp->info($data);
		if ($this->Users_model->del($data)){
			$res=array('res'=>1);
			echo json_encode($res);
		}else
		{
			$res=array('res'=>0);
			echo json_encode($res);	
		}
	}
	
	public function testGetChildrens($agentId){
		$agents=array();
		$this->Users_model->getAllChildrenAgents($agents,$agentId);
		print_r($agents);
	}
	
	public function testGetParents($agentId){
		$agents=array();
		$this->Users_model->getAllParentAgents($agents,$agentId);	
		print_r($agents);
	}
	
	public function testGetBrothers($agentId){
		$agents=array();
		$this->Users_model->getAllBrotherAgents($agents,$agentId);	
		print_r($agents);
	}
}
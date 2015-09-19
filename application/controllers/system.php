<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class System extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$users=$this->load->model("Notice_model");
		echo $this->pagination->create_links();
	}
	public function index(){
		$this->load->view('top_view');
	}
	
	public function navLook($agentId){
		$this->user($agentId);
	}
	
	public function user($agentId,$offset=0,$sort_by='code', $sort_order='desc'){
		$limit=15;
		$columns=array('用户ID'=>'code','用户姓名'=>'name','所属部门'=>'department_name','角色'=>'role_name');	
		
		$users=$this->Users_model->get_users($agentId,$columns,$limit,$offset,$sort_by,$sort_order);
		
		$config['base_url'] = site_url('system/user/'.$agentId);
		$config['total_rows'] = $users['total_num'];
		$config['per_page'] = $limit;	
		$config['uri_segment'] = 4;		
		$this->pagination->initialize($config);	
		
		
		
		$data['pagination']=$this->pagination->create_links();	
		$data['columns']=$columns;
		$data['list_data']=$users['results'];
		$data['sort_order']=$sort_order;
		$data['agentId']=$agentId;
		$this->load->view('user_view',$data);
		
	}
	
	public function ajax_del(){
	 $data=$this->input->post();
	 header('Content-Type: application/json',true);
  	 echo json_encode($data);
	}
	
	public function notice($agentId)
	{
		$limit=25;
		$columns=array('ID'=>'notice_id','标题'=>'notice_title','创建时间'=>'notice_ctime');	
		$results=$this->Notice_model->get_all($agentId,$columns,$limit);	
		$data['notice']=$results['total_data'];
		$data['agentId']=$agentId;
		$this->load->view('person_look_view',$data);
			
	}
	
	public function tabs($agent)
	{
		$data['agentId']=$agent;
		$this->load->view('tabs_view',$data);
	}
	
	public function callControl($agent){
		$data['agentId']=$agent;
		$this->load->view('pbx_call_control_view',$data);
		
	}
	
	
}

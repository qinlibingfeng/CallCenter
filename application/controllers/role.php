<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Role extends CI_Controller
{
	private $role_ids=null;
	function __construct()
	{
		parent::__construct();
		$this->load->model('Role_model');
		$this->load->library('pagination');
		date_default_timezone_set('Asia/Shanghai');
	}
	public function navLook($agentId){
		$this->look();
	}
	public function look($offset=0,$sort_by='name', $sort_order='desc')
	{
		$limit=25;
		$columns=array('角色ID'=>'id','角色名'=>'role_name','创建时间'=>'role_stime');	
		$clients=$this->Role_model->get($columns, $limit,$offset,$sort_by,$sort_order);	
		
		$config['base_url'] = site_url('client/look/');	
		$config['per_page'] = $limit;	
		$config['uri_segment'] = 3;		
		$config['total_rows'] = $clients['total_num'];
		$this->pagination->initialize($config);	
		$data['pagination']=$this->pagination->create_links();	
		$data['columns']=$columns;
		$data['list_data']=$clients['results'];
		$data['sort_order']=$sort_order;
		
		$this->load->view('role_look_view',$data);
	}
	
	public function add()
	{	
		$data['dst']=site_url('role/insert');
		$data['title']='添加角色';
		$data['role_id']=-1;
		$data['role_name']='';
		$data['look_client_agent_data']=$this->Role_model->get_clients();
		$data['look_record_agent_data']=$this->Role_model->get_clients();
		$data['look_func_data']=$this->Role_model->get_func();
		$this->load->view('role_detail_view', $data);
	}
	
	//插入role的信息到数据库
	public function insert(){	
		$this->set_rules();
		if ($this->form_validation->run() == FALSE || $this->Role_model->insert() == FALSE){
			//失败留在role_detail_view
			$this->add();
		}
		else
		{
			//成功，转到role_look_view 页面
			redirect(site_url('role/look'));
		}
	}
	//加载修改界面
	public function modify($id)
	{
		$data['dst']=site_url('role/update/'.$id);
		$data['title']='修改角色';
		$data['role_id']=$id;
		
		$role_info=$this->Role_model->get_role_byid($id);
		$data['role_name']=$role_info[0]->role_name;
		$data['isCallDelClient']=$this->Role_model->isCallDelClient($id);
		$data['isCanExportClient']=$this->Role_model->isCanExportClient($id);
		$data['look_client_agent_data']=$this->Role_model->get_asscocati_agnet_string($id,0);//0查询客户时可显示的用户信息
		$data['look_record_agent_data']=$this->Role_model->get_asscocati_agnet_string($id,1);//1查询通话记录时可显示的用户信
		$data['order_agent_data']=$this->Role_model->get_asscocati_agnet_string($id,2);//2查询工单时可显示的用户信息息
		
		$data['look_func_data']=$this->Role_model->get_assocati_func($id);
		
		$this->load->view('role_detail_view', $data);
	}
	
	public function update($id){
		$this->set_rules();
		if ($this->form_validation->run() == FALSE || $this->Role_model->update_byid($id) == FALSE){
			//失败留在role_detail_view
			$this->modify($id);
		}
		else{			
			//成功，转到role_look_view 页面
			redirect(site_url('role/look'));	
		}
		
	}
	private	function set_rules()
	{
		$this->form_validation->set_rules('role_name', '角色名字', 'required');
	}
	
	/*点击编辑按键
	*
	*点击编辑按键打开树形选择框，可以选择角色可以显示的面板和坐席
	*/
	public function select_items($type=0,$role_id=-1)
	{
		if($type == 0 || $type == 1 ||$type == 2){
			$this->show_select_agents($type,$role_id);
		}
		else if($type == 3){
			
			$this->show_select_func($role_id, $type);
		}
	}
	
	public function checked($row)
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
	
	/*选择面板
	*
	*选择角色可以显示的面板
	*/
	public function show_select_func($role_id, $type)
	{
		$this->load->library('Role_helper',array('role_id'=>$role_id));
		$this->role_ids=$this->role_helper->get_assocatie_func_ids();
		$this->load->library('Func_helper_ztree');
		$tree_nodes=$this->func_helper_ztree->get_items($this);
		
		$data['tree_nodes']=json_encode($tree_nodes);
		$data['role_id']=$role_id;
		$data['con_type']=$type;
			
		$this->load->view('select_items_view', $data);
	}
	
	private function show_select_agents($type=0,$role_id=-1)
	{	
		$this->load->model('Users_model');
		$tree_nodes=$this->Users_model->get_tree();
		$checked_data=$this->Role_model->get_associate_agent_array($role_id,$type);

		foreach($tree_nodes as &$item){
			 if(in_array($item['name'], $checked_data)){
				 $item['checked']='true';
			 }	 	
		}	
		$data['tree_nodes']=json_encode($tree_nodes);
		$data['role_id']=$role_id;
		$data['con_type']=$type;
		
		$this->load->view('select_items_view', $data);
	}
	
	public function ajax_edit()
	{
		 header('Content-Type: application/json',true);
		 //数据
		 $data=$this->input->post();		 
  		 echo json_encode($data);
	}
	
	public function ajax_delete()
	{	 
		 header('Content-Type: application/json',true);
		 //数据
		 $data=$this->input->post();	
		 $this->load->library('firephp');
		 $this->firephp->info($data["ids"]);
		 
		 if(count($data["ids"])>0)
		 	$this->Role_model->delete_roles($data["ids"]);	
		 
		 $res["ok"]=true;
		 $this->firephp->info($res);
  		 echo json_encode($res);
	}
		
	public function ajaxGetCAgentsCanShow(){
		header('Content-Type: application/json',true);
		$this->load->library('firephp');
		$req=$this->input->post();
		$this->load->model('Users_model');
		$this->load->library('Agent_helper',array('agent_id'=>$req['text']));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		$ret=$this->Users_model->getNameValueByIds($agents[3]);
	    echo json_encode($ret);	
	}
	function ajaxGetRoleByAgent(){
		header('Content-Type: application/json',true);
		$req=$this->input->post();
		$this->load->library('firephp');
		$this->firephp->info($req);
		$sql="select delete_client,export_client from role left join agents on role.id=role_id where code='".$req['agent']."' limit 0,1";
		$rs=$this->db->query($sql)->result_array();
		$ret['isOk']=false;
		foreach($rs as $row){
			$ret['isOk']=true;
			$ret['delete_client']=$row['delete_client'] == 1?true:false;
			$ret['export_client']=$row['export_client'] == 1?true:false;
		}
		echo json_encode($ret);
	}
}
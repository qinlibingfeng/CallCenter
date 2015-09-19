<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}
	function getAllChildrenAgents(&$agents,$agentId){
		$sql="select code from agents where p_agent=$agentId";
		$ret=$this->db->query($sql)->result_array();
		if($ret){
			foreach($ret as $sub){
				if($sub['code']){			
					array_push($agents,$sub['code']);	
					$this->getAllChildrenAgents($agents,$sub['code']);
				}
			}		
		}else{
			return;
		}
	}
	
	function getAllParentAgents(&$pagents,$agentId){
		$sql="select p_agent from agents where code=$agentId";
		$ret=$this->db->query($sql)->result_array();
		if($ret){
			foreach($ret as $sub){				
				if($sub['p_agent']){			
					array_push($pagents,$sub['p_agent']);		
					$this->getAllParentAgents($pagents,$sub['p_agent']);		
				}
			}		
		}else{
			return;
		}
	}
	
	function getAllAgentsByRole($agentId,$roleType=0){	
		$sql="select agent_code,code from role_agent left join agents on role_agent.role_id=agents.role_id where code='$agentId' and con_type=$roleType";
		$agents=array();
		$ret=$this->db->query($sql)->result_array();
		foreach($ret as $row){						
			array_push($agents,$row['agent_code']);				
		}			
		return $agents;
	}
	
	function getAllBrotherAgents(&$agents,$agentId){		
		if($agentId != ''){
			$sql="select p_agent from agents where code='$agentId'";
			$ret=$this->db->query($sql)->result_array();			
			if($ret && $ret[0]['p_agent'] && $ret[0]['p_agent'] !=''){
				$this->getAllChildrenAgents($agents,$ret[0]['p_agent']);		
			}else{
				array_push($agents,$agentId);
			}
		}
	}
	
	public function check(){
		//echo "1:".$this->input->post('name')."!";
		$this->db->where('code', $this->input->post('name'));
		$this->db->where('passwd',$this->input->post('passwd'));
		//$this->db->or_where('name', $this->input->post('name'));
		$q=$this->db->get('agents');		

		if ($q->num_rows()>0){
			//echo "wangwang";
			return $q->row();
		}
	}
	public function check_agents($usr,$password){
		//echo "1:".$this->input->post('name')."!";
		$this->db->where('code', $usr);
		$this->db->where('passwd',$password);
		//$this->db->or_where('name', $this->input->post('name'));
		$q=$this->db->get('agents');		

		if ($q->num_rows()>0){
			//echo "wangwang";
			return $q->row();
		}
	}


	public function add($agentId){
		$item['code']=$this->input->post('code');
		$item['name']=$this->input->post('name');
		$item['passwd']=$this->input->post('fpasswd');	
		$item['role_id']=$this->input->post('role');
		$item['department_id']=$this->input->post("department");
		$item['p_agent']=$agentId;
		
		$sipusers['name']=$item['code'];
		$sipusers['username']=$item['code'];
		$sipusers['host']='dynamic';
		$sipusers['sippasswd']=$item['code'];
		//$sipusers['fromuser']='ymkj.com';
		
		$sipusers['context']='callout';
		$sipusers['mailbox']=$item['code'];
		
		//事务开始
		$this->db->trans_start();
  		$this->db->insert('sipusers',$sipusers);
		$id=$this->db->insert('agents',$item);
		$this->db->trans_complete();
		 
		return $id;
	}
		
	public function del($data){
		foreach($data as $item)
		{
			$this->db->trans_start();
		 	$this->db->delete('agents',array('code'=> $item));
			$this->db->delete('sipusers',array('name'=> $item));
			$this->db->trans_complete();
		}	 
		return 1;
	}
	
	public function update($agent_id,$pAgentId)
	{
		//$item['code']=$this->input->post('code');
		$item['name']=$this->input->post('name');
		$item['passwd']=$this->input->post('fpasswd');
		$item['role_id']=$this->input->post('role');
		$titem['agentext']=$this->input->post('ext');
		$item['phone']=$this->input->post('phone');
		$item['cell_phone']=$this->input->post('cell_phone');
		$item['phone_prefix']=$this->input->post('phone_prefix');
		$item['pbx']=$this->input->post('pbx');
		$item['department_id']=$this->input->post('department');
		
		//事务开始
		$this->db->trans_start();
		//更新agents
		$this->db->update('agents', $item, array('code' => $agent_id));
		
		//事务结束
		$this->db->trans_complete();
		return $this->db->trans_status();
	
	}
	
	public function get_byid($agent_id)
	{
		//根据agentid查找agent信息，默认一定可以找到
		return $this->db->select('*')->from('agents')->where('code',$agent_id)->get()->result();
	}
	/*
	public function get_users($agentId,$columns,$limit, $offset, $sort_by, $sort_order){
		
		$sort_order=$sort_order=='asc'?'desc':'asc';
		$fields=array();
		foreach($columns as $key=>$value){
			array_push($fields, $value);
		}
		
		$sort_by=in_array($sort_by,$fields)?$sort_by:'code';
	
		$this->db->where('name !=','self');
		$this->db->where('name !=','everyone');
		$this->db->where('name !=','admin');
		$allChildren=array();
		$this->getAllChildrenAgents($allChildren,$agentId);
		array_push($allChildren,$agentId);
		
		if(count($allChildren)>0)
		  $this->db->where_in('code',$allChildren);
		 else{
		 	 $this->db->where('code',$agentId);
		 }
		
		//$q=$this->db->select("count(*) as count")->from("agents left join role on agents.role_id=role.id left join department on agents.department_id=department.department_id")->order_by($sort_by,$sort_order);
		$q=$this->db->select(implode(",", $fields))->from("agents left join role on agents.role_id=role.id left join department on agents.department_id=department.department_id")->limit($limit, $offset)->order_by($sort_by,$sort_order);


		$ret['results']= $q->get()->result();
		
		$this->db->where('name !=','self');
		$this->db->where('name !=','everyone');
		$this->db->where('name !=','admin');
		$allChildren=array();
		$this->getAllChildrenAgents($allChildren,$agentId);
		array_push($allChildren,$agentId);
		
		if(count($allChildren)>0)
		  $this->db->where_in('code',$allChildren);
		 else{
		 	 $this->db->where('code',$agentId);
		 }

		$q=$this->db->select("count(*) as count")->from("agents left join role on agents.role_id=role.id left join department on agents.department_id=department.department_id")->order_by($sort_by,$sort_order);
		$row=$q->get()->result();
		
		$ret['total_num']=$row[0]->count;
		return $ret;
	}
	*/
	public function get_users($agentId,$columns,$limit, $offset, $sort_by, $sort_order){
		
		$sort_order=$sort_order=='asc'?'desc':'asc';
		$fields=array();
		foreach($columns as $key=>$value){
			array_push($fields, $value);
		}
		
		$sort_by=in_array($sort_by,$fields)?$sort_by:'code';
	
		$this->db->where('name !=','self');
		$this->db->where('name !=','everyone');
		$this->db->where('name !=','admin');
		$allChildren=array();
		$this->getAllChildrenAgents($allChildren,$agentId);
		array_push($allChildren,$agentId);
		

		
		//$q=$this->db->select("count(*) as count")->from("agents left join role on agents.role_id=role.id left join department on agents.department_id=department.department_id")->order_by($sort_by,$sort_order);
		$q=$this->db->select(implode(",", $fields))->from("agents left join role on agents.role_id=role.id left join department on agents.department_id=department.department_id")->limit($limit, $offset)->order_by($sort_by,$sort_order);


		$ret['results']= $q->get()->result();
		
		$this->db->where('name !=','self');
		$this->db->where('name !=','everyone');
		$this->db->where('name !=','admin');
		$allChildren=array();
		$this->getAllChildrenAgents($allChildren,$agentId);
		array_push($allChildren,$agentId);
		

		$q=$this->db->select("count(*) as count")->from("agents left join role on agents.role_id=role.id left join department on agents.department_id=department.department_id")->order_by($sort_by,$sort_order);
		$row=$q->get()->result();
		
		$ret['total_num']=$row[0]->count;
		return $ret;
	}	
	private function add_departments_node($tree,$departs)
	{		
		foreach($departs as $row)
		{
			$node=array();
			$node['pId']=0;
			$node['id']=$row->department_id;
			$node['name']=$row->department_name;
			$node['open']=true;
		
			array_push($tree, $node);			
		}
		return $tree;
	}
	
	private function add_users_node($tree, $users){
		foreach($users as $row){
			$node=array();
			$node['pId']=$row->department_id;
			$node['id']=$row->code;
			$node['name']=$row->name;
			array_push($tree, $node);
		}
		return $tree;
	}
		
	public function get_tree(){
		$tree=array();
		//添加department
		$q=$this->db->select("department_id,department_name")->from('department')->get()->result();
		$tree=$this->add_departments_node($tree, $q);
		
		//添加users
		$q=$this->db->select('code,name,department_id')->from('agents')->get()->result();
		$tree=$this->add_users_node($tree, $q);
		
		return ($tree);
	}
	
	function getDatas(){
		return $this->db->query("select * from agents")->result_array();
	}
	
	function getNameValueById($id){
		return $this->db->query("select  code as name_value,name as name_text from agents where code=$id")->result_array();
	}
	function getNameValue(){
		return $this->db->query("select  code as name_value,name as name_text from agents")->result_array();
	}
	
	function getNameValueByIds($agents){
		$this->db->where_in('code',$agents);
		$ret=$this->db->select("code as name_value,name as name_text ")->from("agents")->get()->result_array();	
		return $ret;
	}
	
}

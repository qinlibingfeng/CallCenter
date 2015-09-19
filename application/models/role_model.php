<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Role_model extends CI_Model
{
	function __construct(){
		parent::__construct();
		//header("context-type: text/html; charset=uft-8");
		
	}
	
	function get_role_byid($id){
		return $this->db->select('*')->from('role')->where('id', $id)->get()->result();
	}
	function getFunIdsByNames($names){
		$this->db->where_in('text', $names);
		$result=$this->db->select("id")->from("function_panel")->get()->result_array();
		$ret=array();
		foreach($result as $row){
			array_push($ret,$row["id"]);
		}
		return $ret;
		
	}
	function getAgentIdsByNames($names){
		$this->db->where_in('name', $names);
		$result=$this->db->select("code")->from("agents")->get()->result_array();
		$ret=array();
		foreach($result as $row){
			array_push($ret,$row["code"]);
		}
		return $ret;	
	}
	
	function get($columns, $limit,$offset,$sort_by,$sort_order){
		$fields=array();
		foreach($columns as $key=>$value){
			array_push($fields, $value);
		}
		$sort_by=in_array($sort_by,$fields)?$sort_by:'id';
		$q=$this->db->select(implode(",", $fields))->from("role")->limit($limit,$offset)->order_by($sort_by,$sort_order);
		$ret['results']= $q->get()->result();
		$q=$this->db->select("count(*) as count")->from('role');
		$row=$q->get()->result();
		$ret['total_num']=$row[0]->count;
		return $ret;
	}
	//新建-插入角色信息到数据库
	function insert()
	{
		$role_item['role_name']=$this->input->post('role_name');
		$role_item['role_stime']=date("Y-m-d H:i:s");
		$role_item['look_client']=$this->input->post('look_client_check');
		$role_item['show_func']=$this->input->post('look_record_check');	   
		
		//事务开始
		$this->db->trans_start();
		//插入基本信息
		$this->db->insert('role',$role_item);
		$id=$this->db->insert_id();
		//插入权限关系look_client
		$this->insert_associate_agent($id, $this->input->post('look_client_agnet_data'),0);
		$this->insert_associate_agent($id, $this->input->post('look_record_agnet_data'),1);
		$this->insert_associate_agent($id, $this->input->post('order_agnet_data'),1);
		$this->insert_associate_func($id, $this->input->post('look_func_data'));
		//事务结束
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	}
	function update_byid($id)
	{
		$role_item['role_name']=$this->input->post('role_name');
		$role_item['role_stime']=date("Y-m-d H:i:s");
		$role_item['look_client']=$this->input->post('look_client_check');
		$role_item['show_func']=$this->input->post('look_record_check');
		$role_item['delete_client']=$this->input->post('delete_agent_check');
		$role_item['export_client']=$this->input->post('export_client_check');
		
		//事务开始
		$this->db->trans_start();
		$this->db->update('role',$role_item,array('id' => $id));
		$this->db->delete('role_agent', array('role_id' => $id));
		$this->db->delete('role_func', array('role_id'  => $id)); 
		
		  
		//插入权限关系look_client
		$this->insert_associate_agent($id, $this->input->post('look_client_agnet_data'),0);
		$this->insert_associate_agent($id, $this->input->post('look_record_agnet_data'),1);
		$this->insert_associate_agent($id, $this->input->post('order_agnet_data'),2);
		
		
		
		$this->insert_associate_func($id, $this->input->post('look_func_data'));
		
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function insert_associate_func($id, $data)
	{
		$items=explode(',',$data);
		$items=$this->getFunIdsByNames($items);
		foreach($items as $item){
			$row['role_id']=$id;
			$row['func_id']=$item;
			$this->db->insert('role_func',$row);
		}
	}
	function insert_associate_agent($id, $data,$type=0){
			$items=explode(',',$data);
			$items=$this->getAgentIdsByNames($items);
			foreach($items as $item){
				$row['role_id']=$id;
				$row['con_type']=$type;
				$row['agent_code']=$item;
				$this->db->insert('role_agent',$row);
			}
	}
	
	function get_associate_agent_byid($id,$type){
		$sql="select agent_code,name from role_agent left join agents on code=agent_code where role_agent.role_id=? and con_type=?";	
		$q=$this->db->query($sql, array($id,$type));
		return $q;
	}
	
	function get_associate_agent_array($id,$type){
		$q=$this->get_associate_agent_byid($id,$type);
		$ret=array();
		foreach( $q->result() as $row){
			array_push($ret, $row->name);
		}
		return $ret;
	}
	
	function get_asscocati_agnet_string($id,$type)
	{
		$ret=array();
		$q=$this->get_associate_agent_byid($id,$type);
		foreach($q->result() as $row){
			array_push($ret, $row->name);	
		}
	
		return implode(',',$ret);
	}
	
	function get_clients()
	{
		$q=$this->db->select('*')->from('agents')->get()->result();
		$client_of_agents=array();
		foreach($q as $item)
		{
			array_push($client_of_agents,$item->code);
		}
		return implode(',', $client_of_agents);
	}
	
	function get_func()
	{
		$q=$this->db->select('*')->from('function_panel')->where('p_id !=',0)->get()->result();
		$data_values=array();
		$data_names=array();
		foreach($q as $item)
		{
			array_push($data_values,$item->id);
			array_push($data_names,$item->text);
		}
		
		$data['values']=implode(',', $data_values);
		$data['names']=implode(',', $data_names);
		return $data;
	}
	
	function get_assocati_func($id)
	{
		$q=$this->db->select('*')->from('role_func')->where('role_id',$id)->get()->result();
		$data_values=array();
		$data_names=array();
		foreach($q as $item){
			array_push($data_values,$item->func_id);
			
		}
		
		$this->db->where_in('id', $data_values);
		$q=$this->db->select('*')->from('function_panel')->get()->result();
		foreach($q as $item){
			array_push($data_names,$item->text);	
		}
		$data['values']=implode(',', $data_values);
		$data['names']=implode(',', $data_names);
		return $data;
	}
	
	function get_assocatie_func_allinfo($id){
		$sql='select * from role_func  left join function_panel  on func_id=function_panel.id where role_id=?';
		return $this->db->query($sql, array($id));
	}
	
	function delete_roles($ids){
		//事务开始
		$this->db->trans_start();	
		$this->db->where_in('role_id', $ids);
		$this->db->delete('role_agent');
		$this->db->where_in('role_id', $ids);
		$this->db->delete('role_func');
		$this->db->where_in('id', $ids);
		$this->db->delete('role');
		$this->db->trans_complete();
		return  $this->db->trans_status();	
	}
	
	function get_roles()
	{
		return $this->db->select('*')->from('role')->get()->result();
	}
	
	function getEveryOneAgentByRoleId($roleId, $type){
		return $this->db->query('select code as name_value,name as name_text from agents where name <> "everyone" and name<>"self"')->result_array();		
	}
	
	function getSelfAgentAttrByRoleId($roleId, $type){
		$sql="select agent_code as name_value,name as name_text from role_agent left join agents on agent_code=agents.code  where role_agent.role_id=".$roleId." and con_type=0 and name='self'";
		return $this->db->query($sql)->result_array();	
	}
	
	function getAgentAttrByRoleId($roleId){
	   $sql="select agent_code as name_value,name as name_text from role_agent left join agents on agent_code=agents.code  where role_agent.role_id=".$roleId." and con_type=0 and (name<>'everyone'  or name<>'self')";
		return $this->db->query($sql)->result_array();			
	}
	
	function isCallDelClient($id){
		$sql="select delete_client from role where id=$id";
		$ret=$this->db->query($sql)->result_array();
		if($ret && $ret[0]['delete_client'] == 1)
			return TRUE;
		else
			return FALSE;
		
	}
	
	function isCanExportClient($id){
		$sql="select export_client from role where id=$id";
		$ret=$this->db->query($sql)->result_array();
		if($ret && $ret[0]['export_client'] == 1)
			return TRUE;
		else
			return FALSE;
		
	}
}
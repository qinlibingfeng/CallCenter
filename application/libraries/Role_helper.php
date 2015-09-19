<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role_helper
{	
	private	$id=null;
 	private	$name=null;
	private	$role_helper=null;
	private $role_id;
	
	function __construct($param)
    {
		$this->role_id=$param['role_id'];
		
	}

	function get_name()
	{
		return $this->name;
	}
	function get_id()
	{
		return $this->id;
	}
	function set_name($name)
	{
		$this->name=$name;
	}
	function set_id($id)
	{
		$this->id=$id;
	}
	/*获取所有的roles的信息
	*
	*/
	function get_roles()
	{
		$ret=array();
		$CI =& get_instance();
		$CI->load->model('Role_model'); 
		$allRoles=$CI->Role_model->get_roles();
		foreach($allRoles as $row)
		{
			$item['id']=$row->id;
			$item['name']=$row->role_name;
			array_push($ret, $item);
		}
		return $ret;
	}
	
	/*获取和agent关联的role的信息
	*
	*/
	function get_role()
	{
		$ret=array();
		$CI =& get_instance();
		$CI->load->model('Users_model');
		$CI->load->model('Role_model');
		$q=$CI->Role_model->get_role_byid($this->role_id);
		foreach($q as $row)
		{
			$item['id']=$row->id;
			$item['name']=$row->role_name;
			array_push($ret, $item);
		}

		return $ret;
	}
	
	/*获取与角色可以显示的所有func的id的集合与pid的集合
	*
	*/
	function get_assocatie_func_ids()
	{
		$ret=array();
		$ids=array();
		$pids=array();
		$CI =& get_instance();
		$CI->load->model('Role_model');
		
		$q=$CI->Role_model->get_assocatie_func_allinfo($this->role_id);
		foreach($q->result() as $row)
		{	 
			array_push($ids,$row->func_id);
			array_push($pids, $row->p_id);
		}	
				
		$ret['ids']=$ids;
		$ret['pids']=$pids;
		return $ret;
	}
	
	function isHasEveryOneAttr($type){
		$roleId=$this->role_id;
		$sql="select id from role_agent left join agents on agent_code=code where name='everyone' and role_agent.role_id=$roleId and con_type=$type";
		$CI =&get_instance();
		$CI->firephp->info($sql);
		if($CI->db->query($sql)->result_array())
			return true;
		else
			return false;
	}
	
	function isHasSelfOneAttr($type){
		$roleId=$this->role_id;
		$sql="select id from role_agent left join agents on agent_code=code where name='self' and role_agent.role_id=$roleId and con_type=$type";
		
		$CI =&get_instance();
		$CI->firephp->info($sql);
		if($CI->db->query($sql)->result_array())
			return true;
		else
			return false;
	}
	
}
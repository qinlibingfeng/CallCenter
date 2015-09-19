<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plan_model extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}
	function get_calendar_events()
	{
		return $this->db->select('*')->from('calendar')->get()->result_array();
	}
	
	function modify_calendar_event($id, $data)
	{	
		return $this->db->update('calendar', $data, array('id' => $id));
	}
	
	function delCalendarEvent($id)
	{
		return $this->db->delete('calendar', array('id'=>$id));
	}
	function addCalendarEvent($data)
	{
		return $this->db->insert('calendar', $data);
	}
	
	function getClocks($limit=10,$offset=0,$sort_by='time',$sort_order='desc'){
		
		$sort_by=in_array($sort_by,array('id','time','title'))?$sort_by:'time';
	
		$q=$this->db->select('*')->from("clock")->limit($limit,$offset)->order_by($sort_by,$sort_order);
		$ret['total_datas']= $q->get()->result_array();
		$q=$this->db->select("count(*) as count")->from('clock');
		$row=$q->get()->result();
		$ret['total_rows']=$row[0]->count;
		return $ret;
	}
	
	function addClock($data)
	{
		return $this->db->insert('clock', $data);
	}
	function updateClock($id,$data)
	{
		return $this->db->update('clock', $data, array('id' => $id));
	}
	function getClock($id)
	{
		return $this->db->select('*')->from("clock")->where('id',$id)->get()->result_array();
	}
}
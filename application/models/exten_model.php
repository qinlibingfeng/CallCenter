<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exten_model extends CI_Model{
	function __construct(){
		parent::__construct();
		//header("context-type: text/html; charset=uft-8");
	}
	
	function get_unarrange()
	{
		$q=$this->db->query('select agentext from TX_AGENT where agentext is not NULL')->result();
		
		$arranged=array();
		foreach($q as $row)
		{		
			array_push($arranged, $row->agentext);
		}
		
		
		//print_r(($arranged));
		$q=$this->db->query('select ext from TX_EXT')->result();
		$all=array();
		foreach($q as $row)
		{	
			array_push($all, $row->ext);
		}
		//返回未分配的分机
		return array_diff(array_values($all),array_values($arranged));
	}
	
	function associate_with($agent_id)
	{
		$q=$this->db->select('agentext')->from('TX_AGENT')->where('agentid',$agent_id)->get()->result();
		$ret=array();
		foreach($q as $row)
		{
			array_push($ret, $row->agentext);
		}
		return $ret;
	}
	
	
	function get($columns, $limit,$offset,$sort_by,$sort_order)
	{
		$fields=array();
		foreach($columns as $key=>$value){
			array_push($fields, $value);
		}
		$sort_by=in_array($sort_by,$fields)?$sort_by:'ext';
		$q=$this->db->select(implode(",", $fields))->from("TX_EXT")->limit($limit,$offset)->order_by($sort_by,$sort_order);
		$ret['results']= $q->get()->result();
		$q=$this->db->select("count(*) as count")->from('TX_EXT');
		$row=$q->get()->result();
		$ret['total_num']=$row[0]->count;
		return $ret;
	}
	
}
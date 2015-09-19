<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notice_model extends CI_Model{
	function __construct(){
		parent::__construct();
		//header("context-type: text/html; charset=uft-8");
	}
	
	public function get_all($agentId,$columns,$limit=8, $offset=0,$sort_by='notice_ctime', $sort_order='desc'){
		
		$sort_order=$sort_order=='desc'?'desc':'asc';
		$fields=array();
		foreach($columns as $key=>$value){
			array_push($fields, $value);
		}
		$sort_by=in_array($sort_by,$fields)?$sort_by:'notice_ctime';
			
		$q=$this->db->select(implode(",", $fields))->from("notice")->limit($limit,$offset)->order_by($sort_by,$sort_order);
		$ret['total_data']= $q->get()->result_array();
		$q=$this->db->select("count(*) as count")->from('notice');
		$row=$q->get()->result();
		$ret['total_num']=$row[0]->count;
		return $ret;
	}
	
	public function insert_from_form($agentId)
	{
		$item['notice_title']=$this->input->post('title');
		$item['notice_html']=$this->input->post('content');
		$item['notice_ctime']=date("Y-m-d H:i:s");
		$item['notice_creator']=$agentId;
		return $this->insert($item);
	}
	public function update_from_form($id,$agentId)
	{
		$item['notice_title']=$this->input->post('title');
		$item['notice_html']=$this->input->post('content');
		$item['notice_mtime']=date("Y-m-d H:i:s");
		$item['notice_creator']=$agentId;
		return $this->update_byid($id, $item);
	}
	public function insert($item)
	{
		return $this->db->insert('notice', $item);
	}
	
	public function update_byid($id, $item)
	{
		return $this->db->update('notice', $item, array('notice_id'=>$id));
	}
	public function get_byid($id)
	{
		return $this->db->select('*')->from('notice')->where('notice_id',$id)->get()->result_array();
	}
	
	public function delete_byids($ids)
	{		
		$this->db->where_in('notice_id', $ids);
		return $this->db->delete('notice');
		
	}
}
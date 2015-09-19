<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dictionary_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
	}
	
	function getNormalDictionarys($name_type=0,$limit=10,$offset=0,$sort_by='name_value',$sort_order='desc')
	{
		$sort_by=in_array($sort_by,array('name_id','name_value','name_text'))?$sort_by:'name_value';
		$q=$this->db->select('*')->from("dictionary_normal")->where('name_type',$name_type)->limit($limit,$offset)->order_by($sort_by,$sort_order);
		$ret['total_datas']= $q->get()->result_array();
		$q=$this->db->select("count(*) as count")->where('name_type',$name_type)->from('dictionary_normal');
		$row=$q->get()->result();
		$ret['total_rows']=$row[0]->count;
		return $ret;
	}
	
	function getNormalDictionaryTypes()
	{
		 $q=$this->db->query('select distinct name_type_text,name_type from dictionary_normal');
		 return $q->result_array();
	}
	function getNormalDictionaryTypeText($name_type)
	{
		$q=$this->db->select('*')->from("dictionary_normal")->where('name_type',$name_type)->limit(1,0);
		return $q->get()->result_array();
	}
	
	function updateNormalDictionary($id, $data)
	{
		return $this->db->update('dictionary_normal', $data, array('name_id' => $id));
	}
	
	function insertNormalDictionary($item)
	{
		return $this->db->insert('dictionary_normal',$item);
	}
	
	function getNormalDictionaryCountOfValue($name_type,$value)
	{
		$this->db->where('name_value',$value);
		$this->db->where('name_type',$name_type);
		$q=$this->db->select("count(*) as count")->from('dictionary_normal');
		$row=$q->get()->result();
		return $row[0]->count;
	}
	function getNormalDictionaryById($id)
	{
		$q=$this->db->select('*')->from("dictionary_normal")->where('name_id',$id);
		return $q->get()->result_array();
	}
	
	function getNormalDictionaryByTypeText($name_type_text)
	{
		$q=$this->db->select('*')->from("dictionary_normal")->where('name_type_text',$name_type_text)->order_by('name_value','asc');
		return $q->get()->result_array();
	}
	
	function getNormalDictionaryByType($name_type)
	{
		$q=$this->db->select('*')->from("dictionary_normal")->where('name_type',$name_type);
		return $q->get()->result_array();
	}
	
	function getSelectOption($type){
		$ret=array();
		$sql="select * from dictionary_normal where name_type_text='$type' order by name_value";
		$q=$this->db->query($sql)->result_array();
		foreach($q as $row){
			$ret[$row['name_text']]=$row['name_text'];	
		}
		return $ret;
		
	}
}
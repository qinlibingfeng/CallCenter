<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Communicate_model extends CI_Model{
	function __construct(){
		parent::__construct();
	
	}
	function get($columns,$limit, $offset, $sort_by, $sort_order)
	{
		$fields=array();
		foreach($columns as $key=>$value){
			array_push($fields, $value);
		}
		$sort_by=in_array($sort_by,$fields)?$sort_by:'caller';
		$q=$this->db->select(implode(",", $fields).',callid')->from("TX_CTICDR a left join TX_RECORD b on callcode=callid")->limit($limit,$offset)->order_by($sort_by,$sort_order);
		$ret['results']= $q->get()->result();
		$q=$this->db->select("count(*) as count")->from('TX_CTICDR');
		$row=$q->get()->result();
		$ret['total_num']=$row[0]->count;
		return $ret;
	}
	
	function getItemsFromReq($req){
		if(isset($req['columInt']))
			$dataInt=array_combine($req['columInt']['colum'],$req['columInt']['datas']);
		else
			$dataInt=array();
		if(isset($req['columText']))
			$dataText=array_combine($req['columText']['colum'],$req['columText']['datas']);
		else
			$dataText=array();
			
		$data=array_merge($dataInt,$dataText);
		
		$data['client_iswaitcom']=0;
		$data['client_modify_time']=date("Y-m-d H:i:s");
		$item['client']=$data;
		return $item;
	}
	function insertBill($bill){
		$this->db->insert('bill',$bill);
	}
	
	function getOneRecordById($uniqueid){
		$sql="select  location,file_name from cc_call_history where autoid=$uniqueid";
		return $this->db->query($sql)->result_array();
	}
}

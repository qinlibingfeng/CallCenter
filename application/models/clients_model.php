<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clients_model extends CI_Model
{
	function __construct(){
		parent::__construct();
	
	}
	function get($columns,$limit, $offset, $sort_by, $sort_order)
	{
		$fields=array();
		foreach($columns as $key=>$value){
			array_push($fields, $value);
		}
		$sort_by=in_array($sort_by,$fields)?$sort_by:'name';
		$q=$this->db->select(implode(",", $fields).',client_id')->from("clients")->limit($limit,$offset)->order_by($sort_by,$sort_order);
		$ret['results']= $q->get()->result();
		$q=$this->db->select("count(*) as count")->from('clients');
		$row=$q->get()->result();
		$ret['total_num']=$row[0]->count;
		return $ret;
	}
	
	
	function getData($query){
		return $this->db->query($query);
	}

	function getby_id($id)
	{
		return $this->db->select('*')->from('clients')->where('client_id',$id)->get()->result_array();
	}
	function update($id,$data)
	{
		return $this->db->update('clients', $data, array('client_id'=>$id));
	}
	function update_list($phone,$data,$list_id)
	{
		require('/var/www/html/config.php');
		$str = $db_config["database"].'vicidial_list';
		return $this->db->update($str, $data, array('phone_number'=>$phone,'list_id'=>$list_id));
	}
	function syn_row_list($row,$client_id){
		
		$cdrRow['modify_date']=$row['client_ctime'];
		$cdrRow['last_name']=$row['client_name'];
		$cdrRow['list_id']=$client_id;
		$cdrRow['phone_number']=$row['client_cell_phone'];
		$cdrRow['user']=$row['client_agent'];
		
		//$cdrRow['lead_id']=$clientId;
		//$cdrRow['entry_date']=$row['client_ctime'];
		//$cdrRow['user']=$row['client_agent'];

		/*$cdrRow['owner']=$row['client_id'];*/

		return $cdrRow;
	}
	
	function syn_comment_list($row){
			
		$cdrRow['modify_date']=$row['client_modify_time'];
		$cdrRow['last_name']=$row['client_name'];
		$cdrRow['phone_number']=$row['client_cell_phone'];
		return $cdrRow;
	}
	function syn_comment_insert_list($row,$client_id){
			
		$cdrRow['modify_date']=$row['client_ctime'];
		$cdrRow['last_name']=$row['client_name'];
		$cdrRow['list_id']=$client_id;
		$cdrRow['phone_number']=$row['client_cell_phone'];
		$cdrRow['user']=$row['client_agent'];
		return $cdrRow;
	}

	function insert_list($item)
	{
		require('/var/www/html/config.php');
		$str = $db_config["database"].'.'.'vicidial_list';

		$this->db->insert($str,$item);
	}
	function insert($item)
	{
		$this->db->insert('clients',$item);
		return $this->db->insert_id();
	}
	function exsit($item)
	{
		return false;
	}

	function filter(&$data)
	{
		foreach($data as $key=>$value)
		{
			if($key == 'client_name')
				$data[$key]=preg_replace("/[^\x{4E00}-\x{9FFF}]+/u","", $value);
			else if($key == 'client_cell_phone' || $key == 'client_phone')
				$data[$key]=preg_replace("/[^0-9]/","", $value); //非数字
			else if($key=='client_person_card')
				$data[$key]=preg_replace("/[^0-9]/","", $value); //非数字
			else
				$data[$key]=$value;			
					
		}
		
	}
	function clearClientTmp()
	{
		 $this->db->empty_table('clients_tmp');
	}
	
	function insertToClientTmp($item)
	{
		return $this->db->insert('clients_tmp',$item);
	}
	function insert_vicidial_list($client_id){
		require('/var/www/html/config.php');
		$str = $db_config["database"].'vicidial_list';

		$sql="INSERT INTO ".$db_config["database"].".vicidial_list(entry_date,modify_date,user,last_name,address1,phone_number) 
			  SELECT client_ctime,client_modify_time,client_agent,client_name,client_address,client_cell_phone FROM  edu.clients where client_id='$client_id'";
		 $this->db->query($sql);
	
	}
	
	function selectClientByPhone($phone, $fileds){	
		$phone=preg_replace("/[^0-9]/","", $phone);
		if($phone != "" && substr($phone,0,1) == '0')
			$phone=substr($phone,1);
			
		$sql="SELECT ".str_replace(" , ", " ", implode(", ", $fileds))." 
		from clients 
		where client_cell_phone='$phone' or client_phone='$phone' or client_cell_phone='0$phone' or client_phone='0$phone' or client_cell_phone_two='$phone' or client_cell_phone_two='0$phone' or client_phone_two='$phone' or client_phone_two='0$phone'";	
		
		return $this->db->query($sql)->result_array();
	}
	
}
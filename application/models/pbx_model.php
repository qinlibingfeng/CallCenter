<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pbx_model extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}
	public function get_pbx_reginfo($agent)
	{
		$ret=$this->db->query("select code from agents where code='$agent' or name='$agent'")->result_array();
		$data['agent']=$ret[0]['code'];
		
		/*
		$q=$this->db->select('*')->from('TX_AGENT')->where('agentid',$agent);
		$row=$q->get()->result();
		if($row)
		{
			$data['pwd']=$row[0]->agentpwd;
			$data['ext']=$row[0]->agentext;
			$q=$this->db->select('*')->from('TX_SYSCONFIG')->where('ConfigItem','ctihost');
			$row=$q->get()->result();
			$data['host']=$row[0]->ConfigValue;
			$q=$this->db->select('*')->from('TX_SYSCONFIG')->where('ConfigItem','ctiport');
			$row=$q->get()->result();
			$data['port']=$row[0]->ConfigValue;
			return $data;
		}
		*/
		return $data; 
	}
	
}
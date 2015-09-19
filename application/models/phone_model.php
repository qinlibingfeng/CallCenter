<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Phone_model extends CI_Model{
	public function getPhoneAddress($phone){
		if($phone == "")
			return "";
		//取电话号码的前
		$phone_prix=substr($phone,0,7);
		
		$sql="select pro,area from mobile where mobile='$phone_prix'";
		$ret=$this->db->query($sql)->result_array();
		if($ret){
			return $ret[0]["pro"].$ret[0]["area"];
		}else{
			return "";
		}
	}
}
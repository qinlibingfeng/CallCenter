<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dictionary_tree_model extends CI_Model
{
	function __construct(){
		parent::__construct();
		
	}
	function getItemByText($tx){
		return $this->db->query("select * from dictionary_tree where treenames_tx='$tx'")->result_array();
	}
	
	function insertItem($data){
		$this->db->insert('dictionary_tree',$data);
	}
	
	function deleteItemById($id){
		$this->db->query("delete from dictionary_tree where treenames_id=$id or treenames_pid=$id");
	}
	function getItemsByPid($pid){
		return $this->db->query("select treenames_id as name_value,treenames_tx as name_text from dictionary_tree where treenames_pid=$pid")->result_array();
	}
	
	function getTreeDataByPid($treeData,$pid){
		$sql="select treenames_id as id,treenames_pid as pId,treenames_tx as name from dictionary_tree where treenames_pid=$pid";
		$ret=$this->db->query($sql)->result_array();
		if($ret){
			foreach($ret as $sub){			
				if($sub['id']){
					$sub['open']=true;
					array_push($treeData,$sub);	
					$treeData=$this->getTreeDataByPid($treeData,$sub['id']);
				}else{
					array_push($treeData,$sub);	
				}
			}		
		}
		return $treeData;
	}
	
	function getAreaData(&$areaData){
		$sql="select area_id as id,area_pid as pId,area_text as name from area";
		$areaData=$this->db->query($sql)->result_array();
		
	}
}
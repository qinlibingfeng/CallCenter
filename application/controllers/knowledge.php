<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Knowledge extends CI_Controller{
	public function __construct(){
    	parent::__construct();
		date_default_timezone_set('Asia/Shanghai');
    }
    public function look($agentId){ 
		$data['agentId']=$agentId;
		$this->load->library('Utility_func');
		$timeOptions=$this->utility_func->creatHourMinOptions();
		$data['beginTime']=$timeOptions;
		$data['beginTime']['ymh']=date('Y-m-d');
		$data['beginTime']['hourDef']='00';
		$data['beginTime']['minDef']='00';
		
		$data['endTime']=$timeOptions;
		$data['endTime']['ymh']=date('Y-m-d');
		$data['endTime']['hourDef']='23';
		$data['endTime']['minDef']='59';
		$sql="select id,pid as pId,name from knowledge";
		$res=$this->db->query($sql)->result_array();
		$tmpData=array();
		foreach($res as $row){
			$row['dId']=$row['id'];
			array_push($tmpData,$row);
		}
		$data["treeData"]=$tmpData;
    	$this->load->view("knowledge_look_view",$data);
    }
	function lookPreview($agentId){
		$sql="select id,pid as pId,name from knowledge";
		$res=$this->db->query($sql)->result_array();
		$tmpData=array();
		foreach($res as $row){
			$row['dId']=$row['id'];
			array_push($tmpData,$row);
		}
		$data["treeData"]=$tmpData;
		$data["agentId"]=$agentId;
    	$this->load->view("knowledge_look_preview_view",$data);
	}
	
	function modifyLook($id,$agentId){
		$sql="select title,html from knowledge_data where id=$id";
		$ret=$this->db->query($sql)->result_array();
		if($ret){
			$data['title']=$ret[0]["title"];
			$data['html']=$ret[0]["html"];
			$data['id']=$id;
			$this->load->view('knowledge_edit_view', $data);
		}
	}
	
	function doModify($id){
		$this->load->library('firephp');	
		$tile=$this->input->post('title');
		$content=$this->input->post('content');	
		$sql="update knowledge_data set title='".$tile."',html='".$content."' where id=".$id;
		$item['title']=$tile;
		$item['html']=$content;
		$this->firephp->info($sql);
		$this->db->update('knowledge_data',$item,array('id'=>$id));
		$this->modifyLook($id,'');
	}
	
	function preview($id,$agentId ){
		$sql="select  title,html from knowledge_data where id=".$id;
		$ret=$this->db->query($sql)->result_array();
		$data['tilte']=$ret[0]['title'];
		$data['html']=$ret[0]['html'];
		$this->load->view('knowledge_preview_view', $data);
	}
	function ajaxGetHtmlByTreeId(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$sql="select  title,html from knowledge_data where id=".$req["id"];
		$ret=$this->db->query($sql)->result_array();
		$data['tilte']=$ret[0]['title'];
		$data['html']=$ret[0]['html'];
		
		echo json_encode($data);
	}
	function ajaxGetTreeNode(){
		$this->load->library('firephp');
		$req=$this->input->post();
		$this->firephp->info($req);
	}
	function ajaxAddKnowledgeTreeNode(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		$req=$this->input->post();
		$this->firephp->info($req);
		$sql="";
		//插入值
		$item["name"]="新增";
		$item["pid"]=$req["pid"];
		$this->firephp->info($item);
		
		$this->db->insert('knowledge',$item);
	
		$id=$this->db->insert_id();
		$titem['id']=$id;
		$titem['title']=$item['name'];
		$titem['html']='';
		$this->db->insert('knowledge_data',$titem);
		
		$ret["isOk"]=true;
		$ret["dId"]=$id;
		$ret["name"]=$item["name"];
		echo json_encode($ret);
	}
	
	function ajaxDelKnowledgeTreeNode(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		$req=$this->input->post();
		$this->firephp->info($req);
		$sql="delete from knowledge where id='".$req["dId"]."'";
		$this->db->query($sql);
		
		$sql="delete from knowledge where pid='".$req["dId"]."'";
		$this->db->query($sql);
		
		$ret["isOk"]=true;
		$ret["id"]=$req["dId"];
		echo json_encode($ret);
	}
	
	function ajaxRenameKnowledgeTreeNode(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		$req=$this->input->post();
		
		$sql="update knowledge set name='".$req["name"]."' where id='".$req["dId"]."'" ;
		$this->db->query($sql);
		
		$sql="update knowledge_data set title='".$req["name"]."' where id='".$req["dId"]."'" ;
		$this->db->query($sql);
		$ret["isOk"]=true;
		$ret["id"]=$req["dId"];
		echo json_encode($ret);
	}
	
}
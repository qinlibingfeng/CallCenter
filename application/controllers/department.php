<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->library('DataTabes_helper');
		$this->load->library('firephp');
	}
	public function look($agentId){
		$this->load->view('department_look_view');
	}
	
	public function ajaxLook(){
		header('Content-type: Application/json',true);	
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 1,
		"iTotalDisplayRecords" => 1,
		"aaData" => array()
		);
				
		$aColumns = array('department_id','department_id','department_name');
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns);
		$sTable="department";
		$sWhere="";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit ";
		
		$this->firephp->info($sQuery);
		
		$ret=$this->db->query($sQuery);	
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns,'department_id');
		$this->firephp->info($output["aaData"]);
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		$ret=$this->db->query($sCount)->result_array();
	
		$this->firephp->info($ret);
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output);
		
	}
	function ajaxAddDepartment(){
		header('Content-type: Application/json',true);	
		$req=$this->input->post();
		$items['department_name']=$req['departmentName'];
		$this->db->insert('department',$items);
		$data['ok']=true;
		echo json_encode($data);
	}
	
	function ajaxDelDepartment(){
		header('Content-type: Application/json',true);	
		$req=$this->input->post();
		$this->firephp->info($req['ids']);
		$sWhere=$this->datatabes_helper->getSearchSql($req['ids']);
		if($sWhere != ""){
			$sTable="department";
			$sQuery = "
			DELETE
			FROM   $sTable
			$sWhere";
			$this->firephp->info($sQuery);
			$this->db->query($sQuery);
			$data['ok']=true;
			echo json_encode($data);
		}
	}
}
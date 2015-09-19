<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('firephp');
		$this->load->library('DataTabes_helper');
		date_default_timezone_set('Asia/Shanghai');
	}
	
	public function createOrder(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$this->firephp->info($req);
		
		$clientData=array_combine($req['ids'],$req['values']);	
		$this->load->helper('string');
		$insertOrderData['order_id']=date("YmdHis").random_string('numeric', 4);;
	
		$insertOrderData['client_name']=$req['name'];
		
		$insertOrderData['client_phone']=$req['phone'];
		
		$insertOrderData['order_group']=$req['orderType'];
		$insertOrderData['order_status']='新建';
		
		$insertOrderData['order_content']=$req['orderContent'];
		$insertOrderData['order_ctime']=date("Y-m-d H:i:s");
		$insertOrderData['order_agent']=$req['owner'];
		$insertOrderData['order_processor']=$req['reciever'];
		
		
		$this->firephp->info($insertOrderData);
		$this->db->insert('work',$insertOrderData);
		
		$res['isOk']=true;
		echo json_encode($res);
	}
	
	
	
	public function look($agentId){
		$this->firephp->info($agentId);

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
		$this->load->library('Dynamicui',array("agentId"=>$agentId));
		$dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		$data["searchPanelTableData"]=$this->$dyModelName->getOrderTableSearchPanel();
		$data["tableHeader"]=$this->$dyModelName->getOrderTableHeader();
		$this->load->view('order_look_view.php',$data);
		
	}
	
	public function lookByOwner($agentId){
		$this->firephp->info($agentId);

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
		$this->load->library('Dynamicui',array("agentId"=>$agentId));
		$dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		$data["searchPanelTableData"]=$this->$dyModelName->getOrderTableSearchPanel();
		$data["tableHeader"]=$this->$dyModelName->getOrderTableHeader();
		$this->load->view('client_order_view.php',$data);
		
	}
	
	public function process($orderId){
		$data['orderId']=$orderId;
		$this->load->library('Dynamicui',array("agentId"=>''));
		
		$dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$fileds=$this->$dyModelName->getOrderBaseInfoFileds();
		
		$sql="SELECT ".str_replace(" , ", " ", implode(", ", $fileds))." 
		 	  from  work
			  where id=$orderId";
		$ret=$this->db->query($sql)->result_array();
		
		$data['bussniessInfo']=$this->$dyModelName->getBussniessInfoTableData($ret[0]);
		
		$fileds=$this->$dyModelName->getOrderProcessInfoFileds();
		$sql="SELECT ".str_replace(" , ", " ", implode(", ", $fileds))." 
		 	  from  work
			  where id=$orderId";
		
		$ret=$this->db->query($sql)->result_array();
		$data['processInfo']=$this->$dyModelName->getOrderProcessTableData($ret[0]);
		
		$this->load->view('order_process_view.php',$data);
	}
	public function ajaxOrderLookByOwner(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 0,
		"iTotalDisplayRecords" => 0,
		"aaData" => array()
		);
		
		$searchObject=json_decode($req['filterString']);
		$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>"1000"));
	  
	  	$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
		
	  	$agents=$this->agent_helper->getOrderAgentsCanShow();
		$this->firephp->info($agents);
		array_push($searchObject->searchText,$agents);
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject->searchText);
		$this->firephp->info("where is");
		$this->firephp->info($sWhere);
		
		$aColumns=array("order_id","order_status","order_group","client_name","client_phone","client_address", "order_content","order_ctime","order_agent","order_processor","id");
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'order_ctime','desc');
	
		$sTable="work";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere 
		$sOrder
		$sLimit ";
	
		$this->firephp->info($sQuery);
		
		$ret=$this->Clients_model->getData($sQuery);	
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		
		
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		
		$ret=$this->Clients_model->getData($sCount)->result_array();
	
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		$this->firephp->info($output);
		
		echo json_encode($output);	
	}
	
	public function ajaxOrderLook(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 0,
		"iTotalDisplayRecords" => 0,
		"aaData" => array()
		);
		
		$searchObject=json_decode($req['filterString']);
		$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>"1000"));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getOrderTableColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
		$this->firephp->info("where is");
		$this->firephp->info($sWhere);
		
		
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'order_ctime','asc');
		
		$this->firephp->info($sOrder);
		
		$sTable="work";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere 
		$sOrder
		$sLimit ";
	
		$this->firephp->info($sQuery);
		
		$ret=$this->Clients_model->getData($sQuery);	
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		
		
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		
		$ret=$this->Clients_model->getData($sCount)->result_array();
	
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		$this->firephp->info($output);
		
		echo json_encode($output);	
	}
	
	
	function ajaxOrderProcessSave(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		
		$this->firephp->info($req);
		
		if(isset($req['columText']))
			$dataText=array_combine($req['columText']['colum'],$req['columText']['datas']);
		else
			$dataText=array();
		
		$this->db->update('work',$dataText,array('id'=>$req["orderId"]));
		
		$res["isOk"]=true;
		
		echo json_encode($res);
		
		
	}
	
	
}
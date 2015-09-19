<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Client extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('DataTabes_helper');
		$this->load->library('excel_helper');
		$this->load->library('firephp');
		date_default_timezone_set('Asia/Shanghai');
	}


/*public  function  vicidial(){
			
	$action = $_REQUEST["action"];	
	
	if($action == "Authenticate"){
		$usr =  $_REQUEST["user_name"];
		$passwd = $_REQUEST["user_password"];
		redirect('login/vici_login/'.$usr.'/'.$passwd);			
	}else if($action == "SynGroups"){
		
		$group_id =  $_REQUEST["group_id"];
		$group_name = $_REQUEST["group_name"];		
	
		redirect('login/syn_groups/'.$group_id.'/'.$group_name);			
	}else if($action == "SynUsers"){
		
		$user_name =  $_REQUEST["user_name"];
		$user_pass = $_REQUEST["user_pass"];		
		$user_fullname =  $_REQUEST["user_fullname"];
		$user_level = $_REQUEST["user_level"];						
		$user_active = $_REQUEST["user_active"];
		$user_group =  $_REQUEST["user_group"];	
				
		redirect('login/syn_users/'.$user_name.'/'.$user_pass.'/'.$user_fullname.'/'.$user_level.'/'.$user_active.'/'.$user_group);			
	}else if($action == "SynCallLogs"){
		
		
		$this->load->database('test',true);
		$res = $this->db->query('SELECT * from vicidial_log')->result_array();
		
		foreach($res as $row){		
			echo $row['uniqueid'].'<br />';
		}

		echo "1111";

		//redirect('client/dbbbb/'.$callid);

	}else {
		redirect('login');
	}
	
}
public  function  dbbbb(){
	//echo $row['uniqueid'].'<br />';
	//echo $val."<br />";
	//echo $user;
}*/
	public  function  dbbbb(){
		echo "222222222222222222222".'<br />';
		
	}
	public function find_all($agentId)
	{
		//echo "<script>alert("成功");</script>";
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
		

		$this->load->view('client_find_all_view',$data);
	
	}

	public function all($agentId='')
	{
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
		
		$this->load->library('Agent_helper',array('agent_id'=>$agentId));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		
		$data["searchPanelTableData"]=$this->$dyModelName->getClientSearchPanel();
		$this->load->model("Users_model");
	
		$showAgents=$this->Users_model->getNameValueByIds($agents[3]);
		if($showAgents){
			array_push($showAgents,array("name_value"=>"全部","name_text"=>"全部"));
			array_push($showAgents,array("name_value"=>"未填写","name_text"=>"未填写"));
			foreach($data["searchPanelTableData"]["elements"][0] as &$items){
				if($items["id"] == "client_agent"){
					$items["value"]["values"]=$showAgents;
					$items["value"]["defaultValue"]="全部";
				}
			}
		}

		$this->load->view('client_all_view', $data);
	}
	
	public function redirect($agentId=''){
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
		
		$this->load->library('Agent_helper',array('agent_id'=>$agentId));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		
		$data["searchPanelTableData"]=$this->$dyModelName->getClientSearchPanel();
		$this->load->model("Users_model");
	
		$showAgents=$this->Users_model->getNameValueByIds($agents[3]);
		if($showAgents){
			array_push($showAgents,array("name_value"=>"全部","name_text"=>"全部"));
			array_push($showAgents,array("name_value"=>"未填写","name_text"=>"未填写"));
			foreach($data["searchPanelTableData"]["elements"][0] as &$items){
				if($items["id"] == "client_agent"){
					$items["value"]["values"]=$showAgents;
					$items["value"]["defaultValue"]="全部";
				}
			}
		}
		$data['targetAgents']=$showAgents;
		$this->load->view('client_redirect_view', $data);	
	}
	
	public function alreadyCommunicated($agentId='')
	{   $data['agentId']=$agentId;
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
		
		$this->load->library('Agent_helper',array('agent_id'=>$agentId));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		
		$data["searchPanelTableData"]=$this->$dyModelName->getClientSearchPanel();
		$this->load->model("Users_model");
	
		$showAgents=$this->Users_model->getNameValueByIds($agents[3]);
		if($showAgents){
			array_push($showAgents,array("name_value"=>"全部","name_text"=>"全部"));
			array_push($showAgents,array("name_value"=>"未填写","name_text"=>"未填写"));
			foreach($data["searchPanelTableData"]["elements"][0] as &$items){
				if($items["id"] == "client_agent"){
					$items["value"]["values"]=$showAgents;
					$items["value"]["defaultValue"]="全部";
				}
			}
		}
		
		$this->load->view('client_communicated_view', $data);
	}
	
	//查询待沟通的用户的视图
	public function wait($agentId){
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
		
		$this->load->library('Agent_helper',array('agent_id'=>$agentId));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		
		$data["searchPanelTableData"]=$this->$dyModelName->getClientSearchPanel();
		$this->load->model("Users_model");
	
		$showAgents=$this->Users_model->getNameValueByIds($agents[3]);
		if($showAgents){
			array_push($showAgents,array("name_value"=>"全部","name_text"=>"全部"));
			array_push($showAgents,array("name_value"=>"未填写","name_text"=>"未填写"));
			foreach($data["searchPanelTableData"]["elements"][0] as &$items){
				if($items["id"] == "client_agent"){
					$items["value"]["values"]=$showAgents;
					$items["value"]["defaultValue"]="全部";
				}
			}
		}
		$this->load->view('client_wait_communicate_view', $data);
	}	
	public function order($agentId){
		$data['agentId']=$agentId;
		$this->load->view('client_yuyue_view', $data);
	}
	
	function ajaxRedirectOneClient(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$this->firephp->info($req['ids']);
		$sWhere=$this->datatabes_helper->getSearchSql($req['ids']);
		$targetAgent=$req['targetAgent'];
		if($sWhere != ""){
			
			$sTable="clients";
			$sQuery = "
			update  $sTable set client_agent='$targetAgent' 
			$sWhere";
			
			$this->firephp->info($sQuery);
			$ret=$this->Clients_model->getData($sQuery);
			
			$res['ok']=true;
		}else{
			$res['ok']=false;
		}
		
		echo json_encode($res);
	}
	//订单删除****************************开始************************
	function ajaxDeleteOneFormClient(){
		//require('/var/www/html/config.php');
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$this->firephp->info($req['ids']);
		$sWhere=$this->datatabes_helper->getSearchSql($req['ids']);
		if($sWhere != ""){
			//print_r($req);
			//echo $sWhere;
			$sTable="order_form";
			$sQuery = "
			DELETE
			FROM    $sTable
			$sWhere";
			
			$ret=$this->Clients_model->getData($sQuery);	
			$this->firephp->info($sQuery);	

			$res['ok']=true;
		}else{
			$res['ok']=false;
		}
		
		echo json_encode($res);

	}
	//订单删除****************************结束************************



	function ajaxDeleteOneClient(){
		require('/var/www/html/config.php');
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$this->firephp->info($req['ids']);
		$sWhere=$this->datatabes_helper->getSearchSql($req['ids']);
		if($sWhere != ""){
			$sTable="clients";
			
			$sql="select list_id from ".$db_config["database"].".vicidial_lists where campaign_id='".$req['campaignId']."';";
			$list=$this->Clients_model->getData($sql)->result_array();
			

			$m_sql="select client_ctime,client_name,client_agent,client_cell_phone from ".$db_config["database2"].".clients $sWhere";
			$client_vici = $this->Clients_model->getData($m_sql)->result_array();
			foreach($client_vici as $row){
				//echo $row['client_cell_phone'];	
				$delect="delete from ".$db_config["database"].".vicidial_list where list_id='".$list[0]['list_id']."' and phone_number='".$row['client_cell_phone']."'";
				$this->Clients_model->getData($delect);
			}
			
			//根据phone_number删除vici_list记录
			//$sQuery="delete from ".$db_config["database"].".vicidial_list where lead_id in (select client_id from $sTable $sWhere)";	
			//$ret=$this->Clients_model->getData($sQuery);
			
			$sQuery = "
			DELETE
			FROM   $sTable
			$sWhere";

			$this->firephp->info($sQuery);
			$ret=$this->Clients_model->getData($sQuery);
			
			$sTable="clients_wait";
			$sQuery = "
			DELETE
			FROM    $sTable
			$sWhere";
			
			$ret=$this->Clients_model->getData($sQuery);	
			$this->firephp->info($sQuery);	
			
			$res['ok']=true;
		}else{
			$res['ok']=false;
		}
		
		echo json_encode($res);
	}
	function ajaxDeleteWaitClient(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$this->firephp->info($req['ids']);
		$sWhere=$this->datatabes_helper->getSearchSql($req['ids']);
		if($sWhere != ""){
			$sTable="clients_wait";
			$sQuery = "
			DELETE
			FROM   $sTable
			$sWhere";
			$this->firephp->info($sQuery);
			$ret=$this->Clients_model->getData($sQuery);
			
			$sTable="clients";
			$sQuery = "
			DELETE
			FROM   $sTable
			$sWhere";
			$this->firephp->info($sQuery);
			$ret=$this->Clients_model->getData($sQuery);
				
			$res['ok']=true;
		}else{
			$res['ok']=false;
		}
		
		echo json_encode($res);
	}
	function ajaxDeleteYuyueClient(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$this->firephp->info($req['ids']);
		$sWhere=$this->datatabes_helper->getSearchSql($req['ids']);
		if($sWhere != ""){
			$sTable="clients_yuyue";
			$sQuery = "
			DELETE
			FROM   $sTable
			$sWhere";
			$this->firephp->info($sQuery);
			$ret=$this->db->query($sQuery);	
			$res['ok']=true;
		}else{
			$res['ok']=false;
		}
		
		echo json_encode($res);
	}
	function ajaxRedirectAllClient(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$searchObject=json_decode($req['filterString']);
		if($searchObject->searchType == 0){
				$searchItems= $this->createDefaultSearchObject($searchObject->searchText);
		}
		else if($searchObject->searchType == 1){
			$searchItems=$searchObject->searchText;
		}
		
	
		$sWhere=$this->datatabes_helper->getSearchSql($searchItems);	
		$sTable="clients";
		
		$targetAgent=$req['targetAgent'];
		
		$sQuery="update  $sTable 
				 set client_agent='$targetAgent'  
				 $sWhere";
	
		$ret=$this->Clients_model->getData($sQuery);
		
		
		$res['ok']=true;
		echo json_encode($res);	
		
	}
	//订单删除所有****************************开始***********************************
	/*function ajaxDeleteAllFormClient(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		
		$this->firephp->info($req['filterString']);
		$sWhere=$this->datatabes_helper->getSearchSql($req['filterString']);
		
		echo $sWhere."1********************************\n";


	

	}*/
	//订单删除所有****************************结束***********************************
	function ajaxDeleteAllClient(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		require('/var/www/html/config.php');
		$searchObject=json_decode($req['filterString']);
		if($searchObject->searchType == 0){
				$searchItems= $this->createDefaultSearchObject($searchObject->searchText);
		}
		else if($searchObject->searchType == 1){
			$searchItems=$searchObject->searchText;
		}
		

		$sWhere=$this->datatabes_helper->getSearchSql($searchItems);	
		$sTable="clients";
		
		
		$sQuery="delete from clients_wait where client_id in (select client_id from $sTable $sWhere)";
	
		$ret=$this->Clients_model->getData($sQuery);

		//删除vicidial_list中edu要删除的数据
		$sql="select list_id from ".$db_config["database"].".vicidial_lists where campaign_id='".$req['campaignId']."';";
		$list=$this->Clients_model->getData($sql)->result_array();
		

	    $m_sql="select client_ctime,client_name,client_agent,client_cell_phone from ".$db_config["database2"].".clients $sWhere";
		$client_vici = $this->Clients_model->getData($m_sql)->result_array();
		foreach($client_vici as $row){
			//echo $row['client_cell_phone'];	
			$delect="delete from ".$db_config["database"].".vicidial_list where list_id='".$list[0]['list_id']."' and phone_number='".$row['client_cell_phone']."'";
			$this->Clients_model->getData($delect);
		}

		//$sQuery="delete from asterisk.vicidial_list where phone_number in (select client_cell_phone from $sTable $sWhere)";	
		//$ret=$this->Clients_model->getData($sQuery);
		
		$sQuery = "
		DELETE
		FROM   $sTable
		$sWhere";

		$ret=$this->Clients_model->getData($sQuery);
	
		$res['ok']=true;
		echo json_encode($res);	
		
	}
	function ajaxDeleteAllWaitClient(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$searchObject=json_decode($req['filterString']);
		if($searchObject->searchType == 0){
				$searchItems= $this->createDefaultSearchObject($searchObject->searchText);
		}
		else if($searchObject->searchType == 1){
			$searchItems=$searchObject->searchText;
		}
		

		$sWhere=$this->datatabes_helper->getSearchSql($searchItems);	
		$sTable="clients_wait";
			
		$sQuery="select clients_wait.client_id from clients_wait left join clients on clients_wait.client_id=clients.client_id $sWhere";
		$rs=$this->db->query($sQuery)->result_array();
		
		if($rs){
			foreach($rs as $item){
				$sQuery="delete from clients where client_id =".$item['client_id'];
				//$this->db->query($sQuery);
				$sQuery="delete from clients_wait where client_id =".$item['client_id'];
				$this->db->query($sQuery);
			}
		}		
		
		$res['ok']=true;
		echo json_encode($res);	
		
	}
	
	public function ajaxYuyueClientLook(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		
		$output = array(	
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 1,
		"iTotalDisplayRecords" => 1,
		"aaData" => array()
		);
		
		$searchObject=json_decode($req['filterString']);
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
		$aColumns = array('client_id', 'client_name', 'client_sex','client_cell_phone','client_phone','client_address','yuyue_note','yuyue_time','client_agent','client_id','name');
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
		$sWhere="";
		$searchItem=$this->createSearchSql($searchObject);
		
		$sWhere=$this->datatabes_helper->getSearchSql($searchItem);
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'yuyue_time','desc');
		$sFields="clients.client_id,client_name,client_sex,client_cell_phone,client_phone,client_address,yuyue_note,yuyue_time,client_agent,clients.client_id,name";
		$sTable="clients_yuyue left join clients on clients_yuyue.client_id=clients.client_id left join agents on client_agent=code";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS $sFields 
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit ";
	
		$this->firephp->info($sQuery);
		
		$ret=$this->Clients_model->getData($sQuery);	
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		$ret=$this->Clients_model->getData($sCount)->result_array();
		
		$this->firephp->info($sCount);
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output); 
	}
	//查询待沟通用户
	public function ajaxAllWaitCommunicateClient(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 1,
		"iTotalDisplayRecords" => 1,
		"aaData" => array()
		);
				
		$searchObject=json_decode($req['filterString']);
		
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
	
		$aColumns = array('client_id', 'client_name', 'client_sex', 'client_cell_phone', 'client_phone','client_address','client_ctime','client_agent','client_id','name');
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
		$sWhere="";
		$searchItem=$this->createSearchSql($searchObject);

		$sWhere=$this->datatabes_helper->getSearchSql($searchItem);
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'clients.client_id','asc');
		$sFields="clients.client_id,client_name,client_sex,client_cell_phone,client_phone,client_address,client_ctime,client_agent,clients.client_id,name";
		$sTable="clients_wait left join clients on clients_wait.client_id=clients.client_id left join agents on client_agent=code";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS $sFields
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit ";
		
		$this->firephp->info($sQuery);
		//echo $sQuery;
		
		$ret=$this->Clients_model->getData($sQuery);	
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		$ret=$this->Clients_model->getData($sCount)->result_array();
		
		$this->firephp->info($sCount);
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];

		//print_r($output);
		
		echo json_encode($output);
	}
	//查询已沟通客户
	public function ajaxAlreadyCommunicatedClientLook(){
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
		$this->firephp->info($searchObject);
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
		
		$aColumns = array('client_id', 'client_name', 'client_sex',  'client_cell_phone','client_phone','client_address','client_ctime','client_modify_time','client_agent','client_id','name');
		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
		$sWhere="";
		
		$seachItems= $this->createSearchSql($searchObject);
			
		$sWhere=$this->datatabes_helper->getSearchSql($seachItems);
		//$this->firephp->info($sWhere);
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'client_agent','desc');
	
		$sTable="clients left join agents on client_agent=code";
		
		$sWhere.=" and client_modify_time is not null";
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
		
		echo json_encode($output);
	}
	//重定向客户
	public function ajaxRedirectClientLook(){
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
		$this->firephp->info($searchObject);
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
		
		$aColumns = array('client_id', 'client_name', 'client_sex',  'client_cell_phone','client_phone','client_address','client_ctime','client_modify_time','client_agent','client_id','name');
		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
		$sWhere="";
		
		//$seachItems= $this->createSearchSql($searchObject);
		$seachItems=$searchObject->searchText;
		$this->firephp->info($seachItems);
		$sWhere=$this->datatabes_helper->getSearchSql($seachItems);
		
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'client_agent','desc');
	
		$sTable="clients left join agents on client_agent=code";
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
		
		echo json_encode($output);
	}
	
	//查询所有客户
	public function ajaxAllClientLook(){
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
		$this->firephp->info($searchObject);
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
		
		$aColumns = array('client_id', 'client_name', 'client_sex',  'client_cell_phone','client_phone','client_address','client_ctime','client_modify_time','client_agent','client_id','name');
		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
		$sWhere="";
		
		$seachItems= $this->createSearchSql($searchObject);
			
		$sWhere=$this->datatabes_helper->getSearchSql($seachItems);
		//$this->firephp->info($sWhere);
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'client_agent','desc');
	
		$sTable="clients left join agents on client_agent=code";
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
		
		echo json_encode($output);
	}
	
	function createSearchSql($searchObject){
		$sWhere="";
		if($searchObject->searchType == 0){
			return $this->appendAgentToSearchObject($this->createDefaultSearchObject($searchObject->searchText));
		}
		else if($searchObject->searchType == 1){
			return $this->appendAgentToSearchObject($searchObject->searchText);
		}
		return array();
	}
	
	function createDefaultSearchObject($text){
		if($text == '')
			return array();
		$searchObject=array();
		array_push($searchObject,array('likeor','varchar','client_name',$text));
		array_push($searchObject,array('likeor','varchar','client_phone',$text));	
		array_push($searchObject,array('likeor','varchar','client_address',$text));
		array_push($searchObject,array('likeor','varchar','client_sex',$text));
		return $searchObject;
	}
	
	function appendAgentToSearchObject($searchObject){	
		$agents=$this->agent_helper->getClientAgentsCanShow();
		array_push($searchObject,$agents);
		
		return $searchObject;
	}
	 
	//加载添加新客户视图
	public function add($agentId){
		$res['agentId']=$agentId;
		$this->load->view('client_add_view',$res);	
	}
	public function ajaxAdd(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		

		require('/var/www/html/config.php');
		$items=array_combine($req['field'],$req['fieldValue']);
		$res['ok']=true;
		
		$this->load->library('Dynamicui',array("agentId"=>""));
		$modelName=$this->dynamicui->getDynamicuiModel();

		
		$this->load->model($modelName);
		$allDbFields=$this->$modelName->getAllDbFileds();
		//print_r($allDbFields);
		
		$this->firephp->info($allDbFields);

		
		//判断号码是否存在
		if($items['client_phone'] !='' && $this->Clients_model->selectClientByPhone($items['client_phone'],$allDbFields)){
			$res['ok']=false;
			$res['fail']=$items['client_phone'].'已存在';
		}	
		
		if($items['client_cell_phone'] !='' && $this->Clients_model->selectClientByPhone($items['client_cell_phone'],$allDbFields)){
			$res['ok']=false;
			$res['fail']=$items['client_cell_phone'].'号码已存在';		
		}

		if($items['client_person_card'] !='' && $this->db->query("select client_id from clients where client_person_card='".$items['client_person_card']."'")->result_array()){
			$res['ok']=false;
			$res['fail']=$items['client_cell_phone'].'号码已存在';
			
		}
	
	
		//判断客户是否存在
		if($res['ok']){
			$items['client_ctime']=date("Y-m-d H:i:s");
			$items['client_agent']=$req['agentId'];
			$items['client_creater']=$req['agentId'];
			
	
			$client_id=$this->Clients_model->insert($items);

			$sql="select list_id from ".$db_config["database"].".vicidial_lists where campaign_id='".$req['campaignId']."';";
			$row=$this->Clients_model->getData($sql)->result_array();
			//echo $sql."$$$$$$$$$$$$$$$$$$$\n";
			//echo $row[0]['list_id'];
			//添加客户到vici_list中
			$ssh = $this->Clients_model->syn_row_list($items,$row[0]['list_id']);
			//print_r($ssh);
			$this->Clients_model->insert_list($ssh);

			
			//$this->Clients_model->insert_vicidial_list($client_id);
			$res['nextUrl']=site_url('communicate/connected/manulClick').'/'.$req['agentId'].'/'.$client_id;
		}
		$this->firephp->info($res);


		
		echo json_encode($res);
	}

	public function	ajaxAddWaitComm(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$this->firephp->info($req);
		
		if($req["ids"]){
			foreach($req["ids"] as $id){
					
				$sCount = "select count(*) from clients_wait where client_id='$id'";
				$ret=$this->db->query($sCount)->result_array();
				//添加
				if($ret[0]["count(*)"] == 0){
					
					$sql="insert into clients_wait (client_id,add_time) values('".$id."',now())";
					$this->db->query($sql);
					$res["ok"]=true;
				}else{
					$res["ok"]=false;
				}	
			}
			
		}else
			$res["ok"]=false;
		echo json_encode($res);  
	}
	
	public function import($agentId)
	{
		$data['agentId']=$agentId;
		$this->load->view('client_import_view',$data);
	}
	public function record()
	{
		$this->load->view('client_import_record_view');
	}
	

	public function tooltips($id)
	{
		$data['title']=$id;
		$this->load->view('user_tooltips_view',$data);
	}
	
	public function ajaxUploadMap()
	{
		header('Content-type: Application/json',true);
		
		$req=$this->input->post();
		
		$this->load->library('excel_helper');
		$this->load->library('firephp');
		
		$data[0]=array('value'=>-1,'text'=>'');
		$this->firephp->info('begin load');
		$this->excel_helper->load('./uploaddir/'.$req['file']);
		$this->firephp->info($this->excel_helper->get_columns());		
		foreach($this->excel_helper->get_columns() as $key=>$value){
			array_push($data,array('value'=>$value,'text'=>$value));
		}
		
		$this->load->library('Dynamicui',array("agentId"=>""));
		$modelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($modelName);
		
		$res['importMap']=$this->$modelName->getImportTableMap();
		
		$this->firephp->info($data);	
		$this->excel_helper->clear();	
		
		$res["excelColumns"]=$data;
		echo json_encode($res);
	}
	
	
	public function doUpload(){
		header('Content-type: Application/json',true);	
    	$req=$this->input->post();
		$this->load->library("utility_func");
		$batchNumber=$this->utility_func->getClientBatchNumber();
		require('/var/www/html/config.php');
		
		//插入数据导临时表
		//print_r($batchNumber);
        $this->insertDataToTmpTable($req['agentId'],$req['file'],$req['dataMap'],$batchNumber);
		$this->firephp->info($req['rules']);
		
		$fields=implode(",",array_keys($req['dataMap']));
		//print_r($req['dataMap']);
		//临时表和总表数据排重
		$res=$this->removeDup('clients_tmp','clients',$req['rules'],$fields);	
		
		if($res['ok'] == 1){  
		 
		  $fields.=",client_ctime,client_creater,client_batch_number";
		  $sql="INSERT INTO clients(".$fields.") SELECT ".$fields." FROM clients_tmp";
		  $this->firephp->info($sql);
		  $this->db->query($sql);

		  $sql="INSERT INTO clients_wait(client_id,add_time) 
		  SELECT client_id,now() FROM  clients where client_batch_number='$batchNumber'";
		  $this->db->query($sql);

		  //将导入edu的信息同步到vicidial_list中
		  
		  $sql="select list_id from ".$db_config["database"].".vicidial_lists where campaign_id='".$req['campaignId']."';";
		  $list=$this->Clients_model->getData($sql)->result_array();
	      
		  $m_sql="select client_ctime,client_name,client_agent,client_cell_phone from ".$db_config["database2"].".clients where client_batch_number='".$batchNumber."'";
		  $client_vici = $this->Clients_model->getData($m_sql)->result_array();
		  
		  foreach($client_vici as $row){
				//echo $row['client_cell_phone'];
				$ssh = $this->Clients_model->syn_comment_insert_list($row,$list[0]['list_id']);
				$this->Clients_model->insert_list($ssh);
		  }


		}
        echo json_encode($res); 	
	}

	
	function insertDataToTmpTable($agentId,$file,&$columnMap,$bathNumber)
	{
		$this->excel_helper->load('./uploaddir/'.$file);	
		$this->firephp->info('./uploaddir/'.$file);
		$count=0;
		$this->Clients_model->clearClientTmp();
		//数据插入临时表
		while ($item=$this->excel_helper->next()){
			foreach($columnMap as $key=>$value){
				if($value != '-1')
					$data[$key]=$item[$value];
			}	
					
			$this->Clients_model->filter($data);
			$data['client_ctime']=date("Y-m-d H:i:s",time()); 
			$data['client_creater']=$agentId;
			$data["client_batch_number"]=$bathNumber;
			if(!isset($data["client_agent"]))
				$data["client_agent"]=$agentId;	


			//print_r($data);
			if ($this->Clients_model->insertToClientTmp($data))
			$count++;
			
		}				
		$this->excel_helper->clear();	
	}
	
	function removeDup($srcTable, $dstTable,$rules,$fields)
	{
		$dup['ok']=1;
		$dup['datas']=array();
		$excuteDup=0; 
		$fields.=",client_id";
		
		
		$this->firephp->info("排重规则".$rules."字段".$fields);
		
		
		$ret=$this->db->query("select $fields from $srcTable")->result_array();
		$countClients=0;
		//echo "111111111111111";
		
		foreach($ret as $item){  	  
			//排重	
			$phones=array();
			if($item['client_cell_phone'] != ''){
				$str=$item['client_cell_phone'];
				array_push($phones,$str);
				if(substr($str,0,1) == '0'){
					array_push($phones,substr($str,1));
				}
				else{
					array_push($phones,'0'.$str);
				}
			}
			
			if($item['client_phone'] != ''){
				$str=$item['client_phone'];
				array_push($phones,$str);
				if(substr($str,0,1) == '0'){
					array_push($phones,substr($str,1));
				}
				else{
					array_push($phones,'0'.$str);
				}
			}
			
			if(isset($item['client_phone_two']) && $item['client_phone_two'] != ''){
				$str=$item['client_phone_two'];
				array_push($phones,$str);
				if(substr($str,0,1) == '0'){
					array_push($phones,substr($str,1));
				}
				else{
					array_push($phones,'0'.$str);
				}
			}
			
			if(isset($item['client_cell_phone_two']) && $item['client_cell_phone_two'] != ''){
				$str=$item['client_cell_phone_two'];
				array_push($phones,$str);
				if(substr($str,0,1) == '0'){
					array_push($phones,substr($str,1));
				}
				else{
					array_push($phones,'0'.$str);
				}
			}
			
			
			
			if(count($phones) > 0 ){			
				//号码+姓名排重
				if($rules == 1 && (isset($item['client_name']) && $item['client_name'] != '')){
					$this->db->where('client_name',$item['client_name']);
				}
					
				$this->db->where_in('client_cell_phone', $phones);
				$this->db->or_where_in('client_phone', $phones);
				$this->db->or_where_in('client_phone_two', $phones);
				$this->db->or_where_in('client_cell_phone_two', $phones);
				
				$excuteDup=1;
			}
			
			if($item['client_person_card'] != ''){
				$excuteDup=1;
				$this->db->or_where('client_person_card',$item['client_person_card']);
			}
			
		    if($excuteDup == 1){
				$q=$this->db->select("count(*) as count")->from($dstTable);
				$row=$q->get()->result();
				if($row[0]->count>0){
					$this->db->where('client_id', $item['client_id']);
					//$this->db->delete($srcTable);
					array_push($dup['datas'],array($item['client_excel_id'],"身份证:".$item['client_person_card']."电话:".implode(',',$phones)));				
					$dup['ok']=0;									
				}		
			}else{
				array_push($dup['datas'],array($item['client_excel_id'],"所有电话号码为空的数据"));
			}
			$countClients++;
			$excuteDup=0;		
		}		
		$dup['counts']=$countClients;
		return $dup;
	}
	
		
	function ajaxSelectOutDisplayNumber(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$this->firephp->info($req['ids']);
		$sWhere=$this->datatabes_helper->getSearchSql($req['ids']);
		$targetAgent=$req['targetAgent'];
		$targetNumberId=$req['targetNumberId'];
		if($sWhere != ""){
			
			$sTable="agents";
			/*$sQuery = "
			update  $sTable set out_display_number_id='$targetNumberId' 
			where code='$targetAgent'";*/
			$sQuery = "
			update  $sTable set out_display_number_id='$targetNumberId' 
			$sWhere";

		
			$this->firephp->info($sQuery);
			$ret=$this->Clients_model->getData($sQuery);
			
			$res['ok']=true;
		}else{
			$res['ok']=false;
		}
		
		echo json_encode($res);
	}

	function ajaxGetClientID(){	
		header('Content-type: Application/json',true);
		$req=$this->input->post();

		$this->load->library('firephp');
		$phone_number=$req['phone_number'];

		$sQuery = "
		SELECT client_id from clients where client_cell_phone='$phone_number'";
		$data=$this->db->query($sQuery)->result_array();

		
		$ret["data"]=$data[0]['client_id'];
		$ret['ok']=true;
		
		echo json_encode($ret);		
	}	
	
	
}
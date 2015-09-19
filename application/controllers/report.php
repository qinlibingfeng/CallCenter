<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->library('DataTabes_helper');
		$this->load->library('Utility_func');
		$this->load->library('firephp');
		date_default_timezone_set('Asia/Shanghai');
	}
	
	function customClientCount($agentId){
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
		$headerFileds=array();
		
		$this->load->library('Dynamicui',array("agentId"=>""));
		$dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		$data["headerFileds"]=$this->$dyModelName->getCustomClientCountItem();	
		$this->load->view('report_custom_client_count_view',$data);
	}
	
	function callCount($agentId){		
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
		
		$this->load->view('report_call_count_view',$data);
	}
	function callLengthCount($agentId){
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
		
		$this->load->view('report_calllength_count_view',$data);
	}
	
	function callLengthSumCount($agentId){
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
		
		$this->load->view('report_calllength_sumcount_view',$data);
	}
	
	function conversionRate($agentId){
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
		
		$this->load->view('report_conversion_rate_view',$data);
	}
	
	function clientStatusCount($agentId){		
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
		
		$this->load->view('report_client_status_count_view',$data);
	}
	function customClient($agentId){
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
		$data["searchPanelTableData"]=$this->$dyModelName->getCustomSearchPanel();
		$data["tableHeader"]=$this->$dyModelName->getCustomClientTableHeader();
		
		$this->load->view('report_custom_client_view',$data);
		
	}
	
	function communicate($agent){
		$timeOptions=$this->utility_func->creatHourMinOptions();
		$data['beginTime']=$timeOptions;
		$data['beginTime']['ymh']=date('Y-m-d');
		$data['beginTime']['hourDef']='00';
		$data['beginTime']['minDef']='00';
		
		$data['endTime']=$timeOptions;
		$data['endTime']['ymh']=date('Y-m-d');
		$data['endTime']['hourDef']='23';
		$data['endTime']['minDef']='59';
		$data['agentId']=$agent;
		
		$this->load->library('Agent_helper',array('agent_id'=>$agent));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		$showAgents=$this->Users_model->getNameValueByIds($agents[3]);
		if($showAgents){
			array_push($showAgents,array("name_value"=>"全部","name_text"=>"全部"));
			array_push($showAgents,array("name_value"=>"未填写","name_text"=>"未填写"));
		}
		
		$data['targetAgents']=$showAgents;
		$this->load->view('report_communicate_view',$data);
	}
	
	function liveLook($agentId){
		$data["agentId"]=$agentId;
		$this->load->view('report_live_look_view',$data);
	}
	function misscall($agent){
		$data['agentId']=$agent;
		$timeOptions=$this->utility_func->creatHourMinOptions();
		$data['beginTime']=$timeOptions;
		$data['beginTime']['ymh']=date('Y-m-d');
		
		$data['beginTime']['hourDef']='00';
		$data['beginTime']['minDef']='00';
		
		$data['endTime']=$timeOptions;
		$data['endTime']['ymh']=date('Y-m-d');
		$data['endTime']['hourDef']='23';
		$data['endTime']['minDef']='59';
		
		$this->load->library('Agent_helper',array('agent_id'=>$agent));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		$showAgents=$this->Users_model->getNameValueByIds($agents[3]);
		if($showAgents){
			array_push($showAgents,array("name_value"=>"全部","name_text"=>"全部"));
			array_push($showAgents,array("name_value"=>"未填写","name_text"=>"未填写"));
		}
		
		$data['targetAgents']=$showAgents;
		$this->load->view('report_misscall_view',$data);
	}
	function leavemess($agent){
		$data['agentId']=$agent;
		$timeOptions=$this->utility_func->creatHourMinOptions();
		$data['beginTime']=$timeOptions;
		$data['beginTime']['ymh']=date('Y-m-d');
		
		$data['beginTime']['hourDef']='00';
		$data['beginTime']['minDef']='00';
		
		$data['endTime']=$timeOptions;
		$data['endTime']['ymh']=date('Y-m-d');
		$data['endTime']['hourDef']='23';
		$data['endTime']['minDef']='59';
		
		$this->load->library('Agent_helper',array('agent_id'=>$agent));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		$showAgents=$this->Users_model->getNameValueByIds($agents[3]);
		if($showAgents){
			array_push($showAgents,array("name_value"=>"全部","name_text"=>"全部"));
			array_push($showAgents,array("name_value"=>"未填写","name_text"=>"未填写"));
		}
		
		$data['targetAgents']=$showAgents;
		$this->load->view('report_leavemessage_view',$data);
	}

	
	function ajaxReportCustomClientCount(){
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
		//$this->firephp->info($req['filterString']);
		
		$this->load->library('Dynamicui',array("agentId"=>""));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
		$this->firephp->info($sWhere);
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sTable="clients";
		
		if($req["isAllCount"] == "true")
			$sGroup="group by client_agent ,DATE_FORMAT(client_modify_time,'%Y-%m-%d') with ROLLUP";
		else
			$sGroup="group by client_agent ,DATE_FORMAT(client_modify_time,'%Y-%m-%d')";
		
		
		$dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		$customItem=$this->$dyModelName->getCustomClientCountItem();	
		$customDbField=$this->$dyModelName->getCustomClientCountDbField();
		
		$sField="client_agent ,DATE_FORMAT(client_modify_time,'%Y-%m-%d') as 'callDate'";

		foreach($customItem as $item){
			$sField.=",sum(case ".$customDbField." when  '".$item."' then 1  else 0 end) as ".$item;	
		}
		
		$sQuery = "SELECT
		$sField 
		from  $sTable 
		$sWhere
		$sGroup
		$sLimit";
		
		$this->firephp->info($sQuery);
		$ret=$this->db->query($sQuery);	
		$aColumns=array();
		array_push($aColumns,'client_agent');
		array_push($aColumns,'callDate');
		
		$aColumns=array_merge($aColumns,$customItem);
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$sCount="select count(*) as sCount from (select client_agent,DATE_FORMAT(client_modify_time,'%Y-%m-%d') 
		from clients $sWhere $sGroup) dataTable";
		
		$ret=$this->db->query($sCount)->result_array();
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output);	
		
	}
	function ajaxConversionRate(){
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
		//$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>""));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		$this->firephp->info($searchObject);
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
		foreach($searchObject as $sitem){
			$this->firephp->info($sitem[2]);
			if($sitem[2] == "client_modify_time"){
				$startTime=$sitem[3];
				$endTime=$sitem[4];
			}
		}
		
		$this->firephp->info($sWhere);
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sTable="clients";
		
		if($req["isAllCount"] == "true")
			$sGroup="group by client_agent ,DATE_FORMAT(client_modify_time,'%Y-%m-%d') with ROLLUP";
		else
			$sGroup="group by client_agent ,DATE_FORMAT(client_modify_time,'%Y-%m-%d')";
		$this->firephp->info($req);
		
		$sField="client_agent ,DATE_FORMAT(client_modify_time,'%Y-%m-%d') as 'callDate',
sum(case when client_ctime >'$startTime' and client_ctime <'$endTime' then 1 else 0 end) as newTime,
sum(case when client_ctime <'$startTime' or client_ctime >'$endTime' then 1 else 0 end) as oldTime,
sum(case when client_modify_time >'$startTime' and client_modify_time <'$endTime' then 1 else 0 end) as total";

		$sQuery = "SELECT
		$sField 
		from  $sTable 
		$sWhere
		$sGroup
		$sLimit";

		$this->firephp->info($sQuery);
		$ret=$this->db->query($sQuery);	
		$aColumns=array('client_agent','callDate','newTime','oldTime','total');
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$sCount="select count(*) as sCount from (select client_agent,DATE_FORMAT(client_modify_time,'%Y-%m-%d') 
		from clients $sWhere $sGroup) dataTable";
		
		$ret=$this->db->query($sCount)->result_array();
	
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		//$this->firephp->info($output);
		
		echo json_encode($output);	
	}
	function ajaxReportCallLengthCount(){
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
		//$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>""));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
		$this->firephp->info($sWhere);
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sTable="cc_call_history";
		
		if($req["isAllCount"] == "true")
			$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') with ROLLUP";
		else
			$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d')";
		$this->firephp->info($req);
		
		$sField="agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') as 'callDate',
sum(case when call_times <=5 then 1 else 0 end) as less_5,
sum(case when call_times> 5 and   call_times <= 10  then 1 else 0  end)  as more_5_less_10,
sum(case when call_times> 10 and   call_times <= 15  then 1 else 0  end)  as more_10_less_15,
sum(case when call_times> 15 and   call_times <= 20  then 1 else 0  end)  as more_15_less_20,
sum(case when call_times> 20 and   call_times <= 25  then 1 else 0  end)  as more_20_less_25,
sum(case when call_times> 16 and   call_times <= 30  then 1 else 0  end)  as more_16_less_30,
sum(case when call_times> 30 and   call_times <= 60  then 1 else 0  end)  as more_30_less_60,
sum(case when call_times> 60 and call_times <=90 then 1 else 0 end)  as more_60_less_90,
sum(case when call_times> 90 then 1 else 0 end)  as more_90,
sum(call_times) as  total_times";

		$sQuery = "SELECT
		$sField 
		from  $sTable 
		$sWhere and call_times>0
		$sGroup
		$sLimit";
	
		
		$this->firephp->info($sQuery);
		$ret=$this->db->query($sQuery);	
		$aColumns=array('agent','callDate','less_5','more_5_less_10','more_10_less_15','more_15_less_20','more_20_less_25','more_16_less_30','more_30_less_60','more_60_less_90','more_90','total_times');
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$sCount="select count(*) as sCount from (select agent,DATE_FORMAT(link_stime,'%Y-%m-%d') 
		from cc_call_history $sWhere $sGroup) dataTable";
		
		$ret=$this->db->query($sCount)->result_array();
	
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		//$this->firephp->info($output);
		
		echo json_encode($output);	
	}
	function ajaxReportCallLengthSumCount(){
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
		//$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>""));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
		$this->firephp->info($sWhere);
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sTable="cc_call_history";
		
		if($req["isAllCount"] == "true")
			$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') with ROLLUP";
		else
			$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d')";
		$this->firephp->info($req);
		
		$sField="agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') as 'callDate',
sum(case when call_times <=5 then 1 else 0 end) as less_5,
sum(case when call_times> 5 and   call_times <= 10  then 1 else 0  end)  as more_5_less_10,
sum(case when call_times> 10 and   call_times <= 15  then 1 else 0  end)  as more_10_less_15,
sum(case when call_times> 15 and   call_times <= 20  then 1 else 0  end)  as more_15_less_20,
sum(case when call_times> 20 and   call_times <= 25  then 1 else 0  end)  as more_20_less_25,
sum(case when call_times> 16 and   call_times <= 30  then 1 else 0  end)  as more_16_less_30,
sum(case when call_times> 30 and   call_times <= 60  then 1 else 0  end)  as more_30_less_60,
sum(case when call_times> 60 and call_times <=90 then 1 else 0 end)  as more_60_less_90,
sum(case when call_times> 90 then 1 else 0 end)  as more_90,
sum(call_times) as  total_times";

		$sQuery = "SELECT
		$sField 
		from  $sTable 
		$sWhere
		$sLimit";
	
		
		$this->firephp->info($sQuery);
		$ret=$this->db->query($sQuery);	
		$aColumns=array('agent','callDate','less_5','more_5_less_10','more_10_less_15','more_15_less_20','more_20_less_25','more_16_less_30','more_30_less_60','more_60_less_90','more_90','total_times');
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$sCount="select count(*) as sCount from (select agent,DATE_FORMAT(link_stime,'%Y-%m-%d') 
		from cc_call_history $sWhere $sGroup) dataTable";
		
		$ret=$this->db->query($sCount)->result_array();
	
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		//$this->firephp->info($output);
		
		echo json_encode($output);	
	}
	function ajaxReportCallCount(){
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
		//$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>""));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
		$this->firephp->info($sWhere);
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sTable="cc_call_history";
		
		if($req["isAllCount"] == "true")
			$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') with ROLLUP";
		else
			$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d')";
		$this->firephp->info($req);
		
		$sField="agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') as 'callDate',
sum(case status when  'CONNECTED' then case call_type when 'callout' then 1 else 0 end  else 0 end) as sumCalloutConnect,
sum(case call_type when 'callout' then case `status` when 'CONNECTED' then 0 else 1 end  else 0 end) as sumCalloutUnConnnect,
sum(case call_type when 'callout' then 1 else 0 end) as sumCallout,
sum(case status when  'CONNECTED' then case call_type when 'callin' then 1 else 0 end  else 0 end) as  sumCallinConnect,
sum(case call_type when 'callin' then case `status` when 'CONNECTED' then 0 else 1 end  else 0 end) as sumCallinUnConnnect,
sum(case call_type when 'callin' then 1 else 0 end) as sumCallin";

		$sQuery = "SELECT
		$sField 
		from  $sTable 
		$sWhere
		$sGroup
		$sLimit";
	
		
		
		$ret=$this->db->query($sQuery);	
				$aColumns=array('agent','callDate','sumCalloutConnect','sumCalloutUnConnnect','sumCallout','sumCallinConnect','sumCallinUnConnnect','sumCallin');
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$sCount="select count(*) as sCount from (select agent,DATE_FORMAT(link_stime,'%Y-%m-%d') 
		from cc_call_history $sWhere $sGroup) dataTable";
		
		$ret=$this->db->query($sCount)->result_array();
	
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		//$this->firephp->info($output);
		
		echo json_encode($output);	
	}
	function ajaxReportClientStatusCount(){
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
		//$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>""));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
		$this->firephp->info($sWhere);
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sTable="cc_call_history";
		$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') with ROLLUP";
		$sField="agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') as 'callDate',
sum(case status when  'CONNECTED' then case call_type when 'callout' then 1 else 0 end  else 0 end) as sumCalloutConnect,
sum(case call_type when 'callout' then case `status` when 'CONNECTED' then 0 else 1 end  else 0 end) as sumCalloutUnConnnect,
sum(case call_type when 'callout' then 1 else 0 end) as sumCallout,
sum(case status when  'CONNECTED' then case call_type when 'callin' then 1 else 0 end  else 0 end) as  sumCallinConnect,
sum(case call_type when 'callin' then case `status` when 'CONNECTED' then 0 else 1 end  else 0 end) as sumCallinUnConnnect,
sum(case call_type when 'callin' then 1 else 0 end) as sumCallin";
		$sQuery = "SELECT
		$sField 
		from  $sTable 
		$sWhere
		$sGroup
		$sLimit";
	
		//$this->firephp->info($sQuery);
		
		$ret=$this->db->query($sQuery);	
				$aColumns=array('agent','callDate','sumCalloutConnect','sumCalloutUnConnnect','sumCallout','sumCallinConnect','sumCallinUnConnnect','sumCallin');
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$sCount="select count(*) as sCount from (select agent,DATE_FORMAT(link_stime,'%Y-%m-%d') 
		from cc_call_history $sWhere $sGroup) dataTable";
		
		$ret=$this->db->query($sCount)->result_array();
	
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		//$this->firephp->info($output);
		
		echo json_encode($output);	
	}
	function ajaxReportCustomClientLook(){
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
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		array_push($aColumns,'client_id');
		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
		$this->firephp->info("where is");
		$this->firephp->info($sWhere);
		
		
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'client_ctime','desc');
	
		$sTable="clients";
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
	
	function ajaxReportCommunicate(){	
		header('Content-type: Application/json',true);	
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 0,
		"iTotalDisplayRecords" => 0,
		"aaData" => array()
		);
		
		$this->load->library('Dynamicui',array("agentId"=>""));
		$modelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($modelName);
		$allDbFields=$this->$modelName->getAllDbFileds();
		
		$searchObject=json_decode($req['filterString']);
		$this->firephp->info($searchObject);
		
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));	
		$setData=$this->agent_helper->getReportAgentsCanShow();
	    array_push($searchObject->searchText,$setData);
		
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject->searchText);
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		$aColumns = array('agent','name','phone_number', 'phone_number_name','call_type' ,'status' ,'link_stime','call_times', 'inqueue_wait_times','call_exten','location');	
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'link_stime','desc');
		$sTable="cc_call_history left join agents on cc_call_history.agent=agents.code";
		$fields="agent,name,phone_number,'' as phone_number_name,call_type,status,link_stime,call_times,inqueue_wait_times,call_exten,location";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS $fields
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit ";
	
		$this->firephp->info($sQuery);	
		$ret=$this->db->query($sQuery);	
		
		$this->firephp->info($ret->result_array());
		
		$datas=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns,'autoid');
	
		foreach($datas as &$row){
			if($row[2] != ""){
				$item=$this->Clients_model->selectClientByPhone($row[2],$allDbFields);	
				$row[3]=isset($item[0]["client_name"])?$item[0]["client_name"]:"";	
			}
		}
		
		$output["aaData"]=$datas;
		
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
	

		$this->firephp->info($sCount);
		
		$ret=$this->db->query($sCount)->result_array();
	
		
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output);
	}
	
	
	function ajaxGetOneRecord(){
		header('Content-type: Application/json',true);
		$this->load->model('Communicate_model');
		$req=$this->input->post();
		$data=$this->Communicate_model->getOneRecordById($req['autoid']);
		echo json_encode($data);
	}	
	
	function ajaxThreeDaysCount(){
		header('Content-type: Application/json',true);
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 1,
		"iTotalDisplayRecords" => 1,
		"aaData" => array()
		);
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sWhere="";
		$this->load->library('Agent_helper',array('agent_id'=>$req['agentId']));
			$this->load->library('firephp');
		$seachItems=$this->agent_helper->getReportAgentsCanShow();
		$this->firephp->info("search item");
		
		$sWhere=$this->datatabes_helper->getSearchSql($seachItems);
		$this->firephp->info($sWhere);
		if($sWhere == ""){
		//获得where语句
			$sWhere="where agent <> '0000'";
		}else{
			$sWhere.=" and  agent <> '0000'";
		}
		$beginTime=date('Y-m-d')." 00:00:00";
		$endTime=date("Y-m-d")." 23:00:00";
		
		$sfiled="agent,
				name,
				sum(case call_type  when 'callin' then 1 else 0 end) as callin,
				sum(case call_type  when 'callout' then 1 else 0 end) as callout,
				count(call_type) as callall";
		$sWhere.=" and link_stime between  '$beginTime' and '$endTime'";
		$sOrder="order by agent";
		$sGroup="group by agent";
		$sTable="cc_call_history left join agents on code=agent";
		$sQuery = "
		SELECT $sfiled
		FROM   $sTable
		$sWhere
		$sGroup
		$sOrder
		$sLimit ";
			
		$this->firephp->info($sQuery);
		$ret=$this->db->query($sQuery);
		$aColumns=array("agent","name","callin","callout","callall");
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$this->firephp->info($output["aaData"]);
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		
		$ret=$this->Clients_model->getData($sCount)->result_array();
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output);
	}
	
	function ajaxReportLeaveMessage(){
		header('Content-type: Application/json',true);	
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 1,
		"iTotalDisplayRecords" => 1,
		"aaData" => array()
		);
		
		$searchObject=json_decode($req['filterString']);
		
		$aColumns = array('agent','name','phone_number','call_type' ,'status' ,'link_stime','autoid','location');
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
		$sWhere="";
		
		$this->firephp->info($req['filterString']);
		
		$this->firephp->info($searchObject);
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
	
		$setData=$this->agent_helper->getReportAgentsCanShow();
		array_push($setData[3],'0000');
		array_push($searchObject->searchText,$setData);
		
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject->searchText);
		
		$this->firephp->info($sWhere);

		
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'link_stime','desc');
		$sTable="cc_call_history left join agents on cc_call_history.agent=agents.code";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere and is_leavemess=1
		$sOrder
		$sLimit ";
	
		$this->firephp->info($sQuery);
		
		$ret=$this->db->query($sQuery);	
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns,'autoid');
		
		$this->firephp->info($output["aaData"]);
		
		$sCount="select count(*) as sCount from $sTable $sWhere and is_leavemess=1 $sOrder";

	
		
		$this->firephp->info($sCount);
		
		$ret=$this->db->query($sCount)->result_array();

		//echo $ret[0]["sCount"];
	
		
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output);
	}
	function ajaxReportMisscall(){	
		header('Content-type: Application/json',true);	
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 1,
		"iTotalDisplayRecords" => 1,
		"aaData" => array()
		);
		
		$searchObject=json_decode($req['filterString']);
		
		$aColumns = array('agent','name','phone_number','call_type' ,'status', 'call_exten','link_stime','alloted','autoid');
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
		$sWhere="";
		
		$this->firephp->info($req['filterString']);
		
		$this->firephp->info($searchObject);
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
	
		$setData=$this->agent_helper->getReportAgentsCanShow();
		array_push($setData[3],'0000');
		array_push($searchObject->searchText,$setData);
		
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject->searchText);
		
		$this->firephp->info($sWhere);

		
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'link_stime','desc');
		$sTable="cc_call_history left join agents on cc_call_history.agent=agents.code";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit ";
	
		$this->firephp->info($sQuery);
	//	echo $sQuery;
		$ret=$this->db->query($sQuery);	
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns,'autoid');
		
		$this->firephp->info($output["aaData"]);
		
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		
		$this->firephp->info($sCount);
		
		$ret=$this->db->query($sCount)->result_array();
	
		
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output);
	}
	function ajaxAllotMisscall(){	
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		
		$req=$this->input->post();
		$searchObject=json_decode($req['filterString']);
		$this->firephp->info($searchObject);	
			
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
		
		$setData=$this->agent_helper->getReportAgentsCanShow();
		array_push($setData[3],'0000');
		array_push($searchObject->searchText,$setData);
		

		$setData2 = array('and','varchar','alloted','N');
		array_push($searchObject->searchText,$setData2);	
		
		
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject->searchText);
		
		$aColumns = array('autoid','phone_number','call_type' ,'status' ,'link_stime');
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'link_stime','desc');
		$sTable="cc_call_history left join agents on cc_call_history.agent=agents.code";
		$sQuery1 = "
		SELECT distinct(phone_number)
		FROM   $sTable
		$sWhere
		$sOrder";
	

		$sTable="cc_call_history left join agents on cc_call_history.agent=agents.code left join clients on cc_call_history.phone_number = clients.client_cell_phone ";
		$sQuery2 = "
		SELECT distinct(phone_number), clients.client_agent
		FROM   $sTable
		$sWhere  and clients.client_id !='' 
		$sOrder";

		//echo $sQuery;
		$this->firephp->info($sQuery2);	
		$data=$this->db->query($sQuery2)->result_array();
		$row_count = count($data);	

		$agents=json_decode($req['agents']);
		$this->firephp->info($agents);	
		$agents_count = count($agents);

		for($j=0; $j < $row_count;$j ++){			
				
			$this->allotAgents($data[$j]["phone_number"], $agents[$j]);
			//echo $data[$j]["phone_number"]." ---> ".$data[$j]["client_agent"]."..\n";
			
		}


		$this->firephp->info($sQuery1);	
		$data=$this->db->query($sQuery1)->result_array();

		$row_count = count($data);	
		echo $row_count;

		
		//echo "\nagents_count: $agents_count\n";
		
	

		for($j=0; $j <= $row_count - $agents_count; $j = $j+$agents_count){			
			for($i=0; $i< $agents_count; $i++){			
					$this->allotAgents($data[$j+$i]["phone_number"], $agents[$i]);
					//echo $data[$j+$i]["phone_number"]." ---> ". $agents[$i] ."\n";
			}			
		}
			
		
	
		$ret["ok"]=1;
		$ret["left"]= $row_count - $j;
		echo json_encode($ret);		
	}

	
	
	function ajaxGetAllAgents(){	
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		
		
		$sQuery = "
		SELECT code, name from agents  where out_display_number_id !='' order by name asc  ";
		$data=$this->db->query($sQuery)->result_array();

		$ret["data"]=$data;
		echo json_encode($ret);		
	}	
	
	function allotAgents($number,$agentcode){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		
		$sCount = "select count(*) from clients where client_cell_phone='$number'";
		$ret=$this->db->query($sCount)->result_array();

		//添加
		if($ret[0]["count(*)"] == 0){
			$today = date('Y-m-d h:i:s',time());
			$sQuery = "insert into clients(client_agent, client_cell_phone, client_ctime) values('$agentcode', '$number', '$today')";	
			$this->db->query($sQuery);
		}
		
		$sCount = "select count(*) from clients_wait where client_id=(select client_id from  clients where client_cell_phone='$number' order by client_id ASC LIMIT 1)";
		$ret=$this->db->query($sCount)->result_array();

		//添加
		if($ret[0]["count(*)"] == 0){
			
			$sQuery="insert into clients_wait (client_id,add_time) values((select client_id from  clients where client_cell_phone='$number'),now())";
			$this->db->query($sQuery);
		}else{
			$sQuery="update clients_wait set add_time=now() where client_id=(select client_id from  clients where client_cell_phone='$number' order by client_id ASC LIMIT 1)";
			$this->db->query($sQuery);
		}
		//
		//$sQuery="delete from cc_call_history where phone_number='$number'";
		$sQuery="update cc_call_history set alloted= 'Y' where phone_number='$number'";
		$this->db->query($sQuery);
			
	}

	
}
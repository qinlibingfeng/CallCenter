<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('excel_helper');
		$this->load->library('DataTabes_helper');
		$this->load->model('Clients_model');	
		$this->load->library('Utility_func');
		date_default_timezone_set('Asia/Shanghai');
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
	function ajaxClientExport(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');	
		$req=$this->input->post();
		$this->firephp->info($req);			
		$searchObject=json_decode($req['filterString']);	
		$aColumns = array('client_id', 'client_name', 'client_sex',  'client_phone','client_address','client_ctime');

		$this->firephp->info($searchObject->searchText);
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
				
		$seachItems= $this->createSearchSql($searchObject);
			
		$sWhere=$this->datatabes_helper->getSearchSql($seachItems);
		/*
		if($searchObject->searchType == 0)
			$sWhere=$this->datatabes_helper->getFilteringSql($searchObject->searchText,$aColumns);
		else if($searchObject->searchType == 1)
			$sWhere=$this->datatabes_helper->getSearchSql($searchObject->searchText);
		*/
		$sOrder="order by client_id";	
		$sTable="clients left join bill on client_id=bill_client_id";
		
		$this->load->library('Dynamicui',array("agentId"=>$searchObject->agentId));
		$dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		$exportMap=$this->$dyModelName->getClientExportFields();
				
		
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $exportMap["dbField"]))."
		FROM   $sTable
		$sWhere
		$sOrder
		";
		
		//echo  str_replace(" , ", " ", implode(", ", $exportMap["dbField"]));
		
		
		
		$this->firephp->info($sQuery);
		$data=$this->Clients_model->getData($sQuery);
		
		$fileName='clients_'.date('dMyhis').'.xls';
		$path='./export_datas/'.$fileName;
		
		$exportData=array();	
	

		$this->datatabes_helper->reverseResultBind($exportData,$data->result_array(), $exportMap["dbField"],$exportMap["bindField"],"client_id");

	    $this->excel_helper->exportToFile($path,$exportData,$exportMap["tabHeader"]);	
		$ret['path']=$this->config->item('base_url').'/'.$path;
		$ret["fileName"]=$fileName;
		
		echo json_encode($ret);
	}
	
	function ajaxCustomClientCountExport(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		$req=$this->input->post();
		
		$searchObject=json_decode($req['filterString']);
		$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>""));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
	
		$eField="坐席,case when 日期 is null and 坐席 <>'总计' then '合计' else 日期 end as '时间', 呼出接通,呼出未接通,呼出,呼入接通,呼入未接通,呼入";
		$sField="case when agent is null then '总计' else agent end as '坐席'  ,
DATE_FORMAT(link_stime,'%Y-%m-%d')  as '日期', 
sum(case status when 'CONNECTED' then case call_type when 'callout' then 1 else 0 end else 0 end) as '呼出接通', 
sum(case call_type when 'callout' then case `status` when 'CONNECTED' then 0 else 1 end else 0 end) as '呼出未接通', 
sum(case call_type when 'callout' then 1 else 0 end) as '呼出', 
sum(case status when 'CONNECTED' then case call_type when 'callin' then 1 else 0 end else 0 end) as '呼入接通', 
sum(case call_type when 'callin' then case `status` when 'CONNECTED' then 0 else 1 end else 0 end) as '呼入未接通',
sum(case call_type when 'callin' then 1 else 0 end) as '呼入'";
		
	
		
		$dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		$customItem=$this->$dyModelName->getCustomClientCountItem();	
		$customDbField=$this->$dyModelName->getCustomClientCountDbField();
		
		$eField="坐席工号,case when callDate is null and 坐席工号 <>'总计' then '合计' else callDate end as '时间'";
		$sField="case when client_agent is null then '总计' else client_agent end as '坐席工号'  ,DATE_FORMAT(client_modify_time,'%Y-%m-%d') as 'callDate'";
		foreach($customItem as $item){
			$eField.=",".$item;
			$sField.=",sum(case ".$customDbField." when  '".$item."' then 1  else 0 end) as ".$item;	
		}
		
		$sTable="clients";
		
		if($req["isAllCount"] == "true")
			$sGroup="group by client_agent ,DATE_FORMAT(client_modify_time,'%Y-%m-%d') with ROLLUP";
		else
			$sGroup="group by client_agent ,DATE_FORMAT(client_modify_time,'%Y-%m-%d')";
		
			
		$sQuery = "SELECT
		$eField 
		from  (select $sField  from $sTable $sWhere $sGroup) baseTable";
	
		$this->firephp->info($sQuery);
		$this->firephp->info("begin create data");
		$fileName='callcount_'.date('dMy').'.xls';
		$path='export_datas/'.$fileName;
		
		$data = $this->db->query($sQuery);
		
		
		$aColumns=array();
		array_push($aColumns,'坐席工号');
		array_push($aColumns,'日期');
		
		$aColumns=array_merge($aColumns,$customItem);
		
		$this->excel_helper->exportToFile($path,$data->result_array(),$aColumns);
	
		$ret['path']=$this->config->item('base_url').'/'.$path;
		$ret["fileName"]=$fileName;
		echo json_encode($ret);	
	}
	
	function ajaxCallCountExport(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		$req=$this->input->post();
		
		$searchObject=json_decode($req['filterString']);
		$this->firephp->info($req['filterString']);

		$this->load->library('Dynamicui',array("agentId"=>""));
	    $dyModelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($dyModelName);
		
		$aColumns =$this->$dyModelName->getCustomClientColumns();
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		
		//获得where语句
		$sWhere="";
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject);
	
		$eField="坐席,case when 日期 is null and 坐席 <>'总计' then '合计' else 日期 end as '时间', 呼出接通,呼出未接通,呼出,呼入接通,呼入未接通,呼入";
		$sField="case when agent is null then '总计' else agent end as '坐席'  ,
DATE_FORMAT(link_stime,'%Y-%m-%d')  as '日期', 
sum(case status when 'CONNECTED' then case call_type when 'callout' then 1 else 0 end else 0 end) as '呼出接通', 
sum(case call_type when 'callout' then case `status` when 'CONNECTED' then 0 else 1 end else 0 end) as '呼出未接通', 
sum(case call_type when 'callout' then 1 else 0 end) as '呼出', 
sum(case status when 'CONNECTED' then case call_type when 'callin' then 1 else 0 end else 0 end) as '呼入接通', 
sum(case call_type when 'callin' then case `status` when 'CONNECTED' then 0 else 1 end else 0 end) as '呼入未接通',
sum(case call_type when 'callin' then 1 else 0 end) as '呼入'";
		$sTable="cc_call_history";
		
		if($req["isAllCount"] == "true")
			$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d') with ROLLUP";
		else
			$sGroup="group by agent ,DATE_FORMAT(link_stime,'%Y-%m-%d')";
			
		$sQuery = "SELECT
		$eField 
		from  (select $sField  from $sTable $sWhere $sGroup) baseTable";
	
		$this->firephp->info($sQuery);
		$this->firephp->info("begin create data");
		$fileName='callcount_'.date('dMy').'.xls';
		$path='export_datas/'.$fileName;
		
		$data = $this->db->query($sQuery);
		$this->excel_helper->exportToFile($path,$data->result_array(),array("坐席工号","日期","呼出接通","呼出未接通","呼出总计","呼入接通","呼入未接通","呼入总计"));
	
		$ret['path']=$this->config->item('base_url').'/'.$path;
		$ret["fileName"]=$fileName;
		echo json_encode($ret);	
	}
	
	function ajaxMissCallExport(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');
		
		$req=$this->input->post();
		$searchObject=json_decode($req['filterString']);
		$this->firephp->info($searchObject);	
			
		$this->load->library('Agent_helper',array('agent_id'=>$searchObject->agentId));
		
		$setData=$this->agent_helper->getReportAgentsCanShow();
		array_push($setData[3],'0000');
		array_push($searchObject->searchText,$setData);
		$sWhere=$this->datatabes_helper->getSearchSql($searchObject->searchText);
		
		$aColumns = array('agent','name','phone_number','call_type' ,'status' ,'link_stime');
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'link_stime','desc');
		$sTable="cc_call_history left join agents on cc_call_history.agent=agents.code";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder";
	
		$this->firephp->info($sQuery);	
		$data=$this->db->query($sQuery);
		$fileName='misscall_'.date('dMy').'.xls';
		$path='export_datas/'.$fileName;
		
		$this->excel_helper->exportToFile($path,$data->result_array(),array("坐席工号","坐席姓名","电话号码","呼叫类型","呼叫状态","开始时间"));
		$ret['path']=$this->config->item('base_url').'/'.$path;
		$ret["fileName"]=$fileName;
		echo json_encode($ret);		
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
sum(case status when  'CONNECTED' then case call_type when 1 then 1 else 0 end  else 0 end) as sumCalloutConnect,
sum(case call_type when 1 then case `status` when 'CONNECTED' then 0 else 1 end  else 0 end) as sumCalloutUnConnnect,
sum(case call_type when 1 then 1 else 0 end) as sumCallout,
sum(case status when  'CONNECTED' then case call_type when 0 then 1 else 0 end  else 0 end) as  sumCallinConnect,
sum(case call_type when 0 then case `status` when 'CONNECTED' then 0 else 1 end  else 0 end) as sumCallinUnConnnect,
sum(case call_type when 0 then 1 else 0 end) as sumCallin";
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
	}
}
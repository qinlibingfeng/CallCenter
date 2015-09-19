<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(0); 
class Communicate extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('firephp');
		$this->load->library('DataTabes_helper');
		$this->load->model('Communicate_model');	
		$this->load->model('Dictionary_model');
		date_default_timezone_set('Asia/Shanghai');
	}
	public function ajaxNextClient(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$nextId=intval($req['clientBh']);
		$sql="select clients_wait.client_id from clients_wait left join clients on clients_wait.client_id=clients.client_id where clients_wait.client_id >".$nextId." and client_agent='".$req['agentId']."'  order by client_id  limit 0,1";
		$this->firephp->info($sql);
		$q=$this->db->query($sql)->result_array();
		if($q){
			$this->firephp->info($q);
			$res['nextUrl']=site_url('communicate/connected')."/manulClick/".$req['agentId']."/".$q[0]['client_id'];
		}
		else{
			$sql="select min(client_id) as client_id from clients_wait";
			$this->firephp->info($sql);
			$q=$this->db->query($sql)->result_array();
			if($q)
				$res['nextUrl']=site_url('communicate/connected')."/manulClick/".$req['agentId']."/".$q[0]['client_id'];
			else
				$res['nextUrl']='';
		}
		echo json_encode($res);
	}
	public function ajaxDeleteClient(){
		$ssh = $this->input->post();  
        if (empty($ssh)) return false; 
		//echo $ssh['client'];
		$data = "./layoutxml/beijing-jiaoyu.xml";
		$xml = simplexml_load_file($data);		//创建 SimpleXML对象
		$cout_row = count($xml->baseInfoTable->row); //计算row的个数


		for($i=0;$i<$cout_row;$i++)
		{	
			$root = $xml->baseInfoTable->row[$i];
			$cout_item = count($xml->baseInfoTable->row[$i]->item); //计算item的个数
			for($j=0;$j<$cout_item;$j++)
			{				
				$vas = $root->item[$j];
				//$ssh = $vas->id;
				//echo $ssh."<br />";
				if($xml->baseInfoTable->row[$i]->item[$j]->id == $ssh['client'])
				{
					if($cout_item==1)
					{
						//echo $ssh."<br />";
						unset($xml->baseInfoTable->row[$i]);
					}
					else
					{
						//echo $ssh."<br />";
						unset($xml->baseInfoTable->row[$i]->item[$j]);
					}
					$xml->asXML($data);
					$res = "删除成功！！";
				}
				else{
					$res = "删除失败！！";
				}
			}
		}
		$this->load->model('dynamicui_model');
		$model=new Dynamicui_model();
		$data_r = array_combine($model->getGerendata(), $model->getGereniddata());  
		$ret = array();
		$ret["res"] = $res ;
		$ret["data"] = $data_r ;
		echo json_encode($ret);

	
	}

	public function ajaxAddClient(){
		//header('Content-type: Application/json',true);
		
		$req = $this->input->post();  
        if (empty($req)) return false;  
		
		function add_new_item($new_item,$req)
		{
			$new_item->addChild("id",$req['client_id']);
			$new_item->addChild("dbfield",$req['client_dbfield']);
			$new_item->addChild("type",$req['client_type']);
			$new_item->addChild("name",$req['client_name']);
			$new_item->addChild("colspan",$req['client_colspan']);		
			$new_item->addChild("lspace",$req['client_lspace']);
			$new_item->addChild("width",$req['client_width']);
			$new_item->addChild("height",$req['client_height']);		
			$new_item->addChild("valuesource",$req['client_valuesource']);
		
		}
		function serch_insert_post($xml,$cout)
		{
			for($i=0;$i<$cout;$i++)
			{	
				$lenth = count($xml->baseInfoTable->row[$i]->item);
				if($lenth<3)
					return $i;
			}
		}
		$data = "./layoutxml/beijing-jiaoyu.xml";
		$xml = simplexml_load_file($data); //创建 SimpleXML对象
		$res= "";; //判断标志位
		$cont=0;

		
		$cout = count($xml->baseInfoTable->row); //计算row的个数
		$lenth = count($xml->baseInfoTable->row[$cout-1]->item); //返回最后一个row中item的个数
		$ret = serch_insert_post($xml,$cout);

		
		if($cout==0) //如果一个row节点都没有
		{
			$root = $xml->baseInfoTable;
			$new_row=$root->addChild('row');
			$new_item=$new_row->addChild('item');
			add_new_item($new_item,$req);
			$xml->asXML($data);	
			$res="添加成功！！";
			$cont=1;
			//echo $cout;
		}
		else			//如果row节点存在
		{
			if($lenth < 3)
			{
				$root = $xml->baseInfoTable->row[$ret];	
				$new_item=$root->addChild('item');
				add_new_item($new_item,$req);
				$xml->asXML($data);	
				$res= "添加成功！！";
				$cont=1;
			
			}
			else if($lenth == 3)
			{
				$root = $xml->baseInfoTable;
				$new_row=$root->addChild('row');
				$new_item=$new_row->addChild('item');
				add_new_item($new_item,$req);
				$xml->asXML($data);	
				$res="添加成功！！";
				$cont=1;
			
			}
		}
		if($cont)
			{			
				$this->load->model('dynamicui_model');
				$model=new Dynamicui_model();
				$data_r = array_combine($model->getGerendata(), $model->getGereniddata());  
				
							
				
			}else{
				$data_r="";
			}
		$ret = array();
		$ret["cont"] = $cont ;
		$ret["res"] = $res ;
		$ret["data"] = $data_r ;
		echo json_encode($ret);
		
	}




	
	function connected($from="manulClick",$agentId="", $clientBh="",$phoneNumber="",$uniqueid=""){
		$data['from']=$from;
		$data['agentId']=$agentId;
		$data['uniqueid']=$uniqueid;
		
		$this->load->library('Dynamicui',array("agentId"=>$agentId));
		$modelName=$this->dynamicui->getDynamicuiModel();
		$this->load->model($modelName);
		
		
		$this->load->library('Agent_helper',array('agent_id'=>$agentId));
		$agents=$this->agent_helper->getClientAgentsCanShow();
		$this->load->model("Users_model");	
		$showAgents=$this->Users_model->getNameValueByIds($agents[3]);
		$data['targetAgents']=$showAgents;
		
		if($from == 'manulClick'){				
			$data['phoneNumber']='';
			$data['uniqueid']='';
			$data['clientItem']=$this->Clients_model->getby_id($clientBh);	
			$data["gsd"]="";
			
		}else if($from == 'callEvent'){			
			$data['phoneNumber']=$phoneNumber;
			$data['uniqueid']=$uniqueid;
			$allDbFields=$this->$modelName->getAllDbFileds();
			$this->load->model('Phone_model');
			$data["gsd"]=$this->Phone_model->getPhoneAddress($phoneNumber);
			$data['clientItem']=$this->Clients_model->selectClientByPhone($phoneNumber,$allDbFields);	
			
		}
		
		$data['phoneNumber']=isset($data['clientItem'][0]['client_cell_phone'])?$data['clientItem'][0]['client_cell_phone']:$phoneNumber;
		
		$data['clientBh']=isset($data['clientItem'][0]['client_id'])?$data['clientItem'][0]['client_id']:'';
		$this->load->library('Utility_func');
		$data['yuyue']=$this->utility_func->creatHourMinOptions();
		$data['yuyue']['ymh']=date('Y-m-d');
		$data['yuyue']['hourDef']='00';
		$data['yuyue']['minDef']='00';
		
		
		if(isset($data['clientItem'][0])){
			$data['baseInfo']=$this->$modelName->getBaseInfoTableData($data['clientItem'][0]);
			$data['loanInvestigate']=$this->$modelName->getLoanInvestigateTableData($data['clientItem'][0]);
			$data['loanRecheck']=$this->$modelName->getLoanRecheckTableData($data['clientItem'][0]);
			$data['loanCheck']=$this->$modelName->getLoanCheckTableData($data['clientItem'][0]);
			$data['limitMaking']=$this->$modelName->getLimitMakingTableData($data['clientItem'][0]);
			$data['loanGiveout']=$this->$modelName->getLoanGiveoutTableData($data['clientItem'][0]);
			$data['loanRevisit']=$this->$modelName->getLoanRevisitTableData($data['clientItem'][0]);
		}
		else{
			$data['baseInfo']=$this->$modelName->getBaseInfoTableData(array('client_phone'=>$phoneNumber));
			$data['loanInvestigate']=$this->$modelName->getLoanInvestigateTableData(array('client_phone'=>$phoneNumber));
			$data['loanRecheck']=$this->$modelName->getLoanRecheckTableData(array('client_phone'=>$phoneNumber));
			$data['loanCheck']=$this->$modelName->getLoanCheckTableData(array('client_phone'=>$phoneNumber));
			$data['limitMaking']=$this->$modelName->getLimitMakingTableData(array('client_phone'=>$phoneNumber));
			$data['loanGiveout']=$this->$modelName->getLoanGiveoutTableData(array('client_phone'=>$phoneNumber));
			$data['loanRevisit']=$this->$modelName->getLoanRevisitTableData(array('client_phone'=>$phoneNumber));
		}
		
		$this->load->view('call_connect_view',$data);
	}
	
	function ajaxCommunicateSave(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();	
		require('/var/www/html/config.php');
		$status['ok']=false;	
		//组织数据
		$item=$this->Communicate_model->getItemsFromReq($req);
		$this->firephp->info($item);
		$ret=$this->Clients_model->getby_id($req['clientBh']);			
		if($ret){	

			$sql="select list_id from ".$db_config["database"].".vicidial_lists where campaign_id='".$req['campaignId']."';";
			$list=$this->Clients_model->getData($sql)->result_array();
			//echo $list[0]['list_id'];

			$sql="select client_cell_phone from ".$db_config["database2"].".clients where client_id='".$ret[0]['client_id']."';";
			$row=$this->Clients_model->getData($sql)->result_array();
			//print_r($row[0]['client_cell_phone']);

			//存在更新客户信息
			$this->Clients_model->update($ret[0]['client_id'],$item['client']);

			//添加客户到vici_list中
			//print_r($item['client']);
			//$ssh = $this->Clients_model->syn_comment_list($item['client']);
			//$this->Clients_model->update_list($row[0]['client_cell_phone'],$ssh,$list[0]['list_id']);

			$update_list="UPDATE ".$db_config["database"].".vicidial_list SET modify_date = '".$item['client']['client_ctime']."',last_name='".$item['client']['client_name']."',phone_number='".$item['client']['client_cell_phone']."',user='".$item['client']['client_agent']."' WHERE phone_number='".$row[0]['client_cell_phone']."' AND list_id='".$list[0]['list_id']."'";
			$list=$this->Clients_model->getData($update_list);
			

			$status['ok']=true;
			$clientId=$ret[0]['client_id'];		
		}else{		
			//不存在新建客户信息
			$item['client']['client_agent']=$req['agentId'];
			$item['client']['client_creater']=$req['agentId'];
			$item['client']['client_ctime']=date("Y-m-d H:i:s");
			$clientId=$this->Clients_model->insert($item['client']);

			//$this->Clients_model->insert_vicidial_list($clientId);
			$sql="select list_id from ".$db_config["database"].".vicidial_lists where campaign_id='".$req['campaignId']."';";
			$row=$this->Clients_model->getData($sql)->result_array();
			$ssh=$this->Clients_model->syn_comment_insert_list($item['client'],$row[0]['list_id']);
			$this->Clients_model->insert_list($ssh);

			$status['ok']=true;
		}	
		
		//如果有沟通，插入沟通信息到bill表
		if($req['uniqueid'] != "0" && $req['uniqueid'] !=""){
			$bill['bill_uniqueid']=$req['uniqueid'];
			$bill['bill_client_id']=$clientId;
			$bill['bill_stime']=date("Y-m-d H:i:s");
			if(isset($item['client']['client_note']))
				$bill['bill_note']=$item['client']['client_note'];
			
			$this->firephp->info($bill);
			$this->Communicate_model->insertBill($bill);
		}
		
		$status['clientBh']=$clientId;
		if($status['ok']){
			$sql="delete from clients_wait where client_id='$clientId'";
			$this->db->query($sql);
		}
		echo json_encode($status);
	}
	
	function ajaxSetYuyueTime(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();		
		$this->firephp->info($req);		
		$item['client_yuyue_time']=$req['time'];
		$item['client_yuyue']=1;
		$item['client_yuyue_content']=$req['content'];
		$sql="select client_id from clients_yuyue where client_id='".$req['client_id']."'";
		$ret=$this->db->query($sql);
		if($ret->num_rows() > 0){
			$sql="update clients_yuyue set yuyue_time='".$req['time']."',yuyue_note='".$req['content']."' where client_id='".$req['client_id']."'";
		}else{
			$sql="insert  into clients_yuyue (client_id,yuyue_time,yuyue_note) values('".$req['client_id']."','".$req['time']."','".$req['content']."')";
		}
		$this->db->query($sql);
		//$this->Clients_model->update($req['client_id'],$item);
		
	}
	
	function ajaxCommunicateRecord(){
		header('Content-type: Application/json',true);
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		
		$output = array(	
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 1,
		"iTotalDisplayRecords" => 1,
		"aaData" => array()
		);
		//$agent=$req['agentId'];
		$phone=$req['phone'];
		$cellPhone=$req['cellPhone'];
		
		$aColumns = array('agent','phone_number','call_type','call_stime','bill_stime','bill_note','location');
		
		$sLimit=$this->datatabes_helper->getPageSql($req);
		$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns,'call_stime','desc');
		
		if($cellPhone != "" && $cellPhone[0] == '0'){
			$cellPhone=substr($cellPhone,1);
		}
		
		if($phone != "" && $phone[0] == '0'){
			$phone=substr($phone,1);
		}
		
		$sTable="cc_call_history left join bill on call_id=bill_uniqueid";
		$sWhere="where status = 'CONNECTED' ";
		if($phone != "" && $cellPhone != ""){
			$sWhere.=" and (phone_number='$phone' or phone_number='0$phone' or phone_number='0$cellPhone' or phone_number='$cellPhone')";
		}else if($phone != ""){
			$sWhere.=" and (phone_number='$phone' or phone_number='0$phone')";
		}else if($cellPhone != ""){
			$sWhere.=" and (phone_number='$cellPhone' or phone_number='0$cellPhone')";
		}
		
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit ";
		
		$this->firephp->info($sQuery);
		
		$ret=$this->db->query($sQuery);	
		/*
		foreach($ret->result_array() as $row){
			$sql="select bill_note from bill where bill_uniqueid='".$row['call_id']."'";
			$billRs=$this->db->query($sql)->result_array();
			foreach($billRs as $billRow)
				array_push($output["aaData"],array($row['agent'],$row['phone_number'],$row['call_type'],$row['call_stime'],$billRow['bill_note'],$row['location']));
			
		}
		*/
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns);
		$this->firephp->info($output["aaData"]);
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		$ret=$this->db->query($sCount)->result_array();
		
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output);
	}
	
	
	function ajaxCommunicateSaveStep(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();	
		$status['ok']=false;	
		//组织数据
	
		
		$sql = "update clients set loan_steps = '".$req['loan_steps']."' where client_id = '".$req['clientId']."'";
		$this->db->query($sql);
		$status['ok']=true;	
		

		echo json_encode($status);
	}
}
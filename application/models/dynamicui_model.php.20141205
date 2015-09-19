<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dynamicui_model extends CI_Model{
	private $xml;
	function __construct(){
		parent::__construct();
		$this->load->model('Dictionary_model');
		$this->load->model('Dictionary_tree_model');
		$this->xml=simplexml_load_file($this->getLayoutFileName());
	}
	
	function getAllDbFileds(){
		$ret=array();	
		$xml = $this->xml;
		foreach($xml->baseInfoTable->children() as $children){
			$row=array();
			foreach($children->children() as $item)
				array_push($ret,(string)$item->dbfield);
		}	
		
		foreach($xml->bussniessInfoTable->children() as $children){
			$row=array();
			foreach($children->children() as $item)
				array_push($ret,(string)$item->dbfield);
		}	
		
		if(!in_array("client_agnet",$ret))
			array_push($ret,"client_agent");
		if(!in_array("client_address",$ret))
			array_push($ret,"client_address");
		array_push($ret,"client_id");
			
		return $ret;
	}
	function getGerendata(){
		$ret=array();	
		$xml = $this->xml;
		foreach($xml->baseInfoTable->children() as $children){
			$row=array();
			foreach($children->children() as $item)
				//$item["name"]=(string)$children->name;
				//$item["align"]=(string)$children->align;
				//$item["width"]=(string)$children->width;
				//array_push($ret,$item);
				array_push($ret,(string)$item->name);
		}	
		return $ret;	
	}


	function getOrderBaseInfoFileds(){
		$ret=array();	
		$xml = $this->xml;
		
		foreach($xml->bussniessInfoTable->children() as $children){
			$row=array();
			foreach($children->children() as $item)
				array_push($ret,(string)$item->dbfield);
		}	
		
		return $ret;
	}
	function getOrderProcessInfoFileds(){
		$ret=array();	
		$xml = $this->xml;
		
		foreach($xml->orderProcessTable->children() as $children){
			$row=array();
			foreach($children->children() as $item)
				array_push($ret,(string)$item->dbfield);
		}	
		
		return $ret;
	}
	function getCustomClientCountDbField(){	
		$xml = $this->xml;	
		$customClientCountDbItem="client_vkhxx";
		$customClientCountDbItem=(string)$xml->customClientCount->dbField;
		return $customClientCountDbItem;
	}
	
	function getCustomClientCountItem(){
		$ret=array();
		$customClientCountDicItem="客户选项";
		$xml = $this->xml;	
		$customClientCountDicItem=(string)$xml->customClientCount->dicField;
		$sql="select name_text from dictionary_normal where name_type_text='".$customClientCountDicItem."'";
		$rs=$this->db->query($sql)->result_array();
		foreach($rs as $row){
			array_push($ret,$row["name_text"]);
		}
		return $ret;
	}
	
	function getClientExportFields(){
		$ret=array("dbField"=>array(),"tabHeader"=>array(),"bindField"=>array());		
		array_push($ret["dbField"],"client_id");
		array_push($ret["tabHeader"],"编号");	
		array_push($ret["dbField"],"client_agent");
		array_push($ret["tabHeader"],"坐席工号");	
		$xml = $this->xml;
		foreach($xml->baseInfoTable->children() as $children){
			$row=array();
			foreach($children->children() as $item){	
				if((string)$item->dbfield == "client_note"){
					array_push($ret["dbField"],"bill_note");
					array_push($ret["bindField"],"bill_note");
				}else{
					array_push($ret["dbField"],(string)$item->dbfield);
				}			
				array_push($ret["tabHeader"],(string)$item->name);		
			}
		}	
		
		foreach($xml->bussniessInfoTable->children() as $children){
				$row=array();
				foreach($children->children() as $item){
					
					array_push($ret["dbField"],(string)$item->dbfield);
					array_push($ret["tabHeader"],(string)$item->name);
					if((string)$item->dbfield == "client_note"){
						array_push($ret["dbField"],"bill_note");
						array_push($ret["bindField"],"bill_note");
						array_push($ret["tabHeader"],'沟通记录');
					}
					
				
			}
		}	
		array_push($ret["tabHeader"],"创建时间");	
		array_push($ret["dbField"],"client_ctime");	
		array_push($ret["tabHeader"],"沟通时间");	
		array_push($ret["dbField"],"client_modify_time");	
		return $ret;
	}
	
	function getCustomSearchPanel(){
		$xml = $this->xml;
		$ret["elements"]=array();	
		foreach($xml->customSearchPanel->children() as $children){
			$row=array();
			foreach($children->children() as $item){
				$itemArray=array("dbtype"=>(string)$item->dbtype, "colspan"=>(int)$item->colspan,"name"=>(string)$item->name,"lspace"=>(int)$item->lspace,"type"=>(int)$item->type,"id"=>(string)$item->id,"value"=>array("defaultValue"=>'',"values"=>array()));	
				$itemArray["value"]["defaultValue"]=isset($defaultValues[(string)$item->dbfield])?$defaultValues[(string)$item->dbfield]:'';
				$itemArray["value"]["values"]=$this->getValues((int)$item->type,(string)$item->valuesource,(string)$item["value"]["defaultValue"],true);
				array_push($row,$itemArray);
			}
			array_push($ret["elements"],$row);		
		}	
		return $ret;		
	}
	function getClientSearchPanel(){
		$xml = $this->xml;
		$ret["elements"]=array();	
		foreach($xml->clientSearchPanel->children() as $children){
			$row=array();
			foreach($children->children() as $item){
				$itemArray=array("dbtype"=>(string)$item->dbtype, "colspan"=>(int)$item->colspan,"name"=>(string)$item->name,"lspace"=>(int)$item->lspace,"type"=>(int)$item->type,"id"=>(string)$item->id,"value"=>array("defaultValue"=>'',"values"=>array()));	
				$itemArray["value"]["defaultValue"]=isset($defaultValues[(string)$item->dbfield])?$defaultValues[(string)$item->dbfield]:'';
				$itemArray["value"]["values"]=$this->getValues((int)$item->type,(string)$item->valuesource,(string)$item["value"]["defaultValue"],true);
				array_push($row,$itemArray);
			}
			array_push($ret["elements"],$row);		
		}	
		return $ret;		
	}
				
	function getCustomClientTableHeader(){
		$xml = $this->xml;
		$ret=array();
		foreach($xml->customBodyPanel->children() as $children){
				$item["name"]=(string)$children->name;
				$item["align"]=(string)$children->align;
				$item["width"]=(string)$children->width;
				array_push($ret,$item);
		}
		return $ret;
	}

	
	function getOrderTableSearchPanel(){
			
		$xml = $this->xml;
		$ret["elements"]=array();	
		
		foreach($xml->orderTableSearchPanel->children() as $children){
			$row=array();
			foreach($children->children() as $item){
				$itemArray=array("dbtype"=>(string)$item->dbtype, "colspan"=>(int)$item->colspan,"name"=>(string)$item->name,"lspace"=>(int)$item->lspace,"type"=>(int)$item->type,"id"=>(string)$item->id,"value"=>array("defaultValue"=>'',"values"=>array()));	
				$itemArray["value"]["defaultValue"]=isset($defaultValues[(string)$item->dbfield])?$defaultValues[(string)$item->dbfield]:'';
				$itemArray["value"]["values"]=$this->getValues((int)$item->type,(string)$item->valuesource,(string)$item["value"]["defaultValue"],true);
				array_push($row,$itemArray);
			}
			array_push($ret["elements"],$row);		
		}	
		
		return $ret;	
	}
	
	function getOrderTableHeader(){
		$xml = $this->xml;
		$ret=array();
		foreach($xml->orderTable->children() as $children){
				$item["name"]=(string)$children->name;
				$item["align"]=(string)$children->align;
				$item["width"]=(string)$children->width;
				array_push($ret,$item);
		}
		return $ret;
	}
	function getOrderTableColumns(){
		$xml = $this->xml;
		$ret=array();
		foreach($xml->orderTable->children() as $children){
				array_push($ret,(string)$children->dbfield);
		}
		
		foreach($xml->bussniessInfoTable->children() as $children){
			$row=array();
			foreach($children->children() as $item)
				array_push($ret,(string)$item->dbfield);
		}	
		
		return $ret;
	}
	
	function getCustomClientColumns(){
		$xml = $this->xml;
		$ret=array();	
		foreach($xml->customBodyPanel->children() as $children){		
				array_push($ret,(string)$children->dbfield);
		}
		return $ret;
	}
	
	function getCustomClientStatusCount(){
		$xml = $this->xml;
		$ret=array();	
		foreach($xml->customBodyPanel->children() as $children){		
				array_push($ret,(string)$children->dbfield);
		}
		return $ret;	
	}
	function getOrderProcessTableData($defaultValues){
		$xml = $this->xml;	
		$items=$xml->baseInfoTable->row;
		$ret["elements"]=array();	
		foreach($xml->orderProcessTable->children() as $children){
			$row=array();
			foreach($children->children() as $item){
				$itemArray=array("colspan"=>(int)$item->colspan,"name"=>(string)$item->name,"lspace"=>(int)$item->lspace,"type"=>(int)$item->type,"width"=>(string)$item->width,"height"=>(string)$item->height,"id"=>(string)$item->id,"value"=>array("defaultValue"=>'',"values"=>array()));	
				$itemArray["value"]["defaultValue"]=isset($defaultValues[(string)$item->dbfield])?$defaultValues[(string)$item->dbfield]:'';
				$itemArray["value"]["values"]=$this->getValues((int)$item->type,(string)$item->valuesource,(string)$item["value"]["defaultValue"]);
				array_push($row,$itemArray);
			}
			array_push($ret["elements"],$row);		
		}	
		
		return $ret;
	}
	
	function getBussniessInfoTableData($defaultValues){
		$xml = $this->xml;	
		$items=$xml->baseInfoTable->row;
		$ret["elements"]=array();	
		foreach($xml->bussniessInfoTable->children() as $children){
			$row=array();
			foreach($children->children() as $item){
				$itemArray=array("colspan"=>(int)$item->colspan,"name"=>(string)$item->name,"lspace"=>(int)$item->lspace,"type"=>(int)$item->type,"width"=>(string)$item->width,"height"=>(string)$item->height,"id"=>(string)$item->id,"value"=>array("defaultValue"=>'',"values"=>array()));	
				$itemArray["value"]["defaultValue"]=isset($defaultValues[(string)$item->dbfield])?$defaultValues[(string)$item->dbfield]:'';
				$itemArray["value"]["values"]=$this->getValues((int)$item->type,(string)$item->valuesource,(string)$item["value"]["defaultValue"]);
				array_push($row,$itemArray);
			}
			array_push($ret["elements"],$row);		
		}	
		
		return $ret;	
	}
	function getBaseInfoTableData($defaultValues){		
		$xml = $this->xml;
		$items=$xml->baseInfoTable->row;
		$ret["elements"]=array();	
		foreach($xml->baseInfoTable->children() as $children){
			$row=array();
			foreach($children->children() as $item){
				$itemArray=array("colspan"=>(int)$item->colspan,"name"=>(string)$item->name,"lspace"=>(int)$item->lspace,"type"=>(int)$item->type,"width"=>(string)$item->width,"height"=>(string)$item->height,"id"=>(string)$item->id,"value"=>array("defaultValue"=>'',"values"=>array()));	
				$itemArray["value"]["defaultValue"]=isset($defaultValues[(string)$item->dbfield])?$defaultValues[(string)$item->dbfield]:'';
				$itemArray["value"]["values"]=$this->getValues((int)$item->type,(string)$item->valuesource,(string)$item["value"]["defaultValue"]);
				array_push($row,$itemArray);
			}
			array_push($ret["elements"],$row);		
		}		
		return $ret;	
	}
	
	function getImportTableMap(){
		$xml = $this->xml;
		$ret=array();
		foreach($xml->importDBMap->children() as $item){	
			array_push($ret,array("name"=>(string)$item->name,"dbfield"=>(string)$item->dbfield));
		}
		return $ret;
	}

	private function getLayoutFileName(){
		$xml = simplexml_load_file("./layoutxml/layout_config.xml");
		$defaultPath="./layoutxml/beijing-jiaoyu.xml";
		$defaultPath="./layoutxml/".$xml->config->layout_file;
		return $defaultPath;
	}
	
	private function getValues($type,$source,$default,$isSearch=false){
		if($type == 1){
			return array($default);
		}else if($type == 2 ){
			$ret=array();
			$data=$this->Dictionary_model->getSelectOption($source);
			if($isSearch)
				array_push($ret,array("name_value"=>"全部","name_text"=>"全部"));	
			
			array_push($ret,array("name_value"=>"未填写","name_text"=>"未填写"));		
			foreach($data as $key=>$value){
				array_push($ret,array("name_value"=>$value,"name_text"=>$value));
			}
			return $ret;
		}else if($type == 3){		
			$id=$this->Dictionary_tree_model->getItemByText($source);
			$data=array();		
			if($id && $id[0])
				$data=$this->Dictionary_tree_model->getTreeDataByPid($data,$id[0]['treenames_id']);		
			return $data;
			
		}else if($type == 4){
			return $this->Dictionary_model->getNormalDictionaryByType($source);
		}else if($type == 6){
			$data=array();
			$this->Dictionary_tree_model->getAreaData($data);
			return $data;
		}else {return array();}
		
	}
	
}
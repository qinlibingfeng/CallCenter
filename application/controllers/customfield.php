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

	function ajaxCustomField(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();
		$str=json_decode($req['name']);
		
		echo "name = ".$name;
		add_field_xml($str);
		

		$this->load->model('dynamicui_model');
		$model=new Dynamicui_model();
		$data['list'] = array_combine($model->getGerendata(), $model->getGereniddata());  
		
		$res['ok']=true;
		$res['data']=$data;
		echo json_encode($res);	
		
	}

	function add_new_item($new_item,$str)
	{
		$new_item->addChild("id",$str['client_id']);
		$new_item->addChild("dbfield",$str['client_dbfield']);
		$new_item->addChild("type",$str['client_type']);
		$new_item->addChild("name",$str['client_name']);
		$new_item->addChild("colspan",$str['client_colspan']);		
		$new_item->addChild("lspace",$str['client_lspace']);
		$new_item->addChild("width",$str['client_width']);
		$new_item->addChild("height",$str['client_height']);		
		$new_item->addChild("valuesource",$str['client_valuesource']);
	
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
	function add_field_xml($str){

		$data = "./layoutxml/beijing-jiaoyu.xml";
		$xml = simplexml_load_file($data); //创建 SimpleXML对象
		$cous= 0; //判断标志位
		
		$cout = count($xml->baseInfoTable->row); //计算row的个数
		$lenth = count($xml->baseInfoTable->row[$cout-1]->item); //返回最后一个row中item的个数
		$ret = serch_insert_post($xml,$cout);
		echo "-------".$ret;

			
		if($lenth < 3)
		{
			$root = $xml->baseInfoTable->row[$ret];
			if(($str['client_dbfield'] != null)&&($str['client_name']!=null)&&($str['client_id']!=null))
			{	
				$new_item=$root->addChild('item');
				add_new_item($new_item,$str);
				echo "添加成功！！"."<br />";
		
				$xml->asXML($data);	
			}
			else
			{
				echo "添加失败……";
			}
		}
		else if($lenth == 3)
		{
			$root = $xml->baseInfoTable;
			if(($str['client_dbfield'] != null)&&($str['client_name']!=null)&&($str['client_id']!=null))
			{
				$new_row=$root->addChild('row');
				$new_item=$new_row->addChild('item');
				add_new_item($new_item,$str);

				echo "添加成功！！"."<br />";
		
				$xml->asXML($data);	
			}
			else
			{
				echo "添加失败……";
			}
		}
	}
?>



	
	




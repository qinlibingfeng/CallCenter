<?php  error_reporting(0);  ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Custom extends CI_Controller
	{
		//private $xml;
		public function __construct()
		{
			parent::__construct();

			$this->load->helper('url');
			$this->load->helper('form');
			//$this->xml=simplexml_load_file($this->getLayoutFileName());
		}

		public function look($agent)
		{
			
			$this->load->model('dynamicui_model');
			$model=new Dynamicui_model();
			
			//$data['list'] = $model->getGerendata();

			//$data['list_id'] = $model->getGereniddata();
			

			$data['list'] = array_combine($model->getGerendata(), $model->getGereniddata());  
			//print_r($data['list']); 
			//foreach($data['list'] as $keys=>$values)
			//{
			//	$arr_n = count($data['list']);
			//}
			//echo $arr_n;
			
			
			$this->load->view('custom_view',$data);
			
		}
		public function update($agent)
		{
			
			$this->load->model('update_model');
			$model=new Update_model();
			
			
			$data['list'] = $model->getGereniddata();
			print_r($data);



			//$data['list'] = array_combine($model->getGerendata(), $model->getGereniddata());  
			//print_r($data['list']); 
			//foreach($data['list'] as $keys=>$values)
			//{
			//	$arr_n = count($data['list']);
			//}
			//echo $arr_n;
			
			
			//$this->load->view('custom_view',$data);
			
		}
	

	
	}
?>
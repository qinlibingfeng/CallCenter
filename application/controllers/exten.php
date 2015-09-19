<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exten extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('Exten_model');
	}
	
	public function look($offset=0,$sort_by='name', $sort_order='desc')
	{
		$limit=10;
		$columns=array('分机名'=>'ext','分机类型'=>'devicetype');	
		$clients=$this->Exten_model->get($columns, $limit,$offset,$sort_by,$sort_order);	
		
		$config['base_url'] = site_url('client/look/');	
		$config['per_page'] = $limit;	
		$config['uri_segment'] = 3;		
		$config['total_rows'] = $clients['total_num'];
		$this->pagination->initialize($config);	
		$data['pagination']=$this->pagination->create_links();	
		$data['columns']=$columns;
		$data['list_data']=$clients['results'];
		$data['sort_order']=$sort_order;
		
		$this->load->view('exten_look_view',$data);
	}	
	
	public function add()
	{
		
	}
	
}
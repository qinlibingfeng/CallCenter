<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plan extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('Plan_model');
	}
	public function navClock($agentId){
		$this->clock();
	}
	public function clock($offset=0,$sort_by='name', $sort_order='desc'){	
		$limit=10;
		$result=$this->Plan_model->getClocks($limit,$offset,$sort_by,$sort_order);		
		$config['base_url']=site_url('plan/clock/');	
		$config['per_page']=$limit;	
		$config['uri_segment']=3;		
		$config['total_rows']=$result['total_rows'];
	
		$this->pagination->initialize($config);	
		
		$data['pagination']=$this->pagination->create_links();	
		$data['list_data']=$result['total_datas'];
		$data['sort_order']=$sort_order;
	
		$this->load->view('plan_clock_view',$data);
	
	}
	
	public function clockAdd()
	{
		$data['title']='添加闹钟';
		$data['enableChecked']=true;
		$data['dst']='clockInsert';
		$this->load->view('plan_clock_edit_view',$data);
	}
	
	public function clockModify($id)
	{
		$ret=$this->Plan_model->getClock($id);
	
		$data['title']='修改闹钟';
		$data['enableChecked']=$ret[0]['enable']==1?true:false;
		$data['monChecked']=$ret[0]['mon']==1?true:false;
		$data['tueChecked']=$ret[0]['tue']==1?true:false;
		$data['wedChecked']=$ret[0]['wed']==1?true:false;
		$data['thuChecked']=$ret[0]['thu']==1?true:false;
		$data['friChecked']=$ret[0]['fri']==1?true:false;
		$data['satChecked']=$ret[0]['sat']==1?true:false;
		$data['sunChecked']=$ret[0]['sun']==1?true:false;
		$data['clockTitle']=$ret[0]['title'];
		
		$data['time']=$ret[0]['time'];
		$data['dst']='clockUpdate/'.$id;
		$this->load->view('plan_clock_edit_view',$data);
	}
	
	public function clockUpdate($id)
	{
		$this->setClockFormFilterRules();
		if ($this->form_validation->run() == FALSE){
			$this->clockModify($id);
		}
		else{
			$this->Plan_model->updateClock($id,$this->collectFormData());
			redirect(site_url('plan/clock'));
		}		
	}
	
	public function clockInsert()
	{
		$this->setClockFormFilterRules();
		if ($this->form_validation->run() == FALSE){
			$this->clockAdd();
		}
		else{
			$this->Plan_model->addClock($this->collectFormData());
			redirect(site_url('plan/clock'));
		}		
	}
	private function setClockFormFilterRules()
	{
		$this->form_validation->set_rules('title', '标题', 'required');
	}
	private function collectFormData()
	{
		$item['enable']=(isset($_POST['enable']))?1:0; 
		$item['time']=$this->input->post('s_hour').':'.$this->input->post('s_min');
		$item['mon']=(isset($_POST['mon']))?1:0; 	
		$item['tue']=(isset($_POST['tue']))?1:0; 
		$item['wed']=(isset($_POST['wed']))?1:0; 
		$item['thu']=(isset($_POST['thu']))?1:0; 
		$item['fri']=(isset($_POST['fri']))?1:0; 
		$item['sat']=(isset($_POST['sat']))?1:0; 
		$item['sun']=(isset($_POST['sun']))?1:0; 
		$item['title']=$this->input->post('title');
		return $item;
	}
	public function calendar($agentId)
	{
		$this->load->view('plan_calendar_view');
	}
	
	public function ajax_modify_and_del()
	{
		$this->load->library('firephp');
		$this->load->library('exten');
		header('Content-Type: application/json',true);	 	
	}
	
	public function ajax_calendar_events()
	{
		header('Content-Type: application/json',true);
		$data=$this->Plan_model->get_calendar_events();
		foreach($data as &$item)
		{
			if($item['allDay'] == 0){
				$item['allDay']=false;
			}else{
				$item['allDay']=true;
			}
		}
		echo json_encode($data);	
	}	
	public function ajax_calendar_modify()
	{
		header('Content-Type: application/json',true);
		$this->load->model('Plan_model');	
		$data=$this->input->post();
		
	    $item['title']=$data['title'];
		$item['start']=$data['start'];
		$item['end']=$data['end'];
		
		$this->Plan_model->modify_calendar_event($data['id'],$item);	
	}
	public function ajaxCalendarAdd()
	{
		header('Content-Type: application/json',true);
		$data=$this->input->post();		
	    $item['title']=$data['title'];
		$item['start']=$data['start'];
		$item['end']=$data['end'];
		
		$this->Plan_model->addCalendarEvent($item);	
	}
	
	public function ajaxCalendarDel()
	{
		header('Content-Type: application/json',true);
		$this->load->model('Plan_model');	
		$data=$this->input->post();			
		$this->Plan_model->delCalendarEvent($data['id']);	
	}

}
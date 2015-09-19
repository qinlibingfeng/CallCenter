<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notice extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model("Notice_model");
		$this->load->library('DataTabes_helper');
	}
	public function navLook($agentId){
		$this->look($agentId);
	}
	//查看公告
	public function look($agentId,$offset=0,$sort_by='notice_ctime', $sort_order='desc')
	{
		$limit=8;
		$columns=array('ID'=>'notice_id','标题'=>'notice_title','创建时间'=>'notice_ctime');	
		$results=$this->Notice_model->get_all($agentId,$columns,$limit,$offset,$sort_by,$sort_order);
		
		$config['base_url'] = site_url('notice/look/'."/$agentId");
		$config['total_rows'] = $results['total_num'];
		$config['per_page'] = $limit;	
		$config['uri_segment'] = 4;		
		$this->pagination->initialize($config);	
		
		$data['pagination']=$this->pagination->create_links();	
		$data['columns']=$columns;
		$data['list_data']=$results['total_data'];
		$data['sort_order']=$sort_order;	
		$data['agentId']=$agentId;
		$this->load->view('notice_look_view',$data);
	}
	
	//添加公告
	public function add($agentId)
	{
		$data['title']='添加公告';
		$data['dst']='insert/'.$agentId;
		$data['agentId']=$agentId;
		$this->load->view('notice_edit_view.php',$data);	
	}
	
	public function modify($id,$agentId)
	{
		$ret=$this->Notice_model->get_byid($id);
		$data['title']='修改公告';
		$data['dst']='update/'.$id."/".$agentId;
		$data['notice']=$ret;
		$data['agentId']=$agentId;
		$this->load->view('notice_edit_view', $data);
	}
	
	//添加新数据导数据库
	public function insert($agentId)
	{
		if($this->Notice_model->insert_from_form($agentId))
		{
			redirect(site_url('notice/look'."/"."$agentId"));
		}
		else
		{
			$this->insert($agentId);
		}
	}
	
	public function update($id,$agentId)
	{
		if($this->Notice_model->update_from_form($id,$agentId))
		{
			redirect(site_url('notice/look'."/"."$agentId"));
		}
		else
		{
			$this->modify($id,$agentId);
		}
	}
	
	public function preview($id)
	{
		$ret=$this->Notice_model->get_byid($id);
		$data['notice']=$ret;
		$this->load->view('notice_preview_view', $data);
	}
	public function ajax_del()
	{
	 	  header('Content-Type: application/json',true);
		 //数据
		 $data=$this->input->post();	 
		 $this->Notice_model->delete_byids($data);	 
  		 echo json_encode($data);
	}
	
	public function ajaxLookNotice(){
		header('Content-Type: application/json',true);
		$sEcho=$this->input->get('sEcho');
		$req=$this->input->get();
		$output = array(
		"sEcho" => intval($sEcho),
		"iTotalRecords" => 1,
		"iTotalDisplayRecords" => 1,
		"aaData" => array()
		);
		
		$aColumns = array('notice_id','notice_title','notice_ctime');
		$sWhere="";
		$this->load->library('Agent_helper',array('agent_id'=>$req['agentId']));
			$this->load->library('firephp');
		$seachItems[]=$this->agent_helper->getNoticeAgentsCanShow();
		//$sWhere=$this->datatabes_helper->getSearchSql($seachItems);
		

		$sLimit=$this->datatabes_helper->getPageSql($req);
		//获得where语句
	
		//$sOrder=$this->datatabes_helper->getOrderSql($req,$aColumns);
		$sOrder="order by notice_ctime desc";
		$sTable="notice";
		$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit ";
		
		$ret=$this->db->query($sQuery);	
		$this->firephp->info('sql'.$sQuery);
		
		$output["aaData"]=$this->datatabes_helper->reverseResult($ret->result_array(),$aColumns,'notice_id');
		
		$sCount="select count(*) as sCount from $sTable $sWhere $sOrder";
		$ret=$this->db->query($sCount)->result_array();
		$output["iTotalRecords"]=$output["iTotalDisplayRecords"]=$ret[0]["sCount"];
		
		echo json_encode($output);
	}

}

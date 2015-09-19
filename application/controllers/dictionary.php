<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dictionary extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('Dictionary_model');
		$this->load->model('Dictionary_tree_model');
	}
	function navNormal($agentId){
		$this->normal();
	}
	function navAdvance($agentId){
		$this->advance();
	}
	/*
	*	普通字典视图
	*/
	function normal($name_type=0,$sort_by='name_value', $sort_order='asc',$offset=0)
	{
		$limit=10;
		$result=$this->Dictionary_model->getNormalDictionarys($name_type,$limit,$offset,$sort_by,$sort_order);		
		$config['base_url']=site_url("dictionary/normal/$name_type/$sort_by/$sort_order/");	
		$config['per_page']=$limit;	
		$config['uri_segment']=6;		
		$config['total_rows']=$result['total_rows'];
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['num_links'] = 12;
		$this->pagination->initialize($config);	
			
		$data['pagination']=$this->pagination->create_links();	
		
		$data['list_data']=$result['total_datas'];
		$data['sort_order']=$sort_order;	
		$data['nameTypeItems']=$this->getNameTypes($name_type);
		
		$this->load->view('dictionary_normal_look_view.php', $data);
	}
	
	function getNameTypes($name_type=0)
	{
		$retDb=$this->Dictionary_model->getNormalDictionaryTypes();
		foreach($retDb as $row)
		{
			$ret['nameTypeOptions'][$row['name_type']]=$row['name_type_text'];
		}
		$ret['nameDefaultType']=$name_type;
		return $ret;
	}	
	
	function normalAdd($name_type=0,$error='')
	{
		$data['title']='添加键值';
		$data['dst']='normalInsert/'.$name_type;
		$data['nameTypeItems']=$this->getNameTypes($name_type);
		$data['error']=$error;
		$this->load->view('dictionary_normal_edit_view',$data);
	}
	
	function normalAddNewType(){
		$data['title']='添加新项';
		$data['dst']='normalInsertType';
		$data['error']='';
		$this->load->view('dictionary_normal_add_type_view',$data);
	}
	
	function normalModify($id,$error='')
	{
		$data['title']='修改键值';
		$data['error']=$error;
		
		$ret=$this->Dictionary_model->getNormalDictionaryById($id);
		$data['item']=$ret;
		$data['nameTypeItems']=$this->getNameTypes($ret[0]['name_type']);
		$data['dst']='normalUpdate/'.$ret[0]['name_type'].'/'.$id;
		$this->load->view('dictionary_normal_edit_view',$data);
	}
	
	function normalInsert($name_type)
	{
		if($this->checkNormalPostData())
		{
			$item=$this->getNormalPostData();
			if($this->Dictionary_model->getNormalDictionaryCountOfValue($name_type,$item['name_value']) <= 0)
			{
				$ret=$this->Dictionary_model->getNormalDictionaryTypeText($name_type);		
				$item['name_type_text']=$ret[0]['name_type_text'];		
				$ret=$this->Dictionary_model->insertNormalDictionary($item);
				if($ret)
				{
					redirect(site_url('dictionary/normal/'.$name_type));
				}
			}
			else
			{
				$this->normalAdd($name_type,'键值已存在');
				return;
			}
		}
		$this->normalAdd($name_type);
	}
	
	function normalInsertType(){
		$this->form_validation->set_rules('name_type_text', '添加项', 'required');
		if($this->checkNormalPostData())
		{
			$item['name_value']=$this->input->post('key');
			$item['name_text']=$this->input->post('name');
			$res=$this->db->query("select max(name_type) as maxType from dictionary_normal")->result();
			if($res)
				$nameType=$res[0]->maxType+1;
			else
				$nameType=0;
			
		
			$item['name_type']=$nameType;
			$item['name_type_text']=$this->input->post('name_type_text');
			$ret=$this->Dictionary_model->insertNormalDictionary($item);
			if($ret)
			{
				redirect(site_url('dictionary/normal/'.$nameType));
			}
		}
		
		$this->normalAddNewType();
	}
	
	function normalUpdate($name_type,$id)
	{
		if($this->checkNormalPostData())
		{
			$item=$this->getNormalPostData();	
			$ret=$this->Dictionary_model->updateNormalDictionary($id,$item);
			if($ret)
			{
				redirect(site_url('dictionary/normal/'.$name_type));
			}				
		}
		$this->normalModify($id);
	}

	function checkNormalPostData()
	{
		$this->form_validation->set_rules('key', '键值', 'required');
		$this->form_validation->set_rules('name', '名字', 'required');
		return $this->form_validation->run();	
	}
	function getNormalPostData()
	{
		$data['name_value']=$this->input->post('key');
		$data['name_text']=$this->input->post('name');
		$data['name_type']=$this->input->post('name_type');
		return $data;
	}
	/*
	*	高级字典视图（树形）
	*/
	function advance(){
		$this->load->view('dictionary_advance_view');
	}
	function ajaxTreeDel(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');			
		$req=$this->input->post();
		$this->Dictionary_tree_model->deleteItemById($req['id']);
		
	}
	function ajaxTreeSave(){
		header('Content-type: Application/json',true);
		$this->load->library('firephp');			
		$req=$this->input->post();
		
		$data['treenames_pid']=$req['pid'];
		$data['treenames_tx']=$req['text'];
		if($req['pid'] != -1){
			$this->Dictionary_tree_model->insertItem($data);
		}
	}
	function ajaxGetTreeData(){
		header('Content-type: Application/json',true);
		$req=$this->input->post();	
		$id=$this->Dictionary_tree_model->getItemByText($req['tx']);
		$data=array();
		if($id[0])
			$data=$this->Dictionary_tree_model->getTreeDataByPid($data,$id[0]['treenames_id']);
		echo json_encode($data);
	}
	
	function ajaxTreeGetKeyValue(){
		header('Content-type: Application/json',true);	
		$req=$this->input->post();	
		$data=$this->Dictionary_tree_model->getItemsByPid($req['text']);
		echo json_encode($data);
	}
	
	function ajaxGetKeyValue(){
		header('Content-type: Application/json',true);			
		$req=$this->input->post();	
		if($req['type'] == 0)
			$data=$this->Dictionary_model->getNormalDictionaryByType($req['type']);
		else if($req['type'] == 1)
			$data=$this->Dictionary_model->getNormalDictionaryByTypeText($req['text']);
		echo json_encode($data);
	}
	
	function ajaxDel(){		
		header('Content-type: Application/json',true);
		$ids=$this->input->post();
		$this->db->where_in('name_id', $ids);
		$this->db->delete('dictionary_normal');
	}
}
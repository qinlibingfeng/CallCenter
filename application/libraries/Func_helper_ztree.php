<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Func_helper.php';
class Func_helper_ztree  {
	private $checker=null;
	function get_items($checker=null)
	{
		 $this->checker=$checker;
		 $CI =& get_instance();
		 $CI->load->model('Function_panel_model'); 
		 $items=array();	 
		 $query = $CI->Function_panel_model->get_items();
		 foreach ($query->result() as $row){	    
		    if ($row->p_id == 0){		
					array_push($items,$this->create_parent($row));      	  			 
		    }else{					
					$item=$this->create_child($row);
					if($item)
						array_push($items,$item);	    				    	
		    }		
		 }	 	 
		return $items;
	}
	
	function create_parent($row)
	{	
		$node=array();
		$node['pId']=0;
		$node['id']=$row->id;
		$node['name']=$row->text;
		$node['open']=true;
		//$node['iconOpen']=$row->logo;
		//$node['iconClose']=$row->logo;
		return $node;
	}
	
	function create_child($row)
	{
		$node['pId']=$row->p_id;
		$node['id']=$row->id;
		$node['name']=$row->text;
		//$node['icon']=$row->logo;
		if($this->checker && $this->checker->checked($row))
			$node['checked']=true;
		return $node;
	}
}

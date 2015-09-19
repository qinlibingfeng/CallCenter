<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Func_helper {

    function __construct()
    {
		
    }
	
	public function get_items($filter=null){	
		 $CI =& get_instance();
		 $CI->load->model('Function_panel_model'); 
		 $items=array();	 
		 $query = $CI->Function_panel_model->get_items();
		 foreach ($query->result() as $row){	    
		    if ($row->p_id == 0){	
				if($filter == null  ||  $filter->filter_item($row))	
					array_push($items,$this->create_parent($row));      	  			 
		    }else{		
				if ($filter == null  || $filter->filter_item($row))
				{
					$item=$this->create_child($row);
					$index=$this->find_item($row->p_sid,$items);
					if($index>=0){
						array_push($items[$index]["sub_items"],$item);	    		
					}	
				}			    	
		    }		
		 }	 	 
		return $items;
	}
	
	private  function find_item($id,$items){
		for($i=0; $i< count($items); $i++){		
			if($items[$i][$this->find_item_use()] == $id){
				return $i;
			}
		}
		return -1;
	}
	
	protected  function create_child($row){	
		$item=array("item_id"=>$row->s_id,
					"item_logo"=>$row->logo,
					"item_text"=>$row->text,
					"item_url"=>site_url($row->url));
		return $item;		
	}
	
	protected  function create_parent($row){
		$item=array("item_text"=>$row->text,
				"item_logo"=>$row->logo,
				"subitem_num"=>0,
				"item_id"=>$row->s_id,
				"is_expand"=>0,
				"sub_items"=>array());	
		return $item;
	}
	
	protected  function find_item_use()
	{
		return 'item_id';
	}
}

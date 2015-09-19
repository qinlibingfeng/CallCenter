 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 class Dynamicui {
	private $agentId;
	function __construct($param){
		$this->agentId=$param["agentId"];		
    }
	
	function getDynamicuiModel(){	
		return "dynamicui_model";	
	}
	
 }
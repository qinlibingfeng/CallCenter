<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'client.php';
class Childclient extends Client{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('DataTabes_helper');
		$this->load->library('excel_helper');
		
		date_default_timezone_set('Asia/Shanghai');
	}
	 public function index()
	{	 
		$this->all();
	 }
	

	
}
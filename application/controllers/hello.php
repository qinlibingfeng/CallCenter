<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hello extends CI_Controller{
	public function  index(){
		$data['title']='my page title';
		$this->load->view('hello_view',$data);
	}
}
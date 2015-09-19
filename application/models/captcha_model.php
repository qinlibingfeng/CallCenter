<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Captcha_model extends CI_Model{
	public function create_captcha(){
		$data['title']='登录页面';
		$data['image']='images/login_12.png';
		//生成验证码
		$vals = array(
     	'img_path' 	=> './www/captcha/',
     	'img_url' 	=> 'http://localhost/www/captcha/',
		'img_width'	=>'120',
		'img_height'=>30);	
		$cap = create_captcha($vals);	
		return $cap;
	}
	public function insert($data){
		$query = $this->db->insert_string('captcha', $data);
 		return $this->db->query($query);
	}
	public function get(){
		$expiration = time()-7200; // 2小时限制
	 	$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration); 
	
		// 然后再看是否有验证码存在:
	 	$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
	 	$binds = array($this->input->post("captcha"), $this->input->ip_address(), $expiration);
	 	$query = $this->db->query($sql, $binds);
	 	$row = $query->row();
		return ($row->count == 0);
	}
}
<?php
class CheckLogin {

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function index($params = null)
	{
		$nocheck = ["login", "api"];
		if (empty($this->CI->uri->segments)) {
			if ($this->CI->session->has_userdata('login')){
				redirect(base_url() . 'home');
			}
		}
		elseif(!in_array($this->CI->uri->segments[1], $nocheck)) {
			if (!$this->CI->session->has_userdata('login')){
				redirect(base_url());
			}	
		}
	}
}
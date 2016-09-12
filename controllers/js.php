<?php
class Js extends CI_Controller {
	public function __construct() {
		parent::__construct();
//		$this->load->model('Memo_model','memo',true);
		$this->load->helper('url');
	}


	public function index($path = null, $param = null) {
		$this->load->view('$path/$param');
	}
}
?>

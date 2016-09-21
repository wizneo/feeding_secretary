<?php
class Test extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Fd_message_model','message',true);
		$this->load->helper('url');
	}


	public function index() {
		$this->message->cancel_feeding_hst('test_user_key');
//		$output_data = array(
//			'memo_list' => $this->memo->get_list(),
//			);
//		$this->load->view('accountbook/main', $output_data);
	}
	
	public function send_msg() {
		$this->load->view('test/send_msg');
	}
	
}
?>

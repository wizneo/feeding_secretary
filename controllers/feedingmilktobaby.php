<?php
class Feedingmilktobaby extends CI_Controller {
	public function __construct() {
		parent::__construct();
 		$this->load->model('Message_model','message',true);
// 		$this->load->helper('url');
	}


	public function keyboard() {
		$output_data = array(
			'type' => 'text',
			'buttons' => array('메뉴1','메뉴2','메뉴3')
		);
		$output_data = json_encode($output_data);
		echo $output_data;
		//$this->load->view('memo_index', $output_data);
	}

	public function message() {
		$input_data = array(
			'user_key' => $this->input->post('user_key'),
			'type' => $this->input->post('type'),
			'content' => $this->input->post('content')
		);
		//$this->message->insert_message($input_data);	
	}

	public function save() {
		$contents = $this->input->post('contents');
		$title = strlen($this->input->post('title')) == 0 ? substr($contents, 0, 50) : $this->input->post('title');
		
		$input_data  = array(
			'title' => $title,
			'contents' => $contents,
			'del_yn' => 'N'
			);

		$this->memo->insert_memo($input_data);
		redirect('/memo');
	}

	public function delete($num) {
		$this->memo->delete_memo($num);
		redirect('/memo');
	}
}
?>

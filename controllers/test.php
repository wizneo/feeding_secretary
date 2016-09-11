<?php
class Test extends CI_Controller {
	public function __construct() {
		parent::__construct();
//		$this->load->model('Memo_model','memo',true);
//		$this->load->helper('url');
	}


	public function index() {
		$str = "11시20분 120ml";
		print_r(preg_split("/[ 시분:미리(ml)]+/", $str));
//		$output_data = array(
//			'memo_list' => $this->memo->get_list(),
//			);
//		$this->load->view('accountbook/main', $output_data);
	}

	public function form() {
		$this->load->view('memo_form');	
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

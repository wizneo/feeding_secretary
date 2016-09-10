<?php
class Address extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Address_model','address',true);
	}

	private static function _isMobile() {
		$mobile_agent = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/';  
		if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT']) == true) {  
			//header("Location:http://namune.net/");
			return true;
		}
		else {
			return false;
		}
	}

	public function index()
	{
		// if (!self::_isMobile()) {
		// 	echo "";
		// }
		// else {
				
			$this->load->view('address');
			
		// }
		// $data['title'] = ucfirst($page); // Capitalize the first letter
		// $this->load->view('templates/header', $data);
		// $this->load->view('pages/'.$page, $data);
		// $this->load->view('templates/footer', $data);
	}

	public function get_one() {
		// echo json_encode(array("no" => "11110-100197365", "address" => "서울특별시 종로구 부암동 327"));
		// return;
		$query_result = $this->address->get_one();
		if ($query_result == "NO_DATA") {
			echo json_encode(array("no" => "0"));
		}
		else {
			$arr = array("no" => $query_result->no, "address" => $query_result->address);
			echo json_encode($arr);
		}	
	}

	public function save_result() {
		$no = $this->input->post('no');
		$name = $this->input->post('name');
		
		$count = $this->address->save_result($no, $name);
		if ($count == "1") {
			echo json_encode(array("result" => "success"));
		}
		else {
			echo json_encode(array("result" => "fail"));
		}
	}
}
?>

<?php
class Minyoung extends CI_Controller {
	public function __construct() {
		parent::__construct();
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
				
			$this->load->view('minyoung_mobile_index');
			
		// }
		// $data['title'] = ucfirst($page); // Capitalize the first letter
		// $this->load->view('templates/header', $data);
		// $this->load->view('pages/'.$page, $data);
		// $this->load->view('templates/footer', $data);
	}
}
?>

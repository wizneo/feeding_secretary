<?php
class Feedingmilktobaby extends CI_Controller {
	public function __construct() {
		parent::__construct();
 		$this->load->model('Fd_message_model','message',true);
 		$this->load->model('Fd_user_model','user',true);
// 		$this->load->helper('url');
	}


	public function keyboard() {
		$output_data = array(
			'type' => 'text'
//			'buttons' => array('temp');//$this->input->post('user_key');
		);
		
		$output_data = json_encode($output_data);
		echo $output_data;
		//$this->load->view('memo_index', $output_data);
	}
	
	private function getInput() {
		return json_decode(file_get_contents('php://input'));
	}
	
	public function friend($param = null) {
		$method = $this->input->server('REQUEST_METHOD');
		if ($method != "POST" && $method != "DELETE") {
			return;
		}
		$input_data = $this->getInput();
		if ($method == "POST") {
			$this->user->insert_user(array(
				'user_key' => $input_data->user_key
			));
		}
		else if ($method == "DELETE" && $param != null) {
			$this->user->delete_user(array(
					'user_key' => $param
				)
			);
		}
	}

	public function chat_room($param = null) {
		$method = $this->input->server('REQUEST_METHOD');
		if ($method != "DELETE" || $param == null) {
			return;
		}
		$this->user->unjoin_user(array(
				'user_key' => $param
			)
		);
	}
	
	public function message() {
		$method = $this->input->server('REQUEST_METHOD');
		if ($method != "POST") {
			return;
		}
		$input_data = $this->getInput();

		$user_key = $input_data->user_key;
		$type = $input_data->type;
		$content = $input_data->content;
		
		// 메세지 저장
		$input_data = array(
			'user_key' => $user_key,
			'type' => $type,
			'content' => $content
		);
		$this->message->insert_message($input_data);
		
		// 메세지 분석 
		$analized_msg_arr = $this->anaylize_message($content);
		$feeding_hour = $analized_msg_arr[0];
		$feeding_min  = $analized_msg_arr[1];
		$feeding_amount  = $analized_msg_arr[2];
		
		$feeding_dtm = date('Y-m-d ').$feeding_hour.':'.$feeding_min.':'.date(':s');
		// 수유 기록  저장
		$hst_data = array(
			'user_key' => $user_key,
			'feeding_dtm' => $feeding_dtm,
			'amount' => $feeding_amount
		);
		$this->message->insert_feeding_hst($hst_data);
		
		// 통계 추출
		$output_data = array(
			'message' => array(
				'text' => $content
				)
		);
		$this->user->join_user(array(
				'user_key' => $user_key
			)
		);	
		echo json_encode($output_data);
	}
	

	// 11:20 120미리 먹음
	// 11시20분 120 먹음
	// 11:20 120
	// 11시20분  120
	private function anaylize_message($msg) {
		return preg_split("/[ 시분:미리(ml)]+/", $str);
	}
}
?>

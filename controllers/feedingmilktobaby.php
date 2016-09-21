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
		$out_message = "";
		// 메세지 저장
		$input_data = array(
			'user_key' => $user_key,
			'type' => $type,
			'content' => $content
		);
		$this->message->insert_message($input_data);
		
		// 메세지 분석 
		$analized_msg = $this->anaylize_message($content);

		
		if ($analized_msg['result'] == 'FAIL') {
			// 메세지에서 명령어 구분
			if (trim($content) == '야' || trim($content) == '수유비서') {
				$out_message = $this->get_help_msg();
			}
			else {
				$out_message = "인식할 수 없는 형태의 명령입니다. 명령의 예를 보려면 '야' 또는 '수유비서'라고 불러주세요.";
			}
		}
		else {
			// 수유 기록  저장
			$hst_data = array(
				'user_key' => $user_key,
				'feeding_dtm' => $analized_msg['feeding_dtm'],
				'amount' => $analized_msg['feeding_amount']
			);
			$this->message->insert_feeding_hst($hst_data);
			$out_message = $analized_msg['feeding_dtm']."에 ".$analized_msg['feeding_amount']."먹였군요! 이 기록을 취소하려면 '취소' 또는 '아니' 라고 해주세요.";
		}
		
		// 사용자를 채팅 중 상태로 변경
		$this->user->join_user(array(
				'user_key' => $user_key
			)
		);	
		
		// 메세지 출력
		$output_data = array(
			'message' => array(
				'text' => $out_message
				)
		);
		echo json_encode($output_data);
	}
	
	// 11:20 120
	private function anaylize_message($msg) {
		preg_match('/^[0-9]{2}:[0-9]{2} [0-9]{3}$/', $msg ,$matched_arr);
		$feeding_amount = 0;
		$feeding_dtm = "";
		$result = "";
		if (count($matched_arr) > 0) {
			$analized_msg_arr = preg_split("/[ 시분:]+/", $msg);
			$feeding_hour = $analized_msg_arr[0];
			$feeding_min  = $analized_msg_arr[1];
			$feeding_dtm = date('Y-m-d ').$feeding_hour.':'.$feeding_min.':00';
			$feeding_amount  = $analized_msg_arr[2];
			$result = "SUCCESS";
		}
		else {
			$result = "FAIL";
		}
		return array(
				'result' => $result,
				'feeding_dtm' => $feeding_dtm,
				'feeding_amount' => $feeding_amount
			);
	}
	
	private function get_help_msg() {
		return "수유시간과 양을 시:분 양 으로 말해주세요. 예를 들면 \n13:20 120\n이라고 말하면 13:20분에 120ml 를 먹었다고 알아듣습니다. 이 때, 시간은 24시간 단위로 적어주세요. 2시라고 하면 항상 오전 2시로 인식하니 오후 2시를 뜻할 때는 14로 적어주세요.";
	}
}
?>

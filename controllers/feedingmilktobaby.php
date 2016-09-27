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
		$analized_msg = null;
		// 메세지 저장
		$input_data = array(
			'user_key' => $user_key,
			'type' => $type,
			'content' => $content
		);
		$this->message->insert_message($input_data);
		

		// 메세지에서 명령어가 있으면 명령어대로 실행
		if (trim($content) == '수유비서') {
			$out_message = $this->get_help_msg();
		}
		else if (trim($content) == '취소') {
			$this->message->cancel_feeding_hst($user_key);
			$out_message .= "취소했습니다.";
			$today_total_amount = $this->message->get_today_total_amount($user_key);
			$out_message .= "오늘 하루 총 수유량은 ".$today_total_amount."ml 입니다.";
		}
		else  {
			// 메세지 분석 
			$analized_msg = $this->anaylize_message($content);
			if ($analized_msg['result'] == 'FAIL') {
				$out_message = "인식할 수 없는 형태의 명령입니다. 명령의 예를 보려면 '수유비서'라고 불러주세요.";
			}
			else {
				// 수유 기록  저장
				$hst_data = array(
					'user_key' => $user_key,
					'feeding_dtm' => $analized_msg['feeding_dtm'],
					'amount' => $analized_msg['feeding_amount']
				);
				
				$this->message->insert_feeding_hst($hst_data);
				if ($analized_msg['additional_msg'] != '') {
					$out_message .= $analized_msg['additional_msg']."\n";
				}
				$out_message .= $analized_msg['feeding_dtm']."에 ".$analized_msg['feeding_amount']."ml 먹었습니다.\n이 기록을 취소하려면 취소 라고 해주세요.\n";
				
				if ($analized_msg['additional_msg'] != '') {
					$yesterday_total_amount = $this->message->get_yesterday_total_amount($user_key);
					$out_message .= "어제 하루 총 수유량은 ".$yesterday_total_amount."ml 입니다.";
				}
				else {
					$today_total_amount = $this->message->get_today_total_amount($user_key);
					$out_message .= "오늘 하루 총 수유량은 ".$today_total_amount."ml 입니다.";
				}
			}
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
	
	private function anaylize_message($msg) {
		// 11:20 120
		preg_match('/^[0-9]{1,2}:[0-9]{1,2} +[0-9]+$/', $msg ,$matched_arr);
		$feeding_amount = 0;
		$feeding_dtm = "";
		$result = "";
		$additional_msg = "";
		if (count($matched_arr) > 0) {
			$analized_msg_arr = preg_split("/[ 시분:]+/", $msg);
			$feeding_hour = $analized_msg_arr[0];
			$feeding_min  = $analized_msg_arr[1];
			$feeding_dtm = date('Y-m-d ').$feeding_hour.':'.$feeding_min.':00';
			$feeding_amount  = $analized_msg_arr[2];
			$result = "SUCCESS";
			
			// 현재 시간 보다 큰 시간이면 어제 날짜로 인식
			if ($feeding_hour > date('H') && $feeding_hour < 12 && date('H') < 12) {
				$additional_msg = "시간을 보니 어제(".date('Y-m-d', strtotime(date('Y-m-d').' -1 day')).") 먹인 거로군요!";
				$feeding_hour = intval($feeding_hour) + 12;
				$feeding_dtm = date('Y-m-d', strtotime(date('Y-m-d').' -1 day'))." ".$feeding_hour.':'.$feeding_min.':00';
			}
		}
		else {
			$result = "FAIL";
		}
		return array(
				'result' => $result,
				'feeding_dtm' => $feeding_dtm,
				'feeding_amount' => $feeding_amount,
				'additional_msg' => $additional_msg
			);
	}
	
	private function get_help_msg() {
		return "수유시간과 양을 시:분 양 으로 말해주세요. 예를 들면 \n13:20 120\n이라고 말하면 13:20분에 120ml 를 먹었다고 알아듣습니다. 이 때, 시간은 24시간 단위로 적어주세요. 2시라고 하면 항상 오전 2시로 인식하니 오후 2시를 뜻할 때는 14로 적어주세요.";
	}
}
?>

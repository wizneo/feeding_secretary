<?php
class Fd_message_model extends CI_Model {
	private static $table_message = 'fd_message';
	private static $table_feeding_hst = 'fd_feeding_hst';
	public function __construct() {
		parent::__construct();
	}

	private function get_max_no($user_key) {
		$this->db->where('user_key', $user_key);
		$this->db->select_max('no');
		$query = $this->db->get(self::$table_message);
		$result_arr = $query->result();
		return $result_arr[0]->no;
	}
	
	public function get_today_total_amount($user_key) {
		$sql = "SELECT sum(`amount`) as today_total_amount FROM fd_feeding_hst WHERE use_yn = 'Y' AND user_key = ? AND feeding_dtm BETWEEN ? AND ?";
		$query = $this->db->query($sql, array($user_key, date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d').' +1 day'))));
		$result_arr = $query->result();
		$total_amount = $result_arr[0]->today_total_amount;
		return $total_amount == "" ? 0 : $total_amount;
	}
	
	public function get_yesterday_total_amount($user_key) {
		$sql = "SELECT sum(`amount`) as today_total_amount FROM fd_feeding_hst WHERE use_yn = 'Y' AND user_key = ? AND feeding_dtm BETWEEN ? AND ?";
		$query = $this->db->query($sql, array($user_key, date('Y-m-d', strtotime(date('Y-m-d').' -1 day')), date('Y-m-d')));
		$result_arr = $query->result();
		$total_amount = $result_arr[0]->today_total_amount;
		return $total_amount == "" ? 0 : $total_amount;
	}
	
	public function cancel_feeding_hst($user_key) {
		$sql = "SELECT no FROM fd_feeding_hst WHERE user_key = ? AND use_yn = 'Y' ORDER BY no DESC LIMIT 1";
		$query = $this->db->query($sql, array($user_key));
		$result_arr = $query->result();
		$no = $result_arr[0]->no;
		
		$sql = "update fd_feeding_hst SET use_yn = 'N' WHERE no = ?";
		$query = $this->db->query($sql, array($no));
	}

	public function get_today_avg_term($user_key) {
// 		$sql = "";
// 		SELECT TIMESTAMPDIFF(HOUR, now(), DATE_ADD(now(),INTERVAL 1 HOUR)) dd ==> 1시간
// 		SELECT TIMESTAMPDIFF(MINUTE, now(), DATE_ADD(now(),INTERVAL 1 HOUR)) dd ==> 60분
	}
	
	public function insert_message($data) {
		$data['reg_dtm'] = date('Y-m-d H:i:s');
		$this->db->insert(self::$table_message, $data);
	}
	
	public function insert_feeding_hst($data) {
		$data['reg_dtm'] = date('Y-m-d H:i:s');
		$data['msg_no'] = $this->get_max_no($data['user_key']);
		$this->db->insert(self::$table_feeding_hst, $data);
	}

	public function get_list($user_key) {
		$query = $this->db->get_where(self::$table_memo, array('del_yn' => 'N'));
		$memo_list = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				array_push($memo_list, $row);
			}
		}
		return $memo_list;
	}

	public function delete_memo($num) {
		$update_data = array('del_yn' => 'Y');
		$this->db->where('id', $num);
		$this->db->update(self::$table_memo, $update_data);
	}
}
?>

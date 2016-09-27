<?php
class Fd_notice_model extends CI_Model {
	private static $table_notice = 'fd_notice';
	private static $table_user = 'fd_user';
	public function __construct() {
		parent::__construct();
	}

	public function get_notice($user_key) {
		$sql = "SELECT notice FROM fd_notice WHERE exists (SELECT user_key FROM fd_user WHERE user_key = ? AND notice_read_yn = 'N') ORDER BY no desc LIMIT 1";
		$query = $this->db->query($sql, array($user_key));
		$result_arr = $query->result();
		$notice = "";
		if (count($result_arr) > 0) {
			$notice = $result_arr[0]->notice;
			if ($notice != "") {
				$this->read_notice($user_key);
				$notice .= "\n";
			}
		}
		else {
			$notice = "";
		}
		return $notice;
	}

	private function read_notice($user_key) {
		$update_data = array('notice_read_yn' => 'Y');
		$this->db->where('user_key', $user_key);
		$this->db->update(self::$table_user, $update_data);
	}

}
?>

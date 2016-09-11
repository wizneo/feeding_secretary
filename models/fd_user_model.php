<?php
class Fd_user_model extends CI_Model {
	private static $table_user = 'fd_user';
	public function __construct() {
		parent::__construct();
	}

	public function insert_user($data) {
		$data['active_yn'] = 'Y';
		$data['in_chat'] = 'N';
		$data['reg_dtm'] = date('Y-m-d H:i:s');
		$data['upd_dtm'] = date('Y-m-d H:i:s');
		$this->db->insert(self::$table_user, $data);
	}
	
	public function delete_user($data) {
		$data['active_yn'] = 'N';
		$data['upd_dtm'] = date('Y-m-d H:i:s');
		$this->db->where('user_key', $data['user_key']);
		$this->db->where('active_yn', 'Y');
		$this->db->update(self::$table_user, $data);
	}
	
	public function unjoin_user($data) {
		$data['in_chat'] = 'N';
		$data['upd_dtm'] = date('Y-m-d H:i:s');
		$this->db->where('user_key', $data['user_key']);
		$this->db->where('active_yn', 'Y');
		$this->db->update(self::$table_user, $data);
	}
	
	public function join_user($data) {
		$data['in_chat'] = 'Y';
		$data['upd_dtm'] = date('Y-m-d H:i:s');
		$this->db->where('user_key', $data['user_key']);
		$this->db->where('active_yn', 'Y');
		$this->db->update(self::$table_user, $data);
	}

	public function get_list() {
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

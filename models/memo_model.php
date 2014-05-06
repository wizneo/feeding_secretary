<?php
class Memo_model extends CI_Model {
	private static $table_memo= 'w_memo';
	public function __construct() {
		parent::__construct();
	}

	public function insert_memo($data) {
		$data['created_dt'] = date('Y-m-d h:i:s');
		$data['modified_dt'] = date('Y-m-d h:i:s');
		$this->db->insert(self::$table_memo, $data);
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

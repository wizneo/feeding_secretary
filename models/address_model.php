<?php
class Address_model extends CI_Model {
	private static $table_address= 'address_base';
	public function __construct() {
		parent::__construct();
	}

	public function get_one() {
		$query = $this->db->query('SELECT no, address FROM address_base WHERE name = \'\' LIMIT 1', false);
		if ($query->num_rows == "0") {
			return "NO_DATA";
		}
		else {
			return $query->result()[0];
		}
	}

	public function save_result($no, $name) {
		$update_data = array('name' => $name);
		$this->db->where('no', $no);
		$query_result = $this->db->update(self::$table_address, $update_data);

		$query = $this->db->query("SELECT name, address FROM `address_base` WHERE `no` = '$no' LIMIT 1", false);
		$name = $query->result()[0]->name;
		$address = $query->result()[0]->address;

		$update_data = array('name' => $name);
		$this->db->where('address', $address);
		$this->db->update(self::$table_address, $update_data);		

		return $query_result;
	}
}
?>

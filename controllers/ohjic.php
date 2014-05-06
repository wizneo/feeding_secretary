<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ohjic extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('ohjic_jsonp');
	}
	
	public function tpl() {
		$this->load->view('return_jsonp_ohjic_tpl');
	}
	
	public function get_list() {
		$this->load->view('ohjic_naver_jsonp');
	}
	
	public function concatCSV() {
		$this->load->view('concat_csv_v');
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library( array('session', 'formbuilder') );
		$this->load->helper('language', 'general', 'url');
		log_message('debug', "CI_Controller Class Initialized");
	}

	/**
	 * Stran za prijavo v admin del
	 */
	public function login() {
	
		echo $this->input->server("REQUEST_METHOD").BR;
		if($this->input->server("REQUEST_METHOD") == "POST") {
	
			//sanitize data
			$u = $this->input->post('user_name');
			$p = $this->input->post('user_pass');
				
			//$user = $this->db_model->checkUser($u, $p, $g);
			//hardkodiramo podatke
			$admins = array(
					'bama' 		=> 'parser',
					'jamie' 	=> 'parser',
					'mhcc'		=> 'parser'
					);
			
			//pofejkamo user database
			$user = (array_key_exists($u, $admins) && in_array($p, $admins)) ? TRUE : FALSE;
	
			if($user) {
				$this->session->set_userdata('logged_in', TRUE);
				$this->session->set_userdata('user', $u);
				redirect('admin/parser');
			}
			else {
				$this->output('admin/login', lang('admin_login'), array('error' => lang('wrong_credentials')));
			}
		}
		else {
			$this->output('admin/login', lang('admin_login'));
				
		}
	}
	
	/**
	 * Odjava iz admin dela
	 */
	public function logout() {
	
		$this->session->set_userdata('logged_in', FALSE);
		$this->session->destroy();
		var_export($this->session->userdata('logged_in'));
		//redirect('main/login');
	}
	
	/**
	 * @param unknown_type $url
	 * @param unknown_type $credentials
	 * @return string|unknown
	 */
	private function curl($url, $credentials=array() ) {
	
		if(!isset($url) || $url=='') return '';
	
		$this->load->library('curl');
	
		$c = $this->curl;
		$c->create($url);
	
		$c->option(CURLOPT_FAILONERROR, true);
		$c->option(CURLOPT_CONNECTTIMEOUT, 15); //The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
		$c->option(CURLOPT_TIMEOUT, 15);	//The maximum number of seconds to allow cURL functions to execute.
		$c->option(CURLOPT_RETURNTRANSFER, TRUE);
	
		// Login to HTTP user authentication
		if(count($credentials) > 0) {
			$c->http_login($credentials[0], $credentials[1]);
		}
	
		//special options
		$c->option(CURLOPT_TIMECONDITION, CURL_TIMECOND_IFMODSINCE);
		$response = $c->execute();
		if($this->debug) $c->debug();
		return $response;
	}
	
	/**
	 * Kreiranje view-jev iz vseh podatkov: header, meni,
	 * @param string $pageName
	 * @param string $pageTitle
	 * @param array $data
	 */
	public function output($pageName, $pageTitle='CMS', $data=array() ) {
	
		//set_document_title($pageTitle);
	
		$data['title'] = $pageTitle;
	
		//nafilamo podatke za globalni meni. Ce imamo breadcrumbe, jih prikazemo (po levelih)
		$menuData = array(
				'title' 		=> $pageTitle,
				'user_group'	=> '',
				'breadcrumbs' 	=> (isset($data['breadcrumbs'])) ? $data['breadcrumbs'] : 0
		);
	
		$this->load->view('template/header');
		$this->load->view('template/menu', $menuData );
		$this->load->view($pageName, $data);
		$this->load->view('template/footer');
	}
	
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
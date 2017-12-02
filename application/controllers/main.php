<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public $mice = array();
	private $customer = '';
	
	public function __construct() {
		parent::__construct();
		$this->load->library( array('curl', 'session', 'formbuilder', 'jquery_ext') );
		$this->load->helper( array('url', 'general', 'language') );
		$this->load->model('mh_db');
		
		
		//load mice array
		$this->set_mice_array();
		
		$this->customer = $this->session->userdata('user');
		
		//load collectibles config (weapons, bases...)
		$this->set_collectibles_array();
		
		//temporary: check localization
		//$this->check_location();
		
		log_message('debug', "Main Controller Class Initialized");
	}
	
	public function index() {

		if($this->input->server("REQUEST_METHOD") == "POST") {
			$this->login();
		}
		else {
			$this->output('common/index');
		}
		
	}
	
	public function faq() {
		$this->output('common/faq');
	}
	
	
	/**
	 * @TODO: 
	 * apple-touch-icon.png
	 * apple-touch-icon-114x114.png
	 */
	//
	
	
	######################################
	########## ADMIN AREA ################
	######################################
	
	public function upload() {
		
		$this->validate();
		
		$msg = array('text', 'type');
		
		if( isset($_FILES['hunters']) ) {
			
			//najprej pozenemo Upload mlincek za varno shranitev upload datoteke v zacasni direktorij
			$config = array(
					'upload_path' 	=> data_url(),
					'allowed_types'	=> 'txt|csv|xls|xlsx',
					'is_image'		=> FALSE,
					'overwrite'		=> TRUE,
					'file_name'		=> ''
				);

			$this->load->library('upload', $config);
			
			//ce smo uspeli, pozenemo se mlincek za resize in prestavitev slik v pravilen folder
			if ( $this->upload->do_upload('hunters')) {
				
				$helper = $this->upload->data();
				
				$msg['type'] = 'success';
				$msg['text'] = 'File uploaded successfully. Visit parser page.';
				
				//save filename for the current user
				//$this->mh_db->save_filename($helper['file_name'], $this->session->userdata('user'));
				
				$this->session->set_userdata('filename', $helper['file_name']);
			}
			//nekaj je slo narobe
			else {
				$msg['type'] = 'error';
				$msg['text'] = $this->upload->display_errors();
			}
		
		}
		else {
			
		}
		
		
		$this->output('main/upload', 'Upload Hunters', array('msg' => $msg));
	}
	
	public function parser($page=1, $tournament=FALSE) {
		
		$this->validate();
		
		$page = (int) $page;
		
		/*
		if($tournament) {
			$comp = $this->mh_db->get_tournament($tournament);
			$file = $comp['comp_file'];
			
			//$crowns = explode(',', 'acolyte,chrono,reaper,lycan,vampire,treasurer,snooty,high_roller,mobster,leprechaun');
		}
		else $file = $this->session->userdata('file');
		*/
		
		$file = $this->session->userdata('file');
		
		//get CSV data from session
		if($file !== FALSE && $file != '') {
			$data = $this->parse_csv( data_url() . $file);
		}
		else {
			show_error('You did not upload any hunters data yet!', 200);
		}
				
		$this->load->library('table');
		
		$max = count($data);
		$per_page = PAGE_NUM;
		
		//create pagination		
		if($max > $per_page) {
			
			$func = site_url() . 'main/parser/';
			
			$pages = ceil($max / $per_page);
			
			//error handling: prevent manual access to bigger page than possible
			if($page == 0 || $page > $pages) {
				show_error('Page number is out of limits.', 405);
			}
			
			$remainder = $max % $per_page;
			
			$all_page_data = array_chunk($data, $per_page);

			//extract data for current page only
			$page_data = $all_page_data[$page-1];
			
			$pagination = '<div class="pagination pagination-centered">'."\n";
			$pagination .= '<ul>'."\n";
			
			//'.$previous.'
			if($page == 1) $pagination .= '<li class="disabled"><a href="#">Previous</a></li>'."\n";
			else $pagination .= '<li><a href="'.$func.($page-1).'">Previous</a></li>'."\n";
			
			for($i=1; $i<$pages+1; $i++) {
					
				if($i == $page) $pagination .= '<li class="active"><a href="#">'.$i.'</a></li>'."\n";
				else $pagination .= '<li><a href="'.$func.$i.'">'.$i.'</a></li>'."\n";
			}
			
			if($page == $pages) $pagination .= '<li class="disabled"><a href="#">Next</a></li>'."\n";
			else $pagination .= '<li><a href="'.$func.($page+1).'">Next</a></li>'."\n";
			
			$pagination .= '</ul>'."\n";
			$pagination .= '</div>'."\n";
			
		}
		else {
			$page_data = $data;
			$pages = 1;
			$pagination = '';
		}
		
		
		$tmpl = array ( 'table_open' => '<table class="table table-striped">' );
		$this->table->set_template($tmpl);
		
		//IMPORTANT! array of mice or collectibles IDs, needed for ajax
		$cellKeys = array(0 => '');
		
		$heading = array('Name');
		//$customer = $this->customers[$this->customer];
		
		//if we're parsing crowns, let's fill the heading
		if(in_array('crowns', $this->session->userdata('actions'))) {
			
			$crowns = $this->session->userdata('crowns');
			
			//we have IDs but we want mice names
			foreach($crowns as $key) {
				$cellKeys[] = $this->mice[$key];
				$heading[] = '<img src="'.images_url().'mice/'. $key.'.gif" alt="'.$this->mice[$key].'" title="'.$this->mice[$key].'" width="50px" height="50px" />';
			}
		}
		
		//if we're parsing collectibles, let's fill the heading
		if(in_array('collectibles', $this->session->userdata('actions'))) {
			
			$collectibles = $this->session->userdata('collectibles');
			
			//we have IDs but we want mice names
			foreach($collectibles as $key) {
				$cellKeys[] = $this->collectibles[$key];
				$heading[] = '<img src="'.images_url().'collectibles/'. $key.'.jpg" alt="'.$this->collectibles[$key].'" title="'.$this->collectibles[$key].'" width="50px" height="50px" />';
			}
		}		

		$this->table->set_heading($heading);
		
		//get saved data for current customer
		$saved_data = ($this->customer != 'test') ? $this->mh_db->get_customer_data($this->customer) : array();
		
		$snuids = array();
		
		//collect data only for current page 
		foreach($page_data as $hunter) {
			
			$snuids[] = $snuid = $hunter['snuid'];
			
			$row = array();
			//add rows
			for($i=0; $i<count($heading); $i++) {

				$mouseId = array_search($cellKeys[$i], $this->mice);
				$itemId = array_search($cellKeys[$i], $this->collectibles);
				
				//we might have mice or collectibles in the header, we have to choose proper ID string
				$cellId = ($mouseId === false) ? $itemId : $mouseId;
				
				if($i==0) {
					$row[] = (
							array(
									'data' => anchor($hunter['link'], $hunter['name'], array('target' => 'blank', 'title' => 'open hunter link in new window')),
									'id' => 'row_'.$hunter['snuid'].'_hunter'
							));
				}
				else {
					$value = 0;
					
					if($cellId === false) $cellId = '';	//error handling
					
					if($snuid === FALSE) continue;
					
					//find saved data if exists and grab the value from respective array
					if( array_key_exists($snuid, $saved_data) ) {
						
						if( array_key_exists($cellId, $saved_data[$snuid]['crowns']) ) 				$value = $saved_data[$snuid]['crowns'][$cellId];
						else if( array_key_exists($cellId, $saved_data[$snuid]['collectibles']) ) 	$value = $saved_data[$snuid]['collectibles'][$cellId];
					}
					
					$row[] = array('data' => $value, 'id' => 'row-'.$hunter['snuid'].'-'.$cellId);
				}
			}
			
			$this->table->add_row($row);
		}
		
		$table = $this->table->generate();
		
		$outData = array(
				'table' => $table, 
				'snuids'=> implode(',', $snuids),
				'pages'	=> $pages,
				'page'	=> $page,
				'pagination'	=> $pagination
			);
		
		$this->output('main/parser', 'Parser', $outData, false );
	}

	public function parser2($page=1, $tournament=FALSE) {
	
		$this->validate();
	
		$page = (int) $page;
	
		$file = $this->session->userdata('file');
	
		//get CSV data from session
		if($file !== FALSE && $file != '') {
			$data = $this->parse_csv( APPPATH . $file);
		}
		else {
			show_error('You did not upload any hunters data yet!', 200);
		}
	
		$this->load->library('table');
	
		$max = count($data);
		$per_page = 20;	//zahardkodiramo
	
		//create pagination
		if($max > $per_page) {
				
			$func = site_url() . 'main/parser/';
				
			$pages = ceil($max / $per_page);
				
			//error handling: prevent manual access to bigger page than possible
			if($page == 0 || $page > $pages) {
				show_error('Page number is out of limits.', 405);
			}
				
			$remainder = $max % $per_page;
				
			$all_page_data = array_chunk($data, $per_page);
	
			//extract data for current page only
			$page_data = $all_page_data[$page-1];
				
			$pagination = '<div class="pagination pagination-centered">'."\n";
			$pagination .= '<ul>'."\n";
				
			//'.$previous.'
			if($page == 1) $pagination .= '<li class="disabled"><a href="#">Previous</a></li>'."\n";
			else $pagination .= '<li><a href="'.$func.($page-1).'">Previous</a></li>'."\n";
				
			for($i=1; $i<$pages+1; $i++) {
					
				if($i == $page) $pagination .= '<li class="active"><a href="#">'.$i.'</a></li>'."\n";
				else $pagination .= '<li><a href="'.$func.$i.'">'.$i.'</a></li>'."\n";
			}
				
			if($page == $pages) $pagination .= '<li class="disabled"><a href="#">Next</a></li>'."\n";
			else $pagination .= '<li><a href="'.$func.($page+1).'">Next</a></li>'."\n";
				
			$pagination .= '</ul>'."\n";
			$pagination .= '</div>'."\n";
				
		}
		else {
			$page_data = $data;
			$pages = 1;
			$pagination = '';
		}
	
	
		$tmpl = array ( 'table_open' => '<table class="table table-striped">' );
		$this->table->set_template($tmpl);
	
		//IMPORTANT! array of mice or collectibles IDs, needed for ajax
		$cellKeys = array(0 => '');
	
		$heading = array('Name');
		//$customer = $this->customers[$this->customer];
	
		//if we're parsing crowns, let's fill the heading
		if(in_array('crowns', $this->session->userdata('actions'))) {
				
			$crowns = $this->session->userdata('crowns');
				
			//we have IDs but we want mice names
			foreach($crowns as $key) {
				$cellKeys[] = $this->mice[$key];
				$heading[] = '<img src="'.images_url().'mice/'. $key.'.gif" alt="'.$this->mice[$key].'" title="'.$this->mice[$key].'" width="50px" height="50px" />';
			}
		}
	
		//if we're parsing collectibles, let's fill the heading
		if(in_array('collectibles', $this->session->userdata('actions'))) {
				
			$collectibles = $this->session->userdata('collectibles');
				
			//we have IDs but we want mice names
			foreach($collectibles as $key) {
				$cellKeys[] = $this->collectibles[$key];
				$heading[] = '<img src="'.images_url().'collectibles/'. $key.'.jpg" alt="'.$this->collectibles[$key].'" title="'.$this->collectibles[$key].'" width="50px" height="50px" />';
			}
		}
	
		$this->table->set_heading($heading);
	
		//get saved data for current customer
		$saved_data = ($this->customer != 'test') ? $this->mh_db->get_customer_data($this->customer) : array();
	
		$snuids = array();
	
		//collect data only for current page
		foreach($page_data as $hunter) {
				
			$snuids[] = $snuid = $hunter['snuid'];
				
			$row = array();
			//add rows
			for($i=0; $i<count($heading); $i++) {
	
				$mouseId = array_search($cellKeys[$i], $this->mice);
				$itemId = array_search($cellKeys[$i], $this->collectibles);
	
				//we might have mice or collectibles in the header, we have to choose proper ID string
				$cellId = ($mouseId === false) ? $itemId : $mouseId;
	
				if($i==0) {
					$row[] = (
							array(
									'data' => anchor($hunter['link'], $hunter['name'], array('target' => 'blank', 'title' => 'open hunter link in new window')),
									'id' => 'row_'.$hunter['snuid'].'_hunter'
							));
				}
				else {
					$value = 0;
						
					if($cellId === false) $cellId = '';	//error handling
						
					if($snuid === FALSE) continue;
						
					//find saved data if exists and grab the value from respective array
					if( array_key_exists($snuid, $saved_data) ) {
	
						if( array_key_exists($cellId, $saved_data[$snuid]['crowns']) ) 				$value = $saved_data[$snuid]['crowns'][$cellId];
						else if( array_key_exists($cellId, $saved_data[$snuid]['collectibles']) ) 	$value = $saved_data[$snuid]['collectibles'][$cellId];
					}
						
					$row[] = array('data' => $value, 'id' => 'row-'.$hunter['snuid'].'-'.$cellId);
				}
			}
				
			$this->table->add_row($row);
		}
	
		$table = $this->table->generate();
	
		$outData = array(
				'table' => $table,
				'snuids'=> implode(',', $snuids),
				'pages'	=> $pages,
				'page'	=> $page,
				'pagination'	=> $pagination
		);
		
		//$this->js_include('parser2');
	
		$this->output('main/parser2', 'Parser FTC', $outData, false );
	}
	
	
	//parser za giveaway
	public function parser_giveaway() {
	
		$this->validate();
	
		$comp = $this->mh_db->get_tournament('giveaway');
			
		$crowns = explode(',', 'acolyte,chrono,reaper,lycan,vampire,treasurer,snooty,high_roller,mobster,leprechaun');
	
		$data = $this->parse_csv( data_url() . $comp['comp_file']);
		
		$this->load->library('table');
	
		$page_data = $data;
		$pages = 1;
		$pagination = '';
	
		$tmpl = array ( 'table_open' => '<table class="table table-striped">' );
		$this->table->set_template($tmpl);
	
		$cellKeys = array(0 => '');
	
		$heading = array('Name');
	
		//we have IDs but we want mice names
		foreach($crowns as $key) {
			$cellKeys[] = $this->mice[$key];
			$heading[] = '<img src="'.images_url().'mice/'. $key.'.gif" alt="'.$this->mice[$key].'" title="'.$this->mice[$key].'" width="50px" height="50px" />';
		}
	
		$this->table->set_heading($heading);
	
		//get saved data for current customer
		$saved_data = $this->mh_db->get_giveaway_data();
		
		$snuids = array();
		
		//BAD PRACTICE !!! povozimo session
		$this->session->set_userdata('crowns', $crowns);
		$this->session->set_userdata('actions', array('crowns'));
		$this->session->set_userdata('collectibles', array());
		
		//if(logged_in()) dump2($saved_data);
		
		//collect data only for current page
		foreach($page_data as $hunter) {
	
			$snuids[] = $snuid = $hunter['snuid'];
	
			//add rows
			$row = array();
			for($i=0; $i<count($heading); $i++) {
	
				$cellId = array_search($cellKeys[$i], $this->mice);
	
				if($i==0) {
					$row[] = (
							array(
									'data' => anchor($hunter['link'], $hunter['name'], array('target' => 'blank', 'title' => 'open hunter link in new window')),
									'id' => 'row_'.$hunter['snuid'].'_hunter'
							));
				}
				else {
					$value = 0;
	
					if($cellId === false) $cellId = '';	//error handling
	
					if($snuid === FALSE) continue;
					
					$snuid = trim($snuid);
	
					//find saved data if exists and grab the value from respective array
					if( array_key_exists($snuid, $saved_data) ) {
						if( array_key_exists($cellId, $saved_data[$snuid]['crowns']) ) 				$value = $saved_data[$snuid]['crowns'][$cellId];
					}
	
					$row[] = array('data' => $value, 'id' => 'row-'.$hunter['snuid'].'-'.$cellId);
				}
			}
	
			$this->table->add_row($row);
		}
	
		$table = $this->table->generate();
	
		$outData = array(
				'table' => $table,
				'snuids'=> implode(',', $snuids),
				'pages'	=> '',
				'page'	=> 1,
				'pagination'	=> ''
		);
	
		$this->output('main/parser', 'Parser za Creepy Giveaway', $outData, false );
	}
	
	
	/**
	* Stran za prijavo v admin del
	*/
	public function login() {
	
		if($this->input->server("REQUEST_METHOD") == "POST") {
	
			$u = $this->input->post('user_name');
			$p = $this->input->post('user_pass');
			
			//hardkodiramo podatke
			$admins = array(
					'test'		=> 'test'
			);
			
			//temp fake user database
			$user = (array_key_exists( (string) $u, $admins) && in_array( (string) $p, $admins)) ? TRUE : FALSE;
			
			if($user) {
				$status = $this->load_user($u);
				if($status) redirect('main/parser');
				else $this->output('main/login', lang('admin_login'), array('error' => 'Could not load customer information.'));
			}
			else {
				$this->output('main/login', lang('admin_login'), array('error' => lang('wrong_credentials')));
			}
		}
		else {
			$this->output('main/login', lang('admin_login'));
	
		}
	}
	
	/**
	 * Odjava iz admin dela
	 */
	public function logout() {
	
		$this->session->set_userdata('logged_in', FALSE);
		$this->session->destroy();
		redirect('main/index');
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
	private function output($pageName, $pageTitle='B.A.M.A. MH Parser', $data=array(), $include_menu=true) {
	
		$data['title'] = $pageTitle;
	
		//nafilamo podatke za globalni meni. Ce imamo breadcrumbe, jih prikazemo (po levelih)
		$menuData = array(
				'title' 		=> $pageTitle,
				'user_group'	=> '',
				'page'			=> $pageName,
				'breadcrumbs' 	=> (isset($data['breadcrumbs'])) ? $data['breadcrumbs'] : 0
		);
	
		$this->load->view('template/header', array('title' => $pageTitle) );
		if($include_menu) $this->load->view('template/menu', $menuData );
		$this->load->view($pageName, $data);
		$this->load->view('template/footer', array('page' => $pageName) );
	}

	/**
	 * Load user information into session 
	 */
	private function load_user($name) {
		
		$customer = $this->mh_db->get_customer($name);
		
		if($customer !== FALSE) {
			$this->session->set_userdata('logged_in', TRUE);
			$this->session->set_userdata('user', $name);
			$this->session->set_userdata('description', $customer['name']);
			$this->session->set_userdata('crowns', $customer['crowns']);
			$this->session->set_userdata('actions', $customer['actions']);
			$this->session->set_userdata('collectibles', $customer['collectibles']);
			$this->session->set_userdata('file', $customer['file']);
			
			return TRUE;
		}
		else return FALSE;
		
	}

	private function set_mice_array() {
		
		if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/bama_mice.php')) {
		    include(APPPATH.'config/'.ENVIRONMENT.'/bama_mice.php');
		}
		elseif (file_exists(APPPATH.'config/bama_mice.php')) {
			include(APPPATH.'config/bama_mice.php');
		}

		//put into global
		$this->mice = (isset($mice) AND is_array($mice)) ? $mice : array();
	}

	private function set_collectibles_array() {
	
		if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/bama_collectibles.php')) {
			include(APPPATH.'config/'.ENVIRONMENT.'/bama_collectibles.php');
		}
		elseif (file_exists(APPPATH.'config/bama_collectibles.php')) {
			include(APPPATH.'config/bama_collectibles.php');
		}
	
		//put into global
		$this->collectibles = (isset($collectibles) AND is_array($collectibles)) ? $collectibles : array();
	}
	
	private function parse_csv($file) {
	
		//return $this->temp_parse();
		
		//http://php.net/manual/en/function.fgetcsv.php
		$row = 1; $return = array();
		if (($handle = fopen($file, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if(isset($data[0]) && isset($data[1])) 
					$return[] = array( 'name' => $data[0], 'link' => $data[1], 'snuid' => substr($data[1], strpos($data[1], '=')+1) );
				
				$row++;
			}
			fclose($handle);
		}
		return $return;
	}
	
	private function temp_parse($str='') {
		$arr = explode('|', $str);
		$return = array();
		foreach($arr as $hunter) {
			$data = explode(',',$hunter);
			$return[] = array( 'name' => $data[0], 'link' => $data[1], 'snuid' => substr($data[1], strpos($data[1], '=')+1) );
		}
		
		return $return;
	}
	
	private function validate() {
		$logged_in = $this->session->userdata('logged_in');
		if($logged_in !== true) {
			redirect('main/login');
		} 
	}
	
	private function check_location() {
		
		$this->load->library('ip2location_lite');
		$loc = $this->ip2location_lite->getCountry();
		
		if (!empty($loc) && is_array($loc)) {
			if(isset($loc['countryCode']) && isset($loc['countryName']) ) {
				log_message('ERROR', 'Code: '.$loc['countryCode'] .' | Country: '.$loc['countryName']);
			}
		}
	}
	
	/**
	 * Ease the way javascript files are included
	 */
	private function js_include() {
	
		$jsfiles = func_get_args();
	
		if(count($jsfiles) > 0) {
			foreach($jsfiles as $filename) {
				$filepath = js_url() . $filename. ".js";
	
				//if(file_exists($filepath)) {
					
				//js file must not be cached for development
				$suffix = (ENVIRONMENT == 'development') ? '?'. time() : '?'. SOFT_VER;
					
				$this->jquery_ext->add_library($filepath . $suffix);
				//}
			}
		}
	}
	
	//#####################################################
	//################## LG ###############################
	//#####################################################
	
	public function lgmaps() {
		
		redirect('maps');
		
		$output = array(); $data = array(); $miceCount = 0;
		
		//POST mice
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			//load config file
			if (file_exists(APPPATH.'config/bama_lgmaps.php')) {
				include(APPPATH.'config/bama_lgmaps.php');
				
				$post = $this->input->post();
				
				if(isset($post['data'])) {
					
					$mapMice = explode(PHP_EOL, $post['data']);
					if(count($mapMice) > 0) {
						foreach($mapMice as &$mouse) {
							if(strlen($mouse) > 0) {
								
								foreach($lgmice as $area => $miceArr) {
								
									if(in_array($mouse, $miceArr)) {

										$data[$area][] = $mouse;
										$miceCount++;
										break;
									}
								}
							}
						}
					}
					
					$normal = array(); $twisted = array();
					
					if(isset($data['Living Garden/regular'])) $normal['Living Garden/regular'] = $data['Living Garden/regular'];
					if(isset($data['Living Garden/duskshade'])) $normal['Living Garden/duskshade'] = $data['Living Garden/duskshade'];
					if(isset($data['Lost City/dewthief'])) $normal['Lost City/dewthief'] = $data['Lost City/dewthief'];
					if(isset($data['Sand Dunes/dewthief'])) $normal['Sand Dunes/dewthief'] = $data['Sand Dunes/dewthief'];
					
					if(isset($data['Twisted Garden/duskshade'])) $twisted['Twisted Garden/duskshade'] = $data['Twisted Garden/duskshade'];
					if(isset($data['Twisted Garden/lunaria'])) $twisted['Twisted Garden/lunaria'] = $data['Twisted Garden/lunaria'];
					if(isset($data['Cursed City/graveblossom'])) $twisted['Cursed City/graveblossom'] = $data['Cursed City/graveblossom'];
					if(isset($data['Sand Crypts/graveblossom'])) $twisted['Sand Crypts/graveblossom'] = $data['Sand Crypts/graveblossom'];					
					
					$output['normal'] = $normal;
					$output['twisted'] = $twisted;
				}
			}
		}
		
		$output['count'] = $miceCount;
		
		$this->js_include('lgmaps');
		
		$this->output('common/lgmaps', 'LG Maps', $output, TRUE ); 
		
	}

	public function maps() {
		
		$output = array(); $miceCount = 0;
		
		$ouptut['map_type'] = 'maps';
		$output['title'] = 'Maps';
	
		//POST mice
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
			//load config file
			if (file_exists(APPPATH.'config/bama_lgmaps.php')) {
				
				$this->config->load('bama_lgmaps');
	
				$post = $this->input->post();
	
				if(isset($post['data'])) {
					
					$mapMice = explode(PHP_EOL, $post['data']);
					if(count($mapMice) > 0) {
						
						$this->load->model('maps_model', 'maps');
						
						$type = $this->maps->get_map_type($mapMice);
						
						log_message("ERROR", "MAP TYPE: $type");
						
						$func = "parse_".$type;
						
						// run map-specific functions
						if(method_exists($this->maps, $func)) {
							list($output, $miceCount) = $this->maps->$func($mapMice, $output);
						}
					}
					
					// save post data
// 					$this->load->model('maps_model');
// 					$this->maps_model->save_post_query($mapMice);
					
					if($miceCount == 0) $output['error_msg'] = "Ooops, we couldn't find any mouse.";
					$output['count'] = $miceCount;
				}
			}
			
			$output['special_msg'] = "<strong>NOTES:</strong> If cheese is not provided, then use any standard cheese, including SB+.<br />
				For some maps, where a mouse can be caught in multiple locations with different setups, above information is provided merely
				as a <u>guideline</u> where certain mouse <u>might</u> be caught quickest, based on HornTracker and other data.<br />
				This does not mean that particular mouse cannot be found elsewhere.";
		}
	
		$this->js_include('lgmaps');
		
		$output['supported_maps'] = array(
				'Living Garden',
				'Deep Sea Diving',
				'Rift Walkers',
				'Fungal Cavern',
				'Valour',
				'Tribal and Shelder Hunt',	
				'Acolyte'
		);
	
		$this->output('common/'.$ouptut['map_type'], $output['title'], $output, TRUE );
	}
	
	//#####################################################
	//################## SETTINGS #########################
	//#####################################################
	
	public function settings() {

		$this->validate();
		
		$this->load->model("mice", "mice_model");
// 		$mice = $this->mice_model->get_mice();
// 		dump($mice);

		$this->load->library('table');
		
		$tmpl = array ( 'table_open' => '<table class="table table-striped">' );
		$this->table->set_template($tmpl);
		
		$this->table->set_heading('ID', 'Type', 'Name', 'Thumb');
		$this->table->add_row('Fred', 'Blue', 'Small', 'Big');
		
		$table = $this->table->generate();
		
		$data = $this->execute();
		$mice = get_object_vars($data->mouse_data);
// 		dump($mice);

		foreach($mice as $key => $mouseObj) {
			$arr = array($mouseObj->id, $mouseObj->type, $mouseObj->name, $mouseObj->thumb);
			break;
		}
		
		dump($arr);

		if($mice) {
			
		}
		else {
			
		}
		
		$html = 'N/A';
// 		$this->check_location();

		
		$this->output('common/settings', 'Settings', array('table' => $table) );
	}
	
	private function execute($action='', $snuid='', $root_uri='') {
	
		$url = $root_uri . "managers/ajax/users/profiletabs.php?action=$action&snuid=$snuid";
	
		$headers = array(
		"Accept"			=> "text/html"
				);
	
		foreach($headers as $name => $content) {
			$this->curl->http_header($name, $content);
		}
	
		$this->curl->create($url);
		$raw = $this->curl->execute();
	
		$data = json_decode($raw);
		return $data;
	}
	

	//#####################################################
	//################## TREASURE MAPS ####################
	//#####################################################
	
	public function maps_old() {
		
		$output = array(); $data = array(); $miceCount = 0; $this->treasure_mice = array();
		
		//POST mice
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
			$post = $this->input->post();
			
			//load config file
			if (file_exists(APPPATH.'config/bama_treasure_map_locations.php')) {
				include(APPPATH.'config/bama_treasure_map_locations.php');
				$this->treasure_mice = $treasure_mice;
			}
			
			if(isset($post['data'])) {
				
				$mapMice = explode(PHP_EOL, $post['data']);
				
				if(count($mapMice) > 0) {
					foreach($mapMice as &$mouse) {
						
						if(strlen($mouse) > 0) {
						
							foreach($this->mice as $mouse_id => $mouse_full_name)
							{
								$mouse_name = (strlen($mouse_full_name) > 20) ? trim(substr($mouse_full_name, 0, 17)) . "..." : $mouse_full_name;
								
								if($mouse === $mouse_name)
								{
									$locations = $this->find_best_map_locations($mouse_id);
									
									$data[] = array(
										'id' 	=> $mouse_id,
										'name' 	=> $mouse_full_name,
										'loc1'	=> $locations[0],
										'loc2'	=> $locations[1],
										'loc3'	=> $locations[2]
									);
									$miceCount++;
									break;	//jump out of one foreach
								}
							}
						}
					}
				}
			}
		}

		$output['data']	 = $data;
		$output['count'] = $miceCount;
		
		$this->output('common/maps', 'MH Treasure Maps', $output, TRUE ); 
		
	}
	
	private function find_best_map_locations($mouse_id)
	{
		if(empty($this->treasure_mice)) return array('N/A', 'N/A', 'N/A');
		else
		{
			if(isset($this->treasure_mice[$mouse_id])) return $this->treasure_mice[$mouse_id];
			else return array('N/A', 'N/A', 'N/A');
		}
	}
	
	
	//#####################################################
	//################## HAUNTED ##########################
	//#####################################################	
	
	public function haunted() {
	
		$output = array(); $data = array(); $miceCount = 0;
		$output['haunted'] = array();
		$output['post'] = FALSE;
		
		//load config file
		include(APPPATH.'config/bama_haunted.php');
		
		$config_mice_names = array_keys($haunted);
		
		// new mice HT 2015
		$new = array('Dire Lycan', 'Teenage Vampire', 'Hollowed Minion', 'Maize Harvester', 'Spectral Butler', 'Gourd Ghoul', 'Gourd Ghoul', 'Bonbon Gummy Globlin');
		$rift_trap = array('Hollowed Minion');
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
				
			$post = $this->input->post();
			
			$output['post'] = TRUE;
				
			$mapMice = explode(PHP_EOL, $post['data']);
			if(count($mapMice) > 0) {
				
				foreach($mapMice as &$mouse)
				{
					if(strlen($mouse) > 0)
					{
						if(in_array($mouse, $config_mice_names)) {
							$output['haunted'][$mouse] = $haunted[$mouse];
						}
					}
				}
				
				ksort($output['haunted']);
			}
		}
		else $output['haunted'] = $haunted;
		
		$output['count'] = count($output['haunted']);
		
		$this->output('common/haunted', 'Haunted Terrortories 2015', $output, TRUE ); 
	}
	
	//#####################################################
	//################## WINTER MAPS ######################
	//#####################################################
	
	public function winter() {
	
		$output = array(); $data = array(); $miceCount = 0;
		$output['winter'] = array();
		$output['post'] = FALSE;
	
		//load config file
		include(APPPATH.'config/bama_winter.php');
	
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
			$post = $this->input->post();
				
			$output['post'] = TRUE;
	
			$mapMice = explode(PHP_EOL, $post['data']);
			if(count($mapMice) > 0) {
	
				foreach($mapMice as &$mouse)
				{
					if(strlen($mouse) > 0)
					{
						foreach($winter as $mouse_key => $mouse_data)
						{
							$temp_db = $mouse_key . ' Mouse';
							if( ($temp_db === $mouse || $temp_db === $mouse . ' Mouse') && array_key_exists($mouse_key, $output['winter']) === FALSE)
							{
								$output['winter'][$mouse_key] = $mouse_data;
								break;
							}
						}
					}
				}
	
				ksort($output['winter']);
			}
		}
		else $output['winter'] = $winter;
	
		$output['count'] = count($output['winter']);
	
		$this->output('common/winter', 'Great Winter Hunt 2014', $output, TRUE );
	}
	
	
	//#####################################################
	//################## COMPS ############################
	//#####################################################
	
	public function ship() {

		$this->js_include('general');
		
		$this->hunters = $this->parse_csv( data_url() . 'comp.csv');
		
		$this->load->library('table');
		
		$tmpl = array ( 'table_open' => '<table class="table table-striped">' );
		$this->table->set_template($tmpl);
		
		//IMPORTANT! array of mice or collectibles IDs, needed for ajax
		$cellKeys = array(0 => '');
		
		$heading = array('Name');
		
		$crowns = explode(',', 'briegull,shelder,bottled,buccaneer,captain,cook,hydra,leviathan,mermaid,pinchy,pirate,salt_water_snapper,shipwrecked,siren,squeaken,swabbie,water_nymph');
			
		//we have IDs but we want mice names
		foreach($crowns as $key) {
			$cellKeys[] = $this->mice[$key];
			$heading[] = '<img src="'.images_url().'mice/'. $key.'.gif" alt="'.$this->mice[$key].'" title="'.$this->mice[$key].'" width="50px" height="50px" />';
		}
		
		$this->table->set_heading($heading);
		
		$saved_data = $this->mh_db->get_data_for_ship('bama');
		
		foreach($saved_data as $snuid => $data) {
			
			$hunter = $this->get_hunter($snuid);
				
			$row = array();
			//add rows
			for($i=0; $i<count($heading); $i++) {
		
				//cellId == mouseId
				$cellId = array_search($cellKeys[$i], $this->mice);
		
				if($i==0) {
					$row[] = (
							array(
									'data' => anchor($hunter['link'], $hunter['name'], array('target' => 'blank', 'title' => 'open hunter link in new window', 'class' => 'popup', 'data-id' => $snuid)),
									'id' => 'row_'.$hunter['snuid'].'_hunter'
							));
				}
				else {
					$value = 0;
						
					if($cellId === false) $cellId = '';	//error handling
					
					if($snuid === FALSE) $snuid = 'NA';	//error handling
						
					//find saved data if exists and grab the value from respective array
					if( array_key_exists($snuid, $saved_data) ) {
		
						if( array_key_exists($cellId, $saved_data[$snuid]['crowns']) ) $value = $saved_data[$snuid]['crowns'][$cellId];
					}
						
					$row[] = array('data' => $value, 'id' => 'row-'.$hunter['snuid'].'-'.$cellId);
				}
			}
				
			$this->table->add_row($row);
		}
		
		$table = $this->table->generate();
		
		$this->output('common/ship', 'Memorandum za Aldu', array('table' => $table), false );
	}
		
	public function giveaway() {
	
		//comp_id, comp_name, comp_file, comp_desc, comp_owner
		$comp = $this->mh_db->get_tournament('giveaway');
		
		$saved_data = $this->mh_db->get_data_for_giveaway();
		
		$this->hunters = $this->parse_csv( data_url() . $comp['comp_file']);
		
		$this->load->library('table');
	
		$tmpl = array ( 'table_open' => '<table class="table table-striped">' );
		$this->table->set_template($tmpl);
	
		$heading = array('Name');
	
		$crowns = explode(',', 'acolyte,chrono,reaper,lycan,vampire,treasurer,snooty,high_roller,mobster,leprechaun');
		
		//we have IDs but we want mice names
		foreach($crowns as $key) {
			$heading[] = '<img src="'.images_url().'mice/'. $key.'.gif" alt="'.$this->mice[$key].'" title="'.$this->mice[$key].'" width="50" height="50" />';
		}
		
		for($k=0;$k<4;$k++) {
			$heading[] = '';
		}
	
		$this->table->set_heading($heading);

		//first row is about points
		$first_row = array(
				array('data' => "Points", 'class' => 'points', 'id' => 'row_points_points'),
				array('data' => 10, 'class' => 'points', 'id' => 'acolyte'),
				array('data' => 10, 'class' => 'points', 'id' => 'chrono'),
				array('data' => 10, 'class' => 'points', 'id' => 'reaper'),
				array('data' => 10, 'class' => 'points', 'id' => 'lycan'),
				array('data' => 10, 'class' => 'points', 'id' => 'vampire'),
				array('data' => 15, 'class' => 'points', 'id' => 'treasurer'),
				array('data' => 15, 'class' => 'points', 'id' => 'snooty'),
				array('data' => 20, 'class' => 'points', 'id' => 'high_roller'),
				array('data' => 20, 'class' => 'points', 'id' => 'mobster'),
				array('data' => 20, 'class' => 'points', 'id' => 'leprechaun'),
				array('data' => "1. day", 'class' => 'points', 'id' => 'row_points_1'),
				array('data' => "2. day", 'class' => 'points', 'id' => 'row_points_2'),
				array('data' => "3. day", 'class' => 'points', 'id' => 'row_points_3'),
				array('data' => "Total", 'class' => 'points', 'id' => 'row_points_total'),
			);
		
		$this->table->add_row($first_row);
		
		$saved_data = $this->calculate_points($saved_data);
		

		foreach($saved_data as $data) {
			
			$snuid = trim($data['snuid']);
			$hunter = $this->get_hunter($snuid);
			$row = array();

			for($i=0; $i<count($heading); $i++) {
				
				switch($i) {
					case 0: //hunter name
						$row[] = array('data' => anchor($hunter['link'], $hunter['name'], array('target' => 'blank', 'title' => 'open hunter link in new window')));						
						break;
						
					case 11: //1. dan
						$row[] = array('data' => "<b>".$data['day1']."</b>");
						break;
					
					case 12: //2. dan
						$row[] = array('data' => "<b>".$data['day2']."</b>");
						break;
						
					case 13: //3. dan
						$row[] = array('data' => "<b>".$data['day3']."</b>");
						break;
					
					case 14:
						$row[] = array('data' => "<b>".$data['total']."</b>");
						break;
						
					default:
						$value = 0;
						
						$id = $first_row[$i]['id'];
						if(isset($data['mice'][$id])) {
							$value = $data['mice'][$id];
						}
						
						$row[] = array('data' => $value);						
						break;
				}
			}
	
			$this->table->add_row($row);
		}
	
		$table = $this->table->generate();
		
		/**
		 *  &#268; - C
		 * 	&#269; - c
		 * 	&#352; - S
		 * 	&#353; - s
		 * 	&#381; - Z
		 * 	&#382; - z
		 *  &#262; - meki C
		 *  &#263; - meki c
		 */
		
		/* PRED-turnirom
		$desc = 'Lovac je le&#382;ao na livadi kod Gnawnije i posmatrao no&#263;no nebo.';
		$desc .= 'Tu i tamo preletjela bi sova, no jedine &#353;umove radili su mali poljski mi&#353;evi, White, Brown, Grey... Lagano su mu se o&#269;i sklapale... ';
		$desc .= 'poink! Lovac se trgne, sredina &#269;ela &#382;arila ga je od udarca. Sjedne, pogleda lijevo-desno, nigdje nikoga. Poink! Ovaj put nastradalo je rame. ';
		$desc .= 'Ok, &#269;ija je to psina! Nebo je bilo vedro, mjesec se jasno vidio. U taj tren doleti ne&#353;to opet, ovaj put se spretno izmakne od lete&#263;eg objekta. ';
		$desc .= 'Pogleda podno nogu, sagne se i dohvati okrugli blje&#353;tavi pak, a ne, ne pak, ve&#263; King\'s Credit. I tada shvati &#353;to je bilo neobi&#269;no u toj no&#263;i ';
		$desc .= '(uz kovanice koje padaju s neba), lagano se ispod mirisa no&#263;i osjetio miris sb+, a u blizini nije bilo drugih lovaca. King&#39;s Credit s neba, ';
		$desc .= 'sb+ u zraku na Meadowu. To je moglo zna&#269;iti samo jednu stvar &#45; King&#39;s Giveaway.'."<br /><br />";
		$desc .= 'Lovac pokupi svoje zamke, sireve i naprtnja&#269;u i krene prema Gnawniji. Iznad taverne visio je znak s Akijem. Znak je bio star, ';
		$desc .= 'izrabljen i uko&#353;en, Aki je izgledao kao da &#263;e svaki tren zavr&#353;iti na podu. Iznad ulaza polu&#269;itljivo pisalo je &#44;P*jani Aco*yte&#34;. ';
		$desc .= 'Nitko ne zna je li ikada taj naziv imao sva slova. Sigurno nije otkad je on postao master Bristle Woodsa. Zakora&#269;io je u crnilo kr&#269;me...';
		*/
		
		$desc = 'Sunce je svanulo no to se nije moglo vidjeti ni osjetiti u FG-u. Iza ne-tako-pitomih grmova vrebali su horori. ';
		$desc .= 'No to se nije dalo osjetiti medju grupom lovaca. Skupina je sjedila oko vatre, &#269;ekanje na otvaranje portala kratili su lova&#269;kim pri&#269;ama, ';
		$desc .= 'a netko je donio &#269;ak i marshmouse-ove. Atmosfera je bila primjerenija ekspediciji na Otocima nego za najopasnije podru&#269;je u Kraljevstvu. ';
		$desc.= 'Minute su ih razdvajale do novog lova na najvrednije mi&#353;eve...';
		
		
		$this->js_include('general');
		
		$this->output('common/giveaway', $comp['comp_desc'], array('table' => $table, 'desc' => $desc), false );
	}

	private function calculate_points($saved_data) {
		$this->giveaway_mice = array(
				'acolyte' 		=> array('day' => 1, 'points' => 10),
				'chrono' 		=> array('day' => 1, 'points' => 10),
				'reaper' 		=> array('day' => 2, 'points' => 10),
				'lycan' 		=> array('day' => 3, 'points' => 10),
				'vampire' 		=> array('day' => 3, 'points' => 10),
				'treasurer' 	=> array('day' => 0, 'points' => 15),
				'snooty' 		=> array('day' => 0, 'points' => 15),
				'high_roller' 	=> array('day' => 0, 'points' => 20),
				'mobster' 		=> array('day' => 0, 'points' => 20),
				'leprechaun' 	=> array('day' => 0, 'points' => 20)
			);
		
		$return = array();
		
		$day = 0;
		$date = (int) date('dm');
		if($date == 2811) $day = 1;
		else if($date == 2911) $day = 2;
		else if($date == 2711) $day = 3;
		
		foreach($saved_data as &$hunter_data) {
			
			$start = json_decode($hunter_data['start'], TRUE);
			$current = json_decode($hunter_data['current'], TRUE);
			$day1 = json_decode($hunter_data['day1'], TRUE);
			
			$temp_start = array();
			$temp_curr = array();
			$temp_day1 = array();
			
			$hunter_data['mice'] = array();
			
			foreach($start['crowns'] as $mouse) $temp_start[$mouse[1]] = $mouse[2];
			unset($mouse);
			foreach($current['crowns'] as $mouse) $temp_curr[$mouse[1]] = $mouse[2];
			unset($mouse);
			foreach($day1['crowns'] as $mouse) $temp_day1[$mouse[1]] = $mouse[2];
			
			$total = 0;
			$day2 = 0;
			
			foreach($temp_curr as $mouse => $curr_catch)
			{
				$start_catch = $temp_start[$mouse];
				$hunter_data['mice'][$mouse] = $curr_catch - $start_catch;
				
				//day 2
				if($this->giveaway_mice[$mouse]['day'] == 2 || $this->giveaway_mice[$mouse]['day'] == 0)
				{
					if(isset($temp_day1[$mouse])) {
						$day1_catch = $temp_day1[$mouse];
						$day2 += ($curr_catch - $day1_catch) * $this->giveaway_mice[$mouse]['points'];
					}
				}
				
				$total += ($curr_catch - $start_catch) * $this->giveaway_mice[$mouse]['points'];
			}
			
			if(logged_in() && $hunter_data['snuid'] == '1193720569' || $hunter_data['snuid'] == 1193720569) {
				//dump2($hunter_data['start']);
			}
			
			$hunter_data['day1'] = $total;	//ZACASNO!
			$hunter_data['day2'] = $day2;
			$hunter_data['day3'] = 0;
			$hunter_data['total'] = $total;
		}
		
		return $saved_data;
		
	}
	
	private function get_hunter($snuid) {
		$snuid = (int) $snuid;
		foreach($this->hunters as $hunter) {
			$s = (int) $hunter['snuid'];
			if($s == $snuid) return $hunter;
		}
		return array();
	}
	
	
	//#####################################################
	//################ LUCIA ##############################
	//#####################################################
	
	public function ar() {
		
		//get CSV data from session
		$data = $this->parse_csv2( APPPATH . 'lucia.csv');
		//dump($data);
		
		$this->load->library('table');

		$pages = 1;
		$pagination = '';
		
		$tmpl = array ( 'table_open' => '<table class="table table-striped">' );
		$this->table->set_template($tmpl);
		
		//IMPORTANT! array of mice or collectibles IDs, needed for ajax
		$cellKeys = array(0 => '');
		$heading = array('Name');
		$crowns = array('chrono', 'acolyte', 'lich', 'POINTS');
		
		//we have IDs but we want mice names
		foreach($crowns as $key) {
			$cellKeys[] = $this->mice[$key];
			$heading[] = '<img src="'.images_url().'mice/'. $key.'.gif" alt="'.$this->mice[$key].'" title="'.$this->mice[$key].'" width="50px" height="50px" />';
		}

		$this->table->set_heading($heading);
		
		//get saved data for current customer
		$saved_data = $this->mh_db->get_customer_data('lucia');
		$saved_data = array();
		
		$snuids = array();
		
		//collect data only for current page 
		foreach($data as $hunter) {
			
			$snuids[] = $snuid = $hunter['snuid'];
			
			$row = array();
			//add rows
			for($i=0; $i<count($heading); $i++) {

				$mouseId = array_search($cellKeys[$i], $this->mice);
				$itemId = array_search($cellKeys[$i], $this->collectibles);
				
				//we might have mice or collectibles in the header, we have to choose proper ID string
				$cellId = ($mouseId === false) ? $itemId : $mouseId;
				
				if($i==0) {
					$row[] = (
							array(
									'data' => anchor($hunter['link'], $hunter['name'], array('target' => 'blank', 'title' => 'open hunter link in new window')),
									'id' => 'row_'.$hunter['snuid'].'_hunter'
							));
				}
				else {
					$value = 0;

					if($cellId === false) $cellId = '';	//error handling
					
					//find saved data if exists and grab the value from respective array
					if( array_key_exists($snuid, $saved_data) ) {
						
						$debug = 0;
						
						$sad = $saved_data[$snuid]['crowns'];
						
						$aki_sad = explode('/', $sad['acolyte']);
						$chrono_sad = explode('/', $sad['chrono']);
						$lich_sad = explode('/', $sad['lich']);
						
						//chrono
						if($i == 1) {
							$catches = trim($chrono_sad[0]);
							$misses = trim($chrono_sad[1]);
							$value = "$catches / $misses";
						}
						//aki
						else if($i == 2) {
							$catches = trim($aki_sad[0]);
							$misses = trim($aki_sad[1]);
							$value = "$catches / $misses";
						}
						//lich
						else if($i == 3) {
							$catches = trim($lich_sad[0]);
							$misses = trim($lich_sad[1]);
							$value = "$catches / $misses";
						}
						else if($i == 4) {
							$aki_points = ( (int) trim($aki_sad[0]) )*15 - ( (int) trim($aki_sad[1]) )*10;
							if($debug == 1) echo "AKI: $aki_points".BR;
							
							$chrono_points = ( (int) trim($chrono_sad[0]) )*30 - ( (int) trim($chrono_sad[1]) )*25;
							if($debug == 1) echo "CHRONO: $chrono_points".BR;
							
							$lich_points = ( (int) trim($lich_sad[0]) )*5;
							if($debug == 1) echo "LICH: $lich_points".BR;
							
							$value = $aki_points + $chrono_points + $lich_points;
							if($debug == 1) echo "TOTAL: $points".BR;
						}
						
						/*
						if( array_key_exists($snuid, $saved_data) ) {
							if( array_key_exists($cellId, $saved_data[$snuid]['crowns']) ) 				$value = $saved_data[$snuid]['crowns'][$cellId];
						}
						*/
					}
					
					$row[] = array('data' => $value, 'id' => 'row-'.$hunter['snuid'].'-'.$cellId);
				}
			}
			
			$this->table->add_row($row);
		}
		
		$table = $this->table->generate();
		
		$outData = array(
				'table' => $table, 
				'snuids'=> implode(',', $snuids),
				'pages'	=> $pages,
				'page'	=> 1,
				'pagination'	=> $pagination
			);
		
		$this->output('common/ar', NULL, $outData, false );
	}
		
	private function parse_csv2($file) {
	
		//http://php.net/manual/en/function.fgetcsv.php
		$row = 1; $return = array();
		if (($handle = fopen($file, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$return[] = array( 
						'name' => $data[0], 
						'link' => $data[1], 
						'snuid' => substr($data[1], strpos($data[1], '=')+1),
						'chrono_catch' 	=> $data[2],
						'chrono_miss'	=> $data[3],
						'acolyte_catch'	=> $data[4],
						'acolyte_miss'	=> $data[5],
						'lich_catch'	=> $data[6],
						'lich_miss'		=> $data[7]
				);
				$row++;
			}
			fclose($handle);
		}
		return $return;
	}
	
	
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
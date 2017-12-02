<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ajax extends CI_Controller {

	private $customer = '';
	private $customerData = array();
	
	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'general') );
		$this->load->library( array('curl', 'session') );

		$this->user = $this->customer = $this->session->userdata('user');
		$this->crowns = $this->session->userdata('crowns');
		$this->actions = $this->session->userdata('actions');
		$this->collectibles = $this->session->userdata('collectibles');
		//$this->customerData = $this->init();
	}
	
	public function get_data($snuids, $start=FALSE) {
		
		//decode urlencoded string of concatenated snuIDs
		$snuidArr = explode(',', urldecode($snuids));
		
		$data = array(); $i = 0;
		foreach($snuidArr as $snuid) {
			
			//parser only if customer wants it
			$crowns = (in_array('crowns', $this->actions)) ? $this->get_crowns($snuid) : array();
			$items = (in_array('collectibles', $this->actions)) ? $this->get_collectibles($snuid): array();
				
			$data[] = array('snuid' => $snuid, 'crowns' => $crowns, 'items' => $items);
			$i++;
		}
	
		header('Content-Type: application/json charset=utf-8');
		echo json_encode( array('status' => 'ok', 'data' => $data) );
		
		if($this->user != 'test') {
			//after output has been sent, lets save data to database:
			$this->load->model('mh_db');
			
			//overloadali bomo tole funkcijo
			$this->mh_db->save_data($data, $this->user, $start);
			
			//after day1:
			//$this->mh_db->save_giveaway($data, trim($this->user), 'current');
			
			//total se vedno shranjuje
			//$this->mh_db->save_giveaway($data, trim($this->user), 'total');
		}
		
	}
	
	public function get_start_data($snuids) {
		$this->get_data($snuids, TRUE);
	}
	
	public function get_collectibles($snuid, $all=false) {
		
		$data = $this->execute('items', $snuid);
		$items_data = $data->items;
				
		$items = get_object_vars($items_data);
		
		$return = array();
		foreach ($items as $key => $itemsArr) {
			
			//weapons, bases, maps, collectibles, skins
			foreach ($itemsArr as $itemObj) {
				
				//we dont want those that are not yet obtained by the hunter
				//if($itemObj->quantity === 0 || $itemObj->quantity === '0') continue;
				
				if($all || in_array($itemObj->type, $this->collectibles)) {
					
					$return[$key][] = array(
							'name'	=> $itemObj->name,
							'type'	=> $itemObj->type,
							'thumb'	=> $itemObj->thumb,
							'quantity'	=> $itemObj->quantity,
							'limited'	=> $itemObj->limited
					);
				}
			}
			
		}
		
		return $return;
	}
	
	public function get_crowns($snuid, $all=false) {
		
		$data = $this->execute('badges', $snuid);
		
		$mice = get_object_vars($data->mouse_data);

		$return = array();
		foreach($mice as $key => $mouseObj) {
			$hunters_mice[$mouseObj->name] = $mouseObj->num_catches;
			if($all || in_array($mouseObj->type, $this->crowns)) {
				$return[] = array($mouseObj->name, $mouseObj->type, $mouseObj->num_catches);
			}
		}
		
		return $return;
	}
	
	public function get_catches($str) {
		$startsAt = strpos($str, "(") + strlen("(");
		$endsAt = strpos($str, ")", $startsAt);
		return substr($str, $startsAt, $endsAt - $startsAt);
	}
	
	private function execute($action, $snuid, $root_uri = '') {

		$url = $root_uri . "/managers/ajax/users/profiletabs.php?action=$action&snuid=$snuid";
				
		$headers = array(
				"Accept"			=> "text/html"
		);
		
		foreach($headers as $name => $content) {
			$this->curl->http_header($name, $content);
		}
		
		if($this->user == 'lucia') {
			$a = $this->curl->ssl(TRUE, 2, data_url() . "cacert.pem");
		}
		
		$this->curl->create($url);
		$raw = $this->curl->execute();
		
//		$this->curl->debug();
		
		$data = json_decode($raw);	//user, messageData, badges, favorites, mouse_data, remaining_mice, is_viewing_user, success
		return $data;
	}
	
	private function points($snuid) {
		
		$debug = 0;
		
		//komaj zaceli
		if(count($this->saved_data) == 0) return 0;
		
		$snuid = (string) $snuid;
		foreach($this->start_data as $key => $hunter) {
			if($hunter['snuid'] == $snuid) break;
		}
		
		$start = $this->start_data[$key];
		$sad = $this->saved_data[$snuid];
		
		$aki_sad = explode('/', $sad['crowns']['acolyte']);
		$chrono_sad = explode('/', $sad['crowns']['chrono']);
		$lich_sad = explode('/', $sad['crowns']['lich']);
		
		/*
		 if($debug == 1) {
		echo "<pre>"; print_r($aki_sad[0]); echo "</pre>";
		echo "<pre>"; print_r($start['acolyte_catch']); echo "</pre>";
		
		echo "<pre>"; print_r($aki_sad[1]); echo "</pre>";
		echo "<pre>"; print_r($start['acolyte_miss']); echo "</pre>";
		}
		*/
		
		//$aki_points = ( ( (int) trim($aki_sad[0]) ) - ( (int) trim($start['acolyte_catch']) ) )*15 - ( ( (int) trim($aki_sad[1]) ) - ( (int) trim($start['acolyte_miss']) ) )*10;
		$aki_points = ( (int) trim($aki_sad[0]) )*15 - ( (int) trim($aki_sad[1]) )*10;
		if($debug == 1) echo "AKI: $aki_points".BR;
		
		//$chrono_points = ( ( (int) trim($chrono_sad[0]) ) - ( (int) trim($start['chrono_catch']) ) )*30 - ( ( (int) trim($chrono_sad[1]) ) - ( (int) trim($start['chrono_miss']) ) )*25;
		$chrono_points = ( (int) trim($chrono_sad[0]) )*30 - ( (int) trim($chrono_sad[1]) )*25;
		if($debug == 1) echo "CHRONO: $chrono_points".BR;
		
		//$lich_points = ( ( (int) trim($lich_sad[0]) ) - ( (int) trim($start['lich_catch']) ) )*5;
		$lich_points = ( (int) trim($lich_sad[0]) )*5;
		if($debug == 1) echo "LICH: $lich_points".BR;
		
		$points = $aki_points + $chrono_points + $lich_points;
		if($debug == 1) echo "TOTAL: $points".BR;
		
		return $points;
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

	//DEPRECATED
	private function init() {
		
		//tournament_badge_challenger_collectible, tournament_badge_competitor_collectible, tournament_badge_participant_collectible
		$data = array(
				
			'bama' => array(
					'collectibles' => array(),
					'crowns'	=> array(),
					'actions'	=> array('collectibles', 'crowns')
					),
			'mhcc' => array(
					'collectibles' => array(),
					'crowns'	=> array(),
					'actions'	=> array('collectibles', 'crowns')
					),
			'vermin' => array(
					'collectibles' 	=> array('tournament_trophy_gold_collectible', 'tournament_trophy_silver_collectible', 'tournament_trophy_bronze_collectible'),
					'crowns'		=> array('eclipse', 'desert_boss', 'chess_master', 'balack_the_banished', 'dragon', 'acolyte', 'dojo_sensei', 'silth', 'library_boss'),
					'actions'	=> array('crowns', 'collectibles')
					)
		);

		return $data[$this->customer];
	}
	
	
	public function teams($uri='', $id='') {
		
		$url = $uri . "?team_id=" . $id;
		
		$headers = array(
				"Accept" => "text/html"
		);
		
		foreach($headers as $name => $content) {
			$this->curl->http_header($name, $content);
		}
		
		$this->curl->ssl(TRUE, 2, data_url() . "cacert.pem");
		
		
		
		$this->curl->create($url);
		$raw = $this->curl->execute();
		
		$data = json_encode($raw);
		
		header('Content-Type: application/json charset=utf-8');
		echo $data;
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mh_db extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

	/*
	GET ALL ADMINS:
		SELECT hunters.hunter_name FROM hunters,team_hunters WHERE team_hunters.is_admin=1 AND hunters.snuid = team_hunters.hunter_id
	*/
    public function __construct() {
        parent::__construct();
		$this->load->database();
		//$this->load->helper( array('url', 'general', 'language') );
    }
    
    
    // #######################################
    // ############ GETTERS ##################
    // #######################################
	
	public function get_customer($id) {
		
		$query = $this->db->query("SELECT * FROM customers WHERE customer_id='$id'");
		
		if ($query->num_rows() == 1) {

			$result = $query->result_array();
			
			$return = array(
					'id'			=> $result[0]['customer_id'],
					'name'			=> $result[0]['customer_name'],
					'crowns'		=> explode(',', $result[0]['crowns']),
					'actions'		=> explode(',', $result[0]['actions']),
					'collectibles'	=> explode(',', $result[0]['collectibles']),
					'file'			=> $result[0]['filename']
				);
			
			return $return;
		}
		else return false;
	}
	
	public function get_customer_data($customer) {
		
		$return = array();
		$query = $this->db->query("SELECT json FROM data WHERE snuid_customer LIKE '%$customer'");
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			
			//echo "<pre>"; print_r($result); echo "</pre>"; die();
			
			foreach($result as $row) {
				$object = json_decode($row['json']);
				$snuid = (isset($object->snuid)) ? $object->snuid : 0;
				unset($object->snuid);
				
				$crowns = array();
				$collectibles = array();
				
				//error handling
				if(!is_object($object)) {
					$return[$snuid] = array('crowns' => $crowns, 'collectibles' => $collectibles);
					continue;
				}
				
				if(count($object->crowns) > 0) {
					foreach($object->crowns as $row2) {
						$mouseId = $row2[1];
						$crowns[$mouseId] = $row2[2];
					}
				}
				
				if(!empty($object->items)) {
					foreach($object->items->collectibles as $row3) {
						$itemId = $row3->type;
						$collectibles[$itemId] = $row3->quantity;
					}
				}
				
				$return[$snuid] = array('crowns' => $crowns, 'collectibles' => $collectibles);
			}
		}
		
		return $return;
	}
	
	public function get_customer_start_data($customer) {
	
		$return = array();
		$query = $this->db->query("SELECT json_start FROM data WHERE snuid_customer LIKE '%$customer'");
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
				
			//echo "<pre>"; print_r($result); echo "</pre>"; die();
				
			foreach($result as $row) {
				$object = json_decode($row['json_start']);
				$snuid = (isset($object->snuid)) ? $object->snuid : 0;
				unset($object->snuid);
	
				$crowns = array();
				$collectibles = array();
	
				//error handling
				if(!is_object($object)) {
					$return[$snuid] = array('crowns' => $crowns, 'collectibles' => $collectibles);
					continue;
				}
	
				if(count($object->crowns) > 0) {
					foreach($object->crowns as $row2) {
						$mouseId = $row2[1];
						$crowns[$mouseId] = $row2[2];
					}
				}
	
				if(!empty($object->items)) {
					foreach($object->items->collectibles as $row3) {
						$itemId = $row3->type;
						$collectibles[$itemId] = $row3->quantity;
					}
				}
	
				$return[$snuid] = array('crowns' => $crowns, 'collectibles' => $collectibles);
			}
		}
	
		return $return;
	}
	
	public function get_data_for_ship($customer) {
		
		$saved_data = $this->get_customer_data($customer);
		$start_data = $this->get_customer_start_data($customer);
		
		$all_snuids = array_keys($saved_data);
		$return = array();
		$brieguls = array();
		$now = array();
		
		foreach($saved_data as $key => $hunter)
		{
			if(isset($hunter['crowns']['briegull']) && isset($start_data[$key]['crowns']['briegull']) )
			{
				//kljuc po katerem bomo sortirali
				$brieguls[] = ( (int) $hunter['crowns']['briegull'] ) - ( (int) $start_data[$key]['crowns']['briegull'] );
					
				foreach($hunter['crowns'] as $mouse => $catches) {
					//sorting razfuka ce imamo integer kljuc, zato dodamo 'a'
					$now['a'.$key][$mouse] = $catches - $start_data[$key]['crowns'][$mouse];
				}
			}
		}
		
		array_multisort($brieguls, $now);
		$now = array_reverse($now);
		
		//odstranimo a-je
		foreach($now as $fake_key => $arr) {
			$real = substr($fake_key, 1);
			$return[$real] = array('crowns' => $arr, 'collectibles' => array() );
		}
		
		return $return;
	}
	
	public function get_giveaway_data() {
		
		$return = array();
		$query = $this->db->query("SELECT current FROM giveaway");
		
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			
			foreach($result as $row) {
				
				$str = str_replace(PHP_EOL, '', $row['current']);
				
				$object = json_decode($str);
				
				$snuid = (isset($object->snuid)) ? $object->snuid : 0;
				unset($object->snuid);
				
				$crowns = array();
				$collectibles = array();
				
				//error handling
				if(!is_object($object)) {
					$return[$snuid] = array('crowns' => $crowns, 'collectibles' => $collectibles);
					continue;
				}
				
				if(count($object->crowns) > 0) {
					foreach($object->crowns as $row2) {
						$mouseId = $row2[1];
						$crowns[$mouseId] = $row2[2];
					}
				}
				
				if(!empty($object->items)) {
					foreach($object->items->collectibles as $row3) {
						$itemId = $row3->type;
						$collectibles[$itemId] = $row3->quantity;
					}
				}
				
				$snuid = trim($snuid);
				
				$return[$snuid] = array('crowns' => $crowns, 'collectibles' => $collectibles);
			}
		}
		
		return $return;
	}
	
	public function get_data_for_giveaway() {
	
		$query = $this->db->query("SELECT * FROM giveaway");
		
		$result = $query->result_array();
	
		return $result;
	}
	
	public function get_tournament($comp_name)
	{
		$query = $this->db->query("SELECT * FROM comps WHERE comp_name='$comp_name'");
		
		if ($query->num_rows() == 1) {
			$result = $query->result_array();
			return $result[0];
		}
		else return false;
	}
	
	// #######################################
	// ############ SETTERS ##################
	// #######################################	
	
	public function save_filename($name='', $id='') {
	
		$str = $this->db->update_string('customers', array('filename' => $name), "customer_id = '$id'");
	
		$status = $this->db->query($str);
	
		return ($status) ? TRUE : FALSE;
	}
	
	public function save_data($data, $customer, $start=FALSE) {
	
		foreach($data as $hunter) {
				
			$id = $hunter['snuid'] .'_'. $customer;
			$json = json_encode($hunter);
				
			//do we have start of the tourney?
			$field = ($start === TRUE) ? 'json_start' : 'json';
			
			$json = mysqli_real_escape_string($this->db->conn_id, $json);
	
			//save whole JSONs to database
			$query = $this->db->query("INSERT INTO data (snuid_customer, $field) VALUES ('$id', '$json') ON DUPLICATE KEY UPDATE $field='$json'");
				
		}
	}
	
	public function save_comp_data($data, $customer, $start=FALSE, $comp_id=FALSE) {
	
		if(!is_array($data) || $comp === FALSE) return FALSE;
	
		foreach($data as $hunter) {
	
			$id = $hunter['snuid'] .'_'. $customer .'_'. $comp_id;
			$json = json_encode($hunter);
	
			//do we have start of the tourney?
			$field = ($start === TRUE) ? 'json_start' : 'json';
	
			//save whole JSONs to database
			$query = $this->db->query("INSERT INTO data (snuid_customer, comp_id, $field) VALUES ('$id', '$comp_id', '$json') ON DUPLICATE KEY UPDATE $field='$json'");
	
		}
	
		return TRUE;
	}

	public function save_giveaway($data, $customer, $column) {
		
		foreach($data as $hunter) {
		
			$snuid = (int) $hunter['snuid'];
			$json = json_encode($hunter);
			
			//$str = $this->db->update_string('giveaway', array($column => $json), "snuid = '$snuid'");
			//$status = $this->db->query($str);
			//log_message('ERROR', "STATUS: ".$this->db->last_query());
		
			//save whole JSONs to database
			$query = $this->db->query("INSERT INTO giveaway (snuid,$column) VALUES ('$snuid','$json') ON DUPLICATE KEY UPDATE $column='$json'");
			
			
		}
		
	}
	
}

?>
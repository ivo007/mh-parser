<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maps_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        log_message("debug", "Maps Model Initialized");
    }
    
    public function get_map_type($mapMice = array()) {
    
    	$maps = $this->config->item('treasure_maps');
    
    	foreach($mapMice as &$mouse) {
    		
    		// make sure the name is in Camel Case
    		$mouse = ucwords(strtolower($mouse));
    		
    		if(strlen($mouse) > 0) {
    			foreach($maps as $area => $miceArr) {
					
					$search_array = array_map('strtolower', $miceArr);
					
    				if(in_array(strtolower($mouse), $search_array)) {
    					return $area;
    				}
    			}
    		}
    	}
    
    	return false;
    }
	
    public function parse_lg($mapMice = array(), $output = array()) {
    
    	list($data, $miceCount) = $this->filter_mice($mapMice, 'maps_lgmice');
    
    	if($miceCount == 0) $output['error_msg'] = "Ooops, we couldn't find any mouse.";
    
    	$normal = array(); $twisted = array();
    		
    	if(isset($data['Living Garden/regular'])) 		$normal['Living Garden/regular'] = $data['Living Garden/regular'];
    	if(isset($data['Living Garden/duskshade'])) 	$normal['Living Garden/duskshade'] = $data['Living Garden/duskshade'];
    	if(isset($data['Lost City/dewthief'])) 			$normal['Lost City/dewthief'] = $data['Lost City/dewthief'];
    	if(isset($data['Sand Dunes/dewthief'])) 		$normal['Sand Dunes/dewthief'] = $data['Sand Dunes/dewthief'];
    		
    	if(isset($data['Twisted Garden/duskshade'])) 	$twisted['Twisted Garden/duskshade'] = $data['Twisted Garden/duskshade'];
    	if(isset($data['Twisted Garden/lunaria'])) 		$twisted['Twisted Garden/lunaria'] = $data['Twisted Garden/lunaria'];
    	if(isset($data['Cursed City/graveblossom'])) 	$twisted['Cursed City/graveblossom'] = $data['Cursed City/graveblossom'];
    	if(isset($data['Sand Crypts/graveblossom'])) 	$twisted['Sand Crypts/graveblossom'] = $data['Sand Crypts/graveblossom'];
    
    	$ouptut['map_type'] = 'maps';
    	$output['title'] = 'Living Garden Treasure Map';
    	$output['left'] = $normal;
    	$output['left_name'] = "NORMAL WORLD";
    	$output['right'] = $twisted;
    	$output['right_name'] = "TWISTED WORLD";
    
    	return array($output, $miceCount);
    }
    
    public function parse_sunken($mapMice = array(), $output = array()) {
    
    	$data = array(); $miceCount = 0; $foundMiceArr = array();
    
    	$mice = $this->config->item('maps_sunkenmice');
    
    	foreach($mapMice as &$mouse) {
    		
    		// make sure the name is in Camel Case
    		$mouse = ucwords(strtolower($mouse));
    		
    		if(strlen($mouse) > 0) {
    			foreach($mice as $area => $miceArr) {
    				if(in_array($mouse, $miceArr)) {
    					$data[$area][] = $mouse;
    
    					if(!in_array($mouse, $foundMiceArr)) {
    						$foundMiceArr[] = $mouse;
    						$miceCount++;
    					}
    				}
    			}
    		}
    	}
    
    	$first_area = array('Shallow Shoals', 'Rocky Outcrop', 'School of Mice', 'Coral Reef', 'Sand Dollar Sea Bar', 'Feeding Grounds');
    	$second_area = array('Sea Floor', 'Shipwreck', 'Mermouse Den', 'Coral Garden', 'Pearl Patch', 'Carnivore Cove');
    	$third_area = array('Murky Depths', 'Haunted Shipwreck', 'Lost Ruins', 'Coral Castle', 'Sunken Treasure', 'Monster Trench', 'Oxygen Stream', 'Deep Oxygen Stream', 'Lair of the Ancients', 'Magma Flow');
    
    	foreach($mice as $area => $miceArr) {
    		if(isset($data[$area])) {
    
    			if(in_array($area, $first_area)) 		$output['left'][$area] = $data[$area];
    			else if(in_array($area, $second_area)) 	$output['middle'][$area] = $data[$area];
    			else if(in_array($area, $third_area)) 	$output['right'][$area] = $data[$area];
    		}
    	}
    
    	if($miceCount == 0) $output['error_msg'] = "Ooops, we couldn't find any mouse.";
    
    	$ouptut['map_type'] = 'maps';
    	$output['title'] = 'Deep Sea Diving Treasure Map';
    	$output['left_name'] = "0 - 1,990 meters";
    	$output['middle_name'] = "2,000 - 9,990 meters";
    	$output['right_name'] = "≥ 10,000 meters";
    
    	return array($output, $miceCount);
    }	

    public function parse_rift($mapMice = array(), $output = array()) {
    
    	$data = array(); $miceCount = 0; $foundMiceArr = array();
    
    	$mice = $this->config->item('maps_riftmice');
    	
    	foreach($mapMice as &$mouse) {
    
    		if(strlen($mouse) > 0) {
    			
    			foreach($mice as $region => $regionArr) {
    				
	    			foreach($regionArr as $area => $miceArr) {

	    				// http://stackoverflow.com/questions/2166512/php-case-insensitive-in-array-function
	    				$search_array = array_map('strtolower', $miceArr);
	    				
	    				if(in_array(strtolower($mouse), $search_array)) {
	    					$data[$region][$area][] = $mouse;
	    
	    					if(!in_array($mouse, $foundMiceArr)) {
	    						$foundMiceArr[] = $mouse;
	    						$miceCount++;
	    					}
	    				}
	    			}
	    			
    			}
    		}
    	}
    
    	$first = array(); $second = array(); $third = array();
    	
    	$first_area = array_keys($mice['grift']);
    	$second_area = array_keys($mice['brift']);
    	$third_area = array_keys($mice['wrift']);
    	
    	foreach($mice as $region => $regionArr) {
    
	    	foreach($regionArr as $area => $miceArr) {
	    		if(isset($data[$region][$area])) {
	    
	    			if(in_array($area, $first_area)) 		$first[$area] = $data[$region][$area];
	    			else if(in_array($area, $second_area)) 	$second[$area] = $data[$region][$area];
	    			else if(in_array($area, $third_area)) 	$third[$area] = $data[$region][$area];
	    		}
	    	}
    	}
    
    	if($miceCount == 0) $output['error_msg'] = "Ooops, we couldn't find any mouse.";
    
    	$ouptut['map_type'] = 'maps';
    	$output['title'] = 'Rift Walkers Treasure Map';
    
    	$output['left'] = $first;
    	$output['left_name'] = "Gnawnia Rift";
    
    	$output['middle'] = $second;
    	$output['middle_name'] = "Burroughs Rift";
    
    	$output['right'] = $third;
    	$output['right_name'] = "Whisker Woods Rift";
    
    	return array($output, $miceCount);
    }
    
    public function parse_fungal($mapMice = array(), $output = array()) {
    	
    	list($data, $miceCount) = $this->filter_mice($mapMice, 'maps_fungalmice');
    
    	if($miceCount == 0) $output['error_msg'] = "Ooops, we couldn't find any mouse.";
    
    	$regular = array(); $special = array();
    
    	if(isset($data['Regular non-SB+'])) $regular['Regular non-SB+'] = $data['Regular non-SB+'];
    	if(isset($data['SB+'])) 			$regular['SB+'] = $data['SB+'];
    
    	if(isset($data['Diamond'])) 		$special['Diamond'] = $data['Diamond'];
    	if(isset($data['Gemstone'])) 		$special['Gemstone'] = $data['Gemstone'];
    	if(isset($data['Glowing Gruyere']))	$special['Glowing Gruyere'] = $data['Glowing Gruyere'];
    	if(isset($data['Mineral'])) 		$special['Mineral'] = $data['Mineral'];
    
    	$ouptut['map_type'] = 'maps';
    	$output['title'] = 'Fungal Cavern Treasure Map';
    	$output['left'] = $regular;
    	$output['left_name'] = "REGULAR CHEESE";
    	$output['right'] = $special;
    	$output['right_name'] = "SPECIAL CHEESE";
    
    	return array($output, $miceCount);
    }

    public function parse_gauntlet($mapMice = array(), $output = array()) {
    	
    	list($data, $miceCount) = $this->filter_mice($mapMice, 'maps_gauntletmice');
    
    	if($miceCount == 0) $output['error_msg'] = "Ooops, we couldn't find any mouse.";
    
    	$regular = array(); $special = array();
    	if(isset($data["Town of Gnawnia/SB+"])) 		$regular["Town of Gnawnia/SB+"] = $data["Town of Gnawnia/SB+"];
    	if(isset($data["Harbour/SB+"])) 				$regular["Harbour/SB+"] = $data["Harbour/SB+"];
    	if(isset($data["Mountain/SB+"])) 				$regular["Mountain/SB+"] = $data["Mountain/SB+"];
    	if(isset($data["Mountain/White Cheddar"])) 		$regular["Mountain/White Cheddar"] = $data["Mountain/White Cheddar"];
    	if(isset($data['King\'s Arms/Gilder'])) 		$regular['King\'s Arms/Gilder'] = $data['King\'s Arms/Gilder'];
    	if(isset($data['King\'s Arms/White Cheddar'])) 	$regular['King\'s Arms/White Cheddar'] = $data['King\'s Arms/White Cheddar'];
    	if(isset($data["Windmill/SB+"])) 				$regular["Windmill/SB+"] = $data["Windmill/SB+"];
    	if(isset($data["Windmill/White Cheddar"])) 		$regular["Gnawnia/Regular"] = $data["Windmill/White Cheddar"];
    	if(isset($data["Meadow/SB+"])) 					$regular["Gnawnia/Regular"] = $data["Meadow/SB+"];
    	if(isset($data["King's Gauntlet/Regular"])) 	$regular["King's Gauntlet/Regular"] = $data["King's Gauntlet/Regular"];

    
    	if(isset($data['Tier 2'])) 	$special['Tier 2'] = $data['Tier 2'];
    	if(isset($data['Tier 3'])) 	$special['Tier 3'] = $data['Tier 3'];
    	if(isset($data['Tier 4'])) 	$special['Tier 4'] = $data['Tier 4'];
    	if(isset($data['Tier 5'])) 	$special['Tier 5'] = $data['Tier 5'];
    	if(isset($data['Tier 6'])) 	$special['Tier 6'] = $data['Tier 6'];
    	if(isset($data['Tier 7'])) 	$special['Tier 7'] = $data['Tier 7'];
    	if(isset($data['Tier 8'])) 	$special['Tier 8'] = $data['Tier 8'];
    
    	$ouptut['map_type'] = 'maps';
    	$output['title'] = "Valour Treasure Map";
    	$output['left'] = $regular;
    	$output['left_name'] = "REGULAR CHEESE";
    	$output['right'] = $special;
    	$output['right_name'] = "SPECIAL CHEESE";
    
    	return array($output, $miceCount);
    }
    
    public function parse_shelder($mapMice = array(), $output = array()) {
    	 
    	list($data, $miceCount) = $this->filter_mice($mapMice, 'maps_sheldermice');
    
    	if($miceCount == 0) $output['error_msg'] = "Ooops, we couldn't find any mouse.";
    
    	$first = array(); $second = array(); $third = array();
    
    	if(isset($data["Balack's Cove/Vengeful"])) 	$first["Balack's Cove/Vengeful"] = $data["Balack's Cove/Vengeful"];
    	if(isset($data["Jungle of Dread"])) 		$first["Jungle of Dread"] = $data["Jungle of Dread"];
    	if(isset($data["SS Huntington"])) 			$first["SS Huntington"] = $data["SS Huntington"];
    	if(isset($data["SS Huntington/SB+"])) 		$first["SS Huntington/SB+"] = $data["SS Huntington/SB+"];
    
    	if(isset($data["Derr Dunes"])) 				$second["Derr Dunes"] = $data["Derr Dunes"];
    	if(isset($data["Nerg Planes"])) 			$second["Nerg Planes"] = $data["Nerg Planes"];
    	if(isset($data["Elub Shore"]))				$second["Elub Shore"] = $data["Elub Shore"];
    	
    	if(isset($data["Cape Clawed/Shell"])) 		$third["Cape Clawed/Shell"] = $data["Cape Clawed/Shell"];
    	if(isset($data["Cape Clawed/Gumbo"])) 		$third["Cape Clawed/Gumbo"] = $data["Cape Clawed/Gumbo"];
    	if(isset($data["Cape Clawed/Crunchy"]))		$third["Cape Clawed/Crunchy"] = $data["Cape Clawed/Crunchy"];
    
    	if($miceCount == 0) $output['error_msg'] = "Ooops, we couldn't find any mouse.";
    
    	$ouptut['map_type'] = 'maps';
    	$output['title'] = 'Tribal and Shelder Hunt Treasure Map';
    
    	$output['left'] = $first;
    	$output['left_name'] = "BC/JoD/SS";
    
    	$output['middle'] = $second;
    	$output['middle_name'] = "Tribes";
    
    	$output['right'] = $third;
    	$output['right_name'] = "Cape Clawed";
    
    	return array($output, $miceCount);
    }

    public function parse_acolyte($mapMice = array(), $output = array()) {
    
        	$data = array(); $miceCount = 0; $foundMiceArr = array();
    
    	$mice = $this->config->item('maps_acolytemice');
    
    	foreach($mapMice as &$mouse) {
    		
    		// make sure the name is in Camel Case
    		$mouse = ucwords(strtolower($mouse));
    		
    		if(strlen($mouse) > 0) {
    			foreach($mice as $area => $miceArr) {
    				
    				$search_array = array_map('strtolower', $miceArr);
    				
    				if(in_array(strtolower($mouse), $search_array)) {
    					$data[$area][] = $mouse;
    
    					if(!in_array($mouse, $foundMiceArr)) {
    						$foundMiceArr[] = $mouse;
    						$miceCount++;
    					}
    				}
    			}
    		}
    	}
    
    	$first_area = array("Acolyte Realm/Runic", "Acolyte Realm/Ancient", "Acolyte Realm/RB");
    	$second_area = array("Mousoleum/Moon","Catacombs/Ancient","Catacombs/Undead");
    	$third_area = array("Forbidden Grove/Moon","Forbidden Grove/Ancient","Forbidden Grove/RB");
    	
    	foreach($mice as $area => $miceArr) {
    		if(isset($data[$area])) {
    
    			if(in_array($area, $first_area)) 		$output['left'][$area] = $data[$area];
    			else if(in_array($area, $second_area)) 	$output['middle'][$area] = $data[$area];
    			else if(in_array($area, $third_area)) 	$output['right'][$area] = $data[$area];
    		}
    	}
    
    	$ouptut['map_type'] = 'maps';
    	$output['title'] = 'Acolyte Treasure Map';
    	$output['left_name'] = "Acolyte Realm";
    	$output['middle_name'] = "Mousoleum/Catacombs";
    	$output['right_name'] = "Forbidden Grove";
    
    	return array($output, $miceCount);
    }
    
	public function save_post_query($data) {
		// $this->load->database();
		
		// dump($this->db);
		
		dump($data); die();
	}
	
    /**
     * Filter out all mice from original POST request
     * @param array $mapMice
     * @param string $configItem
     * @return multitype: array $data, number $miceCount 
     */
    private function filter_mice($mapMice=array(), $configItem='') {
    	
    	$data = array(); $miceCount = 0;
    	
    	$mice = $this->config->item($configItem);
    	
    	foreach($mapMice as &$mouse) {
    	
    		// make sure the name is in Camel Case
    		// $mouse = ucwords(strtolower($mouse));
    	
    		if(strlen($mouse) > 0) {
    			foreach($mice as $area => $miceArr) {
					
					$search_array = array_map('strtolower', $miceArr);
					
    				if(in_array(strtolower($mouse), $search_array)) {
    					$data[$area][] = $mouse;
    					$miceCount++;
    					break;
    				}
    			}
    		}
    	}
    	
    	return array($data, $miceCount);
    }
    
}

// line #297 ?>
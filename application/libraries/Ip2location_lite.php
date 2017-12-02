<?php

//Load the class
final class ip2location_lite {
	
	protected $_ci;
	protected $errors = array();
	protected $service = 'api.ipinfodb.com';
	protected $version = 'v3';
	protected $apiKey = '50c3a97992b08f1751543012f14e8cca978146f357875802f7565db9dbd46a43';

	public function __construct() {
		$this->_ci = & get_instance();
	}

	public function __destruct() {
		
	}

	public function getError() {
		return implode("\n", $this->errors);
	}

	public function getCountry($host=null) {
		return $this->getResult($this->setHost($host), 'ip-country');
	}

	public function getCity($host=null) {
		return $this->getResult($this->setHost($host), 'ip-city');
	}
	
	private function setHost($host) {
		if(is_null($host)) $host = $this->_ci->input->server('REMOTE_ADDR');
		return $host;
	}

	private function getResult($host, $name) {
		$ip = @gethostbyname($host);

		if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)){
			$xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml');
			
			//echo 'http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml';

			if (get_magic_quotes_runtime()){
				$xml = stripslashes($xml);
			}

			try{
				$response = @new SimpleXMLElement($xml);

				foreach($response as $field=>$value){
					$result[(string)$field] = (string)$value;
				}

				return $result;
			}
			catch(Exception $e){
				$this->errors[] = $e->getMessage();
				return;
			}
		}

		$this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
		return;
	}
}
?>
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function dump($array) {
	if(is_null($array)) echo 'null';
	else {
		echo '<pre>'; var_export($array); echo '</pre>';
	}
}

function dump2($array) {
	if(is_null($array)) echo 'null';
	else {
		echo '<pre>'; print_r($array); echo '</pre>';
	}
}

function custom_dropdown($name = '', $options = array(), $selected = array(), $extra = '') {

	if ( ! is_array($selected))
	{
		$selected = array($selected);
	}
	
	// If no selected state was submitted we will attempt to set it automatically
	if (count($selected) === 0)
	{
		// If the form name appears in the $_POST array we have a winner!
		if (isset($_POST[$name]))
		{
			$selected = array($_POST[$name]);
		}
	}
	
	if ($extra != '') $extra = ' '.$extra;

	$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

	$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";
	
	foreach ($options as $key => $val) {
		$key = (string) $key;

		$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

		$form .= '<option id="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
	}
	
	$form .= '</select>';
	
	return $form;
}

function logged_in() {
	$CI = &get_instance();
	return $CI->session->userdata('logged_in');
}

//used when debugging
function timer() {
	$mtime = microtime();
	$mtime = explode(' ', $mtime);
	$mtime = $mtime[1] + $mtime[0];
	return $mtime;
}

/**
 * Remove item from a array and does not preserve keys, if preserve_keys is set to false
 * @param array $array
 * @param mixed $val
 * @param boolean $preserve_keys
 * @return array
 *
 * @link http://dev-tips.com/featured/remove-an-item-from-an-array-by-value
 */
function remove_item_by_value($array, $val = '', $preserve_keys = true) {
	if (empty($array) || !is_array($array)) return false;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
}

function unaccent($string) {

	//remove umlauts
	if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false) {
		$string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
	}

	return $string;
}
/**
 *
 * Convert specials chars to HTML entities
 * @param unknown_type $str
 * @link http://www.lookuptables.com/
 * @link http://www.web-source.net/symbols.htm
 * @link http://webdesign.about.com/library/bl_htmlcodes.htm (most extensive)
 *
 * 	&#268; - C
 * 	&#269; - c
 * 	&#352; - S
 * 	&#353; - s
 * 	&#381; - Z
 * 	&#382; - z
 *
 * 	... = &hellip;
 */
function str2utf($str, $special=0) {
	if(is_string($str)) {

		$str = str_replace(chr(59), "&#58;", $str);	//;
		$str = str_replace(chr(196).chr(140), "&#268;", $str);	//ÄŚ
		$str = str_replace(chr(196).chr(141), "&#269;", $str);	//ÄŤ
		$str = str_replace(chr(197).chr(161), "&#353;", $str);	//Ĺˇ
		$str = str_replace(chr(197).chr(160), "&#352;", $str);	//Ĺ 
		$str = str_replace(chr(197).chr(189), "&#381;", $str);	//Ĺ˝
		$str = str_replace(chr(197).chr(190), "&#382;", $str);	//Ĺľ
		$str = str_replace(chr(196).chr(135), "&#263;", $str);	//Ä‡ (mali meki c)
		//$str = str_replace(chr().chr(), "&#262;", $str);	//Ä† (veliki meki C)
		$str = str_replace(chr(196).chr(145), "&#273;", $str);	//Ä‘ (mali dz)
		$str = str_replace(chr(196).chr(144), "&#272;", $str);	//Ä� (veliki dz)
		$str = str_replace(chr(195).chr(169), "&#233;", $str);	//Ă© (acute accent)
		$str = str_replace(chr(194).chr(187), "&#187;", $str);	//>
		$str = str_replace(chr(194).chr(171), "&#171;", $str);	//<
		$str = str_replace(chr(226).chr(128).chr(147), "&#150;", $str);        //-
		$str = str_replace(chr(226).chr(128).chr(148), "&#150;", $str);        //-
		$str = str_replace(chr(226).chr(128).chr(166), "...", $str);        //hellip
		$str = str_replace(chr(40), "&#40;", $str);	//(
		$str = str_replace(chr(41), "&#41;", $str);	//)
		$str = str_replace(chr(39), "&#39;", $str);	//'
		$str = str_replace(chr(34), "&#34;", $str);	//"

		$str = str_replace("\r", " ", $str);	//"
		//		$str = str_replace("\\r", " ", $str);	//"
		//		$str = str_replace("\\n", "", $str);	//"
		$str = str_replace("\n", "", $str);	//"

		$str = str_replace(chr(91), '&#91;', $str);	// [
		$str = str_replace(chr(93), '&#93;', $str);	// ]

		if($special == 1) { //for URL encoding, urlencode does not work!
			$str = str_replace(chr(34), '%27', $str);	//"
			$str = str_replace(chr(39), "%27", $str);	//'
		}
		else if($special == 2) {	//convert lowercase to uppercase
			$str = str_replace('&#269;', '&#268;', $str);	//ÄŤ
			$str = str_replace('&#353;', '&#352;', $str);	//Ĺˇ
			$str = str_replace('&#382;', '&#381;', $str);	//Ĺľ
			$str = str_replace('&#273;', '&#272;', $str);	//Ä‘
		}
	}

	return addslashes($str);
}


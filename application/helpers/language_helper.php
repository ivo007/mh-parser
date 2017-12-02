<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Lang
 *
 * Fetches a language variable and optionally outputs a form label
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the id of the form element
 * @return	string
 */
if ( ! function_exists('lang'))
{
	function lang($line, $id = '')
	{
		detect_lang();
		$CI =& get_instance();
		$line = $CI->lang->line($line);
		
		if ($id != '')
		{
			$line = '<label for="'.$id.'">'.$line."</label>";
		}

		return $line;
	}
}

/**
 *
 * Detect user-defined language and load appropriate languange files
 */
function detect_lang() {
	$CI =& get_instance();
	$active_lang = $CI->config->item('language');

	if(!in_array($active_lang, $CI->lang->is_loaded, TRUE)) {
		$result = $CI->lang->load($active_lang, $active_lang);
		if($result) $CI->config->set_item('language', $active_lang);
	}
}

// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */
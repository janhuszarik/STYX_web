<?php
/**
 * Project STYX REMISE.
 * User: Jan Huszarik
 * Copyright: Jan Huszarik
 * Date: 07.05.2022
 * Time: 17:39
 * mail: info@websiteapp.eu
 */

if (!function_exists('load_menu_data')) {
	function load_menu_data(&$data) {
		$CI =& get_instance();
		$CI->load->model('App_model');
		$data['menuItems'] = $CI->App_model->get_menu_items();
	}
}
//function getLanguages(){
//	$ci = get_instance();
//
//	return $ci->config->config['languages'];
//
//}

function language(){


	$CI = get_instance();
	$lang = $CI->config->config['language'];
	return $CI->config->config['languages'][$lang];

}

function dd($var_dump){

	echo '<pre>';
	var_dump($var_dump);
	echo '</pre>';

};

	function ddd($var_dump){

	echo '<pre>';
	var_dump($var_dump);
	echo '</pre>';
	die();

}

function langInfo($lang = false)
{

	if ($lang == 'sk') {

		$info = array(
			'text' => 'Slovensky',
			'flag' => BASE_URL . 'img/flag/png/slovak.png'
		);
		return $info;

	} elseif ($lang == 'en') {
		$info = array(
			'text' => 'Anglicky',
			'flag' => BASE_URL . 'img/flag/png/english.png'
		);
		return $info;
	} elseif ($lang == 'de') {
		$info = array(
			'text' => 'Nemecky',
			'flag' => BASE_URL . 'img/flag/png/germany.png'
		);
		return $info;

	} else {
		echo 'chyba';
	}

}


if ( ! function_exists('lang')) {
	/**
	 * Lang
	 *
	 * Fetches a language variable and optionally outputs a form label
	 *
	 * @param string $line The language line
	 * @param string $for The "for" value (id of the form element)
	 * @param array $attributes Any additional HTML attributes
	 * @return    string
	 */
	function lang($line, $for = '', $attributes = array())
	{
		$line = get_instance()->lang->line($line);

		if ($for !== '') {
			$line = '<label for="' . $for . '"' . _stringify_attributes($attributes) . '>' . $line . '</label>';
		}

		return $line;
	}


	/**
	 * @param $string | Očistí string od $ a " .. nahradí ich kódom
	 * @return mixed
	 */
	function string_replaceToDb($string)
	{

		$string = str_replace("'", '&#039;', $string);
		$string = str_replace('"', '&#34;', $string);
		$string = str_replace('%', '&percnt;', $string);
		return $string;

	}

	function getLanguages()
	{
		$ci = get_instance();

		return $ci->config->config['languages'];

	}

	function url_oprava($str, $separator = '-', $lowercase = FALSE)
	{
		if ($separator === 'dash') {
			$separator = '-';
		} elseif ($separator === 'underscore') {
			$separator = '_';
		}

		$q_separator = preg_quote($separator, '#');

		$trans = array(
			"'" => '&#039;',
			'"' => '&#34;',
			'ľ' => 'l',
			'š' => 's',
			'č' => 'c',
			'ť' => 't',
			'ž' => 'z',
			'ý' => 'y',
			'á' => 'a',
			'í' => 'i',
			'é' => 'e',
			'ú' => 'u',
			'ä' => 'a',
			'ň' => 'n',
			'ô' => 'o',
			'ó' => 'o',
			'ĺ' => 'l',
			'ď' => 'd',
			'Ľ' => 'l',
			'Š' => 's',
			'Č' => 'c',
			'Ť' => 't',
			'Ž' => 'z',
			'Ý' => 'y',
			'Á' => 'a',
			'Í' => 'i',
			'É' => 'e',
			'Ú' => 'u',
			'Ä' => 'a',
			'Ň' => 'n',
			'Ô' => 'o',
			'Ó' => 'o',
			'Ĺ' => 'l',
			'ě' => 'e',
			'ö' => 'o',
			'Ď' => 'd',
			'ř' => 'r',
			'ŕ' => 'r',
			'Ŕ' => 'R',
			'ů' => 'u',
			'Ř' => 'r',
			'Ě' => 'e',
			'&.+?;' => '',
			'[^\w\d _-]' => '',
			'\s+' => $separator,
			'(' . $q_separator . ')+' => $separator
		);
		$str = strip_tags($str);
		foreach ($trans as $key => $val) {
			$str = preg_replace('#' . $key . '#i' . (UTF8_ENABLED ? 'u' : ''), $val, $str);
		}

		if ($lowercase === TRUE) {
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));
	}

	function str_oprava($str, $separator = '-', $lowercase = FALSE)
	{
		if ($separator === 'dash') {
			$separator = '-';
		} elseif ($separator === 'underscore') {
			$separator = '_';
		}

		$q_separator = preg_quote($separator, '#');

		$trans = array(
			'ľ' => 'l',
			'š' => 's',
			'č' => 'c',
			'%C4%8D' => 'c',
			'ť' => 't',
			'ž' => 'z',
			'ý' => 'y',
			'á' => 'a',
			'í' => 'i',
			'é' => 'e',
			'ú' => 'u',
			'ä' => 'a',
			'ň' => 'n',
			'ô' => 'o',
			'ó' => 'o',
			'ĺ' => 'l',
			'ď' => 'd',
			'Ľ' => 'l',
			'Š' => 's',
			'Č' => 'c',
			'Ť' => 't',
			'Ž' => 'z',
			'Ý' => 'y',
			'Á' => 'a',
			'Í' => 'i',
			'É' => 'e',
			'Ú' => 'u',
			'Ä' => 'a',
			'Ň' => 'n',
			'Ô' => 'o',
			'Ó' => 'o',
			'Ĺ' => 'l',
			'ě' => 'e',
			'ö' => 'o',
			'Ď' => 'd',
			'ř' => 'r',
			'ŕ' => 'r',
			'Ŕ' => 'R',
			'ů' => 'u',
			'Ř' => 'r',
			'Ě' => 'e',
			'&.+?;' => '',
			'[^\w\d _-]' => '',
			'\s+' => $separator,
			'(' . $q_separator . ')+' => $separator
		);
		$str = strip_tags($str);
		foreach ($trans as $key => $val) {
			$str = preg_replace('#' . $key . '#i' . (UTF8_ENABLED ? 'u' : ''), $val, $str);
		}

		if ($lowercase === TRUE) {
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));

	}


	function validate_recaptcha_response($recaptcha_response, $ip)
	{

		$api_url = 'https://www.google.com/recaptcha/api/siteverify';
		$api_secret = SECRETKEY;

		$data = array('secret' => $api_secret, 'response' => $recaptcha_response);
		$options = array(
			'http' => array(
				'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);

		$context = stream_context_create($options);
		$result = file_get_contents($api_url, false, $context);

		$captcha_response = json_decode($result, true);

//    ddd($captcha_response);
		if ($captcha_response['success'] == false) {
			return false;
		} else {
			$r = array(
				'success' => $captcha_response['success'],
				'timestamp' => $captcha_response['challenge_ts'],
				'hostname' => $captcha_response['hostname'],
				'error_codes' => (isset($captcha_response['error-codes'])) ? $captcha_response['error-codes'] : null,
			);

			return $r;
		}
	}

	function getAccess($id = false)
	{
		$ci = get_instance();

		if ($id) {
			return $ci->db->select('*')->where('id', $id)->get('access')->row();
		} else {
			return $ci->db->select('*')->get('access')->result();
		}

	}


	function getNameCategory($catID)
	{

		$CI = get_instance();
		$CI->db->select('*');
		$CI->db->where('id', $catID);
		return $CI->db->get('categoryArticles')->row();


	}


	function initials($string)
	{


		if (strlen($string) > 8) {
			return strtoupper($string[0]) . '.';
		} else {
			return $string;
		}
	}

	function user($onlyFirst = false)
	{


		$CI = &get_instance();

		if ($CI->ion_auth->logged_in()) {
			$user = $CI->ion_auth->user()->row();

			if ($onlyFirst) {
				return $user->first_name;
			} else {
				return $user->first_name . '&nbsp;' . initials($user->last_name);
			}
		} else {
			return '';
		}


	}

	function redirectIfEmpty($data = false, $urlRedirect = 'admin', $chybovaHlaska = 'Chyba!')
	{

		if (empty($data) || $data == NULL) {

			$CI = &get_instance();
			$CI->session->set_flashdata('error', $chybovaHlaska);
			redirect(BASE_URL . $urlRedirect);

		}


	}

	function activeOrNotEnum($active)
	{

		if ($active == 'on') { // z inputu máme výsledok 'on' | NULL
			return 1;
		} else {
			return 0;
		}
	}

	function activeOrNot($active)
	{

		if ($active == 'on') { // z inputu máme výsledok 'on' | NULL
			return '1';
		} else {
			return '0';
		}
	}

	function activeToIcon($value)
	{


		if ($value == '0') {
			return '<i class="fa fa-times trash_icon_color" title="Neaktívne"></i>';
		} else {
			return '<i class="fa fa-check color_green" title="Aktívne"></i>';
		}

	}
}







<?php
	function dd($var_dump){

	echo '<pre>';
	var_dump($var_dump);
	echo '</pre>';
}

	function ddd($var_dump){

	echo '<pre>';
	var_dump($var_dump);
	echo '</pre>';
	die();
}

	function language(){


	$CI = get_instance();
	$lang = $CI->config->config['language'];
	return $CI->config->config['languages'][$lang];

}

	function getLanguages(){
	$ci = get_instance();

	return $ci->config->config['languages'];

}
function langInfo($lang = false) {
	$default = [
		'text' => strtoupper($lang),
		'flag' => BASE_URL . 'img/flag/default.png' // fallback obrázok
	];

	if ($lang === 'sk') {
		return [
			'text' => 'Slowakisch',
			'flag' => BASE_URL . 'img/flag/png/slovak.png'
		];
	} elseif ($lang === 'en') {
		return [
			'text' => 'Englisch',
			'flag' => BASE_URL . 'img/flag/svg/england.svg'
		];
	} elseif ($lang === 'de') {
		return [
			'text' => 'Deutsch',
			'flag' => BASE_URL . 'img/flag/svg/austria.svg'
		];
	}

	// fallback pre neznámy jazykový kód
	return $default;
}



// Skontroluje, či neexistuje funkcia s názvom 'lang'
	if ( ! function_exists('lang'))

		// Ak neexistuje, definuje funkciu 'lang'
{
		/**
	 * Lang
	 *
	 * Načítava jazykovú premennú a voliteľne vypisuje štítok formulára
	 *
	 * @param	string	$line		Jazyková hodnota
	 * @param	string	$for		Hodnota atribútu "for" (id prvku formulára)
	 * @param	array	$attributes	Ďalšie HTML atribúty
	 * @return	string
	 */
	function lang($line, $for = '', $attributes = array())
	{
		// Načíta jazykovú hodnotu z frameworku
		$line = get_instance()->lang->line($line);

		// Ak je 'for' zadané, vygeneruje HTML štítok
		if ($for !== '')
		{
			$line = '<label for="'.$for.'"'._stringify_attributes($attributes).'>'.$line.'</label>';
		}

		// Vráti jazykovú hodnotu alebo vygenerovaný HTML štítok
		return $line;
	}
}
	//--------------------------------------------------------

	// Skontroluje, či neexistuje funkcia s názvom 'get_http_referer'
	if (!function_exists('get_http_referer')) {
			// Ak neexistuje, definuje funkciu 'get_http_referer'
			function get_http_referer() {
				// Načíta inštanciu frameworku
				$CI =& get_instance();
				// Vráti hodnotu HTTP_REFERER zo serverových premenných
				return $CI->input->server('HTTP_REFERER');
			}
		}
	//--------------------------------------------------------

	function active($option) {
	if ($option == '1') {
		return '<i style="color: green; font-weight: bold; font-size: 17px" class="fa fa-check color_green"></i>';
	} else {
		return '<i style="color: red; font-weight: bold; font-size: 17px" class="fa fa-times trash_icon_color"></i>';
	}
}

	function getCurrentUrl() {
	return current_url();
}

	function getMenu() {
	$ci = get_instance();
	$language = language();

	$ci->db->select('*');
	$ci->db->where('active', '1');
	$ci->db->where('lang', $language);
	$ci->db->order_by('orderBy', 'ASC');
	$mainMenuItems = $ci->db->get('menu')->result();

	$ci->db->select('*');
	$ci->db->where('parent !=', '0');
	$ci->db->where('active', '1');
	$ci->db->where('lang', $language);
	$ci->db->order_by('orderBy', 'ASC');
	$subMenuItems = $ci->db->get('menu')->result();

	$formattedMenu = array();
	foreach ($mainMenuItems as $mainKey => $mainItem) {
		if ($mainItem->parent) continue;

		$url = empty($mainItem->url) ? '' : $mainItem->url;
		$isExternal = (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0);

		if (!$isExternal && strpos($url, $language . '/') === false) {
			$url = $language . '/' . ltrim($url, '/');
		}

		$formattedMenu[$mainKey] = array(
			'name' => $mainItem->name,
			'url' => $url,
			'lang' => $mainItem->lang,
			'children' => array(),
			'has_child' => false,
			'is_external' => $isExternal
		);

		foreach ($subMenuItems as $subKey => $subItem) {
			if ($mainItem->id == $subItem->parent) {
				$subUrl = empty($subItem->url) ? '' : $subItem->url;
				$isSubExternal = (strpos($subUrl, 'http://') === 0 || strpos($subUrl, 'https://') === 0);

				if (!$isSubExternal && strpos($subUrl, $language . '/') === false) {
					$subUrl = $language . '/' . url_oprava($mainItem->name) . '/' . ltrim($subUrl, '/');
				}

				$formattedMenu[$mainKey]['children'][$subKey] = array(
					'name' => $subItem->name,
					'url' => $subUrl,
					'lang' => $subItem->lang,
					'is_external' => $isSubExternal
				);

				$formattedMenu[$mainKey]['has_child'] = true;
			}
		}
	}

	return $formattedMenu;
}






function redirectIfEmpty($data = false,$urlRedirect = 'admin',$chybovaHlaska = 'Fehler!'){

		if (empty($data) || $data == NULL){

			$CI = & get_instance();
			$CI->session->set_flashdata('error', $chybovaHlaska);
			redirect(BASE_URL.$urlRedirect);

		}
	}

	function tage($datetime_in_DB){

		$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
		return $tage[date('w', strtotime($datetime_in_DB))];

}

	function user($user_id = false){
	$CI = & get_instance();
	if ( $user_id > 0) {


		$CI->db->select('*');
		$CI->db->from('users');
		$CI->db->where('id', $user_id);
		$user = $CI->db->get();
		$user = $user->result();

		if ( !$user == 0 ) {
			echo $user[0]->first_name.' '.$user[0]->last_name;
		}   else {
			echo 'Neexistuje!';
		}


	} else {
		$user = $CI->ion_auth->user()->row();


		return $user->first_name.'&nbsp;'.$user->last_name.'&nbsp;'."<br>".$user->email.'&nbsp;'."<br>".$user->phone;


	}


}

function uploadImg($file = false, $dir = false, $saveAsNameFile = false, $resizeImage = false, $watermark = false){
	unset($_FILES['files']);

	$CI = & get_instance();
	$CI->load->library('image_lib');
	if ($dir == false){
		$dir = 'uploads/';
		if (!is_dir($dir)) mkdir($dir, 0755, true);
	} else {
		if (!is_dir($dir)) mkdir($dir, 0755, true);
		$dir = rtrim($dir, '/') . '/';
	}

	if ($saveAsNameFile == false) { $saveAsNameFile = 'img'; }

	if (is_array($_FILES[$file]['name'])) {
		$data = array();
		foreach ($_FILES[$file]['name'] as $k => $name) {
			if (!empty($name)) {
				$tmpName = $_FILES[$file]['tmp_name'][$k];
				if (isset($tmpName) && is_string($tmpName) && file_exists($tmpName)) {
					$nazovAkoURL = trim(url_oprava($saveAsNameFile));
					$typ = pathinfo($name, PATHINFO_EXTENSION);
					$urlimg = $dir . $nazovAkoURL . '-' . uniqid() . '.' . $typ;

					if (in_array(strtolower($typ), array('jpg', 'jpeg', 'png', 'gif', 'webp')) && is_uploaded_file($tmpName)) {
						if (move_uploaded_file($tmpName, $urlimg)) {
							$data[$k] = $resizeImage ? obrazokfinal($urlimg, $watermark) : $urlimg;
						} else {
							$data[$k] = '';
						}
					}
				}
			}
		}
		return $data;
	} else {
		if (empty($_FILES[$file]['name'])){
			return '';
		}

		$tmpName = $_FILES[$file]['tmp_name'];
		if (isset($tmpName) && is_string($tmpName) && file_exists($tmpName)) {
			$nazovAkoURL = trim(url_oprava($saveAsNameFile));
			$typ = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
			$urlimg = $dir . $nazovAkoURL . '-' . uniqid() . '.' . $typ;

			if (in_array(strtolower($typ), array('jpg', 'jpeg', 'png', 'gif', 'webp')) && is_uploaded_file($tmpName)) {
				if (move_uploaded_file($tmpName, $urlimg)) {
					return $resizeImage ? obrazokfinal($urlimg, $watermark) : $urlimg;
				}
			}
		}
		return '';
	}
}

	function obrazokfinal ($adresaimg,$offLogo = true, $defaultWidthImage = 1600){

	$CI = & get_instance();
	$CI->load->library('image_lib');

	if ($adresaimg) {
		$configi['image_library'] = 'gd2';
		$configi['source_image'] =  $adresaimg;
		$configi['create_thumb'] = FALSE;
		$configi['maintain_ratio'] = TRUE;
		$configi['master_dim'] = 'width';
		$configi['max_size'] = '0';
		$configi['quality'] = "70%";
		$configi[ 'x_axis' ]  =  100 ;
		$configi[ 'y_axis' ]  =  40 ;
		$configi['width'] = $defaultWidthImage;
		$configi['height'] = $defaultWidthImage;



		$CI->image_lib->initialize($configi);
		$CI->image_lib->resize();
	}

	if($offLogo == true){
		// vnor vodotlač
		if ($adresaimg) {

			$configw['wm_text'] = DOMAIN;
			$configw['wm_type'] = 'overlay';
			$configw['wm_overlay_path'] = APP_PATH.'/'.LOGO_PNG;
			$configw['wm_opacity'] = '50';
			$configw['wm_vrt_alignment'] = 'bottom';
			$configw['wm_hor_alignment'] = 'right';
			$configw['wm_padding'] = '-20';
			$CI->image_lib->initialize($configw);
			$CI->image_lib->watermark();
		}
	}
	if ($adresaimg) {

		$config['image_library'] = 'gd2';
		$config['source_image'] = $adresaimg;
		$config['thumb_marker'] = '_thumb';
		$config['create_thumb'] = TRUE;
		$config['maintain_ration'] = TRUE;
		$config['width']         = 500;
		$config['height']       = 400;

		$CI->image_lib->initialize($config);

		$CI->image_lib->resize();
	}

	return $adresaimg;
}

	function url_oprava($str, $separator = '-', $lowercase = FALSE){
	if ($separator === 'dash')
	{
		$separator = '-';
	}
	elseif ($separator === 'underscore')
	{
		$separator = '_';
	}

	$q_separator = preg_quote($separator, '#');

	$trans = array(
		"'"									=> '&#039;',
		'"'									=> '&#34;',
		'ľ'									=> 'l',
		'š'									=> 's',
		'č'									=> 'c',
		'ť'									=> 't',
		'ž'									=> 'z',
		'ý'									=> 'y',
		'á'									=> 'a',
		'í'									=> 'i',
		'é'									=> 'e',
		'ú'									=> 'u',
		'ä'									=> 'a',
		'ň'									=> 'n',
		'ô'									=> 'o',
		'ó'									=> 'o',
		'ĺ'									=> 'l',
		'ď'									=> 'd',
		'Ľ'									=> 'l',
		'Š'									=> 's',
		'Č'									=> 'c',
		'Ť'									=> 't',
		'Ž'									=> 'z',
		'Ý'									=> 'y',
		'Á'									=> 'a',
		'Í'									=> 'i',
		'É'									=> 'e',
		'Ú'									=> 'u',
		'Ä'									=> 'a',
		'Ň'									=> 'n',
		'Ô'									=> 'o',
		'Ó'									=> 'o',
		'Ĺ'									=> 'l',
		'ě'									=> 'e',
		'ö'									=> 'o',
		'Ď'									=> 'd',
		'ř'									=> 'r',
		'ŕ'									=> 'r',
		'Ŕ'									=> 'R',
		'ů'									=> 'u',
		'Ř'									=> 'r',
		'Ě'									=> 'e',
		'&.+?;'			=> '',
		'[^\w\d _-]'		=> '',
		'\s+'			=> $separator,
		'('.$q_separator.')+'	=> $separator
	);
	$str = strip_tags($str);
	foreach ($trans as $key => $val)
	{
		$str = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $str);
	}

	if ($lowercase === TRUE)
	{
		$str = strtolower($str);
	}

	return trim(trim($str, $separator));
}

	function obrpridajthumb($vstup = false){


	if($vstup){
		$urlimgthumb = explode('.',$vstup );
		$urlimgthumb = ($urlimgthumb[0]).'_thumb'.'.'.($urlimgthumb[1]);
		return $urlimgthumb;
	} else {
		$urlimgthumb = false;
		return $urlimgthumb;
	}
}
//funkcia pre Admin na zobrazenie stavu keywords a description
if (!function_exists('checkTextIcon')) {
	function checkTextIcon($value = '') {
		if (!empty(trim($value))) {
			return '<i class="fa fa-check text-success"></i>';
		} else {
			return '<i class="fa fa-times text-danger"></i>';
		}
	}
}









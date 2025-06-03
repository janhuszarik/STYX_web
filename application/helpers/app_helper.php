<?php
defined('BASEPATH') OR exit('Kein direkter Skriptzugriff erlaubt');

function dd($var_dump) {
	echo '<pre>';
	var_dump($var_dump);
	echo '</pre>';
}

function ddd($var_dump) {
	echo '<pre>';
	var_dump($var_dump);
	echo '</pre>';
	die();
}

function language() {
	$CI = get_instance();
	$lang = $CI->config->config['language'];
	return $CI->config->config['languages'][$lang];
}

function getLanguages() {
	$ci = get_instance();
	return $ci->config->config['languages'];
}

function langInfo($lang = false) {
	$default = [
		'text' => strtoupper($lang),
		'flag' => BASE_URL . 'img/flag/default.png'
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

	return $default;
}

if (!function_exists('lang')) {
	function lang($line, $for = '', $attributes = array()) {
		$line = get_instance()->lang->line($line);
		if ($for !== '') {
			$line = '<label for="' . $for . '"' . _stringify_attributes($attributes) . '>' . $line . '</label>';
		}
		return $line;
	}
}

if (!function_exists('get_http_referer')) {
	function get_http_referer() {
		$CI =& get_instance();
		return $CI->input->server('HTTP_REFERER');
	}
}

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

	$ci->db->select('id, name, url, lang, parent, base'); // Pridajte 'base' do selectu
	$ci->db->where('active', '1');
	$ci->db->where('lang', $language);
	$ci->db->order_by('orderBy', 'ASC');
	$mainMenuItems = $ci->db->get('menu')->result();

	$ci->db->select('id, name, url, lang, parent, base'); // Pridajte 'base' aj tu
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
			'base' => $mainItem->base, // Pridajte base
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
					'base' => $subItem->base, // Pridajte base aj pre podpoložky, ak je potrebné
					'is_external' => $isSubExternal
				);

				$formattedMenu[$mainKey]['has_child'] = true;
			}
		}
	}

	return $formattedMenu;
}

function redirectIfEmpty($data = false, $urlRedirect = 'admin', $chybovaHlaska = 'Fehler!') {
	if (empty($data) || $data == NULL) {
		$CI =& get_instance();
		$CI->session->set_flashdata('error', $chybovaHlaska);
		redirect(BASE_URL . $urlRedirect);
	}
}

function tage($datetime_in_DB) {
	$tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
	return $tage[date('w', strtotime($datetime_in_DB))];
}

function user($user_id = false) {
	$CI =& get_instance();
	if ($user_id > 0) {
		$CI->db->select('*');
		$CI->db->from('users');
		$CI->db->where('id', $user_id);
		$user = $CI->db->get()->result();

		if (!empty($user)) {
			echo $user[0]->first_name . ' ' . $user[0]->last_name;
		} else {
			echo 'Neexistuje!';
		}
	} else {
		$user = $CI->ion_auth->user()->row();
		return $user->first_name . ' ' . $user->last_name . ' <br>' . $user->email . ' <br>' . $user->phone;
	}
}

function uploadImg($file = false, $dir = false, $saveAsNameFile = false, $resizeImage = false, $watermark = false) {
	unset($_FILES['files']);
	$CI =& get_instance();
	$CI->load->library('image_lib');

	// Nastavenie priečinka
	if ($dir === false) {
		$dir = 'Gallery/';
	} else {
		$dir = rtrim($dir, '/') . '/';
	}

	// Vytvorenie priečinka s kontrolou
	if (!is_dir($dir)) {
		if (!mkdir($dir, 0755, true)) {
			log_message('error', "Nepodarilo sa vytvoriť priečinok: $dir");
			return false;
		}
	}

	// Kontrola oprávnení priečinka
	if (!is_writable($dir)) {
		log_message('error', "Priečinok nie je zapisovateľný: $dir");
		return false;
	}

	if ($saveAsNameFile == false) {
		$saveAsNameFile = 'img';
	}

	// Spracovanie jedného súboru
	if (empty($_FILES[$file]['name'])) {
		return '';
	}

	$tmpName = $_FILES[$file]['tmp_name'];
	if (isset($tmpName) && is_string($tmpName) && file_exists($tmpName)) {
		$nazovAkoURL = trim(url_oprava($saveAsNameFile));
		$typ = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);
		$urlimg = $dir . $nazovAkoURL . '.' . $typ;

		if (in_array(strtolower($typ), array('jpg', 'jpeg', 'png', 'gif', 'webp')) && is_uploaded_file($tmpName)) {
			if (move_uploaded_file($tmpName, $urlimg)) {
				return $resizeImage ? obrazokfinal($urlimg, $watermark) : $urlimg;
			} else {
				log_message('error', "Nepodarilo sa presunúť súbor: $tmpName do $urlimg");
				return '';
			}
		} else {
			log_message('error', "Nepodporovaný formát súboru alebo súbor nie je nahratý: " . $_FILES[$file]['name']);
			return '';
		}
	}
	return '';
}

function obrazokfinal($adresaimg, $offLogo = true, $defaultWidthImage = 1600) {
	$CI =& get_instance();
	$CI->load->library('image_lib');

	if ($adresaimg && file_exists($adresaimg)) {
		// Resize obrázka
		$configi['image_library'] = 'gd2';
		$configi['source_image'] = $adresaimg;
		$configi['create_thumb'] = FALSE;
		$configi['maintain_ratio'] = TRUE;
		$configi['master_dim'] = 'width';
		$configi['max_size'] = '0';
		$configi['quality'] = "70%";
		$configi['x_axis'] = 100;
		$configi['y_axis'] = 40;
		$configi['width'] = $defaultWidthImage;
		$configi['height'] = $defaultWidthImage;

		$CI->image_lib->initialize($configi);
		if (!$CI->image_lib->resize()) {
			log_message('error', "Chyba pri zmene veľkosti obrázka: " . $CI->image_lib->display_errors());
		}

		// Vodoznak
		if ($offLogo == true) {
			$configw['wm_type'] = 'overlay';
			$configw['wm_overlay_path'] = APP_PATH . '/' . LOGO_PNG;
			$configw['wm_opacity'] = '50';
			$configw['wm_vrt_alignment'] = 'bottom';
			$configw['wm_hor_alignment'] = 'right';
			$configw['wm_padding'] = '-20';
			$CI->image_lib->initialize($configw);
			if (!$CI->image_lib->watermark()) {
				log_message('error', "Chyba pri pridávaní vodoznaku: " . $CI->image_lib->display_errors());
			}
		}

		// Vytvorenie náhľadu (thumbnail)
		$config['image_library'] = 'gd2';
		$config['source_image'] = $adresaimg;
		$config['thumb_marker'] = '_thumb';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 500;
		$config['height'] = 400;

		$CI->image_lib->initialize($config);
		if (!$CI->image_lib->resize()) {
			log_message('error', "Chyba pri vytváraní náhľadu: " . $CI->image_lib->display_errors());
		}
	}

	return $adresaimg;
}

function url_oprava($str, $separator = '-', $lowercase = TRUE) {
	if ($separator === 'dash') {
		$separator = '-';
	} elseif ($separator === 'underscore') {
		$separator = '_';
	}

	$q_separator = preg_quote($separator, '#');

	$trans = array(
		"'" => '',
		'"' => '"',
		'ľ' => 'l', 'š' => 's', 'č' => 'c', 'ť' => 't', 'ž' => 'z',
		'ý' => 'y', 'á' => 'a', 'í' => 'i', 'é' => 'e', 'ú' => 'u',
		'ä' => 'a', 'ň' => 'n', 'ô' => 'o', 'ó' => 'o', 'ĺ' => 'l', 'ď' => 'd',
		'Ľ' => 'l', 'Š' => 's', 'Č' => 'c', 'Ť' => 't', 'Ž' => 'z',
		'Ý' => 'y', 'Á' => 'a', 'Í' => 'i', 'É' => 'e', 'Ú' => 'u',
		'Ä' => 'a', 'Ň' => 'n', 'Ô' => 'o', 'Ó' => 'o', 'Ĺ' => 'l',
		'ě' => 'e', 'ö' => 'o', 'Ď' => 'd', 'ř' => 'r', 'ŕ' => 'r',
		'Ŕ' => 'r', 'ů' => 'u', 'Ř' => 'r', 'Ě' => 'e',
		'ü' => 'u', 'Ü' => 'u',
		'ß' => 'ss',
		'&.+?;' => '',
		'[^\w\d _-]' => '',
		'\s+' => $separator,
		'(' . $q_separator . ')+' => $separator
	);

	$str = strip_tags($str);
	foreach ($trans as $key => $val) {
		$str = preg_replace('#' . $key . '#i' . (UTF8_ENABLED ? 'u' : ''), $val, $str);
	}

	$str = trim($str, $separator);

	// Vždy vráť malé písmená
	return strtolower($str);
}



function obrpridajthumb($vstup = false) {
	if ($vstup) {
		$urlimgthumb = explode('.', $vstup);
		$urlimgthumb = ($urlimgthumb[0]) . '_thumb' . '.' . ($urlimgthumb[1]);
		return $urlimgthumb;
	} else {
		return false;
	}
}

if (!function_exists('checkTextIcon')) {
	function checkTextIcon($value = '') {
		if (!empty(trim($value))) {
			return '<i style="color: green; font-weight: bold; font-size: 17px" class="fa fa-check color_green"></i>';
		} else {
			return '<i style="color: red; font-weight: bold; font-size: 17px" class="fa fa-times trash_icon_color"></i>';
		}
	}
}
?>

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

function getMenu()
{
	$ci = get_instance();
	$language = language();

	$ci->db->select('id, name, url, lang, parent, base');
	$ci->db->where('active', '1');
	$ci->db->where('lang', $language);
	$ci->db->order_by('orderBy', 'ASC');
	$mainMenuItems = $ci->db->get('menu')->result();

	$ci->db->select('id, name, url, lang, parent, base');
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
			'base' => $mainItem->base,
			'children' => array(),
			'has_child' => false,
			'is_external' => $isExternal
		);

		foreach ($subMenuItems as $subKey => $subItem) {
			if ($mainItem->id == $subItem->parent) {
				$subUrl = empty($subItem->url) ? '' : $subItem->url;
				$isSubExternal = (strpos($subUrl, 'http://') === 0 || strpos($subUrl, 'https://') === 0);

				if (!$isSubExternal && strpos($subUrl, $language . '/') === false) {
					$subUrl = $language . '/' . ltrim($subUrl, '/');
				}

				$formattedMenu[$mainKey]['children'][$subKey] = array(
					'name' => $subItem->name,
					'url' => $subUrl,
					'lang' => $subItem->lang,
					'base' => $subItem->base,
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
			echo 'Nicht vorhanden!';
		}
	} else {
		$user = $CI->ion_auth->user()->row();
		return $user->first_name . ' ' . $user->last_name . ' <br>' . $user->email . ' <br>' . $user->phone;
	}
}

function uploadImg($file = false, $dir = false, $saveAsNameFile = false, $resizeImage = false, $watermark = false)
{
	unset($_FILES['files']);
	$CI =& get_instance();
	$CI->load->library('image_lib');

	if ($dir === false) {
		$dir = 'uploads/';
	} else {
		$dir = rtrim($dir, '/') . '/';
	}

	if (!is_dir($dir)) {
		if (!mkdir($dir, 0755, true)) {
			return false;
		}
	}

	if (!is_writable($dir)) {
		return false;
	}

	if (empty($_FILES[$file]['name'])) {
		return '';
	}

	$tmpName = $_FILES[$file]['tmp_name'];
	if (isset($tmpName) && is_string($tmpName) && file_exists($tmpName)) {
		$originalName = pathinfo($_FILES[$file]['name'], PATHINFO_FILENAME);
		$extension = pathinfo($_FILES[$file]['name'], PATHINFO_EXTENSION);

		$baseName = $saveAsNameFile
			? trim(url_oprava($saveAsNameFile))
			: trim(url_oprava($originalName)) . '_' . time();

		$originalPath = $dir . $baseName . '.' . $extension;

		if (in_array(strtolower($extension), array('jpg', 'jpeg', 'png', 'gif', 'webp')) && is_uploaded_file($tmpName)) {
			if (strtolower($extension) === 'jpg' || strtolower($extension) === 'jpeg') {
				$exif = @exif_read_data($tmpName);
				if ($exif !== false && !empty($exif['Orientation'])) {
					$image = imagecreatefromjpeg($tmpName);
					switch ($exif['Orientation']) {
						case 3:
							$image = imagerotate($image, 180, 0);
							break;
						case 6:
							$image = imagerotate($image, -90, 0);
							break;
						case 8:
							$image = imagerotate($image, 90, 0);
							break;
					}
					imagejpeg($image, $tmpName, 100);
					imagedestroy($image);
				}
			}

			if (move_uploaded_file($tmpName, $originalPath)) {
				$result = $originalPath;
				if ($resizeImage) {
					$configi['image_library'] = 'gd2';
					$configi['source_image'] = $originalPath;
					$configi['create_thumb'] = FALSE;
					$configi['maintain_ratio'] = TRUE;
					$configi['master_dim'] = 'width';
					$configi['max_size'] = '0';
					$configi['quality'] = "70%";
					$configi['width'] = 1600;
					$configi['height'] = 1600;
					$CI->image_lib->initialize($configi);
					$CI->image_lib->resize();
					if ($watermark == true) {
						$configw['wm_type'] = 'overlay';
						$configw['wm_overlay_path'] = APP_PATH . '/' . LOGO_PNG;
						$configw['wm_opacity'] = '50';
						$configw['wm_vrt_alignment'] = 'bottom';
						$configw['wm_hor_alignment'] = 'right';
						$configw['wm_padding'] = '-20';
						$CI->image_lib->initialize($configw);
						$CI->image_lib->watermark();
					}
				}
				return $result;
			} else {
				return '';
			}
		} else {
			return '';
		}
	}

	return '';
}

function obrazokfinal($originalPath, $offLogo = true, $thumbPath = null, $defaultWidthImage = 1600)
{
	$CI =& get_instance();
	$CI->load->library('image_lib');

	if ($originalPath && file_exists($originalPath)) {
		$configi['image_library'] = 'gd2';
		$configi['source_image'] = $originalPath;
		$configi['create_thumb'] = FALSE;
		$configi['maintain_ratio'] = TRUE;
		$configi['master_dim'] = 'width';
		$configi['max_size'] = '0';
		$configi['quality'] = "70%";
		$configi['width'] = $defaultWidthImage;
		$configi['height'] = $defaultWidthImage;

		$CI->image_lib->initialize($configi);
		$CI->image_lib->resize();

		if ($offLogo == true) {
			$configw['wm_type'] = 'overlay';
			$configw['wm_overlay_path'] = APP_PATH . '/' . LOGO_PNG;
			$configw['wm_opacity'] = '50';
			$configw['wm_vrt_alignment'] = 'bottom';
			$configw['wm_hor_alignment'] = 'right';
			$configw['wm_padding'] = '-20';
			$CI->image_lib->initialize($configw);
			$CI->image_lib->watermark();
		}

		if ($thumbPath) {
			$config['image_library'] = 'gd2';
			$config['source_image'] = $originalPath;
			$config['new_image'] = $thumbPath;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 500;
			$config['height'] = 400;

			$CI->image_lib->initialize($config);
			$CI->image_lib->resize();
		}
	}

	return ['original' => $originalPath, 'thumb' => $thumbPath];
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
		'"' => '',
		'ľ' => 'l', 'š' => 's', 'č' => 'c', 'ť' => 't', 'ž' => 'z', 'ý' => 'y', 'á' => 'a', 'í' => 'i', 'é' => 'e', 'ú' => 'u',
		'ä' => 'ae', 'ň' => 'n', 'ô' => 'o', 'ó' => 'o', 'ĺ' => 'l', 'ď' => 'd',
		'Ľ' => 'l', 'Š' => 's', 'Č' => 'c', 'Ť' => 't', 'Ž' => 'z', 'Ý' => 'y', 'Á' => 'a', 'Í' => 'i', 'É' => 'e', 'Ú' => 'u',
		'Ä' => 'ae', 'Ň' => 'n', 'Ô' => 'o', 'Ó' => 'o', 'Ĺ' => 'l', 'Ď' => 'd',
		'ě' => 'e', 'ö' => 'oe', 'Ö' => 'oe', 'ü' => 'ue', 'Ü' => 'ue',
		'ř' => 'r', 'ŕ' => 'r', 'Ŕ' => 'r', 'ů' => 'u', 'Ř' => 'r', 'Ě' => 'e', 'à'=> 'a',
		'&.+?;' => '', '[^\w\d _-]' => '', '\s+' => $separator, '(' . $q_separator . ')+' => $separator
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

if (!function_exists('remove_diacritics')) {
	function remove_diacritics($string) {
		$trans = array(
			'á' => 'a', 'ä' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e',
			'í' => 'i', 'ľ' => 'l', 'ň' => 'n', 'ó' => 'o', 'ô' => 'o', 'ŕ' => 'r',
			'š' => 's', 'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ý' => 'y', 'ž' => 'z',
			'Á' => 'A', 'Ä' => 'A', 'Č' => 'C', 'Ď' => 'D', 'É' => 'E', 'Ě' => 'E',
			'Í' => 'I', 'Ľ' => 'L', 'Ň' => 'N', 'Ó' => 'O', 'Ô' => 'O', 'Ŕ' => 'R',
			'Š' => 'S', 'Ť' => 'T', 'Ú' => 'U', 'Ů' => 'U', 'Ý' => 'Y', 'Ž' => 'Z',
			'ü' => 'u', 'Ü' => 'U', 'ö' => 'o', 'Ö' => 'O', 'ß' => 'ss', 'à' => 'a'
		);
		return strtr($string, $trans);
	}
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

if (!function_exists('checkDateOrIcon')) {
	function checkDateOrIcon($value = '') {
		$value = trim($value);

		if (!empty($value)) {
			$date = date('d.m.Y', strtotime($value));
			return '<span>' . $date . ' </span>';
		} else {
			return '<i class="fa fa-times" style="color: red; font-weight: bold; font-size: 17px"></i>';
		}
	}
}
if (!function_exists('purify_html')) {
	function purify_html($dirty_html) {
		require_once FCPATH . 'vendor/autoload.php';
		$config = HTMLPurifier_Config::createDefault();
		// Povolené základné značky a obrázky:
		$config->set('HTML.Allowed', 'p,b,strong,i,u,ul,ol,li,br,a[href],img[src|alt|width|height]');
		$purifier = new HTMLPurifier($config);
		return $purifier->purify($dirty_html);
	}
}
if (!function_exists('remove_empty_tags')) {
	function remove_empty_tags($html) {
		// Odstráni prázdne <b>, <i>, <u>, <p> tagy (aj tie s whitespacom alebo &nbsp;)
		return preg_replace([
			'/<([biup])>(\s|&nbsp;)*<\/\1>/i',    // <b></b>, <i></i>, <u></u>, <p></p>
			'/<p>(\s|&nbsp;)*<\/p>/i',            // prázdne <p>
		], '', $html);
	}
}
if (!function_exists('clean_input_text')) {
	function clean_input_text($text) {
		$text = purify_html($text); // Existujúce čistenie
		$text = remove_empty_tags($text);
		// Pridaj extra čistenie pre Word artefakty
		$text = preg_replace('/<o:p>.*?<\/o:p>/i', '', $text);
		$text = preg_replace('/mso-[\w-]+/i', '', $text);
		$text = preg_replace('/(&nbsp;){3,}/i', ' ', $text);
		return trim($text);
	}
}
if (!function_exists('remove_empty_tags')) {
	function remove_empty_tags($html) {
		// Odstráni prázdne <b>, <i>, <u>, <p> tagy (aj tie s whitespacom alebo  )
		$html = preg_replace([
			'/<([biup])>(\s| )*<\/\1>/i',    // <b></b>, <i></i>, <u></u>, <p></p>
			'/<p>(\s| )*<\/p>/i',            // prázdne <p>
		], '', $html);
		// Nové: Normalizuj whitespace, odstráň \r a nadmerné medzery
		$html = str_replace("\r", '', $html);
		$html = preg_replace('/\s+/', ' ', $html);
		$html = trim($html);
		return $html;
	}
}
?>

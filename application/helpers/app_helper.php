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
	function langInfo($lang = false){

		if($lang == 'sk'){

			$info = array(
				'text' => 'Slovensky',
				'flag' => BASE_URL.'img/flag/png/slovak.png'
			);
			return $info;

		} elseif ($lang == 'en') {
			$info = array(
				'text' => 'Anglicky',
				'flag' => BASE_URL . 'img/flag/svg/us.svg'
			);
			return $info;
		} elseif ($lang == 'de'){
			$info = array(
				'text' => 'Nemecky',
				'flag' => BASE_URL.'img/flag/svg/german.svg'
			);
			return $info;

		} else {
			echo 'chyba';
		}

	}

	if ( ! function_exists('lang'))
{
	/**
	 * Lang
	 *
	 * Fetches a language variable and optionally outputs a form label
	 *
	 * @param	string	$line		The language line
	 * @param	string	$for		The "for" value (id of the form element)
	 * @param	array	$attributes	Any additional HTML attributes
	 * @return	string
	 */
	function lang($line, $for = '', $attributes = array())
	{
		$line = get_instance()->lang->line($line);

		if ($for !== '')
		{
			$line = '<label for="'.$for.'"'._stringify_attributes($attributes).'>'.$line.'</label>';
		}

		return $line;
	}
}

	function getCurrentUrl() {
	return current_url(); // Alebo iná metóda, ktorá získava aktuálnu URL
}

	function getMenu() {
	$ci = get_instance();

	$ci->db->select('*');
	$ci->db->where('active', '1');
	$ci->db->where('lang', language());
	$ci->db->order_by('orderBy', 'ASC');
	$mainMenuItems = $ci->db->get('menu')->result();

	$ci->db->select('*');
	$ci->db->where('parent !=', '0');
	$ci->db->where('active', '1');
	$ci->db->where('lang', language());
	$ci->db->order_by('orderBy', 'ASC');
	$subMenuItems = $ci->db->get('menu')->result();

	$formattedMenu = array();
	foreach ($mainMenuItems as $mainKey => $mainItem) {
		if ($mainItem->parent) continue;

		$url = empty($mainItem->url) ? '' : $mainItem->url;
		$isExternal = (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0);

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

				$formattedMenu[$mainKey]['children'][$subKey] = array(
					'name' => $subItem->name,
					'url' => $isSubExternal ? $subUrl : url_oprava($mainItem->name) . '/' . $subUrl,
					'lang' => $subItem->lang,
					'is_external' => $isSubExternal
				);

				$formattedMenu[$mainKey]['has_child'] = true;
			}
		}
	}

	return $formattedMenu;
}


	function activeToIcon($value){


		if ($value == '0'){
			return '<i class="fa fa-times trash_icon_color" title="Neaktívne"></i>';
		} else {
			return '<i class="fa fa-check color_green" title="Aktívne"></i>';
		}

	}

	function redirectIfEmpty($data = false,$urlRedirect = 'admin',$chybovaHlaska = 'Chyba!'){

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


	unset($_FILES['files']); // toto musim doriešiť -- je tu input z aummernote

	$CI = & get_instance();
	$CI->load->library('image_lib');
	if ($dir == false){
		$dir = 'uploads/';
		if (!is_dir($dir) ? mkdir( $dir, 0755) : '');
	} else {
		if (!is_dir($dir) ? mkdir( $dir, 0755) : '');
		$dir = $dir.'/';
	}
	if ( $saveAsNameFile == false) { $saveAsNameFile = 'img';}
	if (count($_FILES) > 1){ // je vo FILES viac obrázkov?

		$data = array();
		$name = $CI->input->post('name');
		if (!empty($name)){
			if ($file == false){
				if (!$name){
					$file = 'file';
				} else {
					$file = $name;
				}

			} else {
				$file = 'img';
			}
		} else {
			$file = 'img';
		}
		foreach ($_FILES as $k => $f){ // Názov inputu file v dokumente tu je $k

			if (file_exists($_FILES[$k]['tmp_name'])){ // existuje obrázok pod danám inputom? spracuj ho / inak zapis prazdne pole
				$nazovAkoURL = trim(url_oprava($file));
				$typ = explode('.',$_FILES[$k]["name"]);
				$typ = $typ[count($typ) - 1];
				$urlimg = $dir.$nazovAkoURL.'-'.uniqid().'.'.$typ;
				if(in_array($typ, array('jpg', 'jpeg', 'png', 'gif')))
					if (is_uploaded_file($_FILES[$k]["tmp_name"]))
						if (move_uploaded_file($_FILES[$k]["tmp_name"], $urlimg));



				if ($resizeImage == true){
					$data[$k] = obrazokfinal($urlimg,$watermark);
				} else {
					$data[$k] = $urlimg;
				}



			} else {
				$data[$k] = '';
			}
		}
		return $data; // vraciam hodnoty ako nazov inputu file z formulara a pod nim je adresa k suboru s priecinkom
	} else {


		if (empty($_FILES[$file]['name'])){
//                dd($_FILES);
			return '';
		}

		$nazovAkoURL = trim(url_oprava($saveAsNameFile));
		$typ = explode('.',$_FILES[$file]["name"]);
		$typ = $typ[count($typ) - 1];
		$urlimg = $dir.$nazovAkoURL.'-'.uniqid().'.'.$typ;
		if(in_array($typ, array('jpg', 'jpeg', 'png', 'gif','webp')))
			if (is_uploaded_file($_FILES[$file]["tmp_name"]))
				if (move_uploaded_file($_FILES[$file]["tmp_name"], $urlimg));

		if ($resizeImage == true){
			$urlimg = obrazokfinal($urlimg,$watermark);
		}

		return $urlimg;
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
//            $configw['wm_overlay_path'] = APP_PATH.'/img/radvarim-logo145.png';
			$configw['wm_overlay_path'] = APP_PATH.'/'.LOGO_PNG;
			$configw['wm_opacity'] = '50';
			$configw['wm_vrt_alignment'] = 'bottom';
			$configw['wm_hor_alignment'] = 'right';
			$configw['wm_padding'] = '-20';
			$CI->image_lib->initialize($configw);
			$CI->image_lib->watermark();
		}
	}
	// pridá malý obrázok
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

	function active($option) {
	if ($option == '0'){
		return '<i style="color: red" class="fa fa-times trash_icon_color"></i>';
	}else{
		return '<i style="color: green" class="fa fa-check color_green"></i>';
	}
}




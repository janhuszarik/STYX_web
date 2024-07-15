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

function myName(){

	$CI = get_instance();
	$user = $CI->ion_auth->user()->row();
	$myname = $user->first_name.'&nbsp;'.$user->last_name;

	echo $myname;
}


function language(){


	$CI = get_instance();
	$lang = $CI->config->config['language'];
	return $CI->config->config['languages'][$lang];

}
function string_replaceToDb($string){

	$string = str_replace("'",'&#039;',$string);
	$string = str_replace('"','&#34;',$string);
	$string = str_replace('%','&percnt;',$string);
	return $string;

}

function getNameCategory($catID){

	$CI = get_instance();
	$CI->db->select('*');
	$CI->db->where('id',$catID);
	return $CI->db->get('categoryArticles')->row();


}

function getNameParent($parent){

	$CI = get_instance();
	$CI->db->select('*');
	$CI->db->where('id',$parent);
	return $CI->db->get('menu')->row();


}
function getLanguages(){
	$ci = get_instance();

	return $ci->config->config['languages'];

}

function activeOrNot($active){

	if ($active == 'on'){ // z inputu máme výsledok 'on' | NULL
		return '1';
	} else {
		return '0';
	}
}

function getMenu(){

	$ci = get_instance();


	$ci->db->select('*');
	$ci->db->where('active', '1');
	$ci->db->where('lang', language());  // Pridanie podmienky na filtrovanie podľa jazyka
	$ci->db->order_by('orderBy', 'ASC');
	$menu = $ci->db->get('menu')->result();

	// Získanie podmenu
	$ci->db->select('*');
	$ci->db->where('parent !=', '0');
	$ci->db->where('active', '1');
	$ci->db->where('lang', language());  // Pridanie podmienky na filtrovanie podľa jazyka
	$ci->db->order_by('orderBy', 'ASC');
	$parent = $ci->db->get('menu')->result();

	$ok = array();
	foreach ($menu as $key => $m){
		if ($m->parent){
			continue;
		}

		if (!empty($m->article)){
			if (is_numeric($m->article)){
				$ci = get_instance();
				$ci->db->select('id,url');
				$ci->db->where('id', $m->article);
				$articleUrlId = $ci->db->get('articles')->row();

				$url = $articleUrlId->url;
			}
		} elseif (empty($m->article) && empty($m->url)){
			$url = '';
		} else {
			$url = $m->url;
		}

		$ok[$key]['name'] = $m->name;
		$ok[$key]['url'] = $url;
		$ok[$key]['lang'] = $m->lang;

		foreach ($parent as $k => $p){
			if (!empty($p->article)){
				$ci->db->select('id,name,url');
				$ci->db->where('id', $p->article);
				$aricle = $ci->db->get('articles')->row();

				$url = $aricle->url;
			} elseif (empty($p->article) && empty($p->url)){
				$url = '';
			} else {
				$url = $p->url;
			}

			if ($m->id == $p->parent){
				$ok[$key]['parent'][$k]['name'] = $p->name;
				$ok[$key]['parent'][$k]['url'] = url_oprava($m->name) . '/' . $url;
				$ok[$key]['parent'][$k]['lang'] = $p->lang;
			}
		}
	}

	return $ok;
}




function getAccess($id = false){
	$ci = get_instance();

	if ($id){
		return $ci->db->select('*')->where('id',$id)->get('access')->row();
	} else {
		return $ci->db->select('*')->get('access')->result();
	}


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

function getStatus($isActive) {
	if ($isActive == '1') {
		return "<strong style='color: limegreen;'>aktiv</strong>";
	} elseif ($isActive == '2') {
		return "<strong style='color: #e0e500;'>Urlaub</strong>";
	}elseif ($isActive == '3') {
		return "<strong style='color: #ea6c04;'>Krankenstand</strong>";
	}elseif ($isActive == '4') {
		return "<strong style='color: #007afe;'>Frei | ZA</strong>";
	} else {
		return "<strong style='color: orangered;'>nicht aktiv</strong>";
	}
}

function getYes($isActive) {
	if ($isActive == '1') {
		return "<strong style='color: limegreen;'>JA</strong>";
	} else {
		return "<strong style='color: orangered;'>NEIN</strong>";
	}
}

function getNationality($isActive){
	if ($isActive == '0') {
		return "<strong>Österreich</strong>";
	} elseif($isActive == '1')  {
		return "<strong>Deutschland</strong>";
	}elseif($isActive == '2')  {
		return "<strong>Slowakei</strong>";}
	elseif($isActive == '3')  {
		return "<strong>Türkei</strong>";}
	elseif($isActive == '4')  {
		return "<strong>Czechien</strong>";}
	elseif($isActive == '5')  {
		return "<strong>Ungarn</strong>";}
	elseif($isActive == '6')  {
		return "<strong>Swizerland</strong>";}
	elseif($isActive == '7')  {
		return "<strong>Italien</strong>";}
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

//------------------------------------------------------------------------------------------------------------------------------------------
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

function meniny(){

	date_default_timezone_set('Europe/Berlin');

	$dny["Mon"] = "Montag";

	$dny["Tue"] = "Dienstag";

	$dny["Wed"] = "Mittwoch";

	$dny["Thu"] = "Donnerstag";

	$dny["Fri"] = "Freitag";

	$dny["Sat"] = "Samstag";

	$dny["Sun"] = "Sonntag";

	$mesice = array(1=>

		"Januar",

		"Februar",

		"März",

		"April",

		"May",

		"Juni",

		"Juli",

		"August",

		"September",

		"Oktober",

		"November",

		"Dezember");

	$dnes = $dny[Date("D")] . Date(" d.") .

		$mesice[(int)Date("m")] . Date(" Y");


	$sviatky=array

	(

		'Neujahr',
		'Basilius',
		'Genoveva',
		'Angela',
		'Emilie',
		'Heilige 3 Könige',
		'Raimund v. P.',
		'Severin/Erhard',
		'Julian/Eberhard',
		'Gregor X.',
		'Taufe Jesu',
		'Ernst',
		'Jutta', 'Gottfried',
		'Felix v. N.',
		'Gabriel v. F.',
		'Theobald',
		'Antonius',
		'Regina',
		'Marius/Mario',
		'Fabian/Sebastian',
		'Agnes',
		'Vinzenz/Walter',
		'Heinrich S.',
		'Franz v. S.',
		'Pauli Bekehrung',
		'Timotheus/Titus',
		'Angela M.',
		'Thomas v. A.',
		'Valerius',
		'Martina',
		'Johannes Bosco',
		'Brigitta v. K.',
		'Mariä Lichtmess',
		'Blasius',
		'Andreas C.',
		'Agatha',
		'Dorothea',
		'Richard K.',
		'Hieronymus',
		'Apollonia/Erich',
		'Wilhelm d. Gr.',
		'Theodor',
		'Reginald',
		'Gerlinde',
		'Valentin',
		'Siegfried',
		'Philippa',
		'Alexius',
		'Konstantia',
		'Bonifatius',
		'Leo d. W.',
		'Petrus Dam.',
		'Petri Stuhlfeier',
		'Romana',
		'Mathias',
		'Walpurga',
		'Alexander',
		'Leander/Gabriel',
		'Roman',
		'Albin/Rüdiger',
		'Karl/Agnes',
		'Friedrich',
		'Kasimir',
		'Gerda/Diemar',
		'Coletta/Fridolin',
		'Reinhard',
		'Johannes v. G.',
		'Franziska v. R.',
		'Emil/Gustav',
		'Theresia R.',
		'Maximilian',
		'Gerald/Paulina',
		'Mathilde',
		'Klemens M. H.',
		'Hilarius v. A.',
		'Getrud',
		'Eduard',
		'Josev/Nährv. Jesu',
		'Claudia/Irmgard',
		'Alexandra',
		'Lea/Elmar',
		'Otto v. A.',
		'Katharina v. Schw.',
		'Verkündung des Herrn',
		'Emmanuel',
		'Frowin/Haimo',
		'Johanna v. M.',
		'Berthold v. K.',
		'Amadeus v. S.',
		'Cornelia',
		'Hugo/Irene',
		'Sandra',
		'Richard',
		'Isidor',
		'Vinzenz Ferr.',
		'Sixtus I. Cölestin',
		'Johann Bapt. de la Salle',
		'Walter/Beate',
		'Waltraud',
		'Engelbert v. A.',
		'Stanislaus',
		'Julius/Hertha',
		'Martin I./Ida v B.',
		'Tiburtius',
		'Waltmann',
		'Bernadette',
		'Eberhard',
		'Aja Apollonius',
		'Leo IX./Gerold',
		'Simon v. T.',
		'Konrad v. P./Anselm',
		'Wolfhelm',
		'Georg/Gerhard',
		'Wilfried',
		'Markus/Erwin/Ev.',
		'Trudpert',
		'Petrus Can.',
		'Ludwig v. M.',
		'Roswitha',
		'Hildegard',
		'',
		'Athanasius/Boris',
		'Philipp/Jakob',
		'Florian',
		'Gotthard',
		'Valerian',
		'Gisela',
		'Ida/Désiré',
		'Volkmar',
		'Antonin',
		'Gangolf',
		'Pankratius',
		'Servatius',
		'Bonifatius',
		'Rupert/Sophie',
		'Johannes',
		'Walter/Pascal',
		'Erich',
		'Cölestin V./Ivo',
		'Elfriede',
		'Hermann/Josef',
		'Rita/Julia',
		'Renate',
		'Vinzenz/Dagmar',
		'Gregor VII.',
		'Philip N.',
		'Augustin v. C.',
		'Wilhelm',
		'Maximin',
		'Ferdinand',
		'Petronilla/Aldo',
		'Konrad/Silke',
		'Armin/Eugen',
		'Karl L./Silvia',
		'Franz C./Klothilde',
		'Bonifaz',
		'Norbert',
		'Robert',
		'Medardus/Ilga',
		'Ephräm/Gratia',
		'Heinrich v. B./Diana',
		'Barnabas/Alice',
		'Leo III./Johann v. S. F.',
		'Antonius v. P.',
		'Burkhard/Gottschalk',
		'Vitus/Veit',
		'Benno v. M.',
		'Rainer/Adolf v. M.',
		'Markus/Marcellianus',
		'Juliana v. F.',
		'Adalbert/Florentina',
		'Aloisius v. G.',
		'Thomas M.',
		'Edeltraud',
		'Johannes der Täufer',
		'Dorothea/Eleonore',
		'Johann/Paul',
		'Cyrill v. A./Harald',
		'Irenäus/Diethild',
		'Peter/Paul/Judith',
		'Otto/Ernst v. P.',
		'Theobald',
		'Mariä, Heimsuchung',
		'Thomas/Raimund',
		'Elisabeth v. P.',
		'Anton M. Zacc.',
		'Maria Goretti',
		'Willibald',
		'Eugen III./Edgar K.',
		'Gottfried/Veronika',
		'Knud/Engelbert',
		'Benedikt v. N./Oliver',
		'Nabor/Felix',
		'Heinrich II.',
		'Roland',
		'Egon/Balduin',
		'Maria v. B. K./Carmen',
		'Alexius',
		'Friedrich/Arnold',
		'Justa/Bernulf',
		'Margareta',
		'Daniel',
		'Maria Magdalena',
		'Brigitta',
		'Christophorus',
		'Jakob/Thea/Ap.',
		'Anna/Joachim',
		'Rudolf A.',
		'Samuel/Viktor',
		'Martha/Lucilla',
		'Ingeborg',
		'Ignatius v. L.',
		'Alfons v. L.',
		'Eusebius v. V./Stefan',
		'Lydia/Benno v. E.',
		'Johannes M. V./Rainer',
		'Oswald/Dominika',
		'Christi Verklärung',
		'Albert',
		'Dominikus/Gustav',
		'Edith',
		'Laurentius/Astrid',
		'Klara/Susanna',
		'Hilaria',
		'Gertrud v. A./Marco',
		'Maximilian',
		'Mariä Himmelfahrt',
		'Stefan v. U./Theodor',
		'Hyazinth',
		'Helene/Claudia',
		'Emilia B.',
		'Bernhard v. Cl.',
		'Pius X.',
		'Regina/Siegfried A.',
		'Rosa v. L./Philipp B.',
		'Isolde/Michaela',
		'Ludwig IX./Patricia',
		'Margareta v. F.',
		'Monika',
		'Augustin',
		'Sabine/Beatrix v. A.',
		'Herbert v. K./Felix',
		'Raimund N.',
		'Verena/Ruth',
		'René/Ingrid',
		'Gregor d. Gr.',
		'Rosalia/Ida',
		'Laurentius/Albert',
		'Magnus/Beata',
		'Regina/Ralph',
		'Mariä Geburt',
		'Grogonius',
		'Nikolaus v. T./Diethard',
		'Helga',
		'Eberhard/Guido',
		'Tobias',
		'Kreuz-Erhöhung',
		'Dolores/Melitta',
		'Ludmilla/Edith',
		'Robert B./Lambert',
		'Josef v. C.',
		'Wilma/Arnulf',
		'Fausta/Candida',
		'Matthäus',
		'Moritz',
		'Helene D./Thekla',
		'Rupert v. S.',
		'Nikolaus v. Fl.',
		'Eugenia',
		'Vinzenz v. P.',
		'Wenzel v. B./Dietmar',
		'Michael/Gabriel',
		'Hieronymus',
		'Theresia v. K. J.',
		'Schutzengelfest',
		'Ewald/Udo',
		'Franz v. Assisi/Edwin',
		'Attila/Placidus',
		'Bruno d. Karth.',
		'Markus I.',
		'Simeon',
		'Dionysius',
		'Viktor v. X.',
		'Bruno v. K.',
		'Maximilian/Horst',
		'Eduard',
		'Burkhard',
		'Theresia v. A.',
		'Hedwig',
		'Ignatuis v. A./Rudolf',
		'Lukas',
		'Paul v. Kr./Frieda',
		'Wendelin',
		'Ursula',
		'Kordula',
		'Oda',
		'Anton M. Cl.',
		'Krispin',
		'Nationalfeiertag',
		'Wolfhard',
		'Simon/Judas/Thadd.',
		'Hermelindis',
		'Alfons Rodr.',
		'Wolfgang/Christoph',
		'Allerheiligen',
		'Allerseelen',
		'Hubert/Silvia',
		'Karl Borr.',
		'Emmerich',
		'Christina d. K.',
		'Engelbert',
		'Gottfried',
		'Theodor',
		'Leo d. Gr./Andreas Av.',
		'Martin v. T.',
		'Emil/Christian',
		'Eugen',
		'Alberich',
		'Leopold von Österreich',
		'Othmar/Edmund',
		'Gertrud/Hilda',
		'Odo/Roman',
		'Elisabeth von Th.',
		'Edmund K.',
		'Gelasius I.',
		'Cäcilia',
		'Klemens I./Felicitas',
		'Chrysogonus/Flora',
		'Katharina v. A.',
		'Konrad',
		'Oda/Modestus',
		'Gunther/Stephan d. J.',
		'Friedrich v. R.',
		'Andreas',
		'Blanka, Natalie',
		'Bibiana',
		'Franz, Xaver',
		'Barbara',
		'Gerald',
		'Nikolaus v. M.',
		'Ambrosius',
		'Mariä Empfängnis',
		'Valerie',
		'Diethard',
		'David/Daniel',
		'Johanna F. v. Ch.',
		'Lucia/Ottilie',
		'Franziska',
		'Christiana/Nina',
		'Adelheid',
		'Lazarus/Jolanda',
		'Gatian',
		'Urban V.',
		'Eugen v. A.',
		'Ingomar',
		'Jutta/Marian',
		'Victoria',
		'Heiliger Abend',
		'Christtag',
		'Stefanitag',
		'Johannes',
		'Unschuldige/Kinder',
		'Thomas B./Tamara',
		'Hermine',
		'Silvester',

	);

	$d=getdate();

	$yday=$d["yday"];

	if (($yday>58) && ((date("Y")%4)!=0)) $yday++;

	$sviatok_dnes=$sviatky[$yday];

	if (($yday==58) && ((date("Y")%4)!=0)) $yday++;

	$sviatok_zajtra=$sviatky[$yday%366+1];
	return   "<b>$dnes. " . "</b>" . " &nbsp Sein Namenstag ist heute &nbsp " . "<b>" . $sviatok_dnes . "</b>" . ", und Morgen &nbsp " . "<b>" . $sviatok_zajtra . "</b>";
}


function diff($date1, $date2){
	$date1=date_create($date1);
	$date2=date_create($date2);
	$diff=date_diff($date1,$date2);
	// prirátam 1 den. Príklad od 1.1.2019 do 20.1.2019 by vyrátalo 19 dní... nepočíta to s posledným dňom
	$diff = ($diff->format("%a") + 1);
	return $diff;

}

//function noImage($image){
//
//	if(!empty($image)){
//		return '<img src="'.BASE_URL.$image.'" width="31px" alt="img" />';
//	} else {
//		return '<img src="'.BASE_URL.'assets/images/noimage.svg" width="31px" alt="img" />';
//	}
//}

function calculatePercentage($oldFigure = 0, $newFigure = 0){
	if (!empty($oldFigure) && !empty($newFigure)){
		$percentChange = (($oldFigure - $newFigure) / $oldFigure) * 100;
		return round(abs($percentChange)).'&nbsp%';
	} else {
		return false;
	}

}


function active($option) {
	if ($option == '0'){
		return '<i style="color: red" class="fa fa-times trash_icon_color"></i>';
	}else{
		return '<i style="color: green" class="fa fa-check color_green"></i>';
	}
}
function access($option) {
	if ($option == '1'){
		return 'Všetci';
	}elseif ($option == '2'){
		return 'Len Prihlásený';
	}else{
		return 'Len Správca';
	}
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

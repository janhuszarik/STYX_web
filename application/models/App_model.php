<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class app_model extends CI_Model {



	function routes($lang){

		if ($this->uri->segment('2') == NULL){
			$url = $this->uri->segment('1');
		} else {
			$url = $this->uri->segment('2');
		}
		$this->db->select('*');
		$this->db->where('lang',$lang);
		$this->db->where('url',$url);
		$article = $this->db->get('articles')->row();

//        ddd($article);
		return $article;
	}

	function getUser($id = false){

		$this->db->select('*');
		$this->db->where('id',$id);
		return $this->db->get('users')->row();

	}


	public function getSliders($onlyActive = false,) {
		$this->db->select('*');
		if ($onlyActive) {
			$this->db->where('active', '1');
		}
		$this->db->where('lang', language());
		$this->db->order_by('orderBy', 'ASC'); // Sort by orderBy

		return $this->db->get('slider')->result();
	}


	function getNews(){

		$this->db->select('*');
		$this->db->where('active', '1');
		return $this->db->get('news')->row();

	}





    function getCategoryCoverings($url = false){
       
        if ($url == false){
            $this->db->select('ca.*, COUNT(a.category) as coveringsCount');
            $this->db->where('ca.active','1');
            $this->db->join('coverings as a','a.category = ca.id','left');
            $this->db->group_by('ca.id');
            
            return $this->db->get('categoryCoverings as ca')->result();
            
        } else { // vysledok na základe url kategorie
            $this->db->select('*');
            $this->db->where('active','1');
            $this->db->where('url',$url);
            $category = $this->db->get('categoryCoverings')->row();
            $category = (array)$category;
            // vysledok kategorie podla url
    
            $this->db->select('*');
            $this->db->where('active','1');
            $this->db->where('category',$category['id']);
            $coverings = $this->db->get('coverings')->result();
            
            // Pripájam k danej kategórii aj produkty
            $category['coverings'] = $coverings;
            
            return $category;
            
        }
        
        
    }
    
    function getCategoryCoveringsByUrl($url = false){
    
    
        $this->db->select('ca.*');
    
        $this->db->where('url',$url);
        $this->db->where('ca.active','1');
        $category = $this->db->get('categoryCoverings as ca')->row();
        
        
        
    }

    function newsletter(){

        $this->db->where('mail',$this->input->post('mail'));
        $this->db->get('newsletter');
        $affected = $this->db->affected_rows();
       if ($affected === 0){
           $data = array(
               'name'                   =>  $this->input->post('name'),
               'last_name'              =>  $this->input->post('last_name'),
               'mail'                   =>  $this->input->post('mail'),
               'active'                 =>  '1',
           );
           return $this->db->insert('newsletter',$data);
       } else {
           return 'exist';
       }

    }
    
    function getArticleByUrl($url = false,$segment2,$access = 1){
        
        if (!empty($segment2)){
            $url = $segment2;
        }
        
        
        $this->db->select('*');
        $this->db->where('url',$url);
        $this->db->where('active','1');
        $this->db->where('access',$access);
        return $this->db->get('articles')->row();
    }
//    function getArticleByUrl($url = false,$segment2,$access = 1){
//
//        if (!empty($segment2)){
//            $url = $segment2;
//        }
//
//
//        $this->db->select('*');
//        $this->db->where('url',$url);
//        $this->db->where('active','1');
//        $this->db->where('access',$access);
//        return $this->db->get('articles')->row();
//    }
//

    function addShowArticle($id,$show){

        $data = array(
            'shows' => (int)$show+1,
        );
        $this->db->where('id',$id);
        $this->db->update('articles',$data);
    }
    
    function hFormSave($image){
    
        $post = $this->input->post();
        
        
//        dd($image);
//        dd($_FILES);
//        dd($post);
        
        $data = array(
            'name'      => $post['name'],
            'adresa'    => $post['adresa'],
            'psc'       => $post['psc'],
            'mesto'     => $post['mesto'],
            'photo'     => $image,
            'email'     => $post['email'],
            'phone'     => $post['phone'],
            'plocha'    => $post['plocha'],
            'typ'       => $post['typ'],
            'stav'      => $post['stav'],
            'poznamka'  => $post['poznamka'],
            'doplnok'   => implode(',',$post['doplnok']),
        );
        
        return $this->db->insert('dopyt',$data);
    }
    
    function getGalleries($idGallery = false){
        
        $this->db->select('*');
        $this->db->where('active', '1');
        $gallery = $this->db->get('galleries')->result();
        $data = array();
        foreach ($gallery as $k => $g){
            
            $data[$k]['id'] = $g->id;
            $data[$k]['name'] = $g->name;
            $data[$k]['enname'] = $g->enname;
            $data[$k]['url'] = $g->url;
            $data[$k]['image'] = $g->image;
            $data[$k]['text'] = $g->text;
            $data[$k]['entext'] = $g->entext;
            
            $this->db->select('*');
            $this->db->where('category',$g->id);
            $data[$k]['photos'] = $this->db->get('photos')->result();
        }
        return $data;
        
    }
//    _____________________________________

	function getCategory($url = false){

		$this->db->select('*');
		$this->db->where('url',$url);
		return $this->db->get('category')->row();

	}

	function getCategoryListDoor($id = false){

		$this->db->select('d.*,c.name as cname,c.url as caturl,s.url as suburl,s.name as sname');
		$this->db->where('d.categorydoor',$id);
		$this->db->join('category as c', 'c.id = d.categorydoor');
		$this->db->join('subcategory as s', 's.id = d.subcategory');
		return $this->db->get('doors as d')->result();

	}

	function getsubCategoryListDoor($id = false){

		$this->db->select('d.*,c.name as cname,c.url as caturl,s.url as suburl,s.name as sname');
		$this->db->where('d.subcategory',$id);
		$this->db->join('category as c', 'c.id = d.categorydoor');
		$this->db->join('subcategory as s', 's.id = d.subcategory');
		return $this->db->get('doors as d')->result();

	}

	function getSubcategory($url = false){

		$this->db->select('*');
		$this->db->where('url',$url);
		return $this->db->get('subcategory')->row();

	}
	function getPosledneClanky(){


			$this->db->select('a.*, b.name');
			$this->db->from('clanky a');
			//zobraz vsetky clanky kde je id viac ako 1 / teda default

			$this->db->where('a.verejny', 'ano');
			$this->db->join('category b', 'b.id=a.category', 'left');

			$this->db->limit(3);
			$this->db->order_by('vytvorene', 'desc');


		$query = $this->db->get();
		return $query->result();
	}

	function sendMail(){

        $config['protocol']    = 'smtp';
        $config['smtp_crypto'] = 'ssl';
        $config['smtp_host']    = SMTP;
        $config['smtp_port']    = SMTP_PORT;
        //      $config['smtp_timeout'] = '7';
        $config['smtp_user']    = SMTP_NAME;
        $config['smtp_pass']    = SMTP_PASS;
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->from(MAIL_MODERATOR, DOMAIN);
        $this->email->to(MAIL_MODERATOR);
        $this->email->bcc(MAIL_ADMIN);


        $this->email->subject('Správa z WEBu: Od '.$this->input->post('username').' - '.$this->input->post('subject'));

//        $body = 'Záujem o: <strong>'.$this->input->post('sluzba').'</strong><br/>';
        $body .= 'Meno: <strong>'.$this->input->post('username').'</strong><br/>';
        $body .= 'Predmet: <strong>'.$this->input->post('subject').'</strong><br/>';
        $body .= 'Telefon: <strong>'.$this->input->post('phone').'</strong><br/>';
        $body .= 'Email: <strong>'.$this->input->post('email').'</strong><br/>';
//        $body .= 'Adresa: <strong>'.$this->input->post('address').'</strong><br/><br/>';
        $body .= 'Správa: <strong>'.$this->input->post('message').'</strong><br/>';
        $this->email->message($body);
        return $this->email->send();
    }

    function getCertivicateBySubUrl($urlSubcatogory){

	    $this->db->select('cer1,cer2,cer3,cer4');
	    $this->db->where('url',$urlSubcatogory);
        $sub = $this->db->get('subcategory')->row();
//        ddd($sub);
        $d0 = $this->getCertificateById($sub->cer1);
        $d1 = $this->getCertificateById($sub->cer2);
        $d2 = $this->getCertificateById($sub->cer3);
        $d3 = $this->getCertificateById($sub->cer4);
        $data = array();
        if ($d0){
            $data[] = $this->getCertificateById($sub->cer1);
        }
        if ($d1){
            $data[] = $this->getCertificateById($sub->cer2);
        }
        if ($d1){
            $data[] = $this->getCertificateById($sub->cer3);
        }
        if ($d1){
            $data[] = $this->getCertificateById($sub->cer4);
        }
        return $data ;


    }

    function getCertificateById($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        return $this->db->get('certificate')->row();
    }

    function getDoplnky($urlDoplnok = false){

	    if ($urlDoplnok){
            $this->db->select('*');
            $this->db->where('active', 'on');
            $this->db->where('url', $urlDoplnok);
            return $this->db->get('doplnky')->row();
        } else {
            $this->db->select('*');
            $this->db->where('active', 'on');
            return $this->db->get('doplnky')->result();
        }

    }

    function getOtherDoor($urlIdDoor,$subCategoryUrl){

	    $this->db->select('id,name,url');
	    $this->db->where('url',$subCategoryUrl);
	    $sub = $this->db->get('subcategory')->row();


	    $this->db->select('d.*,c.name as cname,c.url as caturl,s.url as suburl,s.name as sname');
	    $this->db->where('d.url !=',$urlIdDoor);
	    $this->db->where('d.subcategory',$sub->id);
        $this->db->join('category as c', 'c.id = d.categorydoor');
        $this->db->join('subcategory as s', 's.id = d.subcategory');
	    return $this->db->get('doors as d')->result();

    }
    
	function getDovernici(){
		$this->db->select('*');
		//treba pridat do db parameter aktivny/zobrazeny
		$this->db->where('access', '1');

		return $this->db->get('dovernici')->result();
	}
	
	function getAsistenti(){
		$this->db->select('*');
		//treba pridat do db parameter aktivny/zobrazeny
		$this->db->where('access', '1');

		return $this->db->get('asistenti')->result();
	}
	
	function getKategorie(){

		$this->db->select('*');
		//treba pridat do db parameter aktivny/zobrazeny
		$this->db->where('access', '1');
		return $this->db->get('category')->result();


	}
	
	function getVsetkyClanky($cat_id = false){

		if($cat_id){
			$this->db->select('a.*, b.name');
			$this->db->from('clanky a');
			//zobraz vsetky clanky kde je id viac ako 1 / teda default
			$this->db->where('a.category', $cat_id);
			$this->db->where('a.verejny', 'ano');
			$this->db->join('category b', 'b.id=a.category', 'left');
		} else {
			$this->db->select('a.*, b.name');
			$this->db->from('clanky a');
			$this->db->where('a.verejny', 'ano');
			//zobraz vsetky clanky kde je id viac ako 1 / teda default
			$this->db->where('category >=', '1');
			$this->db->join('category b', 'b.id=a.category', 'left');
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	function getArticle($art_id){
		$this->db->select('a.*, b.name');
		$this->db->from('clanky a');
		//zobraz vsetky clanky kde je id viac ako 1 / teda default
		$this->db->where('a.url_clanku', $art_id);
		$this->db->where('a.verejny', 'ano');
		$this->db->join('category b', 'b.id=a.category', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	

//	ASTANA
//    function getArticleByUrl($segment){
//
//    }



//_________________________________________________________________________________________________





	function getCounter(){

		$this->db->select('*');                            // Vyber všetky záznamy z databázy
		$this->db->where('id', 1);                        // Ktoré sú v riadku s id:1
		return $this->db->get('counter')->row();            // V tabuľke databázy s názvom "settings" a

	}

	function getAboutUs(){

		$this->db->select('*');                            // Vyber všetky záznamy z databázy
		$this->db->where('id', 1);

		return $this->db->get('aboutUs')->row();            // V tabuľke databázy s názvom "settings" a

	}
	function getGalleryByTestimonial(){
		$this->db->select('*');
		$this->db->where('category', 3);
		return $this->db->get('photos')->result();
	}
	function getGalleryByHome(){
		$this->db->select('*');
		$this->db->where('category', 4);
		return $this->db->get('photos')->result();
	}
	function getReview($id = false){


		if ($id == false) {
			$this->db->select('*');
			return $this->db->get('reviews')->result();

		} else {
			$this->db->select('*');
			$this->db->where('id', $id);
			return $this->db->get('reviews')->row();
		}
	}
	function userAll($post = false){
		$id = $this->input->post('id');

		if (!empty($post['id'])) {

			if (!empty($_FILES['image']['name'])) {
				$imageUrl = uploadImg('image', 'uploads', 'profilova_fotka', '800');
				if (!empty($post['oldImage'])) {
					unlink($post['oldImage']);
				}
			} else {
				$imageUrl = $post['oldImage'];
			}

			$data = array(

				'avatar' => $imageUrl,
				'username' => string_replaceToDb($this->input->post('username')),
				'email' => string_replaceToDb($this->input->post('email')),
				'first_name' => string_replaceToDb($this->input->post('first_name')),
				'last_name' => string_replaceToDb($this->input->post('last_name')),
				'phone' => string_replaceToDb($this->input->post('phone')),
				'user_id' => $this->ion_auth->user()->row()->id,
				'birth' => string_replaceToDb($this->input->post('birth')),
				'svn' => string_replaceToDb($this->input->post('svn')),
				'address' => string_replaceToDb($this->input->post('address')),
				'city' => string_replaceToDb($this->input->post('city')),
				'zipCode' => string_replaceToDb($this->input->post('zipCode')),
				'land' => string_replaceToDb($this->input->post('land'))

			);

			if (is_numeric($id)) {
				$this->db->where('user_id', $id);
				return $this->db->update('users', $data);
			} else {
				return $this->db->insert('users', $data);
			}
		}
	}

	function getUserAll ($id = false) {

		if ($id == false){
			$this->db->select('*');
			return $this->db->get('users')->result();

		}else {
			$this->db->select('*');
			$this->db->where('id',$id);
			return $this->db->get('users')->row();
		}

//			$this->db->select('p.*');
//			$this->db->where('p.active','1');
//			$this->db->like('p.name', $search,'both');
//			$this->db->or_like('p.short_text', $search,'both');
//			$this->db->group_by("p.id");
//			$products = $this->db->get('products as p')->result();


	}
	function getSlider($active = false){

		$this->db->select('*');
		if ($active){
			$this->db->where('active','1');
		}
		return $this->db->get('sliders')->result();

	}

	function getDokument(){

			$this->db->select('*');
			$this->db->where('active', '1');
			return $this->db->get('dokuments')->result();



	}

	function getLinkPage(){


			$this->db->select('*');
			$this->db->where('active', '1');
			return $this->db->get('linksPage')->result();

	}

}

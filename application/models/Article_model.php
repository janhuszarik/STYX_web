<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model
{
	public function saveArticleCategory($post = false)
	{
		$data = [
			'name' => $post['name'],
			'slug' => url_title($post['name'], 'dash', true),
			'lang' => $post['lang'],
			'active' => $post['active'],
			'created_at' => date('Y-m-d H:i:s'),
			'keywords' => $post['keywords'],
			'description' => $post['description']
		];

		if (!empty($post['id']) && is_numeric($post['id'])) {
			$this->db->where('id', $post['id']);
			return $this->db->update('article_categories', $data);
		} else {
			return $this->db->insert('article_categories', $data);
		}
	}

	public function getArticleCategories($id = false)
	{
		if ($id === false) {
			return $this->db->get('article_categories')->result();
		} else {
			$this->db->where('id', $id);
			return $this->db->get('article_categories')->row();
		}
	}

	public function deleteArticleCategory($id)
	{
		return $this->db->delete('article_categories', ['id' => $id]);
	}

	public function getArticlesByCategory($categoryId)
	{
		$this->db->where('category_id', $categoryId);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('articles')->result();
	}

	public function getArticleCategoriesWithCount()
	{
		$this->db->select('ac.*, COUNT(a.id) as article_count');
		$this->db->from('article_categories ac');
		$this->db->join('articles a', 'a.category_id = ac.id', 'left');
		$this->db->group_by('ac.id');
		return $this->db->get()->result();
	}
	public function countCategoriesFiltered($search = null)
	{
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('name', $search);
			$this->db->or_like('slug', $search);
			$this->db->or_like('keywords', $search);
			$this->db->or_like('description', $search);
			$this->db->group_end();
		}
		return $this->db->count_all_results('article_categories');
	}



	public function getPaginatedCategories($limit, $offset)
	{
		$this->db->select('ac.*, COUNT(a.id) as article_count, m.parent');
		$this->db->from('article_categories ac');
		$this->db->join('articles a', 'a.category_id = ac.id', 'left');
		$this->db->join('menu m', 'ac.menu_id = m.id', 'left'); // pridanie parent stĺpca
		$this->db->group_by('ac.id');
		$this->db->order_by('ac.id', 'DESC');
		$this->db->limit($limit, $offset);
		return $this->db->get()->result();
	}

	public function countArticlesByCategory($categoryId)
	{
		$this->db->where('category_id', $categoryId);
		return $this->db->count_all_results('articles');
	}

	public function getPaginatedArticlesByCategory($categoryId, $limit, $offset)
	{
		$this->db->where('category_id', $categoryId);
		$this->db->order_by('id', 'DESC');
		return $this->db->get('articles', $limit, $offset)->result();
	}


	public function getArticle($id)
	{
		return $this->db->get_where('articles', ['id' => $id])->row();
	}

	public function getSections($articleId)
	{
		$this->db->where('article_id', $articleId);
		$this->db->order_by('order');
		return $this->db->get('article_sections')->result();
	}

	public function saveArticle($post)
	{
		$this->load->helper('app_helper');

		// 1) Zpracování klasického uploadu hlavního obrázku
		$image = null;
		if (!empty($_FILES['image']['name'])) {
			$uploadPath = uploadImg('image', 'uploads/articles');
			if (!empty($uploadPath) && file_exists($uploadPath)) {
				$image = basename($uploadPath);
			} else {
				log_message('error', 'Chyba pri nahrávaní hlavného obrázka: ' . (isset($uploadPath) ? $uploadPath : 'Žiadny súbor'));
			}
		}

		// 2) Použitie FTP obrázka, ak je vybraný
		if (!empty($post['ftp_image'])) {
			$ftpImagePath = $post['ftp_image'];
			// Ak je to vzdialená URL (napr. ftp:// alebo http://), stiahneme súbor
			if (filter_var($ftpImagePath, FILTER_VALIDATE_URL)) {
				$localPath = 'uploads/articles/' . basename($ftpImagePath);
				// Vytvorenie priečinka, ak neexistuje
				if (!is_dir('uploads/articles/')) {
					mkdir('uploads/articles/', 0755, true);
				}
				if (copy($ftpImagePath, $localPath)) {
					$image = basename($ftpImagePath);
				} else {
					log_message('error', "Nepodarilo sa skopírovať FTP obrázok: $ftpImagePath");
				}
			} else {
				// Predpokladáme, že je to lokálna cesta (napr. uploads/articles/nazev.jpg)
				$image = basename($ftpImagePath);
			}
		}

		// 3) Sestavení pole pro uložení
		$data = [
			'category_id'     => $post['category_id'],
			'title'           => $post['title'],
			'subtitle'        => $post['subtitle'],
			'slug'            => url_title($post['title'], 'dash', true),
			'image'           => $image ?? ($post['old_image'] ?? null),
			'keywords'        => $post['keywords'],
			'meta'            => $post['meta'],
			'active'          => isset($post['active']) ? 1 : 0,
			'start_date_from' => !empty($post['start_date_from']) ? $post['start_date_from'] : null,
			'end_date_to'     => !empty($post['end_date_to']) ? $post['end_date_to'] : null,
			'updated_at'      => date('Y-m-d H:i:s'),
			'product_name1'   => $post['product_name1'] ?? null,
			'product_description1' => $post['product_description1'] ?? null,
			'product_url1'    => $post['product_url1'] ?? null,
			'product_image1'  => null,
			'product_name2'   => $post['product_name2'] ?? null,
			'product_description2' => $post['product_description2'] ?? null,
			'product_url2'    => $post['product_url2'] ?? null,
			'product_image2'  => null,
			'product_name3'   => $post['product_name3'] ?? null,
			'product_description3' => $post['product_description3'] ?? null,
			'product_url3'    => $post['product_url3'] ?? null,
			'product_image3'  => null,
			'empfohlen_name1' => $post['empfohlen_name1'] ?? null,
			'empfohlen_url1'  => $post['empfohlen_url1'] ?? null,
			'empfohlen_name2' => $post['empfohlen_name2'] ?? null,
			'empfohlen_url2'  => $post['empfohlen_url2'] ?? null,
			'empfohlen_name3' => $post['empfohlen_name3'] ?? null,
			'empfohlen_url3'  => $post['empfohlen_url3'] ?? null,
		];

		// 4) Zpracování obrázků produktů (upload + FTP)
		for ($i = 1; $i <= 3; $i++) {
			$field = 'product_image' . $i;

			// a) Standardný upload
			if (!empty($_FILES[$field]['name'])) {
				$uploadPath = uploadImg($field, 'uploads/articles/products');
				if (!empty($uploadPath) && file_exists($uploadPath)) {
					$data[$field] = basename($uploadPath);
				} else {
					log_message('error', "Chyba pri nahrávaní produktu $i: " . (isset($uploadPath) ? $uploadPath : 'Žiadny súbor'));
				}
			}
			// b) Výber z FTP
			elseif (!empty($post['ftp_product_image' . $i])) {
				$ftpImagePath = $post['ftp_product_image' . $i];
				if (filter_var($ftpImagePath, FILTER_VALIDATE_URL)) {
					$localPath = 'uploads/articles/products/' . basename($ftpImagePath);
					if (!is_dir('uploads/articles/products/')) {
						mkdir('uploads/articles/products/', 0755, true);
					}
					if (copy($ftpImagePath, $localPath)) {
						$data[$field] = basename($ftpImagePath);
					} else {
						log_message('error', "Nepodarilo sa skopírovať FTP obrázok produktu $i: $ftpImagePath");
					}
				} else {
					$data[$field] = basename($ftpImagePath);
				}
			}
			// c) Fallback na staré jméno
			else {
				$data[$field] = $post['old_' . $field] ?? null;
			}
		}

		// 5) Uložení záznamu (insert / update)
		if (!empty($post['id']) && is_numeric($post['id'])) {
			$this->db->where('id', $post['id']);
			$success = $this->db->update('articles', $data);
			$articleId = $post['id'];
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('articles', $data);
			$articleId = $this->db->insert_id();
			$success = true;
		}

		// 6) Zpracování sekcí článku
		if ($success && isset($post['sections']) && is_array($post['sections'])) {
			$this->db->delete('article_sections', ['article_id' => $articleId]);

			foreach ($post['sections'] as $index => $text) {
				$imageName = null;
				if (!empty($_FILES['section_images']['name'][$index])) {
					$_FILES['single_section'] = [
						'name'     => $_FILES['section_images']['name'][$index],
						'type'     => $_FILES['section_images']['type'][$index],
						'tmp_name' => $_FILES['section_images']['tmp_name'][$index],
						'error'    => $_FILES['section_images']['error'][$index],
						'size'     => $_FILES['section_images']['size'][$index],
					];
					$uploadPath = uploadImg('single_section', 'uploads/articles/sections');
					if (!empty($uploadPath) && file_exists($uploadPath)) {
						$imageName = basename($uploadPath);
					} else {
						log_message('error', "Chyba pri nahrávaní sekcie $index: " . (isset($uploadPath) ? $uploadPath : 'Žiadny súbor'));
					}
				}
				elseif (!empty($post['ftp_section_image'][$index])) {
					$ftpImagePath = $post['ftp_section_image'][$index];
					if (filter_var($ftpImagePath, FILTER_VALIDATE_URL)) {
						$localPath = 'uploads/articles/sections/' . basename($ftpImagePath);
						if (!is_dir('uploads/articles/sections/')) {
							mkdir('uploads/articles/sections/', 0755, true);
						}
						if (copy($ftpImagePath, $localPath)) {
							$imageName = basename($ftpImagePath);
						} else {
							log_message('error', "Nepodarilo sa skopírovať FTP obrázok sekcie $index: $ftpImagePath");
						}
					} else {
						$imageName = basename($ftpImagePath);
					}
				}

				$this->db->insert('article_sections', [
					'article_id' => $articleId,
					'content'    => $text,
					'image'      => $imageName,
					'order'      => $index,
				]);
			}
		}

		return $success;
	}



	public function deleteArticle($id)
	{
		return $this->db->delete('articles', ['id' => $id]);
	}
	public function syncMenuWithArticleCategories()
	{
		$menuItems = $this->db->get('menu')->result();

		foreach ($menuItems as $menu) {
			// Preskoč ak nemá názov
			if (empty($menu->name)) continue;

			// Priprav dáta
			$data = [
				'name' => $menu->name,
				'slug' => !empty($menu->url) ? $menu->url : url_title($menu->name, 'dash', true),
				'lang' => $menu->lang ?? 'de',
				'active' => 1,
				'created_at' => date('Y-m-d H:i:s'),
			];

			// Rozlíš medzi hlavným a submenu záznamom
			if ((int)$menu->parent === 0) {
				$data['menu_id'] = $menu->id;
				$exists = $this->db->get_where('article_categories', ['menu_id' => $menu->id])->row();
			} else {
				$data['submenu_id'] = $menu->id;
				$exists = $this->db->get_where('article_categories', ['submenu_id' => $menu->id])->row();
			}

			// Ak ešte neexistuje, zapíš
			if (!$exists) {
				$this->db->insert('article_categories', $data);
			}
		}
	}
	public function getPaginatedCategoriesFiltered($limit, $offset, $search = null)
	{
		$this->db->select('ac.*, COUNT(a.id) as article_count, m.parent, m.orderBy');
		$this->db->from('article_categories ac');
		$this->db->join('articles a', 'a.category_id = ac.id', 'left');
		$this->db->join('menu m', 'ac.menu_id = m.id', 'left'); // spojenie kvôli zoradeniu podľa menu.parent

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('ac.name', $search);
			$this->db->or_like('ac.slug', $search);
			$this->db->or_like('ac.keywords', $search);
			$this->db->or_like('ac.description', $search);
			$this->db->group_end();
		}

		$this->db->group_by('ac.id');

		// Zoradenie presne ako menu:
		$this->db->order_by('(CASE WHEN ac.menu_id IS NULL AND ac.submenu_id IS NULL THEN 1 ELSE 0 END)', 'ASC'); // vlastné na koniec
		$this->db->order_by('m.parent', 'ASC');      // zoradenie podľa nadradenej položky
		$this->db->order_by('m.orderBy', 'ASC');     // poradie podľa nastaveného orderBy
		$this->db->order_by('ac.lang', 'ASC');       // najprv DE, potom EN
		$this->db->order_by('ac.id', 'ASC');         // stabilné zoradenie

		$this->db->limit($limit, $offset);
		return $this->db->get()->result();
	}







}

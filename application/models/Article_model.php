<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model
{
	public function saveArticleCategory($post = false)
	{
		$data = [
			'name' => $post['name'],
			'slug' => trim($post['slug']),
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

	public function getArticleCategories()
	{
		$query = $this->db->get('article_categories');
		return $query->result();
	}

	public function deleteArticleCategory($id)
	{
		return $this->db->delete('article_categories', ['id' => $id]);
	}

	public function getArticlesByCategory($categoryId)
	{
		$this->db->select('id, title, slug, slug_title, is_main, category_id, lang, active');
		$this->db->where('category_id', $categoryId);
		$this->db->order_by('is_main DESC, id DESC');
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
		$this->db->join('menu m', 'ac.menu_id = m.id', 'left');
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
		$this->db->select('id, title, slug, slug_title, is_main, category_id, lang, active');
		$this->db->where('category_id', $categoryId);
		$this->db->order_by('is_main DESC, id DESC');
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
		$sections = $this->db->get('article_sections')->result();
		log_message('debug', 'Fetched sections for article ' . $articleId . ': ' . print_r($sections, true));
		return $sections;
	}

	public function saveArticle(array $post)
	{
		$this->load->helper('app_helper');

		log_message('debug', 'Saving article with post data: ' . print_r($post, true));

		$image = null;
		$image_title = $post['image_title'] ?? null;

		if (!empty($_FILES['image']['name'])) {
			$uploadPath = uploadImg('image', 'Uploads/articles');
			if ($uploadPath && file_exists($uploadPath)) {
				$image = $uploadPath;
			} else {
				log_message('error', 'Failed to upload main image: ' . ($uploadPath ?: 'No file'));
				return false;
			}
		} elseif (!empty($post['ftp_image'])) {
			$ftpPath = $post['ftp_image'];
			$localDir = FCPATH . 'Uploads/articles/';
			@mkdir($localDir, 0755, true);

			if (filter_var($ftpPath, FILTER_VALIDATE_URL)) {
				$localFile = $localDir . basename($ftpPath);
				if (@file_put_contents($localFile, @file_get_contents($ftpPath))) {
					$image = basename($ftpPath);
				} else {
					log_message('error', "Failed to download FTP image: $ftpPath");
					return false;
				}
			} elseif (file_exists(FCPATH . ltrim($ftpPath, '/'))) {
				$src = FCPATH . ltrim($ftpPath, '/');
				$dst = $localDir . basename($ftpPath);
				if (@copy($src, $dst)) {
					$image = basename($ftpPath);
				} else {
					log_message('error', "Failed to copy local FTP image: $src");
					return false;
				}
			} else {
				$image = basename($ftpPath);
			}
		} else {
			$image = $post['old_image'] ?? null;
		}

		// Handle is_main and slug_title
		$is_main = isset($post['is_main']) && $post['is_main'] == '1' ? 1 : 0;
		$slug_title = $is_main ? null : url_title($post['title'], 'dash', true);

		// If setting as main, unset other main articles in the same category
		if ($is_main && !empty($post['category_id'])) {
			$this->db->where('category_id', $post['category_id']);
			$this->db->where('is_main', 1);
			if (!empty($post['id'])) {
				$this->db->where('id !=', $post['id']);
			}
			$this->db->update('articles', ['is_main' => 0]);
		}

		$data = [
			'category_id'     => $post['category_id'],
			'lang'            => $post['lang'] ?? 'de',
			'title'           => $post['title'],
			'subtitle'        => $post['subtitle'],
			'slug'            => $post['slug'],
			'image'           => $image,
			'image_title'     => $image_title,
			'keywords'        => $post['keywords'] ?? null,
			'meta'            => $post['meta'] ?? null,
			'gallery_id'      => !empty($post['gallery_id']) ? $post['gallery_id'] : null,
			'active'          => !empty($post['active']) ? 1 : 0,
			'start_date_from' => $post['start_date_from'] ?: null,
			'end_date_to'     => $post['end_date_to']   ?: null,
			'updated_at'      => date('Y-m-d H:i:s'),
			'is_main'         => $is_main,
			'slug_title'      => $slug_title,
		];

		// Handle product sets (2 sets, 3 products each)
		for ($set = 0; $set < 2; $set++) {
			for ($i = 1; $i <= 3; $i++) {
				$suffix = ($set * 3) + $i;
				$setNum = $set + 1;
				$prodNum = $i;

				$data["product_set{$setNum}_product{$prodNum}_name"] = $post["product_name{$suffix}"] ?? null;
				$data["product_set{$setNum}_product{$prodNum}_description"] = $post["product_description{$suffix}"] ?? null;
				$data["product_set{$setNum}_product{$prodNum}_image_title"] = $post["product_image{$suffix}_title"] ?? null;
				$data["product_set{$setNum}_product{$prodNum}_url"] = $post["product_url{$suffix}"] ?? null;
				$data["product_set{$setNum}_product{$prodNum}_image"] = $post["old_product_image{$suffix}"] ?? null;

				if (!empty($_FILES["product_image{$suffix}"]['name']) && $_FILES["product_image{$suffix}"]['size'] > 0) {
					$nazov = url_oprava($post['title'] ?? 'product') . "_set{$setNum}_produkt{$prodNum}_" . time();
					$up = uploadImg("product_image{$suffix}", 'Uploads/articles/products', $nazov);
					if ($up && file_exists($up)) {
						$data["product_set{$setNum}_product{$prodNum}_image"] = $up;
					} else {
						log_message('error', "Failed to upload product image set{$setNum}_product{$prodNum}: " . ($up ?: 'No file'));
						return false;
					}
				} elseif (!empty($post["ftp_product_image{$suffix}"]) && $post["ftp_product_image{$suffix}"] !== $post["old_product_image{$suffix}"]) {
					$ftpPath = $post["ftp_product_image{$suffix}"];
					$localDir = FCPATH . 'Uploads/articles/products/';
					@mkdir($localDir, 0755, true);

					if (filter_var($ftpPath, FILTER_VALIDATE_URL)) {
						$dst = $localDir . basename($ftpPath);
						if (@file_put_contents($dst, @file_get_contents($ftpPath))) {
							$data["product_set{$setNum}_product{$prodNum}_image"] = 'Uploads/articles/products/' . basename($ftpPath);
						} else {
							log_message('error', "Failed to download FTP product image set{$setNum}_product{$prodNum}: $ftpPath");
							return false;
						}
					} elseif (file_exists(FCPATH . ltrim($ftpPath, '/'))) {
						$src = FCPATH . ltrim($ftpPath, '/');
						$dst = $localDir . basename($ftpPath);
						if (@copy($src, $dst)) {
							$data["product_set{$setNum}_product{$prodNum}_image"] = 'Uploads/articles/products/' . basename($ftpPath);
						} else {
							log_message('error', "Failed to copy FTP product image set{$setNum}_product{$prodNum}: $src");
							return false;
						}
					} else {
						$data["product_set{$setNum}_product{$prodNum}_image"] = 'Uploads/articles/products/' . basename($ftpPath);
					}
				}
			}
		}

		for ($i = 1; $i <= 3; $i++) {
			$data["empfohlen_name{$i}"] = $post["empfohlen_name{$i}"] ?? null;
			$data["empfohlen_url{$i}"]  = $post["empfohlen_url{$i}"] ?? null;
		}

		if (!empty($post['id']) && is_numeric($post['id'])) {
			$this->db->where('id', $post['id']);
			$ok = $this->db->update('articles', $data);
			$articleId = $post['id'];
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$ok = $this->db->insert('articles', $data);
			$articleId = $this->db->insert_id();
		}

		if (isset($post['sections_data']) && is_array($post['sections_data'])) {
			$this->db->delete('article_sections', ['article_id' => $articleId]);
			foreach ($post['sections_data'] as $idx => $section) {
				$secImg = $section['image'] ?? null;
				$secImgTitle = $section['image_title'] ?? null;
				$buttonName = $section['button_name'] ?? null;
				$subpage = $section['subpage'] ?? null;
				$externalUrl = $section['external_url'] ?? null;

				$sectionData = [
					'article_id'   => $articleId,
					'content'      => $section['content'],
					'image'        => $secImg,
					'image_title'  => $secImgTitle,
					'button_name'  => $buttonName,
					'subpage'      => $subpage,
					'external_url' => $externalUrl,
					'order'        => $idx,
				];

				log_message('debug', "Inserting section $idx: " . print_r($sectionData, true));

				if (!$this->db->insert('article_sections', $sectionData)) {
					log_message('error', "Failed to insert section $idx into article_sections: " . $this->db->last_query());
					return false;
				}
			}
		}

		return $ok;
	}

	public function deleteArticle($id)
	{
		return $this->db->delete('articles', ['id' => $id]);
	}

	public function syncMenuWithArticleCategories()
	{
		$menuItems = $this->db->get('menu')->result();

		foreach ($menuItems as $menu) {
			if (empty($menu->name)) continue;

			$data = [
				'name' => $menu->name,
				'slug' => !empty($menu->url) ? $menu->url : url_title($menu->name, 'dash', true),
				'lang' => $menu->lang ?? 'de',
				'active' => 1,
				'created_at' => date('Y-m-d H:i:s'),
			];

			if ((int)$menu->parent === 0) {
				$data['menu_id'] = $menu->id;
				$exists = $this->db->get_where('article_categories', ['menu_id' => $menu->id])->row();
			} else {
				$data['submenu_id'] = $menu->id;
				$exists = $this->db->get_where('article_categories', ['submenu_id' => $menu->id])->row();
			}

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
		$this->db->join('menu m', 'ac.menu_id = m.id', 'left');

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('ac.name', $search);
			$this->db->or_like('ac.slug', $search);
			$this->db->or_like('ac.keywords', $search);
			$this->db->or_like('ac.description', $search);
			$this->db->group_end();
		}

		$this->db->group_by('ac.id');

		$this->db->order_by('(CASE WHEN ac.menu_id IS NULL AND ac.submenu_id IS NULL THEN 1 ELSE 0 END)', 'ASC');
		$this->db->order_by('m.parent', 'ASC');
		$this->db->order_by('m.orderBy', 'ASC');
		$this->db->order_by('ac.lang', 'ASC');
		$this->db->order_by('ac.id', 'ASC');

		$this->db->limit($limit, $offset);
		return $this->db->get()->result();
	}

	public function getMenuItems()
	{
		$this->db->select('m.id, m.name, m.url, m.parent, m.orderBy');
		$this->db->where('m.active', 1);
		$this->db->order_by('m.parent', 'ASC');
		$this->db->order_by('m.orderBy', 'ASC');
		$menuItems = $this->db->get('menu m')->result();

		$options = '';
		$categories = $this->getArticleCategories();

		foreach ($menuItems as $item) {
			$options .= '<option value="' . htmlspecialchars($item->url) . '">' . htmlspecialchars($item->name) . '</option>';

			// Find the corresponding category
			$category = null;
			foreach ($categories as $cat) {
				if ($cat->menu_id == $item->id || $cat->submenu_id == $item->id) {
					$category = $cat;
					break;
				}
			}

			// If the category exists and has multiple articles, add articles as submenu items
			if ($category) {
				$articles = $this->getArticlesByCategory($category->id);
				if (count($articles) > 1) {
					foreach ($articles as $article) {
						if (!$article->is_main) {
							$articleSlug = $article->slug . '/' . $article->slug_title;
							$options .= '<option value="' . htmlspecialchars($articleSlug) . '"> - ' . htmlspecialchars($article->title) . '</option>';
						}
					}
				}
			}
		}

		return ['success' => true, 'options' => $options];
	}
}

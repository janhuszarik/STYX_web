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

	public function saveArticle(array $post)
	{
		$this->load->helper('app_helper');

		log_message('debug', 'Saving article with post data: ' . print_r($post, true));

		$image = null;
		$image_title = $post['image_title'] ?? null;

		if (!empty($_FILES['image']['name'])) {
			$uploadPath = uploadImg('image', 'Uploads/articles');
			if ($uploadPath && file_exists($uploadPath)) {
				$image = basename($uploadPath);
			} else {
				log_message('error', 'Failed to upload main image: ' . ($uploadPath ?: 'No file'));
				return false;
			}
		}

		if (!empty($post['ftp_image'])) {
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
		}

		$data = [
			'category_id'     => $post['category_id'],
			'lang'            => $post['lang'] ?? 'de',
			'title'           => $post['title'],
			'subtitle'        => $post['subtitle'],
			'slug'            => $post['slug'], // Použijeme slug priamo z formulára
			'image'           => $image ?? ($post['old_image'] ?? null),
			'image_title'     => $image_title,
			'keywords'        => $post['keywords'] ?? null,
			'meta'            => $post['meta'] ?? null,
			'gallery_id'      => !empty($post['gallery_id']) ? $post['gallery_id'] : null,
			'active'          => !empty($post['active']) ? 1 : 0,
			'start_date_from' => $post['start_date_from'] ?: null,
			'end_date_to'     => $post['end_date_to']   ?: null,
			'updated_at'      => date('Y-m-d H:i:s'),
		];

		for ($i = 1; $i <= 3; $i++) {
			$data["product_name{$i}"] = $post["product_name{$i}"] ?? null;
			$data["product_description{$i}"] = $post["product_description{$i}"] ?? null;
			$data["product_url{$i}"] = $post["product_url{$i}"] ?? null;
			$data["product_image{$i}_title"] = $post["product_image{$i}_title"] ?? null;
			$data["product_image{$i}"] = null;

			if (!empty($_FILES["product_image{$i}"]['name'])) {
				$up = uploadImg("product_image{$i}", 'Uploads/articles/products');
				if ($up && file_exists($up)) {
					$data["product_image{$i}"] = basename($up);
				} else {
					log_message('error', "Failed to upload product image $i: " . ($up ?: 'No file'));
					return false;
				}
			} elseif (!empty($post["ftp_product_image{$i}"])) {
				$ftpPath = $post["ftp_product_image{$i}"];
				$localDir = FCPATH . 'Uploads/articles/products/';
				@mkdir($localDir, 0755, true);

				if (filter_var($ftpPath, FILTER_VALIDATE_URL)) {
					$dst = $localDir . basename($ftpPath);
					if (@file_put_contents($dst, @file_get_contents($ftpPath))) {
						$data["product_image{$i}"] = basename($ftpPath);
					} else {
						log_message('error', "Failed to download FTP product image $i: $ftpPath");
						return false;
					}
				} elseif (file_exists(FCPATH . ltrim($ftpPath, '/'))) {
					$src = FCPATH . ltrim($ftpPath, '/');
					$dst = $localDir . basename($ftpPath);
					if (@copy($src, $dst)) {
						$data["product_image{$i}"] = basename($ftpPath);
					} else {
						log_message('error', "Failed to copy FTP product image $i: $src");
						return false;
					}
				} else {
					$data["product_image{$i}"] = basename($ftpPath);
				}
			} else {
				$data["product_image{$i}"] = $post["old_product_image{$i}"] ?? null;
			}
		}

		for ($i = 1; $i <= 3; $i++) {
			$data["empfohlen_name{$i}"] = $post["empfohlen_name{$i}"] ?? null;
			$data["empfohlen_url{$i}"] = $post["empfohlen_url{$i}"] ?? null;
		}

		if (isset($post['sections']) && is_array($post['sections'])) {
			if (!empty($post['id'])) {
				$this->db->delete('article_sections', ['article_id' => $post['id']]);
			}
			foreach ($post['sections'] as $idx => $text) {
				$secImg = null;
				$secImgTitle = $post['section_image_titles'][$idx] ?? null;
				$buttonName = $post['button_names'][$idx] ?? null;
				$subpage = $post['subpages'][$idx] ?? null;
				$externalUrl = $post['external_urls'][$idx] ?? null;

				log_message('debug', "Saving section $idx: content=$text, button_name=$buttonName, subpage=$subpage, external_url=$externalUrl");

				if (!empty($_FILES['section_images']['name'][$idx])) {
					$_FILES['tmp_sec']['name']     = $_FILES['section_images']['name'][$idx];
					$_FILES['tmp_sec']['tmp_name'] = $_FILES['section_images']['tmp_name'][$idx];
					$_FILES['tmp_sec']['error']    = $_FILES['section_images']['error'][$idx];
					$_FILES['tmp_sec']['size']     = $_FILES['section_images']['size'][$idx];

					$up = uploadImg('tmp_sec', 'Uploads/articles/sections');
					if ($up && file_exists($up)) {
						$secImg = basename($up);
					} else {
						log_message('error', "Failed to upload section image $idx: " . ($up ?: 'No file'));
						return false;
					}
				} elseif (!empty($post['ftp_section_image'][$idx])) {
					$ftpPath = $post['ftp_section_image'][$idx];
					$localDir = FCPATH . 'Uploads/articles/sections/';
					@mkdir($localDir, 0755, true);

					if (filter_var($ftpPath, FILTER_VALIDATE_URL)) {
						$dst = $localDir . basename($ftpPath);
						if (@file_put_contents($dst, @file_get_contents($ftpPath))) {
							$secImg = basename($ftpPath);
						} else {
							log_message('error', "Failed to download FTP section image $idx: $ftpPath");
							return false;
						}
					} elseif (file_exists(FCPATH . ltrim($ftpPath, '/'))) {
						$src = FCPATH . ltrim($ftpPath, '/');
						$dst = $localDir . basename($ftpPath);
						if (@copy($src, $dst)) {
							$secImg = basename($ftpPath);
						} else {
							log_message('error', "Failed to copy FTP section image $idx: $src");
							return false;
						}
					} else {
						$secImg = basename($ftpPath);
					}
				}

				$sectionData = [
					'article_id'   => $post['id'] ?? $this->db->insert_id(),
					'content'      => $text,
					'image'        => $secImg,
					'image_title'  => $secImgTitle,
					'button_name'  => $buttonName,
					'subpage'      => $subpage,
					'external_url' => $externalUrl,
					'order'        => $idx,
				];

				log_message('debug', "Inserting section $idx into article_sections: " . print_r($sectionData, true));

				if (!$this->db->insert('article_sections', $sectionData)) {
					log_message('error', "Failed to insert section $idx into article_sections: " . $this->db->last_query());
					return false;
				}
			}
		}

		if (!empty($post['id']) && is_numeric($post['id'])) {
			$this->db->where('id', $post['id']);
			$ok = $this->db->update('articles', $data);
			if (!$ok) {
				log_message('error', "Failed to update article: " . $this->db->last_query());
				log_message('error', "Error: " . $this->db->error()['message']);
			}
			$articleId = $post['id'];
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$ok = $this->db->insert('articles', $data);
			if (!$ok) {
				log_message('error', "Failed to insert article: " . $this->db->last_query());
				log_message('error', "Error: " . $this->db->error()['message']);
			}
			$articleId = $this->db->insert_id();
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
		$this->db->select('id, name, url');
		$this->db->where('active', 1);
		$this->db->order_by('parent', 'ASC');
		$this->db->order_by('orderBy', 'ASC');
		$menuItems = $this->db->get('menu')->result();

		$options = '';
		foreach ($menuItems as $item) {
			$options .= '<option value="' . htmlspecialchars($item->url) . '">' . htmlspecialchars($item->name) . '</option>';
		}

		return ['success' => true, 'options' => $options];
	}
}

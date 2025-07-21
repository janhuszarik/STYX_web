<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

	public function getArticleCategories($id = null)
	{
		if ($id) {
			return $this->db->get_where('article_categories', ['id' => $id])->row();
		}
		return $this->db->get('article_categories')->result();
	}

	public function deleteArticleCategory($id)
	{
		return $this->db->delete('article_categories', ['id' => $id]);
	}

	public function getArticlesByCategory($categoryId)
	{
		$this->db->select('id, title, slug, slug_title, is_main, category_id, subcategory_id, lang, active');
		$this->db->where('category_id', $categoryId);
		$this->db->order_by('is_main DESC, created_at DESC');
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

	public function getPaginatedCategoriesFiltered($limit = null, $offset = null, $search = null)
	{
		$this->db->select('ac.*, COUNT(a.id) as article_count, m.parent, m.orderBy, m.id as menu_id');
		$this->db->from('article_categories ac');
		$this->db->join('articles a', 'a.category_id = ac.id', 'left');
		$this->db->join('menu m', 'ac.menu_id = m.id OR ac.submenu_id = m.id', 'left');

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('ac.name', $search);
			$this->db->or_like('ac.slug', $search);
			$this->db->or_like('ac.keywords', $search);
			$this->db->or_like('ac.description', $search);
			$this->db->group_end();
		}

		$this->db->group_by('ac.id');
		$this->db->order_by('m.parent', 'ASC');
		$this->db->order_by('m.orderBy', 'ASC');
		$this->db->order_by('ac.id', 'ASC');

		if ($limit !== null && $offset !== null) {
			$this->db->limit($limit, $offset);
		}

		$categories = $this->db->get()->result();

		$ordered_categories = [];
		$main_menus = [];
		$sub_menus = [];

		foreach ($categories as $cat) {
			if ($cat->parent == 0 && $cat->menu_id) {
				$main_menus[] = $cat;
			} else {
				$sub_menus[] = $cat;
			}
		}

		usort($main_menus, function($a, $b) {
			return $a->orderBy <=> $b->orderBy;
		});

		foreach ($main_menus as $main) {
			$ordered_categories[] = $main;
			foreach ($sub_menus as $sub) {
				if ($sub->parent == $main->menu_id) {
					$ordered_categories[] = $sub;
				}
			}
		}

		foreach ($categories as $cat) {
			if (!$cat->menu_id && !$cat->submenu_id) {
				$ordered_categories[] = $cat;
			}
		}

		return $ordered_categories;
	}

	public function countArticlesByCategory($categoryId)
	{
		$this->db->where('category_id', $categoryId);
		return $this->db->count_all_results('articles');
	}

	public function getPaginatedArticlesByCategory($categoryId, $limit, $offset)
	{
		$this->db->select('*');
		$this->db->where('category_id', $categoryId);
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('articles', $limit, $offset)->result();
	}

	public function getArticle($id)
	{
		return $this->db->get_where('articles', ['id' => $id])->row();
	}

	public function getAllArticlesExcept($excludeId = null)
	{
		$this->db->select('id, title, slug, lang');
		if ($excludeId) {
			$this->db->where('id !=', $excludeId);
		}
		$this->db->order_by('title', 'ASC');
		return $this->db->get('articles')->result();
	}

	public function getSections($articleId)
	{
		$this->db->where('article_id', $articleId);
		$this->db->order_by('order');
		$sections = $this->db->get('article_sections')->result();
		return $sections;
	}

	public function saveArticle(array $post)
	{
		$this->load->helper('app_helper');

		// Čistenie textových vstupov
		$post['title'] = clean_input_text($post['title']);
		$post['subtitle'] = clean_input_text($post['subtitle']);
		$post['keywords'] = clean_input_text($post['keywords'] ?? '');
		$post['meta'] = clean_input_text($post['meta'] ?? '');

		// Kombinácia dátumu a času
		$start_date_from = !empty($post['start_date_from_date']) ? $post['start_date_from_date'] . ' ' . ($post['start_date_from_time'] ?? '00:00') . ':00' : null;
		$end_date_to = !empty($post['end_date_to_date']) ? $post['end_date_to_date'] . ' ' . ($post['end_date_to_time'] ?? '00:00') . ':00' : null;

		// Určenie základného priečinka podľa kategórie
		switch ((int)$post['category_id']) {
			case 100:
				$categoryBaseDir = 'neuigkeiten';
				break;
			case 102:
				$categoryBaseDir = 'tipps';
				break;
			case 104:
				$categoryBaseDir = 'Jobs';
				break;
			default:
				$categoryBaseDir = 'neuigkeiten';
		}

		// Spracovanie podkategórie (len pre 100/102)
		$subcategoryDir = '';
		if (in_array((int)$post['category_id'], [100, 102]) && !empty($post['subcategory_id']) && $post['subcategory_id'] !== 'new') {
			$table = $post['category_id'] == 100 ? 'neuigkeiten_subcategories' : 'tipps_subcategories';
			$subcategory = $this->db->get_where($table, ['id' => $post['subcategory_id']])->row();
			$subcategoryDir = $subcategory ? url_oprava($subcategory->name) : '';
		}

		// Dynamické určenie cesty pre obrázky
		$articleBaseDir = 'uploads/' . $categoryBaseDir . '/';
		if ($subcategoryDir) {
			$articleBaseDir .= $subcategoryDir . '/';
		}

		if (!file_exists(FCPATH . $articleBaseDir)) {
			mkdir(FCPATH . $articleBaseDir, 0755, true);
		}

		// Prípona pre obrázky
		$suffix = match ((int)$post['category_id']) {
			100 => '_neuigkeiten',
			102 => '_tipps',
			104 => '_Jobs',
			default => '',
		};

		// Spracovanie hlavného obrázka
		$image = $post['old_image'] ?? null;
		$image_title = $post['image_title'] ?? null;

		if (!empty($_FILES['image']['name'])) {
			$imageName = url_oprava($image_title ?: ($post['title'] ?? 'article')) . $suffix;
			$uploadResult = uploadImg('image', $articleBaseDir, $imageName, false, false, true);
			if ($uploadResult && file_exists($uploadResult)) {
				$image = $uploadResult;
			} else {
				return false;
			}
		} elseif (!empty($post['ftp_image'])) {
			$ftpPath = $post['ftp_image'];
			$imageName = url_oprava($image_title ?: ($post['title'] ?? 'article')) . $suffix . '.' . pathinfo($ftpPath, PATHINFO_EXTENSION);
			$localFile = FCPATH . $articleBaseDir . $imageName;

			if (filter_var($ftpPath, FILTER_VALIDATE_URL)) {
				if (@file_put_contents($localFile, @file_get_contents($ftpPath))) {
					$image = $articleBaseDir . $imageName;
				}
			} elseif (file_exists(FCPATH . ltrim($ftpPath, '/'))) {
				$src = FCPATH . ltrim($ftpPath, '/');
				if (@copy($src, $localFile)) {
					$image = $articleBaseDir . $imageName;
				}
			}
		}

		$is_main = !empty($post['is_main']) && $post['is_main'] == '1' ? 1 : 0;
		$slug_title = $is_main ? null : url_title($post['title'], 'dash', true);

		// Deaktivácia predchádzajúcich hlavných článkov
		if ($is_main && !empty($post['category_id'])) {
			$this->db->where('category_id', $post['category_id']);
			$this->db->where('is_main', 1);
			if (!empty($post['id'])) {
				$this->db->where('id !=', $post['id']);
			}
			$this->db->update('articles', ['is_main' => 0]);
		}

		$data = [
			'category_id' => $post['category_id'],
			'subcategory_id' => !empty($post['subcategory_id']) && $post['subcategory_id'] !== 'new' ? $post['subcategory_id'] : null,
			'lang' => $post['lang'] ?? 'de',
			'title' => $post['title'],
			'subtitle' => $post['subtitle'],
			'slug' => $post['slug'],
			'image' => $image,
			'image_title' => $image_title,
			'keywords' => $post['keywords'] ?? null,
			'meta' => $post['meta'] ?? null,
			'gallery_id' => $post['gallery_id'] ?? null,
			'active' => !empty($post['active']) ? 1 : 0,
			'start_date_from' => $start_date_from,
			'end_date_to' => $end_date_to,
			'updated_at' => date('Y-m-d H:i:s'),
			'is_main' => $is_main,
			'slug_title' => $slug_title,
		];

		$data['created_at'] = !empty($post['created_at']) ? $post['created_at'] . ' 00:00:00' : date('Y-m-d 00:00:00');

		// Uloženie alebo aktualizácia článku
		if (!empty($post['id'])) {
			$this->db->where('id', $post['id']);
			$ok = $this->db->update('articles', $data);
			$articleId = $post['id'];
		} else {
			$ok = $this->db->insert('articles', $data);
			$articleId = $this->db->insert_id();
		}

		if (!$ok) {
			return false;
		}

		// SEKCIE
		if (isset($post['sections']) && is_array($post['sections'])) {
			$this->db->delete('article_sections', ['article_id' => $articleId]);
			foreach ($post['sections'] as $idx => $content) {
				$secImg = $post['old_section_image'][$idx] ?? null;
				$secImgTitle = $post['section_image_titles'][$idx] ?? null;

				if (!empty($_FILES['section_images']['name'][$idx])) {
					$_FILES['temp_section_image'] = [
						'name' => $_FILES['section_images']['name'][$idx],
						'type' => $_FILES['section_images']['type'][$idx],
						'tmp_name' => $_FILES['section_images']['tmp_name'][$idx],
						'error' => $_FILES['section_images']['error'][$idx],
						'size' => $_FILES['section_images']['size'][$idx],
					];

					$imgName = url_oprava($secImgTitle ?: ($post['title'] . '_section_' . $idx)) . $suffix;
					$uploadResult = uploadImg('temp_section_image', $articleBaseDir, $imgName, false, false, true);
					if ($uploadResult && file_exists($uploadResult)) {
						$secImg = $uploadResult;
					}
				} elseif (!empty($post['ftp_section_image'][$idx])) {
					$ftpPath = $post['ftp_section_image'][$idx];
					$imgName = url_oprava($secImgTitle ?: ($post['title'] . '_section_' . $idx)) . $suffix . '.' . pathinfo($ftpPath, PATHINFO_EXTENSION);
					$localPath = FCPATH . $articleBaseDir . $imgName;

					if (filter_var($ftpPath, FILTER_VALIDATE_URL)) {
						if (@file_put_contents($localPath, @file_get_contents($ftpPath))) {
							$secImg = $articleBaseDir . $imgName;
						}
					} elseif (file_exists(FCPATH . ltrim($ftpPath, '/'))) {
						if (@copy(FCPATH . ltrim($ftpPath, '/'), $localPath)) {
							$secImg = $articleBaseDir . $imgName;
						}
					}
				}

				$sectionData = [
					'article_id' => $articleId,
					'content' => remove_empty_tags(purify_html($content)),
					'image' => $secImg,
					'image_title' => $secImgTitle,
					'image_description' => $post['section_image_descriptions'][$idx] ?? null,
					'button_name' => $post['button_names'][$idx] ?? null,
					'subpage' => $post['subpages'][$idx] ?? null,
					'external_url' => $post['external_urls'][$idx] ?? null,
					'order' => $idx,
				];

				if (!$this->db->insert('article_sections', $sectionData)) {
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
		$menuItems = $this->db->select('id, name, url, parent, orderBy, lang, active')
			->order_by('parent ASC, orderBy ASC')
			->get('menu')
			->result();

		foreach ($menuItems as $menu) {
			if (empty($menu->name)) continue;

			$baseSlug = !empty($menu->url) ? $menu->url : url_oprava($menu->name);
			$lang = $menu->lang ?? 'de';
			$baseSlug = preg_replace("/^$lang\//", '', $baseSlug);
			$slug = $lang . '/' . $baseSlug;

			$data = [
				'name' => $menu->name,
				'slug' => $slug,
				'lang' => $lang,
				'active' => $menu->active,
				'orderBy' => $menu->orderBy,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];

			if ((int)$menu->parent === 0) {
				$data['menu_id'] = $menu->id;
				$data['submenu_id'] = null;
				$exists = $this->db->get_where('article_categories', ['menu_id' => $menu->id])->row();
			} else {
				$data['menu_id'] = null;
				$data['submenu_id'] = $menu->id;
				$exists = $this->db->get_where('article_categories', ['submenu_id' => $menu->id])->row();
			}

			if ($exists) {
				$this->db->where('id', $exists->id);
				$this->db->update('article_categories', $data);
			} else {
				$this->db->insert('article_categories', $data);
			}
		}

		$this->db->where('menu_id IS NOT NULL OR submenu_id IS NOT NULL');
		$categories = $this->db->get('article_categories')->result();
		foreach ($categories as $cat) {
			$menuExists = $this->db->where('id', $cat->menu_id ?: $cat->submenu_id)
				->get('menu')
				->num_rows();
			if (!$menuExists) {
				$articleCount = $this->db->where('category_id', $cat->id)
					->count_all_results('articles');
				if ($articleCount === 0) {
					$this->db->where('id', $cat->id);
					$this->db->delete('article_categories');
				}
			}
		}
	}

	public function getMenuItems()
	{
		$this->db->select('m.id, m.name, m.url, m.parent, m.orderBy, m.lang');
		$this->db->where('m.active', 1);
		$this->db->order_by('m.parent', 'ASC');
		$this->db->order_by('m.orderBy', 'ASC');
		$menuItems = $this->db->get('menu m')->result();

		$options = '';
		$categories = $this->getArticleCategories();

		foreach ($menuItems as $item) {
			$lang = $item->lang ?? 'de';
			$menuSlug = !empty($item->url) ? $lang . '/' . $item->url : $lang . '/' . url_title($item->name, 'dash', true);
			$options .= '<option value="' . htmlspecialchars($menuSlug) . '">' . htmlspecialchars($item->name) . '</option>';

			$category = null;
			foreach ($categories as $cat) {
				if ($cat->menu_id == $item->id || $cat->submenu_id == $item->id) {
					$category = $cat;
					break;
				}
			}

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

	public function getSubcategoriesByCategory($category_id)
	{
		if (!in_array($category_id, [100, 102])) {
			return [];
		}
		$table = ($category_id == 100) ? 'neuigkeiten_subcategories' : 'tipps_subcategories';
		$this->db->where('category_id', $category_id);
		$query = $this->db->get($table);
		return $query->result();
	}

	public function getSubcategory($id, $category_id)
	{
		$table = ($category_id == 100) ? 'neuigkeiten_subcategories' : 'tipps_subcategories';
		return $this->db->get_where($table, ['id' => $id, 'category_id' => $category_id])->row();
	}

	public function saveSubcategory($post)
	{
		$category_id = $post['category_id'];
		$table = ($category_id == 100) ? 'neuigkeiten_subcategories' : 'tipps_subcategories';

		$data = [
			'category_id' => $category_id,
			'name' => $post['name'],
			'slug' => url_title($post['name'], 'dash', true),
			'lang' => $post['lang'] ?? 'de',
			'active' => isset($post['active']) ? $post['active'] : 1,
			'updated_at' => date('Y-m-d H:i:s'),
		];

		if (!empty($post['id']) && is_numeric($post['id'])) {
			$existing = $this->db->get_where($table, ['id' => $post['id'], 'category_id' => $category_id])->row();
			if ($existing) {
				$this->db->where('id', $post['id']);
				$this->db->where('category_id', $category_id);
				$this->db->update($table, $data);
				return $post['id'];
			} else {
				return false;
			}
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
	}


	public function deleteSubcategory($id, $category_id)
	{
		$table = ($category_id == 100) ? 'neuigkeiten_subcategories' : 'tipps_subcategories';
		$this->db->where('subcategory_id', $id);
		$this->db->update('articles', ['subcategory_id' => null]);
		return $this->db->delete($table, ['id' => $id, 'category_id' => $category_id]);
	}

	public function getSubcategoryByNameAndCategory($category_id, $name)
	{
		$table = ($category_id == 100) ? 'neuigkeiten_subcategories' : 'tipps_subcategories';
		return $this->db->get_where($table, ['category_id' => $category_id, 'name' => $name])->row();
	}
}

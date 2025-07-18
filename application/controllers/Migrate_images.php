<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate_images extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Article_model');
		$this->load->helper('app_helper');
	}

	public function index()
	{
		$logFile = FCPATH . 'migration_log.txt';
		file_put_contents($logFile, "Migrácia začala: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

		$articles = $this->db->get('articles')->result();
		foreach ($articles as $article) {
			$categoryId = $article->category_id;
			$categoryBaseDir = ($categoryId == 100) ? 'neuigkeiten' : (($categoryId == 102) ? 'tipps' : 'other');
			$suffix = ($categoryId == 100) ? '_neuigkeiten' : (($categoryId == 102) ? '_tipps' : '');

			$subcategoryDir = '';
			if (in_array($categoryId, [100, 102]) && !empty($article->subcategory_id)) {
				$table = ($categoryId == 100) ? 'neuigkeiten_subcategories' : 'tipps_subcategories';
				$subcategory = $this->db->get_where($table, ['id' => $article->subcategory_id])->row();
				$subcategoryDir = $subcategory ? url_oprava($subcategory->name) : '';
			}

			$baseDir = "uploads/articles/{$categoryBaseDir}/" . ($subcategoryDir ? "{$subcategoryDir}/" : '');

			if (!file_exists(FCPATH . $baseDir)) {
				mkdir(FCPATH . $baseDir, 0755, true);
				file_put_contents($logFile, "Vytvorený priečinok: $baseDir\n", FILE_APPEND);
			}

			// Hlavný obrázok
			if (!empty($article->image)) {
				$oldPath = FCPATH . $article->image;
				if (file_exists($oldPath)) {
					$imageName = $article->image_title ? url_oprava($article->image_title) : url_oprava($article->title);
					$imageName = $imageName . $suffix . '.' . pathinfo($oldPath, PATHINFO_EXTENSION);
					$newPath = FCPATH . $baseDir . $imageName;

					file_put_contents($logFile, "Kopírujem hlavný obrázok: $oldPath -> $newPath\n", FILE_APPEND);
					if (@copy($oldPath, $newPath)) {
						$this->db->where('id', $article->id);
						$this->db->update('articles', ['image' => $baseDir . $imageName]);
						file_put_contents($logFile, "Úspešne skopírované a aktualizované: $newPath\n", FILE_APPEND);
						// Voliteľne: zmazať starý súbor
						// @unlink($oldPath);
					} else {
						file_put_contents($logFile, "Chyba pri kopírovaní: $oldPath\n", FILE_APPEND);
					}
				} else {
					file_put_contents($logFile, "Obrázok neexistuje: $oldPath\n", FILE_APPEND);
				}
			}

			// Sekcie
			$sections = $this->Article_model->getSections($article->id);
			foreach ($sections as $section) {
				if (!empty($section->image)) {
					$oldPath = FCPATH . $section->image;
					if (file_exists($oldPath)) {
						$imageName = $section->image_title ? url_oprava($section->image_title) : url_oprava($article->title . '_section_' . $section->order);
						$imageName = $imageName . $suffix . '.' . pathinfo($oldPath, PATHINFO_EXTENSION);
						$newPath = FCPATH . $baseDir . $imageName;

						file_put_contents($logFile, "Kopírujem obrázok sekcie: $oldPath -> $newPath\n", FILE_APPEND);
						if (@copy($oldPath, $newPath)) {
							$this->db->where('id', $section->id);
							$this->db->update('article_sections', ['image' => $baseDir . $imageName]);
							file_put_contents($logFile, "Úspešne skopírované a aktualizované: $newPath\n", FILE_APPEND);
							// Voliteľne: zmazať starý súbor
							// @unlink($oldPath);
						} else {
							file_put_contents($logFile, "Chyba pri kopírovaní: $oldPath\n", FILE_APPEND);
						}
					} else {
						file_put_contents($logFile, "Obrázok sekcie neexistuje: $oldPath\n", FILE_APPEND);
					}
				}
			}
		}

		file_put_contents($logFile, "Migrácia dokončená: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
		echo "Migrácia dokončená. Skontroluj log v migration_log.txt.";
	}
}
?>

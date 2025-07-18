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

		$basePath = FCPATH; // Základná cesta na serveri, napr. /var/www9/p42096/styxnatur.at/sub/styx/release_20250718095321/
		$articles = $this->db->get('articles')->result();
		$oldDirs = [
			'uploads/articles/sections/',
			'uploads/articles/summernote/',
			'uploads/articles/title_image/',
			'uploads/articles/other/'
		];
		$productOldDir = 'uploads/articles/products/';
		$productNewDir = 'uploads/Produkte/';

		$migratedFiles = []; // Zoznam presunutých súborov

		foreach ($articles as $article) {
			$categoryId = $article->category_id;
			$categoryBaseDir = ($categoryId == 100) ? 'neuigkeiten' : (($categoryId == 102) ? 'tipps' : 'neuigkeiten');
			$suffix = ($categoryId == 100) ? '_neuigkeiten' : (($categoryId == 102) ? '_tipps' : '');

			$subcategoryDir = '';
			if (in_array($categoryId, [100, 102]) && !empty($article->subcategory_id)) {
				$table = ($categoryId == 100) ? 'neuigkeiten_subcategories' : 'tipps_subcategories';
				$subcategory = $this->db->get_where($table, ['id' => $article->subcategory_id])->row();
				$subcategoryDir = $subcategory ? url_oprava($subcategory->name) : '';
				file_put_contents($logFile, "Podkategória pre článok ID {$article->id}: $subcategoryDir\n", FILE_APPEND);
			}

			$baseDir = "uploads/articles/{$categoryBaseDir}/" . ($subcategoryDir ? "{$subcategoryDir}/" : '');
			if (!file_exists($basePath . $baseDir)) {
				mkdir($basePath . $baseDir, 0755, true);
				file_put_contents($logFile, "Vytvorený priečinok: $basePath$baseDir\n", FILE_APPEND);
			}

			// Hlavný obrázok a sekcie
			if (!empty($article->image) && $article->image !== 'null') {
				$found = false;
				foreach ($oldDirs as $oldDir) {
					$oldPath = $basePath . $oldDir . basename($article->image);
					if (file_exists($oldPath)) {
						$imageName = $article->image_title ? url_oprava($article->image_title) : url_oprava($article->title);
						$imageName = $imageName . $suffix . '.' . pathinfo($oldPath, PATHINFO_EXTENSION);
						$newPath = $basePath . $baseDir . $imageName;

						file_put_contents($logFile, "Kopírujem hlavný obrázok (článok ID {$article->id}): $oldPath -> $newPath\n", FILE_APPEND);
						if (@copy($oldPath, $newPath)) {
							$this->db->where('id', $article->id);
							$this->db->update('articles', ['image' => $baseDir . $imageName]);
							@unlink($oldPath);
							$migratedFiles[] = $oldPath;
							file_put_contents($logFile, "Úspešne skopírované a aktualizované: $newPath\n", FILE_APPEND);
							file_put_contents($logFile, "Starý súbor vymazaný: $oldPath\n", FILE_APPEND);
							$found = true;
						} else {
							file_put_contents($logFile, "Chyba pri kopírovaní: $oldPath\n", FILE_APPEND);
						}
						break;
					}
				}
				if (!$found) {
					file_put_contents($logFile, "Hlavný obrázok neexistuje pre článok ID {$article->id}: {$article->image}\n", FILE_APPEND);
				}
			} else {
				file_put_contents($logFile, "Hlavný obrázok je prázdny alebo null pre článok ID {$article->id}\n", FILE_APPEND);
			}

			$sections = $this->Article_model->getSections($article->id);
			foreach ($sections as $section) {
				if (!empty($section->image) && $section->image !== 'null') {
					$found = false;
					foreach ($oldDirs as $oldDir) {
						$oldPath = $basePath . $oldDir . basename($section->image);
						if (file_exists($oldPath)) {
							$imageName = $section->image_title ? url_oprava($section->image_title) : url_oprava($article->title . '_section_' . $section->order);
							$imageName = $imageName . $suffix . '.' . pathinfo($oldPath, PATHINFO_EXTENSION);
							$newPath = $basePath . $baseDir . $imageName;

							file_put_contents($logFile, "Kopírujem obrázok sekcie (článok ID {$article->id}, sekcia ID {$section->id}): $oldPath -> $newPath\n", FILE_APPEND);
							if (@copy($oldPath, $newPath)) {
								$this->db->where('id', $section->id);
								$this->db->update('article_sections', ['image' => $baseDir . $imageName]);
								@unlink($oldPath);
								$migratedFiles[] = $oldPath;
								file_put_contents($logFile, "Úspešne skopírované a aktualizované: $newPath\n", FILE_APPEND);
								file_put_contents($logFile, "Starý súbor vymazaný: $oldPath\n", FILE_APPEND);
								$found = true;
							} else {
								file_put_contents($logFile, "Chyba pri kopírovaní: $oldPath\n", FILE_APPEND);
							}
							break;
						}
					}
					if (!$found) {
						file_put_contents($logFile, "Obrázok sekcie neexistuje: {$section->image}\n", FILE_APPEND);
					}
				} else {
					file_put_contents($logFile, "Obrázok sekcie je prázdny alebo null pre článok ID {$article->id}, sekcia ID {$section->id}\n", FILE_APPEND);
				}
			}

			// Produktové obrázky
			if (!file_exists($basePath . $productNewDir)) {
				mkdir($basePath . $productNewDir, 0755, true);
				file_put_contents($logFile, "Vytvorený priečinok pre produkty: $basePath$productNewDir\n", FILE_APPEND);
			}
			for ($set = 1; $set <= 2; $set++) {
				for ($prod = 1; $prod <= 3; $prod++) {
					$field = "product_set{$set}_product{$prod}_image";
					if (!empty($article->$field) && $article->$field !== 'null') {
						$oldPath = $basePath . $productOldDir . basename($article->$field);
						if (file_exists($oldPath)) {
							$imageName = url_oprava($article->title . "_set{$set}_produkt{$prod}") . '.' . pathinfo($oldPath, PATHINFO_EXTENSION);
							$newPath = $basePath . $productNewDir . $imageName;

							file_put_contents($logFile, "Kopírujem produktový obrázok (článok ID {$article->id}, $field): $oldPath -> $newPath\n", FILE_APPEND);
							if (@copy($oldPath, $newPath)) {
								$this->db->where('id', $article->id);
								$this->db->update('articles', [$field => $productNewDir . $imageName]);
								@unlink($oldPath);
								$migratedFiles[] = $oldPath;
								file_put_contents($logFile, "Úspešne skopírované a aktualizované: $newPath\n", FILE_APPEND);
								file_put_contents($logFile, "Starý súbor vymazaný: $oldPath\n", FILE_APPEND);
							} else {
								file_put_contents($logFile, "Chyba pri kopírovaní: $oldPath\n", FILE_APPEND);
							}
						} else {
							file_put_contents($logFile, "Produktový obrázok neexistuje: $oldPath\n", FILE_APPEND);
						}
					}
				}
			}
		}

		// Vymazanie starých priečinkov
		foreach ($oldDirs as $oldDir) {
			$fullPath = $basePath . $oldDir;
			if (is_dir($fullPath)) {
				$files = glob($fullPath . '*', GLOB_MARK);
				if (!empty($files)) {
					foreach ($files as $file) {
						if (is_file($file) && !in_array($file, $migratedFiles)) {
							@unlink($file);
							file_put_contents($logFile, "Vymazaný nemigrovaný súbor: $file\n", FILE_APPEND);
						}
					}
				}
				$this->deleteDirectory($fullPath);
				file_put_contents($logFile, "Starý priečinok vymazaný: $oldDir\n", FILE_APPEND);
			}
		}

		// Vymazanie starého priečinka produktov
		$productFullPath = $basePath . $productOldDir;
		if (is_dir($productFullPath)) {
			$files = glob($productFullPath . '*', GLOB_MARK);
			if (!empty($files)) {
				foreach ($files as $file) {
					if (is_file($file) && !in_array($file, $migratedFiles)) {
						@unlink($file);
						file_put_contents($logFile, "Vymazaný nemigrovaný súbor: $file\n", FILE_APPEND);
					}
				}
			}
			$this->deleteDirectory($productFullPath);
			file_put_contents($logFile, "Starý priečinok produktov vymazaný: $productOldDir\n", FILE_APPEND);
		}

		file_put_contents($logFile, "Migrácia dokončená: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
		echo "Migrácia dokončená. Skontroluj log v migration_log.txt.";
	}

	private function deleteDirectory($dir) {
		if (!file_exists($dir)) return true;
		if (!is_dir($dir)) return unlink($dir);
		foreach (glob($dir . '*', GLOB_MARK) as $file) {
			if (is_dir($file)) {
				$this->deleteDirectory($file);
			} else {
				unlink($file);
			}
		}
		return rmdir($dir);
	}
}
?>

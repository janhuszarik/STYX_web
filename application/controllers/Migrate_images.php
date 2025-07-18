<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate_products extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Article_model');
		$this->load->helper('app_helper');
	}

	public function index()
	{
		$logFile = FCPATH . 'migration_log_products.txt';
		file_put_contents($logFile, "Migrácia produktových obrázkov začala: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

		$basePath = FCPATH; // Základná cesta na serveri, napr. /var/www9/p42096/styxnatur.at/sub/styx/release_20250718095321/
		$oldDir = 'uploads/articles/products/';
		$newDir = 'uploads/Produkte/';
		if (!file_exists($basePath . $newDir)) {
			mkdir($basePath . $newDir, 0755, true);
			file_put_contents($logFile, "Vytvorený priečinok: $basePath$newDir\n", FILE_APPEND);
		}

		$articles = $this->db->get('articles')->result();

		foreach ($articles as $article) {
			for ($set = 1; $set <= 2; $set++) {
				for ($prod = 1; $prod <= 3; $prod++) {
					$field = "product_set{$set}_product{$prod}_image";
					if (!empty($article->$field) && $article->$field !== 'null') {
						$oldPath = $basePath . $oldDir . basename($article->$field);
						if (file_exists($oldPath)) {
							$imageName = url_oprava($article->title . "_set{$set}_produkt{$prod}") . '.' . pathinfo($oldPath, PATHINFO_EXTENSION);
							$newPath = $basePath . $newDir . $imageName;

							file_put_contents($logFile, "Kopírujem produktový obrázok (článok ID {$article->id}, $field): $oldPath -> $newPath\n", FILE_APPEND);
							if (@copy($oldPath, $newPath)) {
								$this->db->where('id', $article->id);
								$this->db->update('articles', [$field => $newDir . $imageName]);
								@unlink($oldPath); // Vymazanie starého súboru
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

		// Vymazanie starého priečinka, ak je prázdny
		$oldFullPath = $basePath . $oldDir;
		if (is_dir($oldFullPath)) {
			$files = glob($oldFullPath . '*', GLOB_MARK);
			if (empty($files)) {
				if (@rmdir($oldFullPath)) {
					file_put_contents($logFile, "Starý priečinok vymazaný: $oldDir\n", FILE_APPEND);
				} else {
					file_put_contents($logFile, "Chyba pri vymazávaní priečinka: $oldDir\n", FILE_APPEND);
				}
			} else {
				file_put_contents($logFile, "Priečinok nie je prázdny, nemôže byť vymazaný: $oldDir\n", FILE_APPEND);
			}
		}

		file_put_contents($logFile, "Migrácia produktových obrázkov dokončená: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
		echo "Migrácia produktových obrázkov dokončená. Skontroluj log v migration_log_products.txt.";
	}
}
?>

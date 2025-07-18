<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate_best_products extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->helper('app_helper');
	}

	public function index()
	{
		$logFile = FCPATH . 'migration_log_best_products.txt';
		file_put_contents($logFile, "Migrácia produktových obrázkov (bestProduct) začala: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

		$basePath = FCPATH; // Základná cesta na serveri
		$oldDir = 'uploads/product/';
		$newDir = 'uploads/Produkte/';

		if (!file_exists($basePath . $newDir)) {
			mkdir($basePath . $newDir, 0755, true);
			file_put_contents($logFile, "Vytvorený priečinok: $basePath$newDir\n", FILE_APPEND);
		}

		$products = $this->Admin_model->getProduct();

		foreach ($products as $product) {
			if (!empty($product->image) && $product->image !== 'null') {
				$oldPath = $basePath . $oldDir . basename($product->image);
				if (file_exists($oldPath)) {
					$imageName = url_oprava($product->name) . '.' . pathinfo($oldPath, PATHINFO_EXTENSION);
					$newPath = $basePath . $newDir . $imageName;

					file_put_contents($logFile, "Kopírujem obrázok (produkt ID {$product->id}): $oldPath -> $newPath\n", FILE_APPEND);
					if (@copy($oldPath, $newPath)) {
						$this->db->where('id', $product->id);
						$this->db->update('bestProduct', ['image' => $newDir . $imageName]);
						@unlink($oldPath);
						file_put_contents($logFile, "Úspešne skopírované a aktualizované: $newPath\n", FILE_APPEND);
						file_put_contents($logFile, "Starý súbor vymazaný: $oldPath\n", FILE_APPEND);
					} else {
						file_put_contents($logFile, "Chyba pri kopírovaní: $oldPath\n", FILE_APPEND);
					}
				} else {
					file_put_contents($logFile, "Obrázok neexistuje: $oldPath\n", FILE_APPEND);
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

		file_put_contents($logFile, "Migrácia produktových obrázkov (bestProduct) dokončená: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
		echo "Migrácia produktových obrázkov (bestProduct) dokončená. Skontroluj log v migration_log_best_products.txt.";
	}
}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestMove extends CI_Controller
{
	public function index()
	{
		$this->moveImages('uploads/articles/neuigkeiten/', 'uploads/Neuigkeiten/');
		$this->moveImages('uploads/articles/tipps/', 'uploads/Tipps/');
		echo "Presun dokončený.";
	}

	private function moveImages($sourcePath, $targetPath)
	{
		$source = FCPATH . $sourcePath;
		$target = FCPATH . $targetPath;

		if (!is_dir($source)) {
			echo "Zdrojový priečinok $source neexistuje.<br>";
			return;
		}

		if (!is_dir($target)) {
			mkdir($target, 0755, true);
		}

		$subdirs = scandir($source);
		foreach ($subdirs as $dir) {
			if ($dir === '.' || $dir === '..') continue;

			$sourceSub = $source . $dir . '/';
			$targetSub = $target . $dir . '/';

			if (!is_dir($sourceSub)) continue;

			if (!is_dir($targetSub)) {
				mkdir($targetSub, 0755, true);
			}

			$files = scandir($sourceSub);
			foreach ($files as $file) {
				if ($file === '.' || $file === '..') continue;

				$srcFile = $sourceSub . $file;
				$dstFile = $targetSub . $file;

				if (!file_exists($dstFile)) {
					rename($srcFile, $dstFile);
					echo "✔ Presunuté: $srcFile → $dstFile<br>";
				} else {
					echo "⚠ Preskočené (existuje): $dstFile<br>";
				}
			}
			rmdir($sourceSub);
		}
		@rmdir($source);
	}
}

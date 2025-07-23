<?php
$this->load->view('partials/search_assets');
?>
<?php
//if (!function_exists('get_article_url')) {
//	function get_article_url($result) {
//		$CI = get_instance();
//		$base_url = rtrim($CI->config->item('base_url'), '/');
//		error_log("Base URL nastavená na: " . $base_url); // Logovanie base_url
//		$lang = $result['lang'] ? $result['lang'] : 'de';
//
//		if (!empty($result['url'])) {
//			// Očistenie pôvodnej url iba od jazyka, zachovanie ostatnej cesty
//			$url = trim(ltrim($result['url'], '/'), '/');
//			$url = preg_replace('/^' . preg_quote($lang, '/') . '\//', '', $url); // Odstránenie iba jazyka
//
//			$tipps_subcategories = $CI->db->select('id, slug')->where('category_id', 102)->get('tipps_subcategories')->result_array();
//			$neuigkeiten_subcategories = $CI->db->select('id, slug')->where('category_id', 100)->get('neuigkeiten_subcategories')->result_array();
//			$subcategory_slugs = array_merge($tipps_subcategories, $neuigkeiten_subcategories);
//			$slug_map = [];
//			foreach ($subcategory_slugs as $subcat) {
//				$slug_map[$subcat['id']] = $subcat['slug'];
//			}
//
//			// Rozšírenie category_path pre ďalšie kategórie
//			$category_path = '';
//			if (!empty($result['category_id'])) {
//				switch ($result['category_id']) {
//					case 102:
//						$category_path = 'aktuelles/tipps';
//						break;
//					case 100:
//						$category_path = 'aktuelles/neuigkeiten';
//						break;
//					case 103: // Príklad pre Unternehmen, uprav podľa tvojej databázy
//						$category_path = 'Unternehmen';
//						break;
//					default:
//						$category_path = ''; // Ak nie je známa kategória, použije sa iba slug
//				}
//			}
//
//			// Zostavenie cesty s category_path a zachovaním očisteného url
//			$constructed_url = trim($url, '/'); // Zachovanie pôvodnej cesty po odstránení jazyka
//			if ($category_path && empty($constructed_url)) {
//				$constructed_url = $category_path; // Ak je url prázdne, použije sa iba category_path
//			} elseif ($category_path) {
//				$constructed_url = rtrim($category_path, '/') . '/' . ltrim($constructed_url, '/');
//			}
//
//			// Pridanie jazyka iba ak nie je prítomný
//			if (!preg_match('/^' . preg_quote($lang, '/') . '\//', $constructed_url)) {
//				$constructed_url = $lang . '/' . $constructed_url;
//			}
//
//			// Odstránenie viacerých lomítok
//			$constructed_url = preg_replace('/\/+/', '/', $constructed_url);
//
//			// Debug pred finálnou URL
//			error_log("URL pred pridaním base_url a title: " . $constructed_url);
//			echo '<pre>'; var_dump($result['lang'], $result['subcategory_id'], $result['subcategory_type'], $result['url'], $constructed_url); echo '</pre>';
//
//			// Finálna URL s base_url
//			$full_url = $base_url . '/' . $constructed_url;
//			error_log("Full URL pred title: " . $full_url);
//
//			// Pridanie title (bez ohľadu na subcategory_id, ak je title dostupné)
//			if (isset($result['title']) && !empty($result['title'])) {
//				$title_part = '/' . url_oprava($result['type'] === 'article' ? $result['title'] : $result['article_title']);
//				error_log("Title part: " . $title_part);
//				if (strpos($full_url, $title_part) === false) {
//					$full_url .= $title_part;
//				}
//			}
//
//			if ($result['type'] === 'article_section' && !empty($result['id'])) {
//				return $full_url . '#section-' . $result['id'];
//			}
//			return $full_url;
//		}
//		return '#';
//	}
//}
$resultCount = !empty($results) && is_array($results) ? count($results) : 0;
error_log("Počet výsledkov v View: " . $resultCount);
if (empty($results)) { echo '<pre>Prázdne výsledky</pre>'; exit; }
?>

<div class="search-results">
	<form action="<?= base_url('search') ?>" method="get" class="mb-4" autocomplete="off">
		<div style="display: flex; gap:8px; align-items: center; max-width: 420px;">
			<input type="search" name="q" value="<?= htmlspecialchars($query) ?>"
				   placeholder="Suchbegriff eingeben …"
				   class="form-control">
			<button type="submit" class="btn btn-success">
				<i class="fas fa-search"></i> Suchen
			</button>
		</div>
	</form>

	<h2 class="mb-1">
		Suchergebnisse für „<span style="color:#2baa59;"><?= htmlspecialchars($query) ?></span>“
	</h2>
	<div class="mb-4" style="color:#647a6d;">
		<?= $resultCount ?> Ergebnis<?= $resultCount == 1 ? '' : 'se' ?> gefunden
	</div>

	<?php if ($resultCount > 0): ?>
		<div class="search-result-list">
			<?php
			$shown_articles = [];
			foreach ($results as $result):
				if ($result['type'] === 'article_section' && !empty($result['article_id'])) {
					if (in_array($result['article_id'], $shown_articles)) continue;
					$shown_articles[] = $result['article_id'];
				}

				$main_title = '';
				$url = base_url($result['url']);

				$image = '';
				$subtext = '';

				if ($result['type'] === 'article_section') {
					$main_title = !empty($result['article_title']) ? $result['article_title'] : '(Ohne Titel)';
					$image = !empty($result['article_image']) ? $result['article_image'] : '';
				} elseif ($result['type'] === 'article') {
					$main_title = !empty($result['title']) ? $result['title'] : '(Ohne Titel)';
					$image = !empty($result['image']) ? $result['image'] : '';
				}

				$found = false;
				$limit = 100;

				if (!empty($result['content'])) {
					$content = strip_tags($result['content']);
					$content_lc = mb_strtolower($content, 'UTF-8');
					$query_lc = mb_strtolower($query, 'UTF-8');
					$pos = mb_stripos($content_lc, $query_lc, 0, 'UTF-8');
					if ($pos !== false) {
						$found = true;
						$start = max(0, $pos - intval($limit/2));
						$sub = mb_substr($content, $start, $limit, 'UTF-8');
						if ($start > 0) $sub = '...' . ltrim($sub);
						if (($start + $limit) < mb_strlen($content, 'UTF-8')) $sub .= '...';
						$subtext = str_ireplace($query, '<mark class="search-mark">'.$query.'</mark>', $sub);
					}
				}
				if (empty($subtext)) {
					foreach (['keywords', 'text', 'content'] as $field) {
						if (!empty($result[$field])) {
							$tmp = htmlspecialchars(strip_tags($result[$field]));
							$subtext = mb_substr($tmp, 0, $limit, 'UTF-8');
							if (mb_strlen($tmp, 'UTF-8') > $limit) $subtext .= '...';
							if (stripos($subtext, $query) !== false) {
								$found = true;
								$subtext = str_ireplace($query, '<mark class="search-mark">'.$query.'</mark>', $subtext);
							}
							break;
						}
					}
				}
				?>
				<div class="search-result-item mb-3 border rounded">
					<div class="search-result-main">
						<div class="search-result-header">
                            <span class="search-result-title">
                                <a href="<?= htmlspecialchars($url) ?>"
								   class="text-decoration-none text-primary"
								   target="_blank">
                                    <?= htmlspecialchars($main_title) ?>
                                </a>
                            </span>
							<?php if ($found): ?>
								<span class="badge-found">
                                    <i class="fas fa-check-circle"></i>
                                    Gefunden!
                                </span>
							<?php endif; ?>
						</div>

						<small class="text-secondary">
							<i class="fas fa-globe me-1"></i>
							<a href="<?= htmlspecialchars($url) ?>" target="_blank"><?= htmlspecialchars($url) ?></a>
						</small>

						<?php if ($subtext): ?>
							<p class="mb-1 text-muted small"><?= $subtext ?></p>
						<?php else: ?>
							<p class="mb-1 text-muted small">Keine relevante Beschreibung verfügbar</p>
						<?php endif; ?>
					</div>
					<?php if ($image): ?>
						<div class="search-result-image">
							<img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($main_title) ?>">
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<p class="text-center mt-4">Keine Ergebnisse gefunden.</p>
	<?php endif; ?>
</div>

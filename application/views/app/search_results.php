<?php
$this->load->view('partials/search_assets');
?>
<?php
if (!function_exists('get_article_url')) {
	function get_article_url($result) {
		if (!empty($result['url'])) {
			return base_url($result['url']);
		}
		return '#';
	}
}
$resultCount = !empty($results) && is_array($results) ? count($results) : 0;
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
				$url = get_article_url($result);
				$image = '';
				$subtitle = '';

				if ($result['type'] === 'article_section') {
					$main_title = !empty($result['article_title']) ? $result['article_title'] : '(Ohne Titel)';
					$image = !empty($result['article_image']) ? $result['article_image'] : '';
					$subtitle = !empty($result['title']) ? $result['title'] : '';
				} elseif ($result['type'] === 'article') {
					$main_title = !empty($result['title']) ? $result['title'] : '(Ohne Titel)';
					$image = !empty($result['image']) ? $result['image'] : '';
				} else {
					$main_title = !empty($result['title']) ? $result['title'] : '(Ohne Titel)';
				}

				// -------- Výpis ukážky textu (max 100 znakov okolo zhody) --------
				$subtext = '';
				$found = false;
				$limit = 100; // počet znakov výpisu

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
					foreach (['keywords', 'subtitle', 'text', 'content'] as $field) {
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
				// -------------------------------------------------------------
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

						<?php if ($subtitle): ?>
							<div style="margin-bottom:4px;font-size:1.04rem;color:#bc3a3a;">
								<i class="fas fa-folder-open me-1"></i>
								Sektion: <?= htmlspecialchars($subtitle) ?>
							</div>
						<?php endif; ?>

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

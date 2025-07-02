<style>
	.search-results {
		max-width: 900px;
		margin: 40px auto 0 auto;
		padding: 0 10px;
	}
	.search-results h2 {
		font-size: 2.2rem;
		font-weight: 700;
		color: #222;
		margin-bottom: 32px;
		letter-spacing: -1px;
	}
	.search-result-list {
		display: flex;
		flex-direction: column;
		gap: 24px;
	}
	.search-result-item {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: stretch;
		background: #fff;
		border: 1px solid #e9ecef;
		border-radius: 16px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.07);
		padding: 24px 28px 18px 28px;
		transition: box-shadow 0.22s cubic-bezier(.4,0,.2,1), border-color 0.22s cubic-bezier(.4,0,.2,1);
		position: relative;
		gap: 26px;
		min-height: 110px;
	}
	.search-result-main {
		display: flex;
		flex-direction: column;
		flex: 1 1 0%;
		min-width: 0;
	}
	.search-result-header {
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		gap: 16px;
	}
	.search-result-title {
		font-size: 1.65rem;
		font-weight: 600;
		color: #2baa59;
		line-height: 1.23;
		word-break: break-word;
		margin-bottom: 10px;
		display: block;
		flex: 1 1 0%;
	}
	.badge-found {
		background: #e6fae8;
		color: #39b54a;
		font-size: 1rem;
		font-weight: 500;
		padding: 2px 10px 2px 8px;
		border-radius: 8px;
		display: inline-block;
		vertical-align: middle;
		line-height: 1.1;
		box-shadow: 0 1px 4px rgba(34,139,84,.08);
		white-space: nowrap;
		margin-top: 2px;
	}
	.badge-found i {
		font-size: 1em;
		margin-right: 2px;
		vertical-align: -1px;
	}
	.search-result-item small {
		font-size: 0.97rem;
		color: #8e9aad;
		display: block;
		margin-bottom: 8px;
		letter-spacing: 0.02em;
		word-break: break-all;
	}
	.search-result-item .fa-globe,
	.search-result-item .fa-folder-open {
		color: #2baa59;
		margin-right: 4px;
		opacity: 0.84;
	}
	.search-result-item p {
		margin-bottom: 0;
		font-size: 1.03rem;
		color: #6b747e;
	}
	.search-result-item strong {
		color: #24704f;
		font-weight: 600;
		background: #e9ffe9;
		padding: 1px 4px;
		border-radius: 4px;
	}
	.search-result-image {
		flex: 0 0 110px;
		display: flex;
		align-items: flex-start;
		justify-content: flex-end;
		max-width: 140px;
		margin-left: 18px;
		margin-top: 0;
	}
	.search-result-image img {
		max-height: 90px;
		max-width: 120px;
		border-radius: 7px;
		object-fit: cover;
		box-shadow: 0 2px 7px rgba(0,0,0,.09);
		display: block;
	}
	.search-mark {
		background: #e9ffe9;
		color: #19754f;
		border-radius: 4px;
		padding: 1px 3px;
		font-weight: 600;
		font-size: 1.02em;
	}
	@media (max-width: 900px) {
		.search-result-item {
			flex-direction: column;
			align-items: flex-start;
			gap: 10px;
			padding: 18px 10px 14px 10px;
		}
		.search-result-header {
			flex-direction: column;
			align-items: flex-start;
			gap: 2px;
		}
		.search-result-image {
			margin-left: 0;
			justify-content: flex-start;
			max-width: 100%;
			margin-top: 10px;
		}
		.search-result-image img {
			max-width: 90vw;
			max-height: 110px;
		}
	}
	.search-results input[type="search"]::placeholder { color: #a2b6ae; opacity:.92; }
</style>

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

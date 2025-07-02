<style>.search-results {
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
		background: #fff;
		border: 1px solid #e9ecef;
		border-radius: 16px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.07);
		padding: 28px 28px 16px 28px;
		transition: box-shadow 0.22s cubic-bezier(.4,0,.2,1), border-color 0.22s cubic-bezier(.4,0,.2,1);
		position: relative;
	}

	.search-result-item:hover {
		box-shadow: 0 4px 28px rgba(44, 170, 89, 0.11);
		border-color: #aadbb9;
	}

	.search-result-item h3 {
		font-size: 1.65rem;
		font-weight: 600;
		margin-bottom: 10px;
		color: #2baa59;
		line-height: 1.2;
	}

	.search-result-item h3 a {
		color: #2baa59;
		text-decoration: none;
		transition: color 0.16s;
	}
	.search-result-item h3 a:hover {
		color: #24704f;
		text-decoration: underline;
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

	@media (max-width: 600px) {
		.search-result-item {
			padding: 18px 9px 12px 9px;
		}
		.search-results h2 {
			font-size: 1.45rem;
		}
		.search-result-item h3 {
			font-size: 1.15rem;
		}
	}
	.search-results input[type="search"]::placeholder { color: #a2b6ae; opacity:.92; }
	.search-mark {
		background: #e9ffe9;
		color: #19754f;
		border-radius: 4px;
		padding: 1px 3px;
		font-weight: 600;
		font-size: 1.02em;
	}
	.search-badge {
		display: inline-flex;
		align-items: center;
		gap: 3px;
		border-radius: 8px;
		padding: 2px 10px 2px 7px;
		box-shadow: 0 1px 3px rgba(34, 139, 84, 0.09);
		font-weight: 500;

	}
	.badge-found {
		background: #e6fae8;
		color: #39b54a;
		font-size: 1rem;
		font-weight: 500;
		padding: 1.5px 10px 1.5px 8px;
		border-radius: 8px;
		display: inline-block;
		margin-left: 2px;
		vertical-align: middle;
		line-height: 1.1;
		box-shadow: 0 1px 4px rgba(34,139,84,.08);
	}
	.badge-found i {
		font-size: 1em;
		margin-right: 2px;
		vertical-align: -1px;
	}

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

				$subtext = '';
				$found = false;
				if (!empty($result['content'])) {
					$content = strip_tags($result['content']);
					$pos = stripos($content, $query);
					if ($pos !== false) {
						$found = true;
						$start = max(0, $pos - 40);
						$subtext = '...' . mb_substr($content, $start, 160, 'UTF-8') . '...';
						$subtext = str_ireplace($query, '<mark>'.$query.'</mark>', $subtext);
					}
				}
				if (empty($subtext)) {
					foreach (['description', 'keywords', 'subtitle', 'text', 'content'] as $field) {
						if (!empty($result[$field])) {
							$subtext = htmlspecialchars(strip_tags($result[$field]));
							if (stripos($subtext, $query) !== false) {
								$found = true;
								$subtext = str_ireplace($query, '<mark>'.$query.'</mark>', $subtext);
							}
							break;
						}
					}
				}
				?>
				<div class="search-result-item mb-3 p-3 border rounded">
					<?php if ($image): ?>
						<img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($main_title) ?>" style="max-width:100px;margin-top:10px;border-radius:4px;">
					<?php endif; ?>

					<h3 class="mb-1" style="display:flex;align-items:center;gap:8px;">
						<a href="<?= htmlspecialchars($url) ?>"
						   class="text-decoration-none text-primary"
						   target="_blank">
							<?= htmlspecialchars($main_title) ?>
						</a>
						<?php if ($found): ?>
							<span class="badge-found">
        						<i class="fas fa-check-circle"></i>
        						Gefunden!
    						</span>
						<?php endif; ?>


					</h3>

					<?php if ($subtitle): ?>
						<div style="margin-bottom:4px;font-size:1.04rem;color:#bc3a3a;">
							<i class="fas fa-folder-open me-1"></i>
							Sekcia: <?= htmlspecialchars($subtitle) ?>
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
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<p class="text-center mt-4">Keine Ergebnisse gefunden.</p>
	<?php endif; ?>
</div>

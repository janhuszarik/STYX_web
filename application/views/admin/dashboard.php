<style>
	.card-footer {
		padding: 12px 0 0 0;
		border-top: 1px solid #eee;
	}

	.btn-settings {
		font-size: 0.8rem;
		font-weight: 500;
		padding: 0.25rem 0.75rem;
		border-radius: 20px;
		background-color: #007bff;
		border-color: #007bff;
		transition: background-color 0.2s ease-in-out;
	}

	.btn-settings:hover {
		background-color: #0056b3;
		border-color: #0056b3;
		text-decoration: none;
		color: #fff;
	}

	.card-body ul {
		padding-left: 1.2rem;
		margin-bottom: 0.5rem;
	}

	.card-body ul li {
		font-size: 0.9rem;
		color: #555;
	}

	.card {
		margin-bottom: 2rem;
	}

	.summary .amount {
		font-size: 2rem;
		font-weight: 700;
		line-height: 1.2;
	}

	.summary .text-muted {
		font-size: 0.9rem;
		color: #888;
	}
</style>

<div class="row">
	<?php
	$cards = [
		'menuStats' => ['label' => 'Menü', 'link' => 'admin/menu'],
		'sliderStats' => ['label' => 'Slider', 'link' => 'admin/slider'],
		'productStats' => ['label' => 'Beliebte Produkte', 'link' => 'admin/bestProduct'],
		'newsStats' => ['label' => 'Aktuelle Beiträge', 'link' => 'admin/news'],
		'articleCategoryStats' => ['label' => 'Artikelkategorien', 'link' => 'admin/article_categories'],
		'articleStats' => ['label' => 'Artikel', 'link' => 'admin/article'],
	];

	foreach ($cards as $key => $info):
		$data = $$key;
		$has_last = !empty($data['last_title']);
		?>
		<div class="col-md-6 col-xl-4">
			<section class="card card-featured-left card-featured-primary">
				<div class="card-body">
					<div class="widget-summary">
						<div class="widget-summary-col">
							<div class="summary">
								<h4 class="title"><?= $info['label'] ?></h4>
								<div class="info">
									<strong class="amount"><?= $data['total'] ?? 0 ?></strong>
									<span class="text-muted">gesamt</span>
								</div>

								<div class="info mb-2" style="<?= !$has_last ? 'margin-bottom: 1.5rem;' : '' ?>">
									<?php if ($has_last): ?>
										<span class="text-muted">
											Letzter: <?= $data['last_title'] ?>
											<?= !empty($data['last_date']) ? '(' . $data['last_date'] . ')' : '' ?>
										</span>
									<?php endif; ?>
								</div>

								<?php if (!empty($data['recent'])): ?>
									<ul>
										<?php foreach ($data['recent'] as $item): ?>
											<li><?= $item->title ?? $item->name ?? $item->name1 ?? '[kein Titel]' ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="card-footer text-end">
						<a href="<?= base_url($info['link']) ?>" class="btn btn-sm btn-primary px-3">
							Zu den Einstellungen
						</a>
					</div>
				</div>
			</section>
		</div>
	<?php endforeach; ?>
</div>

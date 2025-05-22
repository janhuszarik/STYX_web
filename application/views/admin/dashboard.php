<style>
	.card-body {
		padding: 1rem 1.2rem;
	}

	.card {
		margin-bottom: 1.5rem;
		transition: box-shadow 0.2s ease-in-out;
		cursor: pointer;
		text-decoration: none;
	}

	.card:hover {
		box-shadow: 0 0 10px rgba(0,0,0,0.1);
		text-decoration: none;
	}

	.card-body ul {
		padding-left: 1.2rem;
		margin-bottom: 0.5rem;
	}

	.card-body ul li {
		font-size: 0.9rem;
		color: #555;
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

	/* Odstupy medzi vnútornými stĺpcami (ľavá mriežka 2×3) */
	.row > [class*='col-'] {
		padding-right: 10px;
		padding-left: 5px;
		margin-bottom: 1rem;
	}

	.card-calendar {
		height: 100%;
	}
	.number_custom {
		font-size: 25px;
	}
</style>

<div class="row">
	<!-- ĽAVÁ strana: 6 kariet rozdelených do 3 riadkov -->
	<div class="col-md-6">
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
				<div class="col-md-6">
					<a href="<?= base_url($info['link']) ?>" class="card card-featured-left card-featured-primary h-100 text-dark text-decoration-none">
						<div class="card-body d-flex flex-column justify-content-between">
							<div>
								<div class="d-flex justify-content-between align-items-center mb-2">
									<h4 class="fw-bold mb-0" style="border-left: 4px solid #28a745; padding-left: 10px;"><?= $info['label'] ?></h4>
									<span class="text-muted">gesamt: <strong class="text-dark number_custom"><?= $data['total'] ?? 0 ?></strong></span>
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
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="col-md-6 d-flex flex-column">
		<section class="card card-calendar flex-grow-1">
			<div class="card-body">
				<h4 class="title">Kalender</h4>
				<div id="calendar-placeholder">
					<div id="calendar"></div>
				</div>

			</div>
		</section>
	</div>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar');

		var calendar = new FullCalendar.Calendar(calendarEl, {
			locale: 'de',                 // 🇩🇪 Nemecký jazyk
			firstDay: 1,                  // Začiatok týždňa = Pondelok
			initialView: 'dayGridMonth',
			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,listWeek'
			},

		});

		calendar.render();
	});
</script>

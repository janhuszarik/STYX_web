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
	#calendar {
		min-height: 400px;
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
<!-- MODÁLNE OKNO PRE PRIDANIE / EDIT POZNÁMKY -->
<!-- MODÁLNE OKNO -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form id="noteForm" novalidate>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="noteModalLabel">Neue Notiz</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="noteId" name="id">

					<div class="mb-3">
						<label for="noteText" class="form-label">Notiz</label>
						<textarea id="noteText" name="note" class="form-control" rows="3" required></textarea>
					</div>

					<div class="mb-3">
						<label for="noteStart" class="form-label">Von</label>
						<input type="date" id="noteStart" name="start" class="form-control" required>
					</div>

					<div class="mb-3">
						<label for="noteEnd" class="form-label">Bis</label>
						<input type="date" id="noteEnd" name="end" class="form-control">
					</div>

					<div class="mb-3">
						<label for="noteColor" class="form-label">Farbe</label>
						<select id="noteColor" name="color" class="form-select" required>
							<option value="#3788d8">🔵 Blau</option>
							<option value="#dc3545">🔴 Rot</option>
							<option value="#198754">🟢 Grün</option>
							<option value="#ffc107">🟡 Gelb</option>
							<option value="#6f42c1">🟣 Violett</option>
							<option value="#0dcaf0">🔵 Türkis</option>
							<option value="#fd7e14">🟠 Orange</option>
							<option value="#6c757d">⚫ Grau</option>
							<option value="#000000">⚫ Schwarz</option>
							<option value="#ffffff">⚪ Weiß</option>
							<option value="#6610f2">🟣 Indigo</option>
							<option value="#20c997">🟢 Mint</option>
							<option value="#e83e8c">🟣 Pink</option>
							<option value="#adb5bd">⚪ Silber</option>
							<option value="#343a40">⚫ Dunkelgrau</option>
						</select>
					</div>

					<div class="d-flex justify-content-between">
						<button type="button" id="deleteNoteBtn" class="btn btn-danger" style="display: none;">Löschen</button>
						<button type="submit" class="btn btn-primary">Speichern</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>



<script>
	document.addEventListener('DOMContentLoaded', function () {
		const calendarEl = document.getElementById('calendar');
		const noteForm = document.getElementById('noteForm');
		const noteModalEl = document.getElementById('noteModal');
		const modal = new bootstrap.Modal(noteModalEl);

		const calendar = new FullCalendar.Calendar(calendarEl, {
			locale: 'de',
			firstDay: 1,
			initialView: 'dayGridMonth',
			displayEventEnd: true,
			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,listWeek'
			},
			events: <?= json_encode($calendar_events ?? []) ?>,

			dateClick: function (info) {
				document.getElementById('noteStart').value = info.dateStr;
				document.getElementById('noteEnd').value = info.dateStr;
				document.getElementById('noteText').value = '';
				document.getElementById('noteId').value = '';
				document.getElementById('noteColor').value = '#3788d8';
				document.getElementById('deleteNoteBtn').style.display = 'none';
				modal.show();
			},

			eventClick: function (info) {
				const startDate = info.event.startStr;
				const endDate = info.event.extendedProps.raw_end || info.event.endStr || startDate;
				document.getElementById('noteStart').value = startDate;
				document.getElementById('noteEnd').value = endDate;
				document.getElementById('noteText').value = info.event.title;
				document.getElementById('noteId').value = info.event.id;
				document.getElementById('noteColor').value = info.event.backgroundColor || '#3788d8';
				document.getElementById('deleteNoteBtn').style.display = 'inline-block';
				modal.show();
			}
		});

		calendar.render();

		// Form submit: CREATE or UPDATE
		noteForm.addEventListener('submit', function (e) {
			e.preventDefault();

			const id = document.getElementById('noteId').value;
			const note = document.getElementById('noteText').value;
			const start = document.getElementById('noteStart').value;
			const end = document.getElementById('noteEnd').value;
			const color = document.getElementById('noteColor').value;

			const url = id
				? "<?= base_url('admin/update_calendar_note') ?>"
				: "<?= base_url('admin/save_calendar_note') ?>";

			const payload = id
				? { id, note, start, end, color }
				: { note, date: start, end_date: end, color };

			fetch(url, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(payload)
			})
				.then(res => res.json())
				.then(data => {
					if (data.success) {
						const correctedEnd = new Date(end);
						correctedEnd.setDate(correctedEnd.getDate() + 1);
						const correctedEndStr = correctedEnd.toISOString().split('T')[0];

						if (id) {
							const existing = calendar.getEventById(id);
							if (existing) {
								existing.setProp('title', note);
								existing.setStart(start);
								existing.setEnd(correctedEndStr);
								existing.setProp('color', color);
								existing.setExtendedProp('raw_end', end);
							}
						} else {
							calendar.addEvent({
								id: data.id,
								title: note,
								start: start,
								end: correctedEndStr,
								color: color,
								extendedProps: {
									raw_end: end
								}
							});
						}
						modal.hide();
					}
				})
				.catch(err => console.error("❌ Chyba pri uložení:", err));
		});

		// DELETE note
		document.getElementById('deleteNoteBtn').addEventListener('click', function () {
			const id = document.getElementById('noteId').value;
			if (!id || !confirm("Möchten Sie diese Notiz wirklich löschen?")) return;

			fetch("<?= base_url('admin/delete_calendar_note/') ?>" + id)
				.then(res => res.json())
				.then(data => {
					if (data.success) {
						const existing = calendar.getEventById(id);
						if (existing) existing.remove();
						modal.hide();
					}
				})
				.catch(err => console.error("❌ Chyba pri mazaní:", err));
		});
	});
</script>



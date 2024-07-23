
<div role="main" class="main">
	<section class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-primary overlay-show overlay-op-9 mb-0" style="background-image: url(<?=$image1?>);">
		<div class="container translucent-background">
			<div class="row">
				<div class="col align-self-center p-static text-center">
					<h1 style="color:#000;"><?=$title?></h1>
					<span style="color: #0a0a0a" class="sub-title"><?=$description?></span>
				</div>
			</div>
		</div>
	</section>
	<section class="page-header bg-color-light border-bottom border-width-2 translucent-background">
		<div class="container">
			<div class="row">
				<div class="col align-self-center p-static">
					<ul class="breadcrumb d-block">
						<li><a href="<?=BASE_URL?>">Home</a></li>
						<li class="active"><?=$title?></li>
					</ul>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="container py-4">

	<div class="row">
		<div class="col">
			<div class="blog-posts single-post">

				<article class="post post-large blog-single-post border-0 m-0 p-0">


					<div class="post-content ms-0">

						<h2 style="color: #aad998" class="font-weight-semi-bold"><?=lang('AROMA_DERM_HEADING')?></h2>

						<div class="post-meta">
							<h4 class="text-color-black"><?=lang('AROMA_DERM_SUBHEADING')?></h4>

							<span><i class="far fa-comments"></i>
								<a href="#">12 Comments</a></span>
						</div>
						<img src="<?=BASE_URL?>img/image/MichaellaStix.jpg" class="img-fluid float-start me-4 mt-2" alt="" />
						<h4><?=lang('AROMA_DERM_SUBHEADING_TEXT')?></h4>
						<p><?=lang('AROMA_DERM_LONGTEXT')?></p>

						<div class="post-block mt-5 post-share">
							<a href="https://www.aroma-derm.com/" class="btn btn-primary w-50 mb-2"><?=lang('ZUR_HOMA_PAGE')?></a>

							<!-- Go to www.addthis.com/dashboard to customize your tools -->
							<div class="addthis_inline_share_toolbox"></div>
							<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60ba220dbab331b0"></script>

						</div>


						<div id="comments" class="post-block mt-5 post-comments">
							<h4 class="mb-3"><?=lang('SUM_COMMENT')?> | <?=$sumComment?></h4>


							<ul class="comments">
								<?php foreach ($comment as $comment): ?>
									<li>
										<div class="comment">
											<div class="img-thumbnail img-thumbnail-no-borders d-none d-sm-block">
												<img class="avatar" alt="Avatar" src="data:image/svg+xml;base64,
												PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDI0IDI0Ii
												BmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo
												gICAgPGNpcmNsZSBjeD0iMTIiIGN5PSIxMiIgcj0iMTIiIGZpbGw9IiNCMEJFQzUi
												Lz4KICAgIDxjaXJjbGUgY3g9IjEyIiBjeT0iOCIgcj0iNCIgZmlsbD0id2hpdGUiL
												z4KICAgIDxwYXRoIGQ9Ik0xMiAxNEM5LjMzIDE0IDYuOTMgMTUuMzQgNS41IDE3Lj
												M1QzUuMTggMTcuOCA1LjM5IDE4LjQyIDUuOTMgMTguNDJIMTguMDdDMTguNjEgMTguNDIgMTguODIgMTcuOCAxOC41IDE3LjM1QzE3LjA3IDE1LjM0IDE0LjY3IDE0IDEyIDE0WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+"/>
											</div>
											<div class="comment-block">
												<div class="comment-arrow"></div>
												<span class="comment-by">
                        							<strong><?=$comment->name?> </strong>
                        								<span class="float-end">
                          									  <span> <a href="#"><i class="fas fa-reply"></i> <?=lang('COMMENT_REPLY')?></a></span></span>
														</span>
												<p><?=$comment->comment?></p>

												<span class="date float-end"><?= date('j.n.Y H:i', strtotime($comment->created)) ?> / <b class="text-color-black"><?=$comment->id.' | '.$comment->section_id?></b></span>

											</div>
										</div>
								<?php endforeach; ?>
							</ul>


						</div>

						<div class="post-block mt-5 post-leave-comment">
							<h4 class="mb-3"><?=lang('COMMENT_NEW')?></h4>
							<div class="accordion" id="accordion1">
								<div class="card card-default">
									<div class="card-header" id="collapse1HeadingOne">
										<h4 class="card-title m-0">
											<a class="accordion-toggle" data-bs-toggle="collapse" data-bs-target="#collapse1One" aria-expanded="true" aria-controls="collapse1One">
												<?=lang('COMMENT_REPLY_INFO')?>											</a>
										</h4>
									</div>
									<div id="collapse1One" class="collapse" aria-labelledby="collapse1HeadingOne">
										<div class="card-body">
											<p class="mb-0">Falls der Autor seinen Kommentar ändern möchte, muss er uns per
												<a href="<?=BASE_URL.'kontakt'?>">E-Mail kontaktieren.</a>
												Wir akzeptieren Änderungs- oder Löschungsanfragen nur von der ursprünglichen E-Mail-Adresse,
												mit der das Formular ausgefüllt wurde, und die Kommentar-ID muss angegeben werden.
												Die Kommentar-ID befindet sich direkt neben dem Datum und der Uhrzeit, z.B.: ( 8 | Naturkosmetik).
												Wenn Sie mit dem Inhalt eines anderen Kommentars nicht einverstanden sind,
												können Sie ihn <a href="<?=BASE_URL.'kontakt'?>"> melden</a> und wir werden den Inhalt überprüfen.
											</p>
										</div>
									</div>

								</div>
							</div>
							<br>
							<form class="contact-form p-4 rounded bg-color-grey" action="<?=BASE_URL?>app/aromaDerm" method="POST">
								<div class="p-2">
									<div class="row">
										<div class="form-group col-lg-6">
											<label class="form-label required font-weight-bold text-dark"><?=lang('ALL_NAME')?></label>
											<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" required>
										</div>
										<div class="form-group col-lg-6">
											<label class="form-label required font-weight-bold text-dark"><?=lang('EMAIL')?></label>
											<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" required>
										</div>
									</div>
									<div class="row">
										<div class="form-group col">
											<label class="form-label required font-weight-bold text-dark"><?=lang('COMMENT')?></label>
											<textarea maxlength="5000" data-msg-required="Please enter your message." rows="8" class="form-control" name="comment" required></textarea>
										</div>
									</div>
									<div class="row">
										<div class="form-group col">
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="consent" name="consent" value="1" required>
												<label class="form-check-label font-weight-bold text-dark"  for="consent">
													<?=lang('GDPR_TEXT')?><a
														href="https://shop.styx.at/Datenschutz:_:2.html"><?=lang('GDPR_FOR_LINK')?></a>
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group col mb-0">
											<input type="hidden" name="section_id" value="Aroma-Derm">
											<input type="hidden" name="active" value="1">
											<input type="submit" value="Kommentar absenden" class="btn btn-primary btn-modern" data-loading-text="Loading...">
										</div>
									</div>
								</div>
							</form>

						</div>
					</div>
				</article>

			</div>
		</div>
	</div>

</div>

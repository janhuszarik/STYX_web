<style>
	/* Modal container */
	.modal {
		display: none;
		position: fixed;
		z-index: 1000;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0,0,0);
		background-color: rgba(0,0,0,0.4);
		padding-top: 60px;
	}
	/* Modal content */
	.modal-content {
		background-color: #d3dfe1;
		margin: 5% auto;
		padding: 20px;
		border: 1px solid #888;
		width: 40%;
	}
	/* Close button */
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}
	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}
</style>
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

						<h2 style="color: #aad998" class="font-weight-semi-bold"><?=lang('WORLD_OF_STYX_HEADING')?></h2>

						<div class="post-meta">
							<h4 class="text-color-black"><?=lang('WORLD_OF_STYX_SUBHEADING')?></h4>
						</div>
						<p class="text-color-black"><?=lang('WORLD_OF_STYX_SUBHEADING_BOOKING')?></p>

						<div class="post-block mt-5 post-share">
							<button id="wordOfStyx-openModalBtn" class="btn btn-primary w-50 mb-2"><?=lang('TICKET')?></button>

							<!-- Modal structure -->
							<div id="wordOfStyx-myModal" class="wordOfStyx-modal">
								<div class="wordOfStyx-modal-content">
									<span class="wordOfStyx-close">&times;</span>
									<iframe id="wordOfStyx-modalFrame" src="" width="100%" height="500px" style="border:0;"></iframe>
								</div>
							</div>

							<!-- Go to www.addthis.com/dashboard to customize your tools -->
							<div class="addthis_inline_share_toolbox"></div>
							<script id="regiondo-button-js" async="" defer="" src="https://cdn.regiondo.net/js/integration/regiondo-button.js" fired="1"></script>
						</div>


						<div class="container mt-5">
							<h2 style="color: #aad998" class="font-weight-semi-bold"><?=lang('ERLEBNISWELT')?></h2>
							<br>
							<div class="row">
								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/worldOfStyxCard.jpg" alt="worldOfStyxCard.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5">World of STYX</h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('WORLD_OF_STYX_TEXT_CARD')?></p>
<!--												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold">LEARN MORE</a>-->
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/bahnhofsbrau.jpg" alt="bahnhofsbrau.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('BIER_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('BIER_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/bahnerlebnis.jpg" alt="bahnerlebnis.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('BAHN_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('BAHN_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<br><br>

							<div class="row">
								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/kreutergarten.jpg" alt="kreutergarten.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('KREAUTERGARTEN_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('KREAUTERGARTEN_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/kulinarik.jpg" alt="kulinarik.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('KULINARIK_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('KULINARIK_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/ermassigungen.jpg" alt="ermassigungen.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('ERMASSIGUNGEN_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('ERMASSIGUNGEN_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="container mt-5">
							<h2 style="color: #aad998" class="font-weight-semi-bold"><?=lang('PRICECARDHEAD')?></h2>
							<br>
							<div class="row">
								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/individeullbesuch.jpg" alt="individeullbesuch.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('INDIVIDUELLBESUCH_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('INDIVIDUELLBESUCH_TEXT_CARD')?></p>
													<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/gruppenaktion.jpg" alt="gruppenaktion.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('GRUPPENAKTION_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('GRUPPENAKTION_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/englischTour.jpg" alt="englischTour.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('ENGLISCHTOUR_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<h4 class="font-weight-bold text-color-light">World of STYX</h4>
												<p class="font-weight-light text-color-black">
													<?=lang('ENGLISCHTOUR_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<br><br>

							<h2 style="color: #aad998" class="font-weight-semi-bold"><?=lang('CHILDHEAD')?></h2>
							<br>
							<div class="row">
								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/kinderFuhrungen.jpg" alt="kinderFuhrungen.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('CHILDTOUR_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('CHILDTOUR_TEXT_CARD')?></p>
													<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/schoolaktion.jpg" alt="schoolaktion.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('SCHOOLAKTION_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<h4 class="font-weight-bold text-color-light">World of STYX</h4>
												<p class="font-weight-light text-color-black">
													<?=lang('SCHOOLAKTION_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/kinderparty.jpg" alt="kinderparty.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('CHILDHAPPY_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<h4 class="font-weight-bold text-color-light">World of STYX</h4>
												<p class="font-weight-light text-color-black">
													<?=lang('CHILDHAPPY_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<br><br>

							<h2 style="color: #aad998" class="font-weight-semi-bold"><?=lang('KONTAKTCARDS')?></h2>
							<br>
							<div class="row">
								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/styxcard.jpg" alt="styxcard.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('KONTAKT_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<p class="font-weight-light text-color-black">
													<?=lang('KONTAKT_TEXT_CARD')?></p>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/routeCard.jpg" alt="routeCard.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('ROUTTE_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<h4 class="font-weight-bold text-color-light">World of STYX</h4>
												<p class="font-weight-light text-color-black">
													<?=lang('ROUTTE_TEXT_CARD')?></p>
												<a href="<?=BASE_URL.'kontakt'?>" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('ROUTTE_BUTTON')?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
									<div class="card flip-card flip-card-3d text-center rounded-0">
										<div class="flip-front p-6">
											<div class="flip-content">
												<img src="<?=BASE_URL?>img/image/infocard.jpg" alt="infocard.jpg" class="img-fluid">
												<h2 class="font-weight-bold text-color-primary text-5"><?=lang('INFOCARD_HEAD_CARD')?></h2>
											</div>
										</div>
										<div class="flip-back d-flex align-items-center p-5" style="background-image: url('img/generic/generic-corporate-17-1.jpg'); background-size: cover; background-position: center;">
											<div class="flip-content my-4">
												<h4 class="font-weight-bold text-color-light">World of STYX</h4>
												<p class="font-weight-light text-color-black">
													<?=lang('INFOCARD_TEXT_CARD')?></p>
												<a href="#" class="btn btn-light btn-modern text-color-dark font-weight-bold"><?=lang('MORE_INFO')?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
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
                          									  <span> <a href="<?=BASE_URL.'kontakt'?>"><i class="fas fa-reply"></i> <?=lang('COMMENT_REPLY')?></a></span></span>
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
											<p class="mb-0"><?=lang('COMMENT_REPLY_TEXT')?>
											</p>
										</div>
									</div>

								</div>
							</div>
							<br>
							<form class="contact-form p-4 rounded bg-color-grey" action="<?=BASE_URL?>app/workshops" method="POST">
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
											<input type="hidden" name="section_id" value="Workshops">
											<input type="hidden" name="lang" value="<?=language()?>">
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

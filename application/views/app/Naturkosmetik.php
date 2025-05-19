
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

						<h2 class="font-weight-semi-bold"><?=lang('NATURKOSMETIK_HEADING')?></a></h2>

						<div class="post-meta">
							<h4 class="text-color-black"><?=lang('NATURKOSMETIK_SUBHEADING')?></h4>

							<span><i class="far fa-comments"></i><?=$sumComment?> Comments</span>
						</div>
						<img src="<?=BASE_URL?>img/image/naturcosmetic.jpg" class="img-fluid float-start me-4 mt-2" alt="" />
						<h4><?=lang('NATURKOSMETIK_SUBHEADING_TEXT')?></h4>
						<p><?=lang('NATURKOSMETIK_LONGTEXT')?></p>

						<div class="post-block mt-5 post-share">
							<a href="https://shop.styx.at/" class="btn btn-primary w-50 mb-2"><?=lang('ZUR_HOMA_PAGE')?></a>

							<!-- Go to www.addthis.com/dashboard to customize your tools -->
							<div class="addthis_inline_share_toolbox"></div>
							<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60ba220dbab331b0"></script>

						</div>
					</div>
				</article>

			</div>
		</div>
	</div>

</div>

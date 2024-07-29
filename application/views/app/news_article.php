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
	<!-- Začiatok sekcie, ktorá obalí obsah článku -->
	<section class="container">
		<div class="row">
			<div class="col">
				<?=$news_article->content?>
			</div>
		</div>
	</section>
	<!-- Koniec sekcie -->
</div>

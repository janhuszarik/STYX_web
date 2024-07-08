<div class="error-page container-fluid no-padding">
	<div class="section-padding"></div>
	<!-- Container -->
	<div class="container">
		<!-- Section Header -->
		<div class="section-header404">
			<h3 class="text-center">Die Seite, die Sie aufgerufen haben... <br> wurde nicht gefunden!</h3>
		</div><!-- Section Header /- -->

		<div class="text-center picisvor"><sup>Fehler</sup>404</div>

		<div class="error-code text-center">
			<img src="<?=BASE_URL?>img/404.gif" alt="404" />
		</div>

		<div class="row cols-xl-4 cols-lg-3 cols-sm-2 cols-1 mb-10">
			<div class="col-sm-12"><div class="text-center text-orange fs-large"><strong>Warten Sie!</strong> Wir haben noch Homepage!
					<a href="https://www.styx.at">STYX Naturcosmetic</a></div></div>

			<?php foreach ($random_products->products as $rp){?>
				<div class="product-widget-wrap">
					<div class="product product-widget">
						<figure class="product-media">
							<a href="<?=BASE_URL.$rp->cetegory_url.'/'.$rp->url?>">
								<img src="<?=BASE_URL.obrpridajthumb($rp->image)?>" alt="<?=$rp->name?>" width="100px" height="106px">
							</a>
						</figure>
						<div class="product-details">
							<h4 class="product-name">
								<a href="<?=BASE_URL.$rp->cetegory_url.'/'.$rp->url?>"><?=$rp->name?></a>
							</h4>
							<div class="ratings-container">
								<div class="ratings-full">
									<span class="ratings" style="width: <?=ratingToPercent($rp->avgrate)?>%;"></span>
									<span class="tooltiptext tooltip-top"></span>
								</div>
							</div>
							<div class="product-price">
								<ins class="new-price"><?=!empty($rp->action_price) ? $rp->action_price.'&nbsp;€' : $rp->price.'&nbsp;€' ?></ins>
							</div>
						</div>
					</div>
				</div>

			<?php }?>
		</div><!-- Container /-  -->
		<div class="section-padding"></div>
	</div><!-- 404 /- -->

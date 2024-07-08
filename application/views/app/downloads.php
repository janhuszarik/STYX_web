<style>
	.text-background {
		display: inline-block;
		background-color: rgba(255, 255, 255, 0.8);
		color: black;
		padding: 30px;
		border-radius: 5px;
	}

	.button-container {
		display: flex;
		justify-content: center;
		gap: 20px;
		margin-top: 20px;
	}

	.button {
		display: flex;
		flex-direction: column;
		text-align: center;
		padding: 10px;
		background-color: #98d0ff;
		color: white;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		text-decoration: none;
		width: 400px;
	}

	.button-part {
		padding: 10px;
		border-bottom: 1px solid #0056b3;
		color: white;
	}

	.button-part:last-child {
		border-bottom: none;
	}

	.single-button {
		width: 400px;
		height: auto;
		display: flex;
		align-items: center;
		justify-content: center;
	}
</style>

<div role="main" class="main">
	<section class="page-header page-header-modern page-header-background page-header-background-md" style="background-image: url('<?=BASE_URL?>img/remise/downloadsBanner.jpg');">
		<div class="container">
			<div class="row mt-5">
				<div class="col-md-12 align-self-center p-static order-2 text-center">
					<div class="text-background">
						<h1 style="color: #0a0a0a" class="text-9 font-weight-bold"><?=$title?></h1>
						<span style="color: #0a0a0a" class="sub-title">REMISE | STYX Naturcosmetic</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="container">
		<div class="row pb-5">
			<div class="col-md-9 mx-md-auto">
				<div class="overflow-hidden mb-3">
					<h2 class="word-rotator slide font-weight-bold text-8 mb-0 appear-animation text-left" data-appear-animation="maskUp">
						<span>Aktuell zum Herunterladen</span>
					</h2>
				</div>
				<div class="button-container">
					<div class="button">
						<a href="<?=BASE_URL?>img/downloads/RemiseFolder2021.pdf" target="_blank" class="button-part">Folder "STYX Remise" PDF anzeigen</a>
						<a href="<?=BASE_URL?>img/downloads/RemiseFolder2021.pdf" download class="button-part">Folder "STYX Remise" PDF herunterladen</a>
					</div>
					<a href="<?=BASE_URL?>img/downloads/STYX_Remise.zip" download class="button single-button">Logos und Pressematerial ZIP herunterladen</a>
				</div>
			</div>
		</div>
	</div>
</div>

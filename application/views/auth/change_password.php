<!DOCTYPE html>
<html lang="<?php language()?>">
<head>
	<title><?=$title?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<!-- External CSS libraries -->
	<link type="text/css" rel="stylesheet" href="<?=BASE_URL?>assetsLogin/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="<?=BASE_URL?>assetsLogin/fonts/font-awesome/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="<?=BASE_URL?>assetsLogin/fonts/flaticon/font/flaticon.css">

	<!-- Favicon icon -->
	<link rel="shortcut icon" href="<?=BASE_URL?>img/icon/favicon.ico" type="image/x-icon" >

	<!-- Google fonts -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

	<!-- Custom Stylesheet -->
	<link type="text/css" rel="stylesheet" href="<?=BASE_URL?>assetsLogin/css/style.css">
	<link rel="stylesheet" type="text/css" id="style_sheet" href="<?=BASE_URL?>assetsLogin/css/skins/default.css">

</head>
<body id="top">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TAGCODE"
				  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="page_loader"></div>

<!-- Login 4 start -->
<div class="login-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-8 col-lg-7 col-md-12 bg-img">
				<div class="info">
					<div class="animated-text mb-3">
						<div class="char1" style="animation-delay: .1s;">Ú</div>
						<div class="char2" style="animation-delay: .2s;">Č</div>
						<div class="char3" style="animation-delay: .3s;">T</div>
						<div class="char4" style="animation-delay: .4s;">O</div>
						<div class="char5" style="animation-delay: .5s;">V</div>
						<div class="char6" style="animation-delay: .6s;">N</div>
						<div class="char7" style="animation-delay: .7s;">Í</div>
						<div class="char8" style="animation-delay: .8s;">C</div>
						<div class="char8" style="animation-delay: .9s;">T</div>
						<div class="char5" style="animation-delay: .5s;">V</div>
						<div class="char6" style="animation-delay: .6s;">O</div>
					</div>
					<div class="animated-text mb-3">
						<div class="char1" style="animation-delay: .1s;">A</div>
						<div class="char2" style="animation-delay: .2s;">U</div>
						<div class="char3" style="animation-delay: .3s;">S</div>
						<div class="char4" style="animation-delay: .4s;">T</div>
						<div class="char5" style="animation-delay: .5s;">R</div>
						<div class="char6" style="animation-delay: .6s;">I</div>
						<div class="char7" style="animation-delay: .7s;">A</div>
					</div>

				</div>
			</div>
			<div class="col-xl-4 col-lg-5 col-md-12 bg-color-4">
				<div class="form-section">
					<div class="logo">
						<a href="<?=BASE_URL?>"><img src="<?=LOGO_WHITE?>" alt="logo"></a>
					</div>
					<h3>Zmena hesla</h3>
					<div class="text-center" id="infoMessage" style="color:orangered;"><?php echo $message;?></div>

					<div class="login-inner-form">

						<form class="user" method="post" action="<?=BASE_URL?>auth/change_password">

							<div class="form-group clearfix">
								<label for="old_password" class="form-label"><?php echo lang('change_password_old_password_label', 'old_password');?></label>
								<div class="form-box">
									<?php echo form_input($old_password, '', 'class="form-control custom-class" placeholder="Staré heslo"');?>
								</div>
							</div>

							<div class="form-group clearfix">
								<label for="new_password" class="form-label"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label>
								<div class="form-box">
									<?php echo form_input($new_password, '', 'class="form-control custom-class" placeholder="Nové heslo"');?>
								</div>
							</div>

							<div class="form-group clearfix">
								<label for="new_password_confirm" class="form-label"><?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?></label>
								<div class="form-box">
									<?php echo form_input($new_password_confirm, '', 'class="form-control custom-class" placeholder="Potvrdenie nového hesla"');?>
								</div>
							</div>

							<?php echo form_input($user_id);?>

							<div class="form-group clearfix mb-0">
								<?php echo form_submit('submit', lang('change_password_submit_btn'), 'class="btn btn-primary btn-lg btn-theme"');?>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Login 4 end -->

<!-- External JS libraries -->
<script src="<?=BASE_URL?>assetsLogin/js/jquery.min.js"></script>
<script src="<?=BASE_URL?>assetsLogin/js/popper.min.js"></script>
<script src="<?=BASE_URL?>assetsLogin/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS Script -->
</body>
</html>

















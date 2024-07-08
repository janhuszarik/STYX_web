<!DOCTYPE html>
<html lang="<?php language()?>">
<head>
	<title><?=$title?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<!-- External CSS libraries -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

	<link type="text/css" rel="stylesheet" href="<?=BASE_URL?>assetsLogin/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="<?=BASE_URL?>adm/plugins/font-awesome-free/css/all.css">
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
						<a href="<?=BASE_URL?>"><img src="<?=BASE_URL.LOGO_WHITE?>" alt="logo"></a>
					</div>
					<h3>Registrácia</h3>
					<div class="login-inner-form">
						<?php echo $message; ?>

						<?php echo form_open("auth/register");?>

						<div class="form-group clearfix">
								<label for="third_field" class="form-label">Meno</label>
								<div class="form-box">
									<input name="first_name" type="text" class="form-control" id="third_field" placeholder="napr.:Martin" aria-label="first_name">
									<i class="flaticon-user"></i>
								</div>
						</div>
						<div class="form-group clearfix">
							<label for="third_field" class="form-label">Priezvisko</label>
								<div class="form-box">
									<input name="last_name" type="text" class="form-control" id="third_field" placeholder="napr.: Mrkvička" aria-label="last_name">
									<i class="flaticon-user"></i>
								</div>
						</div>
							<div class="form-group clearfix">
								<label for="first_field" class="form-label">Emailová adresa</label>
								<div class="form-box">
									<input name="email" type="text" class="form-control" id="first_field" placeholder="napr.: martinmrkvicka@gmail.com" aria-label="Email Address">
									<i class="flaticon-mail-2"></i>
								</div>
							</div>
						<div class="form-group clearfix">
								<label for="first_field" class="form-label">Kontakt</label>
								<div class="form-box">
									<input name="phone" type="text" class="form-control" id="first_field" placeholder="napr.:0903 333 333" aria-label="phone">
									<i><img src="<?=BASE_URL?>img/icon/phone.png" alt="phone icon"></i>
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="second_field" class="form-label">Heslo</label>
								<div class="form-box">
									<input name="password" type="password" class="form-control" autocomplete="off" id="second_field" placeholder="heslo min.8 znakov" aria-label="Password" minlength="8">
									<span id="passwordError" style="color: red;"></span>
									<i class="flaticon-password"></i>
								</div>
							</div>
						<div class="form-group clearfix">
								<label for="second_field" class="form-label">Heslo opakovať</label>
								<div class="form-box">
									<input name="password_confirm" type="password" class="form-control" autocomplete="off" id="second_field" placeholder="heslo zopakovať" aria-label="password_confirm" minlength="8">
									<span id="passwordError" style="color: red;"></span>
									<i class="flaticon-password"></i>
								</div>
							</div>
							<div class="form-group checkbox clearfix">
								<div class="clearfix float-start">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="rememberme">
										<label class="form-check-label" for="rememberme">
											Súhlasím zo spracovaním <strong style="color: #132b82"> Osobných údajov</strong>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group clearfix mb-0">
								<button type="submit" class="btn btn-primary btn-lg btn-theme">Register</button>
							</div>

						<?php echo form_close();?>
					</div>
					<p class="text-center">Už existuje účet?<a href="<?=BASE_URL?>login"> PRIHLÁSIŤ SA!</a></p>
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






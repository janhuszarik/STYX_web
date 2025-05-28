<!DOCTYPE html>
<html lang="de">
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

<!-- Login 39 start -->
<div class="login-39">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-section">
					<div class="logo-2">
						<a href="<?=BASE_URL?>">
							<img src="<?=BASE_URL.LOGO?>" alt="logo">
						</a>
					</div>
					<h3>Anmelden in Ihrem Konto</h3>
					<form class="user" method="post" action="<?=BASE_URL?>login">
						<div class="form-group form-box">
							<?php echo form_input($identity,'','class="form-control" placeholder="Email"');?>
							<i class="flaticon-mail-2"></i>
						</div>
						<div class="form-group form-box">
							<?php echo form_input($password,'', 'class="form-control" placeholder="Heslo"');?>
							<i class="flaticon-password"></i>
						</div>
						<div class="form-group mb-0 clearfix">
							<button type="submit" class="btn-md btn-theme float-start">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Login 39 end -->

<!-- External JS libraries -->
<script src="<?=BASE_URL?>assetsLogin/js/jquery.min.js"></script>
<script src="<?=BASE_URL?>assetsLogin/js/popper.min.js"></script>
<script src="<?=BASE_URL?>assetsLogin/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS Script -->

</body>
</html>

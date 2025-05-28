<!DOCTYPE html>
<html lang="<?=language()?>">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
	<title><?=$title?></title>
	<meta name="description" content="<?=$description?>">
	<meta name="keywords" content="<?=$keywords?>">
	<meta name="author" content="<?=AUTHOR?>">
	<meta name="robots" content="index, follow">

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?=BASE_URL?>img/icon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="<?=BASE_URL?>img/icon/favicon.ico">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?=BASE_URL . $_SERVER['REQUEST_URI']?>">
	<meta property="og:title" content="<?=$title?>">
	<meta property="og:description" content="<?=$description?>">
	<meta property="og:image" content="<?=BASE_URL?>img/og-image.jpg">
	<meta property="og:site_name" content="<?=COMPANY?>">
	<meta property="og:locale" content="<?=language()?>">

	<!-- Twitter Card -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?=$title?>">
	<meta name="twitter:description" content="<?=$description?>">
	<meta name="twitter:image" content="<?=BASE_URL?>img/og-image.jpg">
	<meta name="twitter:creator" content="@your_twitter_handle">

	<!-- Canonical URL -->
	<link rel="canonical" href="<?=BASE_URL . $_SERVER['REQUEST_URI']?>">

	<!-- Web Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Shadows+Into+Light&display=swap">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?=BASE_URL?>assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/vendor/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/vendor/animate/animate.compat.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/vendor/simple-line-icons/css/simple-line-icons.min.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/vendor/owl.carousel/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/vendor/owl.carousel/assets/owl.theme.default.min.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/vendor/magnific-popup/magnific-popup.min.css">

	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?=BASE_URL?>assets/css/theme.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/css/theme-elements.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/css/theme-blog.css">
	<link rel="stylesheet" href="<?=BASE_URL?>assets/css/theme-shop.css">

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?=BASE_URL?>assets/css/skins/default.css">

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?=BASE_URL?>assets/css/custom.css">

	<!-- Head Scripts -->
	<script src="<?=BASE_URL?>assets/vendor/modernizr/modernizr.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

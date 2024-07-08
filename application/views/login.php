<!DOCTYPE html>
<html lang="<?=language()?>">
<head>
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="<?=BASE_URL?>assetsLogin/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?=BASE_URL?>assetsLogin/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?=BASE_URL?>assetsLogin/fonts/flaticon/font/flaticon.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?=BASE_URL.'favicon/favicon.ico'?>">
    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
<div id="infoMessage"><?php echo $message;?></div>

<?php if ($this->ion_auth->logged_in()): ?>
    <!-- Ak je používateľ prihlásený -->
    <div class="login-16">
        <div class="login-16-inner">
            <div class="container">
                <div class="row login-box justify-content-center">
                    <div class="col-lg-6 align-self-center pad-0">
                        <div style="padding: 80px 0;" class="form-section align-self-center">
                            <div class="logo mobile-only">
                                <a href="<?= BASE_URL ?>">
                                    <img src="<?= LOGO_WHITE_SVG ?>" alt="logo">
                                </a>
                            </div>
                            <h4>Už si prihlásený. <br>Odhlás sa alebo prejdi do Admina</h4>
                            <br>
                            <div class="form-group clearfix text-center">
                                <a href="<?=BASE_URL?>admin" class="btn btn-primary custom-btn">Administrátor</a>
                            </div>
                            <div class="form-group clearfix text-center">
                                <a href="<?=BASE_URL?>logout" class="btn btn-primary custom-btn">Odhlásiť sa</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php else: ?>
    <!-- Ak nie je používateľ prihlásený -->
    <!-- Login 13 start -->
    <div class="login-16">
        <div class="login-16-inner">
            <div class="container">
                <div class="row login-box">
                    <div class="col-lg-6 align-self-center pad-0">
                        <div class="form-section align-self-center">
                            <div class="logo mobile-only">
                                <a href="<?= BASE_URL ?>">
                                    <img src="<?= LOGO_WHITE_SVG ?>" alt="logo">
                                </a>
                            </div>

                            <h3>Prihlás so do svojho konta</h3>

                            <form class="user" method="post" action="<?=BASE_URL?>login">
                                <div class="login-inner-form">
                                    <div class="form-group clearfix">
                                        <div class="form-box">
                                            <input name="identity" type="email" class="form-control" id="exampleInputEmail" placeholder="Email Address" aria-label="Email Address">
                                            <i class="flaticon-mail-2"></i>
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <div class="form-box">
                                            <input name="password" type="password" class="form-control" autocomplete="off" id="exampleInputPassword" placeholder="Password" aria-label="Password">
                                            <i class="flaticon-password"></i>
                                        </div>
                                    </div>
                                    <div class="checkbox form-group clearfix">
                                        <div class="form-check float-start">
                                            <input class="form-check-input" type="checkbox" id="rememberme">
                                            <label class="form-check-label" for="rememberme">
                                                Pamätaj si ma
                                            </label>
                                        </div>
                                        <a href="<?=BASE_URL?>auth/forgot_password" class="link-light float-end forgot-password">Zabudnuté heslo?</a>
                                    </div>
                                    <div class="form-group clearfix">
                                        <button type="submit" class="btn btn-primary btn-lg btn-theme w-100">Prihlásenie</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-center pad-0 bg-img">
                        <div class="info clearfix">
                            <div class="box">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <div class="content">
                                    <img src="<?=BASE_URL.'img/websiteappLogo.svg'?>" width="350px" alt="logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ocean">
                <div class="wave"></div>
                <div class="wave"></div>
            </div>
        </div>
    </div>
    <!-- Login 13 end -->
<?php endif; ?>

<!-- External JS libraries -->
<script src="<?=BASE_URL?>assetsLogin/js/jquery.min.js"></script>
<script src="<?=BASE_URL?>assetsLogin/js/popper.min.js"></script>
<script src="<?=BASE_URL?>assetsLogin/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS Script -->
</body>
</html>

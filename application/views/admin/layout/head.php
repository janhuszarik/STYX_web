<!doctype html>
<html class="fixed sidebar-light">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">
	<title>STYX</title>
	<meta name="keywords" content="STYX REMISE | ADMIN" />
	<meta name="description" content="STYX REMISE | ADMIN">
	<meta name="author" content="Jan Huszarik">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?=BASE_URL?>img/icon/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?=BASE_URL?>img/icon/apple-touch-icon.png">
	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->

	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/animate/animate.compat.css">
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/font-awesome/css/all.min.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/boxicons/css/boxicons.min.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/jquery-ui/jquery-ui.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/jquery-ui/jquery-ui.theme.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/select2/css/select2.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/dropzone/basic.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/dropzone/dropzone.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/vendor/summernote/summernote-bs4.css" />

	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/css/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/css/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?=BASE_URL?>adm/assets/css/custom.css">

	<!-- Head Libs -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
</head>

<body>
<section class="body">

	<!-- start: header -->
	<header class="header">
		<div class="logo-container">
			<a href="<?=BASE_URL?>" class="logo">
				<img src="<?=BASE_URL.LOGO?>" width="75" height="35" alt="Porto Admin" />
			</a>

			<div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
				<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
			</div>

		</div>

		<!-- start: search & user box -->
		<div class="header-right">

			<form action="pages-search-results.html" class="search nav-form">
				<div class="input-group">
					<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
					<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
				</div>
			</form>

			<span class="separator"></span>

			<ul class="notifications">
				<li>
					<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
						<i class="bx bx-list-ol"></i>
						<span class="badge">3</span>
					</a>

					<div class="dropdown-menu notification-menu large">
						<div class="notification-title">
							<span class="float-end badge badge-default">3</span>
							Tasks
						</div>

						<div class="content">
							<ul>
								<li>
									<p class="clearfix mb-1">
										<span class="message float-start">Generating Sales Report</span>
										<span class="message float-end text-dark">60%</span>
									</p>
									<div class="progress progress-xs light">
										<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
									</div>
								</li>

								<li>
									<p class="clearfix mb-1">
										<span class="message float-start">Importing Contacts</span>
										<span class="message float-end text-dark">98%</span>
									</p>
									<div class="progress progress-xs light">
										<div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
									</div>
								</li>

								<li>
									<p class="clearfix mb-1">
										<span class="message float-start">Uploading something big</span>
										<span class="message float-end text-dark">33%</span>
									</p>
									<div class="progress progress-xs light mb-1">
										<div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</li>
				<li>
					<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
						<i class="bx bx-envelope"></i>
						<span class="badge">4</span>
					</a>

					<div class="dropdown-menu notification-menu">
						<div class="notification-title">
							<span class="float-end badge badge-default">230</span>
							Messages
						</div>

						<div class="content">
							<ul>
								<li>
									<a href="#" class="clearfix">
										<figure class="image">
											<img src="img/!sample-user.jpg" alt="Joseph Doe Junior" class="rounded-circle" />
										</figure>
										<span class="title">Joseph Doe</span>
										<span class="message">Lorem ipsum dolor sit.</span>
									</a>
								</li>
								<li>
									<a href="#" class="clearfix">
										<figure class="image">
											<img src="img/!sample-user.jpg" alt="Joseph Junior" class="rounded-circle" />
										</figure>
										<span class="title">Joseph Junior</span>
										<span class="message truncate">Truncated message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam, nec venenatis risus. Vestibulum blandit faucibus est et malesuada. Sed interdum cursus dui nec venenatis. Pellentesque non nisi lobortis, rutrum eros ut, convallis nisi. Sed tellus turpis, dignissim sit amet tristique quis, pretium id est. Sed aliquam diam diam, sit amet faucibus tellus ultricies eu. Aliquam lacinia nibh a metus bibendum, eu commodo eros commodo. Sed commodo molestie elit, a molestie lacus porttitor id. Donec facilisis varius sapien, ac fringilla velit porttitor et. Nam tincidunt gravida dui, sed pharetra odio pharetra nec. Duis consectetur venenatis pharetra. Vestibulum egestas nisi quis elementum elementum.</span>
									</a>
								</li>
								<li>
									<a href="#" class="clearfix">
										<figure class="image">
											<img src="img/!sample-user.jpg" alt="Joe Junior" class="rounded-circle" />
										</figure>
										<span class="title">Joe Junior</span>
										<span class="message">Lorem ipsum dolor sit.</span>
									</a>
								</li>
								<li>
									<a href="#" class="clearfix">
										<figure class="image">
											<img src="img/!sample-user.jpg" alt="Joseph Junior" class="rounded-circle" />
										</figure>
										<span class="title">Joseph Junior</span>
										<span class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam.</span>
									</a>
								</li>
							</ul>

							<hr />

							<div class="text-end">
								<a href="#" class="view-more">View All</a>
							</div>
						</div>
					</div>
				</li>
				<li>
					<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
						<i class="bx bx-bell"></i>
						<span class="badge">3</span>
					</a>

					<div class="dropdown-menu notification-menu">
						<div class="notification-title">
							<span class="float-end badge badge-default">3</span>
							Alerts
						</div>

						<div class="content">
							<ul>
								<li>
									<a href="#" class="clearfix">
										<div class="image">
											<i class="fas fa-thumbs-down bg-danger text-light"></i>
										</div>
										<span class="title">Server is Down!</span>
										<span class="message">Just now</span>
									</a>
								</li>
								<li>
									<a href="#" class="clearfix">
										<div class="image">
											<i class="bx bx-lock bg-warning text-light"></i>
										</div>
										<span class="title">User Locked</span>
										<span class="message">15 minutes ago</span>
									</a>
								</li>
								<li>
									<a href="#" class="clearfix">
										<div class="image">
											<i class="fas fa-signal bg-success text-light"></i>
										</div>
										<span class="title">Connection Restaured</span>
										<span class="message">10/10/2023</span>
									</a>
								</li>
							</ul>

							<hr />

							<div class="text-end">
								<a href="#" class="view-more">View All</a>
							</div>
						</div>
					</div>
				</li>
			</ul>

			<span class="separator"></span>

			<div id="userbox" class="userbox">
				<a href="#" data-bs-toggle="dropdown">
					<figure class="profile-picture">
						<img src="img/!logged-user.jpg" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/!logged-user.jpg" />
					</figure>
					<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
						<span class="name">John Doe Junior</span>
						<span class="role">Administrator</span>
					</div>

					<i class="fa custom-caret"></i>
				</a>

				<div class="dropdown-menu">
					<ul class="list-unstyled mb-2">
						<li class="divider"></li>
						<li>
							<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="bx bx-user-circle"></i> My Profile</a>
						</li>
						<li>
							<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="bx bx-lock"></i> Lock Screen</a>
						</li>
						<li>
							<a role="menuitem" tabindex="-1" href="pages-signin.html"><i class="bx bx-power-off"></i> Logout</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- end: search & user box -->
	</header>
	<!-- end: header -->

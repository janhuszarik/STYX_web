<?php $user = $this->ion_auth->user()->row(); ?>
<section class="body">

	<!-- start: header -->
	<header class="header">
		<div class="logo-container">
			<a href="<?=BASE_URL.'admin'?>" class="logo">
				<img src="<?=BASE_URL.LOGO?>" width="150" height="35" alt="Remise-Admin logo" />
			</a>

			<div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
				<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
			</div>

		</div>

		<!-- start: search & user box -->
		<div class="header-right">



			<span class="separator"></span>


			<span class="separator"></span>

			<div id="userbox" class="userbox">
				<a href="#" data-bs-toggle="dropdown">
					<figure class="profile-picture">
						<img src="<?=BASE_URL?>adm/assets/img/!logged-user.png" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/!logged-user.jpg" />
					</figure>
					<div class="profile-info" data-lock-name="<?=$user->first_name.' '.$user->last_name?>" data-lock-email="johndoe@okler.com">
						<span class="name"><?=$user->first_name.' '.$user->last_name?></span>
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

	<div class="inner-wrapper">
		<!-- start: sidebar -->
		<aside id="sidebar-left" class="sidebar-left">

			<div class="sidebar-header">
				<div class="sidebar-title">
					Navigation
				</div>
				<div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
					<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>

			<div class="nano">
				<div class="nano-content">
					<nav id="menu" class="nav-main" role="navigation">

						<ul class="nav nav-main">
							<li>
								<a class="nav-link" href="<?=BASE_URL?>">
									<i class="bx bx-home-alt" aria-hidden="true"></i>
									<span class="float-end badge badge-primary">Hauptmenü</span>

									<span>Dashboard</span>
								</a>
							</li>
							<li>
								<a class="nav-link" href="<?=BASE_URL.'admin/menu'?>">
									<span class="float-end badge badge-primary">Menü web</span>
									<i class="bx bx-menu" aria-hidden="true"></i>
									<span>Menü</span>
								</a>
							</li>
							<li>
								<a class="nav-link" href="<?=BASE_URL.'admin/slider'?>">
									<span class="float-end badge badge-primary">Slider web</span>
									<i class="bx bx-slider" aria-hidden="true"></i>
									<span>Slider</span>
								</a>
							</li>
							<li>
								<a class="nav-link" href="<?=BASE_URL.'admin/news'?>">
									<span class="float-end badge badge-primary">Aktualität sektion</span>
									<i class="bx bx-carousel" aria-hidden="true"></i>
									<span>Aktuell</span>
								</a>
							</li>
							<li>
								<a class="nav-link" href="<?=BASE_URL.'admin/bestProduct'?>">
									<span class="float-end badge badge-primary">Produkte</span>
									<i class="bx bx-history" aria-hidden="true"></i>
									<span>Beliebte produkte</span>
								</a>
							</li>
							<li>
								<a class="nav-link" href="mailbox-folder.html">
									<span class="float-end badge badge-primary"></span>
									<i class="bx bx-envelope" aria-hidden="true"></i>
									<span>Kontakt</span>
								</a>
							</li>
							<li>
								<a class="nav-link" href="<?=BASE_URL.'logout'?>">
									<span class="float-end badge badge-danger">Abmelden</span>
									<i style="color:#f80000;" class="bx bx-stop-circle" aria-hidden="true"></i>
									<span style="color: red">Logout</span>
								</a>
							</li>

						</ul>
					</nav>
				</div>

				<script>
					// Maintain Scroll Position
					if (typeof localStorage !== 'undefined') {
						if (localStorage.getItem('sidebar-left-position') !== null) {
							var initialPosition = localStorage.getItem('sidebar-left-position'),
								sidebarLeft = document.querySelector('#sidebar-left .nano-content');

							sidebarLeft.scrollTop = initialPosition;
						}
					}
				</script>
			</div>
		</aside>

		<section role="main" class="content-body">
			<header class="page-header">
				<h2><?=$title?></h2>

				<div class="right-wrapper text-end">
					<ol class="breadcrumbs">
						<li>
							<a href="<?=BASE_URL?>">
								<i class="bx bx-home-alt"></i>
							</a>
						</li>

						<li><span>REMISE</span></li>

						<li><span><?=$title?></span></li>

					</ol>

					<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
				</div>
			</header>
			<div class="content-wrapper">


				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<?php
						if (!empty($_SESSION)){
							$flash = $this->session->flashdata();
						}

						if (isset($flash['error'])){ ?>
							<div class="alert alert-danger alert-dismissible fade show" id="alertik" role="alert">
								<strong><?= $flash['error'] ?></strong>
							</div>
							<?php unset($_SESSION['error']);
						}

						if (isset($flash['message'])){ ?>
							<div class="alert alert-success alert-dismissible fade show" id="alertik" role="alert">
								<strong><?= $flash['message'] ?></strong>
							</div>
							<?php unset($_SESSION['message']);
						}

						if (isset($flash['warning'])){ ?>
							<div class="alert alert-warning alert-dismissible fade show" id="alertik" role="alert">
								<strong><?= $flash['warning'] ?></strong>
							</div>
							<?php unset($_SESSION['warning']);
						}

						if (isset($flash['success'])){ ?>
							<div class="alert alert-success alert-dismissible fade show" id="alertik" role="alert">
								<strong><?= $flash['success'] ?></strong>
							</div>
							<?php unset($_SESSION['success']);
						} ?>

					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">

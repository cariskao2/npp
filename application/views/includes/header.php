<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $pageTitle; ?></title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- Bootstrap 3.3.4 -->
	<link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"
		type="text/css" />
	<!-- FontAwesome 4.3.0 -->
	<link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet"
		type="text/css" />
	<!-- Ionicons 2.0.0 -->
	<link href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet"
		type="text/css" />
	<!-- Juqery Css -->
	<link href="<?php echo base_url(); ?>assets/bower_components/jquery-ui/themes/base/jquery-ui.min.css"
		rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
	<link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/b/build/css/all.css" rel="stylesheet" type="text/css" />
	<style>
		/* 加上自訂字體中文粗體才有效果 */
		@font-face {
			font-family: KozGoPr6N-Light_0;
			src: url("<?php echo base_url('assets/fonts/KozGoPr6N-Light_0.otf'); ?>");
		}

		* {
			font-family: KozGoPr6N-Light_0;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-weight: bolder;
		}

		.error {
			color: red;
			font-weight: normal;
		}

		.btn {
			border-radius: 0;
		}
	</style>
	<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.js"></script>
	<script src="<?php echo base_url(); ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/ckeditor4/ckeditor/ckeditor.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/additional-methods.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		var baseURL = "<?php echo base_url(); ?>";
	</script>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<!-- Logo -->
			<a href="<?php echo base_url(); ?>" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><img style="width:25px"
						src="<?php echo base_url('assets/dist/img/npp-logo.png'); ?>" class="user-image"
						alt="img not found" /></span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg">時代力量後台管理</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-fixed-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="title-on-top"><a class="hover-bg"><?php if (!empty($navTitle)) {
    echo $navTitle;
}?></a></li>
						<li class="dropdown tasks-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-history"></i>
							</a>
							<ul class="dropdown-menu">
								<li class="header"> 最後登入時間 : <i class="fa fa-clock-o"></i>
									<?=empty($last_login) ? "First Time Login" : $last_login;?></li>
							</ul>
						</li>
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img style="width:20px" src="<?php echo base_url(); ?>assets/dist/img/npp-logo.png"
									class="img-circle" alt="User Image" />
								<span class="hidden-xs"><?php echo $name; ?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="<?php echo base_url(); ?>assets/dist/img/npp-logo.png" class="img-circle"
										alt="User Image" />
									<p>
										<span
											style="display:block;font-size:30px;margin-top:-15px;margin-bottom:5px"><?php echo $name; ?></span>
										<small><?php echo $role_text; ?></small>
									</p>

								</li>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href="<?php echo base_url(); ?>profile" class="btn btn-warning btn-flat"><i
												class="fa fa-user-circle"></i> 個人檔案</a>
									</div>
									<div class="pull-right">
										<a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i
												class="fa fa-sign-out"></i> 登出</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu" data-widget="tree">
					<!-- <li>
						<a href="<?php echo base_url(); ?>dashboard">
							<i class="fa fa-dashboard"></i> <span>控制面板</span></i>
						</a>
					</li> -->
					<li class="treeview">
						<a href="#">
							<i class="fa fa-globe"></i> <span>新聞訊息</span>
							<!-- <span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span> -->
						</a>
						<ul class="treeview-menu">
							<!-- url尾端也要加上/,這樣在在項目列表的第一頁再點擊下方的page1,才不會error -->
							<li><a href="<?php echo base_url(); ?>news/lists/1/">法案及議事說明</a></li>
							<li><a href="<?php echo base_url(); ?>news/lists/2/">懶人包及議題追追追</a></li>
							<li><a href="<?php echo base_url(); ?>news/lists/3/">行動紀實</a></li>
							<li><a href="<?php echo base_url(); ?>news/tagLists/">標籤管理</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-briefcase"></i> <span>重點法案</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="#">法案狀態管理</a></li>
							<li><a href="#">法案類別管理</a></li>
							<li><a href="#">法案草案管理</a></li>
							<li><a href="<?php echo base_url('issues/issuesClassList/'); ?>">議題類別管理</a></li>
							<li><a href="<?php echo base_url('issues/issuesAllList/'); ?>">議題列表管理</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-user"></i> <span>本黨立委</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="<?php echo base_url('members/membersList/'); ?>">立委管理</a></li>
							<li><a href="<?php echo base_url('members/yearLists/'); ?>">屆期管理</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-cog"></i> <span>網站管理</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="<?php echo base_url('website/carouselLists/'); ?>">輪播管理</a></li>
							<li><a href="<?php echo base_url('website/petition'); ?>">陳情須知內容編輯</a></li>
							<li><a href="<?php echo base_url('website/setup/' . true); ?>">其它設定</a></li>
						</ul>
					</li>

					<?php
if ($role == ROLE_ADMIN) {
    ?>
					<li class="treeview">
						<a href="<?php echo base_url(); ?>userListing/" style="cursor:pointer">
							<i class="fa fa-user-plus"></i>
							<span>人員管理</span>
						</a>
					</li>
					<?php }?>
					<?php
if ($role == ROLE_MANAGER) {
    ?>
					<li class="treeview">
						<a href="<?php echo base_url(); ?>user/managerListing/" style="cursor:pointer">
							<i class="fa fa-user-plus"></i>
							<span>編輯人員管理</span>
						</a>
					</li>
					<?php }?>
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>
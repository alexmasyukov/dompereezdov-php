<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ru" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Аксиома.CMS - Система управления сайтом</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="..//cms/template/assets/plugins/jstree/dist/themes/default/style.min.css"/>
<link rel="stylesheet" type="text/css" href="..//cms/template/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="..//cms/template/assets/plugins/select2/select2-metronic.css"/>
<link rel="stylesheet" type="text/css" href="..//cms/template/assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" href="..//cms/template/assets/plugins/data-tables/DT_bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="..//cms/template/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="..//cms/template/assets/css/custom.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/glyphicons/css/glyphicons.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/cms.css" rel="stylesheet" type="text/css"/>

<script src="..//cms/template/assets/plugins/jquery-2.1.0.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>


<script src="..//cms/template/assets/plugins/jquery.json-2.4.js"></script>
<script src="..//cms/template/assets/plugins/jquery.mask.min.js"></script>

<script src="..//cms/plugins/ckeditor/ckeditor.js"></script>

<!--<script src="..//cms/js/menu_active.js"></script>-->
<script src="..//cms/js/tables.js"></script> 
<script src="..//cms/js/modules.js"></script>
<script src="..//cms/js/forms.js"></script>
<script src="..//cms/js/features.js"></script>
<script src="..//cms/system/fileupload/ajaxfileupload.js"></script>
<script src="..//cms/js/catalog_categories.js"></script>
<script src="..//cms/js/documents.js"></script>



<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<a class="navbar-brand" href="admin.php?link=admin">
			<span>Аксиома.CMS</span> | Система управления сайтом
		</a>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<img src="..//cms/template/assets/img/menu-toggler.png" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">
			
			<!-- DROPDOWNS 3 li tega -->
			
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" src="..//cms/template/assets/img/avatar1_small.jpg"/>
					<span class="username">
						<?php echo $admin_name ?>
					</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
				<!--	<li>
						<a href="extra_profile.html">
							<i class="fa fa-user"></i> My Profile
						</a>
					</li>
					<li>
						<a href="page_calendar.html">
							<i class="fa fa-calendar"></i> My Calendar
						</a>
					</li>
					<li>
						<a href="inbox.html">
							<i class="fa fa-envelope"></i> My Inbox
							<span class="badge badge-danger">
								 3
							</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-tasks"></i> My Tasks
							<span class="badge badge-success">
								 7
							</span>
						</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="javascript:;" id="trigger_fullscreen">
							<i class="fa fa-arrows"></i> Full Screen
						</a>
					</li>
					<li>
						<a href="extra_lock.html">
							<i class="fa fa-lock"></i> Lock Screen
						</a>
					</li>  -->
					<li>
						<a href="<?php echo $exit_of_admin_panel_link; ?>">
							<i class="fa fa-key"></i> Выход
						</a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN CONTENT -->
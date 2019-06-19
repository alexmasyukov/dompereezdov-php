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
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="..//cms/template/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="..//cms/template/assets/plugins/select2/select2-metronic.css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="..//cms/template/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="..//cms/template/assets/css/pages/login-soft.css" rel="stylesheet" type="text/css"/>
<link href="..//cms/template/assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="index.html">
		<img src="..//cms/template/assets/img/logo-big.png" alt=""/>
		
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="" method="post">
		<h3 class="form-title" style="color: #FFF;">Введите логин и пароль</h3>
		<?php echo $auth_errors; ?>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
				Заполните все поля!
			</span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Логин</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Логин" name="username"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Пароль</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Пароль" name="password"/>
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			<input type="checkbox" name="remember" value="1" checked/> Запомнить меня </label>
			<button type="submit" class="btn blue pull-right">
			Войти <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<!-- <div class="login-options">
				<h4>Or login with</h4>
				<ul class="social-icons">
					<li>
						<a class="facebook" data-original-title="facebook" href="#">
						</a>
					</li>
					<li>
						<a class="twitter" data-original-title="Twitter" href="#">
						</a>
					</li>
					<li>
						<a class="googleplus" data-original-title="Goole Plus" href="#">
						</a>
					</li>
					<li>
						<a class="linkedin" data-original-title="Linkedin" href="#">
						</a>
					</li>
				</ul>
			</div> -->
		<div class="forget-password">
				<!--<h4>Forgot your password ?</h4> -->
				<p>
					
					<a href="../" id="forget-password" style="color: #ddd;">
						 Вернуться на сайт
					</a>
					
				</p>
			</div>
		<!-- <div class="create-account">
				<p>
					 Don't have an account yet ?&nbsp;
					<a href="javascript:;" id="register-btn">
						 Create an account
					</a>
				</p>
			</div> -->
	</form>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="forget-form" action="index.html" method="post">
		<h3>Forget Password ?</h3>
		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn">
			<i class="m-icon-swapleft"></i> Back </button>
			<button type="submit" class="btn blue pull-right">
			Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
	<!-- BEGIN REGISTRATION FORM -->
	<!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	 2014 &copy; Чита. Веб-студия «Аксиома» 
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
	<script src="..//cms/template/assets/plugins/respond.min.js"></script>
	<script src="..//cms/template/assets/plugins/excanvas.min.js"></script> 
	<![endif]-->
<script src="..//cms/template/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="..//cms/template/assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="..//cms/template/assets/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="..//cms/template/assets/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="..//cms/template/assets/scripts/core/app.js" type="text/javascript"></script>
<script src="..//cms/template/assets/scripts/custom/login-soft.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
		jQuery(document).ready(function() {     
		  App.init();
		  Login.init();
		});
	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
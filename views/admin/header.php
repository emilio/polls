<?php 
	global $poll;
 	switch( PAGE_ACTION ) {
		case 'edit':
			$title = "Editar la encuesta: $poll->question";
			break;
		case 'login':
			$title = "Entrar al panel de administración | " . SITE_NAME;
			break;
		case 'new':
			$title = "Crea una nueva encuesta";
			break;
		case 'password':
			$title = "Genera una contraseña";
			break;
		case 'index':
			$title = "Administración | " . SITE_NAME;
			break;
	}
?><!DOCTYPE html>
<!--[if lt IE 7 & (!IEMobile)]>
<html class="ie ie6 lt-ie7 lt-ie8 lt-ie9 no-js">
<![endif]-->
<!--[if (IE 7) & (!IEMobile)]>
<html class="ie ie7 lt-ie8 lt-ie9 no-js">
<![endif]-->
<!--[if (IE 8) & (!IEMobile)]>
<html class="ie ie8 lt-ie9 no-js">
<![endif]-->
<!--[if IE 9 & (!IEMobile)]>
<html class="ie ie9 no-js">
<![endif]-->
<!--[if (gt IE 9) | (IEMobile) | !(IE)  ]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title><?php echo $title; ?></title>

	<meta name="robots" content="noindex, nofollow">


	<link rel="stylesheet" href="<?php echo Url::asset('admin/css/bootstrap.css' ); ?>">
	<link rel="stylesheet" href="<?php echo Url::asset('admin/css/style.css' ); ?>">
	<script src="<?php echo Url::asset('admin/js/modernizr.js' ); ?>"></script>
</head>
<body>
	<div class="navbar">
		<div class="navbar-inner">
			<a class="brand" href="<?php echo $_SERVER['PHP_SELF'] ?>">Administración</a>
			<ul class="nav">
				<li><a href="<?php echo Url::get() ?>" title="volver al inicio">Inicio</a></li>
				<?php if( IS_ADMIN ): ?>
					<li><a title="Inicio del panel de administración" href="<?php echo Url::get('admin') ?>">Administración</a></li>
					<li<?php if(  PAGE_ACTION === 'new' ) echo " class=\"active\""; ?>><a href="<?php echo Url::get('admin@new'); ?>">Nueva encuesta</a></li>
				<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="container container-fluid">

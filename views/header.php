<?php
	$canonical_url = Url::current();
	switch (PAGE_ACTION) {
		case 'index':
			$title = 'Encuestas | '. SITE_NAME;
			$description = '';
			break;
		case 'view':
			$title = $poll->question . ' | ' . SITE_NAME;
			$description = $poll->description;
			break;
		case 'vote': 
			$title = 'Vota: &quot;' . $poll->question . '&quot; | ' . SITE_NAME;
			$description = 'Vota a la encuesta número ' . $poll->id . ' en '. SITE_NAME;
			break;
	}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">

	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $description ?>">
	<link rel="canonical" href="<?php echo $canonical_url ?>">

	<meta property="og:title" content="<?php echo $title?>">
	<meta property="og:description" content="<?php echo $description ?>">
	<meta property="og:url" content="<?php echo $canonical_url ?>">
	<meta property="og:site_name" content="<?php echo SITE_NAME ?>">

	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@emiliocobos95">
	<meta name="twitter:creator" content="@emiliocobos95">

	<link rel="stylesheet" type="text/css" href="<?php echo Url::asset('css/style.css'); ?>">
</head>
<body class="<?php echo PAGE_CONTROLLER ?> page-<?php echo PAGE_ACTION ?>">
	<div class="container">
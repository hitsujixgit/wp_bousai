<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/reset.css" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/jquery.pageslide.css" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
<?php wp_head(); ?>
</head>
<body>
<div id="container">
<header id="header">
	<p id="site-description"><?php bloginfo('description'); ?></p>
	<h1 id="site-title"><a class="open" href="#nav">メインメニュー</a><a id="site-title-link" href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
	<nav>
		<?php wp_nav_menu(array(
					'theme_location'=>'mainmenu', 
					'container'		=>'', 
					'menu_class'	=>'',
					'items_wrap'	=>'<ul id="nav">%3$s</ul>'));
		?>
	</nav>
</header>
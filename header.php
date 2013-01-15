<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 is-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 is-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="no-js lt-ie10 is-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title><?php (!defined('WPSEO_VERSION')) ? (wp_title('|', true, 'right').bloginfo('name')) : wp_title(''); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<?php do_action('basey_head');
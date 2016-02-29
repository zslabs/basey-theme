<?php

if ( !defined( 'BASEY_VER' ) ) {
	$basey_theme_object = wp_get_theme();
	define( 'BASEY_VER', $basey_theme_object->version );
}

$folder = '/inc/';

$files = array (
	'assets',
	'functions',
	'comments',
	'gallery',
	'search',
	'menus',
	'widgets',
	'custom',
	'output'
);

foreach ($files as $file) {
	locate_template( $folder . $file . '.php', true, true );
}

unset($file);
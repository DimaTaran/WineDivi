<?php
	
	$theme_path = get_stylesheet_directory_uri();
	
	/**
	 * Configuration array for scripts and styles
	 */
	$assets_config = [
		'js' => [
			'main-script' => [
				'handle' => 'main-script',
				'src' => $theme_path . '/assets/js/main.js',
				'deps' => ['jquery'],
				'version' => '1.0.0',
				'in_footer' => true,
				'strategy' => 'defer'
			],
			'slider-script' => [
				'handle' => 'slider-script',
				'src' => $theme_path . '/assets/js/slider.js',
				'deps' => ['jquery'],
				'version' => '1.0.0',
				'in_footer' => true,
				'strategy' => 'async'
			]
		],
		'css' => [
			'parent-style' => [
				'handle' => 'parent-style',
				'src' => get_template_directory_uri() . '/style.css',
				'deps' => [],
				'version' => '1.0.0',
				'media' => 'all'
			],
			'main-style' => [
				'handle' => 'main-style',
				'src' => $theme_path . '/assets/css/main.css',
				'deps' => ['parent-style'],
				'version' => '1.0.0',
				'media' => 'all'
			],
			'responsive-style' => [
				'handle' => 'responsive-style',
				'src' => $theme_path . '/assets/css/responsive.css',
				'deps' => ['main-style'],
				'version' => '1.0.0',
				'media' => 'all'
			]
		]
	];
	
	return $assets_config;
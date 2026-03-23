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
//			'main-react' => [
//				'handle' => 'main-react',
//				'src' => $theme_path . '/assets/js/react.js',
//				'deps' => ['jquery'],
//				'version' => '1.0.0',
//				'in_footer' => true,
//				'strategy' => 'defer'
//			],
		],
		'css' => [
//			'parent-style' => [
//				'handle' => 'parent-style',
//				'src' => get_template_directory_uri() . '/style.css',
//				'deps' => [],
//				'version' => '1.0.0',
//				'media' => 'all'
//			],
			'main-style' => [
				'handle' => 'main-style',
				'src' => $theme_path . '/assets/css/style.css',
				'deps' => ['parent-style'],
				'version' => '1.0.0',
				'media' => 'all'
			],
		]
	];

	return $assets_config;
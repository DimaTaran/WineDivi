<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


use DiviClasses\Options;
use WineDivi\Classes\AddStylesAndScripts;

$options = new Options();
$options->init();

//	Use config file for styles and scripts
$assets_config = require __DIR__ . '/config/styles.php';
// Initialize the class
$assets_handler = new AddStylesAndScripts($assets_config);

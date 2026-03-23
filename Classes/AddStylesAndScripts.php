<?php

/**
 * Assets Configuration and Management for WordPress
 *
 * @package SherryDivi
 */

namespace WineDivi\Classes;

/**
 * Class to handle enqueuing scripts and styles in WordPress
 */
class AddStylesAndScripts {
	/**
	 * Configuration array for assets
	 *
	 * @var array
	 */
	private $config;
	
	/**
	 * Constructor
	 *
	 * @param array $config Configuration array for assets
	 */
	public function __construct($config) {
		$this->config = $config;
		
		// Add hooks for enqueueing scripts and styles
		add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);
		add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
		add_action( 'wp_enqueue_scripts', [$this, 'safeRemoveDiviChildStyles'], 20 );
	}
	
	/**
	 * Enqueue styles based on configuration
	 */
	public function enqueueStyles() {
		if (!isset($this->config['css']) || !is_array($this->config['css'])) {
			return;
		}
		
		foreach ($this->config['css'] as $style) {
			wp_enqueue_style(
				$style['handle'],
				$style['src'],
				$style['deps'],
				$style['version'],
				$style['media']
			);
		}
	}
	
	/**
	 * Enqueue scripts based on configuration
	 */
	public function enqueueScripts() {
		if (!isset($this->config['js']) || !is_array($this->config['js'])) {
			return;
		}
		
		foreach ($this->config['js'] as $script) {
			wp_enqueue_script(
				$script['handle'],
				$script['src'],
				$script['deps'],
				$script['version'],
				$script['in_footer']
			);
			
			// Add strategy (defer or async) if provided
			if (isset($script['strategy']) && in_array($script['strategy'], ['defer', 'async'])) {
				wp_script_add_data($script['handle'], 'strategy', $script['strategy']);
			}
		}
	}
	
	// Delete style.css from the child theme
	function safeRemoveDiviChildStyles() {
		if ( wp_style_is( 'divi-style-child', 'enqueued' ) ) {
			wp_dequeue_style( 'divi-style-child' );
		}
		
		if ( wp_style_is( 'divi-style-child', 'registered' ) ) {
			wp_deregister_style( 'divi-style-child' );
		}
	}

}
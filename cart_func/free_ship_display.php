<?php
// Display text for free shipping sum JS script in /js/cart.js
if ( ! function_exists('cart_scripts_styles')) {
    function cart_scripts_styles()
    {
        $template_dir = get_theme_file_uri();
        $theme_version = et_get_theme_version();

        // Get amount from DB and settings
//        $free_shipping_settings = get_option('woocommerce_free_shipping_1_settings');
//        $min_amount = $free_shipping_settings['min_amount'];

        if ( is_cart()) {
            $data_array = array(
                'sum' => (new WC_Shipping_Free_Shipping(1))->min_amount, // Get min amount from shipping object
            );

            wp_enqueue_script('cart-custom-script', $template_dir . '/js/cart.js', array(), $theme_version, true);
            wp_localize_script( 'cart-custom-script', 'delivery', $data_array );
        }

    }

    add_action('wp_enqueue_scripts', 'cart_scripts_styles');
}
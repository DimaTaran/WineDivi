<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// autoload Classes
require_once('vendor/autoload.php');

// load files with function
require_once('attr_function/image-to-attr.php');
require_once('product_function/add-to-cart.php');
require_once ('cart_func/free_ship_display.php');


// includes CONSTANS
require_once "product_function/constans.php";
// autoload Classes


use WineDivi\Classes\CustomEnqueueStyles;
use WineDivi\Classes\LoopExtensions;
use WineDivi\Classes\ProductExtensions;
use WineDivi\Classes\GeneralClasses;
use WineDivi\Classes\Telegram;
use WineDivi\Classes\ShopCustomOrder;
use WineDivi\Classes\CustomOrder;




// Instances of Classes
$ProductExtensions = new ProductExtensions();
$LoopProductObject = new LoopExtensions();
$CustomEnqueueStyles = new CustomEnqueueStyles();
$telegram =  new Telegram();
$customOrder = new ShopCustomOrder();
$order = new CustomOrder();



//  free_shipping_amount_shortcode do
//$free_shop_amount = new WC_Shipping_Free_Shipping(1);
$GeneralClasses = new GeneralClasses(new WC_Shipping_Free_Shipping(1));


// send messages on Telegram and other messangers
$telegram->init();


// delete woo style css from blog page
add_action( 'wp_enqueue_scripts', array( $CustomEnqueueStyles, 'custom_manage_woo_styles' ), 99 );

// text on sparkling category
add_action('woocommerce_after_shop_loop', array($LoopProductObject, 'archive_text_footer'), 12 );

//display text to footer
add_action('get_footer', array($LoopProductObject, 'text_to_footer'));

//display product attribites on loop page
add_action('woocommerce_after_shop_loop_item_title', array( $LoopProductObject, 'attr_to_loop' ), 12 );

//Add a custom product data tab
add_filter( 'woocommerce_product_tabs', array( $ProductExtensions, 'woo_new_product_tab' ) );

//Add chaeccked on checkout page to terms
add_filter('woocommerce_terms_is_checked_default',  array( $GeneralClasses, 'termsChecked' ) );

// add woo advance search form fom mobile
add_action( 'et_header_top', array($CustomEnqueueStyles, 'add_mobile_search'), 20 );

//display product sales on single product page
add_action( 'woocommerce_single_product_summary', array( $ProductExtensions, 'displaySalesCountSingle' ), 11 );

//display product sales on category product page
add_action( 'woocommerce_after_shop_loop_item_title', array( $ProductExtensions, 'displaySalesCountCategory' ), 11 );

// display attributes in  menu
add_filter('woocommerce_attribute_show_in_nav_menus', array( $GeneralClasses, 'attrForMenus' ), 1, 2);

define('SAPHALI_LITE_SYMBOL', 1 );
add_filter( 'woocommerce_currency_symbol',  'add_inr_currency_symbol', 1, 2 );
function add_inr_currency_symbol( $symbol , $currency ) {
    if(empty($currency))
        $currency = get_option( 'woocommerce_currency' );
    if(isset($currency)) {
        if ( version_compare( WOOCOMMERCE_VERSION, '2.5.2', '<' ) || SAPHALI_LITE_SYMBOL ):
            switch( $currency ) {
                case 'UAH': $symbol = '&#x433;&#x440;&#x43D;.'; break;
            }
        else:
            switch( $currency ) {
                case 'UAH': $symbol = '&#x433;&#x440;&#x43D;.'; break;
            }
        endif;
    }
    return $symbol;
}
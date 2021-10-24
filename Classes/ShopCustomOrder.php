<?php


namespace WineDivi\Classes;


class ShopCustomOrder
{

    public function __construct()
    {
        add_filter( 'woocommerce_get_catalog_ordering_args', [$this, 'custom_woocommerce_get_catalog_ordering_args'] );
        add_filter( 'woocommerce_default_catalog_orderby_options', [$this, 'custom_woocommerce_catalog_orderby'] );
        add_filter( 'woocommerce_catalog_orderby', [$this, 'custom_woocommerce_catalog_orderby'] );
    }

    /**
     * Add custom sorting options (asc/desc)
     */
    public function custom_woocommerce_get_catalog_ordering_args( $args ) {
        $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        if ( 'stock_list' == $orderby_value ) {
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = '_stock_status';
            $args['order'] =  'ASC';
        }
        return $args;
    }

    public function custom_woocommerce_catalog_orderby( $sortby ) {
        $sortby['stock_list'] = __('В наличии', 'wine-divi');
        return $sortby;
    }

}
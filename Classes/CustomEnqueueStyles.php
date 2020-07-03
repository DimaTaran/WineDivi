<?php

namespace WineDivi\Classes;

class CustomEnqueueStyles
{

    public function custom_manage_woo_styles() {

        if ( function_exists( 'is_woocommerce' ) ) {

            if ( ! is_front_page() && ! is_page() && ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() || is_page('brands')) {

//                wp_dequeue_style( 'woocommerce-layout' );
//                wp_dequeue_style( 'woocommerce-smallscreen' );
//                wp_dequeue_style( 'woocommerce-general' );
                wp_dequeue_style( 'evolution-woostyles' );
                wp_dequeue_script( 'wc_price_slider' );
                wp_dequeue_script( 'wc-single-product' );
                wp_dequeue_script( 'wc-add-to-cart' );
//                wp_dequeue_script( 'wc-cart-fragments' );
                wp_dequeue_script( 'wc-checkout' );
                wp_dequeue_script( 'wc-add-to-cart-variation' );
//                wp_dequeue_script( 'wc-single-product' );
                wp_dequeue_script( 'wc-cart' );
                wp_dequeue_script( 'wc-chosen' );
                wp_dequeue_script( 'woocommerce' );
                wp_dequeue_script( 'prettyPhoto' );
                wp_dequeue_script( 'prettyPhoto-init' );
                wp_dequeue_script( 'jquery-blockui' );
                wp_dequeue_script( 'jquery-placeholder' );
                wp_dequeue_script( 'fancybox' );
                wp_dequeue_script( 'jqueryui' );

            }

        }
    }


    public function add_mobile_search(){

        if (is_shop() || is_archive() ||  is_front_page()) {
            ?>
            <div class="search-mobile">
                <form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php
                    printf( '<input type="search" class="et-search-field" placeholder="%1$s" value="%2$s" name="s" title="%3$s" />',
                        esc_attr__( 'Search &hellip;', 'Divi' ),
                        get_search_query(),
                        esc_attr__( 'Search for:', 'Divi' )
                    );
                    ?>
                </form>
            </div>
        <?php }
    }

}


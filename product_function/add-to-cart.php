<?php

//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart_new', 10 );

function woocommerce_template_loop_add_to_cart_new() {
    global $woocommerce, $product, $post;

    $delivery_status =  get_post_meta( $product->get_id(), 'delivery_status', true );


    $units_sold =  get_post_meta( $product->get_id(), 'total_sales', true );
    if ( !$units_sold ) {
        $add_to_cart_text = (!$product->managing_stock() && !$product->is_in_stock()) ? apply_filters('add_to_cart_text', __('Не доступно', 'woocommerce')) : apply_filters('add_to_cart_text', __('Купить', 'woocommerce'));
    } else
    $add_to_cart_text = (!$product->managing_stock() && !$product->is_in_stock()) ? apply_filters('add_to_cart_text', __('Продано', 'woocommerce')) : apply_filters('add_to_cart_text', __('Купить', 'woocommerce'));
    if ( $delivery_status == 1 ) {
        $add_to_cart_text = (!$product->managing_stock() && !$product->is_in_stock()) ? apply_filters('add_to_cart_text', __('Ожидается', 'woocommerce')) : apply_filters('add_to_cart_text', __('Купить', 'woocommerce'));
    }
    ?>
    <div class="wrappefr-slide">
        <?php
        switch ( $product->get_type() ) {
            case "variable" :
                woocommerce_variable_add_to_cart();
                break;
            case "grouped" :
                $link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $post->ID ) );
                $label 	= apply_filters( 'grouped_add_to_cart_text', __('Посмотреть опции', 'woocommerce') );
                printf('<a href="%s" rel="nofollow" data-product_id="%s" class="button add_to_cart_button product_type_%s">%s</a>', esc_url( $link ), $post->ID, $product->get_type(), $label);
                break;
            case "external" :
                $link 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
                $label 	= apply_filters( 'external_add_to_cart_text', __('Читать далее', 'woocommerce') );
                printf('<a href="%s" rel="nofollow" data-product_id="%s" class="button add_to_cart_button product_type_%s">%s</a>', esc_url( $link ), $post->ID, $product->get_type(), $label);
                break;
            default :
                $link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
                $label = $add_to_cart_text;
                printf('<a href="%s" rel="nofollow" data-product_id="%s" class="button ajax_add_to_cart add_to_cart_button product_type_%s">%s</a>', esc_url( $link ), $post->ID, $product->get_type(), $label);
                break;
        }
        ?>
    </div>
    <?
}

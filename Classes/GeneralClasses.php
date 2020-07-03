<?php


namespace WineDivi\Classes;

use WC_Shipping_Free_Shipping;

class GeneralClasses
{
    public $free_shop_amount;


    public function __construct(WC_Shipping_Free_Shipping $free_shop_amount)
    {
        $this->free_shop_amount = $free_shop_amount;
        $this->init_shortcode();
    }


    public function free_shipping_amount_shortcode()
    {
        return $this->free_shop_amount->min_amount;
    }

    public function init_shortcode()
    {
        add_shortcode( 'free_shipping_amount', array( $this , 'free_shipping_amount_shortcode' ) );
    }

    public function termsChecked( $isset )
    {
        if ( $isset != true ) {
            return true;
        } else return $isset;
    }

    public function attrForMenus( $register, $name = '' )
    {
        foreach (TAXONOMY_LIST as $item) {
            if ( $name == 'pa_' . $item ) $register = true;
        }
        return $register;
    }

}
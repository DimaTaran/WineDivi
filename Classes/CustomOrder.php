<?php

namespace WineDivi\Classes;

class CustomOrder
{

    public function __construct()
    {
        add_action('woocommerce_admin_order_data_after_billing_address', [$this, 'changeNameOrder'], 11, 1);
    }

    public function changeNameOrder($order)
    {
        if ( ( $last_name = $order->get_billing_last_name()) && ( $first_name = $order->get_billing_first_name() ) ) {
         ?>

            <div class="address">
                <h3><?php esc_html_e( 'Новая почта', 'wine-divi' ); ?></h3>
                <p><?php echo $last_name . ' '  . $first_name; ?></p></div>
            <?php
            if ( $old_nova = $order->get_meta('_billing_new_fild11') ) {
                echo '<p>НП старый №: ' .   $old_nova . '</p>';
            }
            ?>
            <?php
        }
    }

}
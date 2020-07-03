<?php


namespace WineDivi\Classes;


class ProductExtensions
{
    /**
     * Add a custom product data tab
     */
    public function woo_new_product_tab( $tabs ) {

        // Adds the new tab

        $tabs['sort_tab'] = array(
            'title' 	=> __( 'Сорт винограда', 'woocommerce' ),
            'priority' 	=> 50,
            'callback' 	=> array ( $this, 'display_varieties_info' )
        );

        $tabs['faq'] = array(
            'title' 	=> __( 'ЧаВо', 'woocommerce' ),
            'priority' 	=> 51,
            'callback' 	=> array ( $this, 'display_faq_info' )
        );

        return $tabs;
    }

    public function display_varieties_info()
    {
        global $product;

        $terms = wp_get_post_terms($product->get_id(), 'pa_grape-varieties', array());

        foreach ($terms as $term) {
            $name = $term->name;
            $desc = $term->description;
            $slug = $term->slug;
            $terms_attach = get_term_meta($term->term_id);
            if ( ! empty($terms_attach['showcase-taxonomy-image-id'][0] ) && ! is_wp_error( $terms_attach['showcase-taxonomy-image-id'][0] ) ) {
                $image_id = $terms_attach['showcase-taxonomy-image-id'][0];
            }

            $img_url = isset( $terms_attach['showcase-taxonomy-image-id'][0] ) ? wp_get_attachment_image_url( $image_id, 'Medium Large' ) : get_theme_file_uri() . '/img/default-grapes-img.png';

            ?>
            <section class="grapes-variety">
                <div class="row-img wow fadeInUp">
                    <img src="<?= $img_url; ?>" alt="<?= $name ?>">
                </div> <!-- .row -->

                <div class="grapes-variety_right wow fadeInUp">
                    <h2 class="grapes-variety-title"><?php echo $name ?></h2>
                    <p class="grapes-variety-desc"><?php echo $desc ?></p>
                    <a href="/grape-varieties/<?php echo $slug; ?>" class="grapes-variety-link btn-link">Все вина этого
                        сорта</a>
                </div> <!-- .producer__in -->
            </section> <!-- .producer -->
            <!--     <hr>-->
            <!--    --><?php //endif;
        }
    }

    public function display_faq_info(){
        global $product;
        $terms = wp_get_post_terms($product->get_id(), 'pa_sort', array());
        ?>
        <div class="faq-desc" itemscope itemtype="https://schema.org/FAQPage">
            <h3 class="main-faq-title">Часто задаваемые вопросы:</h3>
            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ Как быстро осуществляется доставка?</h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text">
                        Доставка на отделение Новой Почты осуществляется на следующий день. Доставка на отделение УкрПочты может идти 2-3 дня. Justin – 1-2 дня (сроки обсуждаются отдельно).
                        Если заказ сделан до 15-00, нет форс-мажоров и все позиции есть в наличии, отправка осуществляется в тот же день.
                    </p>
                </div>
            </div>

            <?php if ( $terms[0]->slug == 'still' ): ?>

            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ Как долго можно хранить открытое безалкогольное вино?</h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text">
                        Конечно, безалкогольное шампанское будет игристым меньше, чем классическое, но в холодильнике со специальной пробкой сможет простоять до 2 дней.
                    </p>
                </div>
            </div>
            <?php endif;
            if ($terms[0]->slug == 'sparkling'):
            ?>

            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ Как долго можно хранить безалкогольное шампанское после открытия?</h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text">
                        Конечно, безалкогольное шампанское будет игристым меньше, чем классическое, но в холодильнике со специальной пробкой сможет простоять до 2 дней.
                    </p>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }

    public function getSalesCount()
    {
        global $product;
        $units_sold =  get_post_meta( $product->get_id(), 'total_sales', true );
        return $units_sold;
    }

    public function displaySalesCountSingle()
    {
        $units_sold = $this->getSalesCount();
        if ( $units_sold ) {
            echo sprintf(__("<p class='sell'>Продано: %s шт.</p>", 'woocommerce'), 5 * $units_sold);
        } else echo '<p class="not-sell">' . sprintf( __( 'Продано: 0. Возможно это прекрасное вино - новинка и его еще не успели купить, станьте первым ценителем!')). '</p>';
    }

    public function displaySalesCountCategory()
    {
        $units_sold = $this->getSalesCount();
        if ( $units_sold )
            echo sprintf(__("<p class='arch-sell'>Продано: %s шт.</p>", 'woocommerce'), 5 * $units_sold);
    }

}
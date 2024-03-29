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
            'callback' 	=> array ( $this, 'displayVarietiesInfo' )
        );

        $tabs['faq'] = array(
            'title' 	=> __( 'ЧаВо', 'woocommerce' ),
            'priority' 	=> 51,
            'callback' 	=> array ( $this, 'displayFaqInfo' )
        );

        return $tabs;
    }

    public function displayVarietiesInfo()
    {
        global $product;

        $terms = wp_get_post_terms($product->get_id(), 'pa_grape-varieties', array());

        foreach ($terms as $term) {
            $name = $term->name;
            $desc = $term->description;
            $slug = $term->slug;
            $terms_attach = get_term_meta($term->term_id);
            $image_id = '';
            if ( ! empty($terms_attach['showcase-taxonomy-image-id'][0] ) && ! is_wp_error( $terms_attach['showcase-taxonomy-image-id'][0] ) ) {
                $image_id = $terms_attach['showcase-taxonomy-image-id'][0];
            }

            $img_url = ( isset( $terms_attach['showcase-taxonomy-image-id'][0] ) && ! empty( $terms_attach['showcase-taxonomy-image-id'][0] ))? wp_get_attachment_image_url( $image_id, 'Medium Large' ) : get_theme_file_uri() . '/img/default-grapes-img.png';

            ?>
            <section class="grapes-variety">
                <div class="row-img wow fadeInUp">
                    <img src="<?= $img_url; ?>" alt="<?= $name ?>">
                </div> <!-- .row -->

                <div class="grapes-variety_right wow fadeInUp">
                    <h2 class="grapes-variety-title"><?php echo $name ?></h2>
                    <p class="grapes-variety-desc"><?php echo $desc ?></p>
                    <a href="/grape-varieties/<?php echo $slug; ?>" class="grapes-variety-link btn-link"><?php _e('Все вина этого сорта', 'wine-divi'); ?></a>
                </div> <!-- .producer__in -->
            </section> <!-- .producer -->
            <!--     <hr>-->
            <!--    --><?php //endif;
        }
    }

    // Generator
    private function faqArray($faq_title, $faq_text, $count)
    {
        for ($i=0; $i < $count; $i++ ) {
            yield [ $faq_title[$i], $faq_text[$i] ];
        }
    }

    // For real array
    private function faqArray2($faq_title, $faq_text, $count)
    {
        $array = [];
        for ($i=0; $i < $count; $i++ ) {
            $array[$i] = [ $faq_title[$i], $faq_text[$i] ];
        }
        return $array;

    }

    public function displayFaqInfo(){
        global $product;
        $terms = wp_get_post_terms($product->get_id(), 'pa_sort', array());
        // get custom fields for title and text
        $faq_title = get_post_meta($product->get_id(), 'faq_tab_title', false);
        $faq_text = get_post_meta($product->get_id(), 'faq_tab_text', false);

        // check diffrent count fields for title and text couse unset field in pair
        $count1 = count( $faq_title );
        $count2 = count( $faq_text );

        if ( $count1 >= $count2 && $count1 > 0 && $count2 > 0 ) {
            $count = $count2;
        } else $count = $count1;
        ?>

        <div class="faq-desc" itemscope itemtype="https://schema.org/FAQPage">
            <h3 class="main-faq-title"><?php _e('Часто задаваемые вопросы:', 'wine-divi'); ?></h3>
      <?php foreach ( $this->faqArray($faq_title, $faq_text, $count) as $faq_info_product ) { ?>
            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?=  $faq_info_product[0]; ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text">
                        <?=  $faq_info_product[1]; ?>
                    </p>
                </div>
            </div>
          <?php } ?>

            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?php _e('Как быстро осуществляется доставка?', 'wine-divi'); ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text">
                        <?php _e('Доставка на отделение Новой Почты осуществляется на следующий день. Доставка на отделение УкрПочты может идти 2-3 дня. Justin – 1-2 дня (сроки обсуждаются отдельно).
                        Если заказ сделан до 15-00, нет форс-мажоров и все позиции есть в наличии, отправка осуществляется в тот же день.', 'wine-divi'); ?>

                    </p>
                </div>
            </div>
            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?php _e('Как получить бесплатную доставку?', 'wine-divi'); ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text"><?php printf( __('Бесплатную доставку можно получить, заказав на сумму от %s грн', 'wine-divi'), do_shortcode('[free_shipping_amount]') ); ?>
                    </p>
                </div>
            </div>

            <?php if ( $terms[0]->slug == 'still' ): ?>

            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?php _e('Как долго можно хранить открытое безалкогольное вино?', 'wine-divi'); ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text">
                        <?php _e('В среднем, безалкогольное вино, которое открыли, можно хранить столько же, сколько и обычное молодое вино, 2-3 дня в холодильнике с хорошо закрученной крышкой. Срок зависит от количества оставшегося вина и сладости, чем слаще 
вино и чем больше его в бутылке, тем больше можно хранить. Если использовать вакуумную пробку, то срок хранения вырастет до 7 дней.
', 'wine-divi'); ?>
                    </p>
                </div>
            </div>
            <?php endif;

            if ( $terms[0]->slug == 'sparkling' ): ?>

            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?php _e('Как долго можно хранить безалкогольное шампанское после открытия?', 'wine-divi'); ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text"><?php _e('Конечно, безалкогольное шампанское будет игристым меньше, чем классическое, но в холодильнике со специальной пробкой сможет простоять до 2 дней.', 'wine-divi'); ?></p>
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
        } else echo '<p class="not-sell">' . sprintf( __( 'Продано: 0. Возможно это прекрасное вино - новинка и его еще не успели купить, станьте первым ценителем!', 'wine-divi' ) ). '</p>';
    }

    public function displaySalesCountCategory()
    {
        $units_sold = $this->getSalesCount();
        if ( $units_sold ) {
            echo sprintf(__("<p class='arch-sell'>Продано: %s шт.</p>", 'wine-divi'), 5 * $units_sold);
        } else echo '<p class="arch-sell">' . sprintf( __( 'Новинка!', 'wine-divi' ) ). '</p>';

    }

}
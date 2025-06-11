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
                        <?= $faq_info_product[1]; ?>
                    </p>
                </div>
            </div>
          <?php } ?>

            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?php _e('Як швидко робиться доставка?', 'wine-divi'); ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text">
                        <?php _e('Доставка на віділення Нової Пошти виконується відповідно роскладу доставок Нової Пошти, як правило наступного дня після відправки.
                        Відправки виконуються як правило з ранку, на протязі дня замовлення збираються та обробляються.', 'wine-divi'); ?>

                    </p>
                </div>
            </div>
            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?php _e('Як отримати безкоштовну доставку?', 'wine-divi'); ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text"><?php printf( __('Безкоштовна доставка виконується при замовленні на суму більш %s грн', 'wine-divi'), do_shortcode('[free_shipping_amount]') ); ?>
                    </p>
                </div>
            </div>

            <?php if ( $terms[0]->slug == 'still' ): ?>

            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?php _e('Скільки можна зберігати відкриті безалкогольні вина?', 'wine-divi'); ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text">
                        <?php _e('У середньому безалкогольне вино після відкриття зберігається стільки ж, скільки й звичайне молоде вино — 2–3 дні в холодильнику за умови, що пляшка щільно закрита. Тривалість зберігання залежить від кількості вина, що залишилося, та його солодкості: чим солодше вино і чим більше його в пляшці, тим довше його можна зберігати. Якщо використати вакуумну пробку, термін зберігання збільшується до 7 днів.
', 'wine-divi'); ?>
                    </p>
                </div>
            </div>
            <?php endif;

            if ( $terms[0]->slug == 'sparkling' ): ?>

            <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                <h2 class="faq-title" itemprop="name">✅ <?php _e('Скільки можна зберігати безалкогольне шампанське після відкриття?', 'wine-divi'); ?></h2>
                <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="faq-text" itemprop="text"><?php _e('Звісно, безалкогольне шампанське зберігає ігристість менше, ніж класичне, але в холодильнику зі спеціальною пробкою воно може простояти до 2 днів.', 'wine-divi'); ?></p>
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
        } else echo '<p class="not-sell">' . sprintf( __( 'Продано: 0. Можливо, це чудове вино — новинка, яку ще не встигли придбати. Станьте першим шанувальником!', 'wine-divi' ) ). '</p>';
    }

    public function displaySalesCountCategory()
    {
        $units_sold = $this->getSalesCount();
        if ( $units_sold ) {
            echo sprintf(__("<p class='arch-sell'>Продано: %s шт.</p>", 'wine-divi'), 5 * $units_sold);
        } else echo '<p class="arch-sell">' . sprintf( __( 'Новинка!', 'wine-divi' ) ). '</p>';

    }

}
<?php


namespace WineDivi\Classes;

/*
 * Class for extension loop display
 */
class LoopExtensions
{
    //attrib for display
    private $attributes = ['sort' => 'Вид', 'color' => 'Цвет', 'grape_varieties' => 'Сорт', 'sweetness' => 'Сладость'];

    // Generator for attr
    private function getAttr()
    {
        yield from $this->attributes;
    }

    public function get_term_string($product, $name_term, $taxonomy_name) {
        $var_name = 'term_' . $name_term;
        $$var_name = wp_get_post_terms( $product->get_id(), $taxonomy_name, array() );
        $name_term = [];
        foreach ( $$var_name as $term) {
            $name_term[] = $term->name ;
        }
        return implode(', ', $name_term);
    }


   public function attr_to_loop() {
        global $product;

        ?>
        <table class="woocommerce-product-attributes shop_attributes">
        <?php

        // Use generator
        foreach ($this->getAttr() as $attribute => $text_label)
        {
            // For problem term and taxonomy grape varieties
            $taxonomy_name =  'pa_'.$attribute;
            if ( $attribute == 'grape_varieties' ) {
                $taxonomy_name = 'pa_grape-varieties';
            }

            if (  $$attribute = $this->get_term_string( $product, $attribute, $taxonomy_name ) ) { ?>
           <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_grape-varieties">
                <th class="woocommerce-product-attributes-item__label"><?php echo $text_label; ?>:</th>
                <td class="woocommerce-product-attributes-item__value"><?php echo $$attribute; ?></td>
           </tr>
           <?php
            }
        }  ?>
        </table>
        <?php
    }

    public function archive_text_footer()
    {
        if ( is_product_category( 'non-alcoholic-sparkling-wine' ) ) {
            ?>
            <div class="faq-desc" itemscope itemtype="https://schema.org/FAQPage">
                <h3 class="main-faq-title">Часті запитання:</h3>
                
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h2 class="faq-title" itemprop="name">✅ Що таке безалкогольне шампанське?</h2>
                    <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p class="faq-text" itemprop="text">Безалкогольне шампанське — це безалкогольне вино, яке пройшло процес шампанізації.</p>
                    </div>
                </div>
                
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h2 class="faq-title" itemprop="name">✅ Яким буває безалкогольне шампанське?</h2>
                    <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p class="faq-text" itemprop="text">Буває біле — його виробляють із білих сортів винограду, та рожеве — його можуть виробляти з червоних сортів або змішувати червоні та білі. Червоне безалкогольне шампанське ще не випущене.</p>
                    </div>
                </div>
                
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h2 class="faq-title" itemprop="name">✅ Як проводять шампанізацію безалкогольного шампанського?</h2>
                    <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p class="faq-text" itemprop="text">
                            Процес шампанізації проводиться шляхом штучного насичення безалкогольного вина вуглекислим газом.
                        </p>
                    </div>
                </div>
                
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h2 class="faq-title" itemprop="name">✅ Яке безалкогольне шампанське найсмачніше?</h2>
                    <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p class="faq-text" itemprop="text">
                            Тут немає однозначної відповіді, адже смакові відчуття та вподобання у всіх різні. Важливо розуміти, що існують майже сухі (напівсухі) безалкогольні шампанські, напівсолодкі та солодкі. Також безалкогольне шампанське виготовляється з багатьох сортів винограду, кожен з яких має свої смакові нотки. Із такого розмаїття завжди можна обрати те, що припаде до душі в будь-якій життєвій ситуації.
                        </p>
                    </div>
                </div>
            </div>
	        <?php
        }
    }

    public function text_to_footer(){
        echo "<p class='footer-city'>" . _('Ми доставляємо безалкогольне вино до всіх міст України! До Києва, Дніпра, Кропивницького, Кам’янського, Кривого Рогу, Білої Церкви, Кременчука, Черкас, Броварів, Чернігова, Павлограда, Сум, Полтави — доставка займає 1–2 дні, зазвичай замовлення прибуває вже наступного дня після відправлення. До міст Умань, Тернопіль, Хмельницький, Чернівці, Мукачево, Стрий, Ковель, Вінниця, Ужгород, Луцьк, Львів, Івано-Франківськ замовлення прибуде протягом 2 днів.') . "</p>";
    }

}
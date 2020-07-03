<?php


namespace WineDivi\Classes;

/*
 * Class for extension loop display
 */
class LoopExtensions
{
    //attrib for display
    public $attributes = ['sort' => 'Вид', 'color' => 'Цвет', 'grape_varieties' => 'Сорт', 'sweetness' => 'Сладость'];

    public function get_term_string($product, $name_term, $taxonomy_name) {
        $var_name = 'term_' . $name_term;
        $$var_name = wp_get_post_terms( $product->get_id(), $taxonomy_name, array() );
        $name_term = [];
        foreach ( $$var_name as $term) {
            $name_term[]= $term->name ;
        }
        return implode(', ', $name_term);
    }


   public function attr_to_loop() {
        global $product;

        ?>
        <table class="woocommerce-product-attributes shop_attributes">
        <?php  foreach ($this->attributes as $attribute => $text_label) {

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

    public function archive_text_footer() {

        if ( is_product_category( 'non-alcoholic-sparkling-wine' ) ) {

            ?>
            <div class="faq-desc" itemscope itemtype="https://schema.org/FAQPage">
                <h3 class="main-faq-title">Часто задаваемые вопросы:</h3>
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h2 class="faq-title" itemprop="name">✅ Что такое безалкогольное шампанское?</h2>
                    <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p class="faq-text" itemprop="text">Безалкогольное шампанское – это безалкогольное вино, которое
                            прошло процесс шампанизации.
                        </p>
                    </div>
                </div>
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h2 class="faq-title" itemprop="name">✅ Какое бывает безалкогольное шампанское?</h2>
                    <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p class="faq-text" itemprop="text">Бывает белое, которое производят из белых сортов винограда и
                            розовое, которое могут производить из красных сортов винограда или смешивая красные и белые
                            сорта. Красное безалкогольное шампанское еще не выпустили.
                        </p>
                    </div>
                </div>
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h2 class="faq-title" class="faq-title" itemprop="name">✅ Как проводят шампанизацию безалкогольного
                        шампанского?</h2>
                    <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p class="faq-text" itemprop="text">
                            Процесс шампанизации проводится путем искусственного насыщения безалкогольного вина
                            углекислым газом.
                        </p>
                    </div>
                </div>
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h2 class="faq-title" itemprop="name">✅ Какое безалкогольное шампанское самое вкусное?</h2>
                    <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p class="faq-text" class="faq-text" itemprop="text">
                            Здесь нет однозначного ответа, так как вкусовые ощущения и предпочтения у всех разные. Важно
                            понимать, что есть практически сухие (полусухие) безалкогольные шампанские, полусладкие и
                            сладкие. Также безалкогольное шампанское производится из большого количества сортов, которые
                            тоже имеют свои вкусовые нотки. Из такого разнообразия всегда можно выбрать то, что придется
                            по душе в любой жизненной ситуации.
                        </p>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function text_to_footer(){
        echo "<p class='footer-city'>" . _('Мы доставляем безалкогольное вино во все города Украины! В Киев, Днепр, Запорожье, Одесса, Александрия, Кропивницький, Мелитополь, Каменское, Кривой Рог, Мариуполь, Одесса, Белая Церковь, Кременчуг, Черкассы, Бровари, Бердянски, Чернигов, Павлоград, Суми, Полтава время доставки 1-2 дня, как правило, заказ приходит на следующий день после отправки.
В города Умань, Николаев, Херсон, Новая Каховка, Тернополь, Хмельницкий, Черновци, Мукачево, Стрий, Ковель, Винница, Ужгород, Луцьк, Львів, Івано-Франківськ заказ придет через 2 дня.')
 . "</p>";
    }

}
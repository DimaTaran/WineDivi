<?php
/**
 * Template name: Contact
 */

get_header();

?>

<div id="main-content contact-wrap">

    <section id="contact" class="contact">
        <div class="column">
            <h1 class="entry-title main_title"><?php the_title(); ?></h1>
            <p>По любым вопросам, касающимся безалкогольных вин связывайтесь с нами<br> т. 097-992-70-80<br>
                т. 068-888-82-28</p><p>e-mail: order@non-alcoholic-wines.in.ua</p>
            <h4>Отправить нам письмо</h4>
        </div>
        <div class="column">
            <?php echo do_shortcode('[contact-form-7 id="693" title="Контактная форма 1"]'); ?>
        </div>
    </section> <!-- .entry-content -->

</div>

<?php

get_footer();

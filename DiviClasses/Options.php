<?php


namespace DiviClasses;

/**
 * Class Options
 * @package DiviClasses
 */
class Options
{

    public function init()
    {
        add_action( 'epanel_render_maintabs', array( $this, 'addEpanelTab') );
        add_action( 'wp_ajax_save_epanel',  array( $this, 'etEpanelSaveCallback')  );

    }
    public function addEpanelFields()
    {
        global $epanelMainTabs, $themename, $shortname, $options;

        $options[] = array(
            "name" => "wrap-taran",
            "type" => "contenttab-wrapstart",);

        $options[] = array(
            "type" => "subnavtab-start",);

        $options[] = array(
            "name" => "taran-1",
            "type" => "subnav-tab",
            "desc" => esc_html__("General", $themename )
        );

        $options[] = array(
            "type" => "subnavtab-end");

        $options[] = array(
            "name" => "taran-1",
            "type" => "subcontent-start",);
        $options[] = array(
            'name' => esc_html__('Telegram API Key', $themename),
            'type' => 'text',
            'id' => $shortname . "_telegram_api_key",
            'desc' => 'Replace here Telegram API Key',
            'std' =>  ! empty( get_option('divi_telegram_api_key') ) ? get_option('divi_telegram_api_key') : 'my:api-key',
        );

        $options[] = array(
            'name' => esc_html__('Telegram ChatID or UserID', $themename),
            'type' => 'text',
            'id' => $shortname . "_telegram_chat_id",
            'desc' => 'Replace here ChatID or UserID',
            'std' => ! empty( get_option('divi_telegram_chat_id') ) ? get_option('divi_telegram_chat_id') : '444444444',
        );

        $options[] = array(
            'name' => esc_html__('Send messages on Telegram', $themename),
            'id' => $shortname . "_send_on_telegram",
            'desc' => esc_html__('Send messages on Telegram'),
            'std' => ! empty( get_option('divi_send_on_telegram') ) ? get_option('divi_send_on_telegram') : 'on',
            "type" => "checkbox"
        );

        $options[] = array(
            "name" => "taran-1",
            "type" => "subcontent-end");

        $options[] = array(
            "name" => "wrap-taran",
            "type" => "contenttab-wrapend");
    }

    public function addEpanelTab(){
        $this->addEpanelFields();
        ?>
        <li><a href="#wrap-taran"><?php echo 'Taran'; ?></a></li>
        <?php
    }
    public function etEpanelSaveCallback( $source )
    {
        $telegram_options['divi_telegram_api_key'] = $_POST['divi_telegram_api_key'];
        $telegram_options['divi_telegram_chat_id'] = $_POST['divi_telegram_chat_id'];
        if ( $_POST['divi_send_on_telegram'] == 'on' ) {
            $telegram_options['divi_send_on_telegram'] = 'on';
        }
        if ( $_POST['divi_send_on_telegram'] == null ) {
            $telegram_options['divi_send_on_telegram'] = 'off';
        }

        foreach ( $telegram_options as $key => $option)  {

            if ( ! empty( $option ) ) {

                update_option( $key, $option );

            }
        }
    }
}
<?php
namespace WatsonConv;

class Frontend {
    public static function load_styles() {
        wp_enqueue_style('chat-style', WATSON_CONV_URL.'styles.css');

        $font_size = get_option('watsonconv_font_size', 11);
        $color = get_option('watsonconv_color', '#23282d');

        $r = hexdec(substr($color,1,2));
        $g = hexdec(substr($color,3,2));
        $b = hexdec(substr($color,5,2));

        if($r + $g + $b > 382){
            $text_color = 'black';
        } else {
            $text_color = 'white';
        }

        wp_add_inline_style('chat-style', '
            .popup-box
            {
                font-size: '.$font_size.'pt;
                width: '.(165 + 4.2*$font_size).'pt;
            }
            .popup-box .popup-head
            {
                background-color: '.$color.';
                color: '.$text_color.';
            }
            .popup-box .popup-message-form .popup-message-input
            {
                font-size: '.$font_size.'pt;
            }
            .popup-box .popup-messages .watson-message
            {
              float: left;
              background-color: '.$color.';
              color: '.$text_color.';
            }
        ');
    }

    public static function render_chat_box() {
        $page_selected =
            is_page(get_option('watsonconv_pages', -1)) ||
            is_single(get_option('watsonconv_posts', -1)) ||
            in_category(get_option('watsonconv_categories', -1));

        if ($page_selected == (get_option('watsonconv_show_on', 'all_except') == 'only')) {
            if (!empty(get_option('watsonconv_id')) &&
                !empty(get_option('watsonconv_username')) &&
                !empty(get_option('watsonconv_password'))) {
            ?>
                <div id="chat-box"></div>
            <?php
                $settings = array(
                    'delay' => (int) get_option('watsonconv_delay', 0)
                );

                wp_enqueue_script('chat-app', WATSON_CONV_URL.'app.js');
                wp_localize_script('chat-app', 'settings', $settings);
            }
        }
    }
}
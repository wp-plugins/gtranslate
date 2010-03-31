<?php
/*
Plugin Name: GTranslate
Plugin URI: http://edo.webmaster.am/gtranslate
Description: Get translations with a single click between 52 languages (more than 98% of internet users) on your website!
Version: 1.0.0
Author: Edvard Ananyan
Author URI: http://edo.webmaster.am

*/

/*  Copyright 2010 Edvard Ananyan  (email : edo888@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('widgets_init', array('GTranslate', 'register'));
register_activation_hook(__FILE__, array('GTranslate', 'activate'));
register_deactivation_hook(__FILE__, array('GTranslate', 'deactivate'));
add_action('admin_menu', array('GTranslate', 'admin_menu'));

class GTranslate extends WP_Widget {
    function activate() {
        $data = array(
            'gtranslate_title' => 'GTranslate',
        );

        if(get_option('GTranslate'))
            update_option('GTranslate', $data);
        else
            add_option('GTranslate', $data);
    }

    function deactivate() {
        delete_option('GTranslate');
    }

    function control() {
        $data = get_option('GTranslate');
        ?>
        <p><label>Title: <input name="gtranslate_title" type="text" class="widefat" value="<?php echo $data['gtranslate_title']; ?>"/></label></p>
        <p>Please go to Settings -> GTranslate for configuration.</p>
        <?php
        if (isset($_POST['gtranslate_title'])){
            $data['gtranslate_title'] = attribute_escape($_POST['gtranslate_title']);
            update_option('GTranslate', $data);
        }
    }

    function widget($args) {
        $data = get_option('GTranslate');

        echo $args['before_widget'];
        echo $args['before_title'] . $data['gtranslate_title'] . $args['after_title'];

        // -- TODO -- display the language selector
        echo 'BETA VERSION:';
        ?>
        <div id="google_translate_element"></div>
        <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                //includedLanguages: ''
            }, 'google_translate_element');
        }
        </script>
        <script type="text/javascript" src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <?php
        echo $args['after_widget'];
    }

    function register() {
        wp_register_sidebar_widget('gtranslate', 'GTranslate', array('GTranslate', 'widget'), array('description' => __('Google Automatic Translations')));
        wp_register_widget_control('gtranslate', 'GTranslate', array('GTranslate', 'control'));
    }

    function admin_menu() {
        add_options_page('GTranslator Options', 'GTranslate', 'administrator', 'gtranslate_options', array('GTranslate', 'options'));
    }

    function options() { // -- TODO -- display options
        echo '<div class="wrap">';
        echo '<p>The configuration settings are not ready yet.</p>';
        echo '</div>';
    }
}
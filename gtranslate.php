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

#error_reporting(E_ALL);
add_action('widgets_init', array('GTranslate', 'register'));
register_activation_hook(__FILE__, array('GTranslate', 'activate'));
register_deactivation_hook(__FILE__, array('GTranslate', 'deactivate'));

class GTranslate extends WP_Widget {
    function activate() {
        $data = array(
            'gtranslate_title' => 'GTranslate',
            'gtranslate_method' => 'on-fly',
            'gtranslate_pro' => 0,
            'gtranslate_look' => 'both',
            'gtranslate_flag_size' => 16,
            'gtranslate_new_window' => 0,
            'gtranslate_main_lang' => 'en',
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
        // -- TODO -- Generate the options form
        ?>
        <p><label>Title: <input name="gtranslate_title" type="text" class="widefat" value="<?php echo $data['gtranslate_title']; ?>"/></label></p>
        <p><input type="checkbox" value="1" name="gtranslate_pro" id="gtranslate_pro" <?php if((int)$data['gtranslate_pro']) echo 'checked="checked"'; ?>/><label for="gtranslate_pro">Operate with GTranslate Pro?</label></p>
        <p><input type="checkbox" value="1" name="gtranslate_new_window" id="gtranslate_new_window" <?php if((int)$data['gtranslate_new_window']) echo 'checked="checked"'; ?>/><label for="gtranslate_new_window">Open in a new window?</label></p>
        <?php
        if (isset($_POST['gtranslate_title'])){
            $data['gtranslate_title'] = attribute_escape($_POST['gtranslate_title']);
            $data['gtranslate_pro'] = attribute_escape($_POST['gtranslate_pro']);
            $data['gtranslate_new_window'] = attribute_escape($_POST['gtranslate_new_window']);
            update_option('GTranslate', $data);
        }
    }

    function widget($args) {
        $data = get_option('GTranslate');

        echo $args['before_widget'];
        echo $args['before_title'] . $data['gtranslate_title'] . $args['after_title'];
        echo 'I am your widget'; // -- TODO -- display the language selector
        echo $args['after_widget'];
    }

    function register() {
        wp_register_sidebar_widget('gtranslate', 'GTranslate', array('GTranslate', 'widget'), array('description' => __('Google Automatic Translations')));
        wp_register_widget_control('gtranslate', 'GTranslate', array('GTranslate', 'control'));
        //register_sidebar_widget('GTranslate', array('GTranslate', 'widget'));
        //register_widget_control('GTranslate', array('GTranslate', 'control'));
    }
}
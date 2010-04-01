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

        $lang_array = array('en'=>'English','ar'=>'Arabic','bg'=>'Bulgarian','zh-CN'=>'Chinese (Simplified)','zh-TW'=>'Chinese (Traditional)','hr'=>'Croatian','cs'=>'Czech','da'=>'Danish','nl'=>'Dutch','fi'=>'Finnish','fr'=>'French','de'=>'German','el'=>'Greek','hi'=>'Hindi','it'=>'Italian','ja'=>'Japanese','ko'=>'Korean','no'=>'Norwegian','pl'=>'Polish','pt'=>'Portuguese','ro'=>'Romanian','ru'=>'Russian','es'=>'Spanish','sv'=>'Swedish','ca'=>'Catalan','tl'=>'Filipino','iw'=>'Hebrew','id'=>'Indonesian','lv'=>'Latvian','lt'=>'Lithuanian','sr'=>'Serbian','sk'=>'Slovak','sl'=>'Slovenian','uk'=>'Ukrainian','vi'=>'Vietnamese','sq'=>'Albanian','et'=>'Estonian','gl'=>'Galician','hu'=>'Hungarian','mt'=>'Maltese','th'=>'Thai','tr'=>'Turkish','fa'=>'Persian','af'=>'Afrikaans','ms'=>'Malay','sw'=>'Swahili','ga'=>'Irish','cy'=>'Welsh','be'=>'Belarusian','is'=>'Icelandic','mk'=>'Macedonian','yi'=>'Yiddish');
        $flag_map = array();
        $i = $j = 0;
        foreach($lang_array as $lang => $lang_name) {
            $flag_map[$lang] = array($i*100, $j*100);
            if($i == 7) {
                $i = 0;
                $j++;
            } else {
                $i++;
            }
        }

        $flag_map_vertical = array();
        $i = 0;
        foreach($lang_array as $lang => $lang_name) {
            $flag_map_vertical[$lang] = $i*16;
            $i++;
        }

        asort($lang_array);
        // Move the default language to the first position
        $lang_array = array_merge(array($language => $lang_array[$language]), $lang_array);


        // -- TODO -- display the language selector
        echo 'BETA VERSION:';
        ?>
        <div id="google_translate_element"></div>
        <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: '<?php echo get_option('main_lang'); ?>',
                includedLanguages: '<?php
                foreach($lang_array as $lang => $lang_name) {
                    $show_this = 'show_'.str_replace('-', '', $lang);
                    if(get_option($show_this))
                        echo $lang.',';
                }
                ?>'
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
        echo '<h2>GTranslate</h2>';
        echo '<p>The configuration settings are not ready yet.</p>';
        ?>
        <form id="gtranslate" name="form1" method="post" action="<?php echo get_option('siteurl') . '/wp-admin/options-general.php?page=gtranslate_options' ?>">
            <fieldset>
                <legend><h3><?php _e('General Configuration'); ?></h3></legend><br />
                <fieldset class="options">
                    <?php _e('Translation Method'); ?><br />
                    &nbsp;&nbsp;<label><input type="radio" name="main_lang" value="google_default" checked /> <?php _e('Google Default'); ?></label><br />
                    &nbsp;&nbsp;<label><input type="radio" name="main_lang" value="ajax" /> <?php _e('On Fly (jQuery)'); ?></label><br />
                    &nbsp;&nbsp;<label><input type="radio" name="main_lang" value="redirect" /> <?php _e('Redirect'); ?></label>
                    <p><small>Select which method shall be used when translating the page. Google Default will show only a dropdown provided by Google and it will translate the page on the fly, but you cannot configure it's appearance. On Fly (jQuery) can be configured, it will also use the on the fly translation method. Redirect method will redirect the visitor to the translated page, if the Pro version is installed it will use SEF URLs and keep the visitor on your domain, however this method cannot translate non-public pages.</small></p>
                </fieldset>
                <fieldset class="options">
                    <label><input type="checkbox" name="pro_version" value="1" /> <?php _e('Operate with Pro version'); ?></label>
                    <p><small>If you have Pro version installed you need to check this box. Find out more on <a href="http://edo.webmaster.am/gtranslate" target="_blank">http://edo.webmaster.am/gtranslate</a></small></p>
                </fieldset>
            </fieldset>

            <fieldset>
                <legend><h3><?php _e('Appearance Configuration'); ?></h3></legend><br />
                <fieldset class="options">
                    <?php _e('Look'); ?><br />
                    &nbsp;&nbsp;<label><input type="radio" name="look" value="both" checked /> <?php _e('Both'); ?></label><br />
                    &nbsp;&nbsp;<label><input type="radio" name="look" value="dropdown" /> <?php _e('Dropdown list'); ?></label><br />
                    &nbsp;&nbsp;<label><input type="radio" name="look" value="flags" /> <?php _e('Flags'); ?></label>
                    <p><small>Select the look of the widget.</small></p>
                </fieldset>
                <fieldset class="options">
                    <?php _e('Flag Size'); ?><br />
                    &nbsp;&nbsp;<label><input type="radio" name="flag_size" value="16" checked /> 16</label><br />
                    &nbsp;&nbsp;<label><input type="radio" name="flag_size" value="24" /> 24</label><br />
                    &nbsp;&nbsp;<label><input type="radio" name="flag_size" value="32" /> 32</label>
                    <p><small>Select the flag size in pixels.</small></p>
                </fieldset>
                <fieldset class="options">
                    <label><input type="checkbox" name="new_window" value="1" /> <?php _e('Open translated page in a new window'); ?></label>
                    <p><small>The translated page will appear in a new window.</small></p>
                </fieldset>
            </fieldset>

            <fieldset>
                <legend><h3><?php _e('Language Configuration'); ?></h3></legend><br />
                <fieldset class="options">
                    <?php _e('Main Language'); ?><br />
                    <p><small>Your sites main language.</small></p>
                </fieldset>
            </fieldset>

            <p class="submit"><input type="submit" name="save" value="<?php _e('Update options'); ?>" /></p>
        </form>
        <?php
        echo '</div>';
    }
}
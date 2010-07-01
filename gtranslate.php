<?php
/*
Plugin Name: GTranslate
Plugin URI: http://edo.webmaster.am/gtranslate
Description: Get translations with a single click between 58 languages (more than 98% of internet users) on your website!
Version: 1.0.5
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
        self::load_defaults(& $data);

        echo $args['before_widget'];
        echo $args['before_title'] . $data['gtranslate_title'] . $args['after_title'];
        echo $data['widget_code'];
        echo $args['after_widget'];
    }

    function register() {
        wp_register_sidebar_widget('gtranslate', 'GTranslate', array('GTranslate', 'widget'), array('description' => __('Google Automatic Translations')));
        wp_register_widget_control('gtranslate', 'GTranslate', array('GTranslate', 'control'));
    }

    function admin_menu() {
        add_options_page('GTranslator Options', 'GTranslate', 'administrator', 'gtranslate_options', array('GTranslate', 'options'));

    }

    function options() {
        ?>
        <div class="wrap">
        <h2>GTranslate</h2>
        <?php
        if($_POST['save'])
            self::control_options();
        $data = get_option('GTranslate');
        self::load_defaults(& $data);

        $site_url = get_option('siteurl');

        extract($data);

        #unset($data['widget_code']);
        #echo '<pre>', print_r($data, true), '</pre>';

$script = <<<EOT

function RefreshDoWidgetCode() {
    var new_line = "\\n";
    var widget_preview = '<!-- GTranslate: http://edo.webmaster.am/gtranslate -->'+new_line;
    var widget_code = '';
    var translation_method = jQuery('#translation_method').val();
    var default_language = jQuery('#default_language').val();
    var flag_size = jQuery('#flag_size').val();
    var pro_version = jQuery('#pro_version:checked').length > 0 ? true : false;
    var new_window = jQuery('#new_window:checked').length > 0 ? true : false;

    var languages = ['Afrikaans','Albanian','Arabic','Armenian','Azerbaijani','Basque','Belarusian','Bulgarian','Catalan','Chinese (Simplified)','Chinese (Traditional)','Croatian','Czech','Danish','Dutch','English','Estonian','Filipino','Finnish','French','Galician','Georgian','German','Greek','Haitian Creole','Hebrew','Hindi','Hungarian','Icelandic','Indonesian','Irish','Italian','Japanese','Korean','Latvian','Lithuanian','Macedonian','Malay','Maltese','Norwegian','Persian','Polish','Portuguese','Romanian','Russian','Serbian','Slovak','Slovenian','Spanish','Swahili','Swedish','Thai','Turkish','Ukrainian','Urdu','Vietnamese','Welsh','Yiddish'];
    var language_codes = ['af','sq','ar','hy','az','eu','be','bg','ca','zh-CN','zh-TW','hr','cs','da','nl','en','et','tl','fi','fr','gl','ka','de','el','ht','iw','hi','hu','is','id','ga','it','ja','ko','lv','lt','mk','ms','mt','no','fa','pl','pt','ro','ru','sr','sk','sl','es','sw','sv','th','tr','uk','ur','vi','cy','yi'];
    var languages_map = {en_x: 0, en_y: 0, ar_x: 100, ar_y: 0, bg_x: 200, bg_y: 0, zhCN_x: 300, zhCN_y: 0, zhTW_x: 400, zhTW_y: 0, hr_x: 500, hr_y: 0, cs_x: 600, cs_y: 0, da_x: 700, da_y: 0, nl_x: 0, nl_y: 100, fi_x: 100, fi_y: 100, fr_x: 200, fr_y: 100, de_x: 300, de_y: 100, el_x: 400, el_y: 100, hi_x: 500, hi_y: 100, it_x: 600, it_y: 100, ja_x: 700, ja_y: 100, ko_x: 0, ko_y: 200, no_x: 100, no_y: 200, pl_x: 200, pl_y: 200, pt_x: 300, pt_y: 200, ro_x: 400, ro_y: 200, ru_x: 500, ru_y: 200, es_x: 600, es_y: 200, sv_x: 700, sv_y: 200, ca_x: 0, ca_y: 300, tl_x: 100, tl_y: 300, iw_x: 200, iw_y: 300, id_x: 300, id_y: 300, lv_x: 400, lv_y: 300, lt_x: 500, lt_y: 300, sr_x: 600, sr_y: 300, sk_x: 700, sk_y: 300, sl_x: 0, sl_y: 400, uk_x: 100, uk_y: 400, vi_x: 200, vi_y: 400, sq_x: 300, sq_y: 400, et_x: 400, et_y: 400, gl_x: 500, gl_y: 400, hu_x: 600, hu_y: 400, mt_x: 700, mt_y: 400, th_x: 0, th_y: 500, tr_x: 100, tr_y: 500, fa_x: 200, fa_y: 500, af_x: 300, af_y: 500, ms_x: 400, ms_y: 500, sw_x: 500, sw_y: 500, ga_x: 600, ga_y: 500, cy_x: 700, cy_y: 500, be_x: 0, be_y: 600, is_x: 100, is_y: 600, mk_x: 200, mk_y: 600, yi_x: 300, yi_y: 600, hy_x: 400, hy_y: 600, az_x: 500, az_y: 600, eu_x: 600, eu_y: 600, ka_x: 700, ka_y: 600, ht_x: 0, ht_y: 700, ur_x: 100, ur_y: 700};

    if(translation_method == 'google_default') {
        included_languages = '';
        jQuery.each(languages, function(i, val) {
            lang = language_codes[i];
            if(jQuery('#incl_langs'+lang+':checked').length) {
                lang_name = val;
                included_languages
            }
        });

        widget_preview += '<div id="google_translate_element"></div>'+new_line;
        widget_preview += '<script type="text/javascript">'+new_line;
        widget_preview += 'function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage: \'';
        widget_preview += default_language;
        widget_preview += '\', includedLanguages: \'';
        widget_preview += included_languages;
        widget_preview += "'}, 'google_translate_element');}"+new_line;
        widget_preview += '<\/script>';
        widget_preview += '<script type="text/javascript" src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"><\/script>'+new_line;
    } else if(translation_method == 'on_fly' || translation_method == 'redirect') {
        // Adding flags
        if(jQuery('#show_flags:checked').length) {
            jQuery.each(languages, function(i, val) {
                lang = language_codes[i];
                if(jQuery('#fincl_langs'+lang+':checked').length) {
                    lang_name = val;
                    flag_x = languages_map[lang.replace('-', '')+'_x'];
                    flag_y = languages_map[lang.replace('-', '')+'_y'];
                    widget_preview += '<a href="javascript:doGTranslate(\''+default_language+'|'+lang+'\')" title="'+lang_name+'" class="gflag" style="background-position:-'+flag_x+'px -'+flag_y+'px;"><img src="{$site_url}/wp-content/plugins/gtranslate/blank.png" height="'+flag_size+'" width="'+flag_size+'" alt="'+lang_name+'" /></a>';
                }
            });

            // Adding stylesheet
            widget_preview += new_line+new_line;
            widget_preview += '<style type="text/css">'+new_line;
            widget_preview += '<!--'+new_line;
            widget_preview += "a.gflag {font-size:"+flag_size+"px;padding:1px 0;background-repeat:no-repeat;background-image:url('{$site_url}/wp-content/plugins/gtranslate/"+flag_size+".png');}"+new_line;
            widget_preview += "a.gflag img {border:0;}"+new_line;
            widget_preview += "a.gflag:hover {background-image:url('{$site_url}/wp-content/plugins/gtranslate/"+flag_size+"a.png');}"+new_line;
            widget_preview += '-->'+new_line;
            widget_preview += '</style>'+new_line+new_line;
        }

        // Adding dropdown
        if(jQuery('#show_dropdown:checked').length) {
            if(jQuery('#show_flags:checked').length && jQuery('#add_new_line:checked').length)
                widget_preview += '<br />';
            else
                widget_preview += ' ';
            widget_preview += '<select onchange="doGTranslate(this);">';
            widget_preview += '<option value="">Select Language</option>';
            jQuery.each(languages, function(i, val) {
                lang = language_codes[i];
                if(jQuery('#incl_langs'+lang+':checked').length) {
                    lang_name = val;
                    widget_preview += '<option value="'+default_language+'|'+lang+'">'+lang_name+'</option>';
                }
            });
            widget_preview += '</select>';
        }

        // Adding javascript
        widget_code += new_line+new_line;
        if(translation_method == 'on_fly') {
            if(jQuery('#load_jquery:checked').length) {
                widget_code += '<script type="text/javascript" src="{$site_url}/wp-content/plugins/gtranslate/jquery.js"><\/script>'+new_line;
            }
            widget_code += '<script type="text/javascript" src="{$site_url}/wp-content/plugins/gtranslate/jquery-translate.js"><\/script>'+new_line;
        }

        widget_code += '<script type="text/javascript">'+new_line;
        widget_code += '//<![CDATA['+new_line;
        if(pro_version && translation_method == 'redirect' && new_window) {
            widget_code += "function openTab(url) {var form=document.createElement('form');form.method='post';form.action=url;form.target='_blank';document.body.appendChild(form);form.submit();}"+new_line;
            widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')openTab(location.protocol+'//'+location.host+location.pathname.replace('/'+plang, '')+location.search);else openTab(location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang, '')+location.search);}"+new_line;
        } else if(pro_version && translation_method == 'redirect') {
            widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')location.href=location.protocol+'//'+location.host+location.pathname.replace('/'+plang, '')+location.search;else location.href=location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang, '')+location.search;}"+new_line;
        } else if(translation_method == 'redirect' && new_window) {
            widget_code += 'if(top.location!=self.location)top.location=self.location;'+new_line;
            widget_code += "window['_tipoff']=function(){};window['_tipon']=function(a){};"+new_line;
            widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;else if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')openTab(unescape(gfg('u')));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')openTab('http://translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href));else openTab('http://translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u')));}"+new_line;
            widget_code += 'function gfg(name) {name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(location.href);if(results==null)return "";return results[1];}'+new_line;
            widget_code += "function openTab(url) {var form=document.createElement('form');form.method='post';form.action=url;form.target='_blank';document.body.appendChild(form);form.submit();}"+new_line;
        } else if(translation_method == 'redirect') {
            widget_code += 'if(top.location!=self.location)top.location=self.location;'+new_line;
            widget_code += "window['_tipoff']=function(){};window['_tipon']=function(a){};"+new_line;
            widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;else if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')location.href=unescape(gfg('u'));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')location.href='http://translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href);else location.href='http://translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u'));}"+new_line;
            widget_code += 'function gfg(name) {name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(location.href);if(results==null)return "";return results[1];}'+new_line;
        } else if(translation_method == 'on_fly') {
            widget_code += "if(jQuery.cookie('glang') && jQuery.cookie('glang') != '"+default_language+"') jQuery(function(\$){\$('body').translate('"+default_language+"', \$.cookie('glang'), {toggle:true, not:'.notranslate'});});"+new_line;
            widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;var lang=lang_pair.split('|')[1];if(lang=='pt')lang='pt-PT';jQuery.cookie('glang', lang);jQuery(function(\$){\$('body').translate('"+default_language+"', lang, {toggle:true, not:'.notranslate'});});}"+new_line;
        }

        widget_code += '//]]>'+new_line;
        widget_code += '<\/script>'+new_line;

    }

    widget_code = widget_preview + widget_code;

    jQuery('#widget_code').val(widget_code);

    ShowWidgetPreview(widget_preview);

}

function ShowWidgetPreview(widget_preview) {
    widget_preview = widget_preview.replace(/javascript:doGTranslate/g, 'javascript:void')
    widget_preview = widget_preview.replace('onchange="doGTranslate(this);"', '');
    widget_preview = widget_preview.replace('if(jQuery.cookie', 'if(false && jQuery.cookie');
    jQuery('#widget_preview').html(widget_preview);
}

jQuery('#pro_version').attr('checked', '$pro_version'.length > 0);
jQuery('#new_window').attr('checked', '$new_window'.length > 0);
jQuery('#load_jquery').attr('checked', '$load_jquery'.length > 0);
jQuery('#add_new_line').attr('checked', '$add_new_line'.length > 0);
jQuery('#show_dropdown').attr('checked', '$show_dropdown'.length > 0);
jQuery('#show_flags').attr('checked', '$show_flags'.length > 0);

jQuery('#default_language').val('$default_language');
jQuery('#translation_method').val('$translation_method');
jQuery('#flag_size').val('$flag_size');

if(jQuery('#widget_code').val() == '')
    RefreshDoWidgetCode();
else
    ShowWidgetPreview(jQuery('#widget_code').val());

EOT;
?>
        <form id="gtranslate" name="form1" method="post" action="<?php echo get_option('siteurl') . '/wp-admin/options-general.php?page=gtranslate_options' ?>">
        <p>Use the configuration form below to customize the GTranslate widget.</p>
        <p>If you would like to have SEF URLs (<?php echo $site_url; ?><b>/es/</b>, <?php echo $site_url; ?><b>/fr/</b>, <?php echo $site_url; ?><b>/it/</b>, etc.) for translated languages or you want your translated pages to be indexed in search engines you may consider <a href="http://edo.webmaster.am/gtranslate" target="_blank">GTranslate Pro</a> version.</p>
        <div style="float:left;width:270px;">
            <h4>Widget options</h4>
            <table style="font-size:11px;">
            <tr>
                <td class="option_name">Translation method:</td>
                <td>
                    <select id="translation_method" name="translation_method" onChange="RefreshDoWidgetCode()">
                        <option value="google_default">Google Default</option>
                        <option value="on_fly" selected>On Fly (jQuery)</option>
                        <option value="redirect">Redirect</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="option_name">Default language:</td>
                <td>
                    <select id="default_language" name="default_language" onChange="RefreshDoWidgetCode()">
                        <option value="af">Afrikaans</option>
                        <option value="sq">Albanian</option>
                        <option value="ar">Arabic</option>
                        <option value="hy">Armenian</option>
                        <option value="az">Azerbaijani</option>
                        <option value="eu">Basque</option>
                        <option value="be">Belarusian</option>
                        <option value="bg">Bulgarian</option>
                        <option value="ca">Catalan</option>
                        <option value="zh-CN">Chinese (Simplified)</option>
                        <option value="zh-TW">Chinese (Traditional)</option>
                        <option value="hr">Croatian</option>
                        <option value="cs">Czech</option>
                        <option value="da">Danish</option>
                        <option value="nl">Dutch</option>
                        <option value="en" selected>English</option>
                        <option value="et">Estonian</option>
                        <option value="tl">Filipino</option>
                        <option value="fi">Finnish</option>
                        <option value="fr">French</option>
                        <option value="gl">Galician</option>
                        <option value="ka">Georgian</option>
                        <option value="de">German</option>
                        <option value="el">Greek</option>
                        <option value="ht">Haitian Creole</option>
                        <option value="iw">Hebrew</option>
                        <option value="hi">Hindi</option>
                        <option value="hu">Hungarian</option>
                        <option value="is">Icelandic</option>
                        <option value="id">Indonesian</option>
                        <option value="ga">Irish</option>
                        <option value="it">Italian</option>
                        <option value="ja">Japanese</option>
                        <option value="ko">Korean</option>
                        <option value="lv">Latvian</option>
                        <option value="lt">Lithuanian</option>
                        <option value="mk">Macedonian</option>
                        <option value="ms">Malay</option>
                        <option value="mt">Maltese</option>
                        <option value="no">Norwegian</option>
                        <option value="fa">Persian</option>
                        <option value="pl">Polish</option>
                        <option value="pt">Portuguese</option>
                        <option value="ro">Romanian</option>
                        <option value="ru">Russian</option>
                        <option value="sr">Serbian</option>
                        <option value="sk">Slovak</option>
                        <option value="sl">Slovenian</option>
                        <option value="es">Spanish</option>
                        <option value="sw">Swahili</option>
                        <option value="sv">Swedish</option>
                        <option value="th">Thai</option>
                        <option value="tr">Turkish</option>
                        <option value="uk">Ukrainian</option>
                        <option value="ur">Urdu</option>
                        <option value="vi">Vietnamese</option>
                        <option value="cy">Welsh</option>
                        <option value="yi">Yiddish</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="option_name">Load jQuery library:</td>
                <td><input id="load_jquery" name="load_jquery" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
            </tr>
            <tr>
                <td class="option_name">Open in new window:</td>
                <td><input id="new_window" name="new_window" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
            </tr>
            <tr>
                <td class="option_name">Operate with Pro version:</td>
                <td><input id="pro_version" name="pro_version" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
            </tr>
            <tr>
                <td class="option_name">Show flags:</td>
                <td><input id="show_flags" name="show_flags" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
            </tr>
            <tr>
                <td class="option_name">Flag size:</td>
                <td>
                <select id="flag_size"  name="flag_size" onchange="RefreshDoWidgetCode()">
                    <option value="16" selected>16px</option>
                    <option value="24">24px</option>
                    <option value="32">32px</option>
                </select>
                </td>
            </tr>
            <tr>
                <td class="option_name">Flag languages:</td>
                <td>
                <div style="height:55px;overflow-y:scroll;">
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsaf" name="fincl_langs" value="af"><label for="fincl_langsaf">Afrikaans</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssq" name="fincl_langs" value="sq"><label for="fincl_langssq">Albanian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsar" name="fincl_langs" value="ar"><label for="fincl_langsar">Arabic</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langshy" name="fincl_langs" value="hy"><label for="fincl_langshy">Armenian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsaz" name="fincl_langs" value="az"><label for="fincl_langsaz">Azerbaijani</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langseu" name="fincl_langs" value="eu"><label for="fincl_langseu">Basque</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsbe" name="fincl_langs" value="be"><label for="fincl_langsbe">Belarusian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsbg" name="fincl_langs" value="bg"><label for="fincl_langsbg">Bulgarian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsca" name="fincl_langs" value="ca"><label for="fincl_langsca">Catalan</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langszh-CN" name="fincl_langs" value="zh-CN"><label for="fincl_langszh-CN">Chinese (Simplified)</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langszh-TW" name="fincl_langs" value="zh-TW"><label for="fincl_langszh-TW">Chinese (Traditional)</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langshr" name="fincl_langs" value="hr"><label for="fincl_langshr">Croatian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langscs" name="fincl_langs" value="cs"><label for="fincl_langscs">Czech</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsda" name="fincl_langs" value="da"><label for="fincl_langsda">Danish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsnl" name="fincl_langs" value="nl"><label for="fincl_langsnl">Dutch</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsen" name="fincl_langs" value="en" checked><label for="fincl_langsen">English</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langset" name="fincl_langs" value="et"><label for="fincl_langset">Estonian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langstl" name="fincl_langs" value="tl"><label for="fincl_langstl">Filipino</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsfi" name="fincl_langs" value="fi"><label for="fincl_langsfi">Finnish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsfr" name="fincl_langs" value="fr" checked><label for="fincl_langsfr">French</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsgl" name="fincl_langs" value="gl"><label for="fincl_langsgl">Galician</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langska" name="fincl_langs" value="ka"><label for="fincl_langska">Georgian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsde" name="fincl_langs" value="de" checked><label for="fincl_langsde">German</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsel" name="fincl_langs" value="el"><label for="fincl_langsel">Greek</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsht" name="fincl_langs" value="ht"><label for="fincl_langsht">Haitian Creole</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsiw" name="fincl_langs" value="iw"><label for="fincl_langsiw">Hebrew</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langshi" name="fincl_langs" value="hi"><label for="fincl_langshi">Hindi</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langshu" name="fincl_langs" value="hu"><label for="fincl_langshu">Hungarian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsis" name="fincl_langs" value="is"><label for="fincl_langsis">Icelandic</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsid" name="fincl_langs" value="id"><label for="fincl_langsid">Indonesian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsga" name="fincl_langs" value="ga"><label for="fincl_langsga">Irish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsit" name="fincl_langs" value="it" checked><label for="fincl_langsit">Italian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsja" name="fincl_langs" value="ja"><label for="fincl_langsja">Japanese</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsko" name="fincl_langs" value="ko"><label for="fincl_langsko">Korean</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langslv" name="fincl_langs" value="lv"><label for="fincl_langslv">Latvian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langslt" name="fincl_langs" value="lt"><label for="fincl_langslt">Lithuanian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsmk" name="fincl_langs" value="mk"><label for="fincl_langsmk">Macedonian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsms" name="fincl_langs" value="ms"><label for="fincl_langsms">Malay</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsmt" name="fincl_langs" value="mt"><label for="fincl_langsmt">Maltese</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsno" name="fincl_langs" value="no"><label for="fincl_langsno">Norwegian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsfa" name="fincl_langs" value="fa"><label for="fincl_langsfa">Persian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langspl" name="fincl_langs" value="pl"><label for="fincl_langspl">Polish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langspt" name="fincl_langs" value="pt" checked><label for="fincl_langspt">Portuguese</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsro" name="fincl_langs" value="ro"><label for="fincl_langsro">Romanian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsru" name="fincl_langs" value="ru" checked><label for="fincl_langsru">Russian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssr" name="fincl_langs" value="sr"><label for="fincl_langssr">Serbian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssk" name="fincl_langs" value="sk"><label for="fincl_langssk">Slovak</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssl" name="fincl_langs" value="sl"><label for="fincl_langssl">Slovenian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langses" name="fincl_langs" value="es" checked><label for="fincl_langses">Spanish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssw" name="fincl_langs" value="sw"><label for="fincl_langssw">Swahili</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langssv" name="fincl_langs" value="sv"><label for="fincl_langssv">Swedish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsth" name="fincl_langs" value="th"><label for="fincl_langsth">Thai</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langstr" name="fincl_langs" value="tr"><label for="fincl_langstr">Turkish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsuk" name="fincl_langs" value="uk"><label for="fincl_langsuk">Ukrainian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsur" name="fincl_langs" value="ur"><label for="fincl_langsur">Urdu</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsvi" name="fincl_langs" value="vi"><label for="fincl_langsvi">Vietnamese</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langscy" name="fincl_langs" value="cy"><label for="fincl_langscy">Welsh</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langsyi" name="fincl_langs" value="yi"><label for="fincl_langsyi">Yiddish</label><br />
                </div>
                </td>
            </tr>
            <tr>
                <td class="option_name">Add new line:</td>
                <td><input id="add_new_line" name="add_new_line" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
            </tr>
            <tr>
                <td class="option_name">Show dropdown:</td>
                <td><input id="show_dropdown" name="show_dropdown" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
            </tr>
            <tr>
                <td class="option_name">Dropdown languages:</td>
                <td>
                <div style="height:55px;overflow-y:scroll;">
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsaf" name="incl_langs" value="af" checked><label for="incl_langsaf">Afrikaans</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssq" name="incl_langs" value="sq" checked><label for="incl_langssq">Albanian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsar" name="incl_langs" value="ar" checked><label for="incl_langsar">Arabic</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshy" name="incl_langs" value="hy" checked><label for="incl_langshy">Armenian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsaz" name="incl_langs" value="az" checked><label for="incl_langsaz">Azerbaijani</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langseu" name="incl_langs" value="eu" checked><label for="incl_langseu">Basque</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsbe" name="incl_langs" value="be" checked><label for="incl_langsbe">Belarusian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsbg" name="incl_langs" value="bg" checked><label for="incl_langsbg">Bulgarian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsca" name="incl_langs" value="ca" checked><label for="incl_langsca">Catalan</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langszh-CN" name="incl_langs" value="zh-CN" checked><label for="incl_langszh-CN">Chinese (Simplified)</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langszh-TW" name="incl_langs" value="zh-TW" checked><label for="incl_langszh-TW">Chinese (Traditional)</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshr" name="incl_langs" value="hr" checked><label for="incl_langshr">Croatian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langscs" name="incl_langs" value="cs" checked><label for="incl_langscs">Czech</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsda" name="incl_langs" value="da" checked><label for="incl_langsda">Danish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsnl" name="incl_langs" value="nl" checked><label for="incl_langsnl">Dutch</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsen" name="incl_langs" value="en" checked><label for="incl_langsen">English</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langset" name="incl_langs" value="et" checked><label for="incl_langset">Estonian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langstl" name="incl_langs" value="tl" checked><label for="incl_langstl">Filipino</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsfi" name="incl_langs" value="fi" checked><label for="incl_langsfi">Finnish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsfr" name="incl_langs" value="fr" checked><label for="incl_langsfr">French</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsgl" name="incl_langs" value="gl" checked><label for="incl_langsgl">Galician</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langska" name="incl_langs" value="ka" checked><label for="incl_langska">Georgian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsde" name="incl_langs" value="de" checked><label for="incl_langsde">German</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsel" name="incl_langs" value="el" checked><label for="incl_langsel">Greek</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsht" name="incl_langs" value="ht" checked><label for="incl_langsht">Haitian Creole</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsiw" name="incl_langs" value="iw" checked><label for="incl_langsiw">Hebrew</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshi" name="incl_langs" value="hi" checked><label for="incl_langshi">Hindi</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langshu" name="incl_langs" value="hu" checked><label for="incl_langshu">Hungarian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsis" name="incl_langs" value="is" checked><label for="incl_langsis">Icelandic</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsid" name="incl_langs" value="id" checked><label for="incl_langsid">Indonesian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsga" name="incl_langs" value="ga" checked><label for="incl_langsga">Irish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsit" name="incl_langs" value="it" checked><label for="incl_langsit">Italian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsja" name="incl_langs" value="ja" checked><label for="incl_langsja">Japanese</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsko" name="incl_langs" value="ko" checked><label for="incl_langsko">Korean</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langslv" name="incl_langs" value="lv" checked><label for="incl_langslv">Latvian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langslt" name="incl_langs" value="lt" checked><label for="incl_langslt">Lithuanian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmk" name="incl_langs" value="mk" checked><label for="incl_langsmk">Macedonian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsms" name="incl_langs" value="ms" checked><label for="incl_langsms">Malay</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsmt" name="incl_langs" value="mt" checked><label for="incl_langsmt">Maltese</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsno" name="incl_langs" value="no" checked><label for="incl_langsno">Norwegian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsfa" name="incl_langs" value="fa" checked><label for="incl_langsfa">Persian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langspl" name="incl_langs" value="pl" checked><label for="incl_langspl">Polish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langspt" name="incl_langs" value="pt" checked><label for="incl_langspt">Portuguese</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsro" name="incl_langs" value="ro" checked><label for="incl_langsro">Romanian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsru" name="incl_langs" value="ru" checked><label for="incl_langsru">Russian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssr" name="incl_langs" value="sr" checked><label for="incl_langssr">Serbian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssk" name="incl_langs" value="sk" checked><label for="incl_langssk">Slovak</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssl" name="incl_langs" value="sl" checked><label for="incl_langssl">Slovenian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langses" name="incl_langs" value="es" checked><label for="incl_langses">Spanish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssw" name="incl_langs" value="sw" checked><label for="incl_langssw">Swahili</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langssv" name="incl_langs" value="sv" checked><label for="incl_langssv">Swedish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsth" name="incl_langs" value="th" checked><label for="incl_langsth">Thai</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langstr" name="incl_langs" value="tr" checked><label for="incl_langstr">Turkish</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsuk" name="incl_langs" value="uk" checked><label for="incl_langsuk">Ukrainian</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsur" name="incl_langs" value="ur" checked><label for="incl_langsur">Urdu</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsvi" name="incl_langs" value="vi" checked><label for="incl_langsvi">Vietnamese</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langscy" name="incl_langs" value="cy" checked><label for="incl_langscy">Welsh</label><br />
                <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langsyi" name="incl_langs" value="yi" checked><label for="incl_langsyi">Yiddish</label><br />
                </div>
                </td>
            </tr>
            </table>
        </div>

        <div style="float:left;width:232px;padding-left:50px;">
            <h4>Widget preview</h4>
            <div id="widget_preview"></div>
            <div style="margin-top:15px;"><small class="black">Save the changes to see it in action.</small></div>
        </div>

        <div style="clear:both;"></div>

        <div style="margin-top:20px;">
            <h4>Widget code</h4>
            You can edit this if you wish:<br />
            <textarea id="widget_code" name="widget_code" onchange="ShowWidgetPreview(this.value)" style="font-family:Monospace;font-size:11px;height:150px;width:565px;"><?php echo $widget_code; ?></textarea>
        </div>
            <p class="submit"><input type="submit" class="button-primary" name="save" value="<?php _e('Save Changes'); ?>" /></p>
        </form>
        </div>
        <script type="text/javascript"><?php echo $script; ?></script>
        <?php
    }

    function control_options() {
        $data = get_option('GTranslate');

        $data['pro_version'] = $_POST['pro_version'];
        $data['new_window'] = $_POST['new_window'];
        $data['load_jquery'] = $_POST['load_jquery'];
        $data['default_language'] = $_POST['default_language'];
        $data['translation_method'] = $_POST['translation_method'];
        $data['show_flags'] = $_POST['show_flags'];
        $data['flag_size'] = $_POST['flag_size'];
        $data['add_new_line'] = $_POST['add_new_line'];
        $data['show_dropdown'] = $_POST['show_dropdown'];

        if(get_magic_quotes_gpc())
            $data['widget_code'] = stripslashes($_POST['widget_code']);
        else
            $data['widget_code'] = $_POST['widget_code'];

        echo '<p style="color:red;">Changes Saved</p>';
        update_option('GTranslate', $data);
    }

    function load_defaults(& $data) {
        $data['pro_version'] = isset($data['pro_version']) ? $data['pro_version'] : '';
        $data['new_window'] = isset($data['new_window']) ? $data['new_window'] : '';
        $data['load_jquery'] = isset($data['load_jquery']) ? $data['load_jquery'] : '1';
        $data['add_new_line'] = isset($data['add_new_line']) ? $data['add_new_line'] : '1';
        $data['show_dropdown'] = isset($data['show_dropdown']) ? $data['show_dropdown'] : '1';
        $data['show_flags'] = isset($data['show_flags']) ? $data['show_flags'] : '1';
        $data['default_language'] = isset($data['default_language']) ? $data['default_language'] : 'en';
        $data['translation_method'] = isset($data['translation_method']) ? $data['translation_method'] : 'on_fly';
        $data['flag_size'] = isset($data['flag_size']) ? $data['flag_size'] : '16';
    }
}
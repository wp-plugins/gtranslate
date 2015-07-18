=== GTranslate ===
Contributors: edo888
Author: Edvard Ananyan
Tags: widget, plugin, sidebar, google, translate, translation, automatic translator, google translate, ajax translator, jquery translator, language translator, google translator, language translate, google language translator, translation, translate, multi language
Requires at least: 2.8
Tested up to: 4.3
Stable tag: 1.0.38
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

GTranslate uses Google Translate power to make your website multilingual and available to more than 98% of internet users.

== Description ==

This module uses Google Translate automatic translation service to translate your web page with Google power. With 81 available languages your site will be available to more than 98% of internet users.

Please `use` [GTranslate Forum](http://gtranslate.net/forum/) for your questions and support requests!

* Hides "Suggest better translation" pop-up
* Hides Google top frame after translation
* Mouse over effect
* Flags combined in one file to load faster
* Analytics
* Option to open translated page in new window
* Option to translate the page on fly
* Available styles Dropdown/Flags/flags with dropdown
* Valid XHTML

**Watch GTranslate Tour**
[vimeo http://vimeo.com/30132555]

== Installation ==

1. Upload `gtranslate` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You can add a widget to your website or use [GTranslate] syntax inside pages where you want it to appear.

== Configuration ==

To configure the widget go to Settings -> GTranslate



== Frequently Asked Questions ==

= It doesn't work, what to do? =
Please check the [Troubleshooting](http://gtranslate.net/forum/troubleshooting-gtranslate-free-t370.html) and feel free to create a new topic if you cannot find your case.

= Can I exclude some parts from being translated? =
Yes, you need to wrap the text you don't want to be translated with &lt;span class=&quot;notranslate&quot;&gt;&lt;/span&gt;.

= What is GTranslate? =
GTranslate is a multilingual solution for your website.

* Multilingual solution makes your website available to the world
* One click translation helps visitors to read your site in their native language
* Free automatic translation translates your site instantly upon installation
* Professional translation by a human being is available 24/7
* Customizable layout lets you choose the suitable layout for your site
* Analytics with Google provides insight into your audience and user activity

[vimeo http://vimeo.com/30132555]

= What is the quality of translation? =
It's Google translation, hence Google quality. In the Pro and Enterprise versions you can refine the translations manually and order professional translations directly from your site.

= Which languages are supported? =
Here is the list: Afrikaans, Albanian, Arabic, Armenian, Azerbaijani, Basque, Belarusian, Bengali, Bosnian, Bulgarian, Catalan, Cebuano, Chinese (Simplified), Chinese (Traditional), Croatian, Czech, Danish, Dutch, English, Esperanto, Estonian, Filipino, Finnish, French, Galician, Georgian, German, Greek, Gujarati, Haitian Creole, Hausa, Hebrew, Hindi, Hmong, Hungarian, Icelandic, Igbo, Indonesian, Irish, Italian, Japanese, Javanese, Kannada, Khmer, Korean, Lao, Latin, Latvian, Lithuanian, Macedonian, Malay, Maltese, Maori, Marathi, Mongolian, Nepali, Norwegian, Persian, Polish, Portuguese, Punjabi, Romanian, Russian, Serbian, Slovak, Slovenian, Somali, Spanish, Swahili, Swedish, Tamil, Telugu, Thai, Turkish, Ukrainian, Urdu, Vietnamese, Welsh, Yiddish, Yoruba, Zulu

= Which websites are supported? =
All the HTML websites are supported. However the contents of media files like images and flash will not be translated.

= Where I can see analytics data? =
You need to login to your Google Analytics account -> Content -> Event Tracking. The event name will be GTranslate and you will see event categories for each language code. If you want to see French language usage you can click on fr and you will see which pages are translated to French by your visitors.

= What is a Translation Delivery Network? =
Translation Delivery Network (TDN) aka Foreign Content Delivery Network (FCDN) is similar to Content Delivery Network (CDN) which is responsible for your static content delivery (images, videos, etc.). TDN will deliver your translations and make your site multilingual.

It means that you don't need to install any software on your server and maintain it to make your website multilingual.

[vimeo http://vimeo.com/38686858]

= How Translation Delivery Network works? =
You just need to change your DNS records to add sub-domains or domains dedicated to your languages to our Translation Delivery Network.

So when someone visits the new added sub-domain it will show the translated clone of your website.

After that you can just configure and place the GTranslate Free widget on your site to enable language selection.

= What are the server requirements? =
There are no server requirements! Your website can be written in any programming language and hosted on any web server.

= What about updates? =
Updates are done seamlessly. Since the translations are hosted on our server we take care about updates. You just use up to date service every day.

= Can I test before making a payment? =
You can test the free version.

= Can I use it on SSL / HTTPS website? =
Absolutely! By default we provide a self signed certificate, but if you want we can setup verified certificate purchased by you.

= Can I exclude some parts from being translated? =
Yes, you need to wrap the text you don't want to be translated with &lt;span class="notranslate"&gt;&lt;/span&gt;. You can add class="nturl" to the "a" tag if you don't want the destination URL to contain the language code.

= How it differs from the Pro version? =
Pro version is a software hosted on your own server while Enterprise is a Translation Delivery Network which doesn't require software to be installed on your server.

= How can I be sure that search engines will index my website? =
You can check that this website is indexed in Google by searching for site:gtranslate.net.

= Will it work with JoomFish, sh404sef or other SEF extensions? =
Yes, there are no known extensions which have conflicts with Pro version.

= How I can edit the translations or order professional human translations? =
You need to go to the language you want to edit, for instance, French: http://domain.com/fr/ and add ?language_edit=1 to the end of the URL: http://domain.com/fr/?language_edit=1 and you will see the Edit and Add to Cart buttons near each text.

== Screenshots ==

1. Main View

== Changelog ==

= 1.0.38 =
* Fix for flags display with some templates

= 1.0.37 =
* Bug fixed with new versions of PHP
* Translation queue added

= 1.0.36 =
* On Fly IE9 bug fixed

= 1.0.35 =
* On Fly method is back

= 1.0.34 =
* Error fixed with Chinese language in Enterprise mode

= 1.0.33 =
* Support for Enterprise version added

= 1.0.30 =
* Link and call home updated

= 1.0.29 =
* Custom update checker added

= 1.0.28 =
* Links changed

= 1.0.27 =
* Changed text in noscript tag

= 1.0.26 =
* Fixed issue with SSL admin

= 1.0.25 =
* Fixed installation notification on update event
* Removed unnecessary commented code

= 1.0.24 =
* Tracking added for collecting statistics

= 1.0.23 =
* Bug fixed with javascript jquery loading option

= 1.0.22 =
* Bug fixed with language change in Pro mode
* Added noscript tag

= 1.0.21 =
* Statistics collector temporarily disabled

= 1.0.20 =
* Changed the statistics collector server from Google AppEngine to GoDaddy

= 1.0.19 =
* Added a dummy img to collect usage statistics

= 1.0.18 =
* Fixed issue with the parameters saving in the admin

= 1.0.17 =
* Minor changes in readme.txt

= 1.0.16 =
* Added [GTranslate] syntax to be used inside wordpress articles/pages

= 1.0.15 =
* Added aff link to track visits from wordpress on my site

= 1.0.14 =
* Added notes, so people will not copy the code into their posts

= 1.0.13 =
* jQuery conflicts fixed, using default wp jquery library
* jQuery Translate updated to v1.4.7
* CSRF Security Vulnerability fix

= 1.0.12 =
* No changes made

= 1.0.11 =
* Analytics feature implemented. If you have Google Analytics _gaq code on your site you can enable it and see the language usage.
* Fixed issue with the cookie path in On Fly method

= 1.0.10 =
* Bug fixed: configuration settings were lost after update
* FAQ updated
* Changelog reordered

= 1.0.9 =
* Updated the description

= 1.0.8 =
* Keywords added in the description page
* FAQ updated

= 1.0.7 =
* Widget title changed
* Link added

= 1.0.6 =
* Bug fixed: magic_quotes_gpc problem

= 1.0.5 =
* Bug fixed: settings save problem

= 1.0.4 =
* Minor changes

= 1.0.3 =
* Stable version released

= 1.0.2 =
* RC2 version

= 1.0.1 =
* RC1 version

= 1.0.0 =
* Initial version for WordPress

== Upgrade Notice ==

= 1.0.22 =
Users are highly recommended to upgrade to this version!
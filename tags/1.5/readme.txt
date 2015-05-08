=== Drag & Drop Featured Image ===
Contributors: Plizzo
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=APEQE63QALKHA&lc=SE&item_name=Drag%20%26%20Drop%20Featured%20Image&item_number=drag%2dand%2dfeatured&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: image, upload, metabox, replacement, featured image
Requires at least: 3.2.1
Tested up to: 3.5.1
Stable tag: 1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Drag & Drop Featured Image is a plugin that replaces the default "Set featured image" metabox with a drop zone for faster uploads.

== Description ==

Drag & Drop Featured Image is a plugin made to save you time when setting a featured image. What it does is simple, it replaces the default "Set featured image" metabox with a new one containing a Plupload drop area just like the one found in the media uploader.

Since it uses the default Wordpress functions it will compress all sizes just as the regular upload method would and it also respects any custom image sizes.

You can also choose an image from the gallery or media library, but due to restrictions the page will reload when an image is chosen from one of these locations. This is in order to properly display the image in the meta box.

If you want to showcase testimonials on your website I would highly recommend you download the [Testionials Widget plugin](http://wordpress.org/extend/plugins/testimonials-widget/ "View plugin") by [Michael Cannon](http://wordpress.org/support/profile/comprock/ "Visit profile").

**Drag & Drop Featured Image is now compatible with WordPress 3.5!** (Version 1.4+)

== Installation ==

To perform a manual install, do the following:

1. Upload the 'drag-and-featured' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin through the Appearance => D&D Featured Image options panel

== Frequently Asked Questions ==

= How do I select an image from the Media Library? =

To select a previously uploaded image from the Media Library, start by pressing the media buttons on top of the editor and go to the Media Library tab. Once there, expand the image you want to use and press "Set featured image" just as you would without the plugin. The page will then reload (this is due to the lack of hooks for this function) and your image will be set.

= Which image file formats extensions are currently supported? =

The current formats that are supported are JPG (JPEG), PNG and GIF

= If I have some feature requests, where can I turn to? =

If you have some ideas for new features or improvements I would love to hear about them.. You can get in touch with me by [sending me an email](mailto:contact@jonathanlundstrom.me "My email-address").

== Screenshots ==
1. The metabox without image attached.
2. The metabox with an image attached.
3. Basic options panel to customize plugin display.

== Changelog ==

= 1.5 =
* Split the javascript and stylesheets for the uploader and the panel into separate files.
* Changed the loading behavior of the scripts and stylesheets by changing hooks and checking the current page in order to reduce conflicts.
* All javascript has been refined to remove compatibility issues with other plugins.
* Re-coded the entire featured image mechanism to utilize ajax and mimic the original WordPress behavior. **In other words, no more reloads! (WP3.5+)**

= 1.4.8 =
* Fixes another conflict with Advanced Custom Fields.

= 1.4.6 =
* Fixes a mistake I made where some lines of code from 1.4.2 were removed. Compatibility with ACF has been resolved again in this version.

= 1.4.4 =
* Fixes a potential conflict with other plugins that bind actions to the media uploader.

= 1.4.2 =
* Changed PHP function to reformat names with uppercase characters from 'mb_stroupper' to 'strtoupper'.
* Fixed an issue that affected later versions of Advanced Custom Fields where the image field button would collide with the media selector button JS of this plugin.
* Previously, dropping several files at once would cause them all to upload even though it was warning the user. This issue has now been fixed.

= 1.4 =
* Added WordPress 3.5 compatibility with the new media viewer. Fixed minor issues and hopefully solved the dual file select bug. Please update asap if you run WordPress 3.5.

= 1.3.6 =
* Added settings for plugin customizing control between user roles and capabilities.

= 1.3.5 =
* Fixed Plugin URL in main plugin file. No changes made to the code.

= 1.3.4 =
* Added a button in the uploader ares for quick access to the Media Library. Also changed the meta box priority from 'high' to 'default'. Thanks to [Michael Cannon](http://wordpress.org/support/profile/comprock/ "Visit profile") for suggesting these fixes.

= 1.3.2 =
* Fixes a bug where $post->ID was called at every page instead of the edit page. Thanks to [kanakiyajay](http://profiles.wordpress.org/kanakiyajay/ "Visit profile") for reporting this issue.

= 1.3 =
* This version adds support for choosing an image previously uploaded to the gallery or through the media library. It also includes support for localization. Due to restrictions, the page will reload when you choose an image from one of these locations.

= 1.2 =
* This version fixes a critical bug preventing the pop-out menus to load as well as the visual editor to work properly. Many thanks to [Adam](http://wordpress.org/support/profile/panhead "Visit profile") for reporting this issue.

= 1.1 =
* Updated and improved options panel.
* The options panel is now called 'D&D Featured Image'
* Added option to set a custom filesize limit.
* Removed BMP support as WordPress doesn't support this format.
* This version also fixes some minor text issues.

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.5 =
Major changes done to the plugin in order to fix bugs and better your workflow.

= 1.4.8 =
Fixes another conflict with Advanced Custom Fields.

= 1.4.6 =
Fixes a conflict with Advanced Custom Fields.

= 1.4.4 =
Fixes a potential conflict with other plugins that bind actions to the media uploader.

= 1.4.2 =
Fixed several issues, one that would cause a PHP error and one that affected ACF.

= 1.4 =
Added compatibility with the new media viewer in WordPress 3.5 and fixed other minor issues.
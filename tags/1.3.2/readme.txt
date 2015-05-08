=== Drag & Drop Featured Image ===
Contributors: plizzo
Donate link: http://jonathanlundstrom.me/
Tags: image, upload, metabox, replacement, featured image
Requires at least: 3.2.1
Tested up to: 3.4.2
Stable tag: 1.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Drag & Drop Featured Image is a plugin that replaces the default "Set featured image" metabox with a drop zone for faster uploads.

== Description ==

Drag & Drop Featured Image is a plugin made to save you time when setting a featured image. What it does is simple, it replaces the default "Set featured image" metabox with a new one containing a Plupload drop area just like the one found in the media uploader.

Since it uses the default Wordpress functions it will compress all sizes just as the regular upload method would and it also respects any custom image sizes.

You can also choose an image from the gallery or media library, but due to restrictions the page will reload when an image is chosen from one of these locations. This is in order to properly display the image in the meta box.

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
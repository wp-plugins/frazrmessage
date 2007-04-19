=== Plugin Name ===
Contributors: derletzteschrei
Tags: frazr,frazrmessage,rss,feed,badge
Requires at least: 2.0.5
Tested up to: 2.1.3
Stable tag: 0.3

Rewritten plugin (SimpleTwitter) for showing the recent message from a frazr account.

== Description ==

FrazrMessage

Frazr Message could be used for showing the recently posted fraze. It is rewritten from an existing twitter plugin by David Wood.

The last fraze will be shown without formatting. You could insert the function into your Sidebar.

= Changelog =

* 0.1.1 Changed shown text in admin panel to german.
* 0.2 Added 2 pictures into this package. New function is available for creating a complete frazr badge.
* 0.2.1 Package failure installation instructions corrected.
* 0.2.2 Fixed Problem with Permalinks Hack
* 0.2.3 Rewritten HTML code - new graphics
* 0.3 Added URL parser for the badge. IE bug fixed.

== Installation ==

= Installation =
Extract the file to a local folder. Then follow these steps.

1. Upload the folder `frazrmessage` to your plugin directory `/wp-content/plugins/`
2. Activate the plugin Admin -> Plugins
3. Update the configuration in the Options -> Frazr Message tab
* Input your Frazr username (your login name)
* Set a cache time (e.g. 5 minutes)
* Set URI to a Userimage (48x48 Pixel) otherwise a default icon will be used

= Update =

1. Backup your database to prevent dataloss
2. Deactivate the Frazr Message plugin
3. Delete the folder `frazrmessage` from the `/wp-content/plugins/` folder
4. Follow the installation instructions

= Plain Text Output =
Edit your theme by putting in `<?php get_frazr_msg(); ?>` where you like to have the messages to be shown. It is a simple plain text message.

= Frazr Badge with Balloon Text =
Now you can add a complete badge to your Wordpress blog by using `<?php get_frazr_badge(); ?>`. Just put it into your theme where you like to have it. Creates a 250 x 130 badge with user-defined picture (48x48).

Have fun

== Frequently Asked Questions ==

= How does it work? =

It fetches the messages from an RSS feed.

= What ID should I use? =

Insert your Frazr login name into the configuration of Frazr Message.

= What is a direct link? =

If you like to have the badge on your blog you can choose a userimage. Just insert a link to your piture into the field. After the update of the configuration it should be shown in the upper left corner of your badge. Otherwise check the link.

= Why 48x48? =

Otherwise there might be some stretching or reducing which make your image ... urrkss baaaa.

== Screenshots ==

Not yet.
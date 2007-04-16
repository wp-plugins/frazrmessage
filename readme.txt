=== Plugin Name ===
Contributors: derletzteschrei
Tags: frazr,frazrmessage,rss,feed
Requires at least: 2.0.5
Tested up to: 2.1.3
Stable tag: 0.1

Rewritten plugin (SimpleTwitter) for showing the recent message from a frazr account.

== Description ==

FrazrMessage

Frazr Message could be used for showing the recently posted fraze. It is rewritten from an existing twitter plugin by David Wood.

The last fraze will be shown without formatting. You could insert the function into your Sidebar.

== Installation ==

Extract the file to a local folder. Then follow these steps.

1. Upload the file `frazr_message.php` to your plugin directory `/wp-content/plugins/`
2. Activate the plugin Admin -> Plugins
3. Update the configuration in the Options -> Frazr Message tab
* Input your Frazr username (your login name)
* Set a cache time (e.g. 5 minutes)
4. Edit your theme by putting in `<?php get_frazr_msg(); ?>` where you like to have the messages to be shown

Have fun

== Frequently Asked Questions ==

= How does it work? =

It fetches the messages from an RSS feed.

= What ID should I use? =

Insert your Frazr login name into the configuration of Frazr Message.

== Screenshots ==

Not yet.
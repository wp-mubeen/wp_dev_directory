=== Theme Mentor ===
Contributors: nofearinc
Tags: theme, review, testing, quality, code
Requires at least: 4.9.13
Tested up to: 5.2.5
Stable tag: 0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Theme Mentor is a cousin of the Theme-Check plugin getting deeper into the code analysis.

== Description ==

Theme Mentor is a cousin of the Theme-Check plugin getting deeper into the code analysis.
 
It's using different approaches to monitor for common problems regarding theme reviews from the WordPress Theme Reviewers Team. It is prone to fault analysis, so use only as a reference for improving your code base even further.

Currently supported validations:

* Mark all <link> tags in template files
* Mark all <script> tags in template files
* Warn about query_posts() usage
* capital_P_dangit control (disallow any WordPress spelling other than WordPress as is - that is WORDPRESS and Wordpress, ugh)
* wp_deregister_script('jquery') is forbidden
* wp_dequeue_script('jquery') is forbidden
* prevent global $data; call as a common troublemaker (props @pippinsplugins)

header.php specific

* Make sure that wp_head is before </head>
* Ensure that wp_title(...) is called within <title> and </title> tags

footer.php specific

* Make sure that wp_footer is before </body> 

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `theme-mentor` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Appearance -> Theme Mentor
4. Pick a theme and start the test

== Frequently Asked Questions ==

= Why would I need this plugin? =

The higher the quality of your theme's code, the better the compatibility with the core and the plugins out there. 

= Should I also use Theme-Check? =

It's not required, but it's highly recommended. Theme Mentor is the extra step of notifying you for possible troubles with your code. Part of the remarks could be irrelevant, but hey, better to have something to double check and confirm it's working than to miss obvious code troubles.

== Screenshots ==

1. Sample Theme Mentor validation test results

== Changelog ==

= 0.1 =
* A first release.
* Tracking script/link tag presence, query_posts calls, and wp_head/wp_footer position in files

= 0.2 =
* Code refactor

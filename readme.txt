=== WordPress Favorite Posts Counter ===
Contributors: miiitaka
Tags: post, posts, cookie, shortcode
Requires at least: 5.1.1
Tested up to: 5.1.1
Stable tag: 1.0.0

This plug-in adds a favorite flag to posts. It is a function to record favorite registration on a cookie and to count the number for each post.

== Description ==

This plug-in adds a favorite flag to posts. It is a function to record favorite registration on a cookie and to count the number for each post.

**In a Posts or Pages**

[ Example (Button) ]
`
<?php
if ( shortcode_exists( 'wp-favorite-button' ) ) {
	echo do_shortcode( '[wp-favorite-button post_id="1" class="class_name"]' );
}
?>
`

[ Example (Counter) ]
`
<?php
if ( shortcode_exists( 'wp-favorite-counter' ) ) {
	echo do_shortcode( '[wp-favorite-counter post_id="1" class="class_name"]' );
}
?>
`

== Installation ==

* A plug-in installation screen is displayed in the WordPress admin panel.
* It installs in `wp-content/plugins`.
* The plug-in is activated.
* Register the widget template.
* Add a widget, you specify the registered template.

== Changelog ==

= 1.0.0 (2019-04-xx) =
* The first release.

== Contact ==

* email to foundationmeister[at]outlook.com
* twitter @miiitaka
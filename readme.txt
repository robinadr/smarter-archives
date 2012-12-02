=== Smarter Archives ===
Contributors: rob1n
Tags: archives, archive
Tested up to: 3.4.2
Stable tag: 1.1

Presents archive navigation in a unique way.

== Description ==

This plugin provides you with a template tag for your archives page, which presents navigating 
the archives in a unique way. It has a row for each year with posts, and every month in that 
year with posts has a link to the month. It is also built to be easy to style with CSS, and 
everything is semantic and has a CSS class.

The idea and code was based on the [original Smart Archives plugin](http://justinblanton.com/projects/smartarchives/) 
by [Justin Blanton](http://justinblanton.com/). I just found that its output wasn't to my 
liking, and I enhanced it a bit and recoded portions.

== Installation ==

1. Download and unzip the archive file. You should end up with a file named `smarter-archives.php`.
2. Upload `smarter-archives.php` to `wp-content/plugins/`.
3. Activate *Smarter Archives* in the WordPress admin plugins screen.
4. Put the template tag (`<?php wp_smart_archives(); ?>`) either:
	* In the template's `.php` file.
	* If you have [runPHP](http://www.nosq.com/blog/runphp/) or similar installed, you can put it in the page's content, right in the 
	  admin panel.
5. Enjoy.

== Frequently Asked Questions ==

= It doesn't parse the PHP! =

**Or: I just see `<?php wp_smart_archives(); ?>`!**

Make sure you have [runPHP](http://www.nosq.com/blog/runphp/) and it's 
set up so that your user level can execute PHP within posts and pages. More in the 
[runPHP documentation](http://www.nosq.com/blog/runphp/runphp-manual/).
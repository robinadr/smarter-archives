=== Smarter Archives ===
Contributors: rob1n
Tags: archives, archive
Tested up to: 3.5.1
Stable tag: 2.0.1

Gives a unique way of navigating the yearly and monthly archives of your blog. 
Highly customizable in its output, and ready for translation.

== Description ==

This plugin provides you with a template tag for your archives page, which presents navigating 
the archives in a unique way. It has a row for each year that you posted during, and every month 
in that year with posts has a link. It is also built to be easy to style with CSS, and everything 
is semantic and has a CSS class.

The plugin's output is completely customizable (both HTML tags and CSS classes) and support for 
translations is built-in.

The idea and code was based on the [original Smart Archives plugin](http://justinblanton.com/projects/smartarchives/) 
by [Justin Blanton](http://justinblanton.com/). I just found that its output wasn't to my 
liking, and I enhanced it a bit and recoded portions.

== Installation ==

1. Download and unzip the archive file.
2. Upload the `smarter-archives` to `wp-content/plugins/`.
3. Activate *Smarter Archives* in the WordPress admin plugins screen.
4. Put the template tag (`<?php wp_smart_archives(); ?>`) either:
	* In the template's `.php` file.
	* If you have a plugin that lets you run PHP code installed, you can put it in the page's content, right in the admin panel.
5. Enjoy.

== Frequently Asked Questions ==

= It doesn't parse the PHP! =

**Or: I just see `<?php wp_smart_archives(); ?>`!**

You need a plugin that enables you to put PHP code directly in your posts. 
Alternatively, you can create a template page for your archives page.

== Changelog ==

= 2.0.1 =

* updated WordPress compatibility to 3.5.1

= 2.0 =

* updated WordPress compatibility to 3.5
* main function's output is now completely customizable
* i18n support added; English domain included
* Smarter Archives is now licensed under the GPL v2 license

= 1.5 =

* updated WordPress compatibility to 3.4.2

== License ==

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
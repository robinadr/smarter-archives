=== Smarter Archives ===
Contributors: rob1n
Tags: archives, archive
Tested up to: 3.7.1
Stable tag: 2.6

Gives a unique way of navigating the yearly and monthly archives of your blog. Output is customizable, there are filter hooks in the code, and it is fully translatable.

== Description ==

When you use the `[smarter-archives]` shortcode anywhere on a page or in a post, it gets replaced by a listing of every year since you started posting, and each year has links to every month within that year. However, the plugin is smart enough to know if you didn't create any content in any given month, and doesn't make a link for that month. See the **Screenshots** section for an example of it in action.

See the **Usage** section for a complete list of the arguments the shortcode takes, and how you can use them to customize your archives listing.

The month names are [internationalized with the WordPress translation API](http://codex.wordpress.org/I18n_for_WordPress_Developers). A POT file is included, and if you want to translate please feel free to do so and [contact me](http://robinadr.com/contact) so I can include it with the plugin (with credit to you, of course). Here are the translations that have been done so far:

* Spanish (es_ES)

<small>The idea and code for this plugin came from the [original Smart Archives plugin](http://hypertext.net/projects/smartarchives/) 
by Justin Blanton.</small>

== Screenshots ==

1. An example of the plugin in action [on my website](http://robinadr.com/archives).

== Installation ==

1. Download the ZIP file and unzip it
2. Copy or upload the `smarter-archives` folder to your plugins folder (usually `wp-content/plugins/`)
3. Activate *Smarter Archives* in the admin
4. Put the `[smarter-archives]` shortcode where you want the listing to show
5. Enjoy.

== Usage ==

The `[smarter-archives]` shortcode takes these arguments (default values included):

* `mode` (default: `output`) -- if it's set to `output`, the plugin prints the listing. Set it to `false` to return the value
* `wrapper_class` (default: `smart-archives`) -- class given to the tag wrapped around the listing (`<div>` by default)
* `wrapper_tag` (default: `div`) -- tag wrapped around the listing
* `year_link_class` (default: `year-link`) -- class given to each year links
* `year_tag` (default: `p`) -- tag around each year group
* `after_year` (default: `: `) -- value after the year and before the list of months
* `month_link_class` (default: `month-link`) -- class given to each month link
* `month_tag` (default: `span`) -- tag around each month
* `after_month` (default: `&nbsp;`) -- spacer between months
* `empty_month_class` (default: `empty-month`) -- class applied to empty months (can use this to gray them out)
* `order` (default: `DESC`) -- order the years are shown in (`ASC` for ascending, `DESC` for descending)

**Example Usage**

	[smarter-archives order="DESC" after_month="&bull;"]

== Changelog ==

= 2.6 =

* Standardized i18n calls -- **fully translatable**
* Added a POT file for translating
* Added a lang folder
* **Spanish (es_ES) translation added** -- thanks to Andrew Kurtis of [WebHostingHub](http://www.webhostinghub.com/)
* **New shortcode**: `[smarter-archives]`, see Usage for more details
* Fixed bug: `order` now actually does something

= 2.5 =

[View changes for 2.5 here](http://robinadr.com/2013/04/smarter-archives-2-5).

= 2.0.1 =

* Updated WordPress compatibility to 3.5.1

= 2.0 =

* Updated WordPress compatibility to 3.5
* Main function's output is now completely customizable
* i18n support added; English domain included
* Smarter Archives is now licensed under the GPL v2 license

= 1.5 =

* Updated WordPress compatibility to 3.4.2

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

A full version of the license is included with the plugin in `license.txt`.
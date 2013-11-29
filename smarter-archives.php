<?php
/*
Plugin Name: Smarter Archives
Plugin URI: http://wordpress.org/extend/plugins/smarter-archives/
Author: Robin Adrianse
Author URI: http://robinadr.com/
Description: Unique way to access archives via months, broken down by year. Originally based on <a href="http://justinblanton.com/projects/smartarchives/">code by Justin Blanton</a>.
Version: 2.6
Text Domain: smarter-archives
	
	Smarter Archives plugin for WordPress
	Copyright (C) 2013 Robin Adrianse
	
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

*/

// See readme.txt for a list of arguments this function/shortcode takes
function smarter_archives( $args = '' )
{
	$defaults = apply_filters('smarter_archives_defaults', array(
		'mode' => 'output', 'wrapper_class' => 'smart-archives', 
		'wrapper_tag' => 'div', 'year_link_class' => 'year-link', 
		'year_tag' => 'p', 'after_year' => ': ', 
		'month_link_class' => 'month-link', 'month_tag' => 'span', 
		'after_month' => '&nbsp;', 'empty_month_class' => 'empty-month', 
		'order' => 'DESC'
	));
	
	extract(wp_parse_args($args, $defaults), EXTR_SKIP);
	
	global $wpdb;
	
	$sql_where = apply_filters('smart_archives_where', "WHERE post_type = 'post' AND post_status = 'publish'");
	$sql_join = apply_filters('smart_archives_join', '');
	
	// If it's an unrecognizable $mode, default to output
	if ( $mode != 'output' && $mode != 'return' )
		$mode = 'output';
	
	// Make the $order uppercase so it's easier to deal with
	$order = strtoupper($order);
	
	// If it's an unrecognizable $order, default to DESC so there are no SQL errors
	if ( $order != 'DESC' && $order != 'ASC' )
		$order = 'DESC';
	
	$years = $wpdb->get_results("SELECT DISTINCT YEAR(post_date) AS `year`, COUNT(ID) as `count` FROM $wpdb->posts $sql_join $sql_where GROUP BY year(post_date) ORDER BY post_date $order");
	
	if ( empty($years) )
		return;
	
	$sm = array(
		__('Jan', 'smarter-archives'), __('Feb', 'smarter-archives'), __('Mar', 'smarter-archives'), 
		__('Apr', 'smarter-archives'), __('May', 'smarter-archives'), __('Jun', 'smarter-archives'), 
		__('Jul', 'smarter-archives'), __('Aug', 'smarter-archives'), __('Sep', 'smarter-archives'), 
		__('Oct', 'smarter-archives'), __('Nov', 'smarter-archives'), __('Dec', 'smarter-archives')
	);
	
	$sm = apply_filters('smarter_archives_months', $sm);
	
	$output = '';
	
	if ( !empty($wrapper_class) )
		$output .= sprintf('<%s class="%s">', $wrapper_tag, $wrapper_class);
	else
		$output .= sprintf('<%s>', $wrapper_tag);
	
	if ( !empty($year_link_class) )
		$year_link_class = ' class="' . $year_link_class . '"';
	
	if ( !empty($empty_month_class) )
		$empty_month_class = ' class="' . $empty_month_class . '"';
	
	foreach ( $years as $year ) {
		$year = $year->year;
		
		$output .= sprintf('<%s><a%s href="%s">%s</a>%s', $year_tag, $year_link_class, get_year_link($year), $year, $after_year);
		
		foreach ( $sm as $i => $month ) {
			$mi = $i + 1;
			
			if ( (int) $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts $sql_join $sql_where AND YEAR(post_date) = '$year' AND month(post_date) = '$mi'") > 0 )
				$output .= sprintf('<%s><a href="%s" title="%s">%s</a></%s>', $month_tag, get_month_link($year, $mi), $month, $month, $month_tag);
			else
				$output .= sprintf('<%s%s>%s</%s>', $month_tag, $empty_month_class, $month, $month_tag);
			
			if ( $mi < 12 )
				$output .= $after_month;
		}
		
		$output .= sprintf('</%s>', $year_tag);
	}
	
	$output .= sprintf('</%s>', $wrapper_tag);
	
	if ( $mode == 'output' )
		echo $output;
	else
		return $output;
}

if ( !function_exists( 'wp_smart_archives' ) )
{
	function wp_smart_archives( $args = '' )
	{
		return smarter_archives($args);
	}
}

function smarter_archives_init()
{
	load_plugin_textdomain('smarter-archives', false, basename(dirname(__FILE__)) . '/lang/');
}
add_action('plugins_loaded', 'smarter_archives_init');

function smarter_archives_shortcode( $args = array() )
{
	$args['output'] = false;
	return smarter_archives($args);
}
add_shortcode( 'smarter-archives', 'smarter_archives_shortcode' );
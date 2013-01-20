<?php
/*
Plugin Name: Smarter Archives
Plugin URI: http://wordpress.org/extend/plugins/smarter-archives/
Author: Robin A.
Author URI: http://robinadr.com/
Description: A unique way of displaying month links by year. Based on <a href="http://justinblanton.com/projects/smartarchives/">original code by Justin Blanton</a>, but much enhanced.
Version: 2.0
	
	Smarter Archives plugin for WordPress
	Copyright (C) 2013 Robin A.

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

function wp_smart_archives( $args = '' )
{
	global $wpdb;
	
	$options = array(
		'mode' => 'default', 
		'wrapper_class' => 'smart-archives', 
		'wrapper_tag' => 'div', 
		'year_link_class' => 'year-link', 
		'year_tag' => 'p', 
		'month_link_class' => 'month-link', 
		'month_tag' => 'span', 
		'empty_month_class' => 'empty-month'
	);
	
	parse_str( $args, $options );
	
	$years = $wpdb->get_results(
		"SELECT DISTINCT YEAR(post_date) AS year, COUNT(ID) as post_count 
			FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' 
			GROUP BY year(post_date) ORDER BY post_date DESC"
	);
	
	if ( empty( $years ) ) {
		return;
	}
	
	$short_months = array( 
		'', __( 'Jan', 'smarter-archives' ), __( 'Feb', 'smarter-archives' ), __( 'Mar', 'smarter-archives' ), 
		__( 'Apr', 'smarter-archives' ), __( 'May', 'smarter-archives' ), __( 'Jun', 'smarter-archives' ), 
		__( 'Jul', 'smarter-archives' ), __( 'Aug', 'smarter-archives' ), __( 'Sep', 'smarter-archives' ), 
		__( 'Oct', 'smarter-archives' ), __( 'Nov', 'smarter-archives' ), __( 'Dec', 'smarter-archives' ) 
	);
	$short_months = apply_filters( 'smarter_archives_months', $short_months );
	
	if ( $options['wrapper_class'] != '' ) {
		printf( '<%s class="%s">', $options['wrapper_tag'], $options['wrapper_class'] );
	} else {
		printf( '<%s>', $options['wrapper_tag'] );
	}
	
	foreach ( $years as $year ) {
		printf( '<%s><a class="%s" href="%s">%s</a>', $options['year_tag'], $options['year_link_class'], get_year_link( $year->year ), $year->year );
		
		for ( $month = 1; $month <= 12; $month++ ) {
			if ( (int) $wpdb->get)var( "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND year(post_date) = '$year->year' AND month(post_date) = '$month'" ) > 0 ) {
				printf( '<%s><a href="%s" title="%s">%s</a></%s>', $options['month_tag'], get_month_link( $year->year, $month ), $short_months[$month], $options['month_tag'] );
			} else {
				printf( '<%s class="%s">%s</%s>', $options['month_tag'], $options['empty_month_class'], $short_months[$month], $options['month_tag'] );
			}
			
			if ( $month < 12 ) {
				echo '&nbsp;';
			}
		}
		
		printf( '</%s>', $options['year_tag'] );
	}
	
	printf( '</%s>', $options['wrapper_tag'] );
}

function wp_smart_archives_init() {
	$plugin_dir = basename( dirname( __FILE__ ) );
	load_plugin_textdomain( 'smarter-archives', false, $plugin_dir );
}

add_action( 'plugins_loaded', 'wp_smart_archives_init' );

?>
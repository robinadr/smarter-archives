<?php
/*
Plugin Name: Smarter Archives
Plugin URI: http://robinadr.com/projects/smarter_archives
Author: rob1n
Author URI: http://robinadr.com/
Description: A unique way of displaying month links by year. Based on <a href="http://justinblanton.com/projects/smartarchives/">original code by Justin Blanton</a>, but much enhanced.
Version: 1.0
*/

function wp_smart_archives()
{
	global $wpdb;
	
	$years = $wpdb->get_results( "SELECT distinct year(post_date) AS year, count(ID) as posts FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' GROUP BY year(post_date) ORDER BY post_date DESC" );
	
	if ( empty( $years ) ) {
		return;
	}
	
	$months_short = array( '', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
	
	print '<div class="smart-archives">';
	
	foreach ( $years as $year ) {
		print '<p><a class="year-link" href="' . get_year_link( $year->year ) . '">' . $year->year . '</a>: ';
		
		for ( $month = 1; $month <= 12; $month++ ) {
			if ( (int) $wpdb->get_var( "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND year(post_date) = '$year->year' AND month(post_date) = '$month'" ) > 0 ) {
				print '<a href="' . get_month_link( $year->year, $month ) . '">' . $months_short[$month] . '</a>';
			} else {
				print '<span class="empty-month">' . $months_short[$month] . '</span>';
			}
			
			if ( $month != 12 ) {
				print ' ';
			}
		}
		
		print '</p>';
	}
	
	print '</div>';
}

?>

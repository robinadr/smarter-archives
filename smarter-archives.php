<?php
/***************************************************************************************************
	Plugin Name: Smarter Archives
	Plugin URI: http://wordpress.org/plugins/smarter-archives/
	
	Author: Robin Adrianse
	Author URI: http://robinadr.com/
	
	Description: Easy, simple, and intuitive way to access archives via months, broken down by year.
	Version: 3.1.3
	Text Domain: smarter-archives
	
	Copyright (c) 2013 Robin Adrianse; see license.txt for full license
***************************************************************************************************/

function get_smarter_archives()
{
	global $wpdb;
	
	$sql_where = apply_filters( 'smart_archives_where', "WHERE post_type = 'post' AND post_status = 'publish'" );
	$sql_join = apply_filters( 'smart_archives_join', '' );
	
	$sql = 'SELECT DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, COUNT(ID) AS `count` ' . 
		"FROM $wpdb->posts $sql_join $sql_where " . 
		'GROUP BY MONTH(post_date), YEAR(post_date) ' . 
		'ORDER BY `year` DESC, `month` ASC';
	
	$results = $wpdb->get_results( $sql );
	
	$archives = array();
	
	if ( !empty( $results ) ) {
		foreach ( $results as $result ) {
			if ( !isset( $archives[$result->year] ) )
				$archives[$result->year] = array();
		
			$archives[$result->year][$result->month] = $result->count;
		}
	}
	
	return $archives;
}

function smarter_archives( $args = '' )
{
	$defaults = array(
		'mode' => 'output', 
		'wrapper_class' => 'smart-archives', 
		'wrapper_tag' => 'div', 
		'year_link_class' => 'year-link', 
		'year_tag' => 'p', 
		'year_class' => '', 
		'after_year' => ': ', 
		'month_link_class' => 'month-link', 
		'month_tag' => 'span', 
		'after_month' => '&nbsp;', 
		'empty_month_class' => 'empty-month', 
		'order' => 'DESC'
	);
	$defaults = apply_filters( 'smarter_archives_defaults', $defaults );
	
	extract( wp_parse_args( $args, $defaults ), EXTR_SKIP );
	
	if ( $mode != 'output' && $mode != 'return' )
		$mode = 'output';
	
	$archives = get_smarter_archives();
	
	if ( empty( $archives ) )
		return '';
	
	$order = strtoupper( $order );
	if ( $order == 'ASC' )
		ksort( $archives );
	
	$month_names = array( '', 
		__( 'Jan', 'smarter-archives' ), __( 'Feb', 'smarter-archives' ), __( 'Mar', 'smarter-archives' ), 
		__( 'Apr', 'smarter-archives' ), __( 'May', 'smarter-archives' ), __( 'Jun', 'smarter-archives' ), 
		__( 'Jul', 'smarter-archives' ), __( 'Aug', 'smarter-archives' ), __( 'Sep', 'smarter-archives' ), 
		__( 'Oct', 'smarter-archives' ), __( 'Nov', 'smarter-archives' ), __( 'Dec', 'smarter-archives' )
	);
	$month_names = apply_filters( 'smarter_archives_months', $month_names );
	
	$output = '<' . _smarter_archives_tag( $wrapper_tag, $wrapper_class ) . ">\n";
	
	foreach ( $archives as $year => $months ) {
		$output .= '<' . _smarter_archives_tag( $year_tag, $year_class ) . '>';
		$output .= '<' . _smarter_archives_tag( 'a', $year_link_class ) . ' href="' . get_year_link( $year ) . '">';
		$output .= $year;
		$output .= "</a>$after_year";
		
		foreach ( $month_names as $month_number => $month_name ) {
			if ( isset( $months[$month_number] ) ) {
				$output .= "<$month_tag>";
				$output .= '<' . _smarter_archives_tag( 'a', $month_link_class ) . ' href="';
				$output .= get_month_link( $year, $month_number );
				$output .= '" title="';
				$output .= sprintf( _n( '1 post', '%d posts', $months[$month_number], 'smarter-archives' ), $months[$month_number] );
				$output .= '">';
				$output .= $month_name;
				$output .= "</a></$month_tag>";
			} else {
				$output .= '<' . _smarter_archives_tag( $month_tag, $empty_month_class ) . '>';
				$output .= $month_name;
				$output .= "</$month_tag>";
			}
			
			if ( $month_number < 12 )
				$output .= $after_month;
		}
		
		$output .= "</$year_tag>\n";
	}
	
	$output .= "</$wrapper_tag>\n";
	
	if ( $mode == 'output' )
		print $output;
	else
		return $output;
}

function _smarter_archives_tag( $tag, $class = '' )
{
	if ( !empty( $class ) )
		return "$tag class=\"$class\"";
	else
		return "$tag";
}

if ( !function_exists( 'wp_smart_archives' ) ) :
	function wp_smart_archives( $args = '' )
	{
		return smarter_archives( $args );
	}
endif;

if ( defined( 'WPLANG' ) && constant( 'WPLANG' ) != '' ) :
	function _smarter_archives_textdomain()
	{
		load_plugin_textdomain( 'smarter-archives', false, basename( dirname( __FILE__ ) ) . '/lang/' );
	}
	add_action( 'plugins_loaded', '_smarter_archives_textdomain' );
endif;

function _smarter_archives_shortcode( $args = array() )
{
	$args['mode'] = 'return';
	return smarter_archives( $args );
}
add_shortcode( 'smarter-archives', '_smarter_archives_shortcode' );
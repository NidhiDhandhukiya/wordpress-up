<?php
/*
Plugin Name: SB Breadcrumbs
Description: Display a breadcrumbs on your sites
Plugin URI: http://someblog.vv.si/
Author: Trang Si Hung
Author URI: http://someblog.vv.si/
Version: 1.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

require_once 'sb_main.php';
require_once 'sb_options.php';

add_action( 'wp_enqueue_scripts', 'register_breadcrumbs_styles' );

function sb_breadcrumbs()
{
	$default_options_text = array(
			'home' 		=> 'Home',
			'category' 	=> 'Category Archives: %s',
			'search' 	=> 'Search Results for: %s',
			'tag' 		=> 'Tag Archives: %s',
			'author' 	=> 'Author Archives: %s',
			'p404' 		=> 'Page not found',
			'year' 		=> 'Yearly Archives: %s',
			'month' 	=> 'Monthly Archives: %s',
			'day' 		=> 'Daily Archives: %s'
     );

	$options_text = (array) get_option('sb_breadcrumbs_text_display' );

	if(!isset($options_text['home'])){
		$options_text = $default_options_text;
	}else{
		foreach ($options_text as $key => $text) {
			if($text == ''){
				$options_text[$key] = $default_options_text[$key];
			}
		}
	}

	$args = array(
		'text' 		=> $options_text,
		'display' 	=> (array) get_option('sb_breadcrumbs_display' )
	);

	$breadcrumbs = get_sb_breadcrumbs($args);

	echo $breadcrumbs;
}



 ?>
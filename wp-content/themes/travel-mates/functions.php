<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


function travel_mates_scripts(){
   // enqueue parent style
	wp_enqueue_style('travel-mates-parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'travel_mates_scripts');


function travel_mates_register_block_pattern_categories(){
    register_block_pattern_category(
        'travel-mates',
        array( 'label' => __( 'Travel Mates', 'travel-mates' ) )
    );

}
add_action('init', 'travel_mates_register_block_pattern_categories');

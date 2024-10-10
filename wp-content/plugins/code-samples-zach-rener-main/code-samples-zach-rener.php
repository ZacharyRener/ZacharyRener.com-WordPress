<?php

/**
 * @wordpress-plugin
 * Plugin Name:       ZacharyRener.com Gutenberg Blocks
 * Plugin URI:        https://zacharyrener.com
 * Description:       Native Gutenberg blocks for ZacharyRener.com
 * Version:           1.0.0
 * Author:            Zach Rener
 * Author URI:        https://zacharyrener.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       code-samples-zach-rener
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

function register_custom_block_category( $categories ) {
    $custom_category = array(
        array(
            'slug'  => 'zacharyrener-category',
            'title' => __( 'ZacharyRener.com', 'text-domain' ),
            'icon'  => 'awards', 
        ),
    );
    return array_merge( $custom_category, $categories );
}
add_filter( 'block_categories_all', 'register_custom_block_category', 10, 2 );

function register_custom_block_types() {
    register_block_type( __DIR__ . '/build/header' );
    register_block_type( __DIR__ . '/build/post-grid' );
}
add_action( 'init', 'register_custom_block_types' );
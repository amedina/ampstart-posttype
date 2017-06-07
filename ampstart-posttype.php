<?php
/**
 * Plugin Name: Custom Post Types for AMP STart Templates
 * Plugin URI: https://github.com/amedina/ampstart-posttype
 * Description: A simple plugin that adds custom post type for AMP Start
 * Version: 0.1
 * Author: Google
 * Author URI: http://google.com
 * License: GPL2
 */

/**
 * Add an AMP Start Custom Post Type
 */
// Creates Movie Reviews Custom Post Type
function ampstart_post_type_init() {

	$labels = array(
		'name'               => 'AMP Start Posts',
		'singular_name'      => 'AMP Start Post',
		'menu_name'          => 'AMP Start Posts',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New AMP Start Post',
		'edit_item'          => 'Edit AMP Start Post',
		'view_item'          => 'View AMP Start Post',
		'all_items'          => 'All AMP Start Posts',
		'search_items'       => 'Search AMP Start Articles',
		'not_found'          => 'No AMP Start Post found',
		'singular_name'      => 'AMP Start Post',
		'not_found_in_trash' => 'No AMP Start Posts in Trash',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array('slug' => 'ampstart'),
		'query_var' => true,
		'menu_icon' => 'dashicons-video-alt',
		'supports' => array(
			'title',
			'editor',
			'revisions',
			'thumbnail',
			'author',
			'page-attributes',)
  );
  register_post_type( 'ampstart', $args );
}
add_action( 'init', 'ampstart_post_type_init' );

function ampstart_rewrite_flush() {
  // First, we "add" the custom post type via the above written function.
  // Note: "add" is written with quotes, as CPTs don't get added to the DB,
  // They are only referenced in the post_type column with a post entry,
  // when you add a post of this CPT.
  ampstart_post_type_init();

  // ATTENTION: This is *only* done during plugin activation hook in this example!
  // You should *NEVER EVER* do this on every page load!!
  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ampstart_rewrite_flush' );
add_action( 'after_switch_theme', 'ampstart_rewrite_flush' );

function ampstart_posts( $query ) {
  if ( ! is_admin() && $query->is_main_query() ) {
        if ( $query->is_home() || $query->is_search() ) {
          $query->set( 'post_type', array( 'post', 'ampstart' ) );
        }
  }
}
add_action( 'pre_get_posts', 'ampstart_posts' );

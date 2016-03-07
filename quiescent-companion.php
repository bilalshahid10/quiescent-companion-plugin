<?php
/**
 * Plugin Name: Quiescent Companion
 * Description: Plugin to work with the Quiescent WP REST API theme
 * Author: Bilal Shahid
 * Author URI: http://imbilal.com
 */

/**
 * Modifying the response for the Post object
 */
function quiescent_modify_post_response() {
	// adding a field for the featured image
	register_rest_field( 'post', 'quiescent_featured_image', array(
		'get_callback'		=> 'quiescent_get_featured_image',
		'update_callback'	=> null,
		'schema'			=> null
	) );

	// adding a field for author name
	register_rest_field( 'post', 'quiescent_author_name', array(
		'get_callback'		=> 'quiescent_get_author_name',
		'update_callback'	=> null,
		'schema'			=> null
	) );

	// adding a field for categories
	register_rest_field( 'post', 'quiescent_categories', array(
		'get_callback'		=> 'quiescent_get_categories',
		'update_callback'	=> null,
		'schema'			=> null
	) );
}
add_action( 'rest_api_init', 'quiescent_modify_post_response' );



/**
 * Function to retrieve featured image link
 */
function quiescent_get_featured_image( $post, $field_name, $request ) {
	$attachment_id = $post['featured_media'];
	$attachment_info = wp_get_attachment_image_src( $attachment_id, 'quiescent_post_thumbnail' );
	return $attachment_info[0];
}



/**
 * Function to retrieve author name
 */
function quiescent_get_author_name( $post, $field_name, $request ) {
	return get_the_author_meta( 'display_name', $post['author'] );
}



/**
 * Function to retrieve categories
 */
function quiescent_get_categories( $post, $field_name, $request ) {
	return get_the_category( $post['id'] );
}



/**
 * Adding image size for the featured image
 */
function quiescent_add_image_size() {
	add_image_size( 'quiescent_post_thumbnail', 712, 348, true );
}
add_action( 'init', 'quiescent_add_image_size' );



/**
 * Modifying the response for the User object
 */
function quiescent_modify_user_response() {
	// adding a field for 207 X 207 avatar
	register_rest_field( 'user', 'quiescent_avatar_url', array(
		'get_callback'		=> 'quiescent_get_user_avatar',
		'update_callback'	=> null,
		'schema'			=> null
	) );
}
add_action( 'rest_api_init', 'quiescent_modify_user_response' );



/**
 * Retrieving the avatar for the user
 */
function quiescent_get_user_avatar( $user, $field_name, $request ) {
	$args = array(
		'size'	=> 207
	);

	return get_avatar_url( $user['id'], $args );
}
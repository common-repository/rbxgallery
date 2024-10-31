<?php
/*
Plugin Name: RBXGallery
Plugin URI: http://www.rudrainnovatives.com
Description: Attaches multiple images to a post/page or custom type post to each post.
Version: 3.1
Author: Rudra Innovative Software
Author URI: http://www.rudrainnovatives.com
License: open
*/


// functions replacing table name
function rbx_gallery()
{
	global $wpdb;
	return $wpdb->prefix . "rbxgallery";
}
function rbx_post_images()
{
	global $wpdb;
	return $wpdb->prefix . "rbxpostimages";
}

function rbx_gallery_plugin_activate()
{
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . rbx_gallery() . '"')) == 0)
	{
		$sql = "CREATE TABLE IF NOT EXISTS " . rbx_gallery() . " (
				id int(11) NOT NULL AUTO_INCREMENT,
				name varchar(100) NOT NULL,
				path varchar(200) NOT NULL,
				title varchar(100) NOT NULL,
				description text NOT NULL,
				slide_order tinyint(10) NOT NULL,
				slide_link varchar(100) NOT NULL,
				effect varchar(30) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;";
		
		dbDelta($sql);
	}
	
	if (count($wpdb->get_var('SHOW TABLES LIKE "' . rbx_post_images() . '"')) == 0)
	{
		$sql = "CREATE TABLE IF NOT EXISTS " . rbx_post_images() . " (
				id int(11) NOT NULL AUTO_INCREMENT,
				postid int(11) NOT NULL,
				path varchar(500) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;";
		
		dbDelta($sql);
	}
	
	if (!get_option('rbx_db_version')) {
		add_option("rbx_db_version", "2.0");

	}
	if(!get_option('rbx_theme')){
		add_option('rbx_theme', 'default');
	}
	if (!get_option('rbx_effect')) {
		add_option('rbx_effect', 'none');
	}
	if (!get_option('rbx_position')) {
		add_option('rbx_position', 'bottom');
	}
	if (!get_option('rbx_height')) {
		add_option('rbx_height', '235');
	}
	if (!get_option('rbx_width')) {
		add_option('rbx_width', '630');
	}
	if (!get_option('rbx_margin')) {
		add_option('rbx_margin', '40');
	}
	if(!get_option('rbx_show_next_prev')){
		add_option('rbx_show_next_prev','true');
	}
	if(!get_option('rbx_show_navigation')){
		add_option('rbx_show_navigation','true');
	}
	if(!get_option('rbx_speed')){
		add_option('rbx_speed','500');
	}
	if(!get_option('rbx_duration')){
		add_option('rbx_duration','3000');
	}
	
	// gallery options
	
	if(!get_option('rbx_zoom_imgheight')){
		add_option('rbx_zoom_imgheight','300');
	}
	if(!get_option('rbx_zoom_imgwidth')){
		add_option('rbx_zoom_imgwidth','300');
	}
	if(!get_option('rbx_gal_imgborder')){
		add_option('rbx_gal_imgborder','5');
	}
	if(!get_option('rbx_gal_imgbordercolor')){
		add_option('rbx_gal_imgbordercolor','#000000');
	}
	
}

register_activation_hook(__FILE__, 'rbx_gallery_plugin_activate');

function rbx_gallery_menu(){
	add_menu_page('RBXGallery Options', 'RBX Gallery', 'administrator', 'rbxgallery', 'rbx_menu_callback','');
	add_submenu_page( 'rbxgallery', 'Add Images', 'Add Images', 'administrator', 'rbxslider-uploader', 'rbx_slider_callback');
	add_submenu_page( 'rbxgallery', 'RBX Settings', 'RBX Settings', 'administrator', 'rbxslider-settings', 'rbx_theme_func_faq');
}

add_action('admin_menu', 'rbx_gallery_menu');

// Menu Functions
 
function rbx_menu_callback()
{
	global $wpdb;
	include_once plugin_dir_path( __FILE__ ) . 'views/rbxhome.php';
}
function rbx_slider_callback()
{
	global $wpdb;
	include_once plugin_dir_path( __FILE__ ) . 'views/rbxsliderimages.php';
} 
function rbx_theme_func_faq()
{
	global $wpdb;
	include_once plugin_dir_path( __FILE__ ) . 'views/rbxslidesettings.php';
}

function rbx_gallery_admin_scripts() {
	global $wp_version;
	if ( version_compare( $wp_version, '3.5', '<' ) ) { // Use old media manager
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}
	else {
			// Required media files for new media manager. Since WP 3.5+
			wp_enqueue_media();
	}

}
add_action('admin_print_scripts', 'rbx_gallery_admin_scripts');

function rbx_gallery_meta_box()
{
	$post_types = get_post_types(array(
		"public" => true
	));
	foreach ($post_types as $post_type) {
		add_meta_box('bximg', __('RBXGallery', 'myplugin_textdomain'), 'rbx_gallery_box', $post_type);
	}
}
function rbx_gallery_box()
{
	include_once plugin_dir_path( __FILE__ ) . 'views/rbx_gallery_box.php';
}

add_action('add_meta_boxes', 'rbx_gallery_meta_box');

function rbx_gallery_tab($tabs)
{
	unset($tabs['gallery']);	
	$tabs['rbxgallery'] = __('RBXGallery', 'wpsc');
	return $tabs;
}
add_filter('media_upload_tabs', 'rbx_gallery_tab', 12);

add_action('media_upload_rbxgallery', 'rbx_add_my_new_form');
function rbx_add_my_new_form() {
	wp_iframe( 'rbx_form_images' );
}


// the tab content
function rbx_form_images() {
	include_once plugin_dir_path( __FILE__ ) . '/views/rbx_postimages.php';
}

add_image_size('my-thumbnails', 60, 60);

add_action('after_setup_theme', 'theme_thub_sizes');
function theme_thub_sizes()
{
	add_image_size('thumbZoom', 308, 9999, false);
	add_image_size('thumbss', 135, 135, true);
}

function rbx_gallery_scripts_method()
{
	// register your script location, dependencies and version and enqueue the script
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery.rbxGallery.1.1.min.js', plugins_url("RBXGallery") .'/assets/js/jquery.rbxGallery.1.1.min.js');
	wp_enqueue_script('custom.js', plugins_url("RBXGallery") .'/assets/js/custom.js');
	if (get_option('rbx_effect') == 'jq_zoom') {
		wp_enqueue_script('jquery.jqzoom-core.js', plugins_url("RBXGallery") .'/assets/js/jquery.jqzoom-core.js');
	}
	
	wp_enqueue_script('jquery.nivo.slider.js', plugins_url("RBXGallery") .'/assets/js/jquery.nivo.slider.js');
	wp_enqueue_script('colorpicker.js', plugins_url("RBXGallery") .'/assets/js/colorpicker.js');
	wp_enqueue_script('PictureSlides-jquery-2.0.js', plugins_url("RBXGallery") .'/assets/js/PictureSlides-jquery-2.0.js');
	
	wp_enqueue_script('lightbox-2.6.min.js', plugins_url("RBXGallery") .'/assets/js/lightbox-2.6.min.js');
	wp_enqueue_script('jquery.jqzoom-core.js', plugins_url("RBXGallery") .'/assets/js/jquery.jqzoom-core.js');
}
add_action('init', 'rbx_gallery_scripts_method');
function rbx_gallery_stylesheet()
{
	wp_enqueue_style('RBXGallery.css', plugins_url("RBXGallery") .'/assets/css/RBXGallery.css');
	wp_enqueue_style('nivo-slider.css', plugins_url("RBXGallery") .'/assets/css/nivo-slider.css');
	
	wp_enqueue_style('default.css', plugins_url("RBXGallery") .'/assets/themes/default/default.css');
	wp_enqueue_style('bar.css', plugins_url("RBXGallery") .'/assets/themes/bar/bar.css');
	wp_enqueue_style('dark.css', plugins_url("RBXGallery") .'/assets/themes/dark/dark.css');
	wp_enqueue_style('light.css', plugins_url("RBXGallery") .'/assets/themes/light/light.css');
	wp_enqueue_style('colorpicker.css', plugins_url("RBXGallery") .'/assets/css/colorpicker.css');
	
	wp_enqueue_style('picture-slides.css', plugins_url("RBXGallery") .'/assets/css/picture-slides.css');
	wp_enqueue_style('lightbox.css', plugins_url("RBXGallery") .'/assets/css/lightbox.css');
	wp_enqueue_style('jquery.jqzoom.css', plugins_url("RBXGallery") .'/assets/css/jquery.jqzoom.css');
	
}
add_action('init', 'rbx_gallery_stylesheet');

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case "rbxgallerylib":
		add_action( 'admin_init', 'rbxgallerylib' );
		function rbxgallerylib()
		{
			global $wpdb;
			include_once plugin_dir_path( __FILE__ ) . 'library/rbxgallery-lib.php';
		}
		break;
	}
	
}

function rbx_slider_shortcode()
{
	include_once plugin_dir_path( __FILE__ ) . 'views/rbx_front_slider.php';
}


add_shortcode('rbxslider', 'rbx_slider_shortcode');

function rbx_gallery_shortcode()
{
	include_once plugin_dir_path( __FILE__ ) . 'views/rbxfrontgallery.php';
}


add_shortcode('rbxgallery', 'rbx_gallery_shortcode');

<?php
/**
 * Torno Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Torno Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_TORNO_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'torno-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_TORNO_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

// Change Administrator user role name
function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can list all currently available roles like this...
    //$roles = $wp_roles->get_names();
    //print_r($roles);

    //You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
    $wp_roles->roles['administrator']['name'] = 'Developer';
    $wp_roles->role_names['administrator'] = 'Developer';       
	
	$wp_roles->roles['editor']['name'] = 'Admin';
    $wp_roles->role_names['editor'] = 'Admin';      
}

add_action( 'init', 'change_role_name');

//Disable admin notices
function ds_admin_theme_style() {
	if (!current_user_can('manage_options')) {
		echo '<style>.update-nag, .updated, .error, .is-dismissible .notice .notice-success { display: none; }</style>';
		echo '<style>.wp-core-ui .notice.is-dismissible{ display: none; }</style>';
		echo '<style>.fv-review, .fv-pro-box, .fv-notice{ display: none !important; }</style>';
		echo '<style> .notice-info, .notice.notice-info.important { display: none !important; }</style>';
		echo '<style> .woocommerce-homepage-notes-wrapper {display:none}</style>';
		echo '<style> .lddfw_admin_bar {display:none}</style>';
	}
}

add_action( 'admin_enqueue_scripts', 'ds_admin_theme_style' );
add_action( 'login_enqueue_scripts', 'ds_admin_theme_style' );

// Remove woocommerce home page on admin panel
function plt_hide_woo_menus() {
	remove_submenu_page('woocommerce', 'wc-admin');
}

// Remove the edit menu from admin bar
function remove_edit_menu( $wp_admin_bar ) {
  $wp_admin_bar->remove_node( 'edit' );
}

//Specific settings for Dashborad customization of Admins
function hide_specific_admin_menu_items() {
	if (!current_user_can('manage_options')) {
		//add_action('admin_menu', 'plt_hide_woo_menus', 71);
		add_filter( 'ast_block_templates_disable', '__return_true' );
		add_action( 'admin_bar_menu', 'remove_edit_menu', 999 );
	}
}

add_action('init', 'hide_specific_admin_menu_items');
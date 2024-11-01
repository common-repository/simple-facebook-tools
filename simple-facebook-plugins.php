<?php
/**
 * @package Simple_Facebook_Plugins
 * @version 1.0
 */
/*
Plugin Name: Simple Facebook Plugins
Plugin URI: http://www.medust.com/
Description: The Simplest way to bring Facebook Page and other social plugins by facebook to WordPress with lot more Options. This plugin is based on Graph API v2.9
Version: 1.0
Author: Medust
Author URI: http://www.medust.com
*/

/*
    Copyright (C) 2010- 2017 Medust.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(! defined('ABSPATH')) {
    exit;
}

require_once ( plugin_dir_path( __FILE__ ) . 'classes/menu.class.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'classes/settings.class.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'classes/widget.class.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'classes/shortcode.class.php' );

add_action('init', mtfb_page_main_loader_func);

function mtfb_page_main_loader_func() {
    new Mtfb_page_menu_settings();
    new Mtfb_shortcode_output();
}

add_action('admin_init', mtfb_page_admin_func);
function mtfb_page_admin_func() {
    new Mtfb_page_register_settings();
}

// Register widget to WP
add_action('widgets_init', 'mtfb_register_fb_widget');

function mtfb_register_fb_widget() {
    register_widget('Mtfb_page_widget');
}


/*add_action( 'wp_footer', 'check_mtfb_widget' );

function check_mtfb_widget() {
    if( is_active_widget( '', '', 'Mtfb_page_widget' ) ) {
        echo 'check';
    }
}*/
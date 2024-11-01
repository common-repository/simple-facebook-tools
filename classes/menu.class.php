<?php
/**
 * @package Simple_Facebook_Plugins
 * @version 1.0
 */
class Mtfb_page_menu_settings {
    
    public function __construct() {
        $this->mtfb_page_add_menu_page();
    }
    
    public function mtfb_page_add_menu_page() {
        add_action('admin_menu', array('Mtfb_page_menu_settings', 'create_menu_pages'));
        add_action('admin_enqueue_scripts', array($this, 'enqueque_scripts_for_admin'));
    }
    
    public function enqueque_scripts_for_admin() {
        if( $_GET['page'] == 'mtfb_page' ) {
            wp_enqueue_script('mtfb-page-js', plugin_dir_url(__FILE__) . '../assets/fbpage-script.js', array('jquery-ui-tabs'), '20740520', true);
            wp_enqueue_style('mebounce-custom-admin-css', plugin_dir_url(__FILE__) . '../assets/custom.css');
        }
    }
    
    public function create_menu_pages() {

        //add_menu_page('mtfb_page', 'Facebook Page', 'administrator', 'mtfb_page', array('Mtfb_page_menu_settings', 'fb_page_func'), plugin_dir_url(__FILE__) . '../images/fb-icon.png', 89.5);
        
        // Add submenu to settings menu
        add_options_page( 'Simple Facebook Plugins Settings Page', 'Facebook Plugins', 'manage_options', 'mtfb_page', array('Mtfb_page_menu_settings', 'fb_page_func') );
    }
    
    public function fb_page_func() {
        ?>
    <div class="wrap">

        <h2><?php _e('Facebook Plugins', 'mtfb-page')?></h2>
        <div class="clear"></div>
        <?php 
        $settings_option = get_option('mtfb_page_settings_options'); 
        if( $settings_option['fb_app_id'] == '' ) :
        ?>
        <div class="error notice is-dismissible">
            <p>Add facebook app ID in the "settings" section here, to execute the plugin.</p>
        </div>
        <?php endif; ?>
        <?php echo $message; ?>

        <div class="main-area">
            <div id="fb_page_tabs">
                <ul class="tabs">
                    <li><a href="#fb_page_tab1">Facebook Page</a></li>
                    <li><a href="#fb_page_tab2">Other FB Plugins</a></li>
                    <li><a href="#fb_page_tab3">Settings</a></li>
                </ul>
                
                <div class="all-tab-content">
                    <div id="fb_page_tab1">
                        <div class="tab-content">
                            <form method="post" action="options.php" enctype="multipart/form-data">
                                <?php 
        $fbpg_option = get_option('mtfb_page_fbpg_plugin_options');
        //print_r($fbpg_option);
        
                                settings_fields('mtfb_page_fbpg_plugin_options');
                                do_settings_sections('mtfb_page_fbpg_settings'); 
                                ?>

                                <p class="submit">
                                    <input name="submit" type="submit" class="button-primary" value="Save Changes">
                                </p>
                            </form>
                        </div>
                    </div>
                    <div id="fb_page_tab2">
                        <div class="tab-content">
                            <h2>Save to Facebook Button</h2>
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/save_to_fb.jpg">
                            <p>Add the <strong>shortcode</strong> to your content to display the send button.</p>
                            <code>[mtfb_save_to_fb_btn url="YOUR URL" btn_size="large/small"]</code>
                            
                            <h2>Send Button</h2>
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/send-btn.jpg">
                            <p>Add the <strong>shortcode</strong> to your content to display the send button.</p>
                            <code>[mtfb_messenger_send_btn url="YOUR URL"]</code>
                            
                            <h2>Like &amp; Share Button</h2>
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/like-and-share.jpg">
                            <p>Add the <strong>shortcode</strong> to your content to display the send button.</p>
                            <code>[mtfb_like_btn url="YOUR URL" btn_size="large/small" layout="standard"]</code>
                            <p>Layout field can be:</p>
                            <ul style="list-style:disc;padding-left:20px;">
                                <li>standard</li>
                                <li>box_count</li>
                                <li>button_count</li>
                                <li>button</li>
                            </ul>
                        </div>
                    </div>
                    <div id="fb_page_tab3">
                        <div class="tab-content">
                            <form method="post" action="options.php" enctype="multipart/form-data">
                                <?php 
        //print_r($settings_option);
        
                                settings_fields('mtfb_page_settings_options');
                                do_settings_sections('mtfb_page_settings'); 
                                ?>

                                <p class="submit">
                                    <input name="submit" type="submit" class="button-primary" value="Save Changes">
                                </p>
                            </form>
                        </div>
                    </div>
                </div><!--.all-tab-content-->
            </div><!--#fb_page_tabs-->
            <div class="clear"></div>
        </div>

    </div>
    <?php
    }
    
}
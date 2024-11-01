<?php
/**
 * @package Simple_Facebook_Plugins
 * @version 1.0
 */
class Mtfb_shortcode_output {
    
    public function __construct() {
        $this->fbpg_add_shortcode();
    }
    
    public function fbpg_add_shortcode() {
        add_shortcode( 'mtfb_save_to_fb_btn', array( $this, 'save_to_fb_btn_func' ) );
        add_shortcode( 'mtfb_messenger_send_btn', array( $this, 'messenger_send_btn_func' ) );
        add_shortcode( 'mtfb_like_btn', array( $this, 'like_btn_func' ) );
    }
    
    function fbpage_code() {
        
        $options = get_option('mtfb_page_settings_options');
        $app_id = $options['fb_app_id'];
        ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=<?php echo $app_id; ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
        <?php
    }
    
    function save_to_fb_btn_func( $atts ) {
        extract( shortcode_atts( array(
            'url' => '',
            'btn_size' => 'large',
        ), $atts ) );
        
        $output = '<div class="fb-save" data-uri="' . $url . '" data-size="' . $btn_size . '"></div>';
        
        add_action( 'wp_footer', array( $this, 'fbpage_code' ) );
        
        return $output;
    }
    
    function messenger_send_btn_func( $atts ) {
        extract( shortcode_atts( array(
            'url' => '',
        ), $atts ) );
        
        $output = '<div class="fb-send" data-href="' . $url . '"></div>';
        
        wp_enqueue_style('fb-page-style');
        add_action( 'wp_footer', array( $this, 'fbpage_code' ) );
        
        return $output;
    }
    
    function like_btn_func( $atts ) {
        extract( shortcode_atts( array(
            'url' => '',
            'btn_size' => 'large',
            'layout' => 'standard',
        ), $atts ) );
        
        $output = '<div class="fb-like" data-href="' . $url . '" data-layout="' . $layout . '" data-action="like" data-size="' . $btn_size . '" data-show-faces="true" data-share="true"></div>';
        
        add_action( 'wp_footer', array( $this, 'fbpage_code' ) );
        
        return $output;
    }
}
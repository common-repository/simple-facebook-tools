<?php
/**
 * @package Simple_Facebook_Plugins
 * @version 1.0
 */
class Mtfb_page_widget extends WP_Widget {
    
    public function __Construct() {
        $params = array(
                    'name' => 'Facebook Page',
                    'description' => 'Display your facebook page to sidebar of your site.',
                );
        parent::__construct( 'Mtfb_page_widget', '', $params );
    }
    
    public function form($instance) {
        extract( $instance );
        ?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>">Title: </label>
    <input 
           class="widefat" 
           id="<?php echo $this->get_field_id('title'); ?>" 
           name="<?php echo $this->get_field_name('title') ?>" 
           value="<?php if( isset($title) ) echo esc_attr($title); ?>" />
</p>
        <?php
    }
    
    public function widget( $args, $instance ) {
        extract($args);
        extract($instance);
        
        // Adding JavaScript SDK code to run the plugin properly.
        add_action( 'wp_footer', array( $this, 'fbpage_code' ) );
        
        $page_options = get_option('mtfb_page_fbpg_plugin_options');
        
        $url = $page_options['fb_page_url'];
        $tabs_array = $page_options['fb_page_tabs'];
        $height = "300";
        $width = "300";
        
        if( isset( $page_options['fb_page_height'] ) && ( $page_options['fb_page_height'] != '' ) ) {
            $height = $page_options['fb_page_height'];
        }
        if( isset( $page_options['fb_page_width'] ) && ( $page_options['fb_page_width'] != '' ) ) {
            $width = $page_options['fb_page_width'];
        }
        
        $tabs_data = '';
        $small_header = 'false';
        $cover = 'false';
        // Checking for tabs
        if( isset( $tabs_array ) ) {
            $tabs = implode( ',', $tabs_array );
            $tabs_data = 'data-tabs="' . $tabs . '"';
        }
        // Checking for small header
        if( isset( $page_options['fb_page_small_header'] ) ) {
            $small_header = $page_options['fb_page_small_header'];
        }
        // Checking for cover
        if( isset( $page_options['fb_page_cover'] ) ) {
            $cover = $page_options['fb_page_cover'];
        }
        
        $face = $page_options['friends_face'];
        $adapt = $page_options['adaptive_width'];
        
        echo $before_widget;
            echo $before_title . $title . $after_title;
        ?>
<div class="fb-page" data-href="<?php echo $url; ?>" <?php echo $tabs_data; ?> data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" data-small-header="<?php echo $small_header; ?>" data-adapt-container-width="<?php echo $adapt; ?>" data-hide-cover="<?php echo $cover; ?>" data-show-facepile="<?php echo $face; ?>"><blockquote cite="<?php echo $url; ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $url; ?>">Facebook Page</a></blockquote></div>
        <?php
        echo $after_widget;
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
}
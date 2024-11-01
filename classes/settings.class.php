<?php 
/**
 * @package Simple_Facebook_Plugins
 * @version 1.0
 */
class Mtfb_page_register_settings {
    public $page_options;
    public $settings_options;
    
    public function __construct() {
        $this->page_options = get_option('mtfb_page_fbpg_plugin_options');
        $this->settings_options = get_option('mtfb_page_settings_options');
        $this->register_settings_and_fields();
    }
    
    public function register_settings_and_fields() {
        // FaceBook Page Options
        register_setting('mtfb_page_fbpg_plugin_options', 'mtfb_page_fbpg_plugin_options');   // 3rd param = optional cb
        
        // Settings Section
        add_settings_section('mtfb_page_fbpg_settings_section', 'FB Page', array($this, 'mtfb_page_fbpg_section_cb'), 'mtfb_page_fbpg_settings');   // id, title, cb, which page?
        
        add_settings_field('mtfb_page_url', 'Page URL', array($this, 'mtfb_page_url_setting'), 'mtfb_page_fbpg_settings', 'mtfb_page_fbpg_settings_section');
        
        add_settings_field('mtfb_page_tabs', 'Page Tabs', array($this, 'mtfb_page_tabs_setting'), 'mtfb_page_fbpg_settings', 'mtfb_page_fbpg_settings_section');
        
        add_settings_field('mtfb_page_small_header', 'Use Small Header', array($this, 'mtfb_page_header_setting'), 'mtfb_page_fbpg_settings', 'mtfb_page_fbpg_settings_section');
        
        add_settings_field('mtfb_page_hide_cover', 'Hide Cover Photo', array($this, 'mtfb_page_cover_setting'), 'mtfb_page_fbpg_settings', 'mtfb_page_fbpg_settings_section');
        
        add_settings_field('mtfb_page_width', 'Width', array($this, 'mtfb_page_width_setting'), 'mtfb_page_fbpg_settings', 'mtfb_page_fbpg_settings_section');
        
        add_settings_field('mtfb_page_height', 'Height', array($this, 'mtfb_page_height_setting'), 'mtfb_page_fbpg_settings', 'mtfb_page_fbpg_settings_section');
        
        add_settings_field('mtfb_page_frnds_face', "Show Friend's Faces" , array($this, 'mtfb_page_frnds_face_setting'), 'mtfb_page_fbpg_settings', 'mtfb_page_fbpg_settings_section');
        
        add_settings_field('mtfb_page_adaptive_width', "Adapt To Cotainer Width" , array($this, 'mtfb_page_adaptive_width_setting'), 'mtfb_page_fbpg_settings', 'mtfb_page_fbpg_settings_section');
        
        // Save to FaceBook Button Options
        register_setting('mtfb_page_settings_options', 'mtfb_page_settings_options');   // 3rd param = optional cb
        
        // Settings Section
        add_settings_section('mtfb_page_settings_section', 'Settings', array( $this, 'mtfb_page_settings_section_cb' ), 'mtfb_page_settings');   // id, title, cb, which page?
        
        add_settings_field('mtfb_page_app_id', 'App ID', array($this, 'mtfb_page_app_id_setting'), 'mtfb_page_settings', 'mtfb_page_settings_section');
        
    }
    
    // Functions for facebook page settings
    public function mtfb_page_fbpg_section_cb() {
        
    }
    
    public function mtfb_page_url_setting() {
        $url = '';
        if(isset($this->page_options['fb_page_url']))
            $url = $this->page_options['fb_page_url'];
        
        $field = "<input name='mtfb_page_fbpg_plugin_options[fb_page_url]' type='text' class='regular-text' value='".$url."'>";
        
        $info = '<p>Type your FaceBook page full URL here. Eg. <code>https://www.facebook.com/medustdotcom/</code></p>';
        
        echo $field . $info;
    }
    
    public function mtfb_page_tabs_setting() {
        $tabs = '';
        if( isset( $this->page_options['fb_page_tabs'] ) ) {
            $tabs = $this->page_options['fb_page_tabs'];
            
            $timelineChecked = ( in_array( 'timeline', $tabs ) ) ? 'checked' : '';
            $eventsChecked = ( in_array( 'events', $tabs ) ) ? 'checked' : '';
            $messagesChecked = ( in_array( 'messages', $tabs ) ) ? 'checked' : '';
        }
        
        $field = '<label><input type="checkbox" name="mtfb_page_fbpg_plugin_options[fb_page_tabs][]" '.$timelineChecked.' value="timeline">Timeline</label>
        <label><input type="checkbox" name="mtfb_page_fbpg_plugin_options[fb_page_tabs][]" '.$eventsChecked.' value="events">Events</label>
        <label><input type="checkbox" name="mtfb_page_fbpg_plugin_options[fb_page_tabs][]" '.$messagesChecked.' value="messages">Messages</label>';
        
        $info = '<p>You can now have timeline, events and messages tabs on the plugin:</p>
        <ul>
        <li><strong>Timeline Tab:</strong> Will show the most recent posts of your Facebook Page timeline.</li>
        <li><strong>Events Tab:</strong> People can follow your page events and subscribe to events from the plugin.</li>
        <li><strong>Messages Tab:</strong> People can message your page directly from your website. People need to be logged in to use this feature.</li>
        </ul>';
        
        echo $field . $info;
    }
    
    public function mtfb_page_header_setting() {
        $smallHeader = 'false';
        
        if( isset( $this->page_options['fb_page_small_header'] ) )
            $smallHeader = $this->page_options['fb_page_small_header'];
        
        $yesChecked = ( $smallHeader=='true' ) ? 'checked' : '';
        $noChecked = ( $smallHeader=='false' ) ? 'checked' : '';
        
        $fields = "<label><input name='mtfb_page_fbpg_plugin_options[fb_page_small_header]' type='radio' value='true' ".$yesChecked ." /> Yes </label> <label><input name='mtfb_page_fbpg_plugin_options[fb_page_small_header]' type='radio' value='false' ".$noChecked ." /> No</label>";
        
        $info = '<p>By default, we will use full header. If you wish to use small header instead, then click on Yes.</p>';
        
        echo $fields . $info;
    }
    
    public function mtfb_page_cover_setting() {
        $cover = 'false';
        
        if( isset( $this->page_options['fb_page_cover'] ) )
            $cover = $this->page_options['fb_page_cover'];
        
        $yesChecked = ( $cover=='true' ) ? 'checked' : '';
        $noChecked = ( $cover=='false' ) ? 'checked' : '';
        
        $fields = "<label><input name='mtfb_page_fbpg_plugin_options[fb_page_cover]' type='radio' value='true' ".$yesChecked ." /> Yes </label> <label><input name='mtfb_page_fbpg_plugin_options[fb_page_cover]' type='radio' value='false' ".$noChecked ." /> No</label>";
        
        $info = '<p>By default, we will use cover photo of FB page. If you wish to hide it, then click on Yes.</p>';
        
        echo $fields . $info;
    }
    
    public function mtfb_page_width_setting() {
        $width = '';
        if(isset($this->page_options['fb_page_width']))
            $width = $this->page_options['fb_page_width'];
        
        $field = "<input name='mtfb_page_fbpg_plugin_options[fb_page_width]' type='text' class='regular-text' value='".$width."'>";
        
        $info = '<p>The pixel width of the embed (Min. 180 to Max. 500)</p>';
        
        echo $field . $info;
    }
    
    public function mtfb_page_height_setting() {
        $height = '';
        if(isset($this->page_options['fb_page_height']))
            $height = $this->page_options['fb_page_height'];
        
        $field = "<input name='mtfb_page_fbpg_plugin_options[fb_page_height]' type='text' class='regular-text' value='".$height."'>";
        
        $info = '<p>The pixel height of the embed (Min. 70)</p>';
        
        echo $field . $info;
    }
    
    public function mtfb_page_frnds_face_setting() {
        $face = 'true';
        
        if( isset( $this->page_options['friends_face'] ) )
            $face = $this->page_options['friends_face'];
        
        $yesChecked = ( $face=='true' ) ? 'checked' : '';
        $noChecked = ( $face=='false' ) ? 'checked' : '';
        
        $fields = "<label><input name='mtfb_page_fbpg_plugin_options[friends_face]' type='radio' value='true' ".$yesChecked ." /> Yes </label> <label><input name='mtfb_page_fbpg_plugin_options[friends_face]' type='radio' value='false' ".$noChecked ." /> No</label>";
        
        $info = '<p>By default, we will show friend\'s faces who likes the FB page. If you wish to hide it, then click on No.</p>';
        
        echo $fields . $info;
    }
    
    public function mtfb_page_adaptive_width_setting() {
        $adapt = 'true';
        
        if( isset( $this->page_options['adaptive_width'] ) )
            $adapt = $this->page_options['adaptive_width'];
        
        $yesChecked = ( $adapt=='true' ) ? 'checked' : '';
        $noChecked = ( $adapt=='false' ) ? 'checked' : '';
        
        $fields = "<label><input name='mtfb_page_fbpg_plugin_options[adaptive_width]' type='radio' value='true' ".$yesChecked ." /> Yes </label> <label><input name='mtfb_page_fbpg_plugin_options[adaptive_width]' type='radio' value='false' ".$noChecked ." /> No</label>";
        
        $info = '<p>By default, it is yes. If you wish to change it, then click on No.</p>';
        
        echo $fields . $info;
    }
    
    // Functions for save button settings
    public function mtfb_page_settings_section_cb() {
        
    }
    
    public function mtfb_page_app_id_setting() {
        $app_id = '';
        if(isset($this->settings_options['fb_app_id']))
            $app_id = $this->settings_options['fb_app_id'];
        
        $field = "<input name='mtfb_page_settings_options[fb_app_id]' type='text' class='regular-text' value='".$app_id."'>";
        
        $info = '<p>Type your Facebook App ID.</p>
        <p><a href="https://developers.facebook.com/apps/" target="_blank">Click Here</a> to get the app ID of existing facebook app or create a new app.</p>
        ';
        
        echo $field . $info;
    }
}
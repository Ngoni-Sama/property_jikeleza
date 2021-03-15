<?php
update_option( 'is_theme_activated', 'is_active' );
require_once  get_theme_file_path('/libs/css_js_include.php');
require_once  get_theme_file_path('/libs/plugins.php');
require_once  get_theme_file_path('/libs/help_functions.php');
require_once  get_theme_file_path('/libs/help_functions_cards.php');
require_once  get_theme_file_path('/libs/pin_management.php');
require_once  get_theme_file_path('/libs/ajax_functions.php');
require_once  get_theme_file_path('/libs/ajax_upload.php');
require_once  get_theme_file_path('/libs/3rdparty.php');
require_once  get_theme_file_path('/libs/theme-setup.php');
require_once  get_theme_file_path('/libs/general-settings.php');
require_once  get_theme_file_path('/libs/listing_functions.php'); 
require_once  get_theme_file_path('/libs/agent_functions.php'); 
require_once  get_theme_file_path('/libs/theme-slider.php');
require_once  get_theme_file_path('/libs/events.php');
require_once  get_theme_file_path('/libs/searchfunctions.php');
require_once  get_theme_file_path('/libs/searchfunctions2.php');
require_once  get_theme_file_path('/libs/stats.php');
require_once  get_theme_file_path('/libs/megamenu.php');
require_once  get_theme_file_path('/libs/design_functions.php');
require_once  get_theme_file_path('/libs/update.php');
require_once  get_theme_file_path('/word_remove.php');
require_once  get_theme_file_path('/world_manage.php');
require_once  get_theme_file_path('/libs/dashboard_widgets.php');
require_once  get_theme_file_path('libs/theme-cache.php'); 
require_once  get_theme_file_path('/libs/multiple_sidebars.php');
 
 
define('ULTIMATE_NO_EDIT_PAGE_NOTICE', true);
define('ULTIMATE_NO_PLUGIN_PAGE_NOTICE', true);
# Disable check updates - 
define('BSF_6892199_CHECK_UPDATES',false);
# Disable license registration nag -
define('BSF_6892199_NAG', false);

 

function wpestate_admin_notice() {
    global $pagenow;
    global $typenow;
    

    wpestate_show_license_form();
    if($pagenow=='themes.php'){
        return;
    }
    
    if (!empty($_GET['post'])) {
        $allowed_html   =   array();
        $post = get_post( esc_html($_GET['post']) );
        $typenow = $post->post_type;
    }

    $wpestate_notices =  get_option('wp_estate_notices');
 
     
    
    if( !is_array($wpestate_notices) || 
        !isset($wpestate_notices['wp_estate_cache_notice']) ||
        ( isset($wpestate_notices['wp_estate_cache_notice']) && $wpestate_notices['wp_estate_cache_notice']!='yes')  ){
        
        print '<div  id ="setting-error-wprentals-cache"  data-notice-type="wp_estate_cache_notice"  data-dismissible="disable-done-notice-forever" class="wpestate_notices updated settings-error notice is-dismissible">
            <p>'.esc_html__( 'For better speed results, the theme offers a built-in caching system for properties and categories. Check this article how to enable - disable theme cache: ','wpresidence').'<a href="http://help.wpresidence.net/article/enable-or-disable-wp-residence-cache/">'.esc_html__('help article','wpresidence').'</a></p>
        </div>';
    }
    
 
    if( esc_html( wpresidence_get_option('wp_estate_api_key') =='' ) ){
         
        if( !is_array($wpestate_notices) || 
            !isset($wpestate_notices['wp_estate_api_key']) ||
            ( isset($wpestate_notices['wp_estate_api_key']) && $wpestate_notices['wp_estate_api_key']!='yes')  ){

            print '<div data-notice-type="wp_estate_api_key"  class="wpestate_notices updated settings-error error notice is-dismissible">
                <p>'.esc_html__('The Google Maps JavaScript API v3 REQUIRES an API key to function correctly. Get an APIs Console key and post the code in Theme Options. You can get it from','wpresidence')
                    .' <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" target="_blank">'.esc_html__('here','wpresidence').'</a></p>
            </div>';   
        }
    }
    
    
    if ( WP_MEMORY_LIMIT < 96 ) { 
          if( !is_array($wpestate_notices) || 
            !isset($wpestate_notices['wp_estate_memory_notice']) ||
            ( isset($wpestate_notices['wp_estate_memory_notice']) && $wpestate_notices['wp_estate_memory_notice']!='yes')  ){
    
            print '<div data-notice-type="wp_estate_memory_notice"  class="wpestate_notices updated settings-error error notice is-dismissible">
                <p>'.esc_html__( 'WordPress Memory Limit is set to ', 'wpresidence' ).' '.WP_MEMORY_LIMIT.' '.esc_html__( 'Recommended memory limit should be at least 96MB. Please refer to : ','wpresidence').'<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">'.esc_html__('Increasing memory allocated to PHP','wpresidence').'</a></p>
            </div>';
        }
    }
    

    
    if (!defined('PHP_VERSION_ID')) {
        $version = explode('.', PHP_VERSION);
        define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    }

    if(PHP_VERSION_ID<50600){
        if( !is_array($wpestate_notices) || 
            !isset($wpestate_notices['wp_estate_php_version']) ||
            ( isset($wpestate_notices['wp_estate_php_version']) && $wpestate_notices['wp_estate_php_version']!='yes')  ){
            
        
            $version = explode('.', PHP_VERSION);
            print '<div data-notice-type="wp_estate_php_version"  class="wpestate_notices updated settings-error error notice is-dismissible">
                <p>'.esc_html__( 'Your PHP version is ', 'wpresidence' ).' '.$version[0].'.'.$version[1].'.'.$version[2].'. We recommend upgrading the PHP version to at least 5.6.1. The upgrade should be done on your server by your hosting company. </p>
            </div>';
        }
    }
    

    if( !extension_loaded('gd') && !function_exists('gd_info')){
        if( !is_array($wpestate_notices) || 
            !isset($wpestate_notices['wp_estate_gd_info']) ||
            ( isset($wpestate_notices['wp_estate_gd_info']) && $wpestate_notices['wp_estate_gd_info']!='yes')  ){
            
            $version = explode('.', PHP_VERSION);
            print '<div data-notice-type="wp_estate_gd_info"  class="wpestate_notices updated settings-error error notice is-dismissible">
                <p>'.esc_html__( 'PHP GD library is NOT installed on your web server and because of that the theme will not be able to work with images. Please contact your hosting company in order to activate this library.','wpresidence').' </p>
            </div>';
        }
    }
    
 
    if ( !extension_loaded('mbstring')) { 
        if( !is_array($wpestate_notices) || 
            !isset($wpestate_notices['wp_estate_mb_string']) ||
            ( isset($wpestate_notices['wp_estate_mb_string']) && $wpestate_notices['wp_estate_mb_string']!='yes')  ){
            
                print '<div data-notice-type="wp_estate_mb_string"  class="wpestate_notices updated settings-error error notice is-dismissible">
                    <p>'.esc_html__( 'MbString extension not detected. Please contact your hosting provider in order to enable it.', 'wpresidence' ).'</p>
                </div>';
        }
    }
    
    
    if (is_admin() &&   $pagenow=='post.php' && $typenow=='page' && basename( get_page_template($post))=='property_list_half.php' ){
        $header_type    =   get_post_meta ( $post->ID, 'header_type', true);
      
        if ( $header_type != 5){
            if( !is_array($wpestate_notices) || 
            !isset($wpestate_notices['wp_estate_header_half']) ||
            ( isset($wpestate_notices['wp_estate_header_half']) && $wpestate_notices['wp_estate_header_half']!='yes')  ){
               
                print '<div data-notice-type="wp_estate_header_half"  class="wpestate_notices updated settings-error error notice is-dismissible">
                <p>'.esc_html__( 'Half Map Template - make sure your page has the "media header type" set as google map ', 'wpresidence' ).'</p>
                </div>';
            }
        }
       
    }
    
    
    
    if (is_admin() &&   $pagenow=='edit-tags.php'  && $typenow=='estate_property') {
        
        if( !is_array($wpestate_notices) || 
            !isset($wpestate_notices['wp_estate_prop_slugs']) ||
            ( isset($wpestate_notices['wp_estate_prop_slugs']) && $wpestate_notices['wp_estate_prop_slugs']!='yes')  ){
    
            print '<div data-notice-type="wp_estate_prop_slugs"  class="wpestate_notices updated settings-error error notice is-dismissible">
                <p>'.esc_html__( 'Please do not manually change the slugs when adding new terms. If you need to edit a term name copy the new name in the slug field also.', 'wpresidence' ).'</p>
            </div>';
        }
    }
    
    $ajax_nonce = wp_create_nonce( "wpestate_notice_nonce" );
    print '<input type="hidden" id="wpestate_notice_nonce" value="'.esc_html($ajax_nonce).'"/>';

}
 

add_action( 'admin_notices', 'wpestate_admin_notice' );
add_action('after_setup_theme', 'wp_estate_init');
if( !function_exists('wp_estate_init') ):
    function wp_estate_init() {
    
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 1200;
        }
        
        load_theme_textdomain('wpresidence', get_template_directory() . '/languages');
        set_post_thumbnail_size(940, 198, true);
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails');
        add_theme_support( 'automatic-feed-links'); 
        add_theme_support('custom-background');
        add_theme_support( 'align-wide' );
        add_theme_support(
            'gutenberg',
            array( 'wide-images' => true )
        );
        
        wp_oembed_add_provider('#https?://twitter.com/\#!/[a-z0-9_]{1,20}/status/\d+#i', 'https://api.twitter.com/1/statuses/oembed.json', true);
        wpestate_image_size();
        add_filter('excerpt_length', 'wp_estate_excerpt_length');
        add_filter('excerpt_more', 'wpestate_new_excerpt_more');
        add_action('tgmpa_register', 'wpestate_required_plugins');
        add_action('wp_enqueue_scripts', 'wpestate_scripts'); 
        add_action('admin_enqueue_scripts', 'wpestate_admin');
        add_action('login_enqueue_scripts', 'wpestate_login_logo_function' );
        update_option( 'image_default_link_type', 'file' );
        wpestate_theme_update();
    }
endif; // end   wp_estate_init  



if( !function_exists('wpestate_theme_update') ):
    function wpestate_theme_update() {
        if ( NULL === get_option( 'wp_estate_submission_page_fields', NULL ) ) {
            $all_submission_fields  =   wpestate_return_all_fields();
            $default_val=array();
            foreach ($all_submission_fields as $key=>$value){
                $default_val[]=$key;    
            }

            add_option('wp_estate_submission_page_fields',$default_val);
        }
    }
    
    
endif;


///////////////////////////////////////////////////////////////////////////////////////////
/////// If admin create the menu
///////////////////////////////////////////////////////////////////////////////////////////
if (is_admin()) {
    add_action('admin_menu', 'wpestate_manage_admin_menu');
}

if( !function_exists('wpestate_manage_admin_menu') ):
    
    function wpestate_manage_admin_menu() {
        $theme = wp_get_theme(); 
        add_submenu_page( $theme->get( 'Name' ),'Import Demo', 'Import Demo', 'administrator', 'themes.php?page=pt-one-click-demo-import', '' );
        add_submenu_page( 'libs/theme-admin.php','Import Demo', 'Import Demo', 'administrator', 'themes.php?page=pt-one-click-demo-import', '' );
        add_submenu_page( 'libs/theme-admin.php','Clear Theme Cache', 'Clear Theme Cache', 'administrator', 'libs/theme-cache.php' , 'wpestate_clear_cache_theme' );
     

        require_once get_theme_file_path('libs/property-admin.php');
        require_once get_theme_file_path('libs/theme-admin.php'); 
       
    }
    
endif; // end   wpestate_manage_admin_menu 





///////////////////////////////////////////////////////////////////////////////////////////
/////// generate custom css
///////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head', 'wpestate_generate_options_css');

if( !function_exists('wpestate_generate_options_css') ):

function wpestate_generate_options_css() {
    $custom_css       =   '';
    $css_cache =   wpestate_request_transient_cache( 'wpestate_custom_css'  );
    if( $css_cache === false ) {   

        $general_font   = esc_html( get_option('wp_estate_general_font', '') );
        $custom_css     = stripslashes  ( wpresidence_get_option('wp_estate_custom_css')  );
      

        ob_start();
            print "<style type='text/css'>" ;
            require_once get_theme_file_path('libs/customcss.php');    
            print wp_specialchars_decode ($custom_css);
            wpestate_custom_fonts_elements();
            print  (  wpestate_general_design_elements() );
            print "</style>"; 
            $css_cache   =  ob_get_contents();
            $css_cache   =  wpestate_css_compress($css_cache); 
        ob_end_clean();
        wpestate_set_transient_cache('wpestate_custom_css',$css_cache,60*60*24);
    }
    print trim($css_cache); 
}
endif; // end   generate_options_css 


function wpestate_css_compress($buffer) {
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
}

function wpestate_html_compress($buffer){
    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
    );

    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}
  
///////////////////////////////////////////////////////////////////////////////////////////
///////  Display navigation to next/previous pages when applicable
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wp_estate_content_nav')) :
 
    function wp_estate_content_nav($html_id) {
        global $wp_query;

        if ($wp_query->max_num_pages > 1) :
            ?>
            <nav id="<?php print esc_attr($html_id); ?>">
                <h3 class="assistive-text"><?php esc_html_e('Post navigation', 'wpresidence'); ?></h3>
                <div class="nav-previous"><?php next_posts_link(esc_html__('<span class="meta-nav">&larr;</span> Older posts', 'wpresidence')); ?></div>
                <div class="nav-next"><?php previous_posts_link(esc_html__('Newer posts <span class="meta-nav">&rarr;</span>', 'wpresidence')); ?></div>
            </nav><!-- #nav-above -->
        <?php
        endif;
    }

endif; // wpestate_content_nav





///////////////////////////////////////////////////////////////////////////////////////////
///////  Comments
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_comment')) :
    function wpestate_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p><?php esc_html_e('Pingback:', 'wpresidence'); ?> <?php comment_author_link(); ?><?php edit_comment_link(esc_html__('Edit', 'wpresidence'), '<span class="edit-link">', '</span>'); ?></p>
                <?php
                break;
                default :
                ?>
                    
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                   
                <?php
                $avatar = wpestate_get_avatar_url(get_avatar($comment, 55));
                print '<div class="blog_author_image singlepage" style="background-image: url('.esc_url($avatar).');">';
                comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'wpresidence'), 'depth' => $depth, 'max_depth' => $args['max_depth'])));
                print'</div>';   
                ?>
                
                <div id="comment-<?php comment_ID(); ?>" class="comment">     
                    <?php edit_comment_link(esc_html__('Edit', 'wpresidence'), '<span class="edit-link">', '</span>'); ?>
                    <div class="comment-meta">
                        <div class="comment-author vcard">
                            <?php
                            print '<div class="comment_name">' . get_comment_author_link().'</div>';                                   
                            print '<span class="comment_date">'.esc_html__(' on ','wpresidence').' '. get_comment_date() . '</span>';
                            ?>
                        </div><!-- .comment-author .vcard -->

                    <?php if ($comment->comment_approved == '0') : ?>
                            <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'wpresidence'); ?></em>
                            <br />
                    <?php endif; ?>

                    </div>

                    <div class="comment-content"><?php comment_text(); ?></div>
                </div><!-- #comment-## -->
                <?php
                break;
        endswitch;
    }


endif; // ends check for  wpestate_comment 




if( !current_user_can('activate_plugins') ) {
    function wpestate_admin_bar_render() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('edit-profile', 'user-actions');
    }
    
    add_action( 'wp_before_admin_bar_render', 'wpestate_admin_bar_render' );

    add_action( 'admin_init', 'wpestate_stop_access_profile' );
    if( !function_exists('wpestate_stop_access_profile') ):
    function wpestate_stop_access_profile() {
        global $pagenow;

        if( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE === true ) {
            wp_die( esc_html__('Please edit your profile page from site interface.','wpresidence') );
        }
       
        if($pagenow=='user-edit.php'){
            wp_die( esc_html__('Please edit your profile page from site interface.','wpresidence') );
        } 
    }
    endif; // end   wpestate_stop_access_profile 

}// end user can activate_plugins



///////////////////////////////////////////////////////////////////////////////////////////
// prevent changing the author id when admin hit publish
///////////////////////////////////////////////////////////////////////////////////////////

add_action( 'transition_post_status', 'wpestate_correct_post_data',10,3 );

if( !function_exists('wpestate_correct_post_data') ):
    
function wpestate_correct_post_data( $strNewStatus,$strOldStatus,$post) {
    /* Only pay attention to posts (i.e. ignore links, attachments, etc. ) */
    if( $post->post_type !== 'estate_property' )
        return;

    if( $strOldStatus === 'new' ) {
        update_post_meta( $post->ID, 'original_author', $post->post_author );
    }

    
    /* If this post is being published, try to restore the original author */
      if( $strNewStatus === 'publish' ) {

            $originalAuthor_id =$post->post_author;
            $user = get_user_by('id',$originalAuthor_id); 
          
            if( isset($user->user_email) ){
                $user_email=$user->user_email;
                if( $user->roles[0]=='subscriber'){
                    $arguments=array(
                        'post_id'           =>  $post->ID,
                        'property_url'      =>   esc_url ( get_permalink($post->ID) ),
                        'property_title'    =>  get_the_title($post->ID)
                    );
                    wpestate_select_email_type($user_email,'approved_listing',$arguments);    
                }
            }
        
    }
}
endif; // end   wpestate_correct_post_data 



///////////////////////////////////////////////////////////////////////////////////////////
// get attachment info
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_get_attachment') ):
    function wp_get_attachment( $attachment_id ) {

            $attachment = get_post( $attachment_id );
        
     
            if($attachment){
                return array(
                        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                        'caption' => $attachment->post_excerpt,
                        'description' => $attachment->post_content,
                        'href' =>  esc_url ( get_permalink( $attachment->ID ) ),
                        'src' => $attachment->guid,
                        'title' => $attachment->post_title
                );
            }else{
                return array(
                        'alt' => '',
                        'caption' => '',
                        'description' => '',
                        'href' => '',
                        'src' => '',
                        'title' => ''
                );
            }
    }
endif;


add_action('get_header', 'wpestate_my_filter_head');

if( !function_exists('wpestate_my_filter_head') ):
    function wpestate_my_filter_head() {
      remove_action('wp_head', '_admin_bar_bump_cb');
    }
endif;



///////////////////////////////////////////////////////////////////////////////////////////
// forgot pass action
///////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head','wpestate_hook_javascript');
if( !function_exists('wpestate_hook_javascript') ):
function wpestate_hook_javascript(){
    global $wpdb;
    $allowed_html   =   array();
    if(isset($_GET['key']) && isset($_GET['action'])&& $_GET['action'] == "reset_pwd") {
        $reset_key  = esc_html( wp_kses($_GET['key'],$allowed_html) );
        $user_login = esc_html( wp_kses($_GET['login'],$allowed_html) );
        $user_data  = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users 
                WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));

            
        if(!empty($user_data)){
                $user_login = $user_data->user_login;
                $user_email = $user_data->user_email;

                if(!empty($reset_key) && !empty($user_data)) {
                        $new_password = wp_generate_password(7, false); 
                        wp_set_password( $new_password, $user_data->ID );
                        //mailing the reset details to the user
                        $message = esc_html__('Your new password for the account at:','wpresidence') . "\r\n\r\n";
                        $message .= get_bloginfo('name') . "\r\n\r\n";
                        $message .= sprintf(esc_html__('Username: %s','wpresidence'), $user_login) . "\r\n\r\n";
                        $message .= sprintf(esc_html__('Password: %s','wpresidence'), $new_password) . "\r\n\r\n";
                        $message .= esc_html__('You can now login with your new password at: ','wpresidence') . get_option('siteurl')."/" . "\r\n\r\n";

                        $headers = 'From: noreply  <noreply@'.wpestate_replace_server_global(site_url()).'>' . "\r\n".
                        'Reply-To: noreply@'.wpestate_replace_server_global(site_url()). "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                        $arguments=array(
                            'user_pass'        =>  $new_password,
                        );
                        wpestate_select_email_type($user_email,'password_reseted',$arguments);

                        $mess= '<div class="login-alert">'.esc_html__('A new password was sent via email!','wpresidence').'</div>';
                         
                }
                else {
                    exit('Not a Valid Key.');
                }
        }// end if empty
  PRINT  $mes='<div class="login_alert_full">'.esc_html__('We have just sent you a new password. Please check your email!','wpresidence').'</div>';   
  
    } 

}
endif;



add_action('wpcf7_before_send_mail', 'wpcf7_update_email_body');
if( !function_exists('wpcf7_update_email_body') ):
function wpcf7_update_email_body($contact_form) {
    global $post;
   
    $submission =   WPCF7_Submission::get_instance();
    $url        =   $submission->get_meta( 'url' );
    $postid     =   url_to_postid( trim($url) );
    $post_type  =   get_post_type($postid);
 
    if( isset($postid) && $post_type == 'estate_property' ){

        $mail = $contact_form->prop('mail');
        $mail['recipient']  = wpestate_return_agent_email_listing($postid,$post_type);
        $mail['body'] .= esc_html__('Message sent from page: ','wpresidence'). esc_url ( get_permalink($postid) );
        $contact_form->set_properties(array('mail' => $mail));
    }

    if(isset($postid) && ( $post_type == 'estate_agent'||  $post_type == 'estate_agency' || $post_type == 'estate_developer' )){
        $mail = $contact_form->prop('mail');

        if( $post_type == 'estate_agency' ){
            $mail['recipient']  = esc_html( get_post_meta($postid, 'agency_email', true) );
        }else if(  $post_type == 'estate_developer'  ){
            $mail['recipient']  = esc_html( get_post_meta($postid, 'developer_email', true) );
        }else{
            $mail['recipient']  = esc_html( get_post_meta($postid, 'agent_email', true) );
        }
       
        $mail['body'] .= esc_html__('Message sent from page: ','wpresidence'). esc_url ( get_permalink($postid) );
        $contact_form->set_properties(array('mail' => $mail));
    }

}
endif;


if(!function_exists('wpestate_return_agent_email_listing')){
    function wpestate_return_agent_email_listing($postid,$post_type){

        $agent_id   = intval( get_post_meta($postid, 'property_agent', true) );
        $role_type  = get_post_type($agent_id);


        if( $role_type == 'estate_agency' ){
            $agent_email  = esc_html( get_post_meta($agent_id, 'agency_email', true) );
        }else if(  $role_type == 'estate_developer'  ){
            $agent_email  = esc_html( get_post_meta($agent_id, 'developer_email', true) );
        }else{
            if ($agent_id!=0){   
                $agent_email = esc_html( get_post_meta($agent_id, 'agent_email', true) );
            }else{
                $author_id           =  wpsestate_get_author($postid);
                $agent_email         =  get_the_author_meta( 'user_email',$author_id  );
            }
        }

        return $agent_email;
    }
}





if ( !function_exists('wpestate_get_pin_file_path')):
    
    function wpestate_get_pin_file_path(){
        if (function_exists('icl_translate') ) {
            $path=get_template_directory().'/pins-'.apply_filters( 'wpml_current_language', 'en' ).'.txt';
        }else{
            $path=get_template_directory().'/pins.txt';
        }
     
        return $path;
    }

endif;




if( !function_exists('wpestate_show_search_field_classic_form') ):
    function  wpestate_show_search_field_classic_form($postion,$action_select_list,$categ_select_list ,$select_city_list,$select_area_list){
   
        $allowed_html=array();
        if ($postion=='main'){
            $caret_class    = ' caret_filter ';
            $main_class     = ' filter_menu_trigger ';
            $appendix       = '';
            $price_low      = 'price_low';
            $price_max      = 'price_max';
            $ammount        = 'amount';
            $slider         = 'slider_price';
            $drop_class     = '';
             
        }else if($postion=='sidebar'){
            $caret_class    = ' caret_sidebar ';
            $main_class     = ' sidebar_filter_menu ';
            $appendix       = 'sidebar-';
            $price_low      = 'price_low_widget';
            $price_max      = 'price_max_widget';
            $ammount        = 'amount_wd';
            $slider         = 'slider_price_widget';
            $drop_class     = '';
            
        }else if($postion=='shortcode'){
            $caret_class    = ' caret_filter ';
            $main_class     = ' filter_menu_trigger ';
            $appendix       = '';
            $price_low      = 'price_low_sh';
            $price_max      = 'price_max_sh';
            $ammount        = 'amount_sh';
            $slider         = 'slider_price_sh';
            $drop_class     = 'listing_filter_select ';
            
        } else if($postion=='mobile'){
            $caret_class    = ' caret_filter ';
            $main_class     = ' filter_menu_trigger ';
            $appendix       = '';
            $price_low      = 'price_low_mobile';
            $price_max      = 'price_max_mobile';
            $ammount        = 'amount_mobile';
            $slider         = 'slider_price_mobile';
            $drop_class     = '';
        }
    
        $return_string='';

        if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
            $full_name = get_term_by('slug', esc_html( wp_kses( $_GET['filter_search_action'][0],$allowed_html) ),'property_action_category');
            $adv_actions_value=$adv_actions_value1= $full_name->name;
            $adv_actions_value1 = mb_strtolower ( str_replace(' ', '-', $adv_actions_value1) );
        }else{
            $adv_actions_value=esc_html__('Types','wpresidence');
            $adv_actions_value1='all';
        }

        $return_string.='
        <div class="col-md-3">    
            <div class="dropdown form-control '.esc_attr($drop_class).' " >
                <div data-toggle="dropdown" id="'.esc_attr($appendix).'adv_actions" class="'.esc_attr($main_class).'" data-value="'.strtolower ( rawurlencode ( $adv_actions_value1) ).'"> 
                    '.esc_html($adv_actions_value).' 
                <span class="caret '.esc_attr($caret_class).'"></span> </div>           
                <input type="hidden" name="filter_search_action[]" value="'; 
                if(isset($_GET['filter_search_action'][0])){
                     $return_string.= strtolower( esc_attr($_GET['filter_search_action'][0]) );

                };  $return_string.='">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="'.esc_attr($appendix).'adv_actions">
                    '.$action_select_list.'
                </ul>        
            </div>
        </div>';
                                              
            
        if( isset($_GET['filter_search_type'][0]) && $_GET['filter_search_type'][0]!=''&& $_GET['filter_search_type'][0]!='all'  ){
            $full_name = get_term_by('slug', esc_html( wp_kses( $_GET['filter_search_type'][0],$allowed_html) ),'property_category');
            $adv_categ_value= $adv_categ_value1=$full_name->name;
            $adv_categ_value1 = mb_strtolower ( str_replace(' ', '-', $adv_categ_value1));
        }else{
            $adv_categ_value    = esc_html__('Types','wpresidence');
            $adv_categ_value1   ='all';
        }
        
        $return_string.='
        <div class="col-md-3">
            <div class="dropdown form-control '.esc_attr($drop_class).'" >
                <div data-toggle="dropdown" id="'.esc_attr($appendix).'adv_categ" class="'.esc_attr($main_class).'" data-value="'.strtolower ( rawurlencode( $adv_categ_value1)).'"> 
                    '.$adv_categ_value.'               
                <span class="caret '.esc_attr($caret_class).'"></span> </div>           
                <input type="hidden" name="filter_search_type[]" value="';
                if(isset($_GET['filter_search_type'][0])){
                    $return_string.= strtolower ( esc_attr( $_GET['filter_search_type'][0] ) );
                }
                $return_string.='">
                <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="'.esc_attr($appendix).'adv_categ">
                    '.$categ_select_list.'
                </ul>
            </div>    
        </div>';

        if(isset($_GET['advanced_city']) && $_GET['advanced_city']!='' && $_GET['advanced_city']!='all'){
            $full_name = get_term_by('slug',esc_html( wp_kses($_GET['advanced_city'] ,$allowed_html)), 'property_city');
            $advanced_city_value    = $advanced_city_value1 =   $full_name->name;
            $advanced_city_value1   = mb_strtolower(str_replace(' ', '-', $advanced_city_value1));
        }else{
            $advanced_city_value=esc_html__('Cities','wpresidence');
            $advanced_city_value1='all';
        }

        $return_string.='
        <div class="col-md-3">
            <div class="dropdown form-control '.esc_attr($drop_class).'" >
                <div data-toggle="dropdown" id="'.esc_attr($appendix).'advanced_city" class="'.esc_attr($main_class).'" data-value="'. strtolower (rawurlencode ($advanced_city_value1)).'"> 
                    '.$advanced_city_value.' 
                    <span class="caret '.esc_attr($caret_class).'"></span> </div>           
                <input type="hidden" name="advanced_city" value="';
                if(isset($_GET['advanced_city'])){
                    $return_string.=strtolower ( esc_attr($_GET['advanced_city'] ) );

                }
                $return_string.='">
                <ul  class="dropdown-menu filter_menu" role="menu"  id="adv-search-city" aria-labelledby="'.esc_attr($appendix).'advanced_city">
                    '.$select_city_list.'
                </ul>
            </div>    
        </div>';  

            
        if(isset($_GET['advanced_area']) && $_GET['advanced_area']!=''&& $_GET['advanced_area']!='all'){
            $full_name = get_term_by('slug', esc_html(wp_kses($_GET['advanced_area'],$allowed_html)),'property_area');
            $advanced_area_value=$advanced_area_value1= $full_name->name;
            $advanced_area_value1 = mb_strtolower (str_replace(' ', '-', $advanced_area_value1));
        }else{
            $advanced_area_value=esc_html__('Areas','wpresidence');
            $advanced_area_value1='all';
        }
        
            
        $return_string.='
        <div class="col-md-3">
            <div class="dropdown form-control '.esc_attr($drop_class).'" >
                <div data-toggle="dropdown" id="'.esc_attr($appendix).'advanced_area" class="'.esc_attr($main_class).'" data-value="'.strtolower( rawurlencode( $advanced_area_value1)).'">
                    '.$advanced_area_value.'
                    <span class="caret '.esc_attr($caret_class).'"></span> </div>           
                    <input type="hidden" name="advanced_area" value="';
                    if(isset($_GET['advanced_area'])){
                        $return_string.=strtolower( esc_attr($_GET['advanced_area'] ) );
                    }
                    $return_string.='">
                <ul class="dropdown-menu filter_menu" role="menu" id="adv-search-area"  aria-labelledby="'.esc_attr($appendix).'advanced_area">
                    '.$select_area_list.'
                </ul>
            </div>
        </div>';

        $return_string.='
        <div class="col-md-3">
        <input type="text" id="'.esc_attr($appendix).'adv_rooms" class="form-control" name="advanced_rooms"  placeholder="'.esc_html__('Type Bedrooms No.','wpresidence').'" 
               value="';
        if ( isset ( $_GET['advanced_rooms'] ) ) {
            $return_string.=   esc_attr( $_GET['advanced_rooms'] );
            
        }
        $return_string.='">
        </div>
        <div class="col-md-3">
        <input type="text" id="'.esc_attr($appendix).'adv_bath"  class="form-control" name="advanced_bath"   placeholder="'.esc_html__('Type Bathrooms No.','wpresidence').'"   
               value="';
        if (isset($_GET['advanced_bath'])) {
            $return_string.=  esc_attr( $_GET['advanced_bath'] );
            
        }
        $return_string.='"></div>';
        
        
        $show_slider_price      =   wpresidence_get_option('wp_estate_show_slider_price','');
        $where_currency         =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        $wpestate_currency      =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
         
        
        if ($show_slider_price==='yes'){
                $min_price_slider= ( floatval(wpresidence_get_option('wp_estate_show_slider_min_price','')) );
                $max_price_slider= ( floatval(wpresidence_get_option('wp_estate_show_slider_max_price','')) );
                
                if(isset($_GET['price_low'])){
                    $min_price_slider=  floatval($_GET['price_low']) ;
                }
                
                if(isset($_GET['price_low'])){
                    $max_price_slider=  floatval($_GET['price_max']) ;
                }

                $price_slider_label = wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$wpestate_currency,$where_currency);
                             
                $return_string.='<div class="col-md-6">
                <div class="adv_search_slider">
                    <p>
                        <label for="'.esc_attr($ammount).'">'.esc_html__('Price range:','wpresidence').'</label>
                        <span id="'.esc_attr($ammount).'" class="wpresidence_slider_price" >'.$price_slider_label.'</span>
                    </p>
                    <div id="'.$slider.'"></div>'; //escaped above
                    $custom_fields = wpresidence_get_option( 'wp_estate_multi_curr', '');
                    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                        $i=intval($_COOKIE['my_custom_curr_pos']);

                        if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
                            $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                            $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
                        }
                    }
                $return_string.='
                    <input type="hidden" id="'.esc_attr($price_low).'"  name="price_low"  value="'.floatval($min_price_slider).'>" />
                    <input type="hidden" id="'.esc_attr($price_max).'"  name="price_max"  value="'.floatval($max_price_slider).'>" />
                </div></div>';
        
        }else{
        $return_string.='
            <div class="col-md-3">
                <input type="text" id="'.esc_attr($price_low).'" class="form-control advanced_select" name="price_low"  placeholder="'.esc_html__('Type Min. Price','wpresidence').'" value=""/>
            </div>
            
            <div class="col-md-3">
                <input type="text" id="'.esc_attr($price_max).'" class="form-control advanced_select" name="price_max"  placeholder="'.esc_html__('Type Max. Price','wpresidence').'" value=""/>
            </div>';
        } 


        return $return_string;
        
        
    }
endif;     


add_filter( 'redirect_canonical','wpestate_disable_redirect_canonical',10,2 ); 
function wpestate_disable_redirect_canonical( $redirect_url ,$requested_url){
    if ( is_page_template('property_list.php') || is_page_template('property_list_directory.php') || is_page_template('property_list_half.php') ){
       $redirect_url = false;
    }
    return $redirect_url;
}



if(!function_exists('convertAccentsAndSpecialToNormal')):
function convertAccentsAndSpecialToNormal($string) {
    $table = array(
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Ă'=>'A', 'Ā'=>'A', 'Ą'=>'A', 'Æ'=>'A', 'Ǽ'=>'A',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ă'=>'a', 'ā'=>'a', 'ą'=>'a', 'æ'=>'a', 'ǽ'=>'a',

        'Þ'=>'B', 'þ'=>'b', 'ß'=>'Ss',

        'Ç'=>'C', 'Č'=>'C', 'Ć'=>'C', 'Ĉ'=>'C', 'Ċ'=>'C',
        'ç'=>'c', 'č'=>'c', 'ć'=>'c', 'ĉ'=>'c', 'ċ'=>'c',

        'Đ'=>'Dj', 'Ď'=>'D', 'Đ'=>'D',
        'đ'=>'dj', 'ď'=>'d',

        'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ĕ'=>'E', 'Ē'=>'E', 'Ę'=>'E', 'Ė'=>'E',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'ę'=>'e', 'ė'=>'e',

        'Ĝ'=>'G', 'Ğ'=>'G', 'Ġ'=>'G', 'Ģ'=>'G',
        'ĝ'=>'g', 'ğ'=>'g', 'ġ'=>'g', 'ģ'=>'g',

        'Ĥ'=>'H', 'Ħ'=>'H',
        'ĥ'=>'h', 'ħ'=>'h',

        'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'İ'=>'I', 'Ĩ'=>'I', 'Ī'=>'I', 'Ĭ'=>'I', 'Į'=>'I',
        'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'į'=>'i', 'ĩ'=>'i', 'ī'=>'i', 'ĭ'=>'i', 'ı'=>'i',

        'Ĵ'=>'J',
        'ĵ'=>'j',

        'Ķ'=>'K',
        'ķ'=>'k', 'ĸ'=>'k',

        'Ĺ'=>'L', 'Ļ'=>'L', 'Ľ'=>'L', 'Ŀ'=>'L', 'Ł'=>'L',
        'ĺ'=>'l', 'ļ'=>'l', 'ľ'=>'l', 'ŀ'=>'l', 'ł'=>'l',

        'Ñ'=>'N', 'Ń'=>'N', 'Ň'=>'N', 'Ņ'=>'N', 'Ŋ'=>'N',
        'ñ'=>'n', 'ń'=>'n', 'ň'=>'n', 'ņ'=>'n', 'ŋ'=>'n', 'ŉ'=>'n',

        'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ō'=>'O', 'Ŏ'=>'O', 'Ő'=>'O', 'Œ'=>'O',
        'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ō'=>'o', 'ŏ'=>'o', 'ő'=>'o', 'œ'=>'o', 'ð'=>'o',

        'Ŕ'=>'R', 'Ř'=>'R',
        'ŕ'=>'r', 'ř'=>'r', 'ŗ'=>'r',

        'Š'=>'S', 'Ŝ'=>'S', 'Ś'=>'S', 'Ş'=>'S',
        'š'=>'s', 'ŝ'=>'s', 'ś'=>'s', 'ş'=>'s',

        'Ŧ'=>'T', 'Ţ'=>'T', 'Ť'=>'T',
        'ŧ'=>'t', 'ţ'=>'t', 'ť'=>'t',

        'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ũ'=>'U', 'Ū'=>'U', 'Ŭ'=>'U', 'Ů'=>'U', 'Ű'=>'U', 'Ų'=>'U',
        'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ũ'=>'u', 'ū'=>'u', 'ŭ'=>'u', 'ů'=>'u', 'ű'=>'u', 'ų'=>'u',

        'Ŵ'=>'W', 'Ẁ'=>'W', 'Ẃ'=>'W', 'Ẅ'=>'W',
        'ŵ'=>'w', 'ẁ'=>'w', 'ẃ'=>'w', 'ẅ'=>'w',

        'Ý'=>'Y', 'Ÿ'=>'Y', 'Ŷ'=>'Y',
        'ý'=>'y', 'ÿ'=>'y', 'ŷ'=>'y',

        'Ž'=>'Z', 'Ź'=>'Z', 'Ż'=>'Z', 'Ž'=>'Z',
        'ž'=>'z', 'ź'=>'z', 'ż'=>'z', 'ž'=>'z',

        '“'=>'"', '”'=>'"', '‘'=>"'", '’'=>"'", '•'=>'-', '…'=>'...', '—'=>'-', '–'=>'-', '¿'=>'?', '¡'=>'!', '°'=>' degrees ',
        '¼'=>' 1/4 ', '½'=>' 1/2 ', '¾'=>' 3/4 ', '⅓'=>' 1/3 ', '⅔'=>' 2/3 ', '⅛'=>' 1/8 ', '⅜'=>' 3/8 ', '⅝'=>' 5/8 ', '⅞'=>' 7/8 ',
        '÷'=>' divided by ', '×'=>' times ', '±'=>' plus-minus ', '√'=>' square root ', '∞'=>' infinity ',
        '≈'=>' almost equal to ', '≠'=>' not equal to ', '≡'=>' identical to ', '≤'=>' less than or equal to ', '≥'=>' greater than or equal to ',
        '←'=>' left ', '→'=>' right ', '↑'=>' up ', '↓'=>' down ', '↔'=>' left and right ', '↕'=>' up and down ',
        '℅'=>' care of ', '℮' => ' estimated ',
        'Ω'=>' ohm ',
        '♀'=>' female ', '♂'=>' male ',
        '©'=>' Copyright ', '®'=>' Registered ', '™' =>' Trademark ',
    );

    $string = strtr($string, $table);
    // Currency symbols: £¤¥€  - we dont bother with them for now
    $string = preg_replace("/[^\x9\xA\xD\x20-\x7F]/u", "", $string);

    return $string;
}
endif;



function estate_create_onetime_nonce($action = -1) {
    $time = time();
    $nonce = wp_create_nonce($time.$action);
    return $nonce . '-' . $time;
}



function estate_verify_onetime_nonce( $_nonce, $action = -1) {
    $parts  =   explode( '-', $_nonce );
    $nonce  =   $toadd_nonce    = $parts[0]; 
    $generated = $parts[1];

    $nonce_life = 60*60;
    $expires    = (int) $generated + $nonce_life;
    $time       = time();

    if( ! wp_verify_nonce( $nonce, $generated.$action ) || $time > $expires ){
        return false;
    }
    
    $used_nonces = get_option('_sh_used_nonces');

    if( isset( $used_nonces[$nonce] ) ) {
        return false;
    }

    if(is_array($used_nonces)){
        foreach ($used_nonces as $nonce=> $timestamp){
            if( $timestamp > $time ){
                break;
            }
            unset( $used_nonces[$nonce] );
        }
    }

    $used_nonces[$toadd_nonce] = $expires;
    asort( $used_nonces );
    update_option( '_sh_used_nonces',$used_nonces );
    return true;
}




function estate_verify_onetime_nonce_login( $_nonce, $action = -1) {
    $parts = explode( '-', $_nonce );
    $nonce =$toadd_nonce= $parts[0];
    $generated = $parts[1];

    $nonce_life = 60*60;
    $expires    = (int) $generated + $nonce_life;
    $expires2   = (int) $generated + 120;
    $time       = time();

    if( ! wp_verify_nonce( $nonce, $generated.$action ) || $time > $expires ){
        return false;
    }
    
    //Get used nonces
    $used_nonces = get_option('_sh_used_nonces');

    if( isset( $used_nonces[$nonce] ) ) {
        return false;
    }

    if(is_array($used_nonces)){
        foreach ($used_nonces as $nonce=> $timestamp){
            if( $timestamp > $time ){
                break;
            }
            unset( $used_nonces[$nonce] );
        }
    }

    //Add nonce in the stack after 2min
    if($time > $expires2){
        $used_nonces[$toadd_nonce] = $expires;
        asort( $used_nonces );
        update_option( '_sh_used_nonces',$used_nonces );
    }
    return true;
}

function wpestate_file_upload_max_size() {
  static $max_size = -1;

  if ($max_size < 0) {
    // Start with post_max_size.
    $max_size = wpestate_parse_size(ini_get('post_max_size'));

    // If upload_max_size is less, then reduce. Except if upload_max_size is
    // zero, which indicates no limit.
    $upload_max = wpestate_parse_size(ini_get('upload_max_filesize'));
    if ($upload_max > 0 && $upload_max < $max_size) {
      $max_size = $upload_max;
    }
  }
  return $max_size;
}

function wpestate_parse_size($size) {
  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
  $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
  if ($unit) {
    // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
    return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
  }
  else {
    return round($size);
  }
}


add_action('wp_head', 'wpestate_rand654_add_css');
function wpestate_rand654_add_css() {
    if ( is_singular('estate_property') ) {
        $local_id=get_the_ID();
        $wp_estate_global_page_template               =     intval( wpresidence_get_option('wp_estate_global_property_page_template') );
        $wp_estate_local_page_template                =     intval( get_post_meta($local_id, 'property_page_desing_local', true));
        if($wp_estate_global_page_template!=0 || $wp_estate_local_page_template!=0){
            
            if($wp_estate_local_page_template!=0){
                $id = $wp_estate_local_page_template; 
            }else{
                $id = $wp_estate_global_page_template; 
            }
         
            if ( $id ) {
                $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
                if ( ! empty( $shortcodes_custom_css ) ) {
                    print '<style type="text/css" data-type="vc_shortcodes-custom-css-'.intval($id).'">';
                    print trim($shortcodes_custom_css);
                    print '</style>';
                }
            }
        }
    }
}




// Enable font size & font family selects in the editor
if ( ! function_exists( 'wpestate_mce_buttons' ) ) {
	function wpestate_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wpestate_mce_buttons' );







if(!function_exists('wpestate_all_prop_details_prop_unit')):
function wpestate_all_prop_details_prop_unit(){
    $single_details = array(
      
        'Image'         =>  'image',
        'Title'         =>  'title',
        'Description'   =>  'description',
        'Categories'    =>  'property_category',
        'Action'        =>  'property_action_category',
        'City'          =>  'property_city',
        'Neighborhood'  =>  'property_area',
        'County / State'=>  'property_county_state',
        'Address'       =>  'property_address',
        'Zip'           =>  'property_zip',
        'Country'       =>  'property_country',
        'Status'        =>  'property_status',
        'Price'         =>  'property_price',
     
        'Size'              =>  'property_size',
        'Lot Size'          =>  'property_lot_size',
        'Rooms'             =>  'property_rooms',
        'Bedrooms'          =>  'property_bedrooms',
        'Bathrooms'         =>  'property_bathrooms',
        'Agent'             =>  'property_agent',
        'Agent Picture'     =>  'property_agent_picture'
        
    );
    
    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', '');    
    if( !empty($custom_fields)){  
        $i=0;
        while($i< count($custom_fields) ){     
            $name =   $custom_fields[$i][0]; 
            $slug         =     wpestate_limit45(sanitize_title( $name )); 
            $slug         =     sanitize_key($slug); 
            $single_details[str_replace('-',' ',$name)]=     $slug;
            $i++;
       }
    }
    
    return $single_details;
}
endif;









function wpestate_search_delete_user( $user_id ) {
    
    $user_obj = get_userdata( $user_id );
    $email = $user_obj->user_email;

    $args = array(
    'post_type'        => 'wpestate_search',
    'post_status'      =>  'any',
    'posts_per_page'   => -1 ,
    'meta_query' => array(
            array(
                    'key'     => 'user_email',
                    'value'   => $email,
                    'compare' => '=',
            ),
        ),
    );   
    $prop_selection = new WP_Query($args);
    
    while ($prop_selection->have_posts()): $prop_selection->the_post(); 
        $post_id        =   get_the_id();
        $user_email     =   get_post_meta($post_id, 'user_email', true) ;
        wp_delete_post($post_id,true);
    endwhile;
        
}
add_action( 'delete_user', 'wpestate_search_delete_user' );




if(!function_exists('wpestate_add_meta_post_to_search')):
function wpestate_add_meta_post_to_search($meta_array){
    global $table_prefix;
    global $wpdb;
    
    foreach($meta_array as $key=> $value){
      

        switch ($value['compare']) {
            case '=':
               
                  $potential_ids[$key]=
                            wpestate_get_ids_by_query(
                                $wpdb->prepare("
                                    SELECT post_id
                                    FROM ".$table_prefix."postmeta
                                    WHERE meta_key = %s
                                    AND CAST(meta_value AS UNSIGNED) = %f
                                ",array($value['key'],$value['value']) )
                        );
                break;
            case '>=':
                if($value['type']=='DATE'){
                    $potential_ids[$key]=
                        wpestate_get_ids_by_query(
                            $wpdb->prepare("
                                SELECT post_id
                                FROM ".$table_prefix."postmeta
                                WHERE meta_key = %s
                                AND CAST(meta_value AS DATE) >= %s
                            ",array($value['key'],( $value['value'] )) )
                    );
                }else{
                   $potential_ids[$key]=
                        wpestate_get_ids_by_query(
                            $wpdb->prepare("
                                SELECT post_id
                                FROM ".$table_prefix."postmeta
                                WHERE meta_key = %s
                                AND CAST(meta_value AS UNSIGNED) >= %f
                            ",array($value['key'],$value['value']) )
                        );
                }
                break;
            case '<=':
                if($value['type']=='DATE'){
                    $potential_ids[$key]=
                        wpestate_get_ids_by_query(
                            $wpdb->prepare("
                                SELECT post_id
                                FROM ".$table_prefix."postmeta
                                WHERE meta_key = %s
                                AND CAST(meta_value AS DATE) <= %s
                            ",array($value['key'],($value['value'])) )
                        );
                }else{
                    $potential_ids[$key]=
                            wpestate_get_ids_by_query(
                                $wpdb->prepare("
                                    SELECT post_id
                                    FROM ".$table_prefix."postmeta
                                    WHERE meta_key = %s
                                    AND CAST(meta_value AS UNSIGNED) <= %f
                                ",array($value['key'],$value['value']) )
                            );
                }
               
                break;
            case 'LIKE':
                
                $wild = '%';
                    $find = $value['value'];
                    $like = $wild . $wpdb->esc_like( $find ) . $wild;
                    $potential_ids[$key]=wpestate_get_ids_by_query(
                    $wpdb->prepare("
                        SELECT post_id
                        FROM ".$table_prefix."postmeta
                        WHERE meta_key =%s AND meta_value LIKE %s
                    ",array($value['key'],$like) ) );
                     
                    
                    
                break;
            case 'BETWEEN':
                $potential_ids[$key]=
                    wpestate_get_ids_by_query(
                        $wpdb->prepare("
                            SELECT post_id
                            FROM ".$table_prefix."postmeta
                            WHERE meta_key = '%s'
                            AND CAST(meta_value AS SIGNED)  BETWEEN '%f' AND '%f'
                        ",array($value['key'],$value['value'][0],$value['value'][1]) )
                );
                break;
        }
        
        $potential_ids[$key]=  array_unique($potential_ids[$key]);
        
    }
    
   

    $ids=[];
    if(!empty($potential_ids)){

        foreach($potential_ids[0] as $elements){
            $ids[]=$elements;
        }
        
        foreach($potential_ids as $key=>$temp_ids){
            $ids = array_intersect($ids,$temp_ids);
        }
    }
    
    $ids=  array_unique($ids);    
    if(empty($ids)){
        $ids[]=0;
    }
    return $ids;
    
}
endif;


add_action ( 'admin_enqueue_scripts', function () {
    if (is_admin ())
        wp_enqueue_media ();
} );








function noo_enable_vc_auto_theme_update() {
	if( function_exists('vc_updater') ) {
		$vc_updater = vc_updater();
                if(function_exists('wpestate_disable_filtering')){
                    wpestate_disable_filtering( 'upgrader_pre_download', array( $vc_updater, 'preUpgradeFilter' ), 10 );
                }
                if( function_exists( 'vc_license' ) ) {
			if( !vc_license()->isActivated() ) {
                                if(function_exists('wpestate_disable_filtering')){
                                    wpestate_disable_filtering( 'pre_set_site_transient_update_plugins', array( $vc_updater->updateManager(), 'check_update' ), 10 );
                                }
                        }
		}
	}
}
add_action('vc_after_init', 'noo_enable_vc_auto_theme_update');


add_filter( 'manage_posts_columns', 'wpestate_add_id_column', 5 );
add_action( 'manage_posts_custom_column', 'wpestate_id_column_content', 5, 2 );
add_filter( 'manage_pages_columns', 'wpestate_add_id_column', 5 );
add_action( 'manage_pages_custom_column', 'wpestate_id_column_content', 5, 2 );
add_filter( 'manage_media_columns', 'wpestate_add_id_column', 5 );
add_action( 'manage_media_custom_column', 'wpestate_id_column_content', 5, 2 );


add_action( 'manage_edit-category_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_category_custom_column', 'wpestate_categoriesColumnsRow',10,3 );
add_action( 'manage_edit-property_category_agent_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_category_agent_custom_column', 'wpestate_categoriesColumnsRow',10,3 );

add_action( 'manage_edit-property_action_category_agent_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_action_category_agent_custom_column', 'wpestate_categoriesColumnsRow',10,3 );

add_action( 'manage_edit-property_city_agent_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_city_agent_custom_column', 'wpestate_categoriesColumnsRow',10,3 );

add_action( 'manage_edit-property_area_agent_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_area_agent_custom_column', 'wpestate_categoriesColumnsRow',10,3 );

add_action( 'manage_edit-property_county_state_agent_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_county_state_agent_custom_column', 'wpestate_categoriesColumnsRow',10,3 );

add_action( 'manage_edit-property_category_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_category_custom_column', 'wpestate_categoriesColumnsRow',10,3 );

add_action( 'manage_edit-property_action_category_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_action_category_custom_column', 'wpestate_categoriesColumnsRow',10,3 );

add_action( 'manage_edit-property_city_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_city_custom_column', 'wpestate_categoriesColumnsRow',10,3 );


add_action( 'manage_edit-property_county_state_columns', 'wpestate_add_id_column',5 );
add_filter( 'manage_property_county_state_custom_column', 'wpestate_categoriesColumnsRow',10,3 );

function wpestate_add_id_column( $columns ) {
   $columns['revealid_id'] = 'ID';
   return $columns;
}

function wpestate_id_column_content( $column, $id ) {
    if( 'revealid_id' == $column ) {
        print intval($id);
    }
}


function wpestate_categoriesColumnsRow($argument, $columnName, $categoryID){
    if($columnName == 'revealid_id'){
        return $categoryID;
    }
}



function wpestate_add_query_vars_filter( $vars ){
  $vars[] = "packet";
  return $vars;
}
add_filter( 'query_vars', 'wpestate_add_query_vars_filter' );


add_action( 'admin_init', 'wpestate_cache_refresh' );
function wpestate_cache_refresh() {
    add_action('wp_trash_post', 'wpestate_delete_cache_for_links', 10 );
}

function ocdi_plugin_intro_text( $default_text ) {
    $default_text = '<div class="ocdi__intro-text intro-text_wpestate">:  For speed purposes, demo images are not included in the import. '
            . 'Revolution Sliders are imported separately from demo_content/revolutions_sliders folder If the import doesn’t go through in 1-2 minutes, server limits are affecting the import. '
            . 'Please check the server requirements list <a href="http://help.wpresidence.net/article/theme-wordpress-server-requirements/" target="_blank">here</a>.  '
            . 'For our assistance with this process, please contact us through client support <a href="http://support.wpestate.org/" target="_blank">here.</a></div>';

    return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'ocdi_plugin_intro_text' );


function ocdi_import_files() {
  return array(
    array(
        'import_file_name'             =>   'Main demo',  
        'local_import_file'            =>   trailingslashit( get_template_directory() ) . 'wpestate_templates/main-demo/theme_content.xml',
        'local_import_widget_file'     =>   trailingslashit( get_template_directory() ) . 'wpestate_templates/main-demo/widgets.wie',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/main-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
        'import_preview_image_url'     =>   get_theme_file_uri('wpestate_templates/main-demo/preview.jpg')  ,
        'import_notice'                =>   esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  =>   'https://wpresidence.net',
    ),
    
      
      
    array(
      'import_file_name'             =>     'Chicago Demo',
      'local_import_file'            =>     trailingslashit( get_template_directory() ) . 'wpestate_templates/chicago-demo/theme_content.xml',
      'local_import_widget_file'     =>     trailingslashit( get_template_directory() ) . 'wpestate_templates/chicago-demo/widgets.wie',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/chicago-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
      'import_preview_image_url'     =>     get_theme_file_uri('wpestate_templates/chicago-demo/preview.jpg')  ,
      'import_notice'               =>     esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
      'preview_url'                  =>     'https://chicago.wpresidence.net',
    ),
      
    array(
        'import_file_name'             => 'New York Demo',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/ny-demo/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/ny-demo/widgets.wie',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/ny-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
        'import_preview_image_url'     =>     get_theme_file_uri( 'wpestate_templates/ny-demo/preview.jpg')  ,
        'import_notice'               => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://newyork.wpresidence.net',
    ),
   
    array(
        'import_file_name'             => 'Los Angeles Demo',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/losangeles-demo/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/losangeles-demo/widgets.wie',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'wpestate_templates/losangeles-demo/wpresidence-export.dat',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/losangeles-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
        'import_preview_image_url'     =>  get_theme_file_uri('wpestate_templates/losangeles-demo/preview.jpg')  ,
        'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://losangeles.wpresidence.net',
    ),
      
       
    array(
        'import_file_name'             => 'Rio Demo',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/rio-demo/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/rio-demo/widgets.wie',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/rio-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
        'import_preview_image_url'     => get_theme_file_uri( 'wpestate_templates/rio-demo/preview.jpg')  ,
           'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://rio.wpresidence.net',
    ),
      
    array(
        'import_file_name'             => 'Tokyo Demo',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/tokyo-demo/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/tokyo-demo/widgets.wie',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/tokyo-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
        'import_preview_image_url'     => get_theme_file_uri('wpestate_templates/tokyo-demo/preview.jpg') ,
        'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://tokyo.wpresidence.net',
    ),
      
    array(
        'import_file_name'             => 'Paris Demo',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/paris-demo/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/paris-demo/widgets.wie',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/paris-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
        'import_preview_image_url'     => get_theme_file_uri('wpestate_templates/paris-demo/preview.jpg') ,
        'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://paris.wpresidence.net',
    ),
      
    array(
        'import_file_name'             => 'London Demo',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/london-demo/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/london-demo/widgets.wie',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/london-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
        'import_preview_image_url'     =>  get_theme_file_uri( 'wpestate_templates/london-demo/preview.jpg') ,
        'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://london.wpresidence.net',
    ),
      
    array(
        'import_file_name'             => 'Sydney Demo',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/sidney-demo/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/sidney-demo/widgets.wie',
        'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/sidney-demo/redux_options.json',
                  'option_name' => 'wpresidence_admin',
                ),
        ),
        'import_preview_image_url'     => get_theme_file_uri('wpestate_templates/sidney-demo/preview.jpg') ,
        'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://sydney.wpresidence.net',
    ),
      
      
       array(
        'import_file_name'             => 'Rome Demo',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/rome-demo/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/rome-demo/widgets.wie',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'wpestate_templates/rome-demo/wpresidence-export.dat',
        'local_import_redux'           => array(
            array(
              'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/rome-demo/redux_options.json',
              'option_name' => 'wpresidence_admin',
            ),
        ),
        'import_preview_image_url'     =>  get_theme_file_uri('wpestate_templates/rome-demo/preview.jpg'),
        'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://rome.wpresidence.net',
    ),
      
    array(
      'import_file_name'             => 'Demo 1',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo1/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo1/widgets.wie',
        'local_import_redux'           => array(
            array(
              'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo1/redux_options.json',
              'option_name' => 'wpresidence_admin',
            ),
        ),
        'import_preview_image_url'     =>  get_theme_file_uri( 'wpestate_templates/demo1/preview.jpg') ,
        'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://demo1.wpresidence.net',
    ),
      
    array(
        'import_file_name'             => 'Demo 2',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo2/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo2/widgets.wie',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo2/wpresidence-export.dat',
        'local_import_redux'           => array(
            array(
              'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo2/redux_options.json',
              'option_name' => 'wpresidence_admin',
            ),
        ),
        'import_preview_image_url'     => get_theme_file_uri( 'wpestate_templates/demo2/preview.jpg'),
        'import_notice'                      => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://demo2.wpresidence.net',
    ),
      
      
    array(
        'import_file_name'             => 'Demo 5',
        'local_import_file'            => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo5/theme_content.xml',
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo5/widgets.wie',
        'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo5/wpresidence-export.dat',
        'local_import_redux'           => array(
            array(
              'file_path'   => trailingslashit( get_template_directory() ) . 'wpestate_templates/demo5/redux_options.json',
              'option_name' => 'wpresidence_admin',
            ),
        ),
        'import_preview_image_url'     =>  get_theme_file_uri('wpestate_templates/demo5/preview.jpg') ,
        'import_notice'                => esc_html__( 'Clear theme cache after demo import is complete!', 'wpresidence' ),
        'preview_url'                  => 'https://demo5.wpresidence.net',
    ),
  );
}

$theme_activated    =   get_option('is_theme_activated','');
if($theme_activated=='is_active'){
    add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );
}



function ocdi_after_import_setup() {
    
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $footer_menu = get_term_by( 'name', 'footer', 'nav_menu' );
    
    set_theme_mod( 'nav_menu_locations', array(
        'primary'       => $main_menu->term_id,
        'mobile'        => $main_menu->term_id,
        'footer_menu'   => $footer_menu->term_id,
        )
    );
  

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Homepage' );
  

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    

}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );



function wpestate_my_export_option_keys( $keys ) {
     $export_options = array(    
        'wp_estate_show_reviews_prop',
        'wp_estate_enable_direct_mess',
        'wp_estate_admin_approves_reviews',
        'wp_estate_header5_info_widget1_icon',
        'wp_estate_header5_info_widget1_text1',
        'wp_estate_header5_info_widget1_text2',
        'wp_estate_header5_info_widget2_icon',
        'wp_estate_header5_info_widget2_text1',
        'wp_estate_header5_info_widget2_text2',
        'wp_estate_header5_info_widget3_text2',
        'wp_estate_header5_info_widget3_text1',
        'wp_estate_header5_info_widget3_icon',
        'wp_estate_spash_header_type',
        'wp_estate_splash_image',
        'wp_estate_splash_slider_gallery',
        'wp_estate_splash_slider_transition',
        'wp_estate_splash_video_mp4',
        'wp_estate_splash_video_webm',
        'wp_estate_splash_video_ogv',
        'wp_estate_splash_video_cover_img',
        'wp_estate_splash_overlay_image',
        'wp_estate_splash_overlay_color',
        'wp_estate_splash_overlay_opacity',
        'wp_estate_splash_page_title',
        'wp_estate_splash_page_subtitle',
        'wp_estate_splash_page_logo_link',    
        'wp_estate_theme_slider_height',
        'wp_estate_sticky_search',
        'wp_estate_use_geo_location',
        'wp_estate_geo_radius_measure',
        'wp_estate_initial_radius',
        'wp_estate_min_geo_radius',
        'wp_estate_max_geo_radius',
        'wp_estate_paralax_header',
        'wp_estate_keep_max',
        'wp_estate_adv_back_color_opacity',
        'wp_estate_search_on_start',
        'wp_estate_use_float_search_form',
        'wp_estate_float_form_top',
        'wp_estate_float_form_top_tax',
        'wp_estate_use_price_pins',
        'wp_estate_use_price_pins_full_price',
        'wp_estate_use_single_image_pin',
        'wpestate_export_theme_options',
        'wp_estate_mobile_header_background_color',
        'wp_estate_mobile_header_icon_color',
        'wp_estate_mobile_menu_font_color',
        'wp_estate_mobile_menu_hover_font_color',
        'wp_estate_mobile_item_hover_back_color',
        'wp_estate_mobile_menu_backgound_color',
        'wp_estate_mobile_menu_border_color',
        'wp_estate_crop_images_lightbox',
        'wp_estate_show_lightbox_contact',
        'wp_estate_submission_page_fields',
        'wp_estate_mandatory_page_fields',
        'wp_estate_url_rewrites',
        'wp_estate_print_show_subunits',
        'wp_estate_print_show_agent',
        'wp_estate_print_show_description',
        'wp_estate_print_show_adress',
        'wp_estate_print_show_details',
        'wp_estate_print_show_features',
        'wp_estate_print_show_floor_plans',
        'wp_estate_print_show_images',
        'wp_estate_show_header_dashboard',
        'wp_estate_user_dashboard_menu_color',
        'wp_estate_user_dashboard_menu_hover_color',
        'wp_estate_user_dashboard_menu_color_hover',
        'wp_estate_user_dashboard_menu_back',
        'wp_estate_user_dashboard_package_back',
        'wp_estate_user_dashboard_package_color',
        'wp_estate_user_dashboard_buy_package',
        'wp_estate_user_dashboard_package_select',
        'wp_estate_user_dashboard_content_back',
        'wp_estate_user_dashboard_content_button_back',
        'wp_estate_user_dashboard_content_color',
        'wp_estate_property_multi_text',                
        'wp_estate_property_multi_child_text', 
        'wp_estate_theme_slider_type',
        'wp_estate_adv6_taxonomy',
        'wp_estate_adv6_taxonomy_terms',   
        'wp_estate_adv6_max_price',     
        'wp_estate_adv6_min_price',
        'wp_estate_adv_search_fields_no',
        'wp_estate_search_fields_no_per_row',
        'wp_estate_property_sidebar',
        'wp_estate_property_sidebar_name',
        'wp_estate_show_breadcrumbs',
        'wp_estate_global_property_page_template',
        'wp_estate_p_fontfamily',
        'wp_estate_p_fontsize',
        'wp_estate_p_fontsubset',
        'wp_estate_p_lineheight',
        'wp_estate_p_fontweight',
        'wp_estate_h1_fontfamily',
        'wp_estate_h1_fontsize',
        'wp_estate_h1_fontsubset',
        'wp_estate_h1_lineheight',
        'wp_estate_h1_fontweight',
        'wp_estate_h2_fontfamily',
        'wp_estate_h2_fontsize',
        'wp_estate_h2_fontsubset',
        'wp_estate_h2_lineheight',
        'wp_estate_h2_fontweight',
        'wp_estate_h3_fontfamily',
        'wp_estate_h3_fontsize',
        'wp_estate_h3_fontsubset',
        'wp_estate_h3_lineheight',
        'wp_estate_h3_fontweight',
        'wp_estate_h4_fontfamily',
        'wp_estate_h4_fontsize',
        'wp_estate_h4_fontsubset',
        'wp_estate_h4_lineheight',
        'wp_estate_h4_fontweight',
        'wp_estate_h5_fontfamily',
        'wp_estate_h5_fontsize',
        'wp_estate_h5_fontsubset',
        'wp_estate_h5_lineheight',
        'wp_estate_h5_fontweight',
        'wp_estate_h6_fontfamily',
        'wp_estate_h6_fontsize',
        'wp_estate_h6_fontsubset',
        'wp_estate_h6_lineheight',
        'wp_estate_h6_fontweight',
        'wp_estate_menu_fontfamily',
        'wp_estate_menu_fontsize',
        'wp_estate_menu_fontsubset',
        'wp_estate_menu_lineheight',
        'wp_estate_menu_fontweight',
        'wp_estate_transparent_logo_image',
        'wp_estate_stikcy_logo_image',
        'wp_estate_logo_image',
        'wp_estate_sidebar_boxed_font_color',
        'wp_estate_sidebar_heading_background_color',
        'wp_estate_map_controls_font_color',
        'wp_estate_map_controls_back',
        'wp_estate_transparent_menu_hover_font_color',
        'wp_estate_transparent_menu_font_color',
        'wp_estate_top_menu_hover_back_font_color',
        'wp_estate_top_menu_hover_type',
        'wp_estate_top_menu_hover_font_color',
        'wp_estate_active_menu_font_color',
        'wp_estate_menu_item_back_color',
        'wp_estate_sticky_menu_font_color',
        'wp_estate_top_menu_font_size',
        'wp_estate_menu_item_font_size',
        'wpestate_uset_unit',
        'wp_estate_sidebarwidget_internal_padding_top',
        'wp_estate_sidebarwidget_internal_padding_left',
        'wp_estate_sidebarwidget_internal_padding_bottom',
        'wp_estate_sidebarwidget_internal_padding_right',
        'wp_estate_widget_sidebar_border_size',
        'wp_estate_widget_sidebar_border_color',
        'wp_estate_unit_border_color',
        'wp_estate_unit_border_size',
        'wp_estate_blog_unit_min_height',
        'wp_estate_agent_unit_min_height',
        'wp_estate_agent_listings_per_row',
        'wp_estate_blog_listings_per_row',
        'wp_estate_content_area_back_color',
        'wp_estate_contentarea_internal_padding_top',
        'wp_estate_contentarea_internal_padding_left',
        'wp_estate_contentarea_internal_padding_bottom',
        'wp_estate_contentarea_internal_padding_right',
        'wp_estate_property_unit_color',
        'wp_estate_propertyunit_internal_padding_top',
        'wp_estate_propertyunit_internal_padding_left',
        'wp_estate_propertyunit_internal_padding_bottom',
        'wp_estate_propertyunit_internal_padding_right',       
        'wpestate_property_unit_structure',
        'wpestate_property_page_content',
        'wp_estate_main_grid_content_width',
        'wp_estate_main_content_width',
        'wp_estate_header_height',
        'wp_estate_sticky_header_height',
        'wp_estate_border_radius_corner',
        'wp_estate_cssbox_shadow',
        'wp_estate_prop_unit_min_height',
        'wp_estate_border_bottom_header',
        'wp_estate_sticky_border_bottom_header',
        'wp_estate_listings_per_row',
        'wp_estate_unit_card_type',
        'wp_estate_prop_unit_min_height',
        'wp_estate_main_grid_content_width',
        'wp_estate_header_height',
        'wp_estate_sticky_header_height',
        'wp_estate_border_bottom_header_sticky_color',
        'wp_estate_border_bottom_header_color',
        'wp_estate_show_top_bar_user_login',
        'wp_estate_show_top_bar_user_menu',
        'wp_estate_currency_symbol',
        'wp_estate_where_currency_symbol',
        'wp_estate_measure_sys',
        'wp_estate_facebook_login',
        'wp_estate_google_login',
        'wp_estate_yahoo_login',
        'wp_estate_wide_status',
        'wp_estate_header_type',
        'wp_estate_prop_no',
        'wp_estate_prop_image_number',
        'wp_estate_show_empty_city',
        'wp_estate_blog_sidebar',
        'wp_estate_blog_sidebar_name',
        'wp_estate_blog_unit',
        'wp_estate_general_latitude',
        'wp_estate_general_longitude',
        'wp_estate_default_map_zoom',
        'wp_estate_cache',
        'wp_estate_show_adv_search_map_close',
        'wp_estate_pin_cluster',
        'wp_estate_zoom_cluster',
        'wp_estate_hq_latitude',
        'wp_estate_hq_longitude',
        'wp_estate_idx_enable',
        'wp_estate_geolocation_radius',
        'wp_estate_min_height',
        'wp_estate_max_height',
        'wp_estate_keep_min',
        'wp_estate_paid_submission',
        'wp_estate_admin_submission',
        'wp_estate_admin_submission_user_role',
        'wp_estate_price_submission',
        'wp_estate_price_featured_submission',
        'wp_estate_submission_curency',
        'wp_estate_free_mem_list',
        'wp_estate_free_feat_list',
        'wp_estate_free_feat_list_expiration',
        'wp_estate_free_pack_image_included',
        'wp_estate_custom_advanced_search',
        'wp_estate_adv_search_type',
        'wp_estate_show_adv_search',
        'wp_estate_show_adv_search_map_close',
        'wp_estate_cron_run',
        'wp_estate_show_no_features',
        'wp_estate_property_features_text',
        'wp_estate_property_description_text',
        'wp_estate_property_details_text',
        'wp_estate_status_list',
        'wp_estate_slider_cycle',
        'wp_estate_show_save_search',
        'wp_estate_search_alert',
        'wp_estate_adv_search_type',
        'wp_estate_color_scheme',
        'wp_estate_main_color',
        'wp_estate_second_color',
        'wp_estate_background_color',
        'wp_estate_content_back_color',
        'wp_estate_header_color',
        'wp_estate_breadcrumbs_font_color',
        'wp_estate_font_color',
        'wp_estate_menu_items_color',
        'wp_estate_link_color',
        'wp_estate_headings_color',
        'wp_estate_sidebar_heading_boxed_color',
        'wp_estate_sidebar_widget_color',
        'wp_estate_footer_back_color',
        'wp_estate_footer_font_color',
        'wp_estate_footer_copy_color',
        'wp_estate_footer_copy_back_color',
        'wp_estate_menu_font_color',
        'wp_estate_menu_hover_back_color',
        'wp_estate_menu_hover_font_color',
        'wp_estate_menu_border_color',
        'wp_estate_top_bar_back',
        'wp_estate_top_bar_font',
        'wp_estate_adv_search_back_color',
        'wp_estate_adv_search_font_color',
        'wp_estate_box_content_back_color',
        'wp_estate_box_content_border_color',
        'wp_estate_hover_button_color',
        'wp_estate_show_g_search',
        'wp_estate_show_adv_search_extended',
        'wp_estate_readsys',
        'wp_estate_map_max_pins',
        'wp_estate_ssl_map',
        'wp_estate_enable_stripe',    
        'wp_estate_enable_paypal',    
        'wp_estate_enable_direct_pay',    
        'wp_estate_global_property_page_agent_sidebar',
        'wp_estate_global_prpg_slider_type',
        'wp_estate_global_prpg_content_type',
        'wp_estate_logo_margin',
        'wp_estate_header_transparent',
        'wp_estate_default_map_type',
        'wp_estate_prices_th_separator',
        'wp_estate_multi_curr',
        'wp_estate_date_lang',
        'wp_estate_blog_unit',
        'wp_estate_enable_autocomplete',
        'wp_estate_visible_user_role_dropdown',
        'wp_estate_visible_user_role',
        'wp_estate_enable_user_pass',
        'wp_estate_auto_curency',
        'wp_estate_status_list',
        'wp_estate_custom_fields',
        'wp_estate_subject_password_reset_request',
        'wp_estate_password_reset_request',
        'wp_estate_subject_password_reseted',
        'wp_estate_password_reseted',
        'wp_estate_subject_purchase_activated',
        'wp_estate_purchase_activated',
        'wp_estate_subject_approved_listing',
        'wp_estate_approved_listing',
        'wp_estate_subject_new_wire_transfer',
        'wp_estate_new_wire_transfer',
        'wp_estate_subject_admin_new_wire_transfer',
        'wp_estate_admin_new_wire_transfer',
        'wp_estate_subject_admin_new_user',
        'wp_estate_admin_new_user',
        'wp_estate_subject_new_user',
        'wp_estate_new_user',
        'wp_estate_subject_admin_expired_listing',
        'wp_estate_admin_expired_listing',
        'wp_estate_subject_matching_submissions',
        'wp_estate_subject_paid_submissions',
        'wp_estate_paid_submissions',
        'wp_estate_subject_featured_submission',
        'wp_estate_featured_submission',
        'wp_estate_subject_account_downgraded',
        'wp_estate_account_downgraded',
        'wp_estate_subject_membership_cancelled',
        'wp_estate_membership_cancelled',
        'wp_estate_subject_downgrade_warning',
        'wp_estate_downgrade_warning',
        'wp_estate_subject_membership_activated',
        'wp_estate_membership_activated',
        'wp_estate_subject_free_listing_expired',
        'wp_estate_free_listing_expired',
        'wp_estate_subject_new_listing_submission',
        'wp_estate_new_listing_submission',
        'wp_estate_subject_listing_edit',
        'wp_estate_listing_edit',
        'wp_estate_subject_recurring_payment',
        'wp_estate_subject_recurring_payment',
        'wp_estate_custom_css',
        'wp_estate_company_name',
        'wp_estate_telephone_no',
        'wp_estate_mobile_no',
        'wp_estate_fax_ac',
        'wp_estate_skype_ac',
        'wp_estate_co_address',
        'wp_estate_facebook_link',
        'wp_estate_twitter_link',
        'wp_estate_pinterest_link',
        'wp_estate_instagram_link',
        'wp_estate_linkedin_link',
        'wp_estate_contact_form_7_agent',
        'wp_estate_contact_form_7_contact',
        'wp_estate_global_revolution_slider',
        'wp_estate_repeat_footer_back',
        'wp_estate_prop_list_slider',
        'wp_estate_agent_sidebar',
        'wp_estate_agent_sidebar_name',
        'wp_estate_property_list_type',
        'wp_estate_property_list_type_adv',
        'wp_estate_prop_unit',
        'wp_estate_general_font',
        'wp_estate_headings_font_subset',
        'wp_estate_copyright_message',
        'wp_estate_show_graph_prop_page',
        'wp_estate_map_style',
        'wp_estate_submission_curency_custom',
        'wp_estate_free_mem_list_unl',
        'wp_estate_adv_search_what',
        'wp_estate_adv_search_how',
        'wp_estate_adv_search_label',
        'wp_estate_show_save_search',
        'wp_estate_show_adv_search_slider',
        'wp_estate_show_adv_search_visible',
        'wp_estate_show_slider_price',
        'wp_estate_show_dropdowns',
        'wp_estate_show_slider_min_price',
        'wp_estate_show_slider_max_price',
        'wp_estate_adv_back_color',
        'wp_estate_adv_font_color',
        'wp_estate_show_no_features',
        'wp_estate_advanced_exteded',
        'wp_estate_adv_search_what',
        'wp_estate_adv_search_how',
        'wp_estate_adv_search_label',
        'wp_estate_adv_search_type',
        'wp_estate_property_adr_text',
        'wp_estate_property_features_text',
        'wp_estate_property_description_text',
        'wp_estate_property_details_text',
        'wp_estate_new_status',
        'wp_estate_status_list',
        'wp_estate_theme_slider',
        'wp_estate_slider_cycle',
        'wp_estate_use_mimify',
        'wp_estate_currency_label_main',
        'wp_estate_footer_background',
        'wp_estate_wide_footer',
        'wp_estate_show_footer',
        'wp_estate_show_footer_copy',
        'wp_estate_footer_type',
        'wp_estate_logo_header_type',
        'wp_estate_wide_header',
        'wp_estate_logo_header_align',
        'wp_estate_text_header_align',
        'wp_estate_general_country'
        );
     
    foreach($export_options as $option){
         $keys[]=$option;
    }
   
    return $keys;
}
add_filter( 'cei_export_option_keys', 'wpestate_my_export_option_keys' );


if ( function_exists('icl_object_id') ) {
    add_action( 'add_attachment', 'sync_menu_order', 100 );
    add_action( 'edit_attachment', 'sync_menu_order', 100 );
    function sync_menu_order( $post_ID ) {
            $post = get_post( $post_ID );
            $menu_order = $post->menu_order;
            $trid = apply_filters( 'wpml_element_trid', false, $post_ID, 'post_attachment' );
            $translations = apply_filters( 'wpml_get_element_translations', false, $trid, 'post_attachment' );
            $translated_ids = wp_list_pluck( $translations, 'element_id' );
            if ( $menu_order !== null && (bool) $translated_ids !== false ) {
                    global $wpdb;
                    $query = $wpdb->prepare(
                            "UPDATE {$wpdb->posts}
                               SET menu_order=%s
                               WHERE ID IN (" . wpml_prepare_in( $translated_ids, '%d' ) . ')',
                            $menu_order
                    );
                    $wpdb->query( $query );
            }
    }
}

//////////////////////////////weglot fixed


add_filter('weglot_active_translation_before_treat_page', 'ajax_weglot_active_translation');

function ajax_weglot_active_translation(){
    if ( isset($_POST) && isset($_POST['action']) && ( $_POST['action'] === 'wpestate_ajax_check_booking_valability' || $_POST['action'] === 'wpestate_ajax_google_login_oauth' || $_POST['action'] === 'wpestate_ajax_facebook_login') ) { 
        return false;
    }
    return true;

}


add_action('body_class', function($classes){
    if (function_exists('the_gutenberg_project') && has_blocks( get_the_ID() ) )
            $classes[] = 'using-gutenberg';
    return $classes;
});


        
add_action('admin_init','wpresidence_convert_redux',50);
function wpresidence_convert_redux(){

    if( get_option('wpresidence_convert_to_redux2','')!='yes' ){
        if(function_exists('wpestate_convert_to_redux_framework')){
            if ( class_exists( 'Redux' ) ) {
                wpestate_convert_to_redux_framework();
             
            }
        }
    }

}
  


/** REMOVE REDUX MESSAGES */
function remove_redux_messages() {
	if(class_exists('ReduxFramework')){
		remove_action( 'admin_notices', array( get_redux_instance('theme_options'), '_admin_notices' ), 99);
	}
}

/** HOOK TO REMOVE REDUX MESSAGES */
add_action('init', 'remove_redux_messages');



if(!function_exists('wpresidence_body_classes')):
    function wpresidence_body_classes( $classes ) {
        global $post;
        $show_header_dashboard      =  wpresidence_get_option('wp_estate_show_header_dashboard','');
        if( isset($post->ID) && wpestate_half_map_conditions ($post->ID) ){
            $classes[] =" half_map_body ";
        }

        if(esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_menu','') )=="yes"){
            $classes[] =" has_top_bar ";
        }
        
        if( wpestate_is_user_dashboard() && $show_header_dashboard=='no'){
            $classes[] =" dash_no_header ";
        }


        return $classes;
    }
endif;
add_filter( 'body_class','wpresidence_body_classes' );



add_action( 'wp_ajax_wpestate_check_license_function', 'wpestate_check_license_function' );

if( !function_exists('wpestate_check_license_function') ):
    function wpestate_check_license_function(){
        check_ajax_referer( 'wpestate_license_ajax_nonce',  'security' );
      
        if( !current_user_can('administrator') ){
            exit('out pls');
        }
        
        $wpestate_license_key = esc_html($_POST['wpestate_license_key']);       
        $data= array(   
                        'license'=>trim($wpestate_license_key),
                        'action'=>    'wpestate_envato_lic'
                    );
            
        $args=array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'sslverify' => false,
                'blocking' => true,
                'body' =>  $data,
                'headers' => [ 
                      'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
                ],
        );
        
        
        $url="http://support.wpestate.org/theme_license_check_wpresidence.php";
        $response = wp_remote_post( $url, $args ); 

        if ( is_wp_error( $response ) ) {
	    $error_message = $response->get_error_message();
            die($error_message);
	} else {
	   
            $output = trim(wp_remote_retrieve_body( $response ));

            if($output==='ok'){
                update_option('is_theme_activated','is_active');
                print 'ok';
            }else{
                print 'nook';
            }
        
	}
        
        die();
    }
endif;


if( !function_exists('show_support_link') ):
function show_support_link(){
    
    if(wpresidence_get_option('wp_estate_support','')=='yes'){

        if( is_front_page() || is_tax() ){
            print '<a class="wpestate_support_link" href="https://wpestate.org" target="_blank">WpEstate</a>';
        }
    }
}
endif;

?>
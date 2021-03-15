<?php
// Template Name: Splash Page
// Wp Estate Pack 
if(!function_exists('wpestate_residence_functionality')){
    esc_html_e('This page will not work without WpResidence Core Plugin, Please activate it from the plugins menu!','wpresidence');
    exit();
}
global $post;
get_header(); 
$wpestate_options=wpestate_page_details($post->ID); 

?>
</div><!-- end content_wrapper started in header -->
</div> <!-- end class container -->
<?php wp_footer(); ?>
</div> <!-- end website wrapper -->
<?php  
include( locate_template('templates/login_register_modal.php') ); 
$ajax_nonce_log_reg = wp_create_nonce( "wpestate_ajax_log_reg" );
print'<input type="hidden" id="wpestate_ajax_log_reg" value="'.esc_html($ajax_nonce_log_reg).'" />    ';  
global $wpestate_logo_header_align;
$logo_header_type            =   wpresidence_get_option('wp_estate_logo_header_type','');
$wpestate_logo_header_align  =   wpresidence_get_option('wp_estate_logo_header_align','');

if($logo_header_type=='type3'){ 
     include( locate_template( 'templates/top_bar_sidebar.php') ); 
}
?>
</body>
</html>
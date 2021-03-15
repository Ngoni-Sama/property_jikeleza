<?php
// Template Name: User Dashboard Search Results
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user                   =   wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$user_registered                =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation        =   get_the_author_meta( 'package_activation' , $userID );   
$paid_submission_status         =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
$edit_link                      =   wpestate_get_template_link('user_dashboard_add.php');
$floor_link                     =   wpestate_get_template_link('user_dashboard_floor.php');
$processor_link                 =   wpestate_get_template_link('processor.php');
$agent_list                     =   (array)get_user_meta($userID,'current_agent_list',true);
$wpestate_options               =   wpestate_page_details($post->ID);



if ( ! isset( $_POST['dashboard_searches_nonce'] )  || ! wp_verify_nonce( $_POST['dashboard_searches_nonce'], 'dashboard_searches' ) ) {
    esc_html_e('Sorry, your nonce did not verify.','wpresidence');
    exit;
}
    
   
if( isset( $_GET['delete_id'] ) ) {
    if( !is_numeric($_GET['delete_id'] ) ){
          exit('you don\'t have the right to delete this');
    }else{
        $delete_id=$_GET['delete_id'];
        $the_post= get_post( $delete_id); 

        if( $current_user->ID != $the_post->post_author   &&  !in_array($the_post->post_author , $agent_list)  ) {
            exit('you don\'t have the right to delete this');;
        }else{

            // delete attchaments
            $arguments = array(
                'numberposts' => -1,
                'post_type' => 'attachment',
                'post_parent' => $delete_id,
                'post_status' => null,
                'exclude' => get_post_thumbnail_id(),
                'orderby' => 'menu_order',
                'order' => 'ASC'
            );
            $post_attachments = get_posts($arguments);
            
            foreach ($post_attachments as $attachment) {
               wp_delete_post($attachment->ID);                      
             }
           
            wp_delete_post( $delete_id ); 
         
        }  
    }  
}  
  


get_header();
?> 


<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-left-col');  ?> 
    
    <div class="col-md-9 dashboard-margin">
        <?php   get_template_part('templates/breadcrumbs'); ?>
        <?php   get_template_part('templates/user_memebership_profile');  ?>
        <?php   get_template_part('templates/ajax_container'); ?>
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h3 class="entry-title"><?php the_title(); ?></h3>
        <?php } ?>
        <?php
        $page_title=esc_html($_POST['prop_name']);
    
        $agent_list[]   =   $current_user->ID;
        
        $args = array(
                     'post_status'      =>  'any',
                    'cache_results'             =>  false,
                    'update_post_meta_cache'    =>  false,
                    'update_post_term_cache'    =>  false,
                    'post_type'                 =>  'estate_property',
                    'author__in'                => $agent_list,
                    'posts_per_page'            =>  -1 ,
                    's'                         => $page_title
               );


        $prop_selection = new WP_Query($args);
        if( !$prop_selection->have_posts() ){
            print'<div class="col-md-12 row_dasboard-prop-listing">';
            print '<h4>'.esc_html__('You don\'t have any properties yet!','wpresidence').'</h4>';
             print'</div>';
        }else{
            print '
            <form action="'.wpestate_get_dasboard_searches_link().'" id="search_dashboard_auto" method="POST">
                <input type="text" id="prop_name" name="prop_name" value="" placeholder="'.esc_html__('Search a listing','wpresidence').'">  
                <input type="submit" class="wpresidence_button" id="search_form_submit_1" value="'.esc_html__('Search','wpresidence').'">';
                wp_nonce_field( 'dashboard_searches', 'dashboard_searches_nonce');
            print'          
            </form> ';       
        }
          
        while ($prop_selection->have_posts()): $prop_selection->the_post();          
            include( locate_template('templates/dashboard_listing_unit.php') ); 
        endwhile;   
        wp_reset_postdata();  
            
        $args = array(
                'cache_results'             =>  false,
                'update_post_meta_cache'    =>  false,
                'update_post_term_cache'    =>  false,
                'post_type'                 =>  'estate_property',
                'author__in'                => $agent_list,
                'posts_per_page'            =>  -1 ,

             );
        
        $autofill='';
        $prop_selection = new WP_Query($args);
        while ($prop_selection->have_posts()): $prop_selection->the_post();          

               $autofill.= '"'.get_the_title().'",';
        endwhile; 
        
        
        print '<script type="text/javascript">
           //<![CDATA[
                 jQuery(document).ready(function(){
                     var autofill=['.$autofill.']
                     jQuery( "#prop_name" ).autocomplete({
                     source: autofill
                 });
           });
           //]]>
           </script>';
        wpestate_pagination($prop_selection->max_num_pages, $range =2);
        ?>    
    </div>

</div>  
<?php
$ajax_nonce1 = wp_create_nonce( "wpestate_property_actions" );
print ' <input type="hidden" id="wpestate_property_actions" value="'.esc_html($ajax_nonce1).'" />';
get_footer(); 
?>
<?php
// Template Name: User Dashboard Floor Plans
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user                   =   wp_get_current_user();  
$paid_submission_status         =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
$userID                         =   $current_user->ID;
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);
$show_remove_fav                =   1;   
$show_compare                   =   1;
$show_compare_only              =   'no';
$wpestate_currency              =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency                 =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$agent_list                     =   (array)get_user_meta($userID,'current_agent_list',true);
get_header();
$wpestate_options=wpestate_page_details($post->ID);
$post_id        =   '';
$post_title     =   '';
if( isset( $_GET['floor_edit'] ) && is_numeric( $_GET['floor_edit'] ) ){
   $post_id=intval( $_GET['floor_edit']);
   $post_title=get_the_title($post_id);
}


 $the_post= get_post( $post_id); 
 
    if( $current_user->ID != $the_post->post_author &&  !in_array($the_post->post_author , $agent_list)   ) {
        exit('You don\'t have the rights to edit this');
    }

if( isset($_POST ) && isset($_POST['dashboard_add_floor_nonce'])){
    //////////////////////////////////////////////////////////////////
    /// save floor plan
    //////////////////////////////////////////////////////////////////
    
    $floor_for_post= intval($_POST['floor_for_post']);

    if (    ! isset( $_POST['dashboard_add_floor_nonce'] )  || ! wp_verify_nonce( $_POST['dashboard_add_floor_nonce'], 'dashboard_add_floor' ) ) {
        esc_html_e('Sorry, your nonce did not verify.','wpresidence');
        exit;
    }
    
    
    if(isset($_POST['use_floor_plans'])){
        update_post_meta($floor_for_post, 'use_floor_plans',intval( $_POST['use_floor_plans'] ) );
    }
    
    if(isset($_POST['plan_title'])){        
        update_post_meta($floor_for_post, 'plan_title',wpestate_sanitize_array ( $_POST['plan_title'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_title','' );
        }
    }
     
    if(isset($_POST['plan_description'])){        
            update_post_meta($floor_for_post, 'plan_description',wpestate_sanitize_array ( $_POST['plan_description'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_description','' );
        }
    }
    
     if(isset($_POST['plan_image_attach'])){        
            update_post_meta($floor_for_post, 'plan_image_attach',wpestate_sanitize_array ( $_POST['plan_image_attach'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_image_attach','' );
        }
    }
    
    
    if(isset($_POST['plan_image'])){        
            update_post_meta($floor_for_post, 'plan_image',wpestate_sanitize_array ( $_POST['plan_image'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_image','' );
        }
    }
    
    if(isset($_POST['plan_size'])){        
            update_post_meta($floor_for_post, 'plan_size',wpestate_sanitize_array ( $_POST['plan_size'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_size','' );
        }
    }
    
    
      if(isset($_POST['plan_rooms'])){        
            update_post_meta($floor_for_post, 'plan_rooms',wpestate_sanitize_array ( $_POST['plan_rooms'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_rooms','' );
        }
    }
    
      if(isset($_POST['plan_bath'])){        
            update_post_meta($floor_for_post, 'plan_bath',wpestate_sanitize_array ( $_POST['plan_bath'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_bath','' );
        }
    }
    
      if(isset($_POST['plan_price'])){        
            update_post_meta($floor_for_post, 'plan_price',wpestate_sanitize_array ( $_POST['plan_price'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_price','' );
        }
    }
    
    
    //////////////////////////////////////// end save floor plan
}
?>



<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-left-col');  ?>


    <div class="col-md-9 dashboard-margin">
        <?php get_template_part('templates/breadcrumbs'); ?>
        <?php get_template_part('templates/user_memebership_profile');  ?>
        <?php get_template_part('templates/ajax_container'); ?>

        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h3 class="entry-title"><?php the_title(); echo ' '.esc_html__('for','wpresidence').' '; echo esc_html($post_title); ?></h3>
        <?php } ?>
        
     <div class="col-md-12 row_dasboard-prop-listing">
        <?php     
        $plan_title         =   '';
        $plan_image         =   '';
        $plan_description   =   '';
        $plan_bath          =   '';
        $plan_rooms         =   '';
        $plan_size          =   '';
        $plan_price         =   '';
        
        $use_floor_plans        = get_post_meta($post_id, 'use_floor_plans', true);
        $plan_title_array       = get_post_meta($post_id, 'plan_title', true);
        $plan_desc_array        = get_post_meta($post_id, 'plan_description', true) ;
        $plan_image_attach_array= get_post_meta($post_id, 'plan_image_attach', true) ;
        $plan_image_array       = get_post_meta($post_id, 'plan_image', true) ;
        $plan_size_array        = get_post_meta($post_id, 'plan_size', true) ;
        $plan_rooms_array       = get_post_meta($post_id, 'plan_rooms', true) ;
        $plan_bath_array        = get_post_meta($post_id, 'plan_bath', true);
        $plan_price_array       = get_post_meta($post_id, 'plan_price', true) ;

        print '<div id="plan_wrapper"><form action="" method="POST">';
         wp_nonce_field( 'dashboard_add_floor', 'dashboard_add_floor_nonce'); 
        if(is_array($plan_title_array)){
            print '<p class="meta-options"> 
                  <input type="hidden" name="use_floor_plans" value="0">
                  <input type="checkbox" id="use_floor_plans" name="use_floor_plans" value="1"'; 

                if($use_floor_plans==1){
                    print ' checked="checked" ';
                }
            print'><label for="use_floor_plans">'.esc_html__('Use Floor Plans','wpresidence').'</label>
            </p>';
        }

        if(is_array($plan_title_array)){
            foreach ($plan_title_array as $key=> $plan_name) {

                if ( isset($plan_desc_array[$key])){
                    $plan_desc=$plan_desc_array[$key];
                }else{
                    $plan_desc='';
                }
                
                if ( isset($plan_desc_array[$key])){
                    $plan_image_attach=$plan_image_attach_array[$key];
                }else{
                    $plan_image_attach='';
                }
                
                if ( isset($plan_image_array[$key])){
                    $plan_img=$plan_image_array[$key];
                }else{
                    $plan_img='';
                }

                if ( isset($plan_size_array[$key])){
                    $plan_size=$plan_size_array[$key];
                }else{
                    $plan_size='';
                }

                if ( isset($plan_rooms_array[$key])){
                    $plan_rooms=$plan_rooms_array[$key];
                }else{
                    $plan_rooms='';
                }

                if ( isset($plan_bath_array[$key])){
                    $plan_bath=$plan_bath_array[$key];
                }else{
                    $plan_bath='';
                }

                if ( isset($plan_price_array[$key])){
                    $plan_price=$plan_price_array[$key];
                }else{
                    $plan_price='';
                }


            $preview=wp_get_attachment_image_src($plan_image_attach, 'user_picture_profile');    
            print '
            <div class="uploaded_images floor_container" data-imageid="">
            <input type="hidden" name="plan_image_attach[]" value="'.esc_html($plan_image_attach).'">
            <input type="hidden" name="plan_image[]" value="'.esc_url($plan_img).'">
            <img src="'.esc_url($preview[0]).'" alt="'.esc_html__('user image','wpresidence').'"><i class="fa deleter_floor fa-trash-o"></i>
            <div class="">
            <p class="meta-options floor_p">
                <label for="plan_title">'.esc_html__('Plan Title','wpresidence').'</label><br>
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="'.esc_html($plan_name).'" >
            </p>
            
            <p class="meta-options floor_full"> 
                <label for="plan_description">'.esc_html__('Plan Description','wpresidence').'</label><br> 
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" >'.esc_html($plan_desc).'</textarea>
            </p>
             
            <p class="meta-options floor_p"> 
                <label for="plan_size">'.esc_html__('Plan Size','wpresidence').'</label><br> 
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="'.esc_html($plan_size).'"> 
            </p> 
            
            <p class="meta-options floor_p"> 
                <label for="plan_rooms">'.esc_html__('Plan Rooms','wpresidence').'</label><br> 
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="'.esc_html($plan_rooms).'""> 
            </p> 
            <p class="meta-options floor_p"> 
                <label for="plan_bath">'.esc_html__('Plan Bathrooms','wpresidence').'</label><br> 
                <input id="plan_bath" type="text" size="36"name="plan_bath[]" value="'.esc_html($plan_bath).'"> 
            </p> 
            <p class="meta-options floor_p"> 
                <label for="plan_price">'.esc_html__('Price in ','wpresidence'). esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') ) .'</label><br> 
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="'.esc_html($plan_price).'"> 
            </p> 
    </div></div>';
            }
        }else{

            print '<h4 id="no_plan_mess">'.esc_html__('You don\'t have any plans attached!','wpresidence').'</h4>';

        }
        
        $images='';
    ?> 
        <div id="upload-container">                 
            <div id="aaiu-upload-container">                 
                <div id="aaiu-upload-imagelist">
                    <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                </div>

                <div id="imagelist">
                <?php 
                 $ajax_nonce = wp_create_nonce( "wpestate_image_upload" );
                    print'<input type="hidden" id="wpestate_image_upload" value="'.esc_html($ajax_nonce).'" />    ';
                    if($images!=''){
                        print trim($images);
                    }
                ?>  
                </div>

                <button id="aaiu-uploader"  class="wpresidence_button wpresidence_success"><?php esc_html_e('Upload New Plan Image','wpresidence');?></button>
      
        </div>  
        </div>   

    <input type="hidden" name="floor_for_post" value="<?php print intval($post_id);?>">
    <input type="submit" class="wpresidence_button" id="floor_submit" value="<?php esc_html_e('Save Plans','wpresidence');?>">
  </form>
 </div>
 </div>
</div>   

<?php get_footer(); ?>
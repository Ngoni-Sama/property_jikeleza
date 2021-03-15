<?php
$current_user               =   wp_get_current_user();
$user_custom_picture        =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
$user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
if( $user_small_picture_id == '' ){
    $user_small_picture[0]= get_theme_file_uri('/img/default_user_small.png');
}else{
    $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'user_thumb');
    
}
?>
<?php
global $wpestate_global_payments;
$show_top_bar_user_login    =   esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_login','') );
?>
   
<?php if(is_user_logged_in()){ ?>   
    <div class="user_menu user_loged" id="user_menu_u">
        <?php 
        echo wpestate_header_phone();
        
        if($show_top_bar_user_login=='yes'){
            if(  class_exists( 'WooCommerce' ) ){
                $wpestate_global_payments->show_cart_icon();
            }
            ?>
            <a class="menu_user_tools dropdown" id="user_menu_trigger" data-toggle="dropdown"> 
                <a class="navicon-button x">
                    <div class="navicon"></div>
                </a>
            <div class="menu_user_picture" style="background-image: url('<?php print esc_attr($user_small_picture[0]); ?>');"></div>
        <?php } ?>
    </div> 
<?php }else{ ?>
    <div class="user_menu user_not_loged" id="user_menu_u">   
        <?php
        
        if($show_top_bar_user_login=='yes'){
            if(  class_exists( 'WooCommerce' ) ){
                $wpestate_global_payments->show_cart_icon();
            }
        ?>
        
            <a class="menu_user_tools dropdown" id="user_menu_trigger" data-toggle="dropdown">  
                <a class="navicon-button nav-notlog x">
                    <div class="navicon"></div>
                </a>
            <?php if(  esc_html ( wpresidence_get_option('wp_estate_show_submit','') ) ==='yes'){ ?>
            <a href="<?php  print wpestate_get_template_link('front_property_submit.php') ?>" class=" submit_listing"><?php esc_html_e('Add Listing','wpresidence');?></a>
            <?php } ?>   
            <div class="submit_action">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 125" enable-background="new 0 0 100 100" xml:space="preserve"><g><path d="M50,5C25.2,5,5,25.1,5,50s20.2,45,45,45s45-20.1,45-45S74.8,5,50,5z M50,26.5c7.2,0,13.1,5.9,13.1,13.1   c0,7.2-5.9,13.1-13.1,13.1s-13.1-5.9-13.1-13.1C36.9,32.4,42.8,26.5,50,26.5z M50,87.9c-12.2,0-23.1-5.8-30.1-14.8   c5.7-10.7,17.1-18,30.1-18s24.4,7.3,30.1,18C73.2,82.1,62.2,87.9,50,87.9z"/></g></svg>
            </div>
        
       <?php
        }
        
        echo wpestate_header_phone(); 
        ?>
    </div>   
<?php } ?>   
                  
 
        
        
<?php 
if ( 0 != $current_user->ID  && is_user_logged_in() ) {
    $username               =   $current_user->user_login ;
    ?> 
    <ul id="user_menu_open" class="dropdown-menu menulist topmenux" role="menu" aria-labelledby="user_menu_trigger"> 
        <?php wpestate_generate_user_menu('top'); ?>
    </ul>
<?php }?>

        
<?php 
    if(  class_exists( 'WooCommerce' ) ){
        $wpestate_global_payments->show_cart();
    }
?>
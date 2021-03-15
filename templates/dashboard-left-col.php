<?php
$current_user               =   wp_get_current_user();
$user_login                 =   $current_user->user_login;
$user_custom_picture        =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
$user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
if( $user_small_picture_id == '' ){
    $user_small_picture[0]=get_theme_file_uri('/img/default-user_1.png');
}else{
    $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'agent_picture_thumb');
    
}


?>

<div class="col-md-3 user_menu_wrapper">
    <div class="dashboard_menu_user_image">
         <div class="menu_user_picture" style="background-image: url('<?php print esc_url($user_small_picture[0]); ?>');height: 80px;width: 80px;" ></div>
         <div class="dashboard_username">
             <?php esc_html_e('Welcome back, ','wpresidence'); echo esc_html($user_login).'!';?>
         </div> 
     </div>
    <?php  get_template_part('templates/user_menu');  ?>
</div>
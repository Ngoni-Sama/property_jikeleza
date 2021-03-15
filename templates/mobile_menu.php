<?php
global $wpestate_global_payments;
$current_user               =   wp_get_current_user();
$user_custom_picture        =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
$user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
if( $user_small_picture_id == '' ){
    $user_small_picture[0]=get_theme_file_uri('/img/default_user_small.png');
}else{
    $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'user_thumb');
}
?>

<div class="mobilewrapper">
    <div class="snap-drawers">
        <!-- Left Sidebar-->
        <div class="snap-drawer snap-drawer-left">
            <div class="mobilemenu-close"><i class="fas fa-times"></i></div>
            <?php  
            
                $transient_name='wpestate_mobile_menu';
                $mobile_menu = wpestate_request_transient_cache($transient_name);
              
                if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
                    $mobile_menu=false;
                }

                if($mobile_menu===false){
                    ob_start();
                    wp_nav_menu( array( 
                        'theme_location'    =>  'mobile',               
                        'container'         =>  false,
                        'menu_class'        =>  'mobilex-menu',
                        'menu_id'           =>  'menu-main-menu'
                    ) );
                    $mobile_menu = ob_get_clean();
                    if ( !defined( 'ICL_LANGUAGE_CODE' ) ) {
                        wpestate_set_transient_cache($transient_name,$mobile_menu,60*60*4);
                    }
                }
                print trim($mobile_menu);
                    
            ?>
        </div>
    </div>
</div>


<div class="mobilewrapper-user">
    <div class="snap-drawers">
        <!-- Left Sidebar-->
        <div class="snap-drawer snap-drawer-right">
            <div class="mobilemenu-close-user"><i class="fas fa-times"></i></div>
      
            <?php
            if ( 0 != $current_user->ID  && is_user_logged_in() ) { ?> 
            
              
                <ul class="  mobile_user_menu mobilex-menu " role="menu" aria-labelledby="user_menu_trigger"> 
                    <?php
                    if(  class_exists( 'WooCommerce' ) ){
                        $wpestate_global_payments->show_cart_icon_mobile();
                    }
                    ?>
                    
                    <?php wpestate_generate_user_menu(); ?>
                </ul>
    
                <?php
                }else{
              
                    $front_end_register     =   esc_html( wpresidence_get_option('wp_estate_front_end_register','') );
                    $front_end_login        =   esc_html( wpresidence_get_option('wp_estate_front_end_login ','') );
                    $facebook_status        =   esc_html( wpresidence_get_option('wp_estate_facebook_login','') );
                    $google_status          =   esc_html( wpresidence_get_option('wp_estate_google_login','') );
                    $yahoo_status           =   esc_html( wpresidence_get_option('wp_estate_yahoo_login','') );
                    $mess                   =   '';
                    $security_nonce         =   wp_nonce_field( 'forgot_ajax_nonce-mobile', 'security-forgot-mobile',true,false );
                    ?>

                
                        <div class="login_sidebar">
                            <h3  id="login-div-title-mobile"><?php esc_html_e('Login','wpresidence');?></h3>
                            <div class="login_form" id="login-div_mobile">
                                <div class="loginalert" id="login_message_area_mobile" > </div>

                                <input type="text" class="form-control" name="log" id="login_user_mobile" placeholder="<?php esc_html_e('Username','wpresidence');?>"/>
                                <input type="password" class="form-control" name="pwd" id="login_pwd_mobile" placeholder="<?php esc_html_e('Password','wpresidence');?>"/>
                                <input type="hidden" name="loginpop" id="loginpop_wd_mobile" value="0">
                                <input type="hidden" id="security-login-mobile" name="security-login-mobile" value="<?php  echo estate_create_onetime_nonce( 'login_ajax_nonce_mobile' );?>">
     
                                <button class="wpresidence_button" id="wp-login-but-mobile"><?php esc_html_e('Login','wpresidence');?></button>
                                <div class="login-links">
                                    <a href="#" id="widget_register_mobile"><?php esc_html_e('Need an account? Register here!','wpresidence');?></a>
                                    <a href="#" id="forgot_pass_mobile"><?php esc_html_e('Forgot Password?','wpresidence');?></a>
                                    <?php 
                                    if(class_exists('Wpestate_Social_Login')){
                                        global $wpestate_social_login;
                                        $wpestate_social_login->display_form('mobile',0);
                                    }
                                   
                                    ?>
                                </div>    
                           </div>

                            <h3   id="register-div-title-mobile"><?php esc_html_e('Register','wpresidence');?></h3>
                            <div class="login_form" id="register-div-mobile">

                                <div class="loginalert" id="register_message_area_mobile" ></div>
                                <input type="text" name="user_login_register" id="user_login_register_mobile" class="form-control" placeholder="<?php esc_html_e('Username','wpresidence');?>"/>
                                <input type="text" name="user_email_register" id="user_email_register_mobile" class="form-control" placeholder="<?php esc_html_e('Email','wpresidence');?>"  />

                                <?php
                                $enable_user_pass_status= esc_html ( wpresidence_get_option('wp_estate_enable_user_pass','') );
                                if($enable_user_pass_status == 'yes'){
                                    print ' <input type="password" name="user_password" id="user_password_mobile" class="form-control" placeholder="'.esc_html__('Password','wpresidence').'"/>
                                    <input type="password" name="user_password_retype" id="user_password_mobile_retype" class="form-control" placeholder="'.esc_html__('Retype Password','wpresidence').'"  />
                                    ';
                                }
                                ?>
                                
                                <?php
                                if(1==1){
                                    $user_types = array(
                                        esc_html__('Select User Type','wpresidence'),
                                        esc_html__('User','wpresidence'),
                                        esc_html__('Single Agent','wpresidence'),
                                        esc_html__('Agency','wpresidence'),
                                        esc_html__('Developer','wpresidence'),
                                    );

                                    $permited_roles             = wpresidence_get_option('wp_estate_visible_user_role');
                                    $visible_user_role_dropdown = wpresidence_get_option('wp_estate_visible_user_role_dropdown');
                                    if($visible_user_role_dropdown=='yes'){
                                        print '<select id="new_user_type_mobile" name="new_user_type_mobile" class="form-control" >';
                                        print '<option value="0">'.esc_html__('Select User Type','wpresidence').'</option>';
                                        if(is_array($permited_roles)){
                                            foreach($user_types as $key=>$name){
                                                if(in_array($name, $permited_roles)){
                                                    print '<option value="'.esc_attr($key).'">'.esc_html($name).'</option>';
                                                }
                                            }
                                        }
                                        print '</select>';
                                    }
                                }

                                ?>                               
                                

                                <input type="checkbox" name="terms" id="user_terms_register_mobile" />
                                <label id="user_terms_register_mobile_label" for="user_terms_register_mobile"><?php esc_html_e('I agree with ','wpresidence');?><a href="<?php print wpestate_get_template_link('terms_conditions.php');?> " target="_blank" id="user_terms_register_mobile_link"><?php esc_html_e('terms & conditions','wpresidence');?></a> </label>
                                
                                <?php
                                if(wpresidence_get_option('wp_estate_use_captcha','')=='yes'){
                                    print '<div id="mobile_register_menu"  style="float:left;transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>';
                                }
                                ?>
                                
                                <?php   if($enable_user_pass_status != 'yes'){  ?>
                                    <p id="reg_passmail_mobile"><?php esc_html_e('A password will be e-mailed to you','wpresidence');?></p>
                                <?php } ?>

                                <?php //wp_nonce_field( 'register_ajax_nonce_mobile', 'security-register-mobile',true );?>   
                                <input type="hidden" id="security-register-mobile" name="security-register-mobile" value="<?php  echo estate_create_onetime_nonce( 'register_ajax_nonce_mobile' );?>">
      
                                <button class="wpresidence_button" id="wp-submit-register_mobile" ><?php esc_html_e('Register','wpresidence');?></button>
                                <div class="login-links">
                                    <a href="#" id="widget_login_mobile"><?php esc_html_e('Back to Login','wpresidence');?></a>                       
                                </div>   
                            </div>

                            <h3  id="forgot-div-title-mobile"><?php esc_html_e('Reset Password','wpresidence');?></h3>
                            <div class="login_form" id="forgot-pass-div-mobile">
                                <div class="loginalert" id="forgot_pass_area_mobile"></div>
                                <div class="loginrow">
                                        <input type="text" class="form-control" name="forgot_email" id="forgot_email_mobile" placeholder="<?php esc_html_e('Enter Your Email Address','wpresidence');?>" size="20" />
                                </div>
                                <?php echo trim($security_nonce);?>   
                                <input type="hidden" id="postid-mobile" value="<?php if( isset($post_id) ) { echo intval($post_id); }?>">    
                                <button class="wpresidence_button" id="wp-forgot-but-mobile" name="forgot" ><?php esc_html_e('Reset Password','wpresidence');?></button>
                                <div class="login-links shortlog">
                                <a href="#" id="return_login_mobile"><?php esc_html_e('Return to Login','wpresidence');?></a>
                                </div>
                            </div>


                        </div>
                   
                    <?php }?>
            
        </div>
    </div>
</div>
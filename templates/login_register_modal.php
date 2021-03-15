<?php
$front_end_register     =   esc_html( wpresidence_get_option('wp_estate_front_end_register','') );
$front_end_login        =   esc_html( wpresidence_get_option('wp_estate_front_end_login ','') );
$facebook_status        =   esc_html( wpresidence_get_option('wp_estate_facebook_login','') );
$google_status          =   esc_html( wpresidence_get_option('wp_estate_google_login','') );
$yahoo_status           =   esc_html( wpresidence_get_option('wp_estate_yahoo_login','') );
$mess                   =   '';
$security_nonce         =   wp_nonce_field( 'forgot_ajax_nonce-topbar', 'security-forgot-topbar',true,false );
global $post;
?>

<div id="modal_login_wrapper">

    <div class="modal_login_back"></div>
    <div class="modal_login_container">

        <div id="login-modal_close"></div>

            <div   id="login-div-title-topbar"><?php esc_html_e('Sign into your account','wpresidence');?></div>
            
            <div class="login_form" id="login-div_topbar">
                <div class="loginalert" id="login_message_area_topbar" > </div>

                <input type="text" class="form-control" name="log" id="login_user_topbar" placeholder="<?php esc_html_e('Username','wpresidence');?>"/>
                <input type="password" class="form-control" name="pwd" id="login_pwd_topbar" placeholder="<?php esc_html_e('Password','wpresidence');?>"/>
                <input type="hidden" name="loginpop" id="loginpop_wd_topbar" value="0">
                <?php //wp_nonce_field( 'login_ajax_nonce_topbar', 'security-login-topbar',true);?>   
                <input type="hidden" id="security-login-topbar" name="security-login-topbar" value="<?php  echo estate_create_onetime_nonce( 'login_ajax_nonce_topbar' );?>">

                <button class="wpresidence_button" id="wp-login-but-topbar"><?php esc_html_e('Login','wpresidence');?></button>
                <div class="login-links">
                   
                    <?php 
                    if( $facebook_status=='yes' || $google_status=='yes' || $yahoo_status=='yes' ){ 
                        echo '<div class="or_social">'.esc_html__('or','wpresidence').'</div>';
                        if(class_exists('Wpestate_Social_Login')){
                            global $wpestate_social_login;
                            $wpestate_social_login->display_form('topbar',0);
                        }
                    }                
                   
                    ?>
                </div>    
           </div>

            <div  id="register-div-title-topbar"><?php esc_html_e('Create an account','wpresidence');?></div>
            <div class="login_form" id="register-div-topbar">

                <div class="loginalert" id="register_message_area_topbar" ></div>
                <input type="text" name="user_login_register" id="user_login_register_topbar" class="form-control" placeholder="<?php esc_html_e('Username','wpresidence');?>"/>
                <input type="text" name="user_email_register" id="user_email_register_topbar" class="form-control" placeholder="<?php esc_html_e('Email','wpresidence');?>"  />

                <?php
                $enable_user_pass_status= esc_html ( wpresidence_get_option('wp_estate_enable_user_pass','') );
                if($enable_user_pass_status == 'yes'){
                    print ' <input type="password" name="user_password" id="user_password_topbar" class="form-control" placeholder="'.esc_html__('Password','wpresidence').'"/>
                    <input type="password" name="user_password_retype" id="user_password_topbar_retype" class="form-control" placeholder="'.esc_html__('Retype Password','wpresidence').'"  />
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
                    
                    $permited_roles             = wpresidence_get_option('wp_estate_visible_user_role','');
                    $visible_user_role_dropdown = wpresidence_get_option('wp_estate_visible_user_role_dropdown','');
                
                    
                    if($visible_user_role_dropdown=='yes'){
                        print '<select id="new_user_type_topbar" name="new_user_type_topbar" class="form-control" >';
                        print '<option value="0">'.esc_html__('Select User Type','wpresidence').'</option>';
                        foreach($user_types as $key=>$name){
                            if(is_array($permited_roles)){
                                if(in_array($name, $permited_roles)){
                                    print '<option value="'.esc_attr($key).'">'.esc_html($name).'</option>';
                                }
                            }
                        }
                        print '</select>';
                    }
                }
                
                ?>

                <input type="checkbox" name="terms" id="user_terms_register_topbar" />
                <label id="user_terms_register_topbar_label" for="user_terms_register_topbar"><?php esc_html_e('I agree with ','wpresidence');?><a href="<?php print wpestate_get_template_link('terms_conditions.php');?> " target="_blank" id="user_terms_register_topbar_link"><?php esc_html_e('terms & conditions','wpresidence');?></a> </label>

                <?php
                if(wpresidence_get_option('wp_estate_use_captcha','')=='yes'){
                    print '<div id="top_register_menu" style="float:left;transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>';
                }
                ?>

                <?php   if($enable_user_pass_status != 'yes'){  ?>
                    <p id="reg_passmail_topbar"><?php esc_html_e('A password will be e-mailed to you','wpresidence');?></p>
                <?php } ?>

                <input type="hidden" id="security-register-topbar" name="security-register-topbar" value="<?php  echo estate_create_onetime_nonce( 'register_ajax_nonce_topbar' );?>">
                <button class="wpresidence_button" id="wp-submit-register_topbar" ><?php esc_html_e('Register','wpresidence');?></button>
              
            </div>

            <div   id="forgot-div-title-topbar"><?php esc_html_e('Reset Password','wpresidence');?></div>
            <div class="login_form" id="forgot-pass-div">
                <div class="loginalert" id="forgot_pass_area_topbar"></div>
                <div class="loginrow">
                        <input type="text" class="form-control" name="forgot_email" id="forgot_email_topbar" placeholder="<?php esc_html_e('Enter Your Email Address','wpresidence');?>" size="20" />
                </div>
                <?php echo trim($security_nonce);?>  
                <input type="hidden" id="postid" value="
                <?php  if( isset($post->ID) ){
                        echo intval($post->ID);
                    }
                ?>">    
                <button class="wpresidence_button" id="wp-forgot-but-topbar" name="forgot" ><?php esc_html_e('Reset Password','wpresidence');?></button>
               
            </div>

            <div class="login_modal_control">
                <a href="#" id="widget_register_topbar"><?php esc_html_e('Register here!','wpresidence');?></a>
                <a href="#" id="forgot_pass_topbar"><?php esc_html_e('Forgot Password?','wpresidence');?></a>
                
                <a href="#" id="widget_login_topbar"><?php esc_html_e('Back to Login','wpresidence');?></a>  
                <a href="#" id="return_login_topbar"><?php esc_html_e('Return to Login','wpresidence');?></a>
                 <input type="hidden" name="loginpop" id="loginpop" value="0">
            </div>
            
    </div>
    
</div>
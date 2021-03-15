<?php
$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$parent_userID          =   wpestate_check_for_agency($userID);
$user_login             =   $current_user->user_login;  
$add_link               =   wpestate_get_template_link('user_dashboard_add.php');
$dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
$dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
$dash_link              =   wpestate_get_template_link('user_dashboard.php');
$activeprofile          =   '';
$activedash             =   '';
$activeadd              =   '';
$activefav              =   '';
$user_pack              =   get_the_author_meta( 'package_id' , $parent_userID );    
$clientId               =   esc_html( wpresidence_get_option('wp_estate_paypal_client_id','') );
$clientSecret           =   esc_html( wpresidence_get_option('wp_estate_paypal_client_secret','') );  
$user_registered        =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $parent_userID );
$is_membership          =   0;
$paid_submission_status = esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );  
$user_role = get_user_meta( $current_user->ID, 'user_estate_role', true) ;

?>


<div class="col-md-12 top_dahsboard_wrapper dashboard_package_row"> 
<?php
if ($paid_submission_status == 'membership'){
    wpestate_get_pack_data_for_user_top($parent_userID,$user_pack,$user_registered,$user_package_activation); 
    $is_membership=1;     
}

?>

<?php
if (    $is_membership==1  ){ 
    $stripe_profile_user    =   get_user_meta($userID,'stripe',true);
    $subscription_id        =   get_user_meta( $userID, 'stripe_subscription_id', true );
    $enable_stripe_status   =   esc_html ( wpresidence_get_option('wp_estate_enable_stripe','') );
 

    if( $stripe_profile_user!='' && $subscription_id!='' && $enable_stripe_status==='yes'){
        echo '<span id="stripe_cancel" data-original-title="'.esc_attr__('subscription will be cancelled at the end of current period','wpresidence').'" data-stripeid="'.esc_attr($userID).'">'.esc_html__('cancel stripe subscription','wpresidence').'</span>';
        $ajax_nonce = wp_create_nonce( "wpestate_stripe_cancel_nonce" );
        print'<input type="hidden" id="wpestate_stripe_cancel_nonce" value="'.esc_html($ajax_nonce).'" />    ';
        
    }
    ?>
    <?php if($userID==$parent_userID){?>
    <div class="pack_description ">
        <?php 
        print '<div id="open_packages" class="wrapper_packages">'.esc_html__('See Available Packages and Payment Methods', 'wpresidence');
        print ' '.'<i class="fas fa-angle-up" aria-hidden="true"></i>'.'</div>';
        ?>
    </div>

     
        <div class="pack_description_row ">
            <div class="add-estate profile-page profile-onprofile row"> 
                <div class="pack-unit">
                    <div class="pack_description_unit_head">     
                        <?php print '<h4>'.esc_html__('Packages Available', 'wpresidence').'</h4>'; ?>
                    </div>    

                    <?php
                    $user_role          =   get_user_meta( $userID, 'user_estate_role', true) ;
                    if( intval($user_role) ==0 ){
                        $user_role=0;
                    }else{
                        $user_role          =   $user_role-1;
                    }
                  
                    $roles              =   array( esc_html__('User','wpresidence') ,esc_html__('Agent','wpresidence'),esc_html__('Agency','wpresidence'),esc_html__('Developer','wpresidence'));
                    $user_role          =   $roles[$user_role];
                    
                    
                    $user_role_array    =   array(
                                                'key'       => 'pack_visible_user_role',
                                                'value'     => $user_role,
                                                'compare'   => 'LIKE',
                                            );
                    
                    $wpestate_currency           =   esc_html( wpresidence_get_option('wp_estate_submission_curency', '') );
                    $where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
                    $args = array(
                        'post_type'         => 'membership_package',
                        'posts_per_page'    => -1,
                        'meta_query'        =>  array(
                                                    array(
                                                        'key' => 'pack_visible',
                                                        'value' => 'yes',
                                                        'compare' => '=',
                                                    ),
                                                )
                    );
                    
                    
                    if($user_role!=''){
                       $args['meta_query'][]= $user_role_array;
                    }
                    
                 
                    $pack_selection = new WP_Query($args);

                    while($pack_selection->have_posts() ){
                        $pack_selection->the_post();
                        $postid                 = $post->ID;
                        $pack_list              = get_post_meta($postid, 'pack_listings', true);
                        $pack_featured          = get_post_meta($postid, 'pack_featured_listings', true);
                        $pack_image_included    = get_post_meta($postid, 'pack_image_included', true);
                        $pack_price             = get_post_meta($postid, 'pack_price', true);
                        $unlimited_lists        = get_post_meta($postid, 'mem_list_unl', true);
                        $biling_period          = get_post_meta($postid, 'biling_period', true);
                        $billing_freq           = get_post_meta($postid, 'billing_freq', true);
                        $pack_time              = get_post_meta($postid, 'pack_time', true);
                        $unlimited_listings     = get_post_meta($postid, 'mem_list_unl', true);

                        if($billing_freq>1){
                            $biling_period.='s';
                        }
                        if ($where_currency == 'before') {
                            $price = $wpestate_currency . ' ' . $pack_price;
                        }else {
                            $price = $pack_price . ' ' . $wpestate_currency;
                        }
                        if (intval($pack_image_included)==0){
                            $pack_image_included=esc_html__('Unlimited', 'wpresidence');
                        }

                        $title = get_the_title();
                        print'<div class="pack-listing" data-id="'.esc_attr($postid).'">';
                            print'<div class="pack-listing-title" data-stripetitle2="'.esc_attr($title).'"  data-stripetitle="'.esc_attr($title).' '.esc_attr__('Package Payment','wpresidence').'" data-stripepay="'.esc_attr($pack_price*100).'" data-packprice="'.esc_attr($pack_price).'" data-packid="'.esc_attr($postid).'">'.esc_html($title).' </div>';
                            print'<div class="submit-price">'.esc_html($price).' / '.esc_html($billing_freq).' '.wpestate_show_bill_period($biling_period).'</div>';

                            if($unlimited_listings==1){
                                print'<div class="pack-listing-period">'.esc_html__('Unlimited', 'wpresidence').' '.esc_html__('listings ', 'wpresidence').' </div>';
                            }else{
                                print'<div class="pack-listing-period">'.esc_html($pack_list).' '.esc_html__('Listings', 'wpresidence').' </div>';
                            }
                            print'<div class="pack-listing-period">'.esc_html($pack_featured).' '.esc_html__('Featured', 'wpresidence').'</div> ';
                            print'<div class="pack-listing-period">'.esc_html($pack_image_included).' '.esc_html__('Images / per listing', 'wpresidence').'</div> ';

                        print'<div class="buypackage">';
                            print'<input type="checkbox" name="packagebox" id="pack_box" value="1" style="display:block;" />'.esc_html__('Switch to this package', 'wpresidence');  
                        print '</div>';
                        print'</div>';//end pack listing;
                    }//end while 
                    wp_reset_query();?>
                </div>
            </div>
        </div>

        <div class="pack_description_row ">
            <div class="add-estate profile-page profile-onprofile row"> 
                <div class="pack-unit">
                    <?php
                    global $wpestate_global_payments;
                    if($wpestate_global_payments->is_woo!='yes'){
                    ?>
                    
                        <div class="pack_description_unit_head">
                            <?php  print '<h4>'.esc_html__('Payment Method','wpresidence').'</h4>'; ?>
                        </div>
                    <?php } ?>
                    

                    <div id="package_pick">
                            <?php
                          
                            
                            if($wpestate_global_payments->is_woo=='yes'){
                                $wpestate_global_payments->show_button_pay('','','',0,5);
                            }else{ ?>
                                <div class="recuring_wrapper">
                                    <input type="checkbox" name="pack_recuring" id="pack_recuring" value="1" style="display:block;" /> 
                                    <label for="pack_recurring"><?php esc_html_e('make payment recurring ','wpresidence');?></label>
                                </div>

                                <?php
                                $enable_paypal_status= esc_html ( wpresidence_get_option('wp_estate_enable_paypal','') );
                                $enable_stripe_status= esc_html ( wpresidence_get_option('wp_estate_enable_stripe','') );
                                $enable_direct_status= esc_html ( wpresidence_get_option('wp_estate_enable_direct_pay','') );


                                if($enable_paypal_status==='yes'){
                                    print '<div id="pick_pack"></div>';
                                }
                                if($enable_stripe_status==='yes'){
                                    wpestate_show_stripe_form_membership();
                                }

                                if($enable_direct_status==='yes'){
                                    print '<div id="direct_pay" class="wpresidence_button">'.esc_html__('Wire Transfer','wpresidence').'</div>';
                                }
                            }
                                
                                
                                
                            $ajax_nonce = wp_create_nonce( "wpresidence_simple_pay_actions_nonce" );
                            print'<input type="hidden" id="wpresidence_simple_pay_actions_nonce" value="'.esc_html($ajax_nonce).'" />    ';

                            ?>
                    </div>
                </div> 
            </div>
        </div>
    
        <?php } ?>
   
<?php } ?>
</div>



            
<?php
function wpestate_show_bill_period($biling_period){

    if($biling_period=='Day' || $biling_period=='Days'){
        return  esc_html__('days','wpresidence');
    }
    else if($biling_period=='Week' || $biling_period=='Weeks'){
       return  esc_html__('weeks','wpresidence');
    }
    else if($biling_period=='Month' || $biling_period=='Months'){
        return  esc_html__('months','wpresidence');
    }
    else if($biling_period=='Year'){
        return  esc_html__('year','wpresidence');
    }else if($biling_period=='Years'){
        return  esc_html__('years','wpresidence');
    }

}
?>       
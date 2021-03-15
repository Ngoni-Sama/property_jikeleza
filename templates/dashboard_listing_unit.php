<?php
global $edit_link;
global $token;
global $processor_link;
global $paid_submission_status;
global $submission_curency_status;
global $price_submission;
global $floor_link;
global $user_pack;
global $user_login;

$post_id                    =   get_the_ID();
$featured                   =   intval  ( get_post_meta($post_id, 'prop_featured', true) );
$preview                    =   wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'property_listings');
$edit_link                  =   esc_url_raw(add_query_arg( 'listing_edit', $post_id, $edit_link )) ;
$floor_link                 =   esc_url_raw(add_query_arg( 'floor_edit', $post_id,  $floor_link )) ;
$post_status                =   get_post_status($post_id);
$property_address           =   esc_html ( get_post_meta($post_id, 'property_address', true) );
$property_city              =   get_the_term_list($post_id, 'property_city', '', ', ', '') ;
$property_category          =   get_the_term_list($post_id, 'property_category', '', ', ', '');
$property_action_category   =   get_the_term_list($post_id, 'property_action_category', '', ', ', '');
$price_label                =   esc_html ( get_post_meta($post_id, 'property_label', true) );
$price_label_before         =   esc_html ( get_post_meta($post_id, 'property_label_before', true) );
$price                      =   floatval( get_post_meta($post->ID, 'property_price', true) );
$wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_submission_curency', '') );
$currency_title             =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$status                     =   '';
$link                       =   '';
$pay_status                 =   '';
$is_pay_status              =   '';
$paid_submission_status     =   esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
$price_submission           =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
$price_featured_submission  =   floatval( wpresidence_get_option('wp_estate_price_featured_submission','') );
$th_separator               =   stripslashes ( wpresidence_get_option('wp_estate_prices_th_separator','') );
$no_views                   =   intval( get_post_meta($post_id, 'wpestate_total_views', true));
if ($price != 0) {
    if( $price == intval($price)){            
        $price = number_format($price,0,'.',$th_separator);
    }else{
        $price = number_format($price,2,'.',$th_separator);
    }
   
   if ($where_currency == 'before') {
       $price_title =   $currency_title . ' ' . $price;
       $price       =   $wpestate_currency . ' ' . $price;
   } else {
       $price_title = $price . ' ' . $currency_title;
       $price       = $price . ' ' . $wpestate_currency;
     
   }
}else{
    $price='';
    $price_title='';
}



if($post_status=='expired'){ 
    $status='<span class="label label-danger">'.esc_html__('Expired','wpresidence').'</span>';
}else if($post_status=='publish'){ 
    $link= esc_url( get_permalink() );
    $status='<span class="label label-success">'.esc_html__('Published','wpresidence').'</span>';
}else if($post_status=='disabled'){
    $link='';
    $status='<span class="label label-info">'.esc_html__('Disabled','wpresidence').'</span>';
}else{
    $link='';
    $status='<span class="label label-info">'.esc_html__('Waiting for approval','wpresidence').'</span>';
}


if ($paid_submission_status=='per listing'){
    $pay_status    = get_post_meta(get_the_ID(), 'pay_status', true);
    if($pay_status=='paid'){
        $is_pay_status.='<span class="label label-success">'.esc_html__('Paid','wpresidence').'</span>';
    }
    if($pay_status=='not paid'){
        $is_pay_status.='<span class="label label-info">'.esc_html__('Not Paid','wpresidence').'</span>';
    }
}
$featured  = intval  ( get_post_meta($post->ID, 'prop_featured', true) );


$free_feat_list_expiration  =   intval ( wpresidence_get_option('wp_estate_free_feat_list_expiration','') );
$pfx_date                   =   strtotime ( get_the_date("Y-m-d",  $post->ID ) );
$expiration_date            =   $pfx_date+$free_feat_list_expiration*24*60*60;
?>



<div class="col-md-12 row_dasboard-prop-listing property_wrapper_dash">
    <div class="col-md-12 dasboard-prop-listing">
     
        <?php
        $author = get_the_author();
        if($user_login!=$author){
            print '   <div class="dashboard_unit_author_info">'.esc_html__('by','wpresidence').' '.esc_html($author).'  </div>';
        }
        ?>
      
        <div class="blog_listing_image">
           <?php
            if($featured==1){
                print '<div class="featured_div">'.esc_html__('Featured','wpresidence').'</div>';
            }
            if (has_post_thumbnail($post_id)){
            ?>
                <a href="<?php print esc_url($link); ?>"><img  src="<?php  print esc_url($preview[0]); ?>" /></a>
            <?php 
            } 
            ?>
        </div>

        <div class="user_dashboard_status">
            <?php print trim($status.$is_pay_status);?>      
        </div>
        
        <div class="prop-info">
            <h4 class="listing_title">
                <a href="<?php print esc_url($link); ?>">
                    <?php 
                    $title=get_the_title();
                    echo mb_substr( $title,0,40); 
                    if(mb_strlen($title)>40){
                        echo '...';   
                    } ?>
                </a> 
            </h4>

            <div class="user_dashboard_listed">
                <?php print esc_html__('Price','wpresidence').': <span class="price_label">'.esc_html($price_label_before).' '.esc_html($price_title).' '.esc_html($price_label).'</span>';?>
                <?php 
                if ( $paid_submission_status=='membership' && $user_pack=='') {
                    echo ' | ' ;esc_html_e('expires on ','wpresidence');echo date("Y-m-d",$expiration_date);
                } ?>
            </div>

            <div class="user_dashboard_listed">
                <?php esc_html_e('Listed in','wpresidence');?>  
                <?php print wp_kses_post($property_action_category); ?> 
                <?php 
                    if( $property_action_category!='') {
                        print' '.esc_html__('and','wpresidence').' ';
                    } 
                    print wp_kses_post($property_category);
                ?>                     
            </div>

            <div class="user_dashboard_listed">
                <?php print esc_html__('City','wpresidence').': ';?>            
                <?php print get_the_term_list($post_id, 'property_city', '', ', ', '');?>
                <?php print ', '.esc_html__('Area','wpresidence').': '?>
                <?php print get_the_term_list($post_id, 'property_area', '', ', ', '');?>          
            </div>

            <?php
            $defaults = array(
                'echo'   => false,
            );
            ?>
            <div class="info-container">
                <a  data-original-title="<?php esc_attr_e('Edit property','wpresidence');?>"   class="dashboad-tooltip" href="<?php  print esc_url($edit_link);?>"><i class="fas fa-pen-square editprop"></i></a>
                <a  data-original-title="<?php esc_attr_e('Delete property','wpresidence');?>" class="dashboad-tooltip" onclick="return confirm(' <?php echo esc_html__('Are you sure you wish to delete ','wpresidence').the_title_attribute($defaults); ?>?')" href="<?php print esc_url_raw(add_query_arg( 'delete_id', $post_id, wpestate_get_template_link('user_dashboard.php') ) );?>"><i class="fas fa-times deleteprop"></i></a>  
                <a  data-original-title="<?php esc_attr_e('Floor Plans','wpresidence');?>"   class="dashboad-tooltip" href="<?php  print esc_url($floor_link);?>"><i class="fa  fa-book editprop"></i></a>
                <?php if ($no_views>0){ ?>
                <a  data-original-title="<?php esc_attr_e('Views Stats','wpresidence');?>"   class="dashboad-tooltip show_stats"  data-listingid="<?php echo intval($post_id);?>" href="#"><i class="fas fa-eye-slash"></i></a>
                <?php }else{ ?>
                    <a  data-original-title="<?php esc_attr_e('Item has 0 views','wpresidence');?>"   class="dashboad-tooltip show_statsx"  data-listingid="<?php echo intval($post_id);?>" href="#"><i class="fas fa-eye-slash"></i></a>
                <?php }?>
                <?php
                    if( $post_status == 'expired' ){ 
                       print'<a data-original-title="'.esc_attr__('Resend for approval','wpresidence').'" class="dashboad-tooltip resend_pending" data-listingid="'.intval($post_id).'"><i class="fas fa-upload"></i></a>';   
                    }
                ?>    

                <?php
                   if( $post_status == 'publish' ){ 
                       print ' <span  data-original-title="'.esc_attr__('Disable Listing','wpresidence').'" class="dashboad-tooltip disable_listing disabledx" data-postid="'.intval($post_id).'" ><i class="fas fa-pause"></i></span>';
                   }else if($post_status=='disabled') {
                       print ' <span  data-original-title="'.esc_attr__('Enable Listing','wpresidence').'" class="dashboad-tooltip disable_listing" data-postid="'.intval($post_id).'" ><i class="fas fa-play"></i></span>';

                   }
                ?>

                <?php
                $no_payment='';
                if($paid_submission_status=='membership'){
                    $no_payment=' no_payment ';
                    if ( intval(get_post_meta($post_id, 'prop_featured', true))==1){
                         print '<span class="label label-success">'.esc_html__('Property is featured','wpresidence').'</span>';       
                    }
                    else{
                        print ' <span  data-original-title="'.esc_attr__('Set as featured,  *Listings set as featured are subtracted from your package','wpresidence').'" class="dashboad-tooltip make_featured" data-postid="'.intval($post_id).'" ><i class="fas fa-star favprop"></i></span>';
                    }
                }

                if($paid_submission_status=='no'){
                     $no_payment=' no_payment ';
                }

                ?>

            </div>

            </div>
            <div class="payment-container <?php echo esc_html($no_payment); ?>">
                <?php $pay_status    = get_post_meta($post_id, 'pay_status', true);
                    if( $post_status == 'expired' ){ 
                        
                    }else{

                        if($paid_submission_status=='per listing'){
                            $enable_paypal_status= esc_html ( wpresidence_get_option('wp_estate_enable_paypal','') );
                            $enable_stripe_status= esc_html ( wpresidence_get_option('wp_estate_enable_stripe','') );
                            $enable_direct_status= esc_html ( wpresidence_get_option('wp_estate_enable_direct_pay','') );

                            if($pay_status!='paid' ){
                                print' 
                                    <div class="listing_submit">'.esc_html__('Submission Fee','wpresidence').': <span class="submit-price submit-price-no">'.esc_html($price_submission).'</span><span class="submit-price"> '.esc_html($wpestate_currency).'</span></br></div>'; 
                                   
                                    global $wpestate_global_payments;
                                    if($wpestate_global_payments->is_woo=='yes'){
                                        $wpestate_global_payments->show_button_pay($post_id,'','',$price_submission,2);
                                    }else{
                                        $stripe_class='';
                                        if($enable_paypal_status==='yes'){
                                            $stripe_class=' stripe_paypal ';
                                            print ' <div class="listing_submit_normal label label-danger" data-listingid="'.intval($post_id).'">'.esc_html__('Pay with Paypal','wpresidence').'</div>';
                                        }

                                        if($enable_stripe_status==='yes'){
                                            wpestate_show_stripe_form_per_listing($stripe_class,$post_id,$price_submission,$price_featured_submission);
                                        }
                                        if($enable_direct_status=='yes'){
                                            print '<div data-listing="'.intval($post_id).'" class="perpack">'.esc_html__('Wire Transfer','wpresidence').'</div>';
                                        }
                                    }

                            }else{
                                if ( intval(get_post_meta($post_id, 'prop_featured', true))==1){
                                    print '<span class="label label-success featured_label">'.esc_html__('Property is featured','wpresidence').'</span>';  
                                }else{
                                     print' 
                                     <div class="listing_submit upgrade_post">
                                    '.esc_html__('Featured  Fee','wpresidence').': <span class="submit-price submit-price-total">'.esc_html($price_featured_submission).'</span> <span class="submit-price">'.esc_html($wpestate_currency).'</span>  </br> ';
                                    print  '</div>'; 

                                    if($wpestate_global_payments->is_woo=='yes'){
                                        $wpestate_global_payments->show_button_pay($post_id,'','',$price_featured_submission,3);
                                    }else{
                                        $stripe_class='';
                                        if($enable_paypal_status==='yes'){
                                            print'<span class="listing_upgrade label label-danger" data-listingid="'.intval($post_id).'">'.esc_html__('Upgrade to featured','wpresidence').' - '.esc_html($price_featured_submission).' '.esc_html($wpestate_currency).'</span>'; 
                                        }
                                        if($enable_stripe_status==='yes'){
                                            wpestate_show_stripe_form_upgrade($stripe_class,$post_id,$price_submission,$price_featured_submission);
                                        }
                                        if($enable_direct_status=='yes'){
                                            print '<div data-listing="'.intval($post_id).'" data-isupgrade="1" class="perpack">'.esc_html__('Upgrade to featured','wpresidence').'</div>';
                                        }
                                    }
                                } 
                            }
                        }

                    }?></div>


        <div class="statistics_wrapper">
            <div class="statistics_wrapper_total_views">
                <?php esc_html_e('Total number of views:','wpresidence'); echo esc_html($no_views); ?>
            </div>
            <canvas class="my_chart_dash" id="myChart_<?php echo esc_html($post_id);?>"></canvas>
        </div>   
    </div>
</div>
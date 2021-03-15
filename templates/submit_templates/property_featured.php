<?php 
global $prop_featured;
global $prop_featured_check;
global $userID;

$paid_submission_status= esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );

if ( ( $paid_submission_status == 'membership' && wpestate_get_remain_featured_listing_user($userID)>0 )){ ?>  
    <div class="submit_container">  
    <div class="submit_container_header"><?php  esc_html_e('Featured Submission','wpresidence');?></div>
    <div class="user_dashboard_box">
        <p class="meta-options full_form-nob"> 
          <?php esc_html_e('Make this listing featured from property list.','wpresidence')?>
        </p> 
    </div>
    </div>
<?php 
}elseif( $paid_submission_status == 'no' ){
    //print '<input type="hidden"  id="prop_featured"  name="prop_featured"  value="0" > ';
} else{

    // print '<input type="hidden"  id="prop_featured"  name="prop_featured"  value="'.$prop_featured.'"  '.$prop_featured_check.' > ';
}
?> 
            
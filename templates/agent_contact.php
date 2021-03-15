<?php

global $propid;


if(isset($slider_property_id) && intval($slider_property_id)!=0){
    $propid=$slider_property_id;
}



$agent_id   = intval( get_post_meta($propid, 'property_agent', true) );

if(is_singular('estate_agent') ||is_singular('estate_agency') || is_singular('estate_developer')){
    $agent_id = get_the_ID();
}

$contact_form_7_agent   =   stripslashes( ( wpresidence_get_option('wp_estate_contact_form_7_agent','') ) );
$contact_form_7_contact =   stripslashes( ( wpresidence_get_option('wp_estate_contact_form_7_contact','') ) );
if (function_exists('icl_translate') ){
    $contact_form_7_agent     =   icl_translate('wpestate','contact_form7_agent', $contact_form_7_agent ) ;
    $contact_form_7_contact   =   icl_translate('wpestate','contact_form7_contact', $contact_form_7_contact ) ;
}
?>
  
<div class="agent_contanct_form ">
    <?php    
    if ( basename(get_page_template())!='contact_page.php') { ?>
        <?php
        if(is_singular('estate_agency')|| is_singular('estate_developer') ){
           echo '<h4 id="show_contact">'.esc_html__('Contact Us', 'wpresidence').'</h4>';
        }else{
            echo '<h4 id="show_contact">'.esc_html__('Contact Me', 'wpresidence').'</h4>';
        }
        ?>
       
        <?php 
        if( $contact_form_7_agent ==''){ 
        ?>
            <div  class="schedule_meeting"><?php esc_html_e('Schedule a showing?','wpresidence');?></div>    
        <?php 
        } 
        ?>


    <?php }else{ ?>
        <h4 id="show_contact"><?php esc_html_e('Contact Us', 'wpresidence'); ?></h4>
        
       
    <?php } ?>

    <?php if ( ($contact_form_7_agent =='' && basename(get_page_template())!='contact_page.php') || ( $contact_form_7_contact=='' && basename(get_page_template())=='contact_page.php')  ){ ?>


        <div class="alert-box error">
          <div class="alert-message" id="alert-agent-contact"></div>
        </div> 

        <div class="schedule_wrapper ">    
            <div class="col-md-6">
                <input name="schedule_day" class="schedule_day" type="text"  placeholder="<?php esc_html_e('Day', 'wpresidence'); ?>" aria-required="true" class="form-control">
            </div>
               
            <div class="col-md-6">
                <select name="schedule_hour" id="schedule_hour" class="form-control">
                    <option value="0"><?php esc_html_e('Time','wpresidence');?></option>
                    <?php
                    for ($i=7; $i <= 19; $i++){
                        for ($j = 0; $j <= 45; $j+=15){
                            $show_j=$j;
                            if($j==0){
                                $show_j='00';
                            }

                            $val =$i.':'.$show_j;
                            echo '<option value="'.esc_attr($val).'">'.esc_html($val).'</option>';
                        }
                    }
                    ?>
                </select>       
            </div>    
        </div>
  
  
        <input name="contact_name" id="agent_contact_name" type="text"  placeholder="<?php esc_html_e('Your Name', 'wpresidence'); ?>" 
               aria-required="true" class="form-control">
        <input type="text" name="email" class="form-control" id="agent_user_email" aria-required="true" placeholder="<?php esc_html_e('Your Email', 'wpresidence'); ?>" >
        <input type="text" name="phone"  class="form-control" id="agent_phone" placeholder="<?php esc_html_e('Your Phone', 'wpresidence'); ?>" >

        <textarea id="agent_comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true"><?php         
            if(is_singular('estate_property') || isset($slider_property_id) ){
                esc_html_e("I'm interested in","wpresidence");
                echo ' [ '.get_the_title($propid).' ] ';
            }
            ?></textarea>	
        
        <?php
        wpestate_check_gdpr_case();
        ?>

        <input type="submit" class="wpresidence_button agent_submit_class "  id="agent_submit" value="<?php esc_html_e('Send Email', 'wpresidence');?>">
        <?php if( wpresidence_get_option('wp_estate_enable_direct_mess')=='yes'){ ?>
            <input type="submit" class="wpresidence_button message_submit"   value="<?php esc_html_e('Send Private Message', 'wpresidence');?>">
            <div class=" col-md-12 message_explaining"><?php esc_html_e('You can reply to private messages from "Inbox" page in your user account.','wpresidence');?></div>
        <?php } ?>
     
        <input name="prop_id" type="hidden"  id="agent_property_id" value="<?php echo intval($propid);?>">
        <input name="prop_id" type="hidden"  id="agent_id" value="<?php echo intval($agent_id);?>">
        <input type="hidden" name="contact_ajax_nonce" id="agent_property_ajax_nonce"  value="<?php echo wp_create_nonce( 'ajax-property-contact' );?>" />

    <?php 
    }else{
        if ( basename(get_page_template())=='contact_page.php') {
          //  $contact_form_7_contact = stripslashes( ( wpresidence_get_option('wp_estate_contact_form_7_contact','') ) );
            echo do_shortcode($contact_form_7_contact);
        }else{
            wp_reset_query();
            echo do_shortcode($contact_form_7_agent);
        }

    }
    ?>
</div>
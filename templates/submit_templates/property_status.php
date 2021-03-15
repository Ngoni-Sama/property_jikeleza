<?php
global $property_status;
global $wpestate_submission_page_fields;
?>

<?php if ( is_array($wpestate_submission_page_fields) && in_array('property_status', $wpestate_submission_page_fields) ) { ?>    
    <div class="col-md-12 add-estate profile-page profile-onprofile row"> 
        <div class="submit_container">     

            <div class="col-md-4 profile_label">
                <!--<div class="submit_container_header"><?php esc_html_e('Select Property Status','wpresidence');?></div> -->
                <div class="user_details_row"><?php esc_html_e('Select Property Status','wpresidence');?></div> 
                <div class="user_profile_explain"><?php esc_html_e('Highlight your property.','wpresidence')?></div>
            </div>

            <div class="col-md-4">
                    <label for="property_status"><?php esc_html_e('Property Status','wpresidence');?></label>
                    <select id="property_status" name="property_status" class="select-submit">
                        <option value=""><?php esc_html_e('no status','wpresidence');?></option>
                        <?php print trim($property_status); ?>
                    </select>
           </div>
            
            
        </div>
    </div>
<?php }?>
<?php
global $submit_title;
global $submit_description;
global $property_price; 
global $property_label; 
global $property_label_before; 
global $property_hoa;
global $property_year_tax;
global $wpestate_submission_page_fields;

?>
<div class="col-md-12 add-estate profile-page profile-onprofile row"> 
    <div class="submit_container">



        <div class="col-md-4 profile_label">
            <div class="user_details_row"><?php esc_html_e('Property Description','wpresidence');?></div> 
            <div class="user_profile_explain"><?php esc_html_e('This description will appear first in page. Keeping it as a brief overview makes it easier to read.','wpresidence')?></div>
            <input type="hidden" name="is_user_submit" value="1">
        </div>



        <div class="col-md-8">   
            <p class="full_form">
               <label for="title"><?php esc_html_e('*Title (mandatory)','wpresidence'); ?> </label>
               <input type="text" id="title" class="form-control" value="<?php print stripslashes(($submit_title)); ?>" size="20" name="wpestate_title" />
            </p>

            <?php if(   is_array($wpestate_submission_page_fields) && in_array('wpestate_description', $wpestate_submission_page_fields)) { ?>
                <p class="full_form">
                   <label for="description"><?php esc_html_e('Description','wpresidence');?></label>
                  
                   
                   
                   <?php
          
                   // <textarea id="description"  class="form-control"  name="wpestate_description" cols="50" rows="6"><?php print stripslashes($submit_description);//</textarea>
                    wp_editor(  
                            stripslashes($submit_description), 
                            'description', 
                            array(
                                'textarea_rows' =>  6,
                                'textarea_name' =>  'wpestate_description',
                                'wpautop'       =>  true, // use wpautop?
                                'media_buttons' =>  false, // show insert/upload button(s)
                                'tabindex'      =>  '',
                                'editor_css'    =>  '', 
                                'editor_class'  => '', 
                                'teeny'         => false, 
                                'dfw'           => false, 
                                'tinymce'       => false,
                                'quicktags'     => array("buttons"=>"strong,em,block,ins,ul,li,ol,close"),
                               ) 
                            );
                   ?>
                
                </p>
            <?php }?>
        </div>    
    </div>

</div>






<?php if(   is_array($wpestate_submission_page_fields) && 
           (    in_array('property_label', $wpestate_submission_page_fields) || 
                in_array('property_price', $wpestate_submission_page_fields) || 
                in_array('property_label_before', $wpestate_submission_page_fields) ||
                in_array('property_year_tax', $wpestate_submission_page_fields) ||
                in_array('property_hoa', $wpestate_submission_page_fields) 
            )
        ) { ?>    
    <div class="col-md-12 add-estate profile-page profile-onprofile row"> 

        <div class="submit_container">

            <div class="col-md-4 profile_label">
                <!--<div class="submit_container_header"><?php esc_html_e('Property Description & Price','wpresidence');?></div>-->
                <div class="user_details_row"><?php esc_html_e('Property Price','wpresidence');?></div> 
                <div class="user_profile_explain"><?php esc_html_e('Adding a price will make it easier for users to find your property in search results.','wpresidence')?></div>
            </div>


            <div class="col-md-8">
                <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_price', $wpestate_submission_page_fields)) { ?>
                    <p class="col-md-12 half_form">
                        <label for="property_price"> <?php esc_html_e('Price in ','wpresidence');print esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') ).' '; esc_html_e('(only numbers)','wpresidence'); ?>  </label>
                        <input type="text" id="property_price" class="form-control" size="40" name="property_price" value="<?php print esc_html($property_price);?>">
                    </p>
                <?php }?>

                <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_year_tax', $wpestate_submission_page_fields)) { ?>    
                    <p class="col-md-6 half_form ">
                        <label for="property_label"><?php esc_html_e('Yearly Tax Rate','wpresidence');?></label>
                        <input type="text" id="property_year_tax" class="form-control" size="40" name="property_year_tax" value="<?php print esc_html($property_year_tax);?>">
                    </p> 
                <?php }?>
                    
                <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_hoa', $wpestate_submission_page_fields)) { ?>    
                    <p class="col-md-6 half_form ">
                        <label for="property_label"><?php esc_html_e('Homeowners Association Fee(monthly)','wpresidence');?></label>
                        <input type="text" id="property_hoa" class="form-control" size="40" name="property_hoa" value="<?php print esc_html($property_hoa);?>">
                    </p> 
                <?php }?>   
                    
                <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_label', $wpestate_submission_page_fields)) { ?>    
                    <p class="col-md-6 half_form ">
                        <label for="property_label"><?php esc_html_e('After Price Label (ex: "/month")','wpresidence');?></label>
                        <input type="text" id="property_label" class="form-control" size="40" name="property_label" value="<?php print esc_html($property_label);?>">
                    </p> 
                <?php }?>

                <?php if(   is_array($wpestate_submission_page_fields) && in_array('property_label_before', $wpestate_submission_page_fields)) { ?>
                    <p class="col-md-6 half_form">
                        <label for="property_label_before"><?php esc_html_e('Before Price Label (ex: "from ")','wpresidence');?></label>
                        <input type="text" id="property_label_before" class="form-control" size="40" name="property_label_before" value="<?php print esc_html($property_label_before);?>">
                    </p>
                <?php }?>
            </div>

        </div>
    </div>
<?php }?>
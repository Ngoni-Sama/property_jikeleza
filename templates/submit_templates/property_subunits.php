<?php

global $property_has_subunits;
global $property_subunits_list;
global $edit_id;
global $wpestate_submission_page_fields;

?>

<?php if(   is_array($wpestate_submission_page_fields) && in_array('property_subunits_list', $wpestate_submission_page_fields)) { ?>
    <div class="col-md-12 add-estate profile-page profile-onprofile row"> 
  
        <div class="submit_container">
            <div class="col-md-4 profile_label">
                <div class="user_details_row"><?php esc_html_e('Subunits','wpresidence');?></div> 
                <div class="user_profile_explain"><?php esc_html_e('Select what properties you wish to show as subunits from those published.','wpresidence')?></div>

                <p class="full_form">
                    <input type="hidden" name="property_has_subunits" value="">
                    <input type="checkbox"  id="property_has_subunits" name="property_has_subunits" value="1" 
                        <?php 
                            if ($property_has_subunits == 1) {
                                print'checked="checked"';
                            }
                        ?>     
                        />
                    <label class="checklabel" for="property_has_subunits"><?php esc_html_e('Enable ','wpresidence');?></label>
                </p>
            </div>

            <div class="col-md-8">     
                <p class="full_form">

                    <label for="property_subunits_list"><?php esc_html_e('Select Subunits From the list: ','wpresidence'); ?></label>
                    <?php



                        $current_user   =   wp_get_current_user();
                        $userID         =   $current_user->ID;
                        $post__not_in   =   array();
                        $post__not_in[] =   $edit_id;
                        $args = array(       
                                    'post_type'                 =>  'estate_property',
                                    'post_status'               => 'publish',
                                    'nopaging'                  =>  'true',
                                    'post__not_in'              =>  $post__not_in,
                                    'cache_results'             =>  false,
                                    'update_post_meta_cache'    =>  false,
                                    'update_post_term_cache'    =>  false,
                                    'author'                    =>  $userID,
                                    'cache_results'             =>  false,
                                    'update_post_meta_cache'    =>  false,
                                    'update_post_term_cache'    =>  false,

                            );


                        $recent_posts = new WP_Query($args);
                        print '<select name="property_subunits_list[]"  style="height:350px;" id="property_subunits_list"  multiple="multiple">';
                        while ($recent_posts->have_posts()): $recent_posts->the_post();
                             $theid=get_the_ID();
                             print '<option value="'.$theid.'" ';
                             if( is_array($property_subunits_list) && in_array($theid, $property_subunits_list) ){
                                 print ' selected="selected" ';
                             }
                             print'>'.get_the_title().'</option>';
                        endwhile;
                        print '</select>';


                    ?>

                </p>
            </div>
        </div>
    </div>

<?php } ?>
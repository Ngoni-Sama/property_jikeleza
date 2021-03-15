<?php
global $prop_action_category;
global $prop_action_category_selected;
global $prop_category_selected;
global $wpestate_submission_page_fields;


?>



<?php if(   is_array($wpestate_submission_page_fields) && 
            (   in_array('prop_action_category', $wpestate_submission_page_fields) || 
                in_array('prop_category', $wpestate_submission_page_fields)
            )
        ) { ?>   

    <div class="col-md-12 add-estate profile-page profile-onprofile row"> 
        <div class="submit_container"> 
            <div class="col-md-4 profile_label">
                <div class="user_details_row"><?php esc_html_e('Select Categories','wpresidence');?></div> 
                <div class="user_profile_explain"><?php esc_html_e('Selecting a category will make it easier for users to find you property in search results.','wpresidence')?></div>
            </div> 


            <?php if(   is_array($wpestate_submission_page_fields) && in_array('prop_category', $wpestate_submission_page_fields)) { ?>
                <p class="col-md-4"><label for="prop_category"><?php esc_html_e('Category','wpresidence');?></label>
                    <?php 
                        $args=array(
                                'class'       => 'select-submit2',
                                'hide_empty'  => false,
                                'selected'    => $prop_category_selected,
                                'name'        => 'prop_category',
                                'id'          => 'prop_category_submit',
                                'orderby'     => 'NAME',
                                'order'       => 'ASC',
                                'show_option_none'   => esc_html__('None','wpresidence'),
                                'taxonomy'    => 'property_category',
                                'hierarchical'=> true
                            );
                        wp_dropdown_categories( $args ); ?>
                </p>
            <?php }?>

            <?php if(   is_array($wpestate_submission_page_fields) && in_array('prop_action_category', $wpestate_submission_page_fields)) { ?>    
                <p class="col-md-4"><label for="prop_action_category"> <?php esc_html_e('Listed In ','wpresidence'); $prop_action_category;?></label>
                    <?php 
                    $args=array(
                            'class'       => 'select-submit2',
                            'hide_empty'  => false,
                            'selected'    => $prop_action_category_selected,
                            'name'        => 'prop_action_category',
                            'id'          => 'prop_action_category_submit',
                            'orderby'     => 'NAME',
                            'order'       => 'ASC',
                            'show_option_none'   => esc_html__('None','wpresidence'),
                            'taxonomy'    => 'property_action_category',
                            'hierarchical'=> true
                        );

                       wp_dropdown_categories( $args );  ?>
                </p>   
            <?php }?>
        </div>
    </div>

<?php }?>
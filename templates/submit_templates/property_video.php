<?php
global $embed_video_id;
global $option_video;
global $wpestate_submission_page_fields;
?>


<?php if(   is_array($wpestate_submission_page_fields) && 
           (    in_array('embed_video_type', $wpestate_submission_page_fields) || 
                in_array('embed_video_id', $wpestate_submission_page_fields)  
            )
        ) { ?>    


    <div class="col-md-12 add-estate profile-page profile-onprofile row"> 
        <div class="submit_container "> 
            
            <div class="col-md-4 profile_label">
                <!--<div class="submit_container_header"><?php esc_html_e('Video Option','wpresidence');?></div>-->
                <div class="user_details_row"><?php esc_html_e('Video Option','wpresidence');?></div> 
                <div class="user_profile_explain"><?php esc_html_e('Add just the video ID from the vimeo or youtube url.','wpresidence')?></div>
            </div>

            <div class="col-md-8">
                <?php if(   is_array($wpestate_submission_page_fields) && in_array('embed_video_type', $wpestate_submission_page_fields)) { ?>

                        <p class="half_form">
                           <label for="embed_video_type"><?php esc_html_e('Video from','wpresidence');?></label>
                           <select id="embed_video_type" name="embed_video_type" class="select-submit2">
                               <?php print trim($option_video);?>
                           </select>
                        </p>

                <?php }?>


                <?php if(   is_array($wpestate_submission_page_fields) && in_array('embed_video_id', $wpestate_submission_page_fields)) { ?>            

                       <p class="half_form">     
                           <label for="embed_video_id"><?php esc_html_e('Embed Video id: ','wpresidence');?></label>
                           <input type="text" id="embed_video_id" class="form-control"  name="embed_video_id" size="40" value="<?php print esc_html($embed_video_id);?>">
                       </p>

                <?php }?>
            </div>
        </div> 
    </div>
<?php }?>
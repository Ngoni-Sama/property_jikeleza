<?php
global $post;
  if ( !wp_script_is( 'googlemap', 'enqueued' )) {
        wpestate_load_google_map();
    }
?>

<div id="property_details_modal_wrapper">

    <div class="property_details_modal_back"></div>
    <div class="property_details_modal_container">
        <div id="property_details_modal_close">
            <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg"><path d="M11.778 11.778L4 4l7.778 7.778L4 19.556l7.778-7.778zm0 0l7.778 7.778-7.778-7.778L19.556 4l-7.778 7.778z" stroke="#FFF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
     
        <div id="property_modal_images">
           
        </div>  
        
        <div id="property_modal_header">
                <div id="property_modal_top_bar"></div>
                <h3 class="modal_property_title"></h3>
                
                <div class="modal_property_price"></div>
                <div class="modal_property_bed"></div>
                <div class="modal_property_addr"></div>
            
                <input type="submit" id="modal_contact_agent" class="wpresidence_button agent_submit_class "  value="<?php esc_html_e('Contact Agent','wpresidence')?>">
               
        </div>
        
        
        <div id="property_modal_content">
          
            <div id="modal_property_agent" class="modal_content_block"></div>
            <div class="modal_property_description modal_content_block"></div>
            <div class="modal_property_adress modal_content_block"></div>
            <div class="modal_property_details modal_content_block"></div>
            <div class="modal_property_features modal_content_block"></div>           
            <div class="modal_property_video modal_content_block"></div> 
            <div class="modal_property_video_tour modal_content_block"></div> 
            <div class="modal_property_walkscore  modal_content_block"></div> 
            <div class="modal_property_yelp modal_content_block"></div> 
            <div class="modal_property_floor_plans modal_content_block"></div> 
            <div id="modal_property_maps" class="modal_property_maps modal_content_block"></div>
            <div id="modal_property_mortgage" class="modal_content_block"></div>
            
        </div>
            
    </div>
    
</div>

<?php
include( locate_template ('/templates/image_gallery_modal.php') ); 
?>
<?php
global $property_adr_text;
global $property_details_text;
global $property_features_text;
global $feature_list_array;
global $use_floor_plans;
global $property_description_text;
global $post;
$walkscore_api                  =   esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );
$show_graph_prop_page           =   esc_html( wpresidence_get_option('wp_estate_show_graph_prop_page', '') );
$virtual_tour                   =   get_post_meta($post->ID, 'embed_virtual_tour', true);
$header_type                    =   get_post_meta ( $post->ID, 'header_type', true);

?>
<div role="tabpanel" id="tab_prpg">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#description" aria-controls="description" role="tab" data-toggle="tab">
        <?php 
            if($property_description_text!=''){
                echo esc_html($property_description_text);
            }else{
                esc_html_e('Description','wpresidence');
            }
        ?>
        </a>
        
    </li>
    
    <li role="presentation">
        <a href="#address" aria-controls="address" role="tab" data-toggle="tab">
            <?php 
                if($property_adr_text!=''){
                    echo esc_html($property_adr_text);
                } else{
                    esc_html_e('Property Address','wpresidence');
                }
            ?>
        </a>
    </li>
    
    <li role="presentation">
        <a href="#details" aria-controls="details" role="tab" data-toggle="tab">
            <?php                      
                if($property_details_text=='') {
                    print esc_html__('Property Details', 'wpresidence');
                }else{
                    print  esc_html($property_details_text);
                }
            ?>
        </a>
    </li>
    <?php
    if ( is_object_in_term($post->ID,'property_features') ){ ?>
        <li role="presentation">
            <a href="#features" aria-controls="features" role="tab" data-toggle="tab">
               <?php
                    if($property_features_text ==''){
                        print esc_html__('Amenities and Features', 'wpresidence');
                    }else{
                        print esc_html($property_features_text);
                    }
                ?>
            </a>
        </li>
    <?php } ?>
   

    <?php if ( $use_floor_plans==1 ){  ?>
    <li role="presentation">
        <a href="#floor" aria-controls="floor" role="tab" data-toggle="tab">
            <?php esc_html_e('Floor Plans','wpresidence');?>
        </a>
    </li>
    <?php } ?>
    
  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="description">
        <?php 
            $content = get_the_content();
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);

            if($content!=''){                            
                print trim($content);     
            }

             print wpestare_return_documents($post->ID);  
            ?>  

		<!-- Energy saving -->
		<?php          

			$energy_index       = get_post_meta($post->ID, 'energy_index', true) ;
			$energy_class       = get_post_meta($post->ID, 'energy_class', true) ;

		if ( $energy_index != ''    || $energy_class != ''  ){ //  if energy data  exists
		?>      
		<div class="property_energy_saving_info"  >  
                    <?php print wpestate_energy_save_features($post->ID); ?>
		</div>  
		<?php
		} // end if energy data  exists
		?>
		<!-- END Energy saving -->

		
    </div>

    <div role="tabpanel" class="tab-pane" id="address">
        <?php print estate_listing_address($post->ID,$wpestate_prop_all_details); ?>
    </div>
      
    <div role="tabpanel" class="tab-pane" id="details">
        <?php print estate_listing_details($post->ID,$wpestate_prop_all_details);?>  
    </div>
      
    <div role="tabpanel" class="tab-pane" id="features">
        <?php print estate_listing_features($post->ID,3,0,'',$wpestate_prop_all_details); ?>
    </div>  
    
  
    <?php if ( $use_floor_plans==1 ){  ?>
        <div role="tabpanel" class="tab-pane" id="floor">
            <?php print estate_floor_plan($post->ID,0,$wpestate_prop_all_details); ?>
        </div>
    <?php } ?>
      
  
      
  </div>

</div>








<!-- Video -->
<?php
$video_id=  get_post_meta ( $post->ID, 'embed_video_id', true);
if ( $video_id!='' ){ 
?>    
 
<div class="panel-group property-panel" id="accordion_video">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_video" href="#collapseThreeOne">
              <?php
                if($property_features_text ==''){
                    print '<h4 class="panel-title" id="prop_video">'.esc_html__('Video', 'wpresidence').'</h4>';
                }else{
                    print '<h4 class="panel-title" id="prop_video">'.esc_html($property_video_text).'</h4>';
                }
              ?>
            </a>
        </div>
        <div id="collapseThreeOne" class="panel-collapse collapse in">
          <div class="panel-body">
            <?php 
            print wpestate_listing_video($post->ID,$wpestate_prop_all_details);
            ?>
              
          </div>
        </div>
    </div>
</div>  

<?php
}
?>
<!-- End Video -->







<?php

    $prpg_slider_type_status= esc_html ( wpresidence_get_option('wp_estate_global_prpg_slider_type','') ); 
    $local_pgpr_slider_type_status  =   get_post_meta($post->ID, 'local_pgpr_slider_type', true);
    
    if( $local_pgpr_slider_type_status=='global' && ( $prpg_slider_type_status == 'header masonry gallery' ||  $prpg_slider_type_status == 'full width header'||  $prpg_slider_type_status=='multi image slider' ||  $prpg_slider_type_status=='gallery' ||   $prpg_slider_type_status =='classic' ) 
            || $local_pgpr_slider_type_status=='header masonry gallery' || $local_pgpr_slider_type_status=='full width header'  ||  $local_pgpr_slider_type_status=='multi image slider'  ||  $local_pgpr_slider_type_status=='gallery'
            ||  $local_pgpr_slider_type_status=='animation slider' ||  $local_pgpr_slider_type_status =='classic'){ 
    ?>
    <div class="panel-group property-panel" id="accordion_prop_map">  
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion_prop_map" href="#collapsemap">
                    <h4 class="panel-title" id="prop_ame"><?php esc_html_e('Map', 'wpresidence');?></h4>
                  
                </a>
            </div>
            <div id="collapsemap" class="panel-collapse collapse in">
                <div class="panel-body">
                    <?php print do_shortcode('[property_page_map propertyid="'.$post->ID.'" ][/property_page_map]') ?>
                </div>
            </div>
        </div>
    </div> 


    <?php
    }
?>


<!-- Virtual Tour -->    

<?php

$virtual_tour                   =   get_post_meta($post->ID, 'embed_virtual_tour', true);
if($virtual_tour!='' && $header_type!=11 ){?>

    
<div class="panel-group property-panel" id="accordion_virtual_tour">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_virtual_tour" href="#collapsenine">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.esc_html__('Virtual Tour', 'wpresidence').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapsenine" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_virtual_tour_details($post->ID); ?>
            </div>
        </div>
    </div>
</div>  

<?php       
}
?>

<!-- Walkscore -->     

<?php
    $walkscore_api= esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );
    if($walkscore_api!=''){?>

    
<div class="panel-group property-panel" id="accordion_walkscore">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_walkscore" href="#collapseFour">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.esc_html__('WalkScore', 'wpresidence').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapseFour" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_walkscore_details($post->ID,$wpestate_prop_all_details); ?>
            </div>
        </div>
    </div>
</div>  


<?php       
}
?>


<?php
$yelp_client_id         =   wpresidence_get_option('wp_estate_yelp_client_id','');
$yelp_client_secret     =   wpresidence_get_option('wp_estate_yelp_client_secret','');
$yelp_client_api_key_2018  =   wpresidence_get_option('wp_estate_yelp_client_api_key_2018','');



if($yelp_client_api_key_2018!='' && $yelp_client_id!=''  ){
?>

<div class="panel-group property-panel" id="accordion_yelp">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_yelp" href="#collapseyelp">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.esc_html__('What\'s Nearby', 'wpresidence').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapseyelp" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_yelp_details($post->ID); ?>
            </div>
        </div>
    </div>
</div>  

<?php
}
?>

<?php
$show_morgage_calculator= wpresidence_get_option('wp_estate_show_morg_calculator','');;
if($show_morgage_calculator=='yes'){
?>
<div class="panel-group property-panel" id="accordion_morgage">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_morgage" href="#collapsemorgage">
                <?php
                    print '<h4 class="panel-title" id="prop_morg">'.esc_html__('Payment Calculator', 'wpresidence').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapsemorgage" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_morgage_calculator($post->ID,$wpestate_prop_all_details); ?>
            </div>
        </div>
    </div>
</div>  

<?php
}
?>



<?php
if($show_graph_prop_page=='yes'){
?>
    <div class="panel-group property-panel" id="accordion_prop_stat">
        <div class="panel panel-default">
           <div class="panel-heading">
               <a data-toggle="collapse" data-parent="#accordion_prop_stat" href="#collapseSeven">
                <h4 class="panel-title">  
                <?php 
                    esc_html_e('Page Views Statistics','wpresidence');
               
                ?>
                </h4>    
               </a>
           </div>
           <div id="collapseSeven" class="panel-collapse collapse in">
             <div class="panel-body">
                <canvas id="myChart"></canvas>
             </div>
           </div>
        </div>            
    </div>   
<?php
}

?>
<script type="text/javascript">
    //<![CDATA[
        jQuery(document).ready(function(){
            wpestate_show_morg_pie();
             wpestate_show_stat_accordion();
        });

    //]]>
</script>

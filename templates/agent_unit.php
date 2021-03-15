<?php
global $wpestate_options;
$agent_details =wpestate_return_agent_details('',$post->ID);
$extra= array(
        'class'	=> 'lazyload img-responsive',    
        );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'property_listings',$extra);


if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_theme_file_uri('/img/default_user.png').'" alt="'.esc_html__('user image','wpresidence').'">';
}
?>
    <div class="agent_unit" data-link="<?php print esc_attr($agent_details['link']);?>">
        <div class="agent-unit-img-wrapper">
            <?php ?>
            <div class="agent_card_my_listings">
                <?php print intval($agent_details['counter']).' '; 
                    if($agent_details['counter']!=1){
                        esc_html_e('listings','wpresidence');
                    }else{
                        esc_html_e('listing','wpresidence');
                    }
                ?>
            </div>
      
            
            
         
            <?php 
                print trim($thumb_prop); 
            ?>
        </div>    
            

        <?php
        print '<h4> <a href="'.esc_url($agent_details['link']).'">'.esc_html($agent_details['realtor_name']).'</a></h4>
        <div class="agent_position">'.esc_html($agent_details['realtor_position']).'</div>';

        print '<div class="agent_card_content">'. wpestate_strip_excerpt_by_char(get_the_excerpt(),90,$post->ID,'...').'</div>';
        ?>

     
       
        <div class="agent_unit_social agent_list">
        
               
               <?php
               
                if($agent_details['realtor_facebook']!=''){
                    print ' <a class="agent_unit_facebook" href="'. esc_url($agent_details['realtor_facebook']).'"><i class="fab fa-facebook-f"></i></a>';
                }

                if($agent_details['realtor_twitter']!=''){
                    print ' <a  class="agent_unit_twitter" href="'.esc_url($agent_details['realtor_twitter']).'"><i class="fab fa-twitter"></i></a>';
                }
                
                if($agent_details['realtor_linkedin']!=''){
                    print ' <a  class="agent_unit_linkedin" href="'.esc_url($agent_details['realtor_linkedin']).'"><i class="fab fa-linkedin-in"></i></a>';
                }
                
                if($agent_details['realtor_pinterest']!=''){
                    print ' <a  class="agent_unit_pinterest" href="'. esc_url($agent_details['realtor_pinterest']).'"><i class="fab fa-pinterest-p"></i></a>';
                }
                
                if($agent_details['realtor_instagram']!=''){
                    print ' <a  class="agent_unit_instagram" href="'. esc_url($agent_details['realtor_instagram']).'"><i class="fab fa-instagram"></i></a>';
                }
                
                if($agent_details['realtor_phone']!=''){
                    print '<div class="agent_unit_phone"><a href="tel:'.esc_html( $agent_details['realtor_phone']).'"><i class="fas fa-phone"></i></a></div>';
                }
                
                if($agent_details['email']!=''){
                    //'.esc_html($agent_details['email']).'</a>
                    print '<div class="agent_unit_email"><a href="mailto:'.esc_html($agent_details['email']).'"><i class="fas fa-envelope"></i></a></div>';
                }
                
                ?>
           
        </div>
    </div>
<!-- </div>    -->
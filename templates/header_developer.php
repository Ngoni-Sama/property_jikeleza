<?php
 
$thumb_id               =   get_post_thumbnail_id($post->ID);
$preview                =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$preview_img            =   $preview[0];
$agency_skype           =   esc_html( get_post_meta($post->ID, 'developer_skype', true) );
$agency_phone           =   esc_html( get_post_meta($post->ID, 'developer_phone', true) );
$agency_mobile          =   esc_html( get_post_meta($post->ID, 'developer_mobile', true) );
$agency_email           =   is_email( get_post_meta($post->ID, 'developer_email', true) );
$agency_posit           =   esc_html( get_post_meta($post->ID, 'developer_position', true) );
$agency_facebook        =   esc_html( get_post_meta($post->ID, 'developer_facebook', true) );
$agency_twitter         =   esc_html( get_post_meta($post->ID, 'developer_twitter', true) );
$agency_linkedin        =   esc_html( get_post_meta($post->ID, 'developer_linkedin', true) );
$agency_pinterest       =   esc_html( get_post_meta($post->ID, 'developer_pinterest', true) );
$agency_instagram       =   esc_html( get_post_meta($post->ID, 'developer_instagram', true) );
$agency_opening_hours   =   esc_html( get_post_meta($post->ID, 'developer_opening_hours', true) );
$name                   =   get_the_title($post->ID);
$link                   =   esc_url ( get_permalink($post->ID) );
$agency_addres          =    esc_html( get_post_meta($post->ID, 'developer_address', true) );
$agency_languages       =    esc_html( get_post_meta($post->ID, 'developer_languages', true) );
$agency_license         =    esc_html( get_post_meta($post->ID, 'developer_license', true) );
$agency_taxes           =    esc_html( get_post_meta($post->ID, 'developer_taxes', true) );
$agency_website         =    esc_html( get_post_meta($post->ID, 'developer_website', true) );
?>

<div class="header_agency_wrapper">
    <div class="header_agency_container">
        <div class="row">
            
           
            
            <div class="col-md-4">
                <a href="<?php print esc_url($link);?>">
                    <img src="<?php print esc_url($preview_img);?>"  alt="<?php esc_html_e('image','wpresidence'); ?>" class="img-responsive"/>
                </a>
            </div>
            
            
            <div class="col-md-8">
                <h1 class="agency_title"><?php echo esc_html($name);?></h1>
                
                
                
                <div class="col-md-6 agency_details">
                    <?php
                         
                        if($agency_facebook!=''){
                            print ' <a class="agency_social" href="'.esc_url($agency_facebook).'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
                        }

                        if($agency_twitter!=''){
                            print ' <a class="agency_social" href="'.esc_url($agency_twitter).'" target="_blank"><i class="fab fa-twitter"></i></a>';
                        }
                        if($agency_linkedin!=''){
                            print ' <a class="agency_social" href="'.esc_url($agency_linkedin).'" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
                        }
                        if($agency_pinterest!=''){
                            print ' <a class="agency_social" href="'.esc_url($agency_pinterest).'" target="_blank"><i class="fab fa-pinterest-p"></i></a>';
                        }
                        if($agency_instagram!=''){
                            print ' <a class="agency_social" href="'.esc_url($agency_instagram).'" target="_blank"><i class="fab fa-instagram"></i></a>';
                        }

                    ?>
                    
                    <?php 
                    if($agency_addres!=''){
                        echo '<div class="agency_detail agency_address"><strong>'.esc_html__('Adress:','wpresidence').'</strong> '.esc_html($agency_addres).'</div>';
                    }
                    ?>
                    
                    <?php 
                    if($agency_email!=''){
                        echo '<div class="agency_detail agency_email"><strong>'.esc_html__('Email:','wpresidence').'</strong> <a href="mailto:'.esc_html($agency_email).'">'.esc_html($agency_email).'</a></div>';
                    }
                    ?>
                 

                    <?php 
                    if($agency_mobile!=''){
                        echo '<div class="agency_detail agency_mobile"><strong>'.esc_html__('Mobile:','wpresidence').'</strong> <a href="tel:'.esc_html($agency_mobile).'">'.esc_html($agency_mobile).'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_phone!=''){
                        echo '<div class="agency_detail agency_phone"><strong>'.esc_html__('Phone:','wpresidence').'</strong> <a href="tel:'.esc_html($agency_phone).'">'.esc_html($agency_phone).'</a></div>';
                    }
                    ?>
                    
                    <a href="#agency_contact" class=" developer_contact_button wpresidence_button"  ><?php esc_html_e('Contact Us','wpresidence');?></a>
                      
                </div>   
                
                <div class="col-md-6 agency_details">
                    <div class="developer_taxonomy">
                    <?php
                    print  get_the_term_list($post->ID, 'property_county_state_developer', '', '', '') ;
                    print  get_the_term_list($post->ID, 'property_city_developer', '', '', '') ;
                    print  get_the_term_list($post->ID, 'property_area_developer', '', '', '');
                    print  get_the_term_list($post->ID, 'property_category_developer', '', '', '') ;
                    print  get_the_term_list($post->ID, 'property_action_developer', '', '', '');  
                    ?>
                    </div>                  
                </div>
            </div>
            
            
            <div class="col-md-12 developer_content">
                <div class="col-md-8 ">
                    <?php
                    $content_post = get_post($post->ID);
                    $content = $content_post->post_content;
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    print trim($content);
                    ?>
                  
                </div>
                
                <div class="col-md-4">
                    <?php 
                    
                    if($agency_website!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.esc_html__('Website:','wpresidence').'</strong> <a href="'.esc_url($agency_website).'" target="_blank">'.esc_html($agency_website).'</a></div>';
                    }
                    ?>  
                    <?php 
                    if($agency_skype!=''){
                        echo '<div class="agency_detail agency_skype"><strong>'.esc_html__('Skype:','wpresidence').'</strong> '.esc_html($agency_skype).'</div>';
                    }
                    ?>
                    <?php 
                    if($agency_license!=''){
                        echo '<div class="agency_detail agency_license"><strong>'.esc_html__('License:','wpresidence').'</strong> '.esc_html($agency_license).'</div>';
                    }
                    ?>
                    <?php 
                    if($agency_taxes!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.esc_html__('Our Taxes:','wpresidence').'</strong> '.esc_html($agency_taxes).'</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
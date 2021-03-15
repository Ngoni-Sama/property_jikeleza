<div class="property_reviews_wrapper">
    <h4><?php esc_html_e('Developer Reviews ','wpresidence');?></h4>
    <?php 
    $args = array(
        'number' => '15',
        'post_id' => $post->ID, // use post_id, not post_ID
       
    );


    $comments           =   get_comments($args);   
    $coments_no         =   0;
    $stars_total        =   0;
    $review_templates   =   ' ';

    foreach($comments as $comment) :
        if(wp_get_comment_status($comment->comment_ID)!='unapproved'){
        
        $coments_no++;
        $userId         =   $comment->user_id;

        if($userId == 1){
            $reviewer_name="admin";
            $userid_agent   =   get_user_meta($userId, 'user_agent_id', true);
        }else{
            $userid_agent   =   get_user_meta($userId, 'user_agent_id', true);
            $reviewer_name  =   get_the_title($userid_agent); 
            
            if($userid_agent==''){
                $reviewer_name=   $comment->comment_author;
            }
        }

        if($userid_agent==''){
            $user_small_picture_id     =    get_the_author_meta( 'small_custom_picture' ,  $comment->user_id,true  );
            $preview                   =    wp_get_attachment_image_src($user_small_picture_id,'agent_picture_thumb');
            $preview_img               =    $preview[0];
        }else{
            $thumb_id           = get_post_thumbnail_id($userid_agent);
            $preview            = wp_get_attachment_image_src($thumb_id, 'thumbnail');
            $preview_img        = $preview[0];
        }

        if($preview_img==''){
            $preview_img    =   get_theme_file_uri('/img/default_user_agent.gif');
        }
        $current_user       =   wp_get_current_user();
        $userID             =   $current_user->ID;
     
        $review_title       =   get_comment_meta( $comment->comment_ID, 'review_title',true  );
        $rating= get_comment_meta( $comment->comment_ID , 'review_stars', true );
        $stars_total+=$rating;
        $review_templates.='  
             <div class="listing-review">


                            <div class=" review-list-content norightpadding">
                                <div class="reviewer_image"  style="background-image: url('.esc_url($preview_img).');"></div>
                            
                                <div class="reviwer-name">'.esc_html__( 'Posted by ','wpresidence' ). ''.esc_html($reviewer_name).'</div>
                                <div class="review-title">'.esc_html($review_title).'</div>
                                <div class="property_ratings">';

                                    $counter=0; 
                                        while($counter<5){
                                            $counter++;
                                            if( $counter<=$rating ){
                                                $review_templates.=' <i class="fas fa-star"></i>';
                                            }else{
                                               $review_templates.=' <i class="far fa-star"></i>'; 
                                            }

                                        }
                                $review_templates.=' <span class="ratings-star">('. esc_html($rating).' ' .esc_html__( 'of','wpresidence').' 5)</span> 
                                </div>
                                
                                <div class="review-date">
                                    '.esc_html__( 'Posted on ','wpresidence' ). ' '. get_comment_date('j F Y',$comment->comment_ID).' 
                                </div>


                                <div class="review-content">
                                    '.$comment->comment_content .'
                                </div>
                            </div>
                        </div>  ';
    }
    endforeach;
?>




    <?php 
    if($coments_no>0){
        $list_rating= ceil($stars_total/$coments_no);

    ?>
    <div class="property_page_container for_reviews">
        <div class="listing_reviews_wrapper">
                <div class="listing_reviews_container">
                    <h3 id="listing_reviews" class="panel-title">
                            <?php
                            print intval($coments_no).' ';
                            esc_html_e('Reviews', 'wpresidence');
                            ?>
                            <span class="property_ratings">
                                 <?php 
                                $counter=0; 
                                    while($counter<5){
                                        $counter++;
                                        if( $counter<=$list_rating ){
                                            print '<i class="fas fa-star"></i>';
                                        }else{
                                            print '<i class="far fa-star"></i>'; 
                                        }

                                    }
                                ?>
                            </span>
                    </h3>

                    <?php   print trim($review_templates); ?>   
            </div>
        </div>
    </div>
    <?php } ?>
    
    
        
    <?php   
    if ( is_user_logged_in() ) {   
        $current_user       =   wp_get_current_user();
        $userID             =   $current_user->ID;
        $review_title       =   '';
        $review_stars       =   '';
        $comment_content    =   '';
        $user_posted_coment =   0;
        $args=array(
            'author__in'        => array($userID),
            'post_id'           => $post->ID,
            'comment_approved'  =>1,
            'number'            =>1,
            
        );
    
        $comments = get_comments( $args );
        
        foreach($comments as $comment) :
            $user_posted_coment =   $comment->comment_ID;
            $review_title       =   get_comment_meta( $comment->comment_ID, 'review_title',true  );
            $review_stars       =   get_comment_meta( $comment->comment_ID, 'review_stars',true  );
            $comment_content    =   get_comment_text( $comment->comment_ID );
        endforeach;
       
        ?>
        <h5><?php    
            if( $user_posted_coment!=0 ){
                print '<div class="review_tag">'.esc_html__('Update Review ','wpresidence');
                if(wp_get_comment_status($user_posted_coment)=='unapproved'){
                   print ' - '. esc_html__('pending approval','wpresidence');
                }
                print '</div>';                
            }else{
                print '<div class="review_tag">'.esc_html__('Write a Review ','wpresidence').'</div>';
            }
            ?>
        </h5>
        <div class="add_review_wrapper">
            
            <div class="rating">
                <span class="rating_legend"><?php esc_html_e( 'Your Rating & Review','wpresidence');?></span>
                
                <?php 
                
                $i=1;
                $j=1;
                while ($i<=5):
                    print '<span class="empty_star';
                        if( $j<=$review_stars){
                            print ' starselected starselected_click';
                        }
                    print' "></span>';
                    $i++;
                    $j++;
                endwhile;
                ?>
               
            </div>
            
            <input type="text" id="wpestate_review_title" name="wpestate_review_title" value="<?php print esc_html($review_title);?>" class="form-control" placeholder="<?php esc_html_e('Review Title','wpresidence');?>">
            <textarea rows="8" id="wpestare_review_content" name="wpestare_review_content" class="form-control" placeholder="<?php  esc_html_e('Your Review','wpresidence'); ?>"><?php 
                if( $user_posted_coment!=0  ){
                    print trim($comment_content);
                } 
                ?></textarea>
            <?php 
           

          
               
            if( $user_posted_coment!=0){ ?>
                <input type="submit" class="wpresidence_button col-md-3" id="edit_review" data-coment_id="<?php print esc_attr($user_posted_coment);?>" data-listing_id="<?php print intval($post->ID);?>" value="<?php esc_html_e('Edit Review','wpresidence');?>">
            <?php
            }else{?>
                <input type="submit" class="wpresidence_button col-md-3" id="submit_review" data-listing_id="<?php print intval($post->ID);?>" value="<?php esc_html_e('Submit Review','wpresidence');?>">
            <?php   
            }

            $ajax_nonce = wp_create_nonce( "wpestate_review_nonce" );
            print'<input type="hidden" id="wpestate_review_nonce" value="'.esc_html($ajax_nonce).'" />    ';
            ?>
        </div>
    <?php
    }else{ 
    ?>
        <h5 class="review_notice"><?php esc_html_e('You need to ','wpresidence');print '<span id="login_trigger_modal">'.esc_html__('login','wpresidence').'</span> ';esc_html_e('in order to post a review ','wpresidence');?></h5>
   
    <?php
    }
    ?>

</div>
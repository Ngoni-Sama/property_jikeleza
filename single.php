<?php
// Sigle - Blog post
// Wp Estate Pack
get_header();
$wpestate_options=wpestate_page_details($post->ID); 
global $more;
$more = 0;

if ( 'wpestate_message' == get_post_type() || 'wpestate_invoice' == get_post_type() ){
    exit();
}
?>

<div id="post" <?php post_class('row');?>>
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> single_width_blog">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php 
        while ( have_posts() ) : the_post();
       
       
        
        if (has_post_thumbnail()){
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
        }
         $email_link     =   'subject='.urlencode ( get_the_title() ) .'&body='. urlencode( esc_url(get_permalink()));
        ?>
            



        <div class="single-content single-blog">
            
          
            
            
            <?php 
            global $more;
            $more=0;
            include( locate_template('templates/postslider.php' ) ); 
            ?>
            
            <?php  
            if (esc_html( get_post_meta($post->ID, 'post_show_title', true) ) != 'no') { ?> 
                <h1 class="entry-title single-title" ><?php the_title(); ?></h1>
            <?php } ?>
            
            <div class="meta-info"> 
                <div class="meta-element"> <?php print '<i class="far fa-calendar-alt meta_icon firsof"></i>'.esc_html__('Posted by ', 'wpresidence'); print ' '.get_the_author().' ';esc_html_e('on', 'wpresidence'); print' '.the_date('', '', '', FALSE); ?></div>
                <div class="meta-element"> <?php print '<i class="far fa-file meta_icon"></i> '; the_category(', ')?></div>
                <div class="meta-element"> <?php print '<i class="far fa-comment meta_icon"></i> '; comments_number( '0', '1' );  ?>   </div>   
            </div> 
                
                
            <?php
            the_content('Continue Reading');                     
            $args = array(
                       'before'           => '<p>' . esc_html__('Pages:','wpresidence'),
                       'after'            => '</p>',
                       'link_before'      => '',
                       'link_after'       => '',
                       'next_or_number'   => 'number',
                       'nextpagelink'     => esc_html__('Next page','wpresidence'),
                       'previouspagelink' => esc_html__('Previous page','wpresidence'),
                       'pagelink'         => '%',
                       'echo'             => 1
              ); 
            wp_link_pages( $args ); 
            
           
            ?>   
                
                
            <div class="prop_social_single">

                <a href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title() .' '.  esc_url( get_permalink() )); ?>" class="share_tweet" target="_blank"><i class="fab fa-twitter"></i></a>
                <?php if (isset($pinterest[0])){ ?>
                   <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($pinterest[0]);?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fab fa-pinterest-p"></i> </a>      
                <?php } ?>
                    <a href="https://api.whatsapp.com/send?text=<?php echo urlencode( get_the_title().' '. esc_url( get_permalink() )); ?>" class=""><i class="fab fa-whatsapp" aria-hidden="true"></i></a>   
       
                <a href="mailto:email@email.com?<?php echo trim(esc_html($email_link));?>"  class="social_email"> <i class="far fa-envelope"></i></a>

            </div>

                
        </div>    
     
        <!-- #comments start-->
        <?php 
         if ( comments_open() || get_comments_number() ) :
            comments_template('', true);
        endif;
        ?> 	
        
        <!-- end comments -->   
        
        <!-- #related posts start-->    
        <?php  include( locate_template('templates/related_posts.php') );?>    
        <!-- #end related posts -->   
        
     
        
        <?php endwhile; // end of the loop. ?>
    </div>
       
<?php   include get_theme_file_path('sidebar.php');?>
</div>   

<?php get_footer(); ?>
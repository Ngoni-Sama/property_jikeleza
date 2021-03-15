<?php 
$agent_id       =   intval  ( get_post_meta($post->ID, 'property_agent', true) );
$thumb_id       =   get_post_thumbnail_id($agent_id);
$agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');

if ($agent_face[0]==''){
   $agent_face[0]= get_theme_file_uri('/img/default-user_1.png');
}

?>

<div class="property_agent_wrapper property_agent_wrapper_type1">
                   
    <?php 
    echo'<span><strong>'. esc_html__('Agent','wpresidence').':'.'</strong></span>';
    if($agent_id!=0){
            echo '<a href="' . esc_url ( get_permalink($agent_id) ) . '"> <i class="far fa-user-circle unit3agent"></i> ' . get_the_title($agent_id) . '</a>';
        }else{
            echo get_the_author_meta( 'first_name',$post->post_author).' '.get_the_author_meta( 'last_name',$post->post_author);
        }
    ?>
</div>


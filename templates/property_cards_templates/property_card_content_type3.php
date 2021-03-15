
            <?php if ($align_class=='the_list_view') {?>
                <div class="listing_details the_list_view" style="display:block;">
                    <?php   
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
                    ?>
                </div>   
        
                <div class="listing_details half_map_list_view" >
                    <?php   
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),90,$post->ID);
                    ?>
                </div>   

                <div class="listing_details the_grid_view" style="display:none;">
                    <?php 
                        echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
                    ?>
                </div>
            <?php
            }else{
            ?>
                <div class="listing_details the_grid_view">
                    <?php
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
                    ?>
                </div>

                <div class="listing_details the_list_view">
                    <?php
                        echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),90,$post->ID);
                    ?>
                </div>
            <?php } ?>   

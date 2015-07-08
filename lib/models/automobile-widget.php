<?php
// return the array of category
    function get_category_list( $category_name, $parent='' ){
        if( empty($parent) ){
            $get_category = get_categories( array( 'taxonomy' => $category_name, 'hide_empty' => 0	));

            $category_list = array( '0' =>'All');
            if( !empty($get_category) ){
                foreach( $get_category as $category ){
                    $category_list[] = urldecode($category->slug);
                }
            }

            return $category_list;
        }else{
            $parent_id = get_term_by('slug', $parent, $category_name);
            $get_category = get_categories( array( 'taxonomy' => $category_name, 'child_of' => $parent_id->term_id, 'hide_empty' => 0));
            $category_list = array( '0' => $parent );

            if( !empty($get_category) ){
                foreach( $get_category as $category ){
                    $category_list[] = urldecode($category->slug);
                }
            }

            return $category_list;
        }
    }

add_action( 'widgets_init', 'recent_team_widget' );

function recent_team_widget() {
    register_widget( 'Recent_team' );
}

class Recent_team extends WP_Widget {

    // Initialize the widget
    function Recent_team() {
        parent::WP_Widget('recent-team-widget', __('team','team_back_office'),
            array('description' => __('A widget that show last team', 'team_back_office')));
    }
    // Output of the widget
    function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        //$port_cat = $instance['port_cat'];
        $show_num = $instance['show_num'];
        //if($port_cat == "All"){ $port_cat = ''; }

        // Opening of widget
       // echo $before_widget;

        // Open of title tag
        if ( $title ){
            //echo $before_title . $title . $after_title;
        }

        // Widget Content
        wp_reset_query();
        //$current_post = array(get_the_ID());
        $custom_posts = get_posts( array('post_type'=>'your_team', 'suppress_filters' => 0, 'showposts'=>$show_num) );

        //print_r($custom_posts);

        if( !empty($custom_posts) ){
            echo "<div class='team-recent-port-widget'>";
            foreach($custom_posts as $custom_post) {
                ?>
                <div class="recent-port-widget second-style">
                    <?php
                        $thumbnail_id = get_post_thumbnail_id( $custom_post->ID );
                        $thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'thumbnail' );
                        echo '<h2>' . $post_title = get_the_title($custom_post->ID).'</h2>';
                        echo '<h2>' . $facebook= get_post_meta($custom_post->ID, 'facebook', true) .'</h2>';
                        if( $thumbnail_id ){
                            echo '<div class="recent-port-widget-thumbnail">';
                            echo '<a href="' . get_permalink( $custom_post->ID ) . '">';
                            $alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
                            if( !empty($thumbnail) ){
                                echo '<img src="' . $thumbnail[0] . '" alt="'. $alt_text .'"/>';
                            }
                            echo '</a>';
                            echo '</div>';
                        }
                    ?>
                </div>
                <?php

            }
            echo "<div class='clear'></div>";
            echo "</div>";
        }

        // Closing of widget
       // echo $after_widget;
    }

    // Widget Form
    function form( $instance ) {
        if ( $instance ) {
            $title = esc_attr( $instance[ 'title' ] );
            //$port_cat = esc_attr( $instance[ 'port_cat' ] );
            $show_num = esc_attr( $instance[ 'show_num' ] );
        } else {
            $title = '';
            //$port_cat = '';
            $show_num = '6';
        }
        ?>

        <!-- Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title :', 'team_back_office' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <!-- Port Category
        <p>
            <label for="<?php //echo $this->get_field_id( 'port_cat' ); ?>"><?php // _e('Category :', 'team_back_office'); ?></label>
            <select class="widefat" name="<?php //echo $this->get_field_name( 'port_cat' ); ?>" id="<?php //echo $this->get_field_id( 'port_cat' ); ?>">
            <?php
        //	$category_list = get_category_list('team_categories');
        //	foreach($category_list as $category){
            ?>
                <option value="<?php //echo $category; ?>" <?php //if ( $port_cat == $category ) echo ' selected="selected"'; ?>><?php //echo $category; ?></option>
            <?php //} ?>
            </select>
        </p>	 -->

        <!-- Show Num -->
        <p>
            <label for="<?php echo $this->get_field_id( 'show_num' ); ?>"><?php _e('Show Count :', 'team_back_office'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_num' ); ?>" name="<?php echo $this->get_field_name( 'show_num' ); ?>" type="text" value="<?php echo $show_num; ?>" />
        </p>

    <?php
    }

    // Update the widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        //$instance['port_cat'] = strip_tags( $new_instance['port_cat'] );
        $instance['show_num'] = strip_tags( $new_instance['show_num'] );

        return $instance;
    }
}
?>
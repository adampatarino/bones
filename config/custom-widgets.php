<?php

global $post;

add_action( 'widgets_init', 'a2_widgets' );


function a2_widgets() {
    register_widget( 'Hot_Links_Widget' );
    register_widget( 'Best_Of_Widget' );
}

class Hot_Links_Widget extends WP_Widget {
    function Hot_Links_Widget() {
        $widget_ops = array( 'classname' => 'hot_links widget', 'description' => __('Display the links from the last Hot Links post', 'hot_links') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'hot_links-widget' );
        $this->WP_Widget( 'hot_links-widget', __('Hot Links Widget', 'custom'), $widget_ops, $control_ops );
    }

    function widget( $args, $instance ) {
        extract( $args );
        //Our variables from the widget settings.
        $title = $instance['title'];

        $args = array(
            'posts_per_page' => 1,
            'category_name' => 'hot-links',
            'orderby' => 'date',
            'order' => 'DESC'
            );
        $links_query = new WP_Query( $args );

        if ( $links_query->have_posts() ) {
            
            echo $before_widget;

            while ( $links_query->have_posts() ) {
                $links_query->the_post();
                
                if(get_field('hot_links')) {
                    $links = array_slice(get_field('hot_links'), 0, 5, true);
                }
                
                if($links) {

                    echo "<div class='inner-widget'>";
                        echo '<h3 class="widget-title"><a href="'. get_the_permalink() .'">'. $title .'</a></h3>';

                            echo "<ul class='links'>";
                            foreach($links as $link) {
                                echo '<li class="link"> <a href="'. $link['link'] .'" target="_blank">'. $link['title'] .'</a> <span class="link-source">('. $link['source'] .')</span>';
                            }
                            echo "</ul>";
                            
                    echo "</div>";

                }
            }

            echo $after_widget;
        }

        
    }

    //Update the widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;
    }

    function form( $instance ) {
        $defaults = array( 'title' => __("Today's Hot Links", 'example'));
        $instance = wp_parse_args( (array) $instance, $defaults );

        ?>

        <!-- Title -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>


        <?php
    }
} // End Widg


class Best_Of_Widget extends WP_Widget {
    function Best_Of_Widget() {
        $widget_ops = array( 'classname' => 'best_of widget', 'description' => __('Display the 5 most recent posts marked with best of', 'best_of') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'best_of-widget' );
        $this->WP_Widget( 'best_of-widget', __('Best Of Widget', 'custom'), $widget_ops, $control_ops );
    }

    function widget( $args, $instance ) {
        extract( $args );
        //Our variables from the widget settings.
        $title = $instance['title'];

        $args = array(
            'posts_per_page' => 5,
            'meta_query' => array(
                array(
                    'key' => 'best_of', 
                    'value' => '"true"',
                    'compare' => 'LIKE'
                )
            ),
            'orderby' => 'date',
            'order' => 'DESC' 
            );
        $best_query = new WP_Query( $args );

        echo $before_widget;

        if ( $best_query->have_posts() ) {
            echo '<h3 class="widget-title">'. $title .'</h3>';
            echo "<div class='inner-widget'>";
                echo '<ul class="best-of-list links">';
                while ( $best_query->have_posts() ) {
                    $best_query->the_post();

                    echo '<li class="link"><a href="'. get_the_permalink() .'">'. get_the_title() .'</a> <span class="link-source">'.get_the_date('M Y').'</span></li>';
                }
            echo '</ul>';

            if( get_page_by_path('best-of') ) { echo '<a class="excerpt-read-more" href="/best-of/">See All</a>'; }

            echo "</div>";
        }

        echo $after_widget;
    }

    //Update the widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;
    }

    function form( $instance ) {
        $defaults = array( 'title' => __("Best Of TRB", 'example'));
        $instance = wp_parse_args( (array) $instance, $defaults );

        ?>

        <!-- Title -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>


        <?php
    }
} // End Widg

?>
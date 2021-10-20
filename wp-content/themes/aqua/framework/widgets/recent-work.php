<?php
class TB_Recent_Work_Widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(
                'tb_recent_work_widget', // Base ID
                __('TB Recent Work', 'aqua'), // Name
                array('description' => __('Recent Work Widget', 'aqua'),) // Args
        );
    }
	function widget($args, $instance) {
		extract($args);
		$title = !empty($instance['title']) ? $instance['title'] : '';
        $number = !empty($instance['number']) ? esc_attr($instance['number']) : '';
		$extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : '';
		
		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $number
		);
		$wp_query = new WP_Query($args);
		
		// no 'class' attribute - add one with the value of width
        if (strpos($before_widget, 'class') === false) {
            $before_widget = str_replace('>', 'class="' . $extra_class . '"', $before_widget);
        }
        // there is 'class' attribute - append width value to it
        else {
            $before_widget = str_replace('class="', 'class="' . $extra_class . ' ', $before_widget);
        }
		ob_start();
        echo tb_filtercontent($before_widget);
		
		if ( $title ) echo tb_filtercontent($before_title . $title . $after_title);
		
		if($wp_query->have_posts()){
			echo "<ul>";
			while($wp_query->have_posts()){ $wp_query->the_post();
				if(has_post_thumbnail()){
					?><li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('thumbnail'); ?>
					</a></li><?php
				}
			}
			echo "</ul>";
		}
		
		echo tb_filtercontent($after_widget);
        echo ob_get_clean();
    }
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['number'] = $new_instance['number'];
		$instance['extra_class'] = $new_instance['extra_class'];
        return $instance;
    }
    function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __('Recent Work', 'aqua');
		$number = isset($instance['number']) ? esc_attr($instance['number']) : '6';
		$extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'aqua');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number:', 'aqua');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
		</p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>"><?php _e('Extra Class:', 'aqua'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php echo tb_filtercontent($extra_class); ?>" />
        </p>
		<?php
    }
}
/**
 * Class TB_Recent_Work_Widget
 */
function register_recent_work_widget() {
    register_widget('TB_Recent_Work_Widget');
}
add_action('widgets_init', 'register_recent_work_widget');
?>
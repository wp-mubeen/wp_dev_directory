<?php
class TB_Opentime_Widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(
                'tb_opentime_widget', // Base ID
                __('TB Opentime', 'aqua'), // Name
                array('description' => __('Opentime Widget', 'aqua'),) // Args
        );
    }
	function widget($args, $instance) {
		extract($args);
		$title = !empty($instance['title']) ? $instance['title'] : '';
        $time1 = !empty($instance['time1']) ? esc_attr($instance['time1']) : '';
        $time2 = !empty($instance['time2']) ? esc_attr($instance['time2']) : '';
        $time3 = !empty($instance['time3']) ? esc_attr($instance['time3']) : '';
		$extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : '';
		
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
		?>
		<ul class='tb-opentime'>
			<?php
				echo tb_filtercontent($time1 == '' ? '' : '<li>'.$time1.'</li>'); 
				echo tb_filtercontent($time2 == '' ? '' : '<li>'.$time2.'</li>'); 
				echo tb_filtercontent($time3 == '' ? '' : '<li>'.$time3.'</li>'); 
			?>
        </ul>
		<?php
		echo tb_filtercontent($after_widget);
        echo ob_get_clean();
    }
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['time1'] = $new_instance['time1'];
		$instance['time2'] = $new_instance['time2'];
		$instance['time3'] = $new_instance['time3'];
		$instance['extra_class'] = $new_instance['extra_class'];
        return $instance;
    }
    function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __('Opentime', 'aqua');
		$time1 = isset($instance['time1']) ? esc_attr($instance['time1']) : '';
		$time2 = isset($instance['time2']) ? esc_attr($instance['time2']) : '';
		$time3 = isset($instance['time3']) ? esc_attr($instance['time3']) : '';
		$extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
		?>
		<p>
			<label for="<?php echo esc_url($this->get_field_id('title')); ?>"><?php _e('Title:', 'aqua');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_url($this->get_field_id('time1')); ?>"><?php _e('Time 1:', 'aqua');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('time1')); ?>" name="<?php echo esc_attr($this->get_field_name('time1')); ?>" type="text" value="<?php echo esc_attr($time1); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_url($this->get_field_id('time2')); ?>"><?php _e('Time 2:', 'aqua');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('time2')); ?>" name="<?php echo esc_attr($this->get_field_name('time2')); ?>" type="text" value="<?php echo esc_attr($time2); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_url($this->get_field_id('time3')); ?>"><?php _e('Time 3:', 'aqua');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('time3')); ?>" name="<?php echo esc_attr($this->get_field_name('time3')); ?>" type="text" value="<?php echo esc_attr($time3); ?>" />
		</p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>"><?php _e('Extra Class:', 'aqua'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php echo tb_filtercontent($extra_class); ?>" />
        </p>
		<?php
    }
}
/**
 * Class TB_Opentime_Widget
 */
function register_opentime_widget() {
    register_widget('TB_Opentime_Widget');
}
add_action('widgets_init', 'register_opentime_widget');
?>
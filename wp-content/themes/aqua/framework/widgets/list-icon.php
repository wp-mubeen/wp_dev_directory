<?php
class TB_List_Icon_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
                'tb_list_icon_widget', // Base ID
                __('TB List Icon', 'aqua'), // Name
                array('description' => __('List Icon Widget', 'aqua'),) // Args
        );
    }
    function widget($args, $instance) {
        extract($args);
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : "";
        $icon = array();
        $text = array();
        for ($i = 1; $i <= 5; $i++) {
            $icon[$i] = !empty($instance['icon_' . $i]) ? esc_attr($instance['icon_' . $i]) : '';
            $text[$i] = !empty($instance['text_' . $i]) ? esc_attr($instance['text_' . $i]) : '';
        }
        // no 'class' attribute - add one with the value of width
        if (strpos($before_widget, 'class') === false) {
            $before_widget = str_replace('>', 'class="' . esc_attr($extra_class) . '"', $before_widget);
        }
        // there is 'class' attribute - append width value to it
        else {
            $before_widget = str_replace('class="', 'class="' . esc_attr($extra_class) . ' ', $before_widget);
        }
        ob_start();
        echo tb_filtercontent($before_widget);
        ?>
        <ul class='tb-list-icon'>
            <?php
            for ($i = 1; $i <= 5; $i++) {
                if($icon[$i] || $text[$i]){
                ?>
                <li>
                    <i class="<?php echo esc_attr($icon[$i]); ?>"></i> <span><?php echo esc_html($text[$i]); ?></span>
                </li>
			<?php
				}
			}
			?>
        </ul>
        <?php
        echo tb_filtercontent($after_widget);
        echo ob_get_clean();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
		$instance['title'] = $new_instance['title'];
        $instance['extra_class'] = $new_instance['extra_class'];
        for ($i = 1; $i <= 5; $i++) {
            $instance['icon_' . $i] = $new_instance['icon_' . $i];
            $instance['text_' . $i] = $new_instance['text_' . $i];
        }
        return $instance;
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
        $icon = array();
        $text = array();
        for ($i = 1; $i <= 5; $i++) {
            $icon[$i] = isset($instance['icon_' . $i]) ? esc_attr($instance['icon_' . $i]) : '';
            $text[$i] = isset($instance['text_' . $i]) ? esc_attr($instance['text_' . $i]) : '';
        }
		?>
		<p>
			<label for="<?php echo esc_url($this->get_field_id('title')); ?>"><?php _e('Title:', 'aqua');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<?php for ($i = 1; $i <= 5; $i++) { ?>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('icon_' . $i)); ?>"><?php _e('Icon:', 'aqua');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('icon_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('icon_' . $i)); ?>" type="text" value="<?php echo esc_attr($icon[$i]); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('text_' . $i)); ?>"><?php _e('Text:', 'aqua');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('text_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('text_' . $i)); ?>" type="text" value="<?php echo esc_attr($text[$i]); ?>" />
            </p>
        <?php } ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>"><?php _e('Extra Class:', 'aqua'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php echo esc_attr($extra_class); ?>" />
        </p>
        <?php
    }
}
/**
 * Class TB_List_Icon_Widget
 */
function register_list_icon_widget() {
    register_widget('TB_List_Icon_Widget');
}
add_action('widgets_init', 'register_list_icon_widget');
?>

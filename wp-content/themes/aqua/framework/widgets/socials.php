<?php
class TB_Social_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
                'tb_social_widget', // Base ID
                __('TB Socials', 'aqua'), // Name
                array('description' => __('Social Widget', 'aqua'),) // Args
        );
    }
    function widget($args, $instance) {
        extract($args);
        $show_tooltip = !empty($instance['show_tooltip']) ? $instance['show_tooltip'] : "";
        $tooltip_pos = !empty($instance['tooltip_pos']) ? $instance['tooltip_pos'] : "";
        $extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : "";
        $title_social = array();
        $icon_social_ = array();
        $link_social_ = array();
        for ($i = 1; $i <= 10; $i++) {
            $title_social[$i] = !empty($instance['title_social_' . $i]) ? esc_attr($instance['title_social_' . $i]) : '';
            $icon_social[$i] = !empty($instance['icon_social_' . $i]) ? esc_attr($instance['icon_social_' . $i]) : '';
            $link_social[$i] = !empty($instance['link_social_' . $i]) ? esc_attr($instance['link_social_' . $i]) : '';
        }
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
        ?>
        <ul class='tb-social'>
            <?php
            for ($i = 1; $i <= 10; $i++) {
                if($icon_social[$i]):
                ?>
                <li>
                    <a target="_blank" <?php echo tb_filtercontent($show_tooltip ? 'data-uk-tooltip="{pos:\'' . $tooltip_pos . '\'}"' : ''); ?> title="<?php echo esc_attr($title_social[$i]); ?>" href="<?php echo esc_url($link_social[$i]); ?>">
                        <i class="<?php echo tb_filtercontent($icon_social[$i]); ?>"></i>
                    </a>
                </li>
        <?php endif; ?>
        <?php } ?>
        </ul>
        <?php
        echo tb_filtercontent($after_widget);
        echo ob_get_clean();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        for ($i = 1; $i <= 10; $i++) {
            $instance['title_social_' . $i] = $new_instance['title_social_' . $i];
            $instance['icon_social_' . $i] = $new_instance['icon_social_' . $i];
            $instance['link_social_' . $i] = $new_instance['link_social_' . $i];
        }
        $instance['show_tooltip'] = $new_instance['show_tooltip'];
        $instance['tooltip_pos'] = $new_instance['tooltip_pos'];
        $instance['extra_class'] = $new_instance['extra_class'];
        return $instance;
    }

    function form($instance) {
        $title_social = array();
        $icon_social = array();
        $link_social = array();
        for ($i = 1; $i <= 10; $i++) {
            $title_social[$i] = isset($instance['title_social_' . $i]) ? esc_attr($instance['title_social_' . $i]) : '';
            $icon_social[$i] = isset($instance['icon_social_' . $i]) ? esc_attr($instance['icon_social_' . $i]) : '';
            $link_social[$i] = isset($instance['link_social_' . $i]) ? esc_attr($instance['link_social_' . $i]) : '';
        }
        $show_tooltip = isset($instance['show_tooltip']) ? esc_attr($instance['show_tooltip']) : '';
        $tooltip_pos = isset($instance['tooltip_pos']) ? esc_attr($instance['tooltip_pos']) : '';
        $extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
        for ($i = 1; $i <= 10; $i++) {
            ?>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('title_social_' . $i)); ?>"><?php _e('Social Title:', 'aqua');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title_social_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('title_social_' . $i)); ?>" type="text" value="<?php echo esc_attr($title_social[$i]); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('icon_social_' . $i)); ?>"><?php _e('Social Icon:', 'aqua');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('icon_social_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('icon_social_' . $i)); ?>" type="text" value="<?php echo esc_attr($icon_social[$i]); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('link_social_' . $i)); ?>"><?php _e('Social Link:', 'aqua');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link_social_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('link_social_' . $i)); ?>" type="text" value="<?php echo esc_attr($link_social[$i]); ?>" />
            </p>
        <?php } ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_tooltip')); ?>"><?php _e('Show tooltip:', 'aqua'); ?></label>
            <input class="widefat" <?php checked($show_tooltip, 1); ?> type="checkbox" id="<?php echo esc_attr($this->get_field_id('show_tooltip')); ?>" name="<?php echo esc_attr($this->get_field_name('show_tooltip')); ?>" value="1" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('tooltip_pos')); ?>"><?php _e('Tooltip Position:', 'aqua'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('tooltip_pos')); ?>" name="<?php echo esc_attr($this->get_field_name('tooltip_pos')); ?>">
                <option value="top" <?php selected($tooltip_pos, 'top'); ?>><?php _e('Top', 'aqua'); ?></option>
                <option value="bottom" <?php selected($tooltip_pos, 'bottom'); ?>><?php _e('Bottom', 'aqua'); ?></option>
                <option value="left" <?php selected($tooltip_pos, 'left'); ?>><?php _e('Left', 'aqua'); ?></option>
                <option value="right" <?php selected($tooltip_pos, 'right'); ?>><?php _e('Right', 'aqua'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>"><?php _e('Extra Class:', 'aqua'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php echo tb_filtercontent($extra_class); ?>" />
        </p>
        <?php
    }
}
/**
 * Class TB_Social_Widget
 */
function register_social_widget() {
    register_widget('TB_Social_Widget');
}
add_action('widgets_init', 'register_social_widget');
?>

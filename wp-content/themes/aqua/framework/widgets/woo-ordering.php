<?php
class TB_Woo_Ordering_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
                'tb_woo_ordering_widget', // Base ID
                __('TB Woocommerce Ordering', 'aqua'), // Name
                array('description' => __('Woocommerce Ordering Widget', 'aqua'),) // Args
        );
    }
    function widget($args, $instance) {
        extract($args);
		$extra_class = isset($instance['extra_class']) ? $instance['extra_class'] : '';
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$before_title = isset($before_title) ? $before_title : '<h2>';
		$after_title = isset($after_title) ? $after_title : '</h2>';
        ob_start();		
		$order = add_filter('woo_setting','setOrdering');
		if ( isset( $_SERVER['QUERY_STRING'] ) ) {
			parse_str($_SERVER['QUERY_STRING'], $params);
			$query_string = '?'.$_SERVER['QUERY_STRING'];
		} else {
			$query_string = '';
		}
		$odb = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
        echo tb_filtercontent($before_widget);
        ?>
		<div class="tb_woo_ordering_widget <?php echo tb_filtercontent($extra_class); ?>">
			<?php if ( $title ) echo tb_filtercontent($before_title . $title . $after_title); ?>
			<div class="btn-group"><a href="#" data-toggle="dropdown" role="link" aria-expanded="false" class="btn dropdown-toggle"><?php _e('Sort By ','aqua'); echo tb_filtercontent($odb); ?><span class="expand"></span></a>
			  <ul role="menu" class="dropdown-menu">
				<li><a href="<?php echo tb_addURLParameter($query_string, 'product_orderby', 'default')?>"><?php _e('Sort By Default','aqua');?></a></li>
				<li><a href="<?php echo tb_addURLParameter($query_string, 'product_orderby', 'price')?>"><?php _e('Sort By Price','aqua');?></a></li>
				<li><a href="<?php echo tb_addURLParameter($query_string, 'product_orderby', 'rand')?>"><?php _e('Sort By Random','aqua');?></a></li>
				<li><a href="<?php echo tb_addURLParameter($query_string, 'product_orderby', 'sales')?>"><?php _e('Sort By Sales','aqua');?></a></li>
				<li><a href="<?php echo tb_addURLParameter($query_string, 'product_orderby', 'name')?>"><?php _e('Sort By Name','aqua');?></a></li>
			  </ul>
			</div>
		</div>
        <?php
        echo tb_filtercontent($after_widget);
        echo ob_get_clean();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
		$instance['extra_class'] = $new_instance['extra_class'];
		$instance['title'] = $new_instance['title'];
        return $instance;
    }

    function form($instance) {
        $extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'aqua'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo tb_filtercontent($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>"><?php _e('Extra Class:', 'aqua'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php echo tb_filtercontent($extra_class); ?>" />
        </p>
        <?php
    }
}
/**
 * Class TB_Woo_Ordering_Widget
 */
function register_woo_ordering_widget() {
    register_widget('TB_Woo_Ordering_Widget');
}
add_action('widgets_init', 'register_woo_ordering_widget');

function setOrdering($orderby){
	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str($_SERVER['QUERY_STRING'], $params);
	}
	$odb = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	if($odb == 'default') return $orderby;
	return $odb;
}
?>

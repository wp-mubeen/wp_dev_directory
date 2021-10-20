<?php
class TB_Post_List_Widget extends RO_Widget {
	public function __construct() {
		$this->widget_cssclass    = 'tb-post tb-widget-post-list';
		$this->widget_description = __( 'Display a list of your posts on your site.', 'aqua' );
		$this->widget_id          = 'tb_post_list';
		$this->widget_name        = __( 'TB Post List', 'aqua' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Post List', 'aqua' ),
				'label' => __( 'Title', 'aqua' )
			),
			'category' => array(
				'type'   => 'tb_taxonomy',
				'std'    => '',
				'label'  => __( 'Categories', 'aqua' ),
			),
			'posts_per_page' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 3,
				'label' => __( 'Number of posts to show', 'aqua' )
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'date',
				'label' => __( 'Order by', 'aqua' ),
				'options' => array(
					'none'   => __( 'None', 'aqua' ),
					'title'  => __( 'Title', 'aqua' ),
					'date'   => __( 'Date', 'aqua' ),
					'ID'  => __( 'ID', 'aqua' ),
				)
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'none',
				'label' => __( 'Order', 'aqua' ),
				'options' => array(
					'none'  => __( 'None', 'aqua' ),
					'asc'  => __( 'ASC', 'aqua' ),
					'desc' => __( 'DESC', 'aqua' ),
				)
			),
			'el_class'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Extra Class', 'aqua' )
			)
		);
		parent::__construct();
		add_action('admin_enqueue_scripts', array($this, 'widget_scripts'));
	}
        
	public function widget_scripts() {
		wp_enqueue_script('widget_scripts', URI_PATH . '/framework/widgets/widgets.js');
	}

	public function widget( $args, $instance ) {
		
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();
		extract( $args );
                
		$title                  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$category               = isset($instance['category'])? $instance['category'] : '';
		$posts_per_page         = absint( $instance['posts_per_page'] );
		$orderby                = sanitize_title( $instance['orderby'] );
		$order                  = sanitize_title( $instance['order'] );
		$el_class               = sanitize_title( $instance['el_class'] );
                
                echo tb_filtercontent($before_widget);

                if ( $title )
                        echo tb_filtercontent($before_title . $title . $after_title);
                
                $query_args = array(
                    'posts_per_page' => $posts_per_page,
                    'orderby' => $orderby,
                    'order' => $order,
                    'post_type' => 'post',
                    'post_status' => 'publish');
                if (isset($category) && $category != '') {
                    $cats = explode(',', $category);
                    $category = array();
                    foreach ((array) $cats as $cat) :
                    $category[] = trim($cat);
                    endforeach;
                    $query_args['tax_query'] = array(
                                            array(
                                                'taxonomy' => 'category',
                                                'field' => 'id',
                                                'terms' => $category
                                            )
                                    );
                }
                $wp_query = new WP_Query($query_args);
				
				if ($wp_query->have_posts()){
					?>
					<div class="tb-post-list">
						<?php while ($wp_query->have_posts()){ $wp_query->the_post(); ?>
							<div class="tb-post-side">
								<div class="tb-post-side-img">
									<a class="post-featured-img" href="<?php the_permalink(); ?>">
										<?php
										if(has_post_thumbnail()){
											the_post_thumbnail('thumbnail');
										}else{
											echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr(URI_PATH.'/assets/images/post_default.jpg') .'">';
										}
										?>
									</a>
								</div>
								<div class="tb-post-side-ct">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<span class="date"><?php echo get_the_date('M jS, Y'); ?></span>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php 
				}
				
                wp_reset_postdata();

                echo tb_filtercontent($after_widget);
                
		$content = ob_get_clean();

		echo tb_filtercontent($content);

		$this->cache_widget( $args, $content );
	}
}
/* Class TB_Post_List_Widget */
function register_post_list_widget() {
    register_widget('TB_Post_List_Widget');
}

add_action('widgets_init', 'register_post_list_widget');

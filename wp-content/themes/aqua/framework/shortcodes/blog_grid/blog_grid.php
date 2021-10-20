<?php
function ro_blog_grid_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'category' => '',
		'posts_per_page' => -1,
		'columns' =>  3,
		'orderby' => 'none',
        'order' => 'none',
        'el_class' => '',
		'show_image' => 0,
		'show_title' => 0,
		'show_info' => 0,
        'show_excerpt' => 0,
    ), $atts));
			
    $class = array();
    $class[] = 'row ro-related-posts';
    $class[] = $el_class;
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
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
        $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'category',
                                    'field' => 'id',
                                    'terms' => $category
                                )
                        );
    }
    $wp_query = new WP_Query($args);
	
    ob_start();
	
	if ( $wp_query->have_posts() ) {
		$class_columns = array();
		switch ($columns) {
			case 1:
				$class_columns[] = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				break;
			case 2:
				$class_columns[] = 'col-xs-12 col-sm-12 col-md-6 col-lg-6';
				break;
			case 3:
				$class_columns[] = 'col-xs-12 col-sm-12 col-md-4 col-lg-4';
				break;
			case 4:
				$class_columns[] = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
				break;
			default:
				$class_columns[] = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
				break;
		}
    ?>
	<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<?php while ( $wp_query->have_posts() ) { $wp_query->the_post(); ?>
			<div class="<?php echo esc_attr(implode(' ', $class_columns)); ?>">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="ro-relate-posts-item">
						<?php if($show_image) { ?>
							<a href="<?php the_permalink(); ?>">
								<div class="ro-image"><?php the_post_thumbnail('full'); ?></div>
							</a>
						<?php } ?>
						<div class="ro-content">
							<?php if($show_title) { ?>
								<h4><a class="ro-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<?php } ?>
							<?php if($show_info) { ?>
								<p class="ro-info"><?php _e('By: ', 'aqua'); the_author(); ?>  /  <?php echo get_the_date('l, F, j, Y'); ?></p>
							<?php } ?>
							<?php if($show_excerpt) the_excerpt(); ?>
						</div>
					</div>
				</article>
			</div>
		<?php } ?>
	</div>
    <?php
	}
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('blog_grid', 'ro_blog_grid_func'); }

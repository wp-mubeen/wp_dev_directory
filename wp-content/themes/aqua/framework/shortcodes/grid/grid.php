<?php
function tb_grid_func($atts) {
    $image = $heading = $title = $icon = $el_class = '';
    extract(shortcode_atts(array(
        'post_type' => 'portfolio',//post, portfolio
		'category' => '',
		'portfolio_category' => '',
		'posts_per_page' => -1,
        'show_filter' => 0,
        'show_sorter' => 0,
        'columns' => 4,
        'tpl' => 'tpl1',
		'padding_item' => '0px',
        'crop_image' => 0,
        'width_image' => 300,
        'height_image' => 200,
        'show_title' => 0,
        'show_description' => 0,
        'excerpt_length' => 5,
        'excerpt_more' => '...',
        'orderby' => 'none',
        'order' => 'none',
        'el_class' => ''
    ), $atts));
    
    switch ($post_type) {
        case 'post':
            $taxonomy = 'category';
			$category = $category;
            break;
        case 'portfolio':
            $taxonomy = 'portfolio_category';
			$category = $portfolio_category;
            break;
        default :
            $taxonomy = 'portfolio_category';
			$category = $portfolio_category;
            break;
    }
	
    $class_columns = array();
	switch ($columns) {
		case 1:
			$class_columns[] = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
			break;
		case 2:
			$class_columns[] = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
			break;
		case 3:
			$class_columns[] = 'col-xs-12 col-sm-4 col-md-4 col-lg-4';
			break;
		case 4:
			$class_columns[] = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
			break;
		default:
			$class_columns[] = 'col-xs-12 col-sm-4 col-md-3 col-lg-3';
			break;
	}
    
    $class = array();
    $class[] = 'tb-grid';
    $class[] = $tpl;
    $class[] = $el_class;
    
    
    
    $args = array(
		'posts_per_page' => $posts_per_page,
        'post_type' => $post_type,
        'orderby' => $orderby,
        'order' => $order,
        'post_status' => 'publish'
    );
	if (isset($category) && $category != '') {
		$cats = explode(',', $category);
		$category = array();
		foreach ((array) $cats as $cat) :
		$category[] = trim($cat);
		endforeach;
		$args['tax_query'] = array(
								array(
									'taxonomy' => $taxonomy,
									'field' => 'id',
									'terms' => $category
								)
						);
	}
    
    $the_query = new WP_Query($args);
    
	wp_enqueue_script('jquery.mixitup.min', URI_PATH . '/assets/js/jquery.mixitup.min.js',array(),"2.1.5");
	
    ob_start();
    if ( $the_query->have_posts() ) {
    ?>
    <div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<?php if($show_filter == 1 || $show_sorter == 1){ ?>
		<div class="tb-grid-nav">
			<?php if($show_filter == 1){ ?>
			<ul class="controls-filter">
				<li class="filter" data-filter="all"><a class="tb-btn tbripple" href="javascript:void(0);"><?php _e('Show All', 'aqua');?></a></li>
				<?php
				$terms = get_terms($taxonomy);
					if ( !empty( $terms ) && !is_wp_error( $terms ) ){
						foreach ( $terms as $term ) {
						?>
							<li class="filter" data-filter=".<?php echo esc_attr($term->slug); ?>"><a class="tb-btn tbripple" href="javascript:void(0);"><?php echo tb_filtercontent($term->name); ?></a></li>
						<?php
						}
					}
				?>
			</ul>
			<?php } ?>
			<?php if($show_sorter == 1){ ?>
				<ul class="controls-sorter">
					<li class="sort" data-sort="random"><a class="tb-btn tbripple" href="javascript:void(0);"><?php _e('Random', 'aqua');?></a></li>
					<li class="sort" data-sort="myorder:asc"><a class="tb-btn tbripple" href="javascript:void(0);"><?php _e('Ascending', 'aqua');?></a></li>
					<li class="sort" data-sort="myorder:desc"><a class="tb-btn tbripple" href="javascript:void(0);"><?php _e('Descending', 'aqua');?></a></li>
				</ul>
			<?php } ?>
		</div>
		<?php } ?>
        <div id="Container" class="tb-grid-content">
			<?php while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                <?php
                $terms = wp_get_post_terms(get_the_ID(), $taxonomy);
                if ( !empty( $terms ) && !is_wp_error( $terms ) ){
                    $term_list = array();
                    foreach ( $terms as $term ) {
                        $term_list[] = $term->slug;
                    }
                }
                ?>
                <div class="mix de-blog <?php echo esc_attr(implode(' ', $term_list)); ?> <?php echo esc_attr(implode(' ', $class_columns)); ?>" data-myorder="<?php echo get_the_ID(); ?>" style="padding: <?php echo esc_attr($padding_item); ?>">
                    <?php include "$tpl.php"; ?> 
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    }else {
            echo 'Post not found!';
    } 
    wp_reset_postdata();
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_grid', 'tb_grid_func'); }

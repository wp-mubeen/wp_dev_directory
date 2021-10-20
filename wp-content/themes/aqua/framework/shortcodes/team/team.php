<?php
function ro_team_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'category' => '',
		'posts_per_page' => -1,
		'orderby' => 'none',
        'order' => 'none',
        'el_class' => '',
		'tpl' => 'tpl1',
        'show_image' => 0,
        'show_title' => 0,
        'show_excerpt' => 0,
        'show_position' => 0,
        'show_social' => 0,
    ), $atts));
			
    $class = array();
    $class[] = 'ro-team-wrapper';
    $class[] = $el_class;
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => $orderby,
        'order' => $order,
        'post_type' => 'team',
        'post_status' => 'publish');
    if (isset($category) && $category != '') {
        $cats = explode(',', $category);
        $category = array();
        foreach ((array) $cats as $cat) :
        $category[] = trim($cat);
        endforeach;
        $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'team_category',
                                    'field' => 'id',
                                    'terms' => $category
                                )
                        );
    }
    $wp_query = new WP_Query($args);
	
    ob_start();
	
	if ( $wp_query->have_posts() ) {
    ?>
	<div class="row <?php echo esc_attr(implode(' ', $class)); ?>">
		<?php while ( $wp_query->have_posts() ) { $wp_query->the_post(); ?>
			<div class="col-md-4">
				<?php include "tpl/{$tpl}.php"; ?>
			</div>
		<?php } ?>
	</div>
    <?php
	}
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('team', 'ro_team_func'); }

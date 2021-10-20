<?php
function tb_products_list_render($atts) {
    extract(shortcode_atts(array(		
		'post_type' 			=> 'product',
		'columns' 				=>  4,
		'tpl'					=> 'tpl1',
		'product_cat'       	=> '',
        'show'              	=> 'all_products',
        'number'            	=> -1,
        'show_sale_flash'   	=> 0,
        'show_title'        	=> 0,
        'show_price'        	=> 0,
        'show_rating'       	=> 0,
        'show_add_to_cart'  	=> 0,
        'show_btn_read_more'	=> 0,
        'hide_free'         	=> 0,
        'show_hidden'       	=> 0,
		'orderby'           	=> 'none',
        'order'             	=> 'none',
		'show_pagination' 		=> 1,
		'pos_pagination' 		=> 'text-center',
		'animation' 			=> '',
		'el_class' 				=> ''
    ), $atts));
	
	if($tpl == 'tpl2'){
		wp_enqueue_script('product.page.ajax', URI_PATH_FR . '/shortcodes/product_list/ajax-page.js');
		wp_localize_script( 'product.page.ajax', 'variable_js', array(
			'ajax_url' => admin_url( 'admin-ajax.php' )
		));
		
		$data_params = $atts;
	}
	
	$cl_effect = getCSSAnimation($animation);
    $class = array();
    $class[] = 'woocommerce tb-products-list';
    $class[] = $tpl;
    $class[] = $post_type;
	$class[] = $cl_effect;
	$class[] = $el_class;
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query_args = array(
            'posts_per_page' => $number,
			'paged' 		 => $paged,
            'post_status' 	 => 'publish',
            'post_type' 	 => $post_type,
            //'no_found_rows'  => 1,
            'order'          => $order == 'asc' ? 'asc' : 'desc'
    );

    $query_args['meta_query'] = array();

    if ( empty( $show_hidden ) ) {
                    $query_args['meta_query'][] = WC()->query->visibility_meta_query();
                    $query_args['post_parent']  = 0;
            }

            if ( ! empty( $hide_free ) ) {
            $query_args['meta_query'][] = array(
                        'key'     => '_price',
                        'value'   => 0,
                        'compare' => '>',
                        'type'    => 'DECIMAL',
                    );
    }

    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
    $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

    if (isset($product_cat) && $product_cat != '') {
        $cats = explode(',', $product_cat);
        $product_cat = array();
        foreach ((array) $cats as $cat) :
        $category[] = trim($cat);
        endforeach;

        $query_args['tax_query'] = array(
                    array(
                            'taxonomy' 		=> 'product_cat',
                            'terms' 		=> $category,
                            'field' 		=> 'id',
                            'operator' 		=> 'IN'
                    )
        );
    }
    switch ( $show ) {
            case 'featured' :
                    $query_args['meta_query'][] = array(
                                    'key'   => '_featured',
                                    'value' => 'yes'
                            );
                    break;
            case 'onsale' :
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                            $product_ids_on_sale[] = 0;
                            $query_args['post__in'] = $product_ids_on_sale;
                    break;
    }
	$orderby = apply_filters('woo_setting',$orderby);
    switch ( $orderby ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
				$query_args['orderby']  = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'name' :
				$query_args['orderby'] = 'title';
				break;
			default :
				$query_args['orderby']  = 'date';
    }

    $wp_query = new WP_Query( $query_args );
	ob_start();	
	if ( $wp_query->have_posts() ) {
    ?>
    <div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<div class="products" data-params="<?php echo ($tpl == 'tpl2')? esc_attr(json_encode($data_params)) : ''; ?>">
			<div class="tb-product-items row">
			<?php
				$loop = 0;
				$class_columns = array();
				switch ($columns) {
					case 1:
						$class_columns[] = 'col-xs-12 col-sm-12 col-md-12 col-lg-12 tb-product-item';
						break;
					case 2:
						$class_columns[] = 'col-xs-12 col-sm-6 col-md-6 col-lg-6 tb-product-item';
						break;
					case 3:
						$class_columns[] = 'col-xs-12 col-sm-6 col-md-4 col-lg-4 tb-product-item';
						break;
					case 4:
						$class_columns[] = 'col-xs-12 col-sm-6 col-md-3 col-lg-3 tb-product-item';
						break;
					default:
						$class_columns[] = 'col-xs-12 col-sm-6 col-md-3 col-lg-3 tb-product-item';
						break;
				}
				
				while ( $wp_query->have_posts() ) { $wp_query->the_post();
					$loop++;
					$start_row = $end_row = '';
					
					if( 0 == ( $loop - 1 ) % $columns || 1 == $columns ) 
						echo '';//'<div class="row tb-product-items">';
					if( (0 == ($loop - 1) % $columns) && $loop != 1 && $tpl == 'tpl2' ) echo '<div class="col-md-12 hidden-xs hidden-sm"><div class="tb-shoptab-separator"></div></div>';//'</div>';
						
					echo '<div class="'.esc_attr(implode(' ', $class_columns)).'">';
						include "{$tpl}.php";
					echo '</div>';
					
					
				}
				$curent_page =  max( 1, get_query_var('paged') );
				$page_count = ceil($wp_query->found_posts/$number);
				if( 0 != $loop % $columns && $curent_page == $page_count ) //echo '</div>';
			?>
			<div style="clear: both;"></div>
			</div>
		</div>
        <?php if($show_pagination){ ?>
			<nav class="pagination <?php echo esc_attr($pos_pagination); ?>" role="navigation">
				<?php
					$big = 999999999; // need an unlikely integer

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $wp_query->max_num_pages,
						'prev_text' => __( '<i class="fa fa-angle-left"></i>&nbsp; Previous', 'aqua' ),
						'next_text' => __( 'Next &nbsp;<i class="fa fa-angle-right"></i>', 'aqua' ),
					) );
				?>
			</nav>
		<?php } ?>
		 
    </div>
    <?php
    }else {
            echo 'Post not found!';
    } 
    ?>
    
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb-products-list', 'tb_products_list_render'); }

add_action( 'wp_ajax_nopriv_render_product_list', 'render_product_list' );
add_action( 'wp_ajax_render_product_list', 'render_product_list' );

function render_product_list() {
	//print_r($_POST);exit;
	extract($_POST['params']);
	$paged = $_POST['paged'];
	$post_type = (isset($$post_type))? $post_type : '';
	$query_args = array(
            'posts_per_page' => $number,
			'paged' 		 => $paged,
            'post_status' 	 => 'publish',
            'post_type' 	 => isset( $product )? $product : 'product',
            //'no_found_rows'  => 1,
            'order'          => $order == 'asc' ? 'asc' : 'desc'
    );

    $query_args['meta_query'] = array();

    if ( empty( $show_hidden ) ) {
                    $query_args['meta_query'][] = WC()->query->visibility_meta_query();
                    $query_args['post_parent']  = 0;
            }

            if ( ! empty( $hide_free ) ) {
            $query_args['meta_query'][] = array(
                        'key'     => '_price',
                        'value'   => 0,
                        'compare' => '>',
                        'type'    => 'DECIMAL',
                    );
    }

    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
    $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

    if (isset($product_cat) && $product_cat != '') {
        $cats = explode(',', $product_cat);
        $product_cat = array();
        foreach ((array) $cats as $cat) :
        $category[] = trim($cat);
        endforeach;

        $query_args['tax_query'] = array(
                    array(
                            'taxonomy' 		=> 'product_cat',
                            'terms' 		=> $category,
                            'field' 		=> 'id',
                            'operator' 		=> 'IN'
                    )
        );
    }
    switch ( $show ) {
            case 'featured' :
                    $query_args['meta_query'][] = array(
                                    'key'   => '_featured',
                                    'value' => 'yes'
                            );
                    break;
            case 'onsale' :
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                            $product_ids_on_sale[] = 0;
                            $query_args['post__in'] = $product_ids_on_sale;
                    break;
    }
	$orderby = apply_filters('woo_setting',$orderby);
    switch ( $orderby ) {
			case 'price' :
					$query_args['meta_key'] = '_price';
			$query_args['orderby']  = 'meta_value_num';
					break;
			case 'rand' :
			$query_args['orderby']  = 'rand';
					break;
			case 'sales' :
					$query_args['meta_key'] = 'total_sales';
			$query_args['orderby']  = 'meta_value_num';
					break;
			case 'name' :
				$query_args['orderby'] = 'title';
				break;
			default :
					$query_args['orderby']  = 'date';
    }

    $wp_query = new WP_Query( $query_args );
    ob_start();	
	if ( $wp_query->have_posts() ) {
		$loop = 0;
		$class_columns = array();
		switch ($columns) {
			case 1:
				$class_columns[] = 'col-xs-12 col-sm-12 col-md-12 col-lg-12 tb-product-item';
				break;
			case 2:
				$class_columns[] = 'col-xs-12 col-sm-6 col-md-6 col-lg-6 tb-product-item';
				break;
			case 3:
				$class_columns[] = 'col-xs-12 col-sm-6 col-md-4 col-lg-4 tb-product-item';
				break;
			case 4:
				$class_columns[] = 'col-xs-12 col-sm-6 col-md-3 col-lg-3 tb-product-item';
				break;
			default:
				$class_columns[] = 'col-xs-12 col-sm-6 col-md-3 col-lg-3 tb-product-item';
				break;
		}
		
		while ( $wp_query->have_posts() ) { $wp_query->the_post();
			$loop++;
			$start_row = $end_row = '';
			
			//if( 0 == ( $loop - 1 ) % $columns || 1 == $columns ) 
				//echo '';//'<div class="row tb-product-items">';
			//if( (0 == ($loop - 1) % $columns) && $loop != 1 && $tpl == 'tpl2' ) echo '<div class="col-md-12 hidden-xs hidden-sm"><div class="tb-shoptab-separator"></div></div>';//'</div>';	
			
			echo '<div class="'.esc_attr(implode(' ', $class_columns)).'">';
				include "{$tpl}.php";
			echo '</div>';
			
		}
		$curent_page =  max( 1, get_query_var('paged') );
		$page_count = ceil($wp_query->found_posts/$number);
		//if( 0 != $loop % $columns && $curent_page == $page_count ) echo '</div>';
	}
	wp_reset_postdata();
    $product_list_content = ob_get_clean(); 
    
    
	$big = 999999999; // need an unlikely integer
	ob_start();	
	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, $paged  ),
		'total' => $wp_query->max_num_pages,
		'prev_text' => __( '<i class="fa fa-angle-left"></i>&nbsp; Previous', 'aqua' ),
		'next_text' => __( 'Next &nbsp;<i class="fa fa-angle-right"></i>', 'aqua' ),
	) );
	$nav_content = ob_get_clean(); 			    
    
    echo json_encode(array( "products_content" => $product_list_content, "nav_content" => $nav_content)); exit;
}
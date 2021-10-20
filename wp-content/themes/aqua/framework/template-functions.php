<?php
if ( ! isset( $content_width ) ) $content_width = 900;
if ( is_singular() ) wp_enqueue_script( "comment-reply" );
if ( ! function_exists( 'tb_theme_setup' ) ) {
	function tb_theme_setup() {
		load_theme_textdomain( 'aqua', get_template_directory() . '/languages' );
		// Add Custom Header.
		add_theme_support('custom-header');
		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'main_navigation'   => __( 'Main Navigation','aqua' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery','status'
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'tbtheme_custom_background_args', array(
			'default-color' => 'f5f5f5',
		) ) );

		// Add support for featured content.
		add_theme_support( 'featured-content', array(
			'featured_content_filter' => 'tbtheme_get_featured_posts',
			'max_posts' => 6,
		) );
		
		add_theme_support( "title-tag" );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
}
add_action( 'after_setup_theme', 'tb_theme_setup' );
add_filter( 'post-format-status', 'tb_avia_status_content_filter', 10, 1 );

if(!function_exists('tb_avia_status_content_filter'))
{
	function tb_avia_status_content_filter($current_post)
	{
		/* FUNCTION HERE */
	}
}
/* Favicon */
if (!function_exists('tb_theme_favicon')) {
	function tb_theme_favicon() {
		global $tb_options;
		$icon = $tb_options['tb_favicon_image']['url'] ? $tb_options['tb_favicon_image']['url']: URI_PATH.'/favicon.ico';
		echo '<link rel="shortcut icon" href="' . esc_url($icon) . '"/>';
	}
}
add_action('wp_head', 'tb_theme_favicon');

/* Favicon */
if (!function_exists('tb_theme_logo')) {
	function tb_theme_logo() {
		global $tb_options,$post;
		$postid = isset($post->ID)?$post->ID:0;
		$logo = isset($tb_options['tb_logo_image']['url']) ? $tb_options['tb_logo_image']['url'] : URI_PATH.'/assets/images/logo.png';
		$logo = get_post_meta($postid, 'tb_custom_logo', true) ? get_post_meta($postid, 'tb_custom_logo', true):$logo;
		$tb_sub_logo = get_post_meta($postid, 'tb_sub_logo', true) ? get_post_meta($postid, 'tb_sub_logo', true):'';
		echo '<img src="'.esc_url($logo).'" alt="Logo"/>';
		if($tb_sub_logo):
			echo '<img src="'.esc_url($tb_sub_logo).'" alt="Logo"/>';		
		endif;
	}
}

/* Custom Site Title */
if (!function_exists('tb_theme_wp_title')) {
    function tb_theme_wp_title( $title, $sep ) {
            global $paged, $page;
            if ( is_feed() ) {
                    return $title;
            }
            // Add the site description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) ) {
                    $title = "$title $sep $site_description";
            }
            // Add a page number if necessary.
            if ( $paged >= 2 || $page >= 2 ) {
                    $title = "$title $sep " . sprintf( __( 'Page %s', 'aqua' ), max( $paged, $page ) );
            }
            return $title;
    }
}
add_filter( 'wp_title', 'tb_theme_wp_title', 10, 2 );

/* Page title */
if (!function_exists('tb_theme_page_title')) {
    function tb_theme_page_title() { 
            ob_start();
			if( is_home() ){
				_e('Home', 'aqua');
			}elseif(is_search()){
                _e('Search Keyword: ', 'aqua');
				echo '<span class="keywork">'. get_search_query(). '</span>';
            }elseif (!is_archive()) {
                the_title();
            } else { 
                if (is_category()){
                    single_cat_title();
                }elseif(get_post_type() == 'recipe' || get_post_type() == 'portfolio' || get_post_type() == 'produce' || get_post_type() == 'team' || get_post_type() == 'testimonial' || get_post_type() == 'myclients' || get_post_type() == 'product'){
                    single_term_title();
                }elseif (is_tag()){
                    single_tag_title();
                }elseif (is_author()){
                    printf(__('Author: %s', 'aqua'), '<span class="vcard">' . get_the_author() . '</span>');
                }elseif (is_day()){
                    printf(__('Day: %s', 'aqua'), '<span>' . get_the_date() . '</span>');
                }elseif (is_month()){
                    printf(__('Month: %s', 'aqua'), '<span>' . get_the_date('F Y') . '</span>');
                }elseif (is_year()){
                    printf(__('Year: %s', 'aqua'), '<span>' . get_the_date('Y') . '</span>');
                }elseif (is_tax('post_format', 'post-format-aside')){
                    _e('Asides', 'aqua');
                }elseif (is_tax('post_format', 'post-format-gallery')){
                    _e('Galleries', 'aqua');
                }elseif (is_tax('post_format', 'post-format-image')){
                    _e('Images', 'aqua');
                }elseif (is_tax('post_format', 'post-format-video')){
                    _e('Videos', 'aqua');
                }elseif (is_tax('post_format', 'post-format-quote')){
                    _e('Quotes', 'aqua');
                }elseif (is_tax('post_format', 'post-format-link')){
                    _e('Links', 'aqua');
                }elseif (is_tax('post_format', 'post-format-status')){
                    _e('Statuses', 'aqua');
                }elseif (is_tax('post_format', 'post-format-audio')){
                    _e('Audios', 'aqua');
                }elseif (is_tax('post_format', 'post-format-chat')){
                    _e('Chats', 'aqua');
                }else{
                    _e('Archives', 'aqua');
                }
            }
                
            return ob_get_clean();
    }
}

/* Page breadcrumb */
if (!function_exists('tb_theme_page_breadcrumb')) {
    function tb_theme_page_breadcrumb($delimiter) {
            ob_start();
			$delimiter = esc_attr($delimiter);
            $home = __('Home', 'aqua');
            $before = '<span class="current">'; // tag before the current crumb
            $after = '</span>'; // tag after the current crumb

            global $post;
            $homeLink = home_url();
			if( is_home() ){
				_e('Home', 'aqua');
			}else{
				echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
			}

            if ( is_category() ) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
                echo tb_filtercontent($before . __('Archive by category: ', 'aqua') . single_cat_title('', false) . $after);

            } elseif ( is_search() ) {
                echo tb_filtercontent($before . __('Search results for: ', 'aqua') . get_search_query() . $after);

            } elseif ( is_day() ) {
                echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F').' '. get_the_time('Y') . '</a> ' . $delimiter . ' ';
                echo tb_filtercontent($before . get_the_time('d') . $after);

            } elseif ( is_month() ) {
                echo tb_filtercontent($before . get_the_time('F'). ' '. get_the_time('Y') . $after);

            } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                if(get_post_type() == 'portfolio'){
                    $terms = get_the_terms(get_the_ID(), 'portfolio_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'portfolio_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo tb_filtercontent($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'recipe'){
                    $terms = get_the_terms(get_the_ID(), 'recipe_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'recipe_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo tb_filtercontent($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'produce'){
                    $terms = get_the_terms(get_the_ID(), 'produce_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'produce_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo tb_filtercontent($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'team'){
                    $terms = get_the_terms(get_the_ID(), 'team_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'team_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo tb_filtercontent($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'testimonial'){
                    $terms = get_the_terms(get_the_ID(), 'testimonial_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'testimonial_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo tb_filtercontent($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'myclients'){
                    $terms = get_the_terms(get_the_ID(), 'clientscategory', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'clientscategory', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo tb_filtercontent($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'product'){
                    $terms = get_the_terms(get_the_ID(), 'product_cat', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'product_cat', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo tb_filtercontent($before . get_the_title() . $after);
                    }
                }else{
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                    echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                }

            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo tb_filtercontent($cats);
                echo tb_filtercontent($before . get_the_title() . $after);
            }

            } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                $post_type = get_post_type_object(get_post_type());
				if($post_type) echo tb_filtercontent($before . $post_type->labels->singular_name . $after);
            } elseif ( is_attachment() ) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID); $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            } elseif ( is_page() && !$post->post_parent ) {
                echo tb_filtercontent($before . get_the_title() . $after);

            } elseif ( is_page() && $post->post_parent ) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo tb_filtercontent($breadcrumbs[$i]);
                    if ($i != count($breadcrumbs) - 1)
                        echo ' ' . $delimiter . ' ';
                }
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

            } elseif ( is_tag() ) {
                echo tb_filtercontent($before . __('Posts tagged: ', 'aqua') . single_tag_title('', false) . $after);
            } elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata($author);
                echo tb_filtercontent($before . __('Articles posted by ', 'aqua') . $userdata->display_name . $after);
            } elseif ( is_404() ) {
                echo tb_filtercontent($before . __('Error 404', 'aqua') . $after);
            }

            if ( get_query_var('paged') ) {
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                    echo ' '.$delimiter.' '.__('Page', 'aqua') . ' ' . get_query_var('paged');
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
            }
                
            return ob_get_clean();
    }
}

/* Custom excerpt */
function tb_custom_excerpt($limit, $more) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit || $limit != -1) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . $more;
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
}
/* Display navigation to next/previous set of posts */
if ( ! function_exists( 'tb_theme_paging_nav' ) ) {
	function tb_theme_paging_nav() {
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
				'base'     => $pagenum_link,
				'format'   => $format,
				'total'    => $GLOBALS['wp_query']->max_num_pages,
				'current'  => $paged,
				'mid_size' => 1,
				'add_args' => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '<i class="fa fa-angle-left"></i>&nbsp; Previous', 'aqua' ),
				'next_text' => __( 'Next &nbsp;<i class="fa fa-angle-right"></i>', 'aqua' ),
		) );

		if ( $links ) {
		?>
		<nav class="pagination text-right" role="navigation">
			<?php echo tb_filtercontent($links); ?>
		</nav>
		<?php
		}
	}
}
/* Display navigation to next/previous post */
if ( ! function_exists( 'tb_theme_post_nav' ) ) {
	function tb_theme_post_nav() {
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation clearfix" role="navigation">
			<div class="nav-links">
				<?php
					previous_post_link( '<div class="nav-previous">%link</div>', __( '<span class="btn btn-default"><i class="fa fa-angle-left"></i>&nbsp; Previous</span>', 'aqua' ) );
					next_post_link(     '<div class="nav-next">%link</div>',     __( '<span class="btn btn-default">Next &nbsp;<i class="fa fa-angle-right"></i></span>', 'aqua' ) );
				?>
			</div>
		</nav>
		<?php
	}
}
/* Title Bar */
if ( ! function_exists( 'tb_theme_title_bar' ) ) {
	function tb_theme_title_bar($tb_show_page_title, $tb_show_page_breadcrumb) {
		global $tb_options;
		$delimiter = isset($tb_options['tb_page_breadcrumb_delimiter']) ? $tb_options['tb_page_breadcrumb_delimiter'] : '/';
		$cl_page_title = $cl_page_breadcrumb = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
		$tpl = isset($tb_options['tb_title_bar_layout']) ? $tb_options['tb_title_bar_layout'] : 'tpl1';
		$class = array();
		$class[] = 'title-bar';
		$class[] = $tpl;
		if($tpl == 'tpl1'){
			if($tb_show_page_title && $tb_show_page_breadcrumb){
				$cl_page_title = $cl_page_breadcrumb = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
			}else{
				if($tb_show_page_title){
					$cl_page_title = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				}
				if($tb_show_page_breadcrumb){
					$cl_page_breadcrumb = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				}
			}
		}
		
		if($tb_show_page_title || $tb_show_page_breadcrumb){ 
		?>
			<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
				<div class="container container-height">
					<div class="row row-height">
						<?php if($tb_show_page_title){ ?>
							<div class="<?php echo esc_attr($cl_page_title); ?> col-height col-middle">
								<h1 class="page-title"><?php echo tb_theme_page_title(); ?></h1>
							</div>
						<?php } ?>
						<?php if($tb_show_page_breadcrumb){ ?>
							<div class="<?php echo esc_attr($cl_page_breadcrumb); ?> col-height col-middle">
								<div class="page-breadcrumb"><?php echo tb_theme_page_breadcrumb($delimiter); ?></div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php 
		}
	}
}
/*Custom comment list*/
function tb_custom_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo tb_filtercontent($tag) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
			<div class="comment-avatar">
				<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div>
			<div class="comment-info">
				<div class="comment-author vcard">
				<?php printf( __( '<h4>%s</h4>','aqua' ), get_comment_author_link() ); ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'aqua' ); ?></em>
					<br />
				<?php endif; ?>

				<?php comment_text(); ?>
				<div class="comment-footer">
					<div class="comment-meta commentmetadata">
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php
							/* translators: 1: date, 2: time */
							printf( __('%1$s at %2$s','aqua'), get_comment_date(),  get_comment_time() ); ?>
						</a>
						<?php edit_comment_link( __( '(Edit)', 'aqua' ), '  ', '' ); ?>
					</div>
					
					<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
				</div>
			</div>
			
	<?php if ( 'div' != $args['style'] ) : ?>
		</div>
	<?php endif; ?>
<?php
}

function tb_addURLParameter($url, $paramName, $paramValue) {
	 $url_data = parse_url($url);
	 if(!isset($url_data["query"]))
		 $url_data["query"]="";

	 $params = array();
	 parse_str($url_data['query'], $params);
	 $params[$paramName] = $paramValue;

	 if( $paramName == 'product_count' ) {
	 	$params['paged'] = '1';
	 }

	 $url_data['query'] = http_build_query($params);
	 return tb_build_url($url_data);
}


function tb_build_url($url_data) {
	 $url="";
	 if(isset($url_data['host']))
	 {
		 $url .= $url_data['scheme'] . '://';
		 if (isset($url_data['user'])) {
			 $url .= $url_data['user'];
				 if (isset($url_data['pass'])) {
					 $url .= ':' . $url_data['pass'];
				 }
			 $url .= '@';
		 }
		 $url .= $url_data['host'];
		 if (isset($url_data['port'])) {
			 $url .= ':' . $url_data['port'];
		 }
	 }
	 if (isset($url_data['path'])) {
	 	$url .= $url_data['path'];
	 }
	 if (isset($url_data['query'])) {
		 $url .= '?' . $url_data['query'];
	 }
	 if (isset($url_data['fragment'])) {
		 $url .= '#' . $url_data['fragment'];
	 }
	 return $url;
}
/* Filter Format Currencty position */
add_filter('woocommerce_price_format','tb_woocommerce_price_format', 10, 2);
function tb_woocommerce_price_format($format, $currency_pos){
	$currency_pos = get_option( 'woocommerce_currency_pos' );
	if(!$currency_pos):
		update_option( 'woocommerce_currency_pos', 'left' );
	endif;
}
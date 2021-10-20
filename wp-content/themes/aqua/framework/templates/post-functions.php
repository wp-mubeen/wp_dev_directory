<?php
/* Title */
if (!function_exists('tb_theme_title_render')) {
	function tb_theme_title_render(){
		global $tb_options;
		ob_start();
		?>
		<?php if(is_single()){ ?>
			<?php if(get_the_title()){ ?>
				<h2 class="blog-title"><?php the_title(); ?></h2>
			<?php } else { ?>    
				<h2 class="blog-title"><a href="<?php the_permalink(); ?>"><?php _e('Read more...', 'aqua');; ?></a></h2>
			<?php } ?>
		<?php }else{ ?>
			<?php if(get_the_title()){ ?>
				<h2 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php }
		}
		return  ob_get_clean();
	}
}
/* Info Bar */
if (!function_exists('tb_theme_info_bar_render')) {
	function tb_theme_info_bar_render() {
		global $tb_options;
		ob_start();
			?>
			<div class="blog-info">
				<!--span class="categories"><?php the_terms(get_the_ID(), 'category', __('Categories: ', 'aqua') , ', ' ); ?></span-->
				<!--span class="tags"><?php the_tags( __('Tags: ', 'aqua'), ', ', '' ); ?> </span-->
				<span class="publish-date" data-datetime="<?php echo get_the_date('Y-m-j') . ' ' . get_the_time('H:i:s'); ?>" data-pubdate="pubdate">
				   <?php 
					$archive_year  = get_the_time('Y'); 
					$archive_month = get_the_time('m'); 
					$archive_day   = get_the_time('d'); 
					?>
				   <?php _e('Posted: ', 'aqua'); ?><a href="<?php echo get_day_link($archive_year, $archive_month, $archive_day); ?>"><?php echo get_the_date('F j, Y'); ?></a>
				</span>
				<span class="author-name"><?php _e('By: ', 'aqua'); the_author_posts_link(); ?></span>
				<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
					<?php if(is_single()){ ?>
						<span class="comments-number"><?php comments_number( __( 'Comment: 0', 'aqua' ), __( 'Comment: 1', 'aqua' ), __( 'Comment: %', 'aqua' ) ); ?></span>
					<?php }else{ ?>
						<span class="comments-number"><?php _e( 'Comment: ', 'aqua' ); ?><a href="<?php echo get_comments_link(); ?>"><?php comments_number( '0', '1', '%') ?></a></span>
					<?php } ?>
				<?php } ?>
				
				<span class="line-end"></span>
			</div>
			<?php
			return  ob_get_clean();
	}
}
/* Post gallery */
if (!function_exists('tb_theme_grab_ids_from_gallery')) {

    function tb_theme_grab_ids_from_gallery() {
        global $post;
        $gallery = tb_theme_get_shortcode_from_content('gallery');
        $object = new stdClass();
        $object->columns = '3';
        $object->link = 'post';
        $object->ids = array();
        if ($gallery) {
            $object = tb_theme_extra_shortcode('gallery', $gallery, $object);
        }
        return $object;
    }

}
/* Extra shortcode */
if (!function_exists('tb_theme_extra_shortcode')) {
    function tb_theme_extra_shortcode($name, $shortcode, $object) {
        if ($shortcode && is_object($object)) {
            $attrs = str_replace(array('[', ']', '"', $name), null, $shortcode);
            $attrs = explode(' ', $attrs);
            if (is_array($attrs)) {
                foreach ($attrs as $attr) {
                    $_attr = explode('=', $attr);
                    if (count($_attr) == 2) {
                        if ($_attr[0] == 'ids') {
                            $object->$_attr[0] = explode(',', $_attr[1]);
                        } else {
                            $object->$_attr[0] = $_attr[1];
                        }
                    }
                }
            }
        }
        return $object;
    }
}
/* Get Shortcode Content */
if (!function_exists('tb_theme_get_shortcode_from_content')) {

    function tb_theme_get_shortcode_from_content($param) {
        global $post;
        $pattern = get_shortcode_regex();
        $content = $post->post_content;
        if (preg_match_all('/' . $pattern . '/s', $content, $matches) && array_key_exists(2, $matches) && in_array($param, $matches[2])) {
            $key = array_search($param, $matches[2]);
            return $matches[0][$key];
        }
    }

}
/* Remove Shortcode */
if (!function_exists('tb_theme_remove_shortcode_from_content')) {
	function tb_theme_remove_shortcode_from_content( $content ) {
		global $post;
		$format = get_post_format();
		if ( is_single() && 'gallery' == $format ) {
			$content = strip_shortcodes( $content );
		}
		return $content;
	}
}
/* add_filter( 'the_content', 'tb_theme_remove_shortcode_from_content' ); */
/* Content */
if (!function_exists('tb_theme_content_render')) {
	function tb_theme_content_render(){
		global $tb_options;
		$tb_post_excerpt_leng = (int) isset($tb_options['tb_blog_post_excerpt_leng']) ? $tb_options['tb_blog_post_excerpt_leng'] : 0;
		$tb_post_excerpt_more = isset($tb_options['tb_blog_post_excerpt_more']) ? $tb_options['tb_blog_post_excerpt_more'] : '';
		
		ob_start();
		$read_more_text = is_home() ? __('Read More', 'aqua') : '';
		?>
		<?php if (is_single() || is_home()) { ?>
				<div class="blog-desc">
					<?php
					if(has_excerpt()):
						the_excerpt();						
					else:
						the_content($read_more_text);					
					endif;
					
					wp_link_pages(array(
						'before' => '<div class="page-links">' . __('Pages:', 'aqua'),
						'after' => '</div>',
					));
					?>
				</div>
			<?php } else { ?>
				<div class="blog-desc">
					<?php echo tb_custom_excerpt($tb_post_excerpt_leng, $tb_post_excerpt_more); ?>
				</div>
			<?php } ?>
		<?php
		return  ob_get_clean();
	}
}
/*Tags*/
if (!function_exists('tb_theme_tags_render')) {
	function tb_theme_tags_render(){
		ob_start();
		?>
		<?php if (is_single()) { ?>
				<div class="tag-links">
					<?php the_tags(); ?>
				</div>
			<?php }?>
		<?php
		return  ob_get_clean();
	}
}
/*Author*/
if ( ! function_exists( 'tb_theme_author_render' ) ) {
	function tb_theme_author_render() {
		ob_start();
		?>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
			<span class="featured-post"> <?php _e( 'Sticky', 'aqua' ); ?></span>
		<?php } ?>
		<div class="about-author"> 
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 170 ); ?>
			</div>
			<div class="author-info">
				<span class="subtitle"><?php _e( 'AUTHOR', 'aqua' ); ?></span>
				<h4 class="name"><?php the_author_meta('display_name'); ?></h4>
				<p class="desc"><?php the_author_meta('description'); ?></p>
				<a class="read-more" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php _e('All stories by: ', 'aqua'); the_author_meta('display_name'); ?></a>
			</div>
		</div>
		<?php
		return  ob_get_clean();
	} 
}
/* Social share */
if ( ! function_exists('tb_theme_social_share_post_render') ) {
	function tb_theme_social_share_post_render() {
		global $post;
		$post_title = $post->post_title;
		$permalink = get_permalink($post->ID);
		$title = get_the_title();
		$output = '';
		$output .= '<div class="tb-social-buttons">
			'.__('Share: ', 'aqua').'
			<a class="icon-twitter" href="http://twitter.com/share?text='.$title.'&url='.$permalink.'"
				onclick="window.open(this.href, \'twitter-share\', \'width=550,height=235\');return false;">
				<span>Twitter</span>
			</a>             
			<a class="icon-fb" href="https://www.facebook.com/sharer/sharer.php?u='.$permalink.'"
				 onclick="window.open(this.href, \'facebook-share\',\'width=580,height=296\');return false;">
				<span>Facebook</span>
			</a>         
			<a class="icon-gplus" href="https://plus.google.com/share?url='.$permalink.'"
			   onclick="window.open(this.href, \'google-plus-share\', \'width=490,height=530\');return false;">
				<span>Google+</span>
			</a>
		</div>';
		return $output;
	}
}

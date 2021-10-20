<?php
$link = get_post_meta(get_the_ID(), 'tb_post_link', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('text-center'); ?>>
	<?php if($show_title){ ?>
		<h2 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php } ?>
	<?php if($show_info){ ?>
		<div class="blog-info text-center">
			<div style="width: 70%; margin: auto;" class="separator-icon text-center">
				<span><i class="fa fa-link"></i></span>
			</div>
			<time class="publish-date" datetime="<?php echo get_the_date('Y-m-j') . ' ' . get_the_time('H:i:s'); ?>" pubdate="pubdate">
			   <?php echo get_the_date('F j, Y'); ?>
			</time>
		</div>
	<?php } ?>
	<?php if($link){ ?>
		<div class="blog-link"><a href="<?php echo esc_url($link); ?>"><?php echo tb_filtercontent($link); ?></a></div>
	<?php } ?>
	<?php if($show_desc) echo '<div class="blog-desc">'.tb_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
</article>

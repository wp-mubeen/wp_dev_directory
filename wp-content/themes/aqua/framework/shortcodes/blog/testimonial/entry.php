<article id="post-<?php the_ID(); ?>" <?php post_class('text-center'); ?>>
	<?php if($show_title) echo tb_theme_title_render(); ?>
	<?php if($show_desc) echo '<div class="blog-desc">'.tb_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
</article>
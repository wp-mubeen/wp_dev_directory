<?php
$quote_type = get_post_meta(get_the_ID(), 'tb_post_quote_type', true);
$quote_author = get_the_title();
$quote_content = get_the_content();

if($quote_type == 'custom'){
	$quote_content = get_post_meta(get_the_ID(), 'tb_post_quote', true);
	$quote_author = get_post_meta(get_the_ID(), 'tb_post_author', true);
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('text-center'); ?>>
	<?php if($show_title){ ?>
		<h2 class="blog-title text-center"><a href="<?php the_permalink(); ?>"><?php echo tb_filtercontent($quote_author); ?></a></h2>
	<?php } ?>
	<?php if($show_info){ ?>
		<div class="blog-info">
			<div style="width: 70%; margin: auto;" class="separator-icon text-center">
				<span><i class="fa fa-quote-left"></i></span>
			</div>
			<span class="publish-date" data-datetime="<?php echo get_the_date('Y-m-j') . ' ' . get_the_time('H:i:s'); ?>" data-pubdate="pubdate">
			   <?php echo get_the_date('F j, Y'); ?>
			</span>
		</div>
	<?php } ?>
	<?php if($show_desc){ ?>
		<div class="blog-quote"><?php echo tb_filtercontent($quote_content); ?></div>
	<?php } ?>
</article>
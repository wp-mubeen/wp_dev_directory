<?php
global $tb_options;
if(is_home()){
	$tb_show_post_title = 1;
	$tb_show_post_desc = 1;
	$tb_show_post_info = 1;
}elseif (is_single()) {
	$tb_show_post_title = (int) isset($tb_options['tb_post_show_post_title']) ? $tb_options['tb_post_show_post_title'] : 1;
	$tb_show_post_info = (int) isset($tb_options['tb_post_show_post_info']) ? $tb_options['tb_post_show_post_title'] : 1;
	$tb_post_show_social_share = (int) isset($tb_options['tb_post_show_social_share']) ? $tb_options['tb_post_show_social_share'] : 1;
	$tb_post_show_post_tags = (int) isset($tb_options['tb_post_show_post_tags']) ? $tb_options['tb_post_show_post_tags'] : 1;
	$tb_post_show_post_author = (int) isset($tb_options['tb_post_show_post_author']) ? $tb_options['tb_post_show_post_author'] : 1;
	$tb_show_post_desc = 1;
}else{
	$tb_show_post_title = (int) isset($tb_options['tb_blog_show_post_title']) ? $tb_options['tb_blog_show_post_title'] : 1;
	$tb_show_post_info = (int) isset($tb_options['tb_blog_show_post_info']) ? $tb_options['tb_blog_show_post_title'] : 1;
	$tb_show_post_desc = (int) isset($tb_options['tb_blog_show_post_desc']) ? $tb_options['tb_blog_show_post_desc'] : 1;
}
$quote_type = get_post_meta(get_the_ID(), 'tb_post_quote_type', true);
$quote_author = get_the_title();
$quote_content = get_the_content();

if($quote_type == 'custom'){
	$quote_content = get_post_meta(get_the_ID(), 'tb_post_quote', true);
	$quote_author = get_post_meta(get_the_ID(), 'tb_post_author', true);
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($tb_show_post_title){ ?>
		<h2 class="blog-title"><a href="<?php the_permalink(); ?>"><?php echo tb_filtercontent($quote_author); ?></a></h2>
	<?php } ?>
	<?php if($tb_show_post_desc){ ?>
		<div class="blog-quote"><?php echo tb_filtercontent($quote_content); ?></div>
	<?php } ?>
	<?php if($tb_show_post_info) echo tb_theme_info_bar_render(); ?>
	<div class="tb-content-block">
		<?php if(is_single() && $tb_post_show_social_share) echo tb_theme_social_share_post_render(); ?>
		<?php if(is_single() && $tb_post_show_post_tags) echo tb_theme_tags_render(); ?>
		<?php if(is_single() && $tb_post_show_post_author) echo tb_theme_author_render(); ?>
	</div>
</article>
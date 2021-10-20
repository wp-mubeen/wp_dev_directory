<?php get_header(); ?>
<?php
global $tb_options;
$tb_show_page_title = isset($tb_options['tb_post_show_page_title']) ? $tb_options['tb_post_show_page_title'] : 1;
$tb_show_page_breadcrumb = isset($tb_options['tb_post_show_page_breadcrumb']) ? $tb_options['tb_post_show_page_breadcrumb'] : 1;
tb_theme_title_bar($tb_show_page_title, $tb_show_page_breadcrumb);

$tb_show_post_nav = (int) isset($tb_options['tb_post_show_post_nav']) ?  $tb_options['tb_post_show_post_nav']: 1;
$tb_show_post_comment = (int) isset($tb_options['tb_post_show_post_comment']) ?  $tb_options['tb_post_show_post_comment']: 1;
?>
	<div class="main-content">
		<div class="container">
			<div class="row">
				<?php
					$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				?>
				<!-- Start Content -->
				<div class="<?php echo esc_attr($cl_content) ?> content tb-blog">
					<?php
					while ( have_posts() ) : the_post();
					echo get_post_format();
						get_template_part( 'framework/templates/team/entry', get_post_format());
						// Previous/next post navigation.
						if($tb_show_post_nav) tb_theme_post_nav();
					endwhile;
					?>
				</div>
				<!-- End Content -->
			</div>
		</div>
	</div>
<?php get_footer(); ?>
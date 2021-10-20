		<?php global $tb_options; ?>
		<?php if($tb_options['tb_display_footer']){ ?>
		<div class="tb_footer<?php echo (get_post_meta(get_the_ID(), 'tb_footer', true)) ? ' '.esc_attr(get_post_meta(get_the_ID(), 'tb_footer', true)) : ''; ?>">
			<div class="container">
				<!-- Start Footer Top -->
				<?php if($tb_options['tb_footer_top_column']){ ?>
				<div class="footer-top">
					<div class="row same-height">
						<!-- Start Footer Sidebar Top 1 -->
						<?php if($tb_options['tb_footer_top_column']>=1){ ?>
							<div class="<?php echo esc_attr($tb_options['tb_footer_top_col1']); ?>  tb_footer_top_once">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Top Widget 1")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 1 -->
						<!-- Start Footer Sidebar Top 2 -->
						<?php if($tb_options['tb_footer_top_column']>=2){ ?>
							<div class="<?php echo esc_attr($tb_options['tb_footer_top_col2']); ?> tb_footer_top_two">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Top Widget 2")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 2 -->
						<!-- Start Footer Sidebar Top 3 -->
						<?php if($tb_options['tb_footer_top_column']>=3){ ?>
							<div class="<?php echo esc_attr($tb_options['tb_footer_top_col3']); ?> tb_footer_top_three">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Top Widget 3")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 3 -->
						<!-- Start Footer Sidebar Top 4 -->
						<?php if($tb_options['tb_footer_top_column']>=4){ ?>
							<div class="<?php echo esc_attr($tb_options['tb_footer_top_col4']); ?> tb_footer_top_four">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Top Widget 4")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 4 -->
					</div>
				</div>
				<?php } ?>
				<!-- End Footer Top -->
				<!-- Start Footer Bottom -->
				<?php if($tb_options['tb_footer_bottom_column']){ ?>
				<div class="footer-bottom">
					<div class="row">
						<!-- Start Footer Sidebar Bottom Left -->
						<?php if($tb_options['tb_footer_bottom_column']>=1){ ?>
							<div class="<?php echo esc_attr($tb_options['tb_footer_bottom_col1']); ?>">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Bottom Widget 1")): endif; ?>
							</div>
						<?php } ?>
						<!-- Start Footer Sidebar Bottom Left -->
						<!-- Start Footer Sidebar Bottom Right -->
						<?php if($tb_options['tb_footer_bottom_column']>=2){ ?>
							<div class="<?php echo esc_attr($tb_options['tb_footer_bottom_col2']); ?>">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Bottom Widget 2")): endif; ?>
							</div>
						<?php } ?>
						<!-- Start Footer Sidebar Bottom Right -->
					</div>
				</div>
				<?php } ?>
				<!-- End Footer Bottom -->
			</div>
		</div>
		<?php } ?>
	</div><!-- #wrap -->
	<a id="tb_back_to_top">
		<span class="go_up">
		<i class="icon-up"></i> 
		</span>
	</a>
	<?php wp_footer(); ?>
</body>
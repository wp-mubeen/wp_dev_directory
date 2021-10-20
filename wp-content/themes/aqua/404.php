<?php
/*
Template Name: 404 Template
*/
?>
<?php get_header('404'); ?>
	<div class="main-content">
		<div class="">
			<div class="error404-wrap-aqua" >
				<div class="content-404-aqua">
					<div class="error-code-aqua"><?php _e('404 OOPS','aqua');?></div>
					<p class="error-message-aqua">
						<i><?php _e('The page you\'re looking for not found ','aqua');?></i></br>
					</p>
					<a class="tb-btn-bd-2" title="<?php _e('Home','aqua');?>" href="<?php echo esc_url( home_url( '/'  ) );?>"><i class="fa fa-home"></i><?php _e('Back','aqua');?></a>
				</div>
			</div>
		</div>
	</div> 
<?php get_footer('404'); ?>
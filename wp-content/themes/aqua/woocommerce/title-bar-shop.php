<?php
	global $tb_options;
	$tb_show_page_title_shop = isset($tb_options['tb_show_page_title_shop']) ? $tb_options['tb_show_page_title_shop'] : 0;
	$tb_show_page_breadcrumb_shop = isset($tb_options['tb_show_page_breadcrumb_shop']) ? $tb_options['tb_show_page_breadcrumb_shop'] : 0;
	$cl_page_title = $cl_page_breadcrumb = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$tpl = isset($tb_options['tb_title_bar_layout']) ? $tb_options['tb_title_bar_layout'] : 'tpl1';
	$class = array();
	$class[] = 'title-bar';
	$class[] = $tpl;
	if($tpl == 'tpl1'){
		if($tb_show_page_title_shop && $tb_show_page_breadcrumb_shop){
			$cl_page_title = $cl_page_breadcrumb = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
		}else{
			if($tb_show_page_title_shop){
				$cl_page_title = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
			}
			if($tb_show_page_breadcrumb_shop){
				$cl_page_breadcrumb = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
			}
		}
	}
?>
<?php if($tb_show_page_title_shop || $tb_show_page_breadcrumb_shop){ ?>
	<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<div class="container container-height">
			<div class="row row-height">
				<?php if($tb_show_page_title_shop){ ?>
					<div class="<?php echo esc_attr($cl_page_title); ?> col-height col-middle">
						<h1 class="page-title"><?php echo tb_woocommerce_page_title(); ?></h1>
					</div>
				<?php } ?>
				<?php if($tb_show_page_breadcrumb_shop){ ?>
					<div class="<?php echo esc_attr($cl_page_breadcrumb); ?> col-height col-middle">
						<?php woocommerce_breadcrumb(); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
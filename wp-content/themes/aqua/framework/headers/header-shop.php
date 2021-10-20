<!-- Start Header Sidebar -->
<?php
	global $tb_options,$post;
	$header_padding = get_post_meta($post->ID, 'tb_header_padding', true) | "";
	$header_bg_color = get_post_meta($post->ID, 'tb_header_bg_color', true) | "";
	$tb_header_fixed = get_post_meta($post->ID, 'tb_header_fixed', true) ? get_post_meta($post->ID, 'tb_header_fixed', true):'';
	$tb_custom_menu = get_post_meta($post->ID, 'tb_custom_menu', true) ? get_post_meta($post->ID, 'tb_custom_menu', true):'';
	$tb_display_widget_top = get_post_meta($post->ID, 'tb_display_widget_top', true);
	$tb_border_bottom_menu = get_post_meta($post->ID, 'tb_border_bottom_menu', true) ? get_post_meta($post->ID, 'tb_border_bottom_menu', true):0;
	if($tb_display_widget_top=='global' || $tb_display_widget_top==''){$tb_display_widget_top = 2;}
	switch ($tb_display_widget_top) {
        case 1:
            $tb_display_widget_top = 1;
            break;
        case 0:
            $tb_display_widget_top = 0;
            break;
		default :
			$tb_display_widget_top = $tb_options['tb_header_top_widget'];
            break;
    }
	$style = array();
	if($header_padding){
		$style[] = "padding: $header_padding";
	}
	if($header_bg_color){
		$style[] = "background: $header_bg_color";
	}
?>
<div class="tb-header-wrap tb-header-shop <?php echo esc_attr($tb_header_fixed); ?>" style="<?php echo implode(';', $style); ?>">
<?php
	if($tb_display_widget_top){ ?>
	<div class="header-sidebar" style="<?php echo implode(';', $style); ?>">
		<div class="container">
			<div class="row header-sidebar-inner">
				<!-- Start Sidebar Top Left -->
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 sidebar-top-left">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Header Shop Top Widget 1")): endif; ?>
				</div>
				<!-- End Sidebar Top Left -->
				<!-- Start LOGO center -->
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 logo_wrap">
					<a class="menubar-brand" href="<?php echo esc_url(home_url()); ?>">
						<?php tb_theme_logo(); ?>
					</a>
				</div>
				<!-- End LOGO center -->
				<!-- Start Sidebar Top Right -->
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 sidebar-top-right">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Header Shop Top Widget 2")): endif; ?>
				</div>
				<!-- End Sidebar Top Right -->
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- End Header Sidebar -->
	<?php	
		$cl_sb_header_left = null;
		$cl_sb_header_right = null;
		$cl_menu_col = null;
		if(is_active_sidebar( 'tbtheme-header-shop-widget' ) && is_active_sidebar( 'tbtheme-header-shop-widget-2' )){
			$cl_sb_header_left = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
			$cl_sb_header_right = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
			$cl_menu_col = 'col-xs-12 col-sm-12 col-md-6 col-lg-6';
		}else{
			if(is_active_sidebar( 'tbtheme-header-shop-widget' )){ 
				$cl_sb_header_left = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
				$cl_menu_col = 'col-xs-12 col-sm-12 col-md-9 col-lg-9';
			}
			if(is_active_sidebar( 'tbtheme-header-shop-widget-2' )){
				$cl_sb_header_right = 'col-xs-12 col-sm-12 col-md-3 col-lg-3';
				$cl_menu_col = 'col-xs-12 col-sm-12 col-md-9 col-lg-9';
			}
		}
	?>
	<div class="header-menu">
		<div class="container">
			<div class="header-menu-inner">
				<div class="row">
					<!-- Start Sidebar Header Shop Left -->
					<?php if(is_active_sidebar( 'tbtheme-header-shop-widget' )){ ?>
						<div class="<?php echo esc_attr($cl_sb_header_left); ?> sidebar-header-left text-left hidden-sm hidden-xs">
							<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("tbtheme-header-shop-widget")): endif; ?>
						</div>
					<?php } ?>
					<!-- End Sidebar Header Shop Left -->
					<!-- Start menu -->	
					<div class="<?php echo esc_attr($cl_menu_col); ?> header-menu">
						<?php $cl_stick = $tb_options['tb_stick_header'] ? 'menu-toggle-class menubar-fixed-top': ''; ?>
						<div class="menubar menu-toggle-class" data-scroll-toggle-class="<?php echo esc_attr($cl_stick); ?>">
							<div class="menubar-inner">
								<?php
								$arr = array(
									'theme_location' => 'main_navigation',
									'menu_id' => 'nav',
									'menu' => '',
									'container_class' => 'menu-list menu-tb menu-align-center',
									'menu_class'      => 'menu-list-inner',
									'echo'            => true,
									'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'depth'           => 0,
								);
								if($tb_custom_menu){
									$arr['menu'] = $tb_custom_menu;
								}
								if (has_nav_menu('main_navigation')) {
									wp_nav_menu( $arr );
								}else{ ?>
								<div class="menu-list-default">
									<?php wp_page_menu();?>
								</div>    
								<?php } ?>
								<div id="ro-hamburger" class="ro-hamburger visible-xs pull-right"><span></span></div>
								<?php if($tb_border_bottom_menu != '0' || $tb_border_bottom_menu != 0) :					
								?>
									<div class="ro-hr ro-full"></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<!-- End menu -->
					<!-- Start Sidebar Header Shop Right -->
					<?php if(is_active_sidebar( 'tbtheme-header-shop-widget-2' )){ ?>
						<div class="<?php echo esc_attr($cl_sb_header_right); ?> sidebar-header-right text-right hidden-sm hidden-xs">
							<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("tbtheme-header-shop-widget-2")): endif; ?>
						</div>
					<?php } ?>
					<!-- End Sidebar Header Shop Right -->
				</div>
			</div>
		</div>
	</div>
</div>
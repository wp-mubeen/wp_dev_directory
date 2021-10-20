<!-- Start Header Sidebar -->
<?php
	global $tb_options,$post;
	$header_padding = isset($post->ID) ? get_post_meta($post->ID, 'tb_header_padding', true):'';
	$header_bg_color = isset($post->ID) ? get_post_meta($post->ID, 'tb_header_bg_color', true):'';
	$tb_header_fixed = isset($post->ID) ? get_post_meta($post->ID, 'tb_header_fixed', true):'';
	$tb_custom_menu =  isset($post->ID) ? get_post_meta($post->ID, 'tb_custom_menu', true):'';
	$tb_display_widget_top = isset($post->ID) ? get_post_meta($post->ID, 'tb_display_widget_top', true): '';
	$tb_border_bottom_menu = isset($post->ID) ? get_post_meta($post->ID, 'tb_border_bottom_menu', true):0;
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
<div class="tb-header-wrap tb-header-v3 <?php echo esc_attr($tb_header_fixed); ?>" style="<?php echo implode(';', $style); ?>">
	<?php
	if($tb_display_widget_top){ ?>
	<div class="header-sidebar">
		<div class="container">
			<div class="row">
				<?php
				$cl_sb_top_left = '';
				$cl_sb_top_right = '';
				if(is_active_sidebar( 'tbtheme-header-3-top-widget' ) && is_active_sidebar( 'tbtheme-header-3-top-widget-2' )){
					$cl_sb_top_left = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
					$cl_sb_top_right = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
				}else{
					if(is_active_sidebar( 'tbtheme-header-top-widget' )) $cl_sb_top_left = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
					if(is_active_sidebar( 'tbtheme-header-top-widget-2' )) $cl_sb_top_right = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				}
				?>
				<!-- Start Sidebar Top Left -->
				<?php if(is_active_sidebar( 'tbtheme-header-3-top-widget' )){ ?>
					<div class="<?php echo esc_attr($cl_sb_top_left); ?> sidebar-top-left">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Header 3 Top Widget 1")): endif; ?>
					</div>
				<?php } ?>
				<!-- End Sidebar Top Left -->
				<!-- Start Sidebar Top Right -->
				<?php if(is_active_sidebar( 'tbtheme-header-3-top-widget-2' )){ ?>
					<div class="<?php echo esc_attr($cl_sb_top_right); ?> sidebar-top-right">
						<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Header 3 Top Widget 2")): endif; ?>
					</div>
				<?php } ?>
				<!-- End Sidebar Top Right -->
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- End Header Sidebar -->
	<!-- Start Header Menu -->
	<div class="header-menu">
		<?php $cl_stick = $tb_options['tb_stick_header'] ? 'menu-toggle-class menubar-fixed-top': ''; ?>
		<div class="menubar menu-toggle-class" data-scroll-toggle-class="<?php echo esc_attr($cl_stick); ?>">
			<div class="menubar-inner">
				<div class="container">
					<div class="row">
						<div class="col-xs-10 col-sm-12 col-md-12 col-lg-12 col-logo">
							<a class="menubar-brand" href="<?php echo esc_url(home_url()); ?>">				
								<?php tb_theme_logo(); ?>
							</a>
						</div>
							<div class="col-xs-2 col-sm-12 col-md-12 col-lg-12 col-menu">
							<?php
							global $tb_options;
							$tb_logo_mbmenu = $tb_options['tb_logo_mbmenu']['url'] ? $tb_options['tb_logo_mbmenu']['url'] : URI_PATH.'/assets/images/aqua-brand3.png';
							$home_url = esc_url(home_url());
							$content_logo ='<li class="menu-item visible-xs tb_logo_mbmenu">
												<a href="'.$home_url.'">
													<img alt="Logo" src="'.$tb_logo_mbmenu.'">
												</a>
											</li>';
							$arr = array(
								'theme_location' => 'main_navigation',
								'menu_id' => 'nav',
								'container_class' => 'menu-list menu-tb text-center',
								'menu_class'      => 'menu-list-inner',
								'echo'            => true,
								'items_wrap'      => '<ul id="%1$s" class="%2$s">'.$content_logo.'%3$s</ul>',
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
							<?php if (class_exists ( 'Woocommerce' )) { ?>
								<div class="ro-mini-cart-mobile visible-xs <?php echo esc_attr($cart_is_empty?'tb-cart-empty':'');?>">
									<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="icon_cart_wrap"><i class="icon-ecommerce-cart-content cart-icon"></i>
										<span class="cart_total" ><?php
											echo tb_filtercontent($woocommerce?' '.$woocommerce->cart->get_cart_contents_count():'');?>
										</span>
									</a>
								</div>
							<?php } ?>
							<div id="ro-hamburger" class="ro-hamburger visible-xs pull-right"><span></span></div>
							<?php if($tb_border_bottom_menu) : ?>
								<div class="ro-hr ro-full"></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Header Menu -->
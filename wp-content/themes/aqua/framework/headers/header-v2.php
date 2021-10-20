<!-- Start Header Top Sidebar -->
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
<div class="tb-header-wrap tb-header-v2 <?php echo esc_attr($tb_header_fixed); ?>" style="<?php echo implode(';', $style); ?>">
	<?php if($tb_display_widget_top){ ?>
	<div class="header-sidebar">
		<div class="container">
			<div class="row">
				<!-- Start Sidebar Top Left -->
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 sidebar-top-left">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Header 2 Top Widget 1")): endif; ?>
				</div>
				<!-- End Sidebar Top Left -->
				<!-- Start LOGO center -->
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-logo">
					<a class="menubar-brand" href="<?php echo esc_url(home_url()); ?>">
						<?php tb_theme_logo(); ?>
					</a>
				</div>
				<!-- End LOGO center -->
				<!-- Start Sidebar Top Right -->
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 sidebar-top-right">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Header 2 Top Widget 2")): endif; ?>
				</div>
				<!-- End Sidebar Top Right -->
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- End Header Top Sidebar -->
	<?php	
		$cl_sb_header_left = null;
		$cl_sb_header_right = null;
		$cl_menu_col = null;
		if(is_active_sidebar( 'tbtheme-header-2-widget' ) && is_active_sidebar( 'tbtheme-header-2-widget-2' )){
			$cl_sb_header_left = 'col-xs-12 col-sm-12 col-md-2 col-lg-2';
			$cl_sb_header_right = 'col-xs-12 col-sm-12 col-md-2 col-lg-2';
			$cl_menu_col = 'col-xs-12 col-sm-12 col-md-8 col-lg-8';
		}else{
			if(is_active_sidebar( 'tbtheme-header-2-widget' )){ 
				$cl_sb_header_left = 'col-xs-12 col-sm-12 col-md-2 col-lg-2';
				$cl_menu_col = 'col-xs-12 col-sm-12 col-md-10 col-lg-10';
			}
			if(is_active_sidebar( 'tbtheme-header-2-widget-2' )){
				$cl_sb_header_right = 'col-xs-12 col-sm-12 col-md-2 col-lg-2';
				$cl_menu_col = 'col-xs-12 col-sm-12 col-md-10 col-lg-10';
			}
		}
	?>	
	<!-- Start Sidebar Header 2 Left -->
	<?php if(is_active_sidebar( 'tbtheme-header-2-widget' )){ ?>
		<div class="<?php echo esc_attr($cl_sb_header_left); ?> sidebar-header-left">
			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("tbtheme-header-2-widget")): endif; ?>
		</div>
	<?php } ?>
	<!-- End Sidebar Header 2 Left -->
	<!-- Start menu -->	
	<div class="<?php echo esc_attr($cl_menu_col); ?> header-menu">
		<?php $cl_stick = $tb_options['tb_stick_header'] ? 'menu-toggle-class menubar-fixed-top': ''; ?>
		<div class="menubar menu-toggle-class" data-scroll-toggle-class="<?php echo esc_attr($cl_stick); ?>">
			<div class="menubar-inner">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
								'menu' => '',
								'container_class' => 'menu-list menu-tb menu-align-center',
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
							<?php if($tb_border_bottom_menu != '0' || $tb_border_bottom_menu != 0) :					
							?>
								<div class="ro-hr ro-full"></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
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
	<!-- End menu -->
	<!-- Start Sidebar Header 2 Right -->
	<?php if(is_active_sidebar( 'tbtheme-header-2-widget-2' )){ ?>
		<div class="<?php echo esc_attr($cl_sb_header_right); ?> sidebar-header-right">
			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("tbtheme-header-2-widget-2")): endif; ?>
		</div>
	<?php } ?>
	<!-- End Sidebar Header 2 Right -->
</div>
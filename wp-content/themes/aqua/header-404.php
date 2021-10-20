<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	

	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php global $tb_options; ?> 
	<?php if($tb_options['tb_responsive']){ ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php } ?>	
	<?php wp_head(); ?><script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/2e91418027c5488b5a73ec56d/1db48b7951a913d4ac4f4a9a7.js");</script>
</head>



<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1913624838680403');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1913624838680403&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->







<?php
	$body_class = 'tb_body';
	$layout = $tb_options["tb_layout"];
	$layout_class = $layout=='boxed'? $body_class .= ' boxed':$body_class .= ' wide';
?>
<body <?php body_class($body_class) ?>>	
	
	
	<div id="tb_wrapper">
		<?php
			$tb_display_top_sidebar = get_post_meta(get_the_ID(), 'tb_display_top_sidebar', true)?get_post_meta(get_the_ID(), 'tb_display_top_sidebar', true):0;
			if(is_active_sidebar( 'tbtheme-top-sidebar' ) && $tb_display_top_sidebar){
			?>
				<div class="tb_top_sidebar_wrap">
					<?php dynamic_sidebar("Top Sidebar"); ?>
				</div>
			<?php
			}
		?>
		<!-- Start Header Top Sidebar -->
		<?php
			global $tb_options,$post;
			$postid = isset($post->ID)?$postid:0;
			$header_padding = get_post_meta($postid, 'tb_header_padding', true) | "";
			$header_bg_color = get_post_meta($postid, 'tb_header_bg_color', true) | "";
			$tb_header_fixed = get_post_meta($postid, 'tb_header_fixed', true) ? get_post_meta($postid, 'tb_header_fixed', true):'';
			$tb_custom_menu = get_post_meta($postid, 'tb_custom_menu', true) ? get_post_meta($postid, 'tb_custom_menu', true):'';
			$tb_display_widget_top = get_post_meta($postid, 'tb_display_widget_top', true);
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
		<?php if(is_active_sidebar( 'tbtheme-right-fixed-sidebar' )){ ?>
			<div class="tb_right_fx_wrap">
				<?php dynamic_sidebar("Right Fixed Sidebar"); ?>
			</div>
		<?php } ?>
		
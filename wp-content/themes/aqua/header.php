<!DOCTYPE html>
<html <?php language_attributes(); ?>>

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

	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-140841879-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-140841879-1');
</script>


	
	
	<head>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TPM5RHK');</script>
<!-- End Google Tag Manager -->
		
		
		
		
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<?php global $tb_options; ?>
	<?php if($tb_options['tb_responsive']){ ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php } ?>	
	<?php wp_head(); ?><script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/2e91418027c5488b5a73ec56d/1db48b7951a913d4ac4f4a9a7.js");</script>
	 <script type="text/javascript" src="https://s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" ></script>
 <?php wp_head(); ?>
</head>
<?php
	$body_class = 'tb_body';
	$layout = $tb_options["tb_layout"];
	$layout_class = $layout=='boxed'? $body_class .= ' boxed':$body_class .= ' wide';
?>
<body <?php body_class($body_class) ?>>	<!-- Global site tag (gtag.js) - Google Analytics -->
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TPM5RHK"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111303719-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-111303719-1');
</script>

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
		<?php tb_Header(); ?>
		<?php if(is_active_sidebar( 'tbtheme-right-fixed-sidebar' )){ ?>
			<div class="tb_right_fx_wrap">
				<?php dynamic_sidebar("Right Fixed Sidebar"); ?>
			</div>
		<?php } ?>
		
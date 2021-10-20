<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php global $tb_options; ?> 
	<?php if($tb_options['tb_responsive']){ ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php } ?>	
	<?php wp_head(); ?>
</head>
<?php
	$body_class = 'tb_body';
	$layout = $tb_options["tb_layout"];
	$layout_class = $layout=='boxed'? $body_class .= ' boxed':$body_class .= ' wide';
?>
<body <?php body_class($body_class) ?>>	
	<div id="tb_wrapper">

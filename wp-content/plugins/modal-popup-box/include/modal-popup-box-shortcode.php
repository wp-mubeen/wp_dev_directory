<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_shortcode('MPBOX', 'awl_modal_popup_box_shortcode');
function awl_modal_popup_box_shortcode($post_id) {
	ob_start();
	//print_r($post_id);
	wp_enqueue_style('mbp-fronted-bootstrap-css');
	wp_enqueue_style('mbp-animate-css');
	wp_enqueue_style('mbp-modal-box-css');
	// modal box js and css
	wp_enqueue_style( 'mbp-component-css');
	wp_enqueue_script('mbp-modernizr-custom-js');	// before body load
	wp_enqueue_script('mbp-classie-js');
	wp_enqueue_script('mbp-cssParser-js');
	
	
	//unserialize
	$modal_popup_box_settings = unserialize(base64_decode(get_post_meta( $post_id['id'], 'awl_mpb_settings_'.$post_id['id'], true)));
	$modal_popup_box_id = $post_id['id'];
	
	//Main Button
	if(isset($modal_popup_box_settings['mpb_show_modal'])) $mpb_show_modal = $modal_popup_box_settings['mpb_show_modal']; else $mpb_show_modal = "onclick";
	if(isset($modal_popup_box_settings['mpb_main_button_text'])) $mpb_main_button_text = $modal_popup_box_settings['mpb_main_button_text']; else $mpb_main_button_text = "Click Me";
	if(isset($modal_popup_box_settings['mpb_main_button_size'])) $mpb_main_button_size = $modal_popup_box_settings['mpb_main_button_size']; else $mpb_main_button_size = "btn btn-lg";
	if(isset($modal_popup_box_settings['mpb_main_button_color'])) $mpb_main_button_color = $modal_popup_box_settings['mpb_main_button_color']; else $mpb_main_button_color = "#008EC2";
	if(isset($modal_popup_box_settings['mpb_main_button_text_color'])) $mpb_main_button_text_color = $modal_popup_box_settings['mpb_main_button_text_color']; else $mpb_main_button_text_color = "#ffffff";
	if(isset($modal_popup_box_settings['mpb_button2_text'])) $mpb_button2_text = $modal_popup_box_settings['mpb_button2_text']; else $mpb_button2_text = "Close Me";
	if(isset($post_id['template'])) {
		$modal_popup_box_settings = $post_id['template'];	// template set by shortcode
	} else {
	if(isset($modal_popup_box_settings['modal_popup_design'])) $modal_popup_design = $modal_popup_box_settings['modal_popup_design']; else  $modal_popup_design = "color_1";
	}
	//General Settings	
	//Animation Effect
	if(isset($modal_popup_box_settings['mpb_animation_effect_open_btn'])) $mpb_animation_effect_open_btn = $modal_popup_box_settings['mpb_animation_effect_open_btn']; else $mpb_animation_effect_open_btn = "md-effect-1" ;
	//Modal Box Height And Width
	if(isset($modal_popup_box_settings['mpb_width'])) $mpb_width = $modal_popup_box_settings['mpb_width']; else $mpb_width = 35;
	if(isset($modal_popup_box_settings['mpb_height'])) $mpb_height = $modal_popup_box_settings['mpb_height']; else $mpb_height = 350;
	//Custom CSS
	if(isset($modal_popup_box_settings['mpb_custom_css'])) $mpb_custom_css = $modal_popup_box_settings['mpb_custom_css']; else $mpb_custom_css = "";
	

	?>
	<style>	
	.md-content_<?php echo $modal_popup_box_id; ?> .mbox-title_<?php echo $modal_popup_box_id; ?> {
		margin: 0;
		padding:20px;
		font-weight: bolder;
		background: rgba(0,0,0,0.1);
	}
	.md-content_<?php echo $modal_popup_box_id; ?> {
		color: #ffffff;
		background: #008EC2;
		position: relative;
		border-radius: 3px;
		margin: 0 auto;
		overflow-y: auto;
	}
	.mpb-shotcode-buttons{
		margin-left: 4% !important;
	}
	.modal-size_<?php echo $modal_popup_box_id; ?> {
		width:<?php echo $mpb_width; ?>%; 
	}
	.md-content_<?php echo $modal_popup_box_id; ?> {
		height:<?php echo $mpb_height; ?>px;
	}
	.btn-bg-<?php echo $modal_popup_box_id; ?> {
		background-color:<?php echo $mpb_main_button_color; ?>;
		color:<?php echo $mpb_main_button_text_color; ?>;
	}
	.btn-bg-<?php echo $modal_popup_box_id; ?>:hover {
		color: #fff !important;
	}
	.btn-default{
		cursor:pointer !important;
	}
	.md-content_<?php echo $modal_popup_box_id; ?> > div {
		padding: 15px 15px 15px;
		margin: 0;
	}
	.btn-style {
		color: #fff;
		background-color: #008EC2;
		border-color: #FF0000;
	}

	.btn-style:hover {
		color: #fff;
		background-color: #008EC2;
		border-color: #0080AE;
	}
	<!--- 2 start -->
	
	
	.md-content_<?php echo $modal_popup_box_id; ?> .modaltwo_<?php echo $modal_popup_box_id; ?> {
		height: <?php echo $mpb_height; ?>px !important;
	}
	
	.modal-sizetwo_<?php echo $modal_popup_box_id; ?> {
		width: <?php echo $mpb_width; ?>%;
	}
	
	.btn-primary_<?php echo $modal_popup_box_id; ?> {
		color: #fff;
		background-color: #b12222ba;
		border-color: #FF0000;
	}

	.btn-primary_<?php echo $modal_popup_box_id; ?>:hover {
		color: #fff !important;
		background-color: #FF0000;
		border-color: #FF6363;
	}
	/* Effect 1: Fade in and scale up */
	.md-effect-1 .md-content_<?php echo $modal_popup_box_id; ?> {
		-webkit-transform: scale(0.7);
		-moz-transform: scale(0.7);
		-ms-transform: scale(0.7);
		transform: scale(0.7);
		opacity: 0;
		-webkit-transition: all 0.3s;
		-moz-transition: all 0.3s;
		transition: all 0.3s;
	}

	.md-show.md-effect-1 .md-content_<?php echo $modal_popup_box_id; ?> {
		-webkit-transform: scale(1);
		-moz-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1);
		opacity: 1;
	}

	/* Effect 2: Slide from the right */
	.md-effect-2 .md-content_<?php echo $modal_popup_box_id; ?> {
		-webkit-transform: translateX(20%);
		-moz-transform: translateX(20%);
		-ms-transform: translateX(20%);
		transform: translateX(20%);
		opacity: 0;
		-webkit-transition: all 0.3s cubic-bezier(0.25, 0.5, 0.5, 0.9);
		-moz-transition: all 0.3s cubic-bezier(0.25, 0.5, 0.5, 0.9);
		transition: all 0.3s cubic-bezier(0.25, 0.5, 0.5, 0.9);
	}

	.md-show.md-effect-2 .md-content_<?php echo $modal_popup_box_id; ?> {
		-webkit-transform: translateX(0);
		-moz-transform: translateX(0);
		-ms-transform: translateX(0);
		transform: translateX(0);
		opacity: 1;
	}
	
	<?php echo $mpb_custom_css; ?>
	</style>
	<?php
	require('modal-popup-box-output.php');
	return ob_get_clean();
}
?>
<?php
$output = $font_color = $el_class = $width = $offset = $animation = $text_align = '';
extract(shortcode_atts(array(
	'font_color'    => '',
    'el_class' 		=> '',
    'width' 		=> '1/1',
    'css' 			=> '',
	'offset' 		=> '',
	'animation' 	=> '',
	'text_align' 	=> '',
), $atts));

$el_class = $this->getExtraClass($el_class);
$width = wpb_translateColumnWidthToSpan($width);
$width = vc_column_offset_class_merge($offset, $width);
$el_class .= ' wpb_column vc_column_container';
$style = $this->buildStyle( $font_color );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

// Column Animation
if($animation != 'animation-none') $css_class .= $this->getCSSAnimation($animation);
//Column Text Align
$css_class .= ' '.esc_attr($text_align);

$output .= "\n\t".'<div class="'.$css_class.'"'.$style.'>';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo tb_filtercontent($output);
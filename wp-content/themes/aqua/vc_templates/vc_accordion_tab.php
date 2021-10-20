<?php
$output = $title = '';
extract(shortcode_atts(array(
	'title' => __("Section", "js_composer"),
	'background' => __("", "js_composer"),
	'background_active' => __("", "js_composer"),
	'border' => __("", "js_composer"),
	'color' => __("", "js_composer"),
	'background_content' => __("", "js_composer"),
), $atts));
$style = array();
$color_style = $content_style = null;
if($background) $style[] = "background:{$background}";
if($border) $style[] = "border: 1px solid {$border}";
if($color) $color_style = "style='color:{$color};'";
if($background_content) $content_style = "style='background:{$background_content};'";
$css = implode(';',$style);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', $this->settings['base'], $atts );
$output .= "\n\t\t\t" . '<div class="'.$css_class.'">';
    $output .= "\n\t\t\t\t" . '<h3 style="'.$css.'" class="wpb_accordion_header ui-accordion-header"><a '.$color_style.' href="#'.sanitize_title($title).'">'.$title.'</a></h3>';
    $output .= "\n\t\t\t\t" . '<div class="wpb_accordion_content ui-accordion-content vc_clearfix" '.$content_style.'>';
        $output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
        $output .= "\n\t\t\t\t" . '</div>';
    $output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_accordion_section') . "\n";
	if($background_active) $output .= '<style>.wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header[aria-selected="true"]{background: '.$background_active.' !important;}</style>';
echo tb_filtercontent($output);
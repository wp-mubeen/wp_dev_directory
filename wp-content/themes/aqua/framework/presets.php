<?php
function tb_theme_autoCompileLess($inputFile, $outputFile) {
    require_once ( ABS_PATH_FR . '/inc/lessc.inc.php' );
	global $tb_options;
    $less = new lessc();
    $less->setFormatter("classic");
    $less->setPreserveComments(true);
	/*Styling Options*/
	$tb_primary_color = $tb_options['tb_primary_color'];
	/*Menu*/
	$tb_main_menu_color_level1 = $tb_options['tb_main_menu_color_level1']['regular'];
	$tb_main_menu_color_level1_hover = $tb_options['tb_main_menu_color_level1']['hover'];
	$tb_main_menu_font_color_sub_level = $tb_options['tb_main_menu_font_color_sub_level']['regular'];
	$tb_main_menu_font_color_sub_level_hover = $tb_options['tb_main_menu_font_color_sub_level']['hover'];
	
	$tb_main_menu_separator_color_sub_level = $tb_options['tb_main_menu_separator_color_sub_level'];
    $variables = array(
		"tb_primary_color" => $tb_primary_color,
		"tb_main_menu_color_level1" => $tb_main_menu_color_level1,
		"tb_main_menu_color_level1_hover" => $tb_main_menu_color_level1_hover,
		"tb_main_menu_font_color_sub_level" => $tb_main_menu_font_color_sub_level,
		"tb_main_menu_font_color_sub_level_hover" => $tb_main_menu_font_color_sub_level_hover,
		"tb_main_menu_separator_color_sub_level" => $tb_main_menu_separator_color_sub_level,
    );
    $less->setVariables($variables);
    $cacheFile = $inputFile.".cache";
    if (file_exists($cacheFile)) {
            $cache = unserialize(file_get_contents($cacheFile));
    } else {
            $cache = $inputFile;
    }
    $newCache = $less->cachedCompile($inputFile);
    if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
            file_put_contents($cacheFile, serialize($newCache));
            file_put_contents($outputFile, $newCache['compiled']);
    }
}
function tb_addLessStyle() {
    try {
		$inputFile = ABS_PATH.'/assets/css/less/style.less';
		$outputFile = ABS_PATH.'/style.css';
		tb_theme_autoCompileLess($inputFile, $outputFile);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}
add_action('wp_enqueue_scripts', 'tb_addLessStyle');
/* End less*/
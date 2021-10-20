<?php
function tb_dropcap_render($params, $content = null) {
	extract(shortcode_atts(array(
        ), $params));
        ob_start();
        ?>
        <div class="tb_dropcap"><?php echo tb_filtercontent($content);?></div>
        <?php
	return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_dropcap', 'tb_dropcap_render'); }

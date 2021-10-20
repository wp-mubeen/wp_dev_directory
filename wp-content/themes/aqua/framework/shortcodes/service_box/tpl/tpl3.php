<?php
	$bg_style = '';
	if($tpl3_bg) $bg_style = 'style="background-color: '.esc_attr($tpl3_bg).';"';
?>
<div class="ro-service-item-3 clearfix"<?php echo ' '.$bg_style; ?>>
	<a href="<?php echo esc_url($ex_link); ?>">
		<div>
			<?php echo '<h3>'.esc_html($title).'</h3>' ?>
			<?php echo '<p>'.esc_html($desc).'</p>'; ?>
			<?php echo wp_get_attachment_image($image, 'full'); ?>
		</div>
	</a>
</div>
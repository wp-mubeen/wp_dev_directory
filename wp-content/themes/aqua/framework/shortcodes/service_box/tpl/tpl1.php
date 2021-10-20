<div class="ro-service-1-item clearfix<?php if($tpl1_style == 'img_top') echo ' ro-service-1-v'; ?>">
	<?php if($tpl1_style == 'img_left' || $tpl1_style == 'img_top') { ?>
		<div class="ro-image ro-left">
			<?php echo wp_get_attachment_image($image, 'full'); ?>
		</div>
	<?php } ?>
	<div class="ro-content<?php if($tpl1_style == 'img_right') echo ' ro-left'; ?>">
		<?php echo '<h3 class="ro-hr-heading">'.esc_html($title).'</h3>' ?>
		<?php
			$desc_bg_style = '';
			if($tpl1_desc_bg) $desc_bg_style = ' style="background-color: '.esc_attr($tpl1_desc_bg).'"';
			echo '<p'.$desc_bg_style.'>'.esc_html($desc).'<a class="ro-more" href="'.esc_url($ex_link).'"><i class="icon-right106"></i></a></p>'; 
		?>
	</div>
	<?php if($tpl1_style == 'img_right') { ?>
		<div class="ro-image">
			<?php echo wp_get_attachment_image($image, 'full'); ?>
		</div>
	<?php } ?>
</div>
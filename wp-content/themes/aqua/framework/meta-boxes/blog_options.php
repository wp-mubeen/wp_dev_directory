<div id="tb-blog-loading" class="tb_loading" style="display: block;">
	<div id="followingBallsG">
	<div id="followingBallsG_1" class="followingBallsG">
	</div>
	<div id="followingBallsG_2" class="followingBallsG">
	</div>
	<div id="followingBallsG_3" class="followingBallsG">
	</div>
	<div id="followingBallsG_4" class="followingBallsG">
	</div>
	</div>
</div>
<div id="tb-blog-metabox" class='tb_metabox' style="display: none;">
	<div id="tb-tab-blog" class='categorydiv'>
		<ul class='category-tabs'>
		   <li class='tb-tab'><a href="#tabs-header"><i class="dashicons dashicons-menu"></i> <?php echo _e('HEADER','aqua');?></a></li>
		   <li class='tb-tab'><a href="#tabs-footer"><i class="dashicons dashicons-menu"></i> <?php echo _e('FOOTER','aqua');?></a></li>
		</ul>
		<div class='tb-tabs-panel'>
			<div id="tabs-header">
				<?php
					$headers = array('global' => 'Global', 'v1' => 'Header 1', 'v2' => 'Header 2', 'v3' => 'Header 3');
					if (class_exists('Woocommerce')) {
						$headers['shop'] = 'Header Shop';
					}
					$this->select('header',
							'Header',
							$headers,
							'',
							''
					);
					$this->select('header_fixed',
							'Header Fixed',
							array('' => 'No','tb_header_fixed' => 'Yes, please'),
							'',
							''
					);
					$this->text('header_padding',
						'Header padding',
						''
					);
					$this->select('display_widget_top',
							'Display Widget Header Top',
							array('global' => 'Global','0' => 'No', '1' => 'Yes'),
							'',
							''
					);
					$this->select('border_bottom_menu',
							'Show border bottom',
							array('0' => 'No', '1' => 'Yes, please'),
							'',
							'Show border in bottom of header'
					);
				?>
				<p class="tb_info"><i class="dashicons dashicons-format-image"></i><?php echo _e('Custom logo:','aqua');?></p>
				<?php

				$this->upload('custom_logo', 'Choose image');
				?>
				<p class="tb_info"><i class="dashicons dashicons-format-image"></i><?php echo _e('Sub logo:','aqua');?></p>
				<?php
				$this->upload('sub_logo', 'Choose image');
				?>
				<p class="tb_info"><i class="dashicons dashicons-format-image"></i><?php echo _e('Background Setting:','aqua');?></p>
				<?php
				$this->text('header_bg_color',
						'Background Color (HEX/RGBA)',
						''
				);
				?>
				<p class="cs_info"><i class="dashicons dashicons-megaphone"></i><?php echo _e('Main Navigation','aqua'); ?></p>
				<?php
				$menus = array('' => 'Global');
				$obj_menus = wp_get_nav_menus();
				foreach ($obj_menus as $obj_menu){
					$menus[$obj_menu->term_id] = $obj_menu->name;
				}
				$this->select('custom_menu',
						'Select Menu',
						$menus,
						'',
						''
				);
				?>
			</div>
			<div id="tabs-footer">
				<?php
					$footers = array('global' => 'Global', 'white' => 'Footer White');
					$this->select('footer',
							'Footer',
							$footers,
							'',
							''
					);
				?>
			</div>
		</div>
	</div>
</div>

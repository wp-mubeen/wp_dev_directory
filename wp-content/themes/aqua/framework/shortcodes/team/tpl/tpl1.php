<div class="ro-team-item">
	<?php if($show_image) { ?>
		<div class="ro-image"><?php the_post_thumbnail('full'); ?></div>
	<?php } ?>
	<div class="ro-content">
		<?php if($show_title) { ?>
			<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
		<?php } ?>
		<?php if($show_position) { ?>
			<p><i class="ro-color-main ro-font-regular"><?php echo get_post_meta(get_the_ID(), 'tb_team_position', true); ?></i></p>
		<?php } ?>
		<?php if($show_excerpt) the_excerpt(); ?>
		<?php
			if($show_social) {
				$team_facebook = get_post_meta(get_the_ID(), 'tb_team_facebook', true);
				$team_twitter = get_post_meta(get_the_ID(), 'tb_team_twitter', true);
				$team_google_plus = get_post_meta(get_the_ID(), 'tb_team_google_plus', true);
				$team_linkedin = get_post_meta(get_the_ID(), 'tb_team_linkedin', true);
				
				$links = array();
				$links[] = ($team_facebook!='') ? '<li><a href="'.esc_url($team_facebook).'" title="'.__('Facebook', 'aqua').'" target="_blank"><i class="fa fa-facebook"></i></a></li>' : '';
				$links[] = ($team_twitter!='') ? '<li><a href="'.esc_url($team_twitter).'" title="'.__('Twitter', 'aqua').'" target="_blank"><i class="fa fa-twitter"></i></a></li>' : '';
				$links[] = ($team_google_plus!='') ? '<li><a href="'.esc_url($team_google_plus).'" title="'.__('Google Plus', 'aqua').'" target="_blank"><i class="fa fa-google-plus"></i></a></li>' : '';
				$links[] = ($team_linkedin!='') ? '<li><a href="'.esc_url($team_linkedin).'" title="'.__('Linkedin', 'aqua').'" target="_blank"><i class="fa fa-linkedin"></i></a></li>' : '';
				
				if (!empty($links)) {
					echo '<ul class="ro-social">' . implode('', $links) . '</ul>';
				}
			}
		?>
	</div>
</div>
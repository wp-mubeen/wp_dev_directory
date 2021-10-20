<div id="ro-testimonial-1" class="ro-testimonial-1">
	<ul class="slides">
		<?php while ( $wp_query->have_posts() ) { $wp_query->the_post(); ?>
			<li class="ro-item">
				<?php if($show_image) { ?>
					<div class="ro-image">
						<?php the_post_thumbnail('thumbnail');?>
					</div>
				<?php } ?>
				<?php if($show_title) { ?>
				<div class="ro-name">
					<p><?php the_title(); ?></p>
				</div>
				<?php } ?>
				<?php if($show_excerpt) the_excerpt(); ?>
			</li>
		<?php } ?>
	</ul>
</div>
<div id="ro-testimonial-2" class="ro-testimonial-2">
	<ul class="slides">
		<?php while ( $wp_query->have_posts() ) { $wp_query->the_post(); ?>
			<li class="ro-item">
				<?php if($show_image) { ?>
					<div class="ro-image">
						<?php the_post_thumbnail('thumbnail');?>
					</div>
				<?php } ?>
				<div class="ro-content">
					<?php if($show_excerpt) the_excerpt(); ?>
					<?php if($show_title) { ?>
						<div class="ro-name clearfix">
							<p><?php the_title(); ?></p>
						</div>
					<?php } ?>
				</div>
			</li>
		<?php } ?>
	</ul>
</div>
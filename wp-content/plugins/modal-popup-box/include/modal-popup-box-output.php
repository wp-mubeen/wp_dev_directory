<?php
// get post details
$modal_popup_box_id = $post_id['id'];
$all_modal_popup_box = array(  'p' => $modal_popup_box_id, 'post_type' => 'modalpopupbox', 'orderby' => 'ASC');
$loop = new WP_Query( $all_modal_popup_box );
while ( $loop->have_posts() ) : $loop->the_post();

?>
	<?php if($modal_popup_design == "color_1") { ?>
	<div class="md-modal modal-size_<?php echo $modal_popup_box_id; ?> <?php echo $mpb_animation_effect_open_btn; ?>" id="modal-<?php echo $modal_popup_box_id; ?>" <?php if($mpb_show_modal == "onclick") { ?> style="display:none;" <?php } ?>>
		<div class="md-content_<?php echo $modal_popup_box_id; ?>">
			<h3 class="mbox-title_<?php echo $modal_popup_box_id; ?> text-center"><?php if($modal_title = get_the_title()) echo $modal_title; else echo "Modal Tital Here"; ?></h3>
				<div>
					<?php
					$modal_content = get_the_content(); 
					if(empty($modal_content)) {
						echo " <p style='font-weight: bold;' >Modal content is empty. This is sample content. You can change it anytime. Simply update your shortcode content to display here.</p>
						<ul>
						<li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
						</ul>";
					} else {
						//Modal content shortcode trick--> do_shortcode();
					echo do_shortcode( $modal_content );
					}
					?>
				</div>	
				<div class="mpb-buttons text-center">
					<button type="button" class="btn btn-primary btn-style btn-lg text-center md-close"><?php echo $mpb_button2_text; ?></button>
				</div>
		</div>
	</div>
	<?php } if($modal_popup_design == "color_2") { ?>
			<div class="md-modal modal-sizetwo_<?php echo $modal_popup_box_id; ?> <?php echo $mpb_animation_effect_open_btn; ?>" id="modal-<?php echo $modal_popup_box_id; ?>" <?php if($mpb_show_modal == "onclick") { ?> style="display:none;" <?php } ?>>	
				<div class="md-content_<?php echo $modal_popup_box_id; ?> modaltwo_<?php echo $modal_popup_box_id; ?>" style="background-color: #ff0000">
					<h3 class=" mbox-title text-center" style="margin: 0; padding: 20px ; font-weight: bolder; background: rgba(0,0,0,0.1);"><?php if($modal_title = get_the_title()) echo $modal_title; else echo "Modal Tital Here"; ?></h3>
					<div>
						<?php
						$modal_content = get_the_content(); 
						if(empty($modal_content)) {
							echo " <p style='font-weight: bold;' >Modal content is empty. This is sample content. You can change it anytime. Simply update your shortcode content to display here.</p>
							<ul>
							<li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
							</ul>";
						} else {
							//Modal content shortcode trick--> do_shortcode();
						echo do_shortcode( $modal_content );
						}
						?>
					</div>	
					<div class="mpb-buttons text-center">
						<button type="button" class="btn btn-primary_<?php echo $modal_popup_box_id; ?> btn-lg text-center md-close"><?php echo $mpb_button2_text; ?></button>
					</div>
				</div>
			</div>
	<?php } ?>
	<!--shortcode button-->
	<?php if($mpb_show_modal == "onclick") { ?>
	<div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 mpb-shotcode-buttons">	
		<div class="md-trigger md-setperspective btn-bg-<?php echo $modal_popup_box_id; ?> <?php echo $mpb_main_button_size; ?> text-center" style="margin:2px;" data-modal="modal-<?php echo $modal_popup_box_id; ?>"><?php echo $mpb_main_button_text; ?></div><br>
	</div>
	<?php } ?>
	
	<!-- the overlay element -->
	<div class="md-overlay" <?php if($mpb_show_modal == "onclick") { ?> style="display:none;" <?php } ?>></div>
<?php
endwhile;
wp_reset_query();
?>
<script>
/**
 * modalEffects.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
jQuery(document).ready(function() {
	
	<?php if($mpb_show_modal == "onload") { ?>
	jQuery(".md-modal").addClass("md-show");
	jQuery("html").removeClass("md-perspective");
	<?php } ?>
	
	var ModalEffects = (function() {

		function init() {

			var overlay = document.querySelector( '.md-overlay' );

			[].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {

				var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
					close = modal.querySelector( '.md-close' );

				function removeModal( hasPerspective ) {
					classie.remove( modal, 'md-show' );

					if( hasPerspective ) {
						classie.remove( document.documentElement, 'md-perspective' );
					}
				}

				function removeModalHandler() {
					// pause YouTube video on modal close by outer click
					jQuery('.youtube-video-<?php echo $modal_popup_box_id; ?>')[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
					
					removeModal( classie.has( el, 'md-setperspective' ) ); 
				}

				el.addEventListener( 'click', function( ev ) {
					classie.add( modal, 'md-show' );
					overlay.removeEventListener( 'click', removeModalHandler );
					overlay.addEventListener( 'click', removeModalHandler );

					if( classie.has( el, 'md-setperspective' ) ) {
						setTimeout( function() {
							classie.add( document.documentElement, 'md-perspective' );
						}, 25 );
					}
				});

				close.addEventListener( 'click', function( ev ) {
					// pause YouTube video on modal close by button inside
					jQuery('.youtube-video-<?php echo $modal_popup_box_id; ?>')[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
					
					ev.stopPropagation();
					removeModalHandler();
				});

			} );

		}
		init();
	})();

	// on page load modal close script

	<?php if($mpb_show_modal == "onclick") { ?>
		jQuery("#modal-<?php echo $modal_popup_box_id; ?>").show();
		jQuery(".md-overlay").show();
	<?php } ?>
	jQuery(".md-overlay").click(function() {
		jQuery(".md-modal<?php echo $modal_popup_box_id; ?>").removeClass("md-show");
		jQuery("html").removeClass("md-perspective");
	});

	// close modal when click on modal close button
	jQuery(".md-close").click(function() {
		jQuery(".md-modal").removeClass("md-show");
		jQuery("html").removeClass("md-perspective");
	});
});
</script>
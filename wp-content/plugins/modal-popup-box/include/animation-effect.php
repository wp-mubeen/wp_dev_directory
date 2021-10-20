<div class="container-fluid">					
	<div class="col-md-12" >
		<div class="md-modal md-effect-1" id="modal-1">
			<div class="md-content">
				<h2 style="font-weight: bolder; color: #fff" class="text-center" ><?php _e('Modal Dialog', MPB_TXTDM); ?></h2>
				<div>
					<p style="font-weight: bolder;" ><?php _e('This is a modal window. You can do the following things with it:', MPB_TXTDM); ?></p>
					<ul>
						<li><strong><?php _e('Read:', MPB_TXTDM); ?></strong> <?php _e('modal windows will probably tell you something important so dont forget to read what they say', MPB_TXTDM); ?></li>
						<li><strong><?php _e('Look:', MPB_TXTDM); ?></strong> <?php _e('a modal window enjoys a certain kind of attention; just look at it and appreciate its presence', MPB_TXTDM); ?></li>
						<li><strong><?php _e('Close:', MPB_TXTDM); ?></strong> <?php _e('click on the button below to close the modal', MPB_TXTDM); ?></li>
					</ul>
					
					<div class="btn-default  btn-lg text-center md-close"><?php _e('Close me!', MPB_TXTDM); ?></div>
				</div>
			</div>
		</div>
		
		<div class="md-modal md-effect-2" id="modal-2">
			<div class="md-content">
				<h2 style="font-weight: bolder; color: #fff" class="text-center" ><?php _e('Modal Dialog', MPB_TXTDM); ?></h2>
				<div>
					<p style="font-weight: bolder;" ><?php _e('This is a modal window. You can do the following things with it:', MPB_TXTDM); ?></p>
					<ul>
						<li><strong><?php _e('Read:', MPB_TXTDM); ?></strong><?php _e('modal windows will probably tell you something important so dont forget to read what they say', MPB_TXTDM); ?></li>
						<li><strong><?php _e('Look:', MPB_TXTDM); ?></strong><?php _e('a modal window enjoys a certain kind of attention; just look at it and appreciate its presence', MPB_TXTDM); ?></li>
						<li><strong><?php _e('Close:', MPB_TXTDM); ?></strong><?php _e('click on the button below to close the modal', MPB_TXTDM); ?></li>
					</ul>
					<div class="btn-default  btn-lg text-center md-close"><?php _e('Close me!', MPB_TXTDM); ?></div>
				</div>
			</div>
		</div>
		
			<div class="col-md-5 md-trigger my_btn btn-default btn-lg text-center"  data-modal="modal-1"><?php _e('Fade in &amp; Scale', MPB_TXTDM); ?></div>
			<div class="col-md-5 md-trigger my_btn btn-default btn-lg text-center"  data-modal="modal-2"><?php _e('Slide in (right)', MPB_TXTDM); ?></div>
			<hr>
		<div class="md-overlay"></div><!-- the overlay element -->
	</div>	
</div><!-- /container -->
<style>
.col-md-5 {
    margin: 35px !important;
}
.my_btn{
	background-color:#0073AA !important;
	color:#FFFFFF !important;
}
#poststuff .stuffbox > h3, #poststuff h2, #poststuff h3.hndle {
	font-size : 30px;
}
.container-fluid {
    padding-left: 0px !important;
    padding-right: 0px !important;
	padding-bottom: 10px !important;
}
.btn-default{
	cursor:pointer !important;
}
</style>
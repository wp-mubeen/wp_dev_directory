<?php

/*

Template Name:  Pricing Template

*/

?>

<?php get_header(); ?>


<style>
	.topmargin{
		margin-top:20px
	}
	
	.pricing-plan{
		margin-top:50px;
	}
	.short-content p{
		
	}
	.pricing-plan .row{
		display: flex;
		margin-bottom: 32px;
		flex-wrap:wrap;
	}
	.pricing-image{
		min-height:220px;
		border-top-left-radius: 10px;
		border-bottom-left-radius: 10px;
	}
	.col-md-8.rightcontent {
		background-color: #d8f3ff;
		padding: 20px 38px;
		border-top-right-radius: 10px;
		border-bottom-right-radius: 10px;
	}
	.prcing-links {
		display: flex;
		justify-content: space-between;
		margin-top: 30px;
	}
	.prcing-links h4{
		margin-bottom:0px;
	}
	.prcing-links a{
		background-color: #26aae1;
		padding: 12px 20px;
		border-radius: 10px;
		color: white;
	}
	.packages-wrap{
		margin-bottom:30px;
	}
	.card-body {
		padding: 30px 0px;
		border-top-left-radius: 10px;
		border-top-right-radius: 10px;
		min-height: 420px;
	}
	.card {
		box-shadow: 0px 4px 4px rgb(0 0 0 / 25%);
		border-radius: 10px;
	}
	.card h2{
		padding:10px;
	}
	h6.card-title {
		background-color: white;
		width: max-content;
		padding: 14px;
		margin-left: 2px;
		border-top-right-radius: 20px;
		border-bottom-right-radius: 20px;
		font-weight:bold;
		box-shadow: 0px 4px 4px rgb(0 0 0 / 25%);
	}
	.content {
		padding: 0 32px;
	}
	.content p{
		padding-top: 15px;
	}
	.content ul {
		padding-left: 15px;
		list-style-type: circle;
	}
	.packages-wrap .button_wrap {
		text-align: center;
	}
	.packages-wrap .button_wrap a{
		padding: 10px 20px;
		border-radius: 10px;
		font-size: 16px;
		background-color: #26aae1;
	}
	.packages-wrap h3.message{
		border-radius: 16px;
		background-color: #d8f3ff;
		padding: 20px;
		font-size: 21px;
		text-align: center;
		color: black;
		margin-top: 50px;
	}
	
	.flower_section {
		margin-bottom:30px;
	}
	.flower_section p{
		text-align: center;
		font-weight: bold;
	}
	.inner_section h2{
		color:black;
	}
	.inner_section {
		background-color: #f2f2f2;
		padding: 60px 20px 0px;
	}
	.bottom_margin{
		margin-bottom:20px;
	}
	@media (max-width: 992px){
		.pricing-image {
			background: none !important;
			margin: 0 auto;
			min-height: auto !important;
		}
		.col-md-8.rightcontent{
			border-top-right-radius: 0px;
			border-bottom-left-radius: 0px;
			width: 410px;
			margin: 0 auto;
		}
		.pricing-image img{
			display:block !important;
			border-top-right-radius: 10px;
			border-top-left-radius: 10px;
			width: 410px;
		}
		
	}
	@media (max-width: 480px){
		.col-md-8.rightcontent{
			width: 300px;
		}
		.pricing-image img{
			width: 300px;
		}
	}
</style>
	<div class="main-content">
		<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php //the_content(); ?>
			<div style="clear: both;"></div>
			<div class="row">
				<div class="col-md-12 topmargin">
					<h3 class="headline text-center underline  "><?php the_title(); ?></h3>
					<div class="short-content">
						<?php the_field("short_info"); ?>
					</div>
				</div>
			</div>
			<?php
			$prices =  get_field("pricing_card");
			$packages =  get_field("packages");
			?>
			<div class="pricing-plan">
				<?php
				if($prices){
					foreach($prices as $field){
						$bgimage = $field['card_image'];
				?>
				<div class="row">
					<div class="col-md-4 pricing-image" <?php if($bgimage){ ?> style="background:url(<?php echo $bgimage; ?>);background-size:cover;background-repeat:no-repeat;" <?php } ?>>
						<img src="<?php echo $bgimage; ?>" style="display:none;">
					</div>
					<div class="col-md-8 rightcontent">
						<h3><?php echo  $field['title']; ?></h3>
						<?php echo  $field['description']; ?>
						<div class="prcing-links">
							<div class="price">
								<h4><?php echo  $field['price']; ?></h4>
							</div>
							<div class="link">
								<a href="<?php echo  $field['button_link']; ?>" ><?php echo  $field['button_text']; ?></a>
							</div>
						</div>
					</div>
				</div>
					<?php
						}
					}
					?>
			</div>
			<div class="row packages-wrap">
				<h2 class="text-center"><?php the_field("heading"); ?></h2>
				<?php
				if($packages){ $i = 0;
					foreach($packages as $field){ $i ++;
						$color = $field['background_color'];
						$text_color = $field['text_color'];
						?>
						<div class="col-lg-4 bottom_margin" >
							<div class="card">
								<div class="card-body" style="background-color:<?php echo $color; ?>;">
									<h6 class="card-title " style="color:<?php if($i == 1 ){ echo "#26aae1;"; }else{ echo $color; } ?>;"><?php echo  $field['title']; ?></h6>
									<div class="content" style="color:<?php echo $text_color; ?>"><?php echo  $field['info']; ?></div>
								</div>
								<h2 class="text-center"><?php echo  $field['price']; ?></h2>
							</div>
							<div class="button_wrap"><a style="color:<?php echo $text_color; ?>;background-color:<?php echo $color; ?>!important;" href="<?php echo  $field['link']; ?>">PURCHASE THIS PACKAGE</a></div>
						</div>
						<?php
					}
				}
				?>
				<div style="clear: both;"></div>
				<h3 class="message"><?php the_field("bottom_message"); ?></h3>
			</div>
			
			<div class="row flower_section">
				<div class="inner_section">
					<h2 class="text-center"><?php the_field("heading_three"); ?></h2>
					<img src="<?php the_field("section_image"); ?>">
				</div>
				<p><?php the_field("bottom_text"); ?></p>
			</div>
		<?php endwhile; // end of the loop. ?>
		</div>
	</div>
<?php get_footer(); ?>
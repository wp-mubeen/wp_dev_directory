<div id="tb-blog-metabox" class='tb_metabox'>
	<?php
	$this->select('post_quote_type',
			'Quote Content',
			array(
					'' 	=> 'From Post',
					'custom' 		=> 'Custom'
			),
			'',
			''
	);
	?>
	<div id="post_quote_custom">
	<?php
	$this->textarea('post_quote',
			'Content',
			__('Please type the text for your quote here.','aqua')
	);
	$this->text('post_author',
			'Author',
			'',
			__('Please type the text for author quote here.','aqua')
	);
	?>
	</div>
</div>
<?php

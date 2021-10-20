<div id="tb-blog-metabox" class='tb_metabox'>
	<?php
	$this->textarea('post_note_text',
			'Note Text',
			'',
			__('Please input the URL note text for your post.','aqua')
	);
	$this->text('post_note_extra_link',
			'Note Extra Link',
			'',
			__('Please input extra link of note for your post. http://www.youwebsite.com','aqua')
	);
	?>
</div>
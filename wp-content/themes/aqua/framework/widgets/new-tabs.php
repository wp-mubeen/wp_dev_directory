<?php
class TB_New_Tabs_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
                'tb_new_tabs_widget', // Base ID
                __('TB New Tabs', 'aqua'), // Name
                array('description' => __('New Tabs Widget', 'aqua'),) // Args
        );
    }
    function widget($args, $instance) {
	
        extract($args);
		
        $posts = $instance['posts'];
        $comments = $instance['comments'];
        $tags_count = $instance['tags'];
        $show_popular_posts = isset($instance['show_popular_posts']) ? 'true' : 'false';
        $show_recent_posts = isset($instance['show_recent_posts']) ? 'true' : 'false';
        $show_comments = isset($instance['show_comments']) ? 'true' : 'false';
        $show_tags = isset($instance['show_tags']) ? 'true' : 'false';

        $extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : "";

        // no 'class' attribute - add one with the value of width
        if( strpos($before_widget, 'class') === false ) {
            $before_widget = str_replace('>', 'class="'. $extra_class . '"', $before_widget);
        }
        // there is 'class' attribute - append width value to it
        else {
            $before_widget = str_replace('class="', 'class="'. $extra_class . ' ', $before_widget);
        }

        echo tb_filtercontent($before_widget);
        ?>
        <div class="tab-holder">
            <div class="tab-hold tabs-wrapper">
                <ul id="tabs" class="nav nav-tabs">
                    <?php if ($show_popular_posts == 'true'): ?>
                        <li class="active tbripple" ><a href="#tab1" data-toggle="tab" ><?php echo __('Popular', 'aqua'); ?></a></li>
                    <?php endif; ?>
                    <?php if ($show_recent_posts == 'true'): ?>
                        <li class="tbripple"><a href="#tab2" data-toggle="tab" ><?php echo __('Recent', 'aqua'); ?></a></li>
                    <?php endif; ?>
                    <?php if ($show_comments == 'true'): ?>
                        <li class="tbripple"><a href="#tab3" data-toggle="tab"><?php echo __('Comments', 'aqua'); ?></a></li>
                    <?php endif; ?>
                </ul>
                <div class="tab-content">
                    <?php if ($show_popular_posts == 'true'): ?>
                        <div id="tab1" class="tab-pane active">
                            <?php
                            $popular_posts = new WP_Query('showposts=' . $posts . '&orderby=comment_count&order=DESC');
                            if ($popular_posts->have_posts()):
                                ?>
                                <ul class="news-list tb-popular tb-style-list">
                                    <?php while ($popular_posts->have_posts()): $popular_posts->the_post(); ?>
                                        <li>
                                            <div class="tb-meta table-cell">
                                                <div class="image">
                                                   	<a class="post-featured-img" href="<?php the_permalink(); ?>">
                                                       <?php
														if(has_post_thumbnail()){
															the_post_thumbnail('thumbnail');
														}else{
															echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr(URI_PATH.'/assets/images/post_default.jpg') .'">';
														}
														?>
                                                   	</a>
                                                </div>
    			                                <div class="date">
                                                    <span><?php echo get_the_date('M jS'); ?></span>
                                                    <span><?php echo get_the_date('Y'); ?></span>
                                                </div>
                                            </div>

                                            <div class="tb-details table-cell">
                                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                <div class="description"><?php echo tb_custom_excerpt( 10, '...'); ?></div>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($show_recent_posts == 'true'): ?>
                        <div id="tab2" class="tab-pane">
                            <?php
                            $recent_posts = new WP_Query('showposts=' . $posts);
                            if ($recent_posts->have_posts()):
                                ?>
                                <ul class="news-list tb-popular tb-style-list">
                                    <?php while ($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                                        <li>
                                            <div class="tb-meta table-cell">
                                                <div class="image">
                                                   	<a class="post-featured-img" href="<?php the_permalink(); ?>">
                                                       <?php
														if(has_post_thumbnail()){
															the_post_thumbnail('thumbnail');
														}else{
															echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr(URI_PATH.'/assets/images/post_default.jpg') .'">';
														}
														?>
                                                   	</a>
                                                </div>
    			                                <div class="date">
    			                                	<span><?php echo get_the_date('M jS'); ?></span>
                                                    <span><?php echo get_the_date('Y'); ?></span>
                                                </div>
                                            </div>

                                            <div class="tb-details table-cell">
                                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                <div class="description"><?php echo tb_custom_excerpt( 10, '...'); ?></div>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($show_comments == 'true'): ?>
                        <div id="tab3" class="tab-pane">
                            <ul class="news-list sh-list-comment tb-style-list">
                                <?php
                                global $wpdb;
                                $number = $instance['comments'];
                                $recent_comments = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,110) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $number";
                                $the_comments = $wpdb->get_results($recent_comments);
                                foreach ($the_comments as $comment) {
                                    ?>
                                    <li>
                                        <div class="image table-cell">
                                            <a>
                                                <?php echo get_avatar($comment->comment_author_email, '32'); ?>
                                            </a>
                                        </div>
                                        <div class="post-holder table-cell">
                                            <p><?php echo strip_tags($comment->comment_author); ?> says:</p>
                                            <div class="meta">
                                                <a class="comment-text-side" href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo tb_filtercontent($comment->comment_ID); ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo tb_filtercontent($comment->post_title); ?>"><?php echo tb_filtercontent($comment->com_excerpt); ?>...</a>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        echo tb_filtercontent($after_widget);
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['posts'] = $new_instance['posts'];
        $instance['comments'] = $new_instance['comments'];
        $instance['tags'] = $new_instance['tags'];
        $instance['show_popular_posts'] = $new_instance['show_popular_posts'];
        $instance['show_recent_posts'] = $new_instance['show_recent_posts'];
        $instance['show_comments'] = $new_instance['show_comments'];
        $instance['show_tags'] = $new_instance['show_tags'];
        $instance['extra_class'] = $new_instance['extra_class'];

        return $instance;
    }

    function form($instance) {
        $defaults = array('posts' => 3, 'comments' => 3, 'tags' => 3, 'show_popular_posts' => 'on', 'show_recent_posts' => 'on', 'show_comments' => 'on', 'show_tags' => 'on');
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('posts')); ?>">Number of popular posts:</label>
            <input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('tags')); ?>">Number of recent posts:</label>
            <input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('tags')); ?>" name="<?php echo esc_attr($this->get_field_name('tags')); ?>" value="<?php echo esc_attr($instance['tags']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('comments')); ?>">Number of comments:</label>
            <input class="widefat" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('comments')); ?>" name="<?php echo esc_attr($this->get_field_name('comments')); ?>" value="<?php echo esc_attr($instance['comments']); ?>" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_popular_posts'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_popular_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('show_popular_posts')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_popular_posts')); ?>">Show popular posts</label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_recent_posts'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_recent_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('show_recent_posts')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_recent_posts')); ?>">Show recent posts</label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_comments')); ?>" name="<?php echo esc_attr($this->get_field_name('show_comments')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_comments')); ?>">Show comments</label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>">Extra Class:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php if(isset($instance['extra_class'])){echo esc_attr($instance['extra_class']);} ?>" />
        </p>
        <?php
    }
}
/**
 * Class TB_New_Tabs_Widget
 */
function register_new_tabs_widget() {
    register_widget('TB_New_Tabs_Widget');
}
add_action('widgets_init', 'register_new_tabs_widget');
?>

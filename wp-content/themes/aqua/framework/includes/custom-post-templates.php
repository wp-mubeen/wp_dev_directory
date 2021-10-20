<?php
/**
 *
 * @package default
 * @author Simon Wheatley
 **/
class tb_CustomPostTemplates
{
	private $tpl_meta_key;
	private $post_ID;
	
	function __construct()
	{
		// Init properties
		$this->tpl_meta_key = 'custom_post_template';
		// NOTE TO PEOPLE WANTING TO USE CUSTOM POST TYPES:
		// Don't edit this file, instead use the cpt_post_types filter. See the plugin description
		// for more information. Thank you and good night.
		add_action( 'admin_init',array($this,'admin_init') );
		add_action( 'save_post',array($this,'save_post') );
		add_filter( 'single_template',array($this,'filter_single_template')) ;
		add_filter( 'body_class',array($this,'body_class') );
	}
	
	/*
	 *  FILTERS & ACTIONS
	 * *******************
	 */
	
	/**
	 * Hooks the WP admin_init action to add metaboxes
	 *
	 * @param  
	 * @return void
	 * @author Simon Wheatley
	 **/
	public function admin_init() {
		// NOTE TO PEOPLE WANTING TO USE CUSTOM POST TYPES:
		// Don't edit this file, instead use the cpt_post_types filter. See the plugin description
		// for more information. Thank you and good night.
 		$post_types = apply_filters( 'cpt_post_types', array( 'post' ) );
		foreach ( $post_types as $post_type )
			add_meta_box( 'select_post_template', __( 'Post Template', 'aqua' ), array($this,'select_post_template'), $post_type, 'side', 'default' );
	}
	
	/**
	 * Hooks the WP body_class function to add a class to single posts using a post template.
	 *
	 * @param array $classes An array of strings 
	 * @return array An array of strings
	 * @author Simon Wheatley
	 **/
	public function body_class( $classes ) {
		global $wp_query;
		// We distrust the global $post object, as it can be substituted in any
		// number of different ways.
		$post = $wp_query->get_queried_object();
		$post_id = isset($post->ID) ? $post->ID : '';
		$post_template = get_post_meta( $post_id, 'custom_post_template', true );
		$classes[] = 'post-template';
		$classes[] = 'post-template-' . str_replace( '.php', '-php', $post_template );
		return $classes;
	}

	public function select_post_template( $post )
	{
		$this->post_ID = $post->ID;

		$template_vars = array();
		$template_vars[ 'templates' ] = $this->get_post_templates();
		$template_vars[ 'custom_template' ] = $this->get_custom_post_template();

		// Render the template
		$this->render_admin ( 'select_post_template', $template_vars );
	}
	function render_admin ($ug_name, $ug_vars = array ())
	{
		$templates = $ug_vars['templates'];
		$custom_template = $ug_vars['custom_template']; ?>
		<label class="hidden" for="page_template"><?php _e( 'Post Template', 'aqua' ); ?></label>
		<?php if ( $templates ) : ?>
		<input type="hidden" name="custom_post_template_present" value="1" />
		<select name="custom_post_template" id="custom_post_template">
			<option 
				value='default'
				<?php
					if ( ! $custom_template ) {
						echo "selected='selected'";
					}
				?>><?php _e( 'Default Template', 'aqua'  ); ?></option>
			<?php foreach( $templates AS $k => $v ) { ?>
				<option 
					value='<?php echo tb_filtercontent($v['path']); ?>'
					<?php
						if ( $custom_template == $v['path'] ) {
							echo "selected='selected'";
						}
					?>><?php echo tb_filtercontent($v['name']); ?></option>
			<?php } ?>
		</select>
	<?php
		endif;
	}
	public function save_post( $post_ID )
	{
		$action_needed = (bool) @ $_POST[ 'custom_post_template_present' ];
		if ( ! $action_needed ) return;

		$this->post_ID = $post_ID;

		$template = (string) @ $_POST[ 'custom_post_template' ];
		$this->set_custom_post_template( $template );
	}

	public function filter_single_template( $template ) 
	{
		global $wp_query;
		$this->post_ID = $wp_query->post->ID;
		// No template? Nothing we can do.
		$template_file = $this->get_custom_post_template();
		$template_file = ABS_PATH_FR . "/templates/singlepost/$template_file";
		if ( is_file($template_file) ) $template =  $template_file;
		return $template;
	}

	/*
	 *  UTILITY METHODS
	 * *****************
	 */
	
	protected function set_custom_post_template( $template )
	{
		delete_post_meta( $this->post_ID, $this->tpl_meta_key );
		if ( ! $template || $template == 'default' ) return;

		add_post_meta( $this->post_ID, $this->tpl_meta_key, $template );
	}
	
	protected function get_custom_post_template()
	{
		$custom_template = get_post_meta( $this->post_ID, $this->tpl_meta_key, true );
		return $custom_template;
	}

	protected function get_post_templates() 
	{
		$post_templates = array();

		$files = glob( ABS_PATH_FR . "/templates/singlepost/*.php");
		foreach ( $files as $k => $full_path ) {
			$headers = get_file_data( $full_path, array( 'Template Name Posts' => 'Template Name Posts' ) );
			if ( empty( $headers['Template Name Posts'] ) )
				continue;
			$post_templates[$k][ 'name' ] = $headers['Template Name Posts'];
			$post_templates[$k][ 'path' ] = basename($full_path);
		}

		return $post_templates;
	}
}

/**
 * Instantiate the plugin
 *
 * @global
 **/

$tbCustomPostTemplates = new tb_CustomPostTemplates();

?>
<?php
    /**
     * ReduxFramework Theme Config File
     * For full documentation, please visit: https://docs.reduxframework.com
     * */

    if ( ! class_exists( 'Redux_Framework_theme_config' ) ) {

        class Redux_Framework_theme_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }
				add_action( 'admin_enqueue_scripts', array( $this, 'tbtheme_add_scripts' ));

            }
			public function tbtheme_add_scripts(){
				wp_enqueue_script( 'action', URI_PATH_ADMIN.'/assets/js/action.js', false );
				wp_enqueue_style( 'style_admin', URI_PATH_ADMIN.'/assets/css/style_admin.css', false );
			}
            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                //$this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'aqua' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'aqua' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */
                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'aqua' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'aqua' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'aqua' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo tb_filtercontent($this->theme->display( 'Name' )); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'aqua' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'aqua' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'aqua' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo tb_filtercontent($this->theme->display( 'Description' )); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'aqua' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'aqua' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';
                if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
                    Redux_Functions::initWpFilesystem();

                    global $wp_filesystem;

                    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
                }
				
				$of_options_fontsize = array("8px" => "8px", "9px" => "9px", "10px" => "10px", "11px" => "11px", "12px" => "12px", "13px" => "13px", "14px" => "14px", "15px" => "15px", "16px" => "16px", "17px" => "17px", "18px" => "18px", "19px" => "19px", "20px" => "20px", "21px" => "21px", "22px" => "22px", "23px" => "23px", "24px" => "24px", "25px" => "25px", "26px" => "26px", "27px" => "27px", "28px" => "28px", "29px" => "29px", "30px" => "30px", "31px" => "31px", "32px" => "32px", "33px" => "33px", "34px" => "34px", "35px" => "35px", "36px" => "36px", "37px" => "37px", "38px" => "38px", "39px" => "39px", "40px" => "40px");
				$of_options_fontweight = array("100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700");
				$of_options_font = array("1" => "Google Font", "2" => "Standard Font", "3" => "Custom Font");
				//Google font API
				$of_options_google_font = array();
				if (is_admin()) {
					$results = '';
					//$whitelist = array('127.0.0.1','::1');
					//if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
						$results = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyDnf-ujK_DUCihfvzqdlBokan6zbnrJbi0');
						if (!is_wp_error($results)) {
								$results = json_decode($results['body']);
								if(isset($results->items)){
									foreach ($results->items as $font) {
										$of_options_google_font[$font->family] = $font->family;
									}
								}
						}
					//}
				}
				//Standard Fonts
				$of_options_standard_fonts = array(
					'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
					"'Arial Black', Gadget, sans-serif" => "'Arial Black', Gadget, sans-serif",
					"'Bookman Old Style', serif" => "'Bookman Old Style', serif",
					"'Comic Sans MS', cursive" => "'Comic Sans MS', cursive",
					"Courier, monospace" => "Courier, monospace",
					"Garamond, serif" => "Garamond, serif",
					"Georgia, serif" => "Georgia, serif",
					"Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
					"'Lucida Console', Monaco, monospace" => "'Lucida Console', Monaco, monospace",
					"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
					"'MS Sans Serif', Geneva, sans-serif" => "'MS Sans Serif', Geneva, sans-serif",
					"'MS Serif', 'New York', sans-serif" => "'MS Serif', 'New York', sans-serif",
					"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
					"Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
					"'Times New Roman', Times, serif" => "'Times New Roman', Times, serif",
					"'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
					"Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif"
				);
				// Custom Font
				$fonts = array();
				$of_options_custom_fonts = array();
				$font_path = get_template_directory() . "/fonts";
				if (!$handle = opendir($font_path)) {
					$fonts = array();
				} else {
					while (false !== ($file = readdir($handle))) {
						if (strpos($file, ".ttf") !== false ||
							strpos($file, ".eot") !== false ||
							strpos($file, ".svg") !== false ||
							strpos($file, ".woff") !== false
						) {
							$fonts[] = $file;
						}
					}
				}
				closedir($handle);

				foreach ($fonts as $font) {
					$font_name = str_replace(array('.ttf', '.eot', '.svg', '.woff'), '', $font);
					$of_options_custom_fonts[$font_name] = $font_name;
				}
				/* remove dup item */
				$of_options_custom_fonts = array_unique($of_options_custom_fonts);
				
				/*General Setting*/
				$this->sections[] = array(
                    'title'  => __( 'General Setting', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-cogs',
                    'fields' => array(
						array(
                            'id'       => 'tb_responsive',
                            'type'     => 'switch',
                            'title'    => __( 'Responsive Design', 'aqua' ),
                            'subtitle' => __( 'Use the responsive design features.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_less',
                            'type'     => 'switch',
                            'title'    => __( 'Less Design', 'aqua' ),
                            'subtitle' => __( 'Use the less design features.', 'aqua' ),
							'default'  => false,
                        ),
						array(
							'id'       => 'tb_layout',
							'type'     => 'button_set',
							'title'    => __('Layout', 'aqua'),
							'subtitle' => __('Set layout your site', 'aqua'),
							'options' => array(
								'wide' => 'Wide',
								'boxed' => 'Boxed'
							 ),
							'default' => 'wide'
						),
						array(
							'id'       => 'tb_background',
							'type'     => 'background',
							'title'    => __('Body Background', 'aqua'),
							'subtitle' => __('Body background with image, color, etc.', 'aqua'),
							'default'  => array(
								'background-color' => '#ffffff',
							),
							'output' => array('body'),
						),
					)
					
				);
				/*Logo*/
				$this->sections[] = array(
                    'title'  => __( 'Logo', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-viadeo',
                    'fields' => array(
						array(
							'id'       => 'tb_favicon_image',
							'type'     => 'media',
							'url'      => true,
							'title'    => __('Favicon Image', 'aqua'),
							'subtitle' => __('Select an image file for your favicon.', 'aqua'),
							'default'  => array(
								'url'	=> URI_PATH.'/favicon.ico'
							),
						),
						array(
							'id'       => 'tb_logo_image',
							'type'     => 'media',
							'url'      => true,
							'title'    => __('Logo Image', 'aqua'),
							'subtitle' => __('Select an image file for your logo.', 'aqua'),
							'default'  => array(
								'url'	=> URI_PATH.'/assets/images/logo.png'
							),
						),
						array(
							'id'       => 'tb_logo_mbmenu',
							'type'     => 'media',
							'url'      => true,
							'title'    => __('Logo Mobile Menu', 'aqua'),
							'subtitle' => __('Select an image file for your logo.', 'aqua'),
							'default'  => array(
								'url'	=> URI_PATH.'/assets/images/aqua-brand3.png'
							),
						),
					)
					
				);
				/*Header*/
				$this->sections[] = array(
                    'title'  => __( 'Header', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-file-edit',
                    'fields' => array(
						array( 
							'id'       => 'tb_header_layout',
							'type'     => 'image_select',
							'title'    => __('Header Layout', 'aqua'),
							'subtitle' => __('Select header layout in your site.', 'aqua'),
							'options'  => array(
								'v1'	=> array(
										'alt'   => 'Header 1',
										'img'   => URI_PATH.'/assets/images/headers/header-default.jpg'
									),
								'v2'	=> array(
										'alt'   => 'Header 2',
										'img'   => URI_PATH.'/assets/images/headers/header-v2.jpg'
									),
							),
							'default' => 'v1'
						),
						array(
                            'id'       => 'tb_header_top_widget',
                            'type'     => 'switch',
                            'title'    => __( 'Header Top Widgets', 'aqua' ),
                            'subtitle' => __( 'Display header top widgets.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_stick_header',
                            'type'     => 'switch',
                            'title'    => __( 'Stick Header', 'aqua' ),
                            'subtitle' => __( 'Enable a fixed header when scrolling.', 'aqua' ),
							'default'  => false,
                        ),
					)
				);
				/*Main Menu*/
				$this->sections[] = array(
                    'title'  => __( 'Main Menu', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-list',
                    'fields' => array(
						array(
							'id'          => 'tb_menu_font_size_firts_level',
							'type'        => 'typography', 
							'title'       => __('Typography', 'aqua'),
							'color'      => false, 
							'font-weight' => false, 
							'subsets' => false,
							'font-backup' => false,
							'subtitle' => __('Typography option with firts level item in menu. Default: 14px, ex: 14px.', 'aqua'),
							'default'     => array(
								'font-size'   => '14px',
							),
							'output' => array('#nav > li > a,.tb-header-shop #nav > li > a'),
						),
						array(
							'id'          => 'tb_menu_font_size_sub_level',
							'type'        => 'typography', 
							'title'       => __('Typography', 'aqua'),
							'color'      => false, 
							'font-weight' => false, 
							'subsets' => false,
							'font-backup' => false,
							'subtitle' => __('Typography option with sub level item in menu.', 'aqua'),
							'default'     => array(
								'font-size'   => '13px',
							),
							'output' => array('#nav > li > ul li a,.tb-header-shop #nav > li > ul li a'),
						),
					)
					
				);
				/*Footer*/
				$this->sections[] = array(
                    'title'  => __( 'Footer', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-file-edit',
                    'fields' => array(
						array(
                            'id'       => 'tb_display_footer',
                            'type'     => 'switch',
                            'title'    => __( 'Display Footer', 'aqua' ),
                            'subtitle' => __( 'Display footer.', 'aqua' ),
							'default'  => true,
                        ),
						array(
							'id'       => 'tb_footer_bg',
							'type'     => 'background',
							'title'    => __('Footer Background', 'aqua'),
							'subtitle' => __('Footer background with image, color, etc.', 'aqua'),
							'default'  => array(
								'background-color' => '#222222',
							),
							'output' => array('.tb_footer'),
						),
						array(
							'id' => 'tb_footer_margin',
							'title' => 'Footer Margin',
							'subtitle' => __('Please, Enter margin of Footer.', 'aqua'),
							'type' => 'spacing',
							'mode' => 'margin',
							'units' => array('px'),
							'output' => array('.tb_footer'),
							'default' => array(
								'margin-top'     => '0', 
								'margin-right'   => '0', 
								'margin-bottom'  => '0', 
								'margin-left'    => '0',
								'units'          => 'px', 
							)
						),
						array(
							'id' => 'tb_footer_padding',
							'title' => 'Footer Padding',
							'subtitle' => __('Please, Enter padding of Footer.', 'aqua'),
							'type' => 'spacing',
							'units' => array('px'),
							'output' => array('.tb_footer'),
							'default' => array(
								'padding-top'     => '0', 
								'padding-right'   => '0', 
								'padding-bottom'  => '0', 
								'padding-left'    => '0',
								'units'          => 'px', 
							)
						),
						
					)
					
				);
				$this->sections[] = array(
                    'title'  => __( 'Footer Top', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-file-edit',
					'subsection' => true,
                    'fields' => array(
						array(
							'id' => 'tb_footer_top_margin',
							'title' => 'Footer Top Margin',
							'subtitle' => __('Please, Enter margin of Footer Top.', 'aqua'),
							'type' => 'spacing',
							'mode' => 'margin',
							'units' => array('px'),
							'output'  => array('.tb_footer .footer-top'),
							'default' => array(
								'margin-top'     => '0', 
								'margin-right'   => '0', 
								'margin-bottom'  => '0', 
								'margin-left'    => '0',
								'units'          => 'px', 
							)
						),
						array(
							'id' => 'tb_footer_top_padding',
							'title' => 'Footer Top Padding',
							'subtitle' => __('Please, Enter padding of Footer Top.', 'aqua'),
							'type' => 'spacing',
							'units' => array('px'),
							'output'  => array('.tb_footer .footer-top'),
							'default' => array(
								'padding-top'     => '40px', 
								'padding-right'   => '0', 
								'padding-bottom'  => '40px', 
								'padding-left'    => '0',
								'units'          => 'px', 
							)
						),
						array(
							'id'       => 'tb_footer_top_column',
							'type'     => 'select',
							'title'    => __('Footer Top Columns', 'aqua'),
							'subtitle' => __('Select column of footer top.', 'aqua'),
							'options'  => array(
								'1' => '1 Column',
								'2' => '2 Columns',
								'3' => '3 Columns',
								'4' => '4 Columns'
							),
							'default'  => '',
						),
						array(
							'id'       => 'tb_footer_top_col1',
							'type'     => 'text',
							'title'    => __('Footer Top Column 1', 'aqua'),
							'subtitle' => __('Please, Enter class boostrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'aqua'),
							'default'  => 'col-xs-12 col-sm-7 col-md-3 col-lg-3',
							'required' => array('tb_footer_top_column','>=','1')
						),
						array(
							'id'       => 'tb_footer_top_col2',
							'type'     => 'text',
							'title'    => __('Footer Top Column 2', 'aqua'),
							'subtitle' => __('Please, Enter class boostrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'aqua'),
							'default'  => 'col-xs-12 col-sm-5 col-md-2 col-lg-2',
							'required' => array('tb_footer_top_column','>=','2')
						),
						array(
							'id'       => 'tb_footer_top_col3',
							'type'     => 'text',
							'title'    => __('Footer Top Column 3', 'aqua'),
							'subtitle' => __('Please, Enter class boostrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'aqua'),
							'default'  => 'col-xs-12 col-sm-5 col-md-2 col-lg-2',
							'required' => array('tb_footer_top_column','>=','3')
						),
						array(
							'id'       => 'tb_footer_top_col4',
							'type'     => 'text',
							'title'    => __('Footer Top Column 4', 'aqua'),
							'subtitle' => __('Please, Enter class boostrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'aqua'),
							'default'  => 'col-xs-12 col-sm-7 col-md-5 col-lg-5 tb-col4',
							'required' => array('tb_footer_top_column','>=','4')
						),
						array( 
							'id'       => 'tb_footer_top_col4_border_left',
							'type'     => 'border',
							'top'     => false,
							'right'     => false,
							'bottom'     => false,
							'left'     => true,
							'title'    => __('Footer Top Column 4 Border Left', 'aqua'),
							'output'  => array('.tb_footer .footer-top .tb-col4'),
							'subtitle'     => __('Please, Enter attribute of border.', 'aqua'),
							'default'  => array(
								'border-color'  => '#999999', 
								'border-style'  => 'solid', 
								'border-top'    => '0px'
							),
							'required' => array('tb_footer_top_column','>=','4')
						),
					)
					
				);
				$this->sections[] = array(
                    'title'  => __( 'Footer Bottom', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-file-edit',
					'subsection' => true,
                    'fields' => array(
						array(
							'id' => 'tb_footer_bottom_margin',
							'title' => 'Footer Bottom Margin',
							'subtitle' => __('Please, Enter margin of Footer Bottom.', 'aqua'),
							'type' => 'spacing',
							'mode' => 'margin',
							'units' => array('px'),
							'output'  => array('.tb_footer .footer-bottom'),
							'default' => array(
								'margin-top'     => '0', 
								'margin-right'   => '0', 
								'margin-bottom'  => '0', 
								'margin-left'    => '0',
								'units'          => 'px', 
							)
						),
						array(
							'id' => 'tb_footer_bottom_padding',
							'title' => 'Footer Bottom Padding',
							'subtitle' => __('Please, Enter padding of Footer Bottom.', 'aqua'),
							'type' => 'spacing',
							'units' => array('px'),
							'output'  => array('.tb_footer .footer-bottom'),
							'default' => array(
								'padding-top'     => '20px', 
								'padding-right'   => '0', 
								'padding-bottom'  => '20px', 
								'padding-left'    => '0',
								'units'          => 'px', 
							)
						),
						array( 
							'id'       => 'tb_footer_bottom_border_top',
							'type'     => 'border',
							'top'     => true,
							'right'     => false,
							'bottom'     => false,
							'left'     => false,
							'output'  => array('.tb_footer .footer-bottom'),
							'title'    => __('Footer Bottom Border Top', 'aqua'),
							'subtitle'     => __('Please, Enter attribute of border.', 'aqua'),
							'default'  => array(
								'border-color'  => '#999999', 
								'border-style'  => 'solid', 
								'border-top'    => '0px'
							)
						),
						array(
							'id'       => 'tb_footer_bottom_column',
							'type'     => 'select',
							'title'    => __('Footer Bottom Columns', 'aqua'),
							'subtitle' => __('Select column of footer bottom.', 'aqua'),
							'options'  => array(
								'1' => '1 Column',
								'2' => '2 Columns'
							),
							'default'  => '',
						),
						array(
							'id'       => 'tb_footer_bottom_col1',
							'type'     => 'text',
							'title'    => __('Footer Bottom Column 1', 'aqua'),
							'subtitle' => __('Please, Enter class boostrap and extra class. Ex: col-xs-12 col-sm-6 col-md-6 col-lg-6 el-class.', 'aqua'),
							'default'  => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
							'required' => array('tb_footer_bottom_column','>=','1')
						),
						array(
							'id'       => 'tb_footer_bottom_col2',
							'type'     => 'text',
							'title'    => __('Footer Bottom Column 2', 'aqua'),
							'subtitle' => __('Please, Enter class boostrap and extra class. Ex: col-xs-12 col-sm-6 col-md-6 col-lg-6 el-class.', 'aqua'),
							'default'  => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
							'required' => array('tb_footer_bottom_column','>=','2')
						),
					)
				);
				$this->sections[] = array(
                    'title'  => __( 'Footer Color White', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-file-edit',
					'subsection' => true,
                    'fields' => array(
						array(
							'id'       => 'tb_footer_white_bg',
							'type'     => 'background',
							'output'  => array('.tb_footer.white'),
							'title'    => __('Footer White Background', 'aqua'),
							'subtitle' => __('Footer White background with image, color, etc.', 'aqua'),
							'default'  => array(
								'background-color' => '#ffffff',
							)
						),
						array( 
							'id'       => 'tb_footer_top_white_border_left',
							'type'     => 'border',
							'top'     => false,
							'left'     => true,
							'right'     => false,
							'bottom'     => false,
							'title'    => __('Footer Top White Border Left', 'aqua'),
							'subtitle'     => __('Please, Enter attribute of border.', 'aqua'),
							'output'  => array('.tb_footer.white'),
							'default'  => array(
								'border-color'  => '#999999', 
								'border-style'  => 'solid', 
								'border-top'    => '1px'
							)
						),
						array( 
							'id'       => 'tb_footer_bottom_white_border_top',
							'type'     => 'border',
							'left'     => false,
							'right'     => false,
							'bottom'     => false,
							'title'    => __('Footer Bottom White Border Top', 'aqua'),
							'subtitle'     => __('Please, Enter attribute of border.', 'aqua'),
							'output'  => array('.tb_footer.white .footer-top'),
							'default'  => array(
								'border-color'  => '#999999', 
								'border-style'  => 'solid', 
								'border-top'    => '1px'
							)
						),
						array(
							'id'       => 'tb_footer_white_heading_color',
							'type'     => 'color',
							'title'    => __('Footer White Heading Color', 'aqua'),
							'subtitle' => __('Controls the headings color of footer. (default: #d3d3d3).', 'aqua'),
							'default'  => '#d3d3d3',
							'validate' => 'color',
							'output'  => array('.tb_footer.white h1,.tb_footer.white h2,.tb_footer.white h3,.tb_footer.white h4,.tb_footer.white h5,.tb_footer.white h6'),
						),
						array(
							'id'       => 'tb_footer_white_link_color',
							'type'     => 'link_color',
							'title'    => __('Footer White Link Color', 'aqua'),
							'subtitle' => __('Controls the links color of footer.', 'aqua'),
							'default'  => '#84c340',
							'validate' => 'color',
							'default'  => array(
								'regular'  => '#84c340', // blue
								'hover'    => '#fc5e49',
							),
							'output'  => array('.tb_footer.white a'),
						),
						array(
							'id'       => 'tb_footer_white_text_color',
							'type'     => 'color',
							'title'    => __('Footer White Text Color', 'aqua'),
							'subtitle' => __('Controls the text color of footer. (default: #999999).', 'aqua'),
							'default'  => '#999999',
							'validate' => 'color',
							'output'  => array('.tb_footer.white'),
						)
					)
				);
				/*Styling Setting*/
				$this->sections[] = array(
                    'title'  => __( 'Styling Options', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-tint',
                    'fields' => array(
						array(
							'id'       => 'tb_primary_color',
							'type'     => 'color',
							'title'    => __('Primary Color', 'aqua'),
							'subtitle' => __('Controls several items, ex: link hovers, highlights, and more. (default: #84c340).', 'aqua'),
							'default'  => '#84c340',
							'validate' => 'color',
						),
						/*array(
							'id'       => 'tb_link_color',
							'type'     => 'link_color',
							'title'    => __('Link Color', 'aqua'),
							'subtitle' => __('Controls the links color of all links.', 'aqua'),
							'validate' => 'color',
							'default'  => array(
								'regular'  => '#444444', // blue
								'hover'    => '#84c340',
							),
							'output' => array('body a'),
						),
						array(
							'id'       => 'tb_button_color',
							'type'     => 'color',
							'title'    => __('Button Color', 'aqua'),
							'subtitle' => __('Controls the color of all buttons. (default: #84c340).', 'aqua'),
							'default'  => '#84c340',
							'validate' => 'color',
							'output' => array('button, input[type="button"], input[type="button"]'),
						)*/
					)
				);
				$this->sections[] = array(
                    'title'  => __( 'Menu Color', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array(
							'id'       => 'tb_main_menu_color_level1',
							'type'     => 'link_color',
							'title'    => __('Main Menu Font Color _ First Level', 'aqua'),
							'subtitle' => __('Controls the text color of first level menu items.', 'aqua'),
							'validate' => 'color',
							'default'  => array(
								'regular'  => '#444444', // blue
								'hover'    => '#444444',
							),
						),
						array(
							'id'       => 'tb_main_menu_font_color_sub_level',
							'type'     => 'link_color',
							'title'    => __('Main Menu Font Color _ SubLevel', 'aqua'),
							'subtitle' => __('Controls the color of the menu font sublevel.', 'aqua'),
							'validate' => 'color',
							'default'  => array(
								'regular'  => '#ffffff', // blue
								'hover'    => '#84c340',
							),
						),
						array(
							'id'       => 'tb_main_menu_bg_sub_level',
							'type'     => 'background',
							'background-color' => true,
							'background-repeat' => false,
							'background-attachment' => false,
							'background-position' => false,
							'background-image' => false,
							'background-clip' => false,
							'background-origin' => false,
							'background-size' => false,
							'preview' => false,
							'background-size' => false,
							'background-size' => false,
							'title'    => __('Main Menu Background Color _ SubLevel', 'aqua'),
							'subtitle' => __('Controls the color of the menu sublevel background', 'aqua'),
							'default'  => array('background-color' => '#000000'),
							'validate' => 'color',
							'output' => array('#nav > li > ul,.tb-header-shop #nav > li > ul, #nav .ul-depth-1'),
						),
						array(
							'id'       => 'tb_main_menu_separator_color_sub_level',
							'type'     => 'color',
							'title'    => __('Main Menu Separator Color _ SubLevel', 'aqua'),
							'subtitle' => __('Controls the color of the menu separator sublevel. (default: #444444).', 'aqua'),
							'default'  => '#444444',
							'validate' => 'color',
						),
					)
					
				);
				$this->sections[] = array(
                    'title'  => __( 'Header Color', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array(
							'id'       => 'tb_header_bg_color',
							'type'     => 'color_rgba',
							'title'    => __('Header Background Color', 'aqua'),
							'subtitle' => __('Controls the background color of header', 'aqua'),
							'default'  => array(
								'color'     => '#FFFFFF',
								'alpha'     => 1,
								'alpha'     => 1,
								'rgba'=>'rgba(255,255,255,1)'
							),
							'validate' => 'color',
							'output' => array(
								'background-color' => '.tb-header-wrap',
							)
						),
					)
				);
				$this->sections[] = array(
                    'title'  => __( 'Title Bar Color', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array(
							'id'       => 'tb_title_bar_heading_color',
							'type'     => 'color',
							'title'    => __('Title Bar Heading Color', 'aqua'),
							'subtitle' => __('Controls the headings color of title bar. (default: #555555).', 'aqua'),
							'default'  => '#555555',
							'validate' => 'color',
							'output'  => array('.title-bar h1,.title-bar h2,.title-bar h3,.title-bar h4,.title-bar h5,.title-bar h6,.woocommerce .title-bar-shop h1,.woocommerce .title-bar-shop h2,.woocommerce .title-bar-shop h3,.woocommerce .title-bar-shop h4,.woocommerce .title-bar-shop h5,.woocommerce .title-bar-shop h6'),
						),
						array(
							'id'       => 'tb_title_bar_link_color',
							'type'     => 'link_color',
							'title'    => __('Title Bar Link Color', 'aqua'),
							'subtitle' => __('Controls the links color of title bar.', 'aqua'),
							'default'  => '#84c340',
							'validate' => 'color',
							'default'  => array(
								'regular'  => '#84c340', // blue
								'hover'    => '#8dc155',
							),
							'output' => array('.title-bar a,.woocommerce .title-bar-shop a'),
						),
						array(
							'id'       => 'tb_title_bar_text_color',
							'type'     => 'color',
							'title'    => __('Title Bar Text Color', 'aqua'),
							'subtitle' => __('Controls the text color of title bar. (default: #555555).', 'aqua'),
							'default'  => '#555555',
							'validate' => 'color',
							'output' => array('.title-bar, .woocommerce .title-bar-shop'),
						)
					)
				);
				$this->sections[] = array(
                    'title'  => __( 'Footer Color', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array(
							'id'       => 'tb_footer_heading_color',
							'type'     => 'color',
							'title'    => __('Footer Heading Color', 'aqua'),
							'subtitle' => __('Controls the headings color of footer. (default: #ffffff).', 'aqua'),
							'default'  => '#ffffff',
							'validate' => 'color',
							'output' => array('.tb_footer h1,.tb_footer h2,.tb_footer h3,.tb_footer h4,.tb_footer h5'),
						),
						array(
							'id'       => 'tb_footer_link_color',
							'type'     => 'link_color',
							'title'    => __('Footer Link Color', 'aqua'),
							'subtitle' => __('Controls the links color of footer.', 'aqua'),
							'default'  => '#84c340',
							'validate' => 'color',
							'default'  => array(
								'regular'  => '#ffffff', // blue
								'hover'    => '#ffffff',
							),
							'output' => array('.tb_footer a'),
						),
						array(
							'id'       => 'tb_footer_text_color',
							'type'     => 'color',
							'title'    => __('Footer Text Color', 'aqua'),
							'subtitle' => __('Controls the text color of footer. (default: #aaaaaa).', 'aqua'),
							'default'  => '#aaaaaa',
							'validate' => 'color',
							'output' => array('.tb_footer'),
						)
					)
				);
				/*Typography Setting*/
				$this->sections[] = array(
                    'title'  => __( 'Typography', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-font',
                    'fields' => array(
						/*Body font*/
						array(
							'id'          => 'tb_body_font',
							'type'        => 'typography', 
							'title'       => __('Body Font Options', 'aqua'),
							'google'      => true, 
							'font-backup' => true,
							'output'      => array('body'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'aqua'),
							'default'     => array(
								'color'       => '#444', 
								'font-style'  => '600', 
								'font-family' => 'Josefin Sans', 
								'google'      => true,
								'font-size'   => '16px', 
								'line-height' => '28.8px'
							),
						),
						array(
							'id'          => 'tb_h1_font',
							'type'        => 'typography', 
							'title'       => __('H1 Font Options', 'aqua'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h1'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'aqua'),
							'default'     => array(
								'color'       => '#666', 
								'font-style'  => '400', 
								'font-family' => 'Roboto Slab', 
								'google'      => true,
								'font-size'   => '42px', 
								'line-height' => '46.2px',
								'letter-spacing' => '1.6'
							),
						),
						array(
							'id'          => 'tb_h2_font',
							'type'        => 'typography', 
							'title'       => __('H2 Font Options', 'aqua'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h2'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'aqua'),
							'default'     => array(
								'color'       => '#666', 
								'font-style'  => '400', 
								'font-family' => 'Roboto Slab', 
								'google'      => true,
								'font-size'   => '36px', 
								'line-height' => '39.6px',
								'letter-spacing' => '1.6'
							),
						),
						array(
							'id'          => 'tb_h3_font',
							'type'        => 'typography', 
							'title'       => __('H3 Font Options', 'aqua'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h3'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'aqua'),
							'default'     => array(
								'color'       => '#666', 
								'font-style'  => '400', 
								'font-family' => 'Roboto Slab', 
								'google'      => true,
								'font-size'   => '24px', 
								'line-height' => '26.4px',
								'letter-spacing' => '1.6'
							),
						),
						array(
							'id'          => 'tb_h4_font',
							'type'        => 'typography', 
							'title'       => __('H4 Font Options', 'aqua'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h4'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'aqua'),
							'default'     => array(
								'color'       => '#666', 
								'font-style'  => '400', 
								'font-family' => 'Roboto Slab', 
								'google'      => true,
								'font-size'   => '18px', 
								'line-height' => '19.8px',
								'letter-spacing' => '1.6'
							),
						),
						array(
							'id'          => 'tb_h5_font',
							'type'        => 'typography', 
							'title'       => __('H5 Font Options', 'aqua'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h5'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'aqua'),
							'default'     => array(
								'color'       => '#666', 
								'font-style'  => '400', 
								'font-family' => 'Roboto Slab', 
								'google'      => true,
								'font-size'   => '16px', 
								'line-height' => '17.6px',
								'letter-spacing' => '1.6'
							),
						),
						array(
							'id'          => 'tb_h6_font',
							'type'        => 'typography', 
							'title'       => __('H6 Font Options', 'aqua'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h6'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'aqua'),
							'default'     => array(
								'color'       => '#666', 
								'font-style'  => '400', 
								'font-family' => 'Roboto Slab', 
								'google'      => true,
								'font-size'   => '14px', 
								'line-height' => '15.4px',
								'letter-spacing' => '1.6'
							),
						),
					)
				);
				/*Title Bar Setting*/
				$this->sections[] = array(
                    'title'  => __( 'Title Bar', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-livejournal',
                    'fields' => array(
						array( 
							'id'       => 'tb_title_bar_layout',
							'type'     => 'image_select',
							'title'    => __('Title Bar Layout', 'aqua'),
							'subtitle' => __('Select title bar layout in your site.', 'aqua'),
							'options'  => array(
								'tpl1'	=> array(
										'alt'   => 'Template 1',
										'img'   => URI_PATH.'/assets/images/title_bars/title-default.jpg'
									),
								'tpl2'	=> array(
											'alt'   => 'Template 2',
											'img'   => URI_PATH.'/assets/images/title_bars/title-2.jpg'
										)
							),
							'default' => 'tpl1'
						),
						array(
							'id'       => 'tb_title_bar_bg',
							'type'     => 'background',
							'title'    => __('Background', 'aqua'),
							'subtitle' => __('background with image, color, etc.', 'aqua'),
							'default'  => array(
								'background-color' => '#e5e5e5',
							),
							'output' => array('.title-bar, .title-bar-shop'),
						),
						array(
							'id' => 'tb_title_bar_margin',
							'title' => 'Margin',
							'subtitle' => __('Please, Enter margin of title bar.', 'aqua'),
							'type' => 'spacing',
							'mode' => 'margin',
							'units' => array('px'),
							'output' => array('.title-bar, .title-bar-shop'),
							'default' => array(
								'margin-top'     => '0', 
								'margin-right'   => '0', 
								'margin-bottom'  => '50px', 
								'margin-left'    => '0',
								'units'          => 'px', 
							)
						),
						array(
							'id' => 'tb_title_bar_padding',
							'title' => 'Padding',
							'subtitle' => __('Please, Enter padding of title bar.', 'aqua'),
							'type' => 'spacing',
							'units' => array('px'),
							'output' => array('.title-bar, .title-bar-shop'),
							'default' => array(
								'padding-top'     => '40px', 
								'padding-right'   => '0', 
								'padding-bottom'  => '40px', 
								'padding-left'    => '0',
								'units'          => 'px', 
							)
						),
						array(
							'id'       => 'tb_page_breadcrumb_delimiter',
							'type'     => 'text',
							'title'    => __('Delimiter', 'aqua'),
							'subtitle' => __('Please, Enter Delimiter of page breadcrumb in title bar.', 'aqua'),
							'default'  => '/'
						)
					)
				);
				/*Post Setting*/
				$this->sections[] = array(
					'title'  => __( 'Post Setting', 'aqua' ),
					'desc'   => __( '', 'aqua' ),
					'icon'   => 'el-icon-file-edit',
					'fields' => array(
						
					)
					
				);
				$this->sections[] = array(
                    'title'  => __( 'Title Bar', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array(
                            'id'       => 'tb_post_show_page_title',
                            'type'     => 'switch',
                            'title'    => __( 'Show Page Title', 'aqua' ),
                            'subtitle' => __( 'Show page title in page title bar.', 'aqua' ),
							'default'  => false,
                        ),
						array(
                            'id'       => 'tb_post_show_page_breadcrumb',
                            'type'     => 'switch',
                            'title'    => __( 'Show Page Breadcrumb', 'aqua' ),
                            'subtitle' => __( 'Show page breadcrumb in page title bar.', 'aqua' ),
							'default'  => false,
                        )
					)
				);
				$this->sections[] = array(
                    'title'  => __( 'Archive Post', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array( 
							'id'       => 'tb_blog_layout',
							'type'     => 'image_select',
							'title'    => __('Select Layout', 'aqua'),
							'subtitle' => __('Select layout of archive post.', 'aqua'),
							'options'  => array(
								'1col'	=> array(
										'alt'   => '1col',
										'img'   => URI_PATH_ADMIN.'/assets/images/1col.png'
									),
								'2cl'	=> array(
											'alt'   => '2cl',
											'img'   => URI_PATH_ADMIN.'/assets/images/2cl.png'
										),
								'2cr'	=> array(
											'alt'   => '2cr',
											'img'   => URI_PATH_ADMIN.'/assets/images/2cr.png'
										),
								'3cm'	=> array(
											'alt'   => '3cm',
											'img'   => URI_PATH_ADMIN.'/assets/images/3cm.png'
										)
							),
							'default' => '2cr'
						),
						array(
							'id'       => 'tb_blog_column',
							'type'     => 'select',
							'title'    => __('Blog Columns', 'aqua'),
							'subtitle' => __('Select column of archive post.', 'aqua'),
							'options'  => array(
								'1' => '1 Column',
								'2' => '2 Columns',
								'3' => '3 Columns',
								'4' => '4 Columns'
							),
							'default'  => '1',
						),
						array(
							'id'       => 'tb_blog_image_default',
							'type'     => 'media',
							'url'      => true,
							'title'    => __('Image Default', 'aqua'),
							'subtitle' => __('Select an image file for image feature post.', 'aqua'),
							'default'  => array(
								'url'	=> ''
							),
						),
						array(
                            'id'       => 'tb_blog_crop_image',
                            'type'     => 'switch',
                            'title'    => __( 'Crop Image', 'aqua' ),
                            'subtitle' => __( 'Crop or not crop image of post on your archive post.', 'aqua' ),
							'default'  => false,
                        ),
						array(
							'id'       => 'tb_blog_image_width',
							'type'     => 'text',
							'title'    => __('Image Width', 'aqua'),
							'subtitle' => __('Please, Enter the width of image on your archive post. Default: 600.', 'aqua'),
							'indent'   => true,
                            'required' => array( 'tb_blog_crop_image', "=", 1 ),
							'default'  => '600'
						),
						array(
							'id'       => 'tb_blog_image_height',
							'type'     => 'text',
							'title'    => __('Image Height', 'aqua'),
							'subtitle' => __('Please, Enter the height of image on your archive post. Default: 400.', 'aqua'),
							'indent'   => true,
                            'required' => array( 'tb_blog_crop_image', "=", 1 ),
							'default'  => '400'
						),
						array(
                            'id'       => 'tb_blog_show_post_title',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Title', 'aqua' ),
                            'subtitle' => __( 'Show or not title of post on your archive post.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_blog_show_post_info',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Info', 'aqua' ),
                            'subtitle' => __( 'Show or not info of post on your archive post.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_blog_show_post_desc',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Description', 'aqua' ),
                            'subtitle' => __( 'Show or not description of post on your archive post.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_blog_post_excerpt_leng',
                            'type'     => 'text',
                            'title'    => __( 'Excerpt Leng', 'aqua' ),
                            'subtitle' => __( 'Insert the number of words you want to show in the post excerpts.', 'aqua' ),
							'default'  => '50',
                        ),
						array(
                            'id'       => 'tb_blog_post_excerpt_more',
                            'type'     => 'text',
                            'title'    => __( 'Excerpt More', 'aqua' ),
                            'subtitle' => __( 'Insert the character of words you want to show in the post excerpts.', 'aqua' ),
							'default'  => '',
                        ),
					)
				);
				$this->sections[] = array(
                    'title'  => __( 'Single Post', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array( 
							'id'       => 'tb_post_layout',
							'type'     => 'image_select',
							'title'    => __('Select Layout', 'aqua'),
							'subtitle' => __('Select layout of single blog.', 'aqua'),
							'options'  => array(
								'1col'	=> array(
										'alt'   => '1col',
										'img'   => URI_PATH_ADMIN.'/assets/images/1col.png'
									),
								'2cl'	=> array(
											'alt'   => '2cl',
											'img'   => URI_PATH_ADMIN.'/assets/images/2cl.png'
										),
								'2cr'	=> array(
											'alt'   => '2cr',
											'img'   => URI_PATH_ADMIN.'/assets/images/2cr.png'
										),
								'3cm'	=> array(
											'alt'   => '3cm',
											'img'   => URI_PATH_ADMIN.'/assets/images/3cm.png'
										)
							),
							'default' => '2cr'
						),
						array(
                            'id'       => 'tb_post_crop_image',
                            'type'     => 'switch',
                            'title'    => __( 'Crop Image', 'aqua' ),
                            'subtitle' => __( 'Crop or not crop image of post on your single blog.', 'aqua' ),
							'default'  => false,
                        ),
						array(
							'id'       => 'tb_post_image_width',
							'type'     => 'text',
							'title'    => __('Image Width', 'aqua'),
							'subtitle' => __('Please, Enter the width of image on your single blog. Default: 800.', 'aqua'),
							'indent'   => true,
                            'required' => array( 'tb_post_crop_image', "=", 1 ),
							'default'  => '800'
						),
						array(
							'id'       => 'tb_post_image_height',
							'type'     => 'text',
							'title'    => __('Image Height', 'aqua'),
							'subtitle' => __('Please, Enter the height of image on your single blog. Default: 800.', 'aqua'),
							'indent'   => true,
                            'required' => array( 'tb_post_crop_image', "=", 1 ),
							'default'  => '400'
						),
						array(
                            'id'       => 'tb_post_show_post_title',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Title', 'aqua' ),
                            'subtitle' => __( 'Show or not title of post on your single blog.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_post_show_social_share',
                            'type'     => 'switch',
                            'title'    => __( 'Show Social Share', 'aqua' ),
                            'subtitle' => __( 'Show or not social share of post on your single blog.', 'aqua' ),
							'default'  => false,
                        ),
						array(
                            'id'       => 'tb_post_show_post_info',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Info', 'aqua' ),
                            'subtitle' => __( 'Show or not info of post on your single blog.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_post_show_post_nav',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Navigation', 'aqua' ),
                            'subtitle' => __( 'Show or not post navigation on your single blog.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_post_show_post_tags',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Tags', 'aqua' ),
                            'subtitle' => __( 'Show or not post tags on your single blog.', 'aqua' ),
							'default'  => false,
                        ),
						array(
                            'id'       => 'tb_post_show_post_author',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Author', 'aqua' ),
                            'subtitle' => __( 'Show or not post author on your single blog.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_post_show_post_comment',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Comment', 'aqua' ),
                            'subtitle' => __( 'Show or not post comment on your single blog.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_post_show_post_related',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Related', 'aqua' ),
                            'subtitle' => __( 'Show or not post related on your single blog.', 'aqua' ),
							'default'  => false,
                        ),
					)
				);
				/*Page Setting*/
				$this->sections[] = array(
                    'title'  => __( 'Page Setting', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-list-alt',
                    'fields' => array(
						array(
                            'id'       => 'tb_page_show_page_title',
                            'type'     => 'switch',
                            'title'    => __( 'Show Page Title', 'aqua' ),
                            'subtitle' => __( 'Show page title in page title bar.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_page_show_page_breadcrumb',
                            'type'     => 'switch',
                            'title'    => __( 'Show Page Breadcrumb', 'aqua' ),
                            'subtitle' => __( 'Show page breadcrumb in page title bar.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_page_show_page_comment',
                            'type'     => 'switch',
                            'title'    => __( 'Show Page Comment', 'aqua' ),
                            'subtitle' => __( 'Show or not page comment on your page.', 'aqua' ),
							'default'  => true,
                        )
					)
					
				);
				/*Shop Setting*/
				if (class_exists ( 'Woocommerce' )) {
					$this->sections[] = array(
						'title'  => __( 'Shop Setting', 'aqua' ),
						'desc'   => __( '', 'aqua' ),
						'icon'   => 'el-icon-shopping-cart',
						'fields' => array(
							
						)
						
					);
					$this->sections[] = array(
						'title'  => __( 'Title Bar', 'aqua' ),
						'desc'   => __( '', 'aqua' ),
						'icon'   => '',
						'subsection' => true,
						'fields' => array(
							array(
								'id'       => 'tb_show_page_title_shop',
								'type'     => 'switch',
								'title'    => __( 'Show Page Title', 'aqua' ),
								'subtitle' => __( 'Show page title in page title bar.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_show_page_breadcrumb_shop',
								'type'     => 'switch',
								'title'    => __( 'Show Page Breadcrumb', 'aqua' ),
								'subtitle' => __( 'Show page breadcrumb in page title bar.', 'aqua' ),
								'default'  => true,
							)
						)
					);
					$this->sections[] = array(
						'title'  => __( 'Archive Products', 'aqua' ),
						'desc'   => __( '', 'aqua' ),
						'icon'   => '',
						'subsection' => true,
						'fields' => array(
							array(
								'id'       => 'tb_archive_sidebar_pos_shop',
								'type'     => 'select',
								'title'    => __('Sidebar Position', 'aqua'),
								'subtitle' => __('Select sidebar position in page archive products.', 'aqua'),
								'options'  => array(
									'tb-sidebar-left' => 'Left',
									'tb-sidebar-right' => 'Right'
								),
								'default'  => 'tb-sidebar-right',
							),
							array(
								'id'       => 'tb_archive_show_result_count',
								'type'     => 'switch',
								'title'    => __( 'Show Result Count', 'aqua' ),
								'subtitle' => __( 'Show result count in page archive products.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_archive_show_catalog_ordering',
								'type'     => 'switch',
								'title'    => __( 'Show Catalog Ordering', 'aqua' ),
								'subtitle' => __( 'Show catalog ordering in page archive products.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_archive_show_pagination_shop',
								'type'     => 'switch',
								'title'    => __( 'Show Pagination', 'aqua' ),
								'subtitle' => __( 'Show pagination in page archive products.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_archive_show_title_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Title', 'aqua' ),
								'subtitle' => __( 'Show product title in page archive products.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_archive_show_price_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Price', 'aqua' ),
								'subtitle' => __( 'Show product price in page archive products.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_archive_show_rating_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Rating', 'aqua' ),
								'subtitle' => __( 'Show product rating in page archive products.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_archive_show_sale_flash_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Sale Flash', 'aqua' ),
								'subtitle' => __( 'Show product sale flash in page archive products.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_archive_show_add_to_cart_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Add To Cart', 'aqua' ),
								'subtitle' => __( 'Show product add to cart in page archive products.', 'aqua' ),
								'default'  => true,
							),
						)
					);
					$this->sections[] = array(
						'title'  => __( 'Single Product', 'aqua' ),
						'desc'   => __( '', 'aqua' ),
						'icon'   => '',
						'subsection' => true,
						'fields' => array(
							array(
								'id'       => 'tb_single_sidebar_pos_shop',
								'type'     => 'select',
								'title'    => __('Sidebar Position', 'aqua'),
								'subtitle' => __('Select sidebar position in page single product.', 'aqua'),
								'options'  => array(
									'tb-sidebar-left' => 'Left',
									'tb-sidebar-right' => 'Right'
								),
								'default'  => 'tb-sidebar-right',
							),
							array(
								'id'       => 'tb_single_show_title_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Title', 'aqua' ),
								'subtitle' => __( 'Show product title in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_price_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Price', 'aqua' ),
								'subtitle' => __( 'Show product price in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_rating_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Rating', 'aqua' ),
								'subtitle' => __( 'Show product rating in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_sale_flash_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Sale Flash', 'aqua' ),
								'subtitle' => __( 'Show product sale flash in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_excerpt',
								'type'     => 'switch',
								'title'    => __( 'Show Product Excerpt', 'aqua' ),
								'subtitle' => __( 'Show product excerpt in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_add_to_cart_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Add To Cart', 'aqua' ),
								'subtitle' => __( 'Show product add to cart in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_meta',
								'type'     => 'switch',
								'title'    => __( 'Show Product Meta', 'aqua' ),
								'subtitle' => __( 'Show product meta in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_data_tabs',
								'type'     => 'switch',
								'title'    => __( 'Show Product Data Tabs', 'aqua' ),
								'subtitle' => __( 'Show product data tabs in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_upsell_display',
								'type'     => 'switch',
								'title'    => __( 'Show Product Upsell Display', 'aqua' ),
								'subtitle' => __( 'Show product upsell display in page single product.', 'aqua' ),
								'default'  => true,
							),
							array(
								'id'       => 'tb_single_show_related_products',
								'type'     => 'switch',
								'title'    => __( 'Show Product Related Products', 'aqua' ),
								'subtitle' => __( 'Show product related products in page single product.', 'aqua' ),
								'default'  => true,
							),
						)
					);
				}
				/*Icons*/
				$this->sections[] = array(
                    'title'  => __( 'Icons', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-fire',
                    'fields' => array(
						array(
                            'id'       => 'tb_font_awesome',
                            'type'     => 'switch',
                            'title'    => __( 'Font Awesome', 'aqua' ),
                            'subtitle' => __( 'Use font awesome in your site.', 'aqua' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'tb_font_ionicons',
                            'type'     => 'switch',
                            'title'    => __( 'Font Ionicons', 'aqua' ),
                            'subtitle' => __( 'Use font ionicons in your site.', 'aqua' ),
							'default'  => true,
                        )
					)
					
				);
				/*Custom CSS*/
				$this->sections[] = array(
                    'title'  => __( 'Custom CSS', 'aqua' ),
                    'desc'   => __( '', 'aqua' ),
                    'icon'   => 'el-icon-css',
                    'fields' => array(
						array(
							'id'       => 'custom_css_code',
							'type'     => 'ace_editor',
							'title'    => __('Custom CSS Code', 'aqua'),
							'subtitle' => __('Quickly add some CSS to your theme by adding it to this block..', 'aqua'),
							'mode'     => 'css',
							'theme'    => 'monokai',
							'default'  => ''
						)
					)
					
				);
				/*Import / Export*/
				$this->sections[] = array(
                    'title'  => __( 'Import / Export', 'aqua' ),
                    'desc'   => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'aqua' ),
                    'icon'   => 'el-icon-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'tb_import_export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => 'Save and restore your Redux options',
                            'full_width' => false,
                        ),
						array (
							'id'            => 'tb_import',
							'type'          => 'js_button',
							'title'         => 'Import sample data',
							'subtitle'      => '<a class="button-secondary" id="import" href="javascript:void(0);">Import</a><div class="import-message"></div>',
						),
                    ),
                );
				
            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'aqua' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'aqua' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'aqua' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'aqua' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'aqua' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'tb_options',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Theme Options', 'aqua' ),
                    'page_title'           => __( 'Theme Options', 'aqua' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => false,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );
				
                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => '#',
                    'title' => 'Visit us on GitHub',
                    'icon'  => 'el-icon-github'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => '#',
                    'title' => 'Like us on Facebook',
                    'icon'  => 'el-icon-facebook'
                );
                $this->args['share_icons'][] = array(
                    'url'   => '#',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el-icon-twitter'
                );
                $this->args['share_icons'][] = array(
                    'url'   => '#',
                    'title' => 'Find us on LinkedIn',
                    'icon'  => 'el-icon-linkedin'
                );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_theme_config();
    } else {
        echo "The class named Redux_Framework_theme_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;

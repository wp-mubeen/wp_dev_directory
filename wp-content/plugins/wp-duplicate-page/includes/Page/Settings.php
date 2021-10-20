<?php
namespace NjtDuplicate\Page;
use NjtDuplicate\Classes\ButtonDuplicate;

defined('ABSPATH') || exit;
/**
 * Settings Page
 */
class Settings {
  protected static $instance = null;
  
  public static function getInstance() {
    if (null == self::$instance) {
      self::$instance = new self;
    }
    
    return self::$instance;
  }

  private $pageId = null;

  private function __construct() {
    add_action('admin_menu', array($this, 'settingsMenu'));
    add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));
    add_filter('plugin_action_links_' . NJT_DUPLICATE_PLUGIN_NAME, array($this, 'addActionLinks'));
    add_action('wp_ajax_njt_duplicate_page_settings', array($this, 'saveSettings'));
    add_action('wp_ajax_nopriv_njt_duplicate_page_settings', array($this, 'saveSettings'));
    // Add button link to post, page, post type
    ButtonDuplicate::getInstance();
  }

  public function settingsMenu() {
    add_submenu_page('options-general.php', __('Duplicate Page Settings', 'njt_duplicate'), __('Duplicate Page', 'njt_duplicate'), 'manage_options', $this->getPageId(), array($this, 'settingsPage'));
  }

  public function settingsPage() {
    $viewPath = NJT_DUPLICATE_PLUGIN_PATH . 'views/pages/html-settings.php';
    include_once $viewPath;
  }
  public function addActionLinks($links) {
    $settingsLinks = array(
      '<a href="' . admin_url('options-general.php?page=' . $this->getPageId()) . '">Settings</a>',
    );
    return array_merge($settingsLinks, $links);
  }

  public function enqueueAdminScripts($screenId) {
    if ($screenId === 'settings_page_njt-duplicate-settings') {
      $scriptId = $this->getPageId();
      wp_enqueue_style($scriptId, NJT_DUPLICATE_PLUGIN_URL . '/assets/css/admin-setting.css', array(), NJT_DUPLICATE_VERSION);
      wp_enqueue_script($scriptId, NJT_DUPLICATE_PLUGIN_URL . '/assets/js/admin-setting.js', array('jquery'), NJT_DUPLICATE_VERSION, true);
      wp_localize_script( $scriptId, 'njt_duplicate_page', array( 
          'ajaxUrl' => admin_url( 'admin-ajax.php' ),
          'ajaxNonce' => wp_create_nonce('wp_rest')
        )
      );
    }
  }

  public function getPageId() {
    if (null == $this->pageId) {
      $this->pageId = NJT_DUPLICATE_DOMAIN . '-settings';
    }
    return $this->pageId;
  }

  function sanitizeTextOrArrayField($arrayOrString) {
    if( is_string($arrayOrString) ){
        $arrayOrString = sanitize_text_field($arrayOrString);
    }elseif( is_array($arrayOrString) ){
        foreach ( $arrayOrString as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = sanitizeTextOrArrayField($value);
            }
            else {
                $value = sanitize_text_field( $value );
            }
        }
    }
    return $arrayOrString;
  }

  function saveSettings() {
    if (!isset( $_POST['njtDuplicateNonce'] ) || !wp_verify_nonce( $_POST['njtDuplicateNonce'], 'wp_rest' ))
      return;

    $roles = isset( $_POST['njtDuplicateRoles'] ) ? $this->sanitizeTextOrArrayField((array) $_POST['njtDuplicateRoles']) : array();
    $postTypes = isset( $_POST['njtDuplicatePostTypes'] ) ? $this->sanitizeTextOrArrayField((array) $_POST['njtDuplicatePostTypes']) : array();
    $textLink = isset( $_POST['njtDuplicateTextLink'] ) ? $this->sanitizeTextOrArrayField($_POST['njtDuplicateTextLink']) : '';
    
    update_option( 'njt_duplicate_roles', $roles );
    update_option( 'njt_duplicate_post_types', $postTypes );
    update_option( 'njt_duplicate_text_link', $textLink );
    global $wp_roles;
    $roles = $wp_roles->get_names();
    $duplicateUserRoles = get_option('njt_duplicate_roles');

    if ( $duplicateUserRoles == false || $duplicateUserRoles == "" ) {
        $duplicateUserRoles = array();
    }

    foreach ($roles as $name => $displayName){
        $role = get_role($name);

        /* If the role doesn't have the capability and it was selected, add it. */
        if ( !$role->has_cap( 'njt_duplicate_page' )  && in_array($name, $duplicateUserRoles) )
            $role->add_cap( 'njt_duplicate_page' );

        /* If the role has the capability and it wasn't selected, remove it. */
        elseif ( $role->has_cap( 'njt_duplicate_page' ) && !in_array($name, $duplicateUserRoles) )
        $role->remove_cap( 'njt_duplicate_page' );
    }
    // Optionally (if needed).
    wp_reset_query();
    wp_reset_postdata();
  
    // To avoid error 500 (don't forget this)
    wp_die();
  }
}

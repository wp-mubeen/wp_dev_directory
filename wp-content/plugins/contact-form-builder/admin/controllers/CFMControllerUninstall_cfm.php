<?php

class CFMControllerUninstall_cfm {

  public function __construct() {
    global $fmc_options;
    if (!class_exists("DoradoWebConfig")) {
      include_once(WD_CFM_DIR . "/wd/config.php");
    }
    $config = new DoradoWebConfig();
    $config->set_options($fmc_options);
    $deactivate_reasons = new DoradoWebDeactivate($config);
    $deactivate_reasons->submit_and_deactivate();
  }

  public function execute() {
    $task = ((isset($_POST['task'])) ? esc_html(stripslashes($_POST['task'])) : '');
    if (method_exists($this, $task)) {
      check_admin_referer('nonce_cfm', 'nonce_cfm');
      $this->$task();
    }
    else {
      $this->display();
    }
  }

  public function display() {
    require_once WD_CFM_DIR . "/admin/models/CFMModelUninstall_cfm.php";
    $model = new CFMModelUninstall_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewUninstall_cfm.php";
    $view = new CFMViewUninstall_cfm($model);
    $view->display();
  }

  public function uninstall() {
    require_once WD_CFM_DIR . "/admin/models/CFMModelUninstall_cfm.php";
    $model = new CFMModelUninstall_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewUninstall_cfm.php";
    $view = new CFMViewUninstall_cfm($model);
    $view->uninstall();
  }
}
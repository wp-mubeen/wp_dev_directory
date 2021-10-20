<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * Set the ajax action and call for wordpress
 */
class SQ_Classes_ActionController extends SQ_Classes_FrontController {

    /** @var array with all form and ajax actions */
    var $actions = array();

    /**
     * The hookAjax is loaded as custom hook in hookController class
     *
     * @return void
     */
    public function hookInit() {
        /* Only if ajax */
        if (SQ_Classes_Helpers_Tools::isAjax()) {
            $this->getActions();
        }
    }

    /**
     * The hookSubmit is loaded when action si posted
     *
     * @return void
     */
    public function hookMenu() {
        /* Only if post */
        if (!SQ_Classes_Helpers_Tools::isAjax()) {
            $this->getActions();
        }
    }

    /**
     * The hookHead is loaded as admin hook in hookController class for script load
     * Is needed for security check as nonce
     *
     * @return void
     */
    public function hookHead() {
        echo '<script>var sqQuery = {"adminurl": "' . admin_url() . '","ajaxurl": "' . admin_url('admin-ajax.php') . '","adminposturl": "' . admin_url('post.php') . '","adminlisturl": "' . admin_url('edit.php') . '","nonce": "' . wp_create_nonce(_SQ_NONCE_ID_) . '"}</script>';
    }

    public function hookFronthead() {
        if (SQ_Classes_Helpers_Tools::isFrontAdmin()) {
            echo '<script>var sqQuery = {"adminurl": "' . admin_url() . '","ajaxurl": "' . admin_url('admin-ajax.php') . '","nonce": "' . wp_create_nonce(_SQ_NONCE_ID_) . '"}</script>';
        }
    }

    public function getActionsList(){
        return array(
            array(
                'name' => 'SQ_Core_Blocklogin',
                'description' => 'Connection Block',
                'actions' => array(
                    'action' => array(
                        'sq_login',
                        'sq_register',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Core_BlockConnect',
                'description' => 'Connection Block to API',
                'actions' => array(
                    'action' => array(
                        'sq_cloud_connect',
                        'sq_cloud_disconnect',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Account',
                'description' => 'Account Class',
                'actions' => array(
                    'action' => array(
                        'sq_ajax_account_getaccount',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_FocusPages',
                'description' => 'Focus Pages Controller',
                'actions' => array(
                    'action' => array(
                        'sq_focuspages_getpage',
                        'sq_focuspages_addnew',
                        'sq_focuspages_update',
                        'sq_focuspages_delete',
                        'sq_focuspages_inspecturl',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_PostsList',
                'description' => 'Posts List Page',
                'actions' => array(
                    'action' => array(
                        'inline-save',
                        'sq_ajax_postslist',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Post',
                'description' => 'Post Page',
                'actions' => array(
                    'action' => array(
                        'sq_create_demo',
                        'sq_ajax_save_ogimage',
                        'sq_ajax_get_post',
                        'sq_ajax_save_post',
                        'sq_ajax_type_click',
                        'sq_ajax_search_blog',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Snippet',
                'description' => 'Snippet Page',
                'actions' => array(
                    'action' => array(
                        'sq_saveseo',
                        'sq_getsnippet',
                        'sq_previewsnippet',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Patterns',
                'description' => 'Patterns Class',
                'actions' => array(
                    'action' => array(
                        'sq_getpatterns',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_BulkSeo',
                'actions' => array(
                    'action' => array(
                        'sq_ajax_assistant_bulkseo',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_SeoSettings',
                'actions' => array(
                    'action' => array(
                        'sq_seosettings_automation',
                        'sq_seosettings_bulkseo',
                        'sq_seosettings_jsonld',
                        'sq_seosettings_metas',
                        'sq_seosettings_links',
                        'sq_seosettings_social',
                        'sq_seosettings_tracking',
                        'sq_seosettings_webmaster',
                        'sq_seosettings_sitemap',
                        'sq_seosettings_robots',
                        'sq_seosettings_favicon',
                        'sq_seosettings_backupsettings',
                        'sq_seosettings_backupseo',
                        'sq_seosettings_restoresettings',
                        'sq_seosettings_restoreseo',
                        'sq_seosettings_importsettings',
                        'sq_seosettings_importseo',
                        'sq_seosettings_importall',
                        'sq_seosettings_ga_revoke',
                        'sq_seosettings_gsc_revoke',
                        'sq_seosettings_gsc_check',
                        'sq_seosettings_ga_check',
                        'sq_seosettings_clear_cache',
                        'sq_seosettings_ga_save',
                        'sq_reinstall',
                        'sq_rollback',
                        'sq_alerts_close',
                        'sq_ajax_seosettings_save',
                        'sq_ajax_automation_addpostype',
                        'sq_ajax_automation_deletepostype',
                        'sq_ajax_sla_sticky',
                        'sq_ajax_gsc_code',
                        'sq_ajax_ga_code',
                        'sq_ajax_connection_check',
                        'sq_seosettings_advanced',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Research',
                'actions' => array(
                    'action' => array(
                        'sq_briefcase_addlabel',
                        'sq_briefcase_editlabel',
                        'sq_briefcase_keywordlabel',
                        'sq_briefcase_article',
                        'sq_briefcase_doresearch',
                        'sq_briefcase_addkeyword',
                        'sq_briefcase_deletekeyword',
                        'sq_briefcase_deletelabel',
                        'sq_briefcase_deletefound',
                        'sq_briefcase_savemain',
                        'sq_briefcase_backup',
                        'sq_briefcase_restore',
                        'sq_ajax_briefcase_doserp',
                        'sq_ajax_research_others',
                        'sq_ajax_research_process',
                        'sq_ajax_research_history',
                        'sq_ajax_briefcase_bulk_delete',
                        'sq_ajax_briefcase_bulk_label',
                        'sq_ajax_briefcase_bulk_doserp',
                        'sq_ajax_labels_bulk_delete',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Audits',
                'actions' => array(
                    'action' => array(
                        'sq_audits_settings',
                        'sq_auditpages_getaudit',
                        'sq_audits_getpage',
                        'sq_audits_addnew',
                        'sq_audits_page_update',
                        'sq_audits_update',
                        'sq_audits_delete',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Ranking',
                'actions' => array(
                    'action' => array(
                        'sq_ranking_settings',
                        'sq_serp_refresh_post',
                        'sq_serp_delete_keyword',
                        'sq_ajax_rank_bulk_delete',
                        'sq_ajax_rank_bulk_refresh',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Assistant',
                'actions' => array(
                    'action' => array(
                        'sq_settings_assistant',
                        'sq_ajax_assistant',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_CheckSeo',
                'actions' => array(
                    'action' => array(
                        'sq_checkseo',
                        'sq_fixsettings',
                        'sq_donetask',
                        'sq_resetignored',
                        'sq_moretasks',
                        'sq_ajax_checkseo',
                        'sq_ajax_getgoals',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Onboarding',
                'actions' => array(
                    'action' => array(
                        'sq_onboarding_commitment',
                        'sq_onboading_checksite',
                        'sq_onboarding_settings',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Core_BlockJorney',
                'actions' => array(
                    'action' => array(
                        'sq_journey_close',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Core_BlockSupport',
                'actions' => array(
                    'action' => array(
                        'sq_feedback',
                        'sq_uninstall_feedback',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Core_BlockSearch',
                'actions' => array(
                    'action' => array(
                        'sq_ajax_search',
                    ),
                ),
                'active' => '1',
            ),
            array(
                'name' => 'SQ_Controllers_Dashboard',
                'actions' => array(
                    'action' => array(
                        'sq_ajaxcheckseo',
                    ),
                ),
                'active' => '1',
            ),
        );
    }

    /**
     * Get all actions from config.json in core directory and add them in the WP
     *
     */
    public function getActions() {

        if (!is_admin()) {
            return;
        }

        $this->actions = array();
        $cur_action = SQ_Classes_Helpers_Tools::getValue('action', false);
        $http_referer = SQ_Classes_Helpers_Tools::getValue('_wp_http_referer', false);
        $sq_nonce = SQ_Classes_Helpers_Tools::getValue('sq_nonce', false);


        //Let only the logged users to access the actions
        if ($cur_action <> '' && $sq_nonce <> '') {

            //load the actions list for each class
            $actions = $this->getActionsList();

            if(!empty($actions)) {
                foreach ($actions as $block) {
                    if (isset($block['active']) && $block['active'] == 1) {
                        /* if there is a single action */
                        if (isset($block['actions']['action']))
                            /* if there are more actions for the current block */
                            if (!is_array($block['actions']['action'])) {
                                /* add the action in the actions array */
                                if ($block['actions']['action'] == $cur_action) {
                                    $this->actions[] = array('class' => $block['name']);
                                }
                            } else {
                                /* if there are more actions for the current block */
                                foreach ($block['actions']['action'] as $action) {
                                    /* add the actions in the actions array */
                                    if ($action == $cur_action) {
                                        $this->actions[] = array('class' => $block['name']);
                                    }
                                }
                            }
                    }
                }
            }

            //If there is an action found in the config.js file
            if (!empty($this->actions)) {
                /* add the actions in WP */
                foreach ($this->actions as $actions) {
                    if (SQ_Classes_Helpers_Tools::isAjax() && !$http_referer) {
                        check_ajax_referer(_SQ_NONCE_ID_, 'sq_nonce');
                        add_action('wp_ajax_' . $cur_action, array(SQ_Classes_ObjController::getClass($actions['class']), 'action'));
                    } else {
                        check_admin_referer($cur_action, 'sq_nonce');
                        SQ_Classes_ObjController::getClass($actions['class'])->action();
                    }
                }
            }
        }

        //For Post List
        if(SQ_Classes_Helpers_Tools::isAjax() && $cur_action <> '' && $cur_action == 'inline-save'){
            check_ajax_referer('inlineeditnonce', '_inline_edit');
            SQ_Classes_ObjController::getClass('SQ_Controllers_PostsList')->action();

        }


    }

}

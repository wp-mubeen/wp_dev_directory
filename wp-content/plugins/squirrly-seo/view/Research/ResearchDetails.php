<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
if (!empty($view->kr)) {
    //For teh saved country
    if (isset($_COOKIE['sq_country'])) {
        $view->country = sanitize_text_field($_COOKIE['sq_country']);
    }

    foreach ($view->kr as $nr => $row) {
        if (!isset($row->keyword)) continue;

        $in_briefcase = false;
        if (!empty($view->keywords)) {
            foreach ($view->keywords as $krow) {
                if (trim(strtolower($krow->keyword)) == trim(strtolower($row->keyword))) {
                    $in_briefcase = true;
                    break;
                }
            }
        }
        ?>
        <tr class="<?php echo($in_briefcase ? 'bg-briefcase' : '') ?> <?php echo($row->initial ? 'bg-selected' : '') ?>">
            <td style="width: 40%;"><?php echo(isset($row->keyword) ? SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) : '') ?></td>
            <td style="width: 4%;"><?php echo(isset($view->country) ? esc_html($view->country) : 'com') ?></td>
            <td style="width: 23%; color: <?php echo esc_attr($row->stats->sc->color) ?>"><?php echo(isset($row->stats->sc->text) ? '<span data-value="' . esc_attr($row->stats->sc->value) . '">' . $view->getReasearchStatsText('sc',$row->stats->sc->value) . '</span>' : '') ?></td>
            <td style="width: 16%"><?php echo(isset($row->stats->sv) ? '<span data-value="' . (int)$row->stats->sv->absolute . '">' . (is_numeric($row->stats->sv->absolute) ? number_format($row->stats->sv->absolute, 0, '.', ',') . '</span>' : esc_html($row->stats->sv->absolute)) : '') ?></td>
            <td style="width: 17%;"><?php echo(isset($row->stats->tw) ? '<span data-value="' . esc_attr($row->stats->tw->value) . '">' . $view->getReasearchStatsText('tw',$row->stats->tw->value) . '</span>' : '') ?></td>

            <td class="px-0" style="width: 24px;">
                <div class="sq_sm_menu">
                    <div class="sm_icon_button sm_icon_options">
                        <i class="fa fa-ellipsis-v"></i>
                    </div>
                    <div class="sq_sm_dropdown">
                        <ul class="p-2 m-0 text-left">
                            <?php
                            $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('/post-new.php?keyword=' .  SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url'));
                            if ($view->post_id) {
                                $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$view->post_id . '&action=edit&keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url'));
                            }
                            ?>
                            <li class="sq_research_selectit border-bottom m-0 p-1 py-2 noloading">
                                <a href="<?php echo (string)$edit_link  ?>" target="_blank" class="sq-nav-link">
                                    <i class="sq_icons_small sq_sla_icon"></i>
                                    <?php echo esc_html__("Optimize for this", _SQ_PLUGIN_NAME_) ?>
                                </a>
                            </li>
                            <?php if ($in_briefcase) { ?>
                                <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                    <i class="sq_icons_small sq_briefcase_icon"></i>
                                    <?php echo esc_html__("Already in briefcase", _SQ_PLUGIN_NAME_); ?>
                                </li>
                            <?php } else { ?>
                                <li class="sq_research_add_briefcase m-0 p-1 py-2" data-keyword="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?>">
                                    <i class="sq_icons_small sq_briefcase_icon"></i>
                                    <?php echo esc_html__("Add to briefcase", _SQ_PLUGIN_NAME_); ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    <?php }
} ?>
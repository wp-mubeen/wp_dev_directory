<?php
function tb_social_render($atts) {
    $title_social = $align = $underline =$animation = $el_class = '';
    extract(shortcode_atts(array(
        'title_social1' => '',
        'icon_social1' => '',
        'link_social1' => '',
        'title_social2' => '',
        'icon_social2' => '',
        'link_social2' => '',
        'title_social3' => '',
        'icon_social3' => '',
        'link_social3' => '',
        'title_social4' => '',
        'icon_social4' => '',
        'link_social4' => '',
        'title_social5' => '',
        'icon_social5' => '',
        'link_social5' => '',
        'show_tooltip' => 0,
        'tooltip_pos' => '',
        'animation' => '',
        'el_class' => ''
    ), $atts));

    $class = array();
    $class[] = 'tb-social';                
    $class[] = getCSSAnimation($animation);
    $class[] = $el_class;
    ob_start();
    ?>
        <ul class="<?php echo esc_attr(implode(' ', $class)); ?>">
            <?php if($icon_social1): ?>
                <li>
                    <a target="_blank" <?php echo tb_filtercontent($show_tooltip ? 'data-uk-tooltip="{pos:\'' . $tooltip_pos . '\'}"' : ''); ?> title="<?php echo esc_attr($title_social1); ?>" href="<?php echo esc_url($link_social1); ?>">
                        <i class="<?php echo tb_filtercontent($icon_social1); ?>"></i>
                    </a>
                </li>
            <?php endif; ?>
            <?php if($icon_social2): ?>
                <li>
                    <a target="_blank" <?php echo tb_filtercontent($show_tooltip ? 'data-uk-tooltip="{pos:\'' . $tooltip_pos . '\'}"' : ''); ?> title="<?php echo esc_attr($title_social2); ?>" href="<?php echo esc_url($link_social2); ?>">
                        <i class="<?php echo tb_filtercontent($icon_social2); ?>"></i>
                    </a>
                </li>
            <?php endif; ?>
            <?php if($icon_social3): ?>
                <li>
                    <a target="_blank" <?php echo tb_filtercontent($show_tooltip ? 'data-uk-tooltip="{pos:\'' . $tooltip_pos . '\'}"' : ''); ?> title="<?php echo esc_attr($title_social3); ?>" href="<?php echo esc_url($link_social3); ?>">
                        <i class="<?php echo tb_filtercontent($icon_social3); ?>"></i>
                    </a>
                </li>
            <?php endif; ?>
            <?php if($icon_social4): ?>
                <li>
                    <a target="_blank" <?php echo tb_filtercontent($show_tooltip ? 'data-uk-tooltip="{pos:\'' . $tooltip_pos . '\'}"' : ''); ?> title="<?php echo esc_attr($title_social4); ?>" href="<?php echo esc_url($link_social4); ?>">
                        <i class="<?php echo tb_filtercontent($icon_social4); ?>"></i>
                    </a>
                </li>
            <?php endif; ?>
            <?php if($icon_social5): ?>
                <li>
                    <a target="_blank" <?php echo tb_filtercontent($show_tooltip ? 'data-uk-tooltip="{pos:\'' . $tooltip_pos . '\'}"' : ''); ?> title="<?php echo esc_attr($title_social5); ?>" href="<?php echo esc_url($link_social5); ?>">
                        <i class="<?php echo tb_filtercontent($icon_social5); ?>"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('social', 'tb_social_render');}

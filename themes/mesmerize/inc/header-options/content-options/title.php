<?php


function mesmerize_front_page_header_title_options($section, $prefix, $priority)
{
    $companion = apply_filters('mesmerize_is_companion_installed', false);


    mesmerize_add_kirki_field(array(
        'type'     => 'checkbox',
        'settings' => 'header_content_show_title',
        'label'    => esc_html__('Show title', 'mesmerize'),
        'section'  => $section,
        'default'  => true,
        'priority' => $priority,
    ));

    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => 'header_content_title_group',
        'label'           => esc_html__('Options', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority,
        "choices"         => array(
            "header_title",
        ),
        'active_callback' => array(
            array(
                'setting'  => 'header_content_show_title',
                'operator' => '==',
                'value'    => true,
            ),
        ),
        'in_row_with'     => array('header_content_show_title'),
    ));

    if ( ! $companion) {
    mesmerize_add_kirki_field(array(
            'type'              => 'textarea',
        'settings'          => 'header_title',
            'label'             => esc_html__('Title', 'mesmerize'),
        'section'           => $section,
        'default'           => "",
        'sanitize_callback' => 'mesmerize_wp_kses_post',
        'priority'          => $priority,

        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => ".header-homepage .hero-title",
                'function' => 'html',
            ),
        ),
    ));
}
}

add_action("mesmerize_print_header_content", function() {
    mesmerize_print_header_title();
}, 1);




function mesmerize_print_header_title()
{
    $title = get_theme_mod('header_title', "");
    $show  = get_theme_mod('header_content_show_title', true);


    if (mesmerize_can_show_demo_content()) {
        if ($title == "") {
            $title = esc_html__('You can set this title from the customizer.', 'mesmerize');
        }
    }

    $title = mesmerize_wp_kses_post($title);
    $title = apply_filters("mesmerize_header_title", $title);

    if ($show) {
        printf('<h1 class="hero-title">%1$s</h1>', $title);
    }
}

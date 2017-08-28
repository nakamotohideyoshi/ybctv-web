<?php
/*
*	---------------------------------------------------------------------
*	This file create and contains the portfolio post_type meta elements
*	---------------------------------------------------------------------
*/
add_action('init', 'create_event');
function create_event()
{
    $labels = array(
        'name'               => _x('Event', 'Event General Name', TEXT_DOMAIN),
        'singular_name'      => _x('Event Item', 'Event Singular Name', TEXT_DOMAIN),
        'add_new'            => _x('Add New', 'Add New Event Name', TEXT_DOMAIN),
        'add_new_item'       => __('Add New Event', TEXT_DOMAIN),
        'edit_item'          => __('Edit Event', TEXT_DOMAIN),
        'new_item'           => __('New Event', TEXT_DOMAIN),
        'view_item'          => __('View Event', TEXT_DOMAIN),
        'search_items'       => __('Search Event', TEXT_DOMAIN),
        'not_found'          => __('Nothing found', TEXT_DOMAIN),
        'not_found_in_trash' => __('Nothing found in Trash', TEXT_DOMAIN),
        'parent_item_colon'  => ''
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'query_var'          => true,
        //'menu_icon' => THEME_PATH . '/plazart/assets/images/event-icon.png',
        'rewrite'            => true,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor','author', 'thumbnail', 'custom-fields'), //'editor', 'excerpt', 'comments',
        'rewrite'            => array('slug' => 'event', 'with_front' => false ),
        //'has_archive'        => 'event'
    );
    register_post_type('event', $args);
}

// filter for event first page
add_filter("manage_edit-event_columns", "show_event_column");
function show_event_column($columns)
{
    $columns = array(
        "cb"                 => "<input type=\"checkbox\" />",
        "title"              => "Title",
        "author"             => "Author",
        "date"               => "date" );

    return $columns;
}

add_action("manage_event_custom_column", "event_custom_columns");


add_action('init', 'create_magazines');
function create_magazines()
{
    $labels = array(
        'name'               => _x('Magazines', 'Magazines General Name', TEXT_DOMAIN),
        'singular_name'      => _x('Magazines Item', 'Magazines Singular Name', TEXT_DOMAIN),
        'add_new'            => _x('Add New', 'Add New Magazines Name', TEXT_DOMAIN),
        'add_new_item'       => __('Add New Magazines', TEXT_DOMAIN),
        'edit_item'          => __('Edit Magazines', TEXT_DOMAIN),
        'new_item'           => __('New Magazines', TEXT_DOMAIN),
        'view_item'          => __('View Magazines', TEXT_DOMAIN),
        'search_items'       => __('Search Magazines', TEXT_DOMAIN),
        'not_found'          => __('Nothing found', TEXT_DOMAIN),
        'not_found_in_trash' => __('Nothing found in Trash', TEXT_DOMAIN),
        'parent_item_colon'  => ''
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'query_var'          => true,
        //'menu_icon' => THEME_PATH . '/plazart/assets/images/magazines-icon.png',
        'rewrite'            => true,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor','author', 'thumbnail', 'custom-fields'), //'editor', 'excerpt', 'comments',
        'rewrite'            => array('slug' => 'magazines', 'with_front' => false ),
        //'has_archive'        => 'magazines'
    );
    register_post_type('magazines', $args);
}

// filter for magazines first page
add_filter("manage_edit-magazines_columns", "show_magazines_column");
function show_magazines_column($columns)
{
    $columns = array(
        "cb"                 => "<input type=\"checkbox\" />",
        "title"              => "Title",
        "author"             => "Author",
        "date"               => "date" );

    return $columns;
}

add_action("manage_magazines_custom_column", "magazines_custom_columns");


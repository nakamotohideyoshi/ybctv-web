<?php

add_action('admin_menu', 'last_word_email_builder_editor_add_page');
 
function last_word_email_builder_editor_add_page() {
    add_submenu_page(
        'tools.php',
        'Email Builder Editor',
        'Email Builder Editor',
        'edit_posts',
        'last-word-email-builder-editor',
        'last_word_email_builder_editor_callback' 
    );
}
 
function last_word_email_builder_editor_callback() {
    echo '<div class="wrap">';
    echo '<h2>Email Builder Editor</h2>';
    include "tpl/email-builder-editor-tpl.php";
    echo '</div>';
}
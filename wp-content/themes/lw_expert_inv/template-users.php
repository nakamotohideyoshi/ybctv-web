<?php
/**
 * Template Name: Users list
 */
?>
<?php get_header();?>
<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <div class="content-page">
            <div class="container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php

                    $users = get_users();

                    echo '<h3>Users:</h3><ul>';

                    $i = 1;

                    foreach ( $users  as $user ) {
                        $contactId = get_user_meta($user->ID, '_contactId', true);

                        if ($contactId == '') {
                            echo '<li>' . $i . ' - ' . $user->ID . ' - ' . $user->user_login . ' - ' . $contactId . '</li>';  
                            $i++; 
                        }
    
                    }

                    echo '</ul>';

                ?>
                </div> 
            </div>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->
<?php get_footer();?>
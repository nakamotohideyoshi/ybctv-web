<?php
/**
 * Template Name: Taxonomy list
 */
?>
<?php get_header();?>
<section id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <div class="content-page">
            <div class="container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php
                    $operator = 'and';
                    $output = 'objects';
                    $args = Array('public' => true);
                    $taxonomies = get_taxonomies( $args, $output, $operator);
                    $exclude = array( 'post_tag' );

                    echo '<h3>Taxonomies:</h3><ul>';

                    if ( $taxonomies ) {

                        foreach ( $taxonomies  as $taxonomy ) {

                            if( in_array( $taxonomy->name, $exclude ) ) {
                                continue;
                            }

                            echo '<li>' . $taxonomy->label . '</li>';   

                            }

                        }



                    echo '</ul>';

                    if ( $taxonomies ) {

                        foreach ( $taxonomies  as $taxonomy ) {

                            if( in_array( $taxonomy->name, $exclude ) ) {
                                continue;
                            }

                            $terms = get_terms( array(
                                'taxonomy' => $taxonomy->name,
                                'hide_empty' => 0,
                            ) );

                            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

                                echo '<h3>' . $taxonomy->label . '</h3>';   

                                $term_list = '<ul class="term-list">';

                                foreach ( $terms as $term ) {
                                    $term_list .= '<li><a href="' . esc_url( get_term_link( $term ) ) . '" >' . $term->name . '</a></li>';          
                                }

                                $term_list .= '</ul>';

                                echo $term_list;
                            }

                        }

                    }
                ?>
                </div> 
            </div>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->
<?php get_footer();?>
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
                    $user_ids = array(
                        3,
                        13,
                        15,
                        17,
                        19,
                        20,
                        22,
                        23,
                        24,
                        28,
                        31,
                        36,
                        37,
                        39,
                        40,
                        41,
                        42,
                        44,
                        45,
                        47,
                        50,
                        51,
                        52,
                        53,
                        54,
                        57,
                        58,
                        72,
                        73,
                        74,
                        80,
                        84,
                        91,
                        92,
                        93,
                        98,
                        99,
                        100,
                        101,
                        103,
                        104,
                        106,
                        108,
                        109,
                        110,
                        111,
                        112,
                        116,
                        117,
                        118,
                        119,
                        120,
                        122,
                        125,
                        126,
                        127,
                        128,
                        129,
                        130,
                        131,
                        132,
                        135,
                        136,
                        137,
                        138,
                        139,
                        141,
                        142,
                        143,
                        144,
                        145,
                        146,
                        156,
                        169,
                        199,
                        201,
                        256,
                        258,
                        259,
                        282,
                        288,
                        289,
                        291,
                        298,
                        303,
                        304,
                        305,
                        306,
                        307,
                        308,
                        309,
                        310,
                        311,
                        315,
                        383,
                        34121,
                        34154,
                        34160,
                        34162,
                        34164,
                        34180,
                        34182,
                        34183,
                        34186,
                        34196,
                        34203,
                        34205,
                        34207,
                        34209,
                        34242,
                        34250,
                        34262,
                        34270,
                        34279,
                        34319,
                        34346,
                        34362,
                        34448,
                        34454,
                        34464,
                        34483,
                        34489,
                        34494,
                        34508,
                        34522,
                        34558,
                        34559,
                        34560,
                        34829,
                        34902,
                        34980,
                        36828,
                        36887,
                        37084,
                        37386,
                        37471,
                        37495,
                        37658,
                        37677,
                        38010,
                        38075,
                        38105
                    );

                    //var_dump($user_ids);
                    
                    $uargs = array( 'include' => $user_ids, 'fields' => 'all', 'blog_id' => 5 );

                    $users = get_users($uargs);
                    echo '<table>';
                        echo '<tr>';
                            echo '<th>User Id</th>';
                            echo '<th>First Name</th>';
                            echo '<th>Last Name</th>';
                            echo '<th>Country</th>';
                            echo '<th>Phone</th>';
                            echo '<th>Company</th>';

                            echo '<th>PA News</th>';
                            echo '<th>PA Mag dig/prnt</th>';
                            echo '<th>PA Mag dig</th>';
                            echo '<th>PA Mag free dig/prnt</th>';
                            echo '<th>PA Mag free dig</th>';
                            echo '<th>PA Mag ire dig/prnt</th>';
                            echo '<th>PA Mag ire dig</th>';
                            echo '<th>IA News</th>';
                            echo '<th>IA Mag dig</th>';
                            echo '<th>FSA News</th>';
                            echo '<th>EI News</th>';
                            echo '<th>EI Mag dig/prnt</th>';
                            echo '<th>EI Mag dig</th>';
                            echo '<th>EI Mark. Intl</th>';
                        echo '</tr>';
                        foreach ( $users as $user ) {
                            $userid = $user->ID;
                            $userfirst = $user->first_name;
                            $userlast = $user->last_name;
                            $country = get_user_meta($userid, '_country', true);
                            $directline = get_user_meta($userid, '_direct_line', true);
                            $company = get_user_meta($userid, 'lw_company_name', true);

                            $panews = get_user_meta($userid, 'lw_product_pa_news', true);
                            $pamag_dp = get_user_meta($userid, 'lw_product_pa_magazine_print_digital', true);
                            $pamag_dig = get_user_meta($userid, 'lw_product_pa_magazine_digital', true);
                            $pamag_free_dp = get_user_meta($userid, 'lw_product_pa_magazine_free_print_digital', true);
                            $pamag_free_dig = get_user_meta($userid, 'lw_product_pa_magazine_free_digital', true);
                            $pamag_ire_dp = get_user_meta($userid, 'lw_product_pa_magazine_ire_print_digital', true);
                            $pamag_ire_dig = get_user_meta($userid, 'lw_product_pa_magazine_ire_digital', true);
                            $ianews = get_user_meta($userid, 'lw_product_ia_news', true);
                            $iamag_dig = get_user_meta($userid, 'lw_product_ia_magazine_digital', true);
                            $fsanews = get_user_meta($userid, 'lw_product_fsa_news', true);
                            $einews = get_user_meta($userid, 'lw_product_ei_news', true);
                            $eimag_dp = get_user_meta($userid, 'lw_product_ei_magazine_print_digital', true);
                            $eimag_dig = get_user_meta($userid, 'lw_product_ei_magazine_digital', true);
                            $eimi = get_user_meta($userid, 'lw_product_ei_market_intelligence', true);

                            echo '<tr>';
                                echo '<td>'.$userid.'</td>';
                                echo '<td>'.$userfirst.'</td>';
                                echo '<td>'.$userlast.'</td>';
                                echo '<td>'.$country.'</td>';
                                echo '<td>'.$directline.'</td>';
                                echo '<td>'.$company.'</td>';

                                echo '<td>'.$panews.'</td>';
                                echo '<td>'.$pamag_dp.'</td>';
                                echo '<td>'.$pamag_dig.'</td>';
                                echo '<td>'.$pamag_free_dp.'</td>';
                                echo '<td>'.$pamag_free_dig.'</td>';
                                echo '<td>'.$pamag_ire_dp.'</td>';
                                echo '<td>'.$pamag_ire_dig.'</td>';
                                echo '<td>'.$ianews.'</td>';
                                echo '<td>'.$iamag_dig.'</td>';
                                echo '<td>'.$fsanews.'</td>';
                                echo '<td>'.$einews.'</td>';
                                echo '<td>'.$eimag_dp.'</td>';
                                echo '<td>'.$eimag_dig.'</td>';
                                echo '<td>'.$eimi.'</td>';
                            echo '</tr>';
                        }
                    echo '</table>';
                ?>
                </div> 
            </div>
        </div>

    </div><!-- #content -->
</section><!-- #primary -->
<?php get_footer();?>
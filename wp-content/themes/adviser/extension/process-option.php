<?php

    /*
     * Method process option
     * # option 1: config font
     * # option 2: process config theme
    */

    if(!is_admin()):

        add_action('wp_head','portoflio_config_theme');

        function portoflio_config_theme(){

            /*===========================
             * method body font
            ============================*/
            $TZFontType     =   ot_get_option('TZFontType','TzFontSquirrel');       // type font google or defaul
            $TzFontFamiUrl  =   ot_get_option('TzFontFami');                        //  url google font
            $TZUrlFamily    =   ot_get_option('TzFontFaminy');                      //  font family google
            $TzFontSqui     =   ot_get_option('TzFontSquirrel','OpenSansLight');     //  font squireel
            $bodySelecter   =   ot_get_option('TzBodySelecter');                     //  body selecter
            $TzFontDefault  =   ot_get_option('TzFontDefault','Arial');             //  font standard
            $TzbodyFontColor    = ot_get_option('TzBodyColor');                      //*color*
            switch($TZFontType){
                case'Tzgoogle':
                    $Tzfont = $TZUrlFamily;
                    break;
                case'TzFontDefault':
                    $Tzfont = "'".$TzFontDefault."'";
                    break;
                default:
                    $Tzfont = "'".$TzFontSqui."'";
                    break;
            }

            // end method

            /*========================
            * Method header font
            ==========================*/
            $TZFHeadType     =   ot_get_option('TZFontTypeHead','TzFontDefault');                // type font google or defaul
            $TzFHeadUrl      =   ot_get_option('TzFontHeadGoodurl');                             //  url google font
            $TZFheadFamily   =   ot_get_option('TzFontFaminyHead');                              //  font family google
            $TzFHeadSqui     =   ot_get_option('TzFontHeadSquirrel','LaconicBold');               //  font squireel
            $FHeadSelecter   =   ot_get_option('TzHeadSelecter');                                //  body selecter
            $TzFHeadDefault  =   ot_get_option('TzFontHeadDefault','Arial');                     //  font standard
            $TzHeaderFontColor   = ot_get_option('TzHeaderFontColor');                           // color

            switch($TZFHeadType){
                case'Tzgoogle':
                    $TzHeadfont = $TZFheadFamily;
                    break;
                case'TzFontDefault':
                    $TzHeadfont = "'".$TzFHeadDefault."'";
                    break;
                default:
                    $TzHeadfont = "'".$TzFHeadSqui."'";
                    break;

            }

            // end method header font

            /*
            * Method Menu font
           */

            $TZFMenuType     =   ot_get_option('TZFontTypeMenu','TzFontDefault');               // type font google or defaul
            $TzFMenuUrl      =   ot_get_option('TzFontMenuGoodurl');                            //  url google font
            $TZFMenuFamily   =   ot_get_option('TzFontFaminyMenu');                             //  font family google
            $TzFMenuSqui     =   ot_get_option('TzFontMenuSquirrel','LaconicLight');            //  font squireel
            $FMenuSelecter   =   ot_get_option('TzMenuSelecter');                               //  body selecter
            $TzFMenuDefault  =   ot_get_option('TzFontMenuDefault','Arial');                     //  font standard
            $TzMenuFontColor    = ot_get_option('TzMenuFontColor');                              // color
            switch($TZFMenuType){
                case'Tzgoogle':
                    $TzMenufont = $TZFMenuFamily;
                    break;
                case'TzFontDefault':
                    $TzMenufont = "'".$TzFMenuDefault."'";
                    break;
                default:
                    $TzMenufont = "'".$TzFMenuSqui."'";
                    break;

            }
            // end method menu font

            /*
              * Method Custom font
             */
            $TZFCustomType     =   ot_get_option('TZFontTypeCustom','TzFontDefault');               // type font google or defaul
            $TzFCustomUrl      =   ot_get_option('TzFontCustomGoodurl');                            //  url google font
            $TZFCustomFamily   =   ot_get_option('TzFontFaminyCustom');                             //  font family google
            $TzFCustomSqui     =   ot_get_option('TzFontCustomSquirrel','LaconicBold');            //  font squireel
            $FCustomSelecter   =   ot_get_option('TzCustomSelecter');                               //  body selecter
            $TzFCustomDefault  =   ot_get_option('TzFontCustomDefault','Arial');                     //  font standard
            $TzCustomFontColor     = ot_get_option('TzCustomFontColor');                             // color

            switch($TZFCustomType){
                case'Tzgoogle':
                    $TzCustomfont = $TZFCustomFamily;
                    break;
                case'TzFontDefault':
                    $TzCustomfont = "'".$TzFCustomDefault."'";
                    break;
                default:
                    $TzCustomfont = "'".$TzFCustomSqui."'";
                    break;

            }

            // end custom font

            if(isset($TzFontFamiUrl) && $TzFontFamiUrl!=""){ wp_enqueue_style('google-font', $TzFontFamiUrl, false); }

            if(isset($TzFHeadUrl) && $TzFHeadUrl!=""){ wp_enqueue_style('header-font', $TzFHeadUrl, false); }

            if(isset($TzFMenuUrl) && $TzFMenuUrl!=""){ wp_enqueue_style('menu-font', $TzFMenuUrl, false); }

            if(isset($TzFCustomUrl) && $TzFCustomUrl!=""){ wp_enqueue_style('custom-font', $TzFCustomUrl, false); }

            /*====================================
             *  Background
            =====================================*/

            $default_background_type = ot_get_option('background_type');
            $default_color           = ot_get_option('TZBackgroundColor','');
            $default_pattern         = ot_get_option('background_pattern');
            $default_single_image    = ot_get_option('background_single_image');
            $background = '';
            switch($default_background_type){
                case 'pattern':
                    $background = 'body#bd {background: url("' . THEME_PATH .'/images/patterns/' . $default_pattern . '") repeat scroll 0 0 transparent !important;}';
                    break;
                case 'single_image':
                    $background = 'body#bd {background: url("' . $default_single_image . '") no-repeat fixed center center / cover transparent !important;}';
                    break;
                case 'none':
                    $background = 'body#bd {background: '.$default_color.' !important;}';
                    break;
                default:
                    $background = 'body#bd {background: '.$default_color.' !important;}';
                    break;
            }
            // logo
            $colorlogo  =   ot_get_option('logoTextcolor');

            ?>
                <style type="text/css">


                        /* body  font style  */
                        <?php if(!empty($bodySelecter) && !empty($bodySelecter)){  echo $bodySelecter ; ?> { font-family:<?php echo $Tzfont; ?> !important; color: <?php echo $TzbodyFontColor; ?> !important ;  }
                        <?php }   ?>

                        /* Head font style  */
                        <?php if(!empty($FHeadSelecter) && !empty($FHeadSelecter)){  echo $FHeadSelecter ; ?> { font-family:<?php echo $TzHeadfont; ?> !important; color: <?php echo $TzHeaderFontColor; ?> !important ;  }
                        <?php }   ?>

                        /* Menu font style*/
                        <?php if(!empty($FMenuSelecter) && !empty($FMenuSelecter)){  echo $FMenuSelecter ; ?> { font-family:<?php echo $TzMenufont; ?> !important ; color: <?php echo $TzMenuFontColor; ?> !important ; }
                        <?php } ?>

                        /* Custom font style */

                        <?php if(!empty($TZFCustomType) && !empty($FCustomSelecter)):  echo $FCustomSelecter ; ?> { font-family:<?php echo $TzCustomfont; ?> !important ; color: <?php echo $TzCustomFontColor; ?> !important ;  }
                        <?php endif; ?>

                        /* color logo */

                        <?php if(isset($colorlogo) && !empty($colorlogo)): echo'.logo h3 a{ color: '.$colorlogo.' }';  endif; ?>

                        /*background*/
                        <?php if($background){ echo $background; } ?>

                </style>

            <?php

            if(ot_get_option( 'favicon_onoff','no') == 'yes'){

                $plazart_favicon = ot_get_option('favicon');

                if( $plazart_favicon ){

                    echo '<link rel="shortcut icon" href="' . $plazart_favicon . '" type="image/x-icon" />';

                }

            }

        } // end function config theme

    endif // endif check admin

?>
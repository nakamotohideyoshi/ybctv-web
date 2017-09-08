<?php
/*
 * Initialize the options before anything else.
 */

add_action('admin_init','theme_options',1);

/*
 * Build the custom settings & update OptionTree.
*/

function theme_options()
{

    /**
     * Get a copy of the saved settings array.
     */
    $saved_settings = get_option('option_tree_settings', array());


    // Pattern
    $patterns = array();
    if ($dir = opendir(SERVER_PATH . '/images/patterns/')) {
        while (false !== ($file = readdir($dir))) {
            if ($file != '..' && $file != '.') {
                $patterns[] = array(
                    'value' => trim($file),
                    'label' => 'Click on pattern to preview',
                    'src'   => THEME_PATH . '/images/patterns/' . $file, 40, 40, true
                );
            }
        }
        // Close directory handle
        closedir($dir);
    }

    /**
     * Custom settings array that will eventually be
     * passes to the OptionTree Settings API Class.
     */
    $custom_settings = array(
        'contextual_help' => array(
            'content' => array(
                array(
                    'id'      => 'general_help',
                    'title'   => 'General',
                    'content' => '<p>Help content goes here!</p>'
                ),
            ),
            'sidebar' => '<p>Sidebar content goes here!</p>'
        ),
        'sections'        => array(
            array(
                'id'    => 'logo',
                'title' => 'Logo & Favicon',
            ),
            array(
                'id'    => '404',
                'title' => '404 Page',
            ),

            array(
                'id'    => 'copyright',
                'title' => 'Copyright',
            ),
            array(
                'id'    =>  'google_analytics',
                'title' =>  'Google Analytics',
            ),
            array(
                'id'    => 'social_network',
                'title' => 'Social Network',
            ),
            array(
                'id'    =>  'TzSyle',
                'title' =>  'Style Option',
            ),
            array(
                'id'    =>  'TZBody',
                'title' =>  'Body Style',
            ),

            array(
                'id'    =>  'TzFontHeader',
                'title' =>  'Header Style',
            ),


            array(
                'id'    =>  'TzFontMenu',
                'title' =>  'Menu Style',
            ),

            array(
                'id'    =>  'TzFontCustom',
                'title' =>  'Custom Style',
            ),

            array(
                'id'    =>  'TZBackground',
                'title' =>  'Background',
            ),

            array(
                'id'    =>  'HomeOption',
                'title' =>  'Home Option',
            ),
        ),



        'settings'        => array(

            array(
                'id'        => 'logotype',
                'label'     => 'Logo Type',
                'desc'      => '',
                'std'       => '1',
                'type'      => 'select',
                'section'   => 'logo',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => '',
                'choices'   => array(
                    array(
                        'value' => '1',
                        'label' => 'Logo image',
                    ),
                    array(
                        'value' => '0',
                        'label' => 'Logo text',
                    ),
                ),
            ),

            array(
                'id'        => 'logoText',
                'label'     => 'Logo Text',
                'desc'      => '',
                'std'       => 'logo',
                'type'      => 'text',
                'section'   => 'logo',
            ),

            array(
                'id'        => 'logoTextcolor',
                'label'     => 'Color logo',
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'logo',
            ),

            array(
                'id'        => 'logo',
                'label'     => 'Upload Logo',
                'desc'      => '',
                'std'       => '',
                'type'      => 'upload',
                'section'   => 'logo',
            ),

            array(
                'id'        => 'favicon_onoff',
                'label'     => 'Enable Favicon',
                'desc'      => '',
                'std'       => 'no',
                'type'      => 'radio',
                'section'   => 'logo',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => '',
                'choices'   => array(
                    array(
                        'value' => 'yes',
                        'label' => 'Yes',
                        'src'   => ''
                    ),
                    array(
                        'value' => 'no',
                        'label' => 'No',
                        'src'   => ''
                    )
                ),
            ),

            array(
                'id'        => 'favicon',
                'label'     => 'Upload Favicon Icon',
                'desc'      => '',
                'std'       => '',
                'type'      => 'upload',
                'section'   => 'logo',
            ),

            array(
                'id'        => '404_page_content',
                'label'     => '404 Page Content',
                'desc'      => '',
                'std'       => '<h2>We\'re sorry..</h2><p>The page or journal you are looking for cannot be found</p>',
                'type'      => 'textarea',
                'section'   => '404',
                'rows'      => '15',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),


            // Copyright Settings
            array(
                'id'        => 'copyright',
                'label'     => 'Copyright',
                'desc'      => '',
                'std'       => '',
                'type'      => 'textarea',
                'section'   => 'copyright',
                'rows'      => '15',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            // Google Analytics
            array(
                'id'        => 'google_analytics',
                'label'     => 'Google Analytics',
                'desc'      => 'Place the code you get from google here. This should be something like:<br /><br /><code>   // Google analytics <br /> var _gaq = _gaq || []; <br />_gaq.push(["_setAccount", "UA-XXXXXXX-XX"]); <br /> ...</code>',
                'std'       => '',
                'type'      => 'textarea-simple',
                'section'   => 'google_analytics',
                'rows'      => '4',
            ),

            // Social Network Settings

            array(
                'id'        => 'social_network_facebook',
                'label'     => 'Facebook',
                'desc'      => 'Place the link you want and Facebook icon will appear. To remove it, just leave it blank.',
                'std'       => '',
                'type'      => 'text',
                'section'   => 'social_network',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),
            array(
                'id'        => 'social_network_twitter',
                'label'     => 'Twitter',
                'desc'      => 'Place the link you want and Twitter icon will appear. To remove it, just leave it blank.',
                'std'       => '',
                'type'      => 'text',
                'section'   => 'social_network',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            array(
                'id'        => 'social_network_google-plus',
                'label'     => 'Google Plus',
                'desc'      => 'Place the link you want and Google Plus icon will appear. To remove it, just leave it blank.',
                'std'       => '',
                'type'      => 'text',
                'section'   => 'social_network',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            array(
                'id'        => 'social_network_youtube',
                'label'     => 'Youtube',
                'desc'      => 'Place the link you want and Youtube icon will appear. To remove it, just leave it blank.',
                'std'       => '',
                'type'      => 'text',
                'section'   => 'social_network',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),
            array(
                'id' =>  'TzSyle',
                'label'     => 'StyleConfig',
                'desc'      => '<p>Config for body style, header style, menu style, custom style, background</p>',
                'std'       => '',
                'type'      => 'textblock-titled',
                'section'   => 'TzSyle',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),
            // font style body -----------------------------------------------------------------------
            array(
                'id'        =>  'TZFontType',
                'label'     =>  'Font Type',
                'desc'      =>  'option font type',
                'std'       =>  '',
                'type'      =>  'select',
                'section'   =>  'TZBody',
                'rows'      =>  '',
                'post_type' =>  '',
                'taxonomy'  =>  '',
                'class'     =>  'btn-group',
                'choices'   =>  array(
                    array(
                        'value' =>  'TzFontSquirrel',
                        'label' =>  'Squirrel Font',
                    ),
                    array(
                        'value' =>  'Tzgoogle',
                        'label' =>  'Goole Font',
                    ),
                    array(
                        'value' =>  'TzFontDefault',
                        'label' =>  'Standard Font',
                    ),


                ),
            ),

            // Squirrel font
            array(
                'id'       =>   'TzFontDefault',
                'label'    =>   'Select Standard Font ',
                'desc'     =>   '',
                'type'     =>   'select',
                'section'  =>   'TZBody',
                'class'    =>   'TzFontStylet',
                'choices'  =>   array(
                    array(
                        'value'  =>  'Arial',
                        'label'  =>  'Arial',
                    ),
                    array(
                        'value'  =>  'Tahoma',
                        'label'  =>  'Tahoma',
                    ),
                    array(
                        'value'  =>  'Verdana',
                        'label'  =>  'Verdana',
                    ),
                    array(
                        'value'  =>  'Georgia',
                        'label'  =>  'Georgia',
                    ),
                    array(
                        'value'  =>  'Impact',
                        'label'  =>  'Impact',
                    ),
                    array(
                        'value'  =>  'Times',
                        'label'  =>  'Times',
                    ),
                )
            ),

            //default font
            array(
                'id'        =>  'TzFontSquirrel',
                'label'     =>  'Select Squirrel  Font ',
                'desc'      =>  '',
                'type'      =>  'select',
                'section'   =>  'TZBody',
                'choices'   =>  array(
                    array(
                        'value'  =>  'OpenSansRegular',
                        'label'  =>  'OpenSansRegular',
                    ),
                ),
            ),

            // google url
            array(
                'id'    =>  'TzFontFami',
                'label' =>  'Google Url',
                'desc'  =>  'http://www.google.com/fonts/',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TZBody'
            ),

            // body font
            array(
                'id'    =>  'TzFontFaminy',
                'label' =>  'Font Family',
                'desc'  =>  '',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TZBody',
            ),
            // color code
            array(
                'id'        =>  'TzBodyColor',
                'label'     => 'Color code',
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZBody',
            ),
            array(
                'id'        =>  'TzBodySelecter',
                'label'     =>  'Body Selectors',
                'desc'      =>  'you can specify a selector for font used in the document body',
                'std'       =>  '',
                'type'      =>  'textarea-simple',
                'section'   =>  'TZBody',
                'rows'      =>  '10',
            ),
            // end font style body


            // font style Header -----------------------------------------------------------------------
            array(
                'id'        =>  'TZFontTypeHead',
                'label'     =>  'Font Type',
                'desc'      =>  'option font type',
                'std'       =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontHeader',
                'rows'      =>  '',
                'post_type' =>  '',
                'taxonomy'  =>  '',
                'class'     =>  '',
                'choices'   =>  array(
                    array(
                        'value' =>  'TzFontSquirrel',
                        'label' =>  'Squirrel Font',
                    ),
                    array(
                        'value' =>  'Tzgoogle',
                        'label' =>  'Goole Font',
                    ),
                    array(
                        'value' =>  'TzFontDefault',
                        'label' =>  'Standard Font',
                    ),


                ),
            ),

            // Squirrel font
            array(
                'id'       =>   'TzFontHeadDefault',
                'label'    =>   'Select Standard Font ',
                'desc'     =>   '',
                'type'     =>   'select',
                'section'  =>   'TzFontHeader',
                'choices'  =>   array(
                    array(
                        'value'  =>  'Arial',
                        'label'  =>  'Arial',
                    ),
                    array(
                        'value'  =>  'Tahoma',
                        'label'  =>  'Tahoma',
                    ),
                    array(
                        'value'  =>  'Verdana',
                        'label'  =>  'Verdana',
                    ),
                    array(
                        'value'  =>  'Georgia',
                        'label'  =>  'Georgia',
                    ),
                    array(
                        'value'  =>  'Impact',
                        'label'  =>  'Impact',
                    ),
                    array(
                        'value'  =>  'Times',
                        'label'  =>  'Times',
                    ),
                )
            ),

            //default font
            array(
                'id'        =>  'TzFontHeadSquirrel',
                'label'     =>  'Select Squirrel  Font ',
                'desc'      =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontHeader',
                'choices'   =>  array(
                    array(
                        'value'  =>  'OpenSansRegular',
                        'label'  =>  'OpenSansRegular',
                    ),
                ),
            ),

            // google url
            array(
                'id'    =>  'TzFontHeadGoodurl',
                'label' =>  'Google Url',
                'desc'  =>  'http://www.google.com/fonts/',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontHeader'
            ),

            // body font
            array(
                'id'    =>  'TzFontFaminyHead',
                'label' =>  'Font Family',
                'desc'  =>  '',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontHeader',
            ),
            array(
                'id'    =>  'TzHeaderFontColor',
                'label'     => 'Color code',
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TzFontHeader',
            ),
            array(
                'id'        =>  'TzHeadSelecter',
                'label'     =>  'Header Selecter',
                'desc'      =>  'you can specify a selector for font used in the document Header',
                'std'       =>  '',
                'type'      =>  'textarea-simple',
                'section'   =>  'TzFontHeader',
                'rows'      =>  '10',
            ),

            // end font header

            // font  Menu -----------------------------------------------------------------------

            array(
                'id'        =>  'TZFontTypeMenu',
                'label'     =>  'Font Type',
                'desc'      =>  'option font type',
                'std'       =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontMenu',
                'rows'      =>  '',
                'post_type' =>  '',
                'taxonomy'  =>  '',
                'class'     =>  '',
                'choices'   =>  array(
                    array(
                        'value' =>  'TzFontSquirrel',
                        'label' =>  'Squirrel Font',
                    ),
                    array(
                        'value' =>  'Tzgoogle',
                        'label' =>  'Goole Font',
                    ),
                    array(
                        'value' =>  'TzFontDefault',
                        'label' =>  'Standard Font',
                    ),


                ),
            ),

            // Squirrel font
            array(
                'id'       =>   'TzFontMenuDefault',
                'label'    =>   'Select Standard Font ',
                'desc'     =>   '',
                'type'     =>   'select',
                'section'  =>   'TzFontMenu',
                'choices'  =>   array(
                    array(
                        'value'  =>  'Arial',
                        'label'  =>  'Arial',
                    ),
                    array(
                        'value'  =>  'Tahoma',
                        'label'  =>  'Tahoma',
                    ),
                    array(
                        'value'  =>  'Verdana',
                        'label'  =>  'Verdana',
                    ),
                    array(
                        'value'  =>  'Georgia',
                        'label'  =>  'Georgia',
                    ),
                    array(
                        'value'  =>  'Impact',
                        'label'  =>  'Impact',
                    ),
                    array(
                        'value'  =>  'Times',
                        'label'  =>  'Times',
                    ),
                )
            ),

            //default font
            array(
                'id'        =>  'TzFontMenuSquirrel',
                'label'     =>  'Select Squirrel  Font ',
                'desc'      =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontMenu',
                'choices'   =>  array(
                    array(
                        'value'  =>  'OpenSansRegular',
                        'label'  =>  'OpenSansRegular',
                    ),
                ),
            ),

            // google url
            array(
                'id'    =>  'TzFontMenuGoodurl',
                'label' =>  'Google Url',
                'desc'  =>  'http://www.google.com/fonts/',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontMenu'
            ),

            // Font Family
            array(
                'id'    =>  'TzFontFaminyMenu',
                'label' =>  'Font Family',
                'desc'  =>  '',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontMenu',
            ),

            array(
                'id'    =>  'TzMenuFontColor',
                'label'     => 'Color code',
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TzFontMenu',
            ),
            array(
                'id'        =>  'TzMenuSelecter',
                'label'     =>  'Menu Selectors',
                'desc'      =>  '',
                'std'       =>  '',
                'type'      =>  'textarea-simple',
                'section'   =>  'TzFontMenu',
                'rows'      =>  '10',
            ),
            /*---end menu font--*/



            // font style custom -----------------------------------------------------------------------
            array(
                'id'        =>  'TZFontTypeCustom',
                'label'     =>  'Font Type',
                'desc'      =>  'option font type',
                'std'       =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontCustom',
                'rows'      =>  '',
                'post_type' =>  '',
                'taxonomy'  =>  '',
                'class'     =>  '',
                'choices'   =>  array(
                    array(
                        'value' =>  'TzFontSquirrel',
                        'label' =>  'Squirrel Font',
                    ),

                    array(
                        'value' =>  'Tzgoogle',
                        'label' =>  'Goole Font',
                    ),
                    array(
                        'value' =>  'TzFontDefault',
                        'label' =>  'Standard Font',
                    ),

                ),
            ),

            // Squirrel font
            array(
                'id'       =>   'TzFontCustomDefault',
                'label'    =>   'Select Standard Font ',
                'desc'     =>   '',
                'type'     =>   'select',
                'section'  =>   'TzFontCustom',
                'choices'  =>   array(
                    array(
                        'value'  =>  'Arial',
                        'label'  =>  'Arial',
                    ),
                    array(
                        'value'  =>  'Tahoma',
                        'label'  =>  'Tahoma',
                    ),
                    array(
                        'value'  =>  'Verdana',
                        'label'  =>  'Verdana',
                    ),
                    array(
                        'value'  =>  'Georgia',
                        'label'  =>  'Georgia',
                    ),
                    array(
                        'value'  =>  'Impact',
                        'label'  =>  'Impact',
                    ),
                    array(
                        'value'  =>  'Times',
                        'label'  =>  'Times',
                    ),
                )
            ),

            //default font
            array(
                'id'        =>  'TzFontCustomSquirrel',
                'label'     =>  'Select Squirrel  Font ',
                'desc'      =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontCustom',
                'choices'   =>  array(
                    array(
                        'value'  =>  'OpenSansRegular',
                        'label'  =>  'OpenSansRegular',
                    ),
                ),
            ),

            // google url
            array(
                'id'    =>  'TzFontCustomGoodurl',
                'label' =>  'Google Url',
                'desc'  =>  'http://www.google.com/fonts/',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontCustom'
            ),

            // body font
            array(
                'id'       =>  'TzFontFaminyCustom',
                'label'    =>  'Font Family',
                'desc'     =>  '',
                'std'      =>  '',
                'type'     =>  'text',
                'section'  => 'TzFontCustom',
            ),

            array(
                'id'        =>  'TzCustomFontColor',
                'label'     =>  'Color code',
                'desc'      =>  '',
                'std'       =>  '',
                'type'      => 'colorpicker',
                'section'   => 'TzFontCustom',
            ),
            array(
                'id'        =>  'TzCustomSelecter',
                'label'     =>  'Custom Selecter',
                'desc'      =>  'you can specify a selector for font used in the document Custom',
                'std'       =>  '',
                'type'      =>  'textarea-simple',
                'section'   =>  'TzFontCustom',
                'rows'      =>  '10',
            ),
            // end font custom

            /*---------------------end themestyle--------------------*/

            /* Background */

            array(
                'id'        => 'cbackground',
                'label'     => 'Background',
                'desc'      => '<p>Default background for Post, Page, Portfolio, Category, Archive, Seach page.</p>',
                'std'       => '',
                'type'      => 'textblock-titled',
                'section'   => 'TZBackground',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),
            array(
                'id'        => 'background_type',
                'label'     => 'Background Type',
                'desc'      => 'You can choose the background you want between our pre-provided pattern and your custom image.',
                'std'       => 'none',
                'type'      => 'select',
                'section'   => 'TZBackground',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => '',
                'choices'   => array(
                    array(
                        'value' => 'none',
                        'label' => 'Default',
                    ),
                    array(
                        'value' => 'pattern',
                        'label' => 'Pattern',
                    ),
                    array(
                        'value' => 'single_image',
                        'label' => 'Single image',
                    ),
                ),
            ),
            array(
                'id'        =>  'TZBackgroundColor',
                'label'     => 'Color code',
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZBackground',
            ),
            array(
                'id'        => 'background_pattern',
                'label'     => 'Choose Pattern',
                'desc'      => '',
                'std'       => '',
                'type'      => 'radio-image',
                'section'   => 'TZBackground',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => 'background_pattern',
                'choices'   => $patterns
            ),
            array(
                'id'        => 'background_single_image',
                'label'     => 'Single Image Background',
                'desc'      => '',
                'std'       => '',
                'type'      => 'upload',
                'section'   => 'TZBackground',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            /* End Background */

            /*------------------HomePage--------------------*/
            /*------------------HomePage--------------------*/

            array(
                'id'        => 'address_email',
                'label'     => 'Đia chỉ Email',
                'desc'      => 'Đia chỉ Email',
                'std'       => '',
                'type'      => 'text',
                'section'   => 'HomeOption',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            array(
                'id'        => 'hot_line',
                'label'     => 'Hot Line',
                'desc'      => 'Hot Line',
                'std'       => '',
                'type'      => 'text',
                'section'   => 'HomeOption',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            array(
                'id'          => 'service_icon',
                'label'       => __( 'Dịch vụ & Icon' ),
                'desc'        => __( '', '' ),
                'std'         => '',
                'type'        => 'list-item',
                'section'     => 'HomeOption',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => '',
                'operator'    => 'and',
                'settings'    => array(
                    array(
                        'id'          => 'social_icon_img',
                        'label'       => __( 'icon' ),
                        'desc'        => 'the best sixe for icon is 65x65.',
                        'std'         => '',
                        'type'        => 'upload',
                        'rows'        => '10',
                        'post_type'   => '',
                        'taxonomy'    => '',
                        'min_max_step'=> '',
                        'class'       => '',
                        'condition'   => '',
                        'operator'    => 'and'
                    ),
                    array(
                        'id'          => 'social_icon_link',
                        'label'       => __( 'link' ),
                        'desc'        => 'Link',
                        'std'         => '',
                        'type'        => 'text',
                        'rows'        => '10',
                        'post_type'   => '',
                        'taxonomy'    => '',
                        'min_max_step'=> '',
                        'class'       => '',
                        'condition'   => '',
                        'operator'    => 'and'
                    ),
                )
            ),

            array(
                'id'          => 'support_icon',
                'label'       => __( 'Hỗ trợ trực tuyến' ),
                'desc'        => __( '', '' ),
                'std'         => '',
                'type'        => 'list-item',
                'section'     => 'HomeOption',
                'rows'        => '',
                'post_type'   => '',
                'taxonomy'    => '',
                'min_max_step'=> '',
                'class'       => '',
                'condition'   => '',
                'operator'    => 'and',
                'settings'    => array(
                    array(
                        'id'          => 'sp_name',
                        'label'       => __( 'Tên'),
                        'desc'        => '',
                        'std'         => '',
                        'type'        => 'text',
                        'post_type'   => '',
                        'taxonomy'    => '',
                        'min_max_step'=> '',
                        'class'       => '',
                        'condition'   => '',
                        'operator'    => 'and'
                    ),
                )
            )
        ),
    );

    /* allow settings to be filtered before saving */

    $custom_settings = apply_filters('option_tree_settings_args', $custom_settings);

    /* settings are not the same update the DB */
    if ($saved_settings !== $custom_settings) {
        update_option('option_tree_settings', $custom_settings);
    }

}


?>

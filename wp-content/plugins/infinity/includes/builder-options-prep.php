<?php

function view_widget_in_use($view_id){

    $widget_settings = get_option('widget_infinity_widget');

    $view_in_use = null;

    foreach((array)$widget_settings as $instance => $options){

        $id_base = 'infinity_widget';

        $id = "{$id_base}-{$instance}";

        // is this the instance
        if(!is_active_widget(false, $id, $id_base)) continue;

        // check if the view id option matches the id we are checking for
        if($options['view_id'] == $view_id) {
           $view_in_use = true;
        }

    }

    return $view_in_use;

}


function builder_options() {

$builder_options = TitanFramework::getInstance( 'builder-options' );


$args = array(
    'post_type' => 'view',
    'posts_per_page'        => '-1',
);

$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) :

    while($the_query->have_posts()) : $the_query->the_post();

        $id = $the_query->post->ID;

        $options = vb_options( $id );

        $query_mode = $options['query-mode'];

        $title = get_the_title();
        $view_name = strtolower(str_replace(' ', '-', get_the_title()));

            /*
             * View customizer options
             */
            //if (view_widget_in_use($id)) {

                $section = $builder_options->createThemeCustomizerSection( array(
                    'label' =>  get_the_title(),
                    'setting'=> 'builder-' . $view_name,
                    'position' => 3,
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => get_the_title(),
                    'setting' => 'id-hide-'.$id,
                    'description' => $id,
                    'type' => 'heading-infinity',
                ) );

                if ( $query_mode == 1 ) {

                  Infinity_Kirki::add_field( 'infinity', array(
                  'section'  => 'PART_'.$id,
                        'label' => 'Posts:',
                        'setting' => 'postopts-post-count-' . $id . '',
                        'description' => 'The total number of posts to show per view per page.',
                        'type' => 'text',
                        'default' => '20'
                    ) );

                }

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Columns:',
                    'setting' => 'postopts-columns-' . $id . '',
                    'type' => 'select',
                    'description' => 'The number of columns to display for grid, masonry and carousel modes.',
                    'choices' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                        '13' => '13',
                        '14' => '14',

                    ),
                    'default' => '4'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Spacing:',
                    'setting' => 'postopts-post-spacing-' . $id . '',
                    'description' => 'The amount spacing in pixels between each item.',
                    'type' => 'text',
                    'default' => '20'
                ) );

                if ( $query_mode == 1 ) {

                  Infinity_Kirki::add_field( 'infinity', array(
                  'section'  => 'PART_'.$id,
                        'label' => 'Categories ',
                        'setting' => 'postopts-post-categories-' . $id . '',
                        'type' => 'multicheck-categories-infinity',
                        'description' => 'Select a category to display content from',
                        'default' => 'all'
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Order:',
                        'setting' => 'postopts-order-by-' . $id,
                        'description' => 'What to order the posts by. Set to <b>Meta value</b> or Meta value (Numeric) to order by custom meta values.',
                        'type' => 'select',
                        'default' => 'date',
                        'choices' => array(
                            'date' => 'Date Published',
                            'setting' => 'setting',
                            'author' => 'Author',
                            'title' => 'Title',
                            'modified' => 'Date Modified',
                            'parent' => 'Parent ID',
                            'rand' => 'Random order',
                            'likes' => 'Order by post likes',
                            'comment_count' => 'Comment Count',
                            'menu_order' => 'Page order',
                            'meta_value' => 'Meta value',
                            'meta_value_num' => 'Meta value (Numeric)'
                        )
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Key:',
                        'setting' => 'postopts-order-meta-key-' . $id,
                        'description' => 'Set a meta key to order content by. The key will be the meta key set when adding a custom meta element.',
                        'type' => 'text',
                        'default' => ''
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => '',
                        'setting' => 'postopts-order-' . $id,
                        'description' => 'Set the order',
                        'type' => 'select',
                        'default' => 'description',
                        'choices' => array(
                            'ASC' => 'ASC',
                            'description' => 'description'
                        )
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Offset:',
                        'setting' => 'postopts-post-offset-' . $id,
                        'description' => 'Offset results by x number of posts',
                        'type' => 'text',
                        'default' => ''
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => '<a href="wp-admin/post.php?post='. $id .'&action=edit" target="_blank"><img src="'. views()->plugin_url .'/includes/admin/images/filter.png"/></a>',
                        'setting' => 'postopts-builder-'.$id,
                        'type' => 'heading-infinity',
                        'description' => '<strong>Filter Content</strong> <p>Takes you to the advanced filter page with more advanced options where you can select specific content to display.</p>',
                    ) );

                } else {
                  Infinity_Kirki::add_field( 'infinity', array(
                  'section'  => 'PART_'.$id,
                        'label' => 'You are currently in default mode. <a href="wp-admin/post.php?post='. $id .'&action=edit" target="_blank">Enable custom query</a> to show specific content.',
                        'setting' => 'postopts-disabled-query-'.$id,
                        'type' => 'heading-infinity',
                        'description' => '<strong>Default Mode</strong>
                                    <p>When default mode is selected, the output will be like a normal blog template according to normal wordpress behaviour. For example, if you add this on a page, it will display that page\'s content. If you add it on the Blog Index layout, it will list the posts like a normal blog and if you add this box on a category or tag layout, it will list posts of that category or tag respectively.</p>
                                    <strong>Custom Query Mode</strong>
                                    <p>Enable a custom query to display specific content from your wordpress installation. This content will always show on all pages irrespective of the wordpress relative page. Used to display posts specific post types or taxonomies on all pages.</p>'
                    ) );
                }

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '1) Select a style',
                    'setting' => 'toggle-heading-style-' . $id,
                    'type' => 'heading-infinity',
                    'default' => '20'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '',
                    'description' => 'Set a preset style that is applied to each item in the view.',
                    'setting' => 'style-name-' . $id,
                    'type' => 'select',
                    'choices' => get_styles_list(),
                    'default' => 'headway'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '2) Select a Layout',
                    'setting' => 'toggle-heading-select-layout-' . $id,
                    'type' => 'heading-infinity',
                    'default' => '20'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'description' => 'Choose from one of the layouts below to display your items.',
                    'setting' => 'layout-heading-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '',
                    'setting' => 'view-layout-' . $id . '',
                    'type' => 'radio-image',
                    'choices' => get_layouts_list(),
                    'default' => 'blog',
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '3) Build Individual Layout',
                    'setting' => 'toggle-heading-build-layout-' . $id,
                    'type' => 'heading-infinity',
                    'default' => '20'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'description' => 'Use the builder below to show or hide & then configure the elements as needed.',
                    'setting' => 'builder-heading-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '',
                    'setting' => 'builder_parts' . $id,
                    'description' => 'Choose from one of the layouts below to display your items.',
                    'type' => 'sortable-infinity',
                    'description' => '',
                    'choices' => get_builder_elements($id),
                    'default' => array('title', 'image', 'excerpt', 'date', 'readmore'),
                ) );


                //Title Options

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before title',
                    'setting' => 'title-option-before-text-' . $id,
                    'type' => 'text',
                    'default' => ''
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Title Markup',
                    'setting' => 'title-option-html-tag-' . $id,
                    'type' => 'select',
                    'choices' => array(
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                    ),
                    'default' => 'h2',
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Link title',
                    'setting' => 'title-option-link-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'link' => 'Link',
                        'unlink' => 'UnLink'
                    ),
                    'default' => 'link'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Shorten Title',
                    'setting' => 'title-option-shorten-title-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Limit to characters',
                    'setting' => 'title-option-shorten-limit-' . $id,
                    'type' => 'text',
                    'default' => '50'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'title-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => '',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Excerpt Options

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Content to show',
                    'setting' => 'excerpt-option-content-to-show-' . $id,
                    'type' => 'select',
                    'choices' => array(
                        'excerpt' => 'Excerpt',
                        'content' => 'Full Content'
                    ),
                    'default' => 'excerpt'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Excerpt Length',
                    'setting' => 'excerpt-option-length-' . $id,
                    'type' => 'text',
                    'default' => '140',
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Excerpt more:',
                    'setting' => 'excerpt-option-more-' . $id,
                    'type' => 'text',
                    'default' => '...',
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'excerpt-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => null,
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Date Options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'date_'.$id,
                    'label' => 'Before Text',
                    'setting' => 'date-option-before-text-' . $id,
                    'type' => 'text',
                    'default' => ''
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						'section'  => 'date_'.$id,
                   'label' => 'Before Text',
                   'setting' => 'date-styles-color-' . $id,
                   'type' => 'color',
                   'default' => '',
               ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'date_'.$id,
                    'label' => 'Date Format',
                    'type' => 'select',
                    'setting' => 'date-option-meta-date-format-' . $id,
                    'choices' => array(
                        'wordpress-default' => 'WordPress Default',
                        'F j, Y' => date('F j, Y'),
                        'm/d/y' => date('m/d/y'),
                        'd/m/y' => date('d/m/y'),
                        'M j' => date('M j'),
                        'M j, Y' => date('M j, Y'),
                        'F j' => date('F j'),
                        'F jS' => date('F jS'),
                        'F jS, Y' => date('F jS, Y')
                    ),
                    'default' => 'wordpress-default'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'date_'.$id,
                    'label' => 'Display As',
                    'setting' => 'date-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'inline-block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Image Options

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Thumb Alignment',
                    'setting' => 'image-option-thumb-align-heading-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => '',
                    'setting' => 'image-option-thumb-align-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'left' => 'Left',
                        'none' => 'None',
                        'right' => 'Right'
                    ),
                    'default' => 'left'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Automatically Size Thumb',
                    'description' => 'Auto resizes to fit the full width of the article column.',
                    'setting' => 'image-option-auto-size-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Auto size container width',
                    'setting' => 'image-option-autosize-container-width-' . $id,
                    'type' => 'text',
                    'default' => '940'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Dimensions if "Auto is Off"',
                    'setting' => 'image-option-heading-dimensions-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Thumb Width',
                    'setting' => 'image-option-thumbnail-width-' . $id,
                    'type' => 'text',
                    'default' => '250'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Thumb Height',
                    'setting' => 'image-option-thumbnail-height-' . $id,
                    'type' => 'text',
                    'default' => '200'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Crop thumb vertically',
                    'description' => 'Makes the height of all images the same even if originals are not.',
                    'setting' => 'image-option-crop-vertically-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Crop vertical ratio',
                    'setting' => 'image-option-crop-vertically-height-ratio-' . $id,
                    'type' => 'text',
                    'default' => '60'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Icon Animation',
                    'setting' => 'image-icon-type-effect-' . $id,
                    'type' => 'select',
                    'choices' => array(
                        'StyleH' => 'Fade In',
                        'StyleHe' => 'Slide Top',
                        'StyleLi' => 'Slide Bottom',
                        'StyleBe' => 'Slide Right',
                        'StyleB' => 'Slide Left',
                        'StyleC' => 'Zoom In',
                        'StyleN' => 'Twirl In',
                        'StyleO' => 'Rotate In',
                        'StyleF' => 'Flip In',
                        'StyleNe' => 'Zoom Twirl',
                        'StyleMg' => 'Left Right In',
                        'StyleAl' => 'Top Bottom In',
                        'StyleP' => 'Corners In 1',
                        'StyleS' => 'Corners In 2',
                        'StyleSc' => 'Left Right & Top',
                        'StyleTi' => 'Left Right & Center',
                        'StyleV' => 'Drop from top',
                        'CStyleH' => 'Cubic Top',
                        'CStyleHe' => 'Cubic Bottom',
                        'CStyleLi' => 'Cubic Right',
                        'CStyleBe' => 'Cubic Left',
                        'CStyleB' => 'Cubic Zoom In',
                        'CStyleC' => 'Cubic Center Zoom Left & Right'
                    ),
                    'default' => 'StyleH'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Icon Cover Effect',
                    'setting' => 'image-icon-type-cover-effect-' . $id,
                    'type' => 'select',
                    'choices' => array(
                        'ImageFade' => 'Fade In',
                        'ImageFadeExpand' => 'Expand Outwards Top & Bottom',
                        'ImageOverlayLi' => 'Expand Inwards Top & Bottom',
                        'ImageOverlayB' => 'Expand Outwards Left & Right',
                        'ImageOverlayC' => 'Expand Inwards Left & Right',
                        'ImageOverlayO' => 'In from top left',
                        'ImageOverlayF' => 'In from top right',
                        'ImageOverlayNe' => 'In from bottom left',
                        'ImageOverlayNa' => 'In from bottom right',
                        'ImageOverlayMg' => 'Expand In from Top',
                        'ImageOverlayAl' => 'Expand In from Bottom',
                        'ImageOverlaySi' => 'Expand In from Right',
                        'ImageOverlayP' => 'Expand In from Left',
                        'ImageOverlayS' => 'Twirl In',
                        'ImageOverlayCl' => 'Twirl In Bottom Right',
                        'ImageOverlayK' => 'Flip In Bottom Left',
                        'ImageOverlayCa' => 'Flip In Top',
                        'ImageOverlaySc' => 'Flip In Bottom',
                        'ImageOverlayTi' => 'Flip In Top Right',
                    ),
                    'default' => 'ImageFade'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Icon Style',
                    'setting' => 'image-icon-type-style-' . $id,
                    'type' => 'select',
                    'choices' => array(
                        'Headway' => 'Style in Headway',
                        'WhiteRounded' => 'White Rounded',
                        'BlackRounded' => 'Black Rounded',
                        'WhiteHollowRounded' => 'White Hollow Rounded',
                        'BlackHollowRounded' => 'Black Hollow Rounded',
                        'WhiteSquare' => 'White Square',
                        'BlackSquare' => 'Black Square',
                        'WhiteHollowSquare' => 'White Hollow Square',
                        'BlackHollowSquare' => 'Black Hollow Square',

                    ),
                    'default' => 'WhiteRounded',
                    'livepreview' => '
                        var element = $("article .cover-button");
                        var elClass = element.attr("class");
                        var lastword = elClass.split(" ").pop();
                        element.removeClass(lastword).addClass(value);
                        showHideLoader();
                    '
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Cover Content Effect',
                    'setting' => 'image-content-type-hover-effect-' . $id,
                    'type' => 'select',
                    'choices' => array(
                        'ShowFirst' => 'Show On Load',
                        'H' => 'Fade In',
                        'He' => 'Scale In',
                        'Li' => 'Scale Out & In',
                        'Be' => 'Zoom In',
                        'B' => 'Slide from Top',
                        'C' => 'Slide from Bottom',
                        'N' => 'Slide from Right',
                        'O' => 'Slide from Left',
                        'F' => 'Flip half Left',
                        'Ne' => 'Flip half Top',
                        'Na' => 'Flip half Right',
                        'Mg' => 'Flip half Bottom',
                        'Al' => 'Spin Zoom Horizontal',
                        'Si' => 'Spin Zoom Vertical',
                        'P' => 'Spin Horizontal',
                        'S' => 'Spin Vertical',
                        'Cl' => 'Push Up',
                        'Ar' => 'Push Top',
                        'K' => 'Push Right',
                        'Ca' => 'Push Left',
                        'Sc' => 'Slide Down',
                        'Ti' => 'Slide Left',
                        'V' => 'Slide Right',
                        'Cr' => 'Slide Bottom',
                        'Mn' => 'Rotate in Bottom Left',
                        'Fe' => 'Rotate in Top Right',
                        'Cu' => 'Flip Horizontal',
                        'Zn' => 'Flip Vertical'
                    ),
                    'default' => 'H'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Center Content Vertically',
                    'setting' => 'image-content-type-content-vertical-align-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'top' => 'Top',
                        'center' => 'Center',
                        'bottom' => 'Bottom'
                    ),
                    'default' => 'center'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Lightbox Image Width',
                    'setting' => 'image-icon-type-lightbox-width-' . $id,
                    'type' => 'text',
                    'default' => '1024'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Lightbox Image Height',
                    'setting' => 'image-icon-type-lightbox-height-' . $id,
                    'type' => 'text',
                    'default' => '768'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Show Hover Cover',
                    'setting' => 'image-show-cover-hide-' . $id,
                    'type' => 'checkbox',
                    'default' => true
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Cover Type',
                    'setting' => 'thumb-cover-type-hide-' . $id,
                    'type' => 'select',
                    'choices' => array(
                        'icons' => 'Icons',
                        'content' => 'Content'
                    ),
                    'default' => 'icons'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => '4) Build Image Cover',
                    'setting' => 'toggle-heading-build-cover-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'description' => 'Use the builder below to setup the content and effect that happens when a user hovers over a thumbnail.',
                    'setting' => 'cover-builder-heading-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Cover Content Builder',
                    'setting' => 'image-parts-content-type-' . $id,
                    'description' => 'Add <b>Icons</b> or <b>Content Parts</b> to the Image cover using the builder below. Then set the animation effect.',
                    'type' => 'sortable-infinity',
                    'choices' => get_cover_builder_elements($id),
                    'default' => array('title', 'categories')

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Cover Icon Builder',
                    'setting' => 'image-cover-icon-type-icons-' . $id,
                    'type' => 'sortable-infinity',
                    'choices' => array(
                        'btn1' => 'Icon 1',
                        'btn2' => 'Icon 2',
                        'btn3' => 'Icon 3',
                        'btn4' => 'Icon 4'
                    ),
                    'default' => array('btn1', 'btn2')

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Icon 1',
                    'setting' => 'btn1-option-icon-' . $id,
                    'type' => 'select',
                    'default' => 'search',
                    'choices' => font_awesome_icons(),

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Link 1',
                    'setting' => 'btn1-option-link-' . $id,
                    'description' => 'Add an http:// link or use <strong>lightbox</strong> or content (links to the full content item)',
                    'type' => 'text',
                    'default' => 'lightbox'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Icon 2',
                    'setting' => 'btn2-option-icon-' . $id,
                    'type' => 'select',
                    'default' => 'link',
                    'choices' => font_awesome_icons(),
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Link 2',
                    'setting' => 'btn2-option-link-' . $id,
                    'type' => 'text',
                    'default' => 'content'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Icon 3',
                    'setting' => 'btn3-option-icon-' . $id,
                    'type' => 'select',
                    'choices' => font_awesome_icons(),
                    'default' => null

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Link 3',
                    'setting' => 'btn3-option-link-' . $id,
                    'type' => 'text',
                    'default' => null

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Icon 4',
                    'setting' => 'btn4-option-icon-' . $id,
                    'type' => 'select',
                    'choices' => font_awesome_icons(),
                    'default' => 'check'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Link 4',
                    'setting' => 'btn4-option-link-' . $id,
                    'type' => 'text',
                    'default' => 'check'

                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'image_'.$id,
                    'label' => 'Display As',
                    'setting' => 'image-styles-display-as-' . $id,
                    'type' => 'radio-buttonset',
                    'default' => 'B',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Read more options

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Read more text',
                    'setting' => 'readmore-option-more-text-' . $id ,
                    'type' => 'text',
                    'default' => 'Read More'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Show Always',
                    'setting' => 'readmore-option-show-always-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'off'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'readmore-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Time since options

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before time text',
                    'setting' => 'time-option-time-before-' . $id,
                    'type' => 'text',
                    'default' => null
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Time format',
                    'setting' => 'time-option-time-format-' . $id,
                    'type' => 'Select',
                    'choices' => array(
                        'wordpress-default' => 'WordPress Default',
                        'g:i A' => date('g:i A'),
                        'g:i A T' => date('g:i A T'),
                        'g:i:s A' => date('g:i:s A'),
                        'G:i' => date('G:i'),
                        'G:i T' => date('G:i T')
                    ),
                    'default' => 'wordpress-default'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Show as Time Since',
                    'setting' => 'time-option-time-since-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'time-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'inline-block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Categories options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before categories text',
                    'setting' => 'categories-option-before-' . $id,
                    'type' => 'text',
                    'default' => null
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'categories-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'inline-block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Tags options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before tags text',
                    'setting' => 'tags-option-before-' . $id,
                    'type' => 'text',
                    'default' => null
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'tags-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'inline-block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Post Format options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before post format text',
                    'setting' => 'post-format-option-before-' . $id,
                    'type' => 'text',
                    'default' => null
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display format as',
                    'setting' => 'post-format-option-type-' . $id,
                    'type' => 'select',
                    'choices' => array(
                        'text' => 'Text',
                        'icon' => 'Icon'
                    ),
                    'default' => 'icon'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Icon Size',
                    'setting' => 'post-format-option-icon-size-' . $id,
                    'type' => 'text',
                    'default' => '32'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'post-format-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'inline-block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Author options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Link to author page?',
                    'setting' => 'author-option-linked-' .  $view_name . '',
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before author text',
                    'setting' => 'author-option-before-' . $id,
                    'type' => 'text',
                    'default' => ''
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'author-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'inline-block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Avatar options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Link to author page?',
                    'setting' => 'avatar-option-linked-' .  $view_name . '',
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before avatar text',
                    'setting' => 'avatar-option-before-' . $id,
                    'type' => 'text',
                    'default' => ''
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Avatar size',
                    'setting' => 'avatar-option-size-' . $id,
                    'type' => 'text',
                    'default' => 32
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'avatar-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'inline-block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //Comments Options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'If Several Comments',
                    'setting' => 'comments-option-comments-format-' . $id,
                    'type' => 'text',
                    'default' => '%num% Comments'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'If 1 Comment',
                    'setting' => 'comments-option-comments-format-1-' . $id,
                    'type' => 'text',
                    'default' => '%num% Comment'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'If no Comments',
                    'setting' => 'comments-option-comments-format-0-' . $id,
                    'type' => 'text',
                    'default' => '%num% Comments'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before comments text',
                    'setting' => 'comments-option-before-' . $id,
                    'type' => 'text',
                    'default' => ''
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'comments-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'inline-block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //share options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before share text',
                    'setting' => 'share-option-before-' . $id,
                    'type' => 'text',
                    'default' => 'Share this: '
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Twitter Icon',
                    'setting' => 'share-option-icon-twitter-heading-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '',
                    'setting' => 'share-option-icon-fa-twitter-' . $id,
                    'type' => 'select',
                    'default' => 'fa-twitter',
                    'choices' => array(
                        'hide' => 'None (Hide)',
                        'fa-twitter' => 'Twitter',
                        'fa-twitter-square' => 'Twitter Square'
                    ),
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'New Window',
                    'setting' => 'share-option-twitter-target-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Facebook Icon',
                    'setting' => 'share-option-icon-fa-facebook-heading-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '',
                    'setting' => 'share-option-icon-fa-facebook-' . $id,
                    'type' => 'select',
                    'default' => 'fa-facebook',
                    'choices' => array(
                        'hide' => 'None (Hide)',
                        'fa-facebook' => 'Facebook',
                        'fa-facebook-square' => 'Facebook Square'
                    ),
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'New Window',
                    'setting' => 'share-option-facebook-target-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Google Plus Icon',
                    'setting' => 'share-option-icon-fa-google-plus-heading-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '',
                    'setting' => 'share-option-icon-fa-google-plus-' . $id,
                    'type' => 'select',
                    'default' => 'fa-google-plus',
                    'choices' => array(
                        'hide' => 'None (Hide)',
                        'fa-google-plus' => 'Google Plus',
                        'fa-google-plus-square' => 'Google Plus Square'
                    ),
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'New Window',
                    'setting' => 'share-option-googleplus-target-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Linkedin Icon',
                    'setting' => 'share-option-icon-fa-linkedin-heading-' . $id,
                    'type' => 'heading-infinity'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => '',
                    'setting' => 'share-option-icon-fa-linkedin-' . $id,
                    'type' => 'select',
                    'default' => 'fa-linkedin',
                    'choices' => array(
                        'hide' => 'None (Hide)',
                        'fa-linkedin' => 'Linkedin',
                        'fa-linkedin-square' => 'Linkedin Square'
                    ),
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'New Window',
                    'setting' => 'share-option-linkedin-target-' . $id,
                    'type' => 'radio-buttonset',
                    'choices' => array(
                        'on' => 'Yes',
                        'off' => 'No'
                    ),
                    'default' => 'on'
                ) );

                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'share-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //likes options
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Before likes text',
                    'setting' => 'likes-option-before-' . $id,
                    'type' => 'text',
                    'default' => 'Likes: '
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Show like/unlike text',
                    'setting' => 'likes-option-show_like_text-' . $id,
                    'type' => 'radio-buttonset',
                        'choices' => array(
                            'show' => 'Show',
                            'hide' => 'Hide'
                        ),
                    'default' => 'show'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Display As',
                    'setting' => 'likes-styles-display-as-' . $id,
                    'type' => 'select',
                    'default' => 'block',
                    'choices' => array(
                        '' => 'None',
                        'block' => 'Block',
                        'inline' => 'Inline',
                        'inline-block' => 'Inline Block'
                    )
                ) );

                //custom fields
                $custom_fields_array = isset($options['custom-fields']) ? $options['custom-fields'] : '';

                if( is_array($custom_fields_array) )
                    foreach ($custom_fields_array as $position => $field_slug) {

                      Infinity_Kirki::add_field( 'infinity', array(
                        'section'  => 'PART_'.$id,
                        'label' => 'Before text',
                        'setting' => 'custom-field-'.$field_slug.'-option-before-' . $id,
                        'type' => 'text',
                        'default' => null
                      ) );

                      Infinity_Kirki::add_field( 'infinity', array(
            						  'section'  => 'PART_'.$id,
                          'label' => 'Display As',
                          'setting' => 'custom-field-'.$field_slug.'-styles-display-as-' . $id,
                          'type' => 'select',
                          'default' => 'block',
                          'choices' => array(
                              '' => 'None',
                              'block' => 'Block',
                              'inline' => 'Inline',
                              'inline-block' => 'Inline Block'
                          )
                      ) );

                }


                if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

                    //Woocommerce Price options
                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Before Price text',
                        'setting' => 'wc-price-option-before-' . $id,
                        'type' => 'text',
                        'default' => null
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Display As',
                        'setting' => 'wc-price-styles-display-as-' . $id,
                        'type' => 'select',
                        'default' => 'inline-block',
                        'choices' => array(
                            '' => 'None',
                            'block' => 'Block',
                            'inline' => 'Inline',
                            'inline-block' => 'Inline Block'
                        )
                    ) );

                    //Woocommerce Rating options
                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Show as stars',
                        'setting' => 'wc-rating-option-show-as-stars-' . $id,
                        'type' => 'radio-buttonset',
                        'choices' => array(
                            'on' => 'Yes',
                            'off' => 'No'
                        ),
                        'default' => 'on'
                    ) );
                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Show review count',
                        'setting' => 'wc-rating-option-show-review-count-' . $id,
                        'type' => 'radio-buttonset',
                        'choices' => array(
                            'on' => 'Yes',
                            'off' => 'No'
                        ),
                        'default' => 'off'
                    ) );
                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Before Rating text',
                        'setting' => 'wc-rating-option-before-' . $id,
                        'type' => 'text',
                        'default' => null
                    ) );
                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Display As',
                        'setting' => 'wc-rating-styles-display-as-' . $id,
                        'type' => 'select',
                        'default' => 'inline-block',
                        'choices' => array(
                            '' => 'None',
                            'block' => 'Block',
                            'inline' => 'Inline',
                            'inline-block' => 'Inline Block'
                        )
                    ) );

                    //Woocommerce Sale Flash
                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Before Sale Flash text',
                        'setting' => 'wc-sale-flash-option-before-' . $id,
                        'type' => 'text',
                        'default' => null
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'After Sale Flash text',
                        'setting' => 'wc-sale-flash-option-after-' . $id,
                        'type' => 'text',
                        'default' => null
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'On Sale Flash text',
                        'setting' => 'wc-sale-flash-option-text-' . $id,
                        'type' => 'text',
                        'default' => 'On Sale!'
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Show sale as percent',
                        'description' => 'Replaces on sale flash text',
                        'setting' => 'wc-sale-flash-option-as-percent-off-' . $id,
                        'type' => 'radio-buttonset',
                        'choices' => array(
                            'on' => 'Yes',
                            'off' => 'No'
                        ),
                        'default' => 'off'
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Display As',
                        'setting' => 'wc-sale-flash-styles-display-as-' . $id,
                        'type' => 'select',
                        'default' => 'inline-block',
                        'choices' => array(
                            '' => 'None',
                            'block' => 'Block',
                            'inline' => 'Inline',
                            'inline-block' => 'Inline Block'
                        )
                    ) );

                    //Woocommerce Add Cart options
                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Add to cart text',
                        'setting' => 'wc-add-to-cart-option-add-text-' . $id,
                        'type' => 'text',
                        'default' => 'Add to cart'
                    ) );

                    Infinity_Kirki::add_field( 'infinity', array(
          						  'section'  => 'PART_'.$id,
                        'label' => 'Display As',
                        'setting' => 'wc-add-to-cart-styles-display-as-' . $id,
                        'type' => 'select',
                        'default' => 'inline-block',
                        'choices' => array(
                            '' => 'None',
                            'block' => 'Block',
                            'inline' => 'Inline',
                            'inline-block' => 'Inline Block'
                        )
                    ) );

                } //end woocommerce check

                //Pagination and infinite scroll
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Next',
                    'setting' => 'pagination-next-page-text-' . $id,
                    'description' => 'Text for button that goes to next page.',
                    'type' => 'text',
                    'default' => '&rsaquo;'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Previous',
                    'setting' => 'pagination-prev-page-text-' . $id,
                    'type' => 'text',
                    'description' => 'Text for button that goes to the previous page.',
                    'default' => '&lsaquo;'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Last:',
                    'setting' => 'pagination-last-page-text-' . $id,
                    'description' => 'Text for button that goes to last page.',
                    'type' => 'text',
                    'default' => '&raquo;'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'First:',
                    'setting' => 'pagination-first-page-text-' . $id,
                    'type' => 'text',
                    'description' => 'Text for button that goes to first page.',
                    'default' => '&laquo;'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Pages:',
                    'setting' => 'pagination-pages-text-' . $id,
                    'type' => 'text',
                    'description' => 'Text that displays at the beginning of the pagination.',
                    'default' => 'Pages'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Align:',
                    'setting' => 'pagination-alignment-' . $id,
                    'type' => 'select',
                    'description' => 'Sets where to align the pagination if not using infinite.',
                    'choices' => array(
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right'
                    ),
                    'default' => 'center'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Range:',
                    'setting' => 'pagination-range-' . $id,
                    'description' => 'The number of page links to show before and after the current page.',
                    'type' => 'text',
                    'default' => '3'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Effect:',
                    'setting' => 'pagination-infinite-effect-' . $id,
                    'type' => 'select',
                    'description' => 'Only applies to masonry layouts. Sets the effect for new articles added to the page.',
                    'choices' => array(
                        'fade' => 'Fade In',
                        'flyin' => 'Fly In'
                    ),
                    'default' => 'fade'
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Infinite:',
                    'setting' => 'pagination-infinite-' . $id,
                    'description' => 'Infinite pagination will automatically fetch and load posts from other pages without the user needing to navigate to another page.',
                    'type' => 'checkbox',
                    'default' => false
                ) );
                Infinity_Kirki::add_field( 'infinity', array(
      						  'section'  => 'PART_'.$id,
                    'label' => 'Pagination:',
                    'setting' => 'pagination-show-' . $id,
                    'description' => 'Set whether to show post pagination or not.',
                    'type' => 'checkbox',
                    'default' => false
                ) );

            //} disabled view_widget_in_use

    endwhile;

    endif;

wp_reset_postdata();
}

add_action('wp_loaded', 'builder_options');

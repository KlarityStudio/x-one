<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Pro_Toggle_Blocks') && class_exists( 'Mega_Menu_Toggle_Blocks' ) ) :

/**
 * Mobile Toggle Blocks
 */
class Mega_Menu_Pro_Toggle_Blocks extends Mega_Menu_Toggle_Blocks {

    /**
     * Constructor
     *
     * @since 1.4
     */
    public function __construct() {

        // Generic
        add_filter( 'megamenu_load_scss_file_contents', array( $this, 'append_scss'), 10 );

        // Logo Block
        add_filter( 'megamenu_scss_variables', array( $this, 'logo_add_block_vars_to_scss'), 10, 5 );
        add_filter( 'megamenu_registered_toggle_blocks', array( $this, 'logo_add_as_available_block_option') );
        add_action( 'wp_ajax_mm_get_toggle_block_logo', array( $this, 'logo_output_block_admin' ) );
        add_action( 'megamenu_output_admin_toggle_block_logo', array( $this, 'logo_output_block_admin'), 10, 2 );
        add_filter( 'megamenu_output_public_toggle_block_logo', array( $this, 'logo_output_block_public'), 10, 2 );

        // Search Block
        add_filter( 'megamenu_scss_variables', array( $this, 'search_add_block_vars_to_scss'), 10, 5 );
        add_filter( 'megamenu_registered_toggle_blocks', array( $this, 'search_add_as_available_block_option') );
        add_action( 'wp_ajax_mm_get_toggle_block_search', array( $this, 'search_output_block_admin' ) );
        add_action( 'megamenu_output_admin_toggle_block_search', array( $this, 'search_output_block_admin'), 10, 2 );
        add_filter( 'megamenu_output_public_toggle_block_search', array( $this, 'search_output_block_public'), 10, 2 );

        // HTML Block
        add_filter( 'megamenu_registered_toggle_blocks', array( $this, 'html_add_as_available_block_option') );
        add_action( 'wp_ajax_mm_get_toggle_block_html', array( $this, 'html_output_block_admin' ) );
        add_action( 'megamenu_output_admin_toggle_block_html', array( $this, 'html_output_block_admin'), 10, 2 );
        add_filter( 'megamenu_output_public_toggle_block_html', array( $this, 'html_output_block_public'), 10, 2 );

        // Icon Block
        add_filter( 'megamenu_scss_variables', array( $this, 'icon_add_block_vars_to_scss'), 10, 5 );
        add_filter( 'megamenu_registered_toggle_blocks', array( $this, 'icon_add_as_available_block_option') );
        add_action( 'wp_ajax_mm_get_toggle_block_icon', array( $this, 'icon_output_block_admin' ) );
        add_action( 'megamenu_output_admin_toggle_block_icon', array( $this, 'icon_output_block_admin'), 10, 2 );
        add_filter( 'megamenu_output_public_toggle_block_icon', array( $this, 'icon_output_block_public'), 10, 2 );

    }

    /**
     * Add "Logo" as a drop down option to the toggle block editor
     *
     * @since 1.4
     * @param array $options
     * @return array
     */
    public function logo_add_as_available_block_option( $options ) {
        $options['logo'] = __("Logo / Image", "megamenu_pro");

        return $options;

    }

    /**
     * Output the logo block HTML (front end)
     *
     * @since 1.4
     * @param string $html
     * @param array $settings
     * @return string
     */
    public function logo_output_block_public( $html, $settings ) {

        $logo_src = "";
        $logo_url = "";

        if ( isset( $settings['logo_id'] ) ) {
            $logo = wp_get_attachment_image_src( $settings['logo_id'], 'full' );
            $logo_src = $logo[0];
        }

        if ( isset( $settings['url'] ) ) {
            $logo_url = esc_url( $settings['url'] );
        }

        $html = "<a class='mega-menu-logo' href='{$logo_url}'><img class='mega-menu-logo' src='{$logo_src}' /></a>";

        return apply_filters("megamenu_toggle_block_logo_html", $html, $settings, $logo_url, $logo_src);

    }


    /**
     * Output the HTML for the "Menu Toggle" block settings
     *
     * @since 1.4
     * @param int $block_id
     * @param array $settings
     */
    public function logo_output_block_admin( $block_id, $settings = array() ) {

        if ( empty( $settings ) ) {
            $block_id = "0";
        }

        $defaults = array(
            "align" => "left",
            "logo_id" => 0,
            "url" => home_url(),
            "logo_src" => "",
            "vertical_offset" => "-1px",
            "max_height" => "100%"
        );

        $logo_src = "";

        $settings = array_merge( $defaults, $settings );

        if ( isset( $settings['logo_id'] ) && intval( $settings['logo_id'] ) > 0 ) {
            $logo = wp_get_attachment_image_src( intval( $settings['logo_id'] ), 'thumbnail' );
            $settings['logo_src'] = $logo[0];
        }

        ?>

        <div class='block'>
            <div class='block-title'><span title='<?php _e("Logo", "megamenupro"); ?>' class="dashicons dashicons-format-image"></span></div>
            <div class='block-settings'>
                <h3><?php _e("Logo Settings", "megamenupro") ?></h3>
                <input type='hidden' class='type' name='toggle_blocks[<?php echo $block_id; ?>][type]' value='logo' />
                <input type='hidden' class='align' name='toggle_blocks[<?php echo $block_id; ?>][align]' value='<?php echo $settings['align'] ?>'>
                <label>
                    <?php _e("Media File", "megamenupro") ?>

                    <div class='mmm_image_selector' data-src='<?php echo $settings['logo_src']; ?>' data-field='logo_id_<?php echo $block_id; ?>'></div>
                    <input type='hidden' id='logo_id_<?php echo $block_id; ?>' name='toggle_blocks[<?php echo $block_id; ?>][logo_id]' value='<?php echo $settings['logo_id']; ?>' />
                </label>
                <label>
                    <?php _e("URL", "megamenupro") ?>
                    <input type='text' class='logo_url' name='toggle_blocks[<?php echo $block_id; ?>][url]' value='<?php echo $settings['url'] ?>' />
                </label>
                <label>
                    <?php _e("Vertical Offset", "megamenupro") ?>
                    <input type='text' class='logo_vertical_offset' name='toggle_blocks[<?php echo $block_id; ?>][vertical_offset]' value='<?php echo $settings['vertical_offset'] ?>' />
                </label>
                <label>
                    <?php _e("Max Height", "megamenupro") ?>
                    <input type='text' class='logo_max_height' name='toggle_blocks[<?php echo $block_id; ?>][max_height]' value='<?php echo $settings['max_height'] ?>' />
                </label>
                <a class='mega-delete'><?php _e("Delete", "megamenupro"); ?></a>
            </div>
        </div>

        <?php
    }


    /**
     * Create a new variable containing the toggle blocks to be used by the SCSS file
     *
     * @param array $vars
     * @param string $location
     * @param string $theme
     * @param int $menu_id
     * @param string $theme_id
     * @return array - all custom SCSS vars
     * @since 1.4
     */
    public function logo_add_block_vars_to_scss( $vars, $location, $theme, $menu_id, $theme_id ) {

        $toggle_blocks = $this->get_toggle_blocks_for_theme( $theme_id );

        $logo_blocks = array();

        if ( is_array( $toggle_blocks ) ) {

            foreach( $toggle_blocks as $index => $settings ) {

                if ( isset( $settings['type'] ) && $settings['type'] == 'logo' ) {

                    $logo_src = "";

                    if ( isset( $settings['logo_id'] ) ) {
                        $logo = wp_get_attachment_image_src( $settings['logo_id'], 'thumbnail' );
                        $logo_src = $logo[0];
                    }

                    $styles = array(
                        'id' => $index,
                        'logo_id' => isset($settings['logo_id']) ? "'" . $settings['logo_id'] . "'" : "0",
                        'logo_src' => "'" . $logo_src . "'",
                        'logo_url' => isset($settings['url']) ? "'" . $settings['url'] . "'" : "''",
                        'logo_vertical_offset' => isset($settings['vertical_offset']) ? $settings['vertical_offset'] : "-1px",
                        'logo_max_height' => isset($settings['max_height']) ? $settings['max_height'] : "100%",
                    );

                    $logo_blocks[ $index ] = $styles;
                }

            }
        }

        //$menu_toggle_blocks(
        // (123, red, 150px),
        // (456, green, null),
        // (789, blue, 90%),());
        if ( count( $logo_blocks ) ) {

            $list = "(";

            foreach ( $logo_blocks as $id => $vals ) {
                $list .= "(" . implode( ",", $vals ) . "),";
            }

            // Always add an empty list item to meke sure there are always at least 2 items in the list
            // Lists with a single item are not treated the same way by SASS
            $list .= "());";

            $vars['logo_blocks'] = $list;

        } else {

            $vars['logo_blocks'] = "()";

        }

        return $vars;
    }





    /**
     * Add "Search" as a drop down option to the toggle block editor
     *
     * @since 1.4
     * @param array $options
     * @return array
     */
    public function search_add_as_available_block_option( $options ) {
        $options['search'] = __("Search", "megamenu_pro");

        return $options;

    }


    /**
     * Return the default settings for a search block
     *
     * @since 1.4
     * @return array
     */
    private function get_search_block_defaults() {

        $defaults = array(
            "align" => "left",
            "search_type" => 'expand_to_right',
            "height" => '25px',
            "text_color" => '#333',
            "icon_color_closed" => '#fff',
            "icon_color_open" => '#333',
            "background_color_closed" => 'transparent',
            "background_color_open" => '#fff',
            "border_radius" => '2px',
            "placeholder_text" => 'Search'
        );

        return $defaults;
    }


    /**
     * Output the search block HTML (front end)
     *
     * @since 1.4
     * @param string $html
     * @param array $settings
     * @return string
     */
    public function search_output_block_public( $html, $settings ) {

        $defaults = $this->get_search_block_defaults();

        $settings = array_merge( $defaults, $settings );

        $name = apply_filters("megamenu_search_var", "s");
        $action = apply_filters("megamenu_search_action", trailingslashit( home_url() ) );

        if ( $settings['search_type'] == 'expand_to_left' ) {
            $html = "<div class='mega-search-wrap'><form class='mega-search expand-to-left mega-search-closed' action='" . $action . "'>
                        <span class='dashicons dashicons-search search-icon'></span>
                        <input type='submit' value='" . __( "Search" , "megamenupro" ) . "'>
                        <input type='text' data-placeholder='{$settings['placeholder_text']}' name='{$name}'>
                    </form></div>";
        }

        if ( $settings['search_type'] == 'expand_to_right' ) {
            $html = "<div class='mega-search-wrap'><form class='mega-search expand-to-right mega-search-closed' action='" .  $action . "'>
                        <span class='dashicons dashicons-search search-icon'></span>
                        <input type='submit' value='" . __( "Search" , "megamenupro" ) . "'>
                        <input type='text' data-placeholder='{$settings['placeholder_text']}' name='{$name}'>
                    </form></div>";
        }

        if ( $settings['search_type'] == 'static' ) {
            $html = "<div class='mega-search-wrap'><form class='mega-search static mega-search-open' action='" . $action . "'>
                        <span class='dashicons dashicons-search search-icon'></span>
                        <input type='submit' value='" . __( "Search" , "megamenupro" ) . "'>
                        <input type='text' placeholder='{$settings['placeholder_text']}' name='{$name}'>
                    </form></div>";
        }

        return $html;

    }


    /**
     * Output the HTML for the "Search" block settings
     *
     * @since 1.4
     * @param int $block_id
     * @param array $settings
     */
    public function search_output_block_admin( $block_id, $settings = array() ) {

        if ( empty( $settings ) ) {
            $block_id = "0";
        }

        $defaults = $this->get_search_block_defaults();

        $settings = array_merge( $defaults, $settings );

        ?>

        <div class='block'>
            <div class='block-title'><span title='<?php _e("Search", "megamenupro"); ?>' class="dashicons dashicons-search"></span></div>
            <div class='block-settings'>
                <h3><?php _e("Search Settings", "megamenupro") ?></h3>
                <input type='hidden' class='type' name='toggle_blocks[<?php echo $block_id; ?>][type]' value='search' />
                <input type='hidden' class='align' name='toggle_blocks[<?php echo $block_id; ?>][align]' value='<?php echo $settings['align'] ?>'>

                <label>
                    <?php _e("Style", "megamenupro") ?>

                    <select name='toggle_blocks[<?php echo $block_id; ?>][search_type]'>
                        <option value='expand_to_left' <?php selected( $settings['search_type'], 'expand_to_left' ); ?>><?php _e("Expand to Left", "megamenupro") ?></option>
                        <option value='expand_to_right' <?php selected( $settings['search_type'], 'expand_to_right' ); ?>><?php _e("Expand to Right", "megamenupro") ?></option>
                        <option value='static' <?php selected( $settings['search_type'], 'static' ); ?>><?php _e("Static", "megamenupro") ?></option>
                    </select>
                </label>
                <label>
                    <?php _e("Height", "megamenupro") ?>
                    <input type='text' name='toggle_blocks[<?php echo $block_id; ?>][height]' value='<?php echo $settings['height']; ?>' />
                </label>
                <label>
                    <?php _e("Text Color", "megamenupro") ?>
                    <?php $this->print_toggle_color_option( 'text_color', $block_id, $settings['text_color'] ); ?>
                </label>
                <label>
                    <?php _e("Icon Color (Closed)", "megamenupro") ?>
                    <?php $this->print_toggle_color_option( 'icon_color_closed', $block_id, $settings['icon_color_closed'] ); ?>
                </label>
                <label>
                    <?php _e("Icon Color (Open)", "megamenupro") ?>
                    <?php $this->print_toggle_color_option( 'icon_color_open', $block_id, $settings['icon_color_open'] ); ?>
                </label>
                <label>
                    <?php _e("Background Color (Closed)", "megamenupro") ?>
                    <?php $this->print_toggle_color_option( 'background_color_closed', $block_id, $settings['background_color_closed'] ); ?>
                </label>
                <label>
                    <?php _e("Background Color (Open)", "megamenupro") ?>
                    <?php $this->print_toggle_color_option( 'background_color_open', $block_id, $settings['background_color_open'] ); ?>
                </label>
                <label>
                    <?php _e("Border Radius", "megamenupro") ?>
                    <input type='text' name='toggle_blocks[<?php echo $block_id; ?>][border_radius]' value='<?php echo $settings['border_radius']; ?>' />
                </label>
                <label>
                    <?php _e("Placeholder Text", "megamenupro") ?>
                    <input type='text' name='toggle_blocks[<?php echo $block_id; ?>][placeholder_text]' value='<?php echo $settings['placeholder_text']; ?>' />
                </label>

                <a class='mega-delete'><?php _e("Delete", "megamenupro"); ?></a>
            </div>
        </div>

        <?php
    }


    /**
     * Create a new variable containing the toggle blocks to be used by the SCSS file
     *
     * @param array $vars
     * @param string $location
     * @param string $theme
     * @param int $menu_id
     * @param string $theme_id
     * @return array - all custom SCSS vars
     * @since 1.4
     */
    public function search_add_block_vars_to_scss( $vars, $location, $theme, $menu_id, $theme_id ) {

        $toggle_blocks = $this->get_toggle_blocks_for_theme( $theme_id );

        $search_blocks = array();

        $defaults = $this->get_search_block_defaults();

        if ( is_array( $toggle_blocks ) ) {

            foreach( $toggle_blocks as $index => $settings ) {

                if ( isset( $settings['type'] ) && $settings['type'] == 'search' ) {

                    $styles = array(
                        'id' => $index,
                        'search_height' => isset($settings['height']) ? $settings['height'] : $defaults['height'],
                        'search_text_color' => isset($settings['text_color']) ? $settings['text_color'] : $defaults['text_color'],
                        'search_icon_color_closed' => isset($settings['icon_color_closed']) ? $settings['icon_color_closed'] : $defaults['icon_color_closed'],
                        'search_icon_color_open' => isset($settings['icon_color_open']) ? $settings['icon_color_open'] : $defaults['icon_color_open'],
                        'search_background_color_closed' => isset($settings['background_color_closed']) ? $settings['background_color_closed'] : $defaults['background_color_closed'],
                        'search_background_color_open' => isset($settings['background_color_open']) ? $settings['background_color_open'] : $defaults['background_color_open'],
                        'search_border_radius' => isset($settings['border_radius']) ? $settings['border_radius'] : $defaults['border_radius']
                    );

                    $search_blocks[ $index ] = $styles;
                }

            }
        }

        //$menu_toggle_blocks(
        // (123, red, 150px),
        // (456, green, null),
        // (789, blue, 90%),());
        if ( count( $search_blocks ) ) {

            $list = "(";

            foreach ( $search_blocks as $id => $vals ) {
                $list .= "(" . implode( ",", $vals ) . "),";
            }

            // Always add an empty list item to meke sure there are always at least 2 items in the list
            // Lists with a single item are not treated the same way by SASS
            $list .= "());";

            $vars['search_blocks'] = $list;

        } else {

            $vars['search_blocks'] = "()";

        }

        return $vars;
    }




    /**
     * Add "HTML" as a drop down option to the toggle block editor
     *
     * @since 1.4
     * @param array $options
     * @return array
     */
    public function html_add_as_available_block_option( $options ) {
        $options['html'] = __("HTML", "megamenu_pro");

        return $options;

    }


    /**
     * Output the HTML (front end)
     *
     * @since 1.4
     * @param string $html
     * @param array $settings
     * @return string
     */
    public function html_output_block_public( $html, $settings ) {

        return do_shortcode( wp_unslash( $settings['html'] ) );

    }


    /**
     * Output the HTML for the "HTML" block settings
     *
     * @since 1.4
     * @param int $block_id
     * @param array $settings
     */
    public function html_output_block_admin( $block_id, $settings = array() ) {

        if ( empty( $settings ) ) {
            $block_id = "0";
        }

        $defaults = array(
            'align' => 'left',
            'html' => ''
        );

        $settings = array_merge( $defaults, $settings );

        ?>

        <div class='block'>
            <div class='block-title'><span title='<?php _e("HTML", "megamenupro"); ?>' class="dashicons dashicons-media-code"></span></div>
            <div class='block-settings'>
                <h3><?php _e("HTML Settings", "megamenupro") ?></h3>
                <input type='hidden' class='type' name='toggle_blocks[<?php echo $block_id; ?>][type]' value='html' />
                <input type='hidden' class='align' name='toggle_blocks[<?php echo $block_id; ?>][align]' value='<?php echo $settings['align'] ?>'>

                <label>
                    <?php _e("HTML", "megamenupro") ?><br /><br />
                    <textarea name='toggle_blocks[<?php echo $block_id; ?>][html]'><?php echo esc_textarea( wp_unslash( $settings['html'] ) ) ?></textarea>
                </label>

                <a class='mega-delete'><?php _e("Delete", "megamenupro"); ?></a>
            </div>
        </div>

        <?php
    }


    /**
     * Create a new variable containing the toggle blocks to be used by the SCSS file
     *
     * @param array $vars
     * @param string $location
     * @param string $theme
     * @param int $menu_id
     * @param string $theme_id
     * @return array - all custom SCSS vars
     * @since 1.4
     */
    public function icon_add_block_vars_to_scss( $vars, $location, $theme, $menu_id, $theme_id ) {

        $toggle_blocks = $this->get_toggle_blocks_for_theme( $theme_id );

        $icon_blocks = array();

        if ( is_array( $toggle_blocks ) ) {

            foreach( $toggle_blocks as $index => $settings ) {

                if ( isset( $settings['type'] ) && $settings['type'] == 'icon' ) {

                    if ( isset( $settings['icon'] ) ) {
                        $icon_parts = explode( '-', $settings['icon'] );
                        $icon = end( $icon_parts );
                        $icon_type = reset( $icon_parts );

                        if ($icon_type == 'dash') {
                            $font = 'dashicons';
                        } else {
                            $font = 'fontawesome';
                        }
                    } else {
                        $icon = 'disabled';
                        $font = 'dashicons';
                    }

                    $styles = array(
                        'id' => $index,
                        'icon' => $icon != 'disabled' ? "'\\" . $icon  . "'" : "''",
                        'color' => isset($settings['color']) ? $settings['color'] : '#fff',
                        'font' => $font,
                        'size' => isset($settings['size']) ? $settings['size'] : '20px'
                    );

                    $icon_blocks[ $index ] = $styles;
                }

            }
        }

        //$menu_toggle_blocks(
        // (123, red, 150px),
        // (456, green, null),
        // (789, blue, 90%),());
        if ( count( $icon_blocks ) ) {

            $list = "(";

            foreach ( $icon_blocks as $id => $vals ) {
                $list .= "(" . implode( ",", $vals ) . "),";
            }

            // Always add an empty list item to meke sure there are always at least 2 items in the list
            // Lists with a single item are not treated the same way by SASS
            $list .= "());";

            $vars['icon_blocks'] = $list;

        } else {

            $vars['icon_blocks'] = "()";

        }

        return $vars;
    }




    /**
     * Add "Icon" as a drop down option to the toggle block editor
     *
     * @since 1.4
     * @param array $options
     * @return array
     */
    public function icon_add_as_available_block_option( $options ) {
        $options['icon'] = __("Icon", "megamenu_pro");

        return $options;

    }


    /**
     * Output the icon (front end)
     *
     * @since 1.4
     * @param string $html
     * @param array $settings
     * @return string
     */
    public function icon_output_block_public( $html, $settings ) {

        return '<a class="mega-icon" href="' . esc_attr( $settings['url'] ) .  '"></a>';

    }


    /**
     * Output the HTML for the "Icon" block settings
     *
     * @since 1.4
     * @param int $block_id
     * @param array $settings
     */
    public function icon_output_block_admin( $block_id, $settings = array() ) {

        if ( empty( $settings ) ) {
            $block_id = "0";
        }

        $defaults = array(
            'align' => 'left',
            'icon' => 'dash-f319',
            'color' => '#fff',
            'url' => '',
            'size' => '20px'
        );

        $settings = array_merge( $defaults, $settings );

        $icon_class = 'dashicon-admin-site';
        $icons = array();

        if ( class_exists( 'Mega_Menu_Menu_Item_Manager') && method_exists( 'Mega_Menu_Menu_Item_Manager', 'all_icons' ) ) {
            $menu_item_manager = new Mega_Menu_Menu_Item_Manager();
            $icons = $menu_item_manager->all_icons();
        }

        if ( class_exists( 'Mega_Menu_Font_Awesome') && method_exists( 'Mega_Menu_Font_Awesome', 'icons' ) ) {
            $fontawesome = new Mega_Menu_Font_Awesome();
            $fa_icons = $fontawesome->icons();
            $icons = array_merge($icons, $fa_icons);

        }

        if ( isset( $icons[$settings['icon']] ) ) {
            $icon_class = $icons[$settings['icon']];

            $icon_type = explode('-', $icon_class);
        }

        ?>

        <div class='block'>
            <div class='block-title'><span title='<?php _e("Icon", "megamenupro"); ?>' class="<?php echo $icon_type[0] ?> <?php echo $icon_class; ?>"></span></div>
            <div class='block-settings'>
                <h3><?php _e("Icon Settings", "megamenupro") ?></h3>
                <input type='hidden' class='type' name='toggle_blocks[<?php echo $block_id; ?>][type]' value='icon' />
                <input type='hidden' class='align' name='toggle_blocks[<?php echo $block_id; ?>][align]' value='<?php echo $settings['align'] ?>'>

                <label>
                    <?php _e("Icon", "megamenupro") ?>
                    <?php $this->print_icon_option( 'icon', $block_id, $settings['icon'], $icons ); ?>
                </label>
                <label>
                    <?php _e("Color", "megamenupro") ?>
                    <?php $this->print_toggle_color_option( 'color', $block_id, $settings['color'] ); ?>
                </label>
                <label>
                    <?php _e("URL", "megamenupro") ?>
                    <input type='text' name='toggle_blocks[<?php echo $block_id; ?>][url]' value='<?php echo $settings['url']; ?>' />
                </label>
                <label>
                    <?php _e("Size", "megamenupro") ?>
                    <input type='text' name='toggle_blocks[<?php echo $block_id; ?>][size]' value='<?php echo $settings['size']; ?>' />
                </label>

                <a class='mega-delete'><?php _e("Delete", "megamenupro"); ?></a>
            </div>
        </div>

        <?php
    }


    /**
     * Return the saved toggle blocks for a specified theme
     *
     * @param string $theme_id
     * @since 1.4
     * @return array
     */
    private function get_toggle_blocks_for_theme( $theme_id ) {

        $blocks = get_site_option( "megamenu_toggle_blocks" );

        if ( isset( $blocks[ $theme_id ] ) ) {
            return $blocks[ $theme_id ];
        }

        return false;

    }


    /**
     * Append the logo SCSS to the main SCSS file
     *
     * @since 1.4
     * @param string $scss
     * @param string
     */
    public function append_scss( $scss ) {

        $path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'scss/toggle-blocks.scss';

        $contents = file_get_contents( $path );

        return $scss . $contents;

    }

}

endif;
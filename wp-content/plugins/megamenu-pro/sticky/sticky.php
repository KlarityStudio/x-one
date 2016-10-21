<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Sticky') ) :

/**
 *
 */
class Mega_Menu_Sticky {


	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

        add_filter( 'megamenu_wrap_attributes', array( $this, 'add_sticky_attribute' ), 10, 5 );
		add_filter( 'megamenu_scss_variables', array( $this, 'add_sticky_scss_vars'), 10, 4 );
		add_filter( 'megamenu_load_scss_file_contents', array( $this, 'append_sticky_scss'), 10 );
        add_action( 'megamenu_settings_table', array( $this, 'add_sticky_setting'), 20, 2);

	}


    /**
     * Add Orientation setting to menu options
     *
     * @since 1.1
     * @param string $location
     * @param array $settings
     */
    public function add_sticky_setting( $location, $settings ) {
        ?>
            </table>
            <table class='sticky_settings'>
                <tr>
                    <td>
                        <?php _e("Sticky", "megamenupro"); ?>
                    </td>
                    <td>
                        <input type='checkbox' class='megamenu_sticky_enabled' name='megamenu_meta[<?php echo $location ?>][sticky_enabled]' value='true' <?php checked( $this->get_sticky_setting($settings, $location, 'sticky_enabled') == 'true' ); ?> />
                    </td>
                </tr>

                <?php
                    if ( $this->get_sticky_setting($settings, $location, 'sticky_enabled') == 'true' ) {
                        $display = 'table-row';
                    } else {
                        $display = 'none';
                    }
                ?>

                <tr class='megamenu_sticky_behaviour' style='display: <?php echo $display; ?>;'>
                    <td>
                        <?php _e("Sticky On Mobile?", "megamenupro"); ?><i class='mmm_tooltip dashicons dashicons-info' title="<?php _e("IMPORTANT: Only set this to 'Yes' if your menu is small enough to fully fit on the screen without completely covering the page content. Default: Off.", "megamenupro"); ?>"></i>
                        </div>
                    </td>
                    <td>
                        <select name='megamenu_meta[<?php echo $location; ?>][sticky_mobile]'>
                            <option value='true' <?php selected('true', $this->get_sticky_setting($settings, $location, 'sticky_mobile') ) ?>><?php _e("Yes", "megamenupro"); ?></option>
                            <option value='false' <?php selected('false', $this->get_sticky_setting($settings, $location, 'sticky_mobile') ) ?>><?php _e("No", "megamenupro"); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class='megamenu_sticky_behaviour' style='display: <?php echo $display; ?>;'>
                    <td class='mega-name'>
                        <?php _e("Sticky Opacity", "megamenupro"); ?><i class='mmm_tooltip dashicons dashicons-info' title='<?php _e("Set the transparency of the menu when sticky (values 0.2 - 1.0). Default: 0.9.", "megamenupro"); ?>'></i>
                    </td>
                    <td>
                        <input type='number' step='0.1' min='0.2' max='1' name='megamenu_meta[<?php echo $location; ?>][sticky_opacity]' value='<?php echo $this->get_sticky_setting($settings, $location, 'sticky_opacity'); ?>' />
                    </td>
                </tr>
                <tr class='megamenu_sticky_behaviour' style='display: <?php echo $display; ?>;'>
                    <td>
                        <?php _e("Sticky Offset", "megamenupro"); ?><i class='mmm_tooltip dashicons dashicons-info' title='<?php _e("Set the distance between top of window and top of menu when the menu is stuck. Default: 0.", "megamenupro"); ?>'></i>
                    </td>
                    <td>
                        <input type='number' name='megamenu_meta[<?php echo $location; ?>][sticky_offset]' value='<?php echo $this->get_sticky_setting($settings, $location, 'sticky_offset'); ?>' /><span class='mega-after'>px</span>
                    </td>
                </tr>
                <tr class='megamenu_sticky_behaviour' style='display: <?php echo $display; ?>;'>
                    <td>
                        <?php _e("Expand Background", "megamenupro"); ?>
                    </td>
                    <td>
                        <select name='megamenu_meta[<?php echo $location; ?>][sticky_expand]'>
                            <option value='true' <?php selected('true', $this->get_sticky_setting($settings, $location, 'sticky_expand') ) ?>><?php _e("Yes", "megamenupro"); ?></option>
                            <option value='false' <?php selected('false', $this->get_sticky_setting($settings, $location, 'sticky_expand') ) ?>><?php _e("No", "megamenupro"); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
            <table>

        <?php

    }


	/**
	 *
	 */
	public function add_sticky_scss_vars( $vars, $location, $theme, $menu_id ) {

		$settings = get_option('megamenu_settings');

		$opacity = $this->get_sticky_setting( $settings, $location, 'sticky_opacity');

		$vars['sticky_menu_opacity'] = $opacity;

        $expand = $this->get_sticky_setting( $settings, $location, 'sticky_expand');

        $vars['sticky_menu_expand'] = $expand;

		return $vars;

	}


	/**
	 * Add the sticky CSS to the main SCSS file
	 *
	 * @since 1.0
	 * @param string $scss
	 * @return string
	 */
	public function append_sticky_scss( $scss ) {

		$path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'scss/sticky.scss';

		$contents = file_get_contents( $path );

 		return $scss . $contents;

	}


	/**
	 * Add the sticky related attributes to the menu wrapper
	 */
	public function add_sticky_attribute( $attributes, $menu_id, $menu_settings, $settings, $current_theme_location ) {

        if ( $this->get_sticky_setting( $settings, $current_theme_location, 'sticky_enabled') == 'true' ) {
            $attributes['data-sticky-enabled'] = 'true';
            $attributes['data-sticky-mobile'] = $this->get_sticky_setting( $settings, $current_theme_location, 'sticky_mobile' );
            $attributes['data-sticky-offset'] = $this->get_sticky_setting( $settings, $current_theme_location, 'sticky_offset' );
        }

		return $attributes;
	}



    /**
     * Return a setting, taking into account backwards compatibility (when it was only possible to make a single location sticky)
     * @since 1.4.6
     */
    private function get_sticky_setting( $saved_settings, $location, $setting ) {

        if ( isset( $saved_settings[$location][$setting] ) ) {
            return $saved_settings[$location][$setting];
        }

        // backwards compatibility from this point onwards
        if ( isset($saved_settings['sticky']['location']) && $setting == 'sticky_enabled' && $location == $saved_settings['sticky']['location'] ) {
            return "true";
        }

        $old_setting_name = substr($setting, 7);

        if ( isset( $saved_settings['sticky'][$old_setting_name]) && $location == $saved_settings['sticky']['location'] ) {
            return $saved_settings['sticky'][$old_setting_name];
        }

        // defaults
        $defaults = array(
            'sticky_location' => 'false',
            'sticky_opacity' => '0.9',
            'sticky_mobile' => 'false',
            'sticky_offset' => '0',
            'sticky_expand' => 'true'
        );


        if ( isset( $defaults[$setting] ) ) {
            return $defaults[$setting];
        }

        return 'false';
    }
}

endif;
<?php
/**
 * @class       AW_Install
 * @package     AutomateWoo
 * @since       1.0.0
 */

class AW_Install
{
	/**
	 * Database updates
	 * @var array
	 */
	private static $db_updates = array(
		'2.1.0' => 'automatewoo-update-2.1.0.php',
		'2.3' => 'automatewoo-update-2.3.php',
		'2.4' => 'automatewoo-update-2.4.php',
		'2.6' => 'automatewoo-update-2.6.php',
		'2.6.1' => 'automatewoo-update-2.6.1.php'
	);


	/**
	 * Init
	 */
	public static function init()
	{
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ), 5 );
		add_filter( 'plugin_action_links_' . AW()->plugin_basename, array( __CLASS__, 'plugin_action_links' ) );
	}



	/**
	 * Admin init
	 */
	public static function admin_init()
	{
		// check version
		if ( ! defined( 'IFRAME_REQUEST' ) && ( AW()->options()->version != AW()->version ) )
		{
			self::install();

			// check for required database update
			if ( self::database_upgrade_available() )
			{
				add_action( 'admin_notices', array( __CLASS__, 'data_upgrade_prompt') );
			}
			else
			{
				self::update_version();
			}
		}
	}



	/**
	 * Install
	 */
	public static function install()
	{
		self::create_tables();

		// Trigger action
		do_action( 'automatewoo_installed' );
	}


	/**
	 * @return bool
	 */
	static function database_upgrade_available()
	{
		if ( AW()->options()->version == AW()->version )
			return false;

		return AW()->options()->version && version_compare( AW()->options()->version, max( array_keys( self::$db_updates ) ), '<' );
	}


	/**
	 * Handle updates
	 */
	public static function update()
	{
		@ini_set( 'memory_limit', apply_filters( 'admin_memory_limit', WP_MAX_MEMORY_LIMIT ) );

		foreach ( self::$db_updates as $version => $updater )
		{
			if ( version_compare( AW()->options()->version, $version, '<' ) )
			{
				include( AW()->path( '/includes/updates/' . $updater ) );
			}
		}

		self::update_version();
	}


	/**
	 * Update version to current
	 */
	private static function update_version()
	{
		delete_option( 'automatewoo_version' );
		add_option( 'automatewoo_version', AW()->version );

		do_action( 'automatewoo_updated' );
	}



	/**
	 * Set up the database tables which the plugin needs to function.
	 */
	private static function create_tables()
	{
		global $wpdb;

		$wpdb->hide_errors();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( self::get_schema() );
	}


	/**
	 * Renders prompt notice for user to update
	 */
	static function data_upgrade_prompt()
	{
		AW()->admin->get_view( 'data-upgrade-prompt', [
			'plugin_name' => __( 'AutomateWoo', 'automatewoo' ),
			'plugin_slug' => AW()->plugin_slug
		]);
	}



	/**
	 * @return bool
	 */
	static function is_data_update_screen()
	{
		$screen = get_current_screen();
		return $screen->id === 'automatewoo_page_automatewoo-data-upgrade';
	}


	/**
	 * Show action links on the plugin screen.
	 *
	 * @param	mixed $links Plugin Action links
	 * @return	array
	 */
	public static function plugin_action_links( $links )
	{
		$action_links = array(
			'settings' => '<a href="' . AW()->admin->page_url( 'settings' ) . '" title="' . esc_attr( __( 'View AutomateWoo Settings', 'woocommerce' ) ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}


	/**
	 * Get Table schema
	 * @return string
	 */
	private static function get_schema()
	{
		global $wpdb;

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		return "
CREATE TABLE {$wpdb->prefix}automatewoo_guests (
  id bigint(20) NOT NULL auto_increment,
  email varchar(255) NOT NULL default '',
  tracking_key varchar(32) NOT NULL default '',
  created datetime NULL,
  last_active datetime NULL,
  language varchar(10) NOT NULL default '',
  PRIMARY KEY  (id)
) $collate;
CREATE TABLE {$wpdb->prefix}automatewoo_abandoned_carts (
  id bigint(20) NOT NULL auto_increment,
  user_id bigint(20) NOT NULL default 0,
  guest_id bigint(20) NOT NULL default 0,
  last_modified datetime NULL,
  items longtext NOT NULL default '',
  coupons longtext NOT NULL default '',
  total varchar(32) NOT NULL default '0',
  token varchar(32) NOT NULL default '',
  PRIMARY KEY  (id)
) $collate;
CREATE TABLE {$wpdb->prefix}automatewoo_queue (
  id bigint(20) NOT NULL auto_increment,
  workflow_id bigint(20) NULL,
  date datetime NULL,
  data_items longtext NOT NULL default '',
  failed int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY  (id)
) $collate;
CREATE TABLE {$wpdb->prefix}automatewoo_logs (
  id bigint(20) NOT NULL auto_increment,
  workflow_id bigint(20) NULL,
  date datetime NULL,
  tracking_enabled int(1) NOT NULL DEFAULT 0,
  conversion_tracking_enabled int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY  (id)
) $collate;
CREATE TABLE {$wpdb->prefix}automatewoo_log_meta (
  meta_id bigint(20) NOT NULL auto_increment,
  log_id bigint(20) NULL,
  meta_key varchar(255) NULL,
  meta_value longtext NOT NULL default '',
  PRIMARY KEY  (meta_id)
) $collate;
CREATE TABLE {$wpdb->prefix}automatewoo_unsubscribes (
  id bigint(20) NOT NULL auto_increment,
  workflow_id bigint(20) NULL,
  user_id bigint(20) NOT NULL default 0,
  date datetime NULL,
  PRIMARY KEY  (id)
) $collate;
		";
	}

}

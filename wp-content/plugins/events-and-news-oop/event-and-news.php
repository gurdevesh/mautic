<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://snotrainfotech.com/
 * @since             1.0.0
 * @package           EventNews
 *
 * @wordpress-plugin
 * Plugin Name:       Events and News OOP
 * Plugin URI:        https://snotrainfotech.com/
 * Description:       Manage events and news
 * Version:           1.0.0
 * Author:            snotrainfotech
 * Author URI:        https://snotrainfotech.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Define constants.
 */
define( 'PLUGIN_NAME', 'EVENTNEWS' );
define( 'EVENTNEWS_VERSION', '1.0.0' );
define( 'EVENTNEWS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'EVENTNEWS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The core plugin class
 */
require EVENTNEWS_PLUGIN_DIR . 'includes/class-event-news.php';

/**
 * Begins execution of the plugin.
 */
if( ! function_exists('run_event_news') ) :

    function run_event_news() {
        $plugin = new Event_News();
        $plugin->initialize();
    }
    run_event_news();

endif;






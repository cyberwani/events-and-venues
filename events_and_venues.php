<?php
/*
Plugin Name: Events And Venues
Plugin URI: 
Description: 
Author: 
Version: 
Author URI: 
*/

register_activation_hook(__FILE__, 'events_and_venues_activate');
register_deactivation_hook(__FILE__, 'events_and_venues_deactivate');

function events_and_venues_activate() {
	require_once dirname(__FILE__).'/events_and_venues_loader.php';
	$loader = new EventsAndVenuesLoader();
	$loader->activate();
}

function events_and_venues_deactivate() {
	require_once dirname(__FILE__).'/events_and_venues_loader.php';
	$loader = new EventsAndVenuesLoader();
	$loader->deactivate();
}

add_action('init', 'register_events_and_venue_scripts');
function register_events_and_venue_scripts() {
	error_log('register_events_and_venue_scripts()');
    wp_register_script('ev-ui', plugins_url('ev-ui.js', __FILE__), array(), false, true);

    wp_localize_script('ev-ui', 'EVUIEnv', array(
        'tpl_dir' => plugins_url('/components/templates/', __FILE__),
        'theme_dir' => get_bloginfo('template_url')
    ));
}

// Load all of the php files in the components folder
$file_tmp = glob(dirname(__FILE__).'/components/*.php', GLOB_MARK | GLOB_NOSORT);
foreach ($file_tmp as $item){
    if (substr($item, -1) != DIRECTORY_SEPARATOR) {
        require_once($item);
    }
}

?>

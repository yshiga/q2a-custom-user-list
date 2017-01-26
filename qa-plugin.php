<?php

/*
    Plugin Name: Custom User List Plugin
    Plugin URI:
    Plugin Description: Provide a new user list page
    Plugin Version: 1.0
    Plugin Date: 2016-12-09
    Plugin Author: 38qa.net
    Plugin Author URI: http://38qa.net/
    Plugin License: GPLv2
    Plugin Minimum Question2Answer Version: 1.7
    Plugin Update Check URI:
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}

//Define global constants
@define( 'CUL_DIR', dirname( __FILE__ ) );
@define( 'CUL_FOLDER', basename( dirname( __FILE__ ) ) );
@define( 'CUL_TARGET_THEME_NAME', 'q2a-material-lite');
@define( 'CUL_RELATIVE_PATH', '../qa-plugin/'.CUL_FOLDER.'/');

// language file
qa_register_plugin_phrases('qa-custom-user-list-lang-*.php', 'cul_lang');
// layer
qa_register_plugin_layer('qa-custom-user-list-layer.php','Custom User List Layer');
qa_register_plugin_overrides('qa-custom-user-list-overrides.php');

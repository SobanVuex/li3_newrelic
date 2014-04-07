<?php

use lithium\core\Libraries;
use li3_newrelic\extensions\NewRelic;

if (!Libraries::get('NewRelic')) {
    if (!defined('COMPOSER_VENDOR_PATH')) {
        define('COMPOSER_VENDOR_PATH', dirname(LITHIUM_APP_PATH) . '/vendor');
    }

    Libraries::add('NewRelic', array(
        'bootstrap' => false,
        'path' => COMPOSER_VENDOR_PATH . '/sobanvuex/php-newrelic/src/NewRelic'
    ));
}

NewRelic::init(Libraries::get('li3_newrelic'));

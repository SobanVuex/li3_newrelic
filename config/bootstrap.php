<?php

use \lithium\core\Libraries;
use \li3_newrelic\extensions\NewRelic;

if (class_exists('\\NewRelic\\NewRelic')) {
    Libraries::add('NewRelic', [
        'bootstrap' => false,
        'path' => dirname(LITHIUM_APP_PATH) . '/vendor/sobanvuex/php-newrelic/src/NewRelic'
    ]);
}

NewRelic::init(Libraries::get('li3_newrelic'));

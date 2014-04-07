<?php

namespace li3_newrelic\extensions;

use lithium\action\Dispatcher;
use NewRelic\NewRelic as NewRelicAgent;

class NewRelic extends \lithium\core\StaticObject
{

    /**
     * @param  array $options
     * @return void
     */
    public static function init(array $options = array())
    {
        $options += array(
            'app_name' => defined('APP_NAME') ? APP_NAME : null,
            'license' => null,
            'filter' => true
        );

        if ($options['filter']) {
            Dispatcher::applyFilter('_callable', static::filter());
        }

        if ($options['app_name']) {
            if ($options['license']) {
                NewRelicAgent::getInstance()->setAppname($options['app_name'], $options['license']);
            } else {
                NewRelicAgent::getInstance()->setAppname($options['app_name']);
            }
        }
    }

    /**
     * @return \Closure
     */
    public static function filter()
    {
        $filter = function($self, $params, $chain) {
            $callable = $chain->next($self, $params, $chain);

            $name = get_class($callable);
            $class = substr($name, strrpos($name, '\\') + 1);
            $action = ucfirst($params['request']->params['action']);
            $controller = ucfirst(preg_replace('/Controller$/', '', $class));
            NewRelicAgent::getInstance()->nameTransaction($controller . '/' . $action);

            return $callable;
        };

        return $filter;
    }

}

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
            Dispatcher::applyFilter('_callable', static::filter($options['filter']));
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
     * @param  boolean|string $ransaction
     * @return \Closure
     */
    public static function filter($ransaction = true)
    {
        return function($self, $params, $chain) use ($ransaction) {
            $callable = $chain->next($self, $params, $chain);

            if ($transaction === 'url') {
                $transaction = $params['request']->url;
            } elseif ($transaction) {
                $name = get_class($callable);
                $class = substr($name, strrpos($name, '\\') + 1);
                $transaction = preg_replace('/Controller$/', '', $class) . '/' . $params['request']->params['action'];
            } else {
                return $callable;
            }

            NewRelicAgent::getInstance()->nameTransaction($transaction);

            return $callable;
        };
    }

}

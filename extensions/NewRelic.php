<?php

namespace li3_newrelic\extensions;

use \lithium\action\Dispatcher;
use \NewRelic\NewRelic as NewRelicAgent;

class NewRelic
{

    /**
     * Initialize the extension with provided conifugration
     *
     * @param  array $options
     * @return void
     */
    public static function init(array $options = [])
    {
        $options += [
            'app_name' => defined('APP_NAME') ? APP_NAME : null,
            'license' => null,
            'filter' => true
        ];

        if ($options['filter']) {
            Dispatcher::applyFilter('_callable', static::filter($options['filter']));
        }

        if ($options['app_name']) {
            if ($options['license']) {
                NewRelicAgent::setAppname($options['app_name'], $options['license']);
            } else {
                NewRelicAgent::setAppname($options['app_name']);
            }
        }
    }

    /**
     * Filter function for recording transaction name
     *
     * @param  boolean|string $transaction
     * @return \Closure
     */
    public static function filter($transaction = true)
    {
        return function($self, $params, $chain) use ($transaction) {
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

            NewRelicAgent::nameTransaction($transaction);

            return $callable;
        };
    }

}

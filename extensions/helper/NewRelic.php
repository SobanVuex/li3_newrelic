<?php

namespace li3_newrelic\extensions\helper;

use NewRelic\NewRelic as NewRelicAgent;

class NewRelic extends \lithium\template\Helper
{

    /**
     * @param  boolean $tag
     * @return string
     */
    public function header($tag = true)
    {
        return NewRelicAgent::getInstance()->getBrowserTimingHeader($tag);
    }

    /**
     * @param  boolean $tag
     * @return string
     */
    public function footer($tag = true)
    {
        return NewRelicAgent::getInstance()->getBrowserTimingFooter($tag);
    }

    /**
     * @return \NewRelic\NewRelic
     */
    public function agent()
    {
        return NewRelicAgent::getInstance();
    }

}

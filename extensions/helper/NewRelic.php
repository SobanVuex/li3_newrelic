<?php

namespace li3_newrelic\extensions\helper;

use \NewRelic\NewRelic as NewRelicAgent;

class NewRelic extends \lithium\template\Helper
{

    /**
     * Get the RUM header JavaScript string
     *
     * @param  boolean $tag False to omit <script></script> tags. Defaults to True
     * @return string
     */
    public function header($tag = true)
    {
        return NewRelicAgent::getBrowserTimingHeader($tag);
    }

    /**
     * Get the RUM footer JavaScript string
     *
     * @param  boolean $tag False to omit <script></script> tags. Defaults to True
     * @return string
     */
    public function footer($tag = true)
    {
        return NewRelicAgent::getBrowserTimingFooter($tag);
    }

    /**
     * Get the New Relic agent instance
     *
     * @return \NewRelic\NewRelic
     */
    public function instance()
    {
        return NewRelicAgent::getInstance();
    }

}

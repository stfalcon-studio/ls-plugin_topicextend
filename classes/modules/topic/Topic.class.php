<?php

/* ---------------------------------------------------------------------------
 * @Plugin Name: Topic Extend
 * @Plugin Id: topic extend
 * @Plugin URI:
 * @Description: Add some improvements to the topic module
 * @Author: stfalcon-studio
 * @Author URI: http://stfalcon.com
 * @LiveStreet Version: 0.4.2
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * ----------------------------------------------------------------------------
 */

class PluginTopicextend_ModuleTopic extends PluginTopicextend_Inherit_ModuleTopic
{

    public function UpdateTopicContent($oTopic) {
        return $this->oMapperTopic->UpdateTopicContent($oTopic);
    }

}
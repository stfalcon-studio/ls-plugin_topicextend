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

class PluginTopicextend extends Plugin
{

    /**
     * Указанные в массивы наследования будут переданы движку автоматически
     * перед инициализацией плагина
     */
    public $aInherits = array(
        'action' => array(
            'ActionTopic' => '_ActionTopic',
            'ActionTag' => '_ActionTag'
        ),
        'module' => array(
            'ModuleTopic' => '_ModuleTopic',
        ),
    );

    /**
     * Активация плагина
     *
     * @return boolean
     */
    public function Activate() {
        return true;
    }

    /**
     * Инициализация плагина
     *
     * @return void
     */
    public function Init() {

    }

    /**
     * Деактивация плагина
     *
     * @return boolean
     */
    public function Deactivate() {
        return true;
    }

}
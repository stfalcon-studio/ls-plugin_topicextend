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

class PluginTopicextend_ActionTopic extends PluginAddtopic_Inherit_ActionTopic
{

    /**
     * Инициализация
     *
     * @return unknown
     */
    public function Init() {
        /**
         * Проверяем авторизован ли юзер
         */
        if (!$this->User_IsAuthorization()) {
            $this->Message_AddNoticeSingle($this->Lang_Get('autorize_to_enter'));
            return Router::Action('login');
        }

        parent::Init();
    }

}
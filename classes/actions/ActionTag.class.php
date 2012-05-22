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

class PluginTopicextend_ActionTag extends PluginTopicextend_Inherit_ActionTag
{

    protected function EventTags() {
        /**
         * Получаем тег из УРЛа
         */
        $sTag = urldecode($this->sCurrentEvent);
        /**
         * Передан ли номер страницы
         */
        $iPage = $this->GetParamEventMatch(0, 2) ? $this->GetParamEventMatch(0, 2) : 1;
        /**
         * Получаем список топиков
         */
        $aResult = $this->Topic_GetTopicsByTag($sTag, $iPage, Config::Get('module.topic.per_page'));
        $aTopics = $aResult['collection'];
        /**
         * Формируем постраничность
         */
        $aPaging = $this->Viewer_MakePaging($aResult['count'], $iPage, Config::Get('module.topic.per_page'), 4, Router::GetPath('tag') . htmlspecialchars($sTag));
        /**
         * Загружаем переменные в шаблон
         */
        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('aTopics', $aTopics);
        $this->Viewer_Assign('sTag', $sTag);


        require_once Config::Get('path.root.engine') . '/modules/viewer/plugs/modifier.declension.php';
        require_once Plugin::GetPath(__CLASS__) . 'engine/modules/viewer/plugs/modifier.declension.php';
        $plural = smarty_modifier_declension($aResult['count'], $this->Lang_Get('tag_result'), Config::Get('lang.current'));

        $sTaghtml = mb_strtoupper(mb_substr($sTag, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($sTag, 1, mb_strlen($sTag), 'UTF-8');
        $this->Viewer_AddHtmlTitle($sTaghtml . ': ' . $aResult['count'] . ' ' . $plural . ' / ' . $this->Lang_Get('tag_title'));
        $this->Viewer_SetHtmlRssAlternate(Router::GetPath('rss') . 'tag/' . $sTag . '/', $sTag);
        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('index');
    }

}
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

class PluginTopicextend_HookTopicextend extends Hook
{

    /**
     * Регистрация хуков
     */
    public function RegisterHook() {
        if (Config::Get('plugin.topicextend.add_button_to_mainmenu')) {
            $this->AddHook('template_main_menu', 'Menu', __CLASS__, -100);
        }

        if (Config::Get('plugin.topicextend.add_image_size')) {
            $this->AddHook('module_image_buildhtml_after', 'BuildHtml', __CLASS__);
        }

        if (Config::Get('plugin.topicextend.add_misclick_protection')) {
            $this->AddHook('topic_add_show', 'AddMisClick', __CLASS__);
            $this->AddHook('topic_edit_show', 'AddMisClick', __CLASS__);
        }

        if (Config::Get('plugin.topicextend.add_image_alt')) {
            $this->AddHook('topic_add_after', 'AddImageAlt', __CLASS__);
            $this->AddHook('topic_edit_after', 'AddImageAlt', __CLASS__);
        }

        if (Config::Get('path.img.web')) {
            $this->AddHook('module_image_getwebpath_before', 'ChangeImageWebPath', __CLASS__);
            $this->AddHook('module_image_getwebpath_after', 'RestoreImageWebPath', __CLASS__);
        }

        $this->AddHook('topic_add_after', 'AssignLink', __CLASS__, -100);
        $this->AddHook('topic_edit_after', 'AssignLink', __CLASS__, -100);
    }

    /**
     * Добавляет кнопку в основное меню
     *
     * @return type
     */
    public function Menu() {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'main_menu.tpl');
    }

    /**
     *
     * @param type $aData
     */
    public function BuildHtml(&$aData) {
        extract($aData);
        if ($aParams = getimagesize($params[0])) {
            $sSize = (string) $aParams[3];
            $aData['result'] = str_replace('/>', $sSize . ' />', $result);
        }
    }

    /**
     *
     * @param type $aData
     */
    public function ChangeImageWebPath($aData) {
        Config::Set('path.root.web_temp', Config::Get('path.root.web'));
        Config::Set('path.root.web', Config::Get('path.img.web'));
    }

    /**
     *
     * @param type $aData
     */
    public function RestoreImageWebPath($aData) {
        Config::Set('path.root.web', Config::Get('path.root.web_temp'));
    }

    /**
     * Добавляет JS скрипт плагина
     *
     */
    public function AddMisClick() {
        $this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__) . 'js/misclick.js');
    }

    /**
     * Добавляет атрибут альтернативного текста в тэг изображения
     *
     * @param type $aVars
     */
    public function AddImageAlt($aVars) {
        if (isset($aVars['oTopic'])) {
            $oTopic = $aVars['oTopic'];
            $oTopic = $this->Topic_GetTopicById($oTopic->getId());
            $sTitle = $oTopic->getTitle();
            while (preg_match('/"/', $sTitle)) {
                $sTitle = preg_replace('/"/', '«', $sTitle, 1);
                $sTitle = preg_replace('/"/', '»', $sTitle, 1);
            }
            $sInsert = 'alt="' . $sTitle . '" title="' . $sTitle . '"';
            if ($sText = $this->_addImageParam($oTopic->getTextSource(), $sInsert)) {
                list($sTextShort, $sTextNew, $sTextCut) = $this->Text_Cut($sText);
                $oTopic->setCutText($sTextCut);
                $oTopic->setText($this->Text_Parser($sTextNew));
                $oTopic->setTextShort($this->Text_Parser($sTextShort));
                $oTopic->setTextSource($sText);
                $oTopic->setTextHash(md5($sText));
                $this->Topic_UpdateTopic($oTopic);
            }
        }
    }

    /**
     * Добавляет или замещает атрибуты тэга изображения
     *
     * @param type $sText
     * @param type $sInsert
     * @return type
     */
    protected function _addImageParam($sText, $sInsert) {
        $sTextNew = '';
        $patternImg = "(<img([^<>+]*)>)";
        if (preg_match_all($patternImg, $sText, $aMathces)) {
            $aMathcesImg = $aMathces[0];
            $iLast = count($aMathcesImg) - 1;
            // убираем title и alt со всех картинок
            foreach ($aMathcesImg as $key => $sImg) {
                $sImgNew = preg_replace('/alt.?=[^".]?".*?"/', '', $sImg);
                $sImgNew = preg_replace('/title.?=[^".]?".*?"/', '', $sImgNew);
                $sText = str_replace($sImg, $sImgNew, $sText);
                $aMathcesImg[$key] = $sImgNew;
            }
            $sImgFirst = preg_replace('/\/?>/', $sInsert . ' />', $aMathcesImg[0]);
            $sText = str_replace($aMathcesImg[0], $sImgFirst, $sText);
            $sImgLast = preg_replace('/\/?>/', $sInsert . ' />', $aMathcesImg[$iLast]);
            $sText = str_replace($aMathcesImg[$iLast], $sImgLast, $sText);
            $sTextNew = $sText;
        }
        return $sTextNew;
    }

    /**
     *
     * @param array $aVars
     */
    public function AssignLink($aVars) {
        /* @var $oTopic ModuleTopic_EntityTopic */
        $oTopic = $aVars['oTopic'];
        $oTopic = $this->Topic_GetTopicById($oTopic->getId());

        $sTextShort = $oTopic->getTextShort();
        $sTextSource = $oTopic->getTextSource();

        $patternImg = "#(<img([^<>+]*)>)(?!</a>)#";
        if (preg_match_all($patternImg, $sTextShort, $aMathces)) {
            $aMathcesImg = $aMathces[0];
            foreach ($aMathcesImg as $key => $sImg) {
                $sImg = rtrim($sImg, '<');
                $sImgNew = '<a href="' . $oTopic->getUrl() . '" title="' . $oTopic->getTitle() . '">' . $sImg . '</a>';
                $sTextShort = str_replace($sImg, $sImgNew, $sTextShort);
            }

            $oTopic->setTextShort($sTextShort);
            $this->Topic_UpdateTopicContent($oTopic);
        }
    }

}
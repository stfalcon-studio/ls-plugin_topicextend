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

/**
 * Модификатор declension: склонение существительных по правилам украинского языка
 *
 * @param array $forms (напр: 0 => людей, 1 => людина, 2 => людей)
 * @param int $count
 * @return string
 */
function smarty_modifier_declension_ukrainian(array $forms, $count) {

    return smarty_modifier_declension_russian($forms, $count);
}

?>

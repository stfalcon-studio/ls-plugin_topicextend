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
return $config = array(
    /*
     * Добавлять атрибуты размеров изображения в его тэг
     */
    'add_image_size' => true,
    /**
     * Выводить предупреждение о том, что вы собираетесь покинуть страницу
     */
    'add_misclick_protection' => true,
    /**
     * Добавлять атрибут альтернативного текста изображения в его тэг
     */
    'add_image_alt' => true,
    /**
     * Добавить кнопку добавления топика в основное меню
     */
    'add_button_to_mainmenu' => false,
);
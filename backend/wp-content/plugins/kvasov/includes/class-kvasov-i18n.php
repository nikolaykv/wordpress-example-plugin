<?php

/**
 * Определите функциональность интернационализации
 *
 * Загружает и определяет файлы интернационализации для этого плагина
 * чтобы он был готов к переводу.
 *
 * @link       https://github.com/
 * @since      1.0.0
 *
 * @package    Kvasov
 * @subpackage Kvasov/includes
 */

/**
 * Определите функциональность интернационализации.
 *
 * Загружает и определяет файлы интернационализации для этого плагина
 * чтобы он был готов к переводу.
 *
 * @since      1.0.0
 * @package    Kvasov
 * @subpackage Kvasov/includes
 * @author     Nikolai Kvasov <kvasov1992@inbox.ru>
 */

class Kvasov_i18n {
	/**
	 *Загрузите текстовый домен плагина для перевода.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'kvasov',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}

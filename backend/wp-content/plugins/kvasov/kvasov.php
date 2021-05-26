<?php

/**
 * Файл начальной загрузки плагина
 *
 * Этот файл читается WordPress для генерации информации о плагине во вкладке плагинов административной части сайта.
 * Этот файл также включает все зависимости, используемые плагином,
 * регистрирует функции активации и деактивации и определяет функцию
 * который запускает плагин.
 *
 * @link              https://github.com/
 * @since             1.0.0
 * @package           Kvasov
 *
 * @wordpress-plugin
 * Plugin Name:       Kvasov
 * Plugin URI:        https://github.com/
 * Description:       Самый первый плагин, который я когда-либо создавал
 * Version:           1.0.0
 * Author:            Nikolai Kvasov
 * Author URI:        https://vk.com/ozzy1991
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kvasov
 * Domain Path:       /languages
 */

// Если этот файл вызывается напрямую, прервите его.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Текущая версия плагина.
 * Начните с версии 1.0.0 и используйте SemVer - https://semver.org
 * Переименуйте это для своего плагина и обновляйте его по мере выпуска новых версий.
 */
define( 'KVASOV_VERSION', '1.0.0' );

/**
 * Код, который запускается при активации плагина.
 * Это действие задокументировано в файле includes/class-kvasov-activator.php.
 */
function activate_kvasov() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kvasov-activator.php';
	Kvasov_Activator::activate();
}

/**

 * Код, который запускается при деактивации плагина.
 * Это действие задокументировано в includes/class-kvasov-deactivator.php.
 */
function deactivate_kvasov() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kvasov-deactivator.php';
	Kvasov_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kvasov' );
register_deactivation_hook( __FILE__, 'deactivate_kvasov' );

/**
 * Основной класс плагина, который используется для определения интернационализации,
 * хуки, специфичные для администратора, и публичные хуки для сайтов.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kvasov.php';

/**
 * Начинает выполнение плагина.
 *
 * Всё регистрируется через хуки,
 * затем запускается плагин с этого места.
 * Всё это не влияет на жизненный цикл страницы
 *
 * @since    1.0.0
 */
function run_kvasov() {

	$plugin = new Kvasov();
	$plugin->run();

}
run_kvasov();

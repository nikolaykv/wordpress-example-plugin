<?php

/**
 * Запускается при удалении плагина.
 *
 * При заполнении этого файла учитывайте следующее:
 *
 * - Этот метод должен быть статическим
 * - Проверьте, действительно ли содержимое $_REQUEST является именем плагина
 * - Запустите проверку администратора, чтобы убедиться, что он проходит аутентификацию
 * - Убедитесь, что вывод $_GET присутствует
 * - Повторите то же самое с другими ролями пользователей. Лучше всего напрямую, используя параметры ссылки/строки запроса.
 * - Повторите действия для мультисайта. Один раз для одного сайта в сети, один раз для всего сайта.
 *
 * Этот файл может быть обновлен больше в будущей версии Boilerplate; однако это
 * общий скелет и схема того, как файл должен работать.
 *
 * Для получения дополнительной информации см. Следующее обсуждение:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://github.com/
 * @since      1.0.0
 *
 * @package    Kvasov
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
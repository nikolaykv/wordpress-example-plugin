<?php

/**
 * Функциональность плагина, специфичная для публичной части сайта.
 *
 * @link       https://github.com/
 * @since      1.0.0
 *
 * @package    Kvasov
 * @subpackage Kvasov/public
 */

/**
 * Функциональность плагина, специфичная для публичной части сайта.
 *
 * Определяет название плагина, версию и два примера хуков для того, как
 * поставить в очередь на загрузку таблицу стилей и JavaScript, специфичные для публичной части сайта.
 *
 * @package    Kvasov
 * @subpackage Kvasov/public
 * @author     Nikolai Kvasov <kvasov1992@inbox.ru>
 */
class Kvasov_Public {

	/**
	 * ID этого плагина.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $kvasov ID этого плагина.
	 */
	private $kvasov;

	/**
	 * Версия этого плагина.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version Версия этого плагина.
	 */
	private $version;

	/**
	 * Инициализируйте класс и установите его свойства.
	 *
	 * @param string $kvasov Название плагина.
	 * @param string $version Версия этого плагина.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $kvasov, $version ) {

		$this->kvasov  = $kvasov;
		$this->version = $version;

	}

	/**
	 * Регистрация css для публичной части сайта
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * Эта функция предназначена только для демонстрационных целей.
		 *
		 * Экземпляр этого класса нужно передать функции run ()
		 * определено в Kvasov_Loader, поскольку все хуки определены
		 * в этом конкретном классе.
		 *
		 * Затем Kvasov_Loader создаст связь
		 * между определенными хуками и функциями, определенными в этом
		 * класс.
		 */

		wp_enqueue_style(
			$this->kvasov,
			plugin_dir_url( __FILE__ ) . 'css/kvasov-public.css',
			array(), $this->version,
			'all'
		);
	}

	/**
	 * Зарегистрируйте JavaScript публичной части сайта
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * Эта функция предназначена только для демонстрационных целей.
		 *
		 * Экземпляр этого класса нужно передать функции run ()
		 * определено в Kvasov_Loader, поскольку все хуки определены
		 * в этом конкретном классе.
		 *
		 * Затем Kvasov_Loader создаст связь
		 * между определенными хуками и функциями, определенными в этом
		 * класс.
		 */

		wp_enqueue_script(
			$this->kvasov,
			plugin_dir_url( __FILE__ ) . 'js/kvasov-public.js',
			array( 'jquery' ), $this->version,
			false
		);
	}

	/**
	 * Функция, по факту, работающая только с шаблоном кастомного шорткода
	 *
	 * @since    1.0.0
	 */
	public function example_shortcode() {
		ob_start();
		include 'shortcodes/shortcode-kvasov-example.php';
		return ob_get_clean();
	}

	/**
	 * Регистрация кастомного шорткода
	 *
	 * @since    1.0.0
	 */
	public function example_shortcode_init() {
		add_shortcode( 'kvasov-example', array( $this, 'example_shortcode' ) );
	}

	/**
	 * Функция фильтрации контента записи,
	 * повешенная на хук the_content в файле include/class-kvasov.php в лоадере хуков define_public_hooks
	 *
	 * @since    1.0.0
	 */
	public function the_content( $post_content ) {

		// Если это прямой запрос и отдельная страница сообщения
		if ( is_main_query() && is_singular('post') ) {

			// Получаем сохранённые настройки плагина
			$position  = get_option( 'kvasov_position', 'before' );
			$days      = (int) get_option( 'kvasov_day', 0 );

			// Получаем текущее время с сервера баз данных
			$date_now  = new DateTime( current_time('mysql') );
			$date_old  = new DateTime( get_the_modified_time('Y-m-d H:i:s') );

			// и рассчитываем разницу в днях для демонстрации функционала плагина
			$date_diff = $date_old->diff( $date_now );

			// сравнение $date_diff и установленной опцией $days в плагине
			if ( $date_diff->days > $days ) {
				$class = 'is-outdated'; // пост устарел
			} else {
				$class = 'is-fresh'; // пост свежий
			}

			// Формируем уведомление
			$notice = sprintf(
				_n(
					'Этот пост последний раз обновлялся %s день назад.',
					'Этот пост последний раз обновлялся %s дней назад.',
					$date_diff->days,
					'kvasov'
				),
				$date_diff->days
			);

			// Добавляем класс к уведомлению и формируем итоговую разметку
			$notice = '<div class="outdated-notice %s">' . $notice . '</div>';
			$notice = sprintf( $notice, $class );

			// Вывод информационного сообщения, в зависимости от указанной опции position в плагине
			if ( 'after' == $position ) {
				$post_content .= $notice;
			} else {
				$post_content = $notice . $post_content;
			}
		}

		return $post_content;
	}
}

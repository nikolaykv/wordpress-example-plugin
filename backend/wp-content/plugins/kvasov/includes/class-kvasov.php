<?php

/**
 * Файл, определяющий базовый класс плагина.
 *
 * Определение класса, которое включает атрибуты и функции, используемые как в
 * общедоступной части сайта, так и в административной панели.
 *
 * @link       https://github.com/
 * @since      1.0.0
 *
 * @package    Kvasov
 * @subpackage Kvasov/includes
 */

/**
 * Основной класс плагина.
 *
 * Это используется для определения интернационализации, специфичных для администратора хуков и
 * общедоступные хуков сайта.
 *
 * Также поддерживает уникальный идентификатор этого плагина, а также текущую
 * версию плагина.
 *
 * @since      1.0.0
 * @package    Kvasov
 * @subpackage Kvasov/includes
 * @author     Nikolai Kvasov <kvasov1992@inbox.ru>
 */
class Kvasov {

	/**
	 * Загрузчик, отвечающий за обслуживание и регистрацию всех хуков плагина.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Kvasov_Loader    $loader   Поддерживает и регистрирует все хуки для плагина.
	 */
	protected $loader;

	/**
	 * Уникальный идентификатор этого плагина.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $kvasov    Строка, используемая для однозначной идентификации этого плагина.
	 */
	protected $kvasov;

	/**
	 * Текущая версия плагина.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    Текущая версия плагина.
	 */
	protected $version;

	/**
	 * Определите основные функции плагина.
	 *
	 * Задайте имя и версию плагина, которые можно использовать во всем плагине.
	 * Загрузите зависимости, определите локаль и установите хуки для области администрирования и
	 * публичной части сайта.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'KVASOV_VERSION' ) ) {
			$this->version = KVASOV_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->kvasov = 'kvasov';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Загрузите необходимые зависимости для этого плагина.
	 *
	 * Включите следующие файлы, из которых состоит плагин:
	 *
	 * - Kvasov_Loader. Управляет хуками плагина.
	 * - Kvasov_i18n. Определяет функциональность интернационализации.
	 * - Kvasov_Admin. Определяет все хуки для админки.
	 * - Kvasov_Public. Определяет все хуки для публичной части сайта.
	 *
	 * Создайте экземпляр загрузчика, который будет использоваться для регистрации хуков.
	 * с WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Класс, отвечающий за оркестровку действий и фильтров
		 * ядро плагина.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-kvasov-loader.php';

		/**
		 * Класс, отвечающий за определение функциональности интернационализации
		 * плагина.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-kvasov-i18n.php';

		/**
		 * Класс, отвечающий за определение всех действий, происходящих в админке.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-kvasov-admin.php';

		/**
		 * Класс, отвечающий за определение всех действий, которые происходят в публичной
		 * части сайта.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-kvasov-public.php';

		$this->loader = new Kvasov_Loader();

	}

	/**
	 * Определите локаль для этого плагина для интернационализации.
	 *
	 * Использует класс Kvasov_i18n, чтобы установить домен и зарегистрировать перехватчик
	 * с WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Kvasov_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Зарегистрируйте все хуки, связанные с функциональностью админки.
	 * плагина.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Kvasov_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Добавит подменю "Устаревшее уведомление" в левое главное меню настроек
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );

		// register_settings() функция на этом хуке admin_init, выводит и регистрирует все возможные настройки это плагина
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );

		// Регистрация index.js для реализации кастомного метабокса на редакторе гутенберг
		$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'kvasov_gutenberg_enqueue_assets' );

		// Регистрация kvasov_add_meta_box функции на add_meta_boxes - добавляет кастомный мета блок
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'kvasov_add_meta_box' );

		// Регистрация kvasov_save_post_metabox функции на save_post хуке.
		// Обновляет запись
		$this->loader->add_action( 'save_post', $plugin_admin, 'kvasov_save_post_metabox', 10, 2 );

		// Функция kvasov_register_meta, регистрирует метаполе (ключ произвольного поля)
		// на хуке init
		$this->loader->add_action( 'init', $plugin_admin, 'kvasov_register_meta');

		// Регистрации функции new_type_of_quote - по добавлению нового типа записи в систему
		// на соответствующем хуке
		$this->loader->add_action( 'init', $plugin_admin, 'new_type_of_quote' );

		// Регистрация пользовательской таксономии.
		$this->loader->add_action( 'init', $plugin_admin, 'kvasov_taxonomy' );

		// Регистрация нового пользовательского типа записи: "Новость"
        $this->loader->add_action( 'init', $plugin_admin, 'register_news_type' );

        // Регистрация новой конечной точки для пользовательского типа записи "Новость"
        $this->loader->add_action( 'rest_api_init', $plugin_admin, 'register_news_rest_route' );

	}

	/**
	 * Зарегистрируйте все хуки, связанные с функциональностью плагина
	 * в общедоступной части сайта.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Kvasov_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Инициализация кастомного шорткода для публичной части на хуке init
		$this->loader->add_action( 'init', $plugin_public, 'example_shortcode_init' );

		// Для шорткода, перехват контента и фильтрация
		$this->loader->add_action( 'the_content', $plugin_public, 'the_content' );

	}

	/**
	 * Запустите загрузчик, чтобы выполнить все хуки с WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Имя плагина, используемое для его уникальной идентификации в контексте
	 * WordPress и определение функциональности интернационализации.
	 *
	 * @since     1.0.0
	 * @return    string    Название плагина.
	 */
	public function get_plugin_name() {
		return $this->kvasov;
	}

	/**
	 * Ссылка на класс, который управляет обработчиками плагина.
	 *
	 * @since     1.0.0
	 * @return    Kvasov_Loader    Управляет хуками плагина.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Получите номер версии плагина.
	 *
	 * @since     1.0.0
	 * @return    string    Номер версии плагина.
	 */
	public function get_version() {
		return $this->version;
	}

}

<?php

/**
 * Функциональность плагина, специфичная для администратора.
 *
 * @link       https://github.com/
 * @since      1.0.0
 *
 * @package    Kvasov
 * @subpackage Kvasov/admin
 */

/**
 * Функциональность плагина, специфичная для администратора.
 *
 * Определяет название плагина, версию и два примера хуков для того, как
 * поставить в очередь на загрузку таблицу стилей и JavaScript, специфичные для административной части сайта.
 *
 * @package    Kvasov
 * @subpackage Kvasov/admin
 * @author     Nikolai Kvasov <kvasov1992@inbox.ru>
 */
class Kvasov_Admin {

	/**
	 * Название опции этого плагина
	 *
	 * @since    1.0.0
	 * @access    private
	 * @var    string $option_name Название опции этого плагина
	 */
	private $option_name = 'kvasov';

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
	 * @param string $kvasov Название этого плагина.
	 * @param string $version Версия этого плагина.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $kvasov, $version ) {

		$this->kvasov  = $kvasov;
		$this->version = $version;

	}

	/**
	 * Регистрация css для административной части сайта
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * Эта функция предназначена только для демонстрационных целей.
		 *
		 * Экземпляр этого класса нужно передать в функцию run ()
		 * определено в Kvasov_Loader, поскольку все хуки определены
		 * в этом конкретном классе.
		 *
		 * Затем Kvasov_Loader создаст связь
		 * между определенными хуками и функциями, определенными в этом
		 * классе.
		 */
		wp_enqueue_style(
			$this->kvasov,
			plugin_dir_url( __FILE__ ) . 'css/kvasov-admin.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Зарегистрируйте JavaScript административной части сайта
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
			plugin_dir_url( __FILE__ ) . 'js/kvasov-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);
	}

	/**
	 * Добавьте страницу опций в подменю настроек
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Устаревшие настройки уведомлений', 'kvasov' ),
			__( 'Устаревшее уведомление', 'kvasov' ),
			'manage_options',
			$this->kvasov,
			array( $this, 'display_options_page' )
		);
	}

	/**
	 * Визуализируйте страницу параметров для плагина
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/kvasov-admin-display.php';
	}

	/**
	 * Зарегистрирует все связанные настройки этого плагина
	 *
	 * @since  1.0.0
	 */
	public function register_settings() {
		// Добавит секцию
		add_settings_section(
			$this->option_name . '_general',
			__( 'Опции', 'kvasov' ),
			array( $this, $this->option_name . '_general_kv' ),
			$this->kvasov
		);

		// Добавит поле radio button
		add_settings_field(
			$this->option_name . '_position',
			__( 'Положение текста', 'kvasov' ),
			array( $this, $this->option_name . '_position_kv' ),
			$this->kvasov,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_position' )
		);

		// добавит поле type="text"
		add_settings_field(
			$this->option_name . '_day',
			__( 'Сообщение устарело после', 'kvasov' ),
			array( $this, $this->option_name . '_day_kv' ),
			$this->kvasov,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_day' )
		);

		// Регистрация полей формы, описанных выше
		register_setting(
			$this->kvasov,
			$this->option_name . '_position',
			array( $this, $this->option_name . '_sanitize_position' )
		);
		register_setting( $this->kvasov, $this->option_name . '_day', 'intval' );
	}

	/**
	 * Визуализировать разметку для страницы опций
	 *
	 * @since  1.0.0
	 */
	public function kvasov_general_kv() {
		echo '<p class="base-font-size">
                ' . __( 'Пожалуйста, укажите желаемые настройки:', 'kvasov' ) . '
              </p>';
	}

	/**
	 * Визуализируйте поле ввода радио для опции позиции
	 *
	 * @since  1.0.0
	 */
	public function kvasov_position_kv() {
		$position = get_option( $this->option_name . '_position' );
		?>
        <fieldset>
            <label>
                <input type="radio"
                       name="<?= $this->option_name . '_position' ?>"
                       id="<?php echo $this->option_name . '_position' ?>"
                       value="before" <?php checked( $position, 'before' ); ?>>
				<?php _e( 'Перед контентом', 'kvasov' ); ?>
            </label>
            <br>
            <label>
                <input type="radio"
                       name="<?= $this->option_name . '_position' ?>"
                       value="after" <?php checked( $position, 'after' ); ?>>
				<?php _e( 'После контента', 'kvasov' ); ?>
            </label>
        </fieldset>
		<?php
	}

	/**
	 * Отобразите значения порогового дня для этого плагина
	 *
	 * @since  1.0.0
	 */
	public function kvasov_day_kv() {
		$day = get_option( $this->option_name . '_day' );
		echo '<input type="text"
		             name="' . $this->option_name . '_day' . '"
		             id="' . $this->option_name . '_day' . '"
		             value="' . $day . '"> ' . __( 'дней', 'kvasov' );
	}

	/**
	 * Очистите значение позиции текста перед сохранением в базе данных
	 *
	 * @param string $position $_POST value
	 *
	 * @return string           Sanitized value
	 * @since  1.0.0
	 */
	public function kvasov_sanitize_position( $position ) {
		if ( in_array( $position, array( 'before', 'after' ), true ) ) {
			return $position;
		}
	}

	/**
	 * Регистрация index.js для реализации кастомного метабокса на редакторе гутенберг
	 * с обратной совместимостью на классический редактор
	 *
	 * @since  1.0.0
	 */
	public function kvasov_gutenberg_enqueue_assets() {
		wp_enqueue_script(
			'kvasov-meta-box-example',
			plugins_url( 'kvasov/build/index.js' ),
			array( 'wp-plugins', 'wp-edit-post', 'wp-i18n', 'wp-element', 'wp-components', 'wp-data' ),
			$this->version
		);
	}

	/**
	 * Добавляет дополнительные блоки (meta box)
	 *
	 * @since  1.0.0
	 */
	public function kvasov_add_meta_box() {
		add_meta_box(
			'kvasov_post_options_metabox', // $id -  атрибут HTML тега, контейнера блока.
			__( 'Параметры публикации', 'kvasov' ), // $title - заголовок/название блока
			// $callback функция, вызываемая по ссылке.
			// Выводит на экран HTML содержание блока
			array( $this, 'kvasov_post_options_metabox_html' ),
			'post', // $screen - название экрана для которого добавляется блок
			'normal', // $context - место где должен показываться блок
			'default', // $priority - приоритет блока для показа выше или ниже остальных блоков
			// $callback_args - аргументы, которые нужно передать в callback функцию.
			// Здесь, скрыть мета блок на классическом редакторе
			array( '__back_compat_meta_box' => true )
		);
	}

	/**
	 * $callback функция, вызываемая по ссылке в kvasov_add_meta_box()
	 * отрисует поле формы для мета блока id="kvasov_post_options_metabox"
	 *
	 * @since  1.0.0
	 */
	public function kvasov_post_options_metabox_html( $post ) {
		// получает значение произвольного поля записи
		$field_value = get_post_meta( $post->ID, '_kvasov_text_metafield', true );
		// получает или выводит скрытое одноразовое поле (nonce) для формы
		wp_nonce_field( 'kvasov_update_post_metabox', 'kvasov_update_post_nonce' );
		?>
        <p>
            <label for="kvasov_text_metafield">
				<?php esc_html_e( 'Кастомное текстовое поле', 'kvasov' ); ?>
            </label>
            <br/>
            <input class="widefat"
                   type="text"
                   name="kvasov_text_metafield"
                   id="kvasov_text_metafield"
                   value="<?php echo esc_attr( $field_value ); ?>"/>
        </p>
		<?php
	}

	/**
	 * Функция обработчик полей формы мета блока id="kvasov_post_options_metabox"
	 *
	 * @since  1.0.0
	 */
	public function kvasov_save_post_metabox( $post_id, $post ) {
		// получает объект (данные) указанного типа записи
		$edit_cap = get_post_type_object( $post->post_type )
			->cap
			->edit_post;

		// проверяет права текущего пользователя, совершать указанное действие
		if ( ! current_user_can( $edit_cap, $post_id ) ) {
			return;
		}

		// Если пришло пустое поле или токен формы не валиден
		if ( ! isset( $_POST['kvasov_update_post_nonce'] ) || ! wp_verify_nonce( $_POST['kvasov_update_post_nonce'], 'kvasov_update_post_metabox' ) ) {
			return;
		}

		// иначе, проверим наличе ключа в массиве $_POST и обновим запись
		if ( array_key_exists( 'kvasov_text_metafield', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_kvasov_text_metafield',
				sanitize_text_field( $_POST['kvasov_text_metafield'] ) // очистка поля перед сохранением в БД
			);
		}
	}

	/**
	 * Регистрирует метаполе (ключ произвольного поля).
	 *
	 * @since  1.0.0
	 */
	public function kvasov_register_meta() {
		register_meta(
			'post', // $object_type - тип объекта для которого регистрируется метаполе
			'_kvasov_text_metafield', // $meta_key - название ключа, который регистрируется
			// данные описывающие метаполе
			array(
				// нужно ли показывать эти данные в REST запросах
				// здесь нужно, так как задействован react для редактора гутенберг
				'show_in_rest'      => true,
				'type'              => 'string',
				'single'            => true, // может быть только одно метаполе с таким названием
				// название функции или метода,
				// который будет использован при очистки значения метаполя при сохранении
				'sanitize_callback' => 'sanitize_text_field',
				// название функции или метода,
				// который будет разрешать или запрещать добавление прав
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				}
			)
		);
	}

	/**
	 * Регистрация произвольного типа сообщений.
	 *
	 * https://wp-kama.ru/function/register_post_type#can_export
	 *
	 * @since  1.0.0
	 */
	public static function new_type_of_quote() {

		$cap_type = 'post'; // строка, которая будет маркером для установки прав для этого типа записи
		//$pluralCustom   = __('Цитат', 'kvasov');
		$plural = __( 'Quotes', 'kvasov' );
		$single = __( 'Quote', 'kvasov' );
		//$singleCustom   = __('Цитату', 'kvasov');
		$cpt_name = 'random_quote'; // Название типа записи

		$opts['can_export']      = true; // возможность экспорта этого типа записей.
		$opts['capability_type'] = $cap_type;

		// короткое описание этого типа записи
		$opts['description']         = esc_html__( "Описание для типа записи: \"Случайная цитата\"", 'now-hiring' );
		$opts['exclude_from_search'] = false; // исключить ли этот тип записей из поиска по сайту
		$opts['has_archive']         = false; // включить поддержку страниц архивов для этого типа записей

		// будут ли записи этого типа иметь древовидную структуру (как постоянные страницы)
		$opts['hierarchical']      = false;
		$opts['map_meta_cap']      = true; // ставим true, чтобы включить дефолтный обработчик специальных прав
		$opts['menu_icon']         = 'dashicons-businessman'; // Иконка
		$opts['menu_position']     = 25; // позиция где должно расположится меню нового типа записи
		$opts['public']            = true; // определяет является ли тип записи публичным или нет
		$opts['publicly_querable'] = true; // включит публичный просмотр записей этого типа
		$opts['query_var']         = true; // устанавливает название параметра запроса для создаваемого типа записи

		// callback функция, которая будет срабатывать
		// при установки мета блоков для страницы создания/редактирования этого типа записи
		$opts['register_meta_box_cb'] = '';

		$opts['rewrite']           = false; // использовать ли ЧПУ для этого типа записи
		$opts['show_in_admin_bar'] = true; // сделать этот тип доступным из admin_bar
		$opts['show_in_menu']      = true; // показывать ли тип записи в администраторском меню
		$opts['show_in_nav_menu']  = true; // включить возможность выбирать этот тип записи в меню навигации

		// определяет нужно ли создавать логику управления типом записи
		// из админ-панели
		$opts['show_ui'] = true;

		// вспомогательные поля на странице создания/редактирования этого типа записи
		$opts['supports'] = array( 'title', 'editor', 'thumbnail' );

		// массив зарегистрированных таксономий, которые будут связаны с этим типом записей
		$opts['taxonomies'] = array();

		// Массив прав для этого типа записи.
		$opts['capabilities']['delete_others_posts']    = "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']            = "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']           = "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']   = "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts'] = "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']      = "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']              = "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']             = "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']     = "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']   = "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']          = "publish_{$cap_type}s";
		$opts['capabilities']['read_post']              = "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']     = "read_private_{$cap_type}s";

		// массив содержащий в себе названия ярлыков для типа записи
		$opts['labels']['add_new']            = esc_html__( "Добавить новую {$single}", 'kvasov' );
		$opts['labels']['add_new_item']       = esc_html__( "Добавить новую {$single}", 'kvasov' );
		$opts['labels']['all_items']          = esc_html__( $plural, 'kvasov' );
		$opts['labels']['edit_item']          = esc_html__( "Редактировать {$single}", 'kvasov' );
		$opts['labels']['menu_name']          = esc_html__( $plural, 'kvasov' );
		$opts['labels']['name']               = esc_html__( $plural, 'kvasov' );
		$opts['labels']['name_admin_bar']     = esc_html__( $single, 'kvasov' );
		$opts['labels']['new_item']           = esc_html__( "Новая {$single}", 'kvasov' );
		$opts['labels']['not_found']          = esc_html__( "Не найдено {$plural}", 'kvasov' );
		$opts['labels']['not_found_in_trash'] = esc_html__( "Не найдено в корзине {$plural} ", 'kvasov' );
		$opts['labels']['parent_item_colon']  = esc_html__( "Родитель {$plural} :", 'kvasov' );
		$opts['labels']['search_items']       = esc_html__( "Поиск {$plural}", 'kvasov' );
		$opts['labels']['singular_name']      = esc_html__( $single, 'kvasov' );
		$opts['labels']['view_item']          = esc_html__( "Шаблон {$single}", 'kvasov' );

		$opts['rewrite']['ep_mask']    = EP_PERMALINK; // использовать ли ЧПУ для этого типа записи
		$opts['rewrite']['feeds']      = false; // добавить ли правило ЧПУ для RSS ленты этого типа записи
		$opts['rewrite']['pages']      = true; // добавить ли правило ЧПУ для пагинации архива записей этого типа
		$opts['rewrite']['slug']       = esc_html__( strtolower( $plural ), 'kvasov' ); // префикс в ЧПУ
		$opts['rewrite']['with_front'] = false; // нужно ли в начало вставлять общий префикс из настроек

		register_post_type( strtolower( $cpt_name ), $opts );
	}


	/**
	 * Регистрация пользовательской таксономии.
     *
	 * https://wp-kama.ru/function/register_taxonomy#label
	 *
	 * @since  1.0.0
	 */
	public function kvasov_taxonomy() {
		register_taxonomy(
			'example-taxonomy',
			array( 'post', 'random_quote' ),
			array(
				'label'  => '',
				'labels' => [
					'name'          => __( 'Пользовательские таксономии', 'kvasov' ),
                    'singular_name' => __( 'Пользовательская таксономия', 'kvasov' ),
                    'search_items' => __('Искать пользовательские таксономии', 'kvasov'),
                    'all_items' => __('Все пользовательские таксономии', 'kvasov'),
                    'view_item' => __('Посмотреть пользовательскую таксономию', 'kvasov'),
                    'parent_item' => null,
					'parent_item_colon' => null,
                    'edit_item' => __('Редактировать пользовательскую таксономию', 'kvasov'),
                    'update_item' => __('Обновить пользовательскую таксономию', 'kvasov'),
                    'add_new_item' => __('Добавить пользовательскую таксономию', 'kvasov'),
                    'new_item_name' => __('Имя новой пользовательской таксономии', 'kvasov')
				],
                'hierarchical' => false,
                'description' => __('Пример внедрения пользовательской таксономии через плагин', 'kvasov'),
                'public' => true,
                'rewrite' => true,
                'capabilities' => array(),
                'meta_box_cb' => null,
                'show_admin_column' => false,
                'show_in_rest' => null,
                'rest_base' => null

			)
		);
	}
}

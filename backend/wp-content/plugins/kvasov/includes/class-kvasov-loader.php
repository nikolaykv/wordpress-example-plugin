<?php

/**
 * Зарегистрируйте все действия и фильтры для плагина
 *
 * @link       https://github.com/
 * @since      1.0.0
 *
 * @package    Kvasov
 * @subpackage Kvasov/includes
 */

/**
 * Зарегистрируйте все действия и фильтры для плагина.
 *
 * Поддержка списка всех зарегистрированных хуков
 * плагина и регистрация их в WordPress API.
 * Вызов функции запуска для выполнения списка actions и filters.
 *
 * @package    Kvasov
 * @subpackage Kvasov/includes
 * @author     Nikolai Kvasov <kvasov1992@inbox.ru>
 */
class Kvasov_Loader {

	/**
	 * Массив actions, зарегистрированных в WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    Actions, зарегистрированные в WordPress, срабатывают при загрузке плагина.
	 */
	protected $actions;

	/**
	 * Массив filters, зарегистрированных в WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    Filters, зарегистрированные в WordPress, срабатывают при загрузке плагина.
	 */
	protected $filters;

	/**
	 * Инициализируйте коллекции, используемые для поддержки actions и filters
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Добавьте новый actions в коллекцию для регистрации в WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             Имя регистрируемого action WordPress.
	 * @param    object               $component        Ссылка на экземпляр объекта, для которого определен action.
	 * @param    string               $callback         Имя вызываемой обратной функции в $component
	 * @param    int                  $priority         Опционально. Приоритет, при котором функция должна быть запущена. По умолчанию 10.
	 * @param    int                  $accepted_args    Опционально. Количество аргументов, которые следует передать функции обратного вызова $callback$. По умолчанию 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Добавьте новый фильтр в коллекцию для регистрации в WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             Имя регистрируемого фильтра WordPress.
	 * @param    object               $component        Ссылка на экземпляр объекта, для которого определен фильтр.
	 * @param    string               $callback         Имя $callback функции в $component
	 * @param    int                  $priority         Опционально. Приоритет, при котором функция должна быть запущена. По умолчанию 10.
	 * @param    int                  $accepted_args    Опционально. Количество аргументов, которые следует передать функции обратного вызова $callback. По умолчанию 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Служебная функция, которая используется для регистрации actions и hooks в одну
	 * коллекцию.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            Набор регистрируемых хуков (то есть actions или filters).
	 * @param    string               $hook             Имя регистрируемого фильтра WordPress.
	 * @param    object               $component        Ссылка на экземпляр объекта, для которого определен фильтр.
	 * @param    string               $callback         Имя $callback функции определённой в $component
	 * @param    int                  $priority         Приоритет, при котором функция должна быть запущена.
	 * @param    int                  $accepted_args    Количество аргументов, которые следует передать функции обратного вызова $callback.
	 * @return   array                                  Набор actions и filters, зарегистрированных в WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Зарегистрируйте filters и actions в WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

}

<?php
/**
 * Шаблон страницы опций для плагина
 *
 * @link       https://github.com/
 * @since      1.0.0
 *
 * @package    Kvasov
 * @subpackage Kvasov/admin/partials
 */
?>

<!-- Этот файл должен в первую очередь состоять из HTML с небольшим количеством PHP. -->

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form action="options.php" method="post">
		<?php
		settings_fields( $this->kvasov );
		do_settings_sections( $this->kvasov );
		submit_button();
		?>
    </form>

    <hr/>
    <div>
        <h3>Демонстрация возможностей HTTP API WordPress</h3>
        <div>
            <p class="base-font-size">
                В качестве конечной точки будем использовать бесплатное поддельное API для тестирования и
                прототипирования <a href="https://jsonplaceholder.typicode.com/" target="_blank">{JSON} Placeholder</a>
            </p>
            <p class="base-font-size">
                Когда вы нажмёте на кнопку расположенную ниже, вы тем самым отправите GET Ajax запрос на данный сервис.
            </p>
            <p class="base-font-size">
                Полученные данные от сервера API будут отрисованы на этой же странице, сразу под кнопкой в виде таблицы
            </p>
        </div>
    </div>

    <button class="wp-core-ui button-primary button-custom" id="get-json-placeholder-request">
        Получить данные
    </button>

    <hr />

    <table class="wp-list-table widefat fixed striped table-view-list posts example-table table-custom">
        <thead>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>userId</th>
            <th>body</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
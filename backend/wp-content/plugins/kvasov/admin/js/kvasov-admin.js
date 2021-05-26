(function ($) {
    'use strict';

    /**
     * Весь JavaScript, специфичный для административной части сайта
     * должен быть включён в данный файл
     */

    $(document).ready(function () {


    	console.log($('.example-table tbody'))

        $("#get-json-placeholder-request").on('click',function (event) {
			$.ajax({
				url: 'https://jsonplaceholder.typicode.com/posts/1',
				method: 'get',
				dataType: 'json',
				success: function(data){
					$('.example-table tbody').append(
						'<tr>' +
							'<td>' + data.id +'</td>' +
							'<td>' + data.title +'</td>' +
							'<td>' + data.userId +'</td>' +
							'<td>' + data.body +'</td>' +
						'</tr>'
					);

					$('.example-table').fadeIn().after(
						'<p>' +
							'Запрос был сделан на следующий url ' +
							'<a href="https://jsonplaceholder.typicode.com/posts/1" target="_blank">' +
								'https://jsonplaceholder.typicode.com/posts/1' +
							'</a> ' +
						'</p>'
					);
				},
				error: function (jqXHR, exception) {
					if (jqXHR.status === 0) {
						alert('Нет соединения. Проверьте соединение.');
					} else if (jqXHR.status == 404) {
						alert('Запрошенный ресурс не найден (404).');
					} else if (jqXHR.status == 500) {
						alert('Внутренняя ошибка сервера (500).');
					} else if (exception === 'parsererror') {
						alert('Не удалось прочитать запрошенный JSON.');
					} else if (exception === 'timeout') {
						alert('Время ожидания запроса истекло.');
					} else if (exception === 'abort') {
						alert('Ajax запрос прерван.');
					} else {
						alert('Неперехваченная ошибка. ' + jqXHR.responseText);
					}
				}
			});

		});
    });

})(jQuery);

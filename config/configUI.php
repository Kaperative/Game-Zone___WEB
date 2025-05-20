<?php

return [
    // Количество элементов на одной странице таблицы
    'perPage' => 15,

    // Доступные варианты количества элементов на странице
    'perPageOptions' => [10, 15, 25, 50, 100],

    // Имя параметра в URL для номера страницы (например: ?page=2)
    'pageName' => 'page',

    // Параметры стилей для пагинации (опционально)
    'styles' => [
        'wrapperClass' => 'pagination',
        'activeClass' => 'active',
        'disabledClass' => 'disabled',
    ],

];
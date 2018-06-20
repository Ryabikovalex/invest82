<?php
//Загрузка конфигурации
require_once  'core/config.php';
LOAD_CONFIGURATION('config.ini');
//require_once 'core/autoloader.php';
require_once 'utils/translit_func.php';
require_once 'utils/format.php';

//Подключение базы данных
require_once 'core/Database.php';
Database::instance( PDO['host'], PDO['database'], PDO['charset'], PDO['user'], PDO['password']);
//Запускаем пользователей
//require_once 'core/user.php';

//Подключаем модели, виды, контроллеры
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
//Подключаем маршрутизатор
require_once 'core/route.php';
Route::start();
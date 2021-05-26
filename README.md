## Про плагин

<p>
Сделан на основе шаблона: 
<a href="https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/tree/master/plugin-name" target="_blank">
DevinVinson/WordPress-Plugin-Boilerplate
</a>
</p>

## Настройка xDebug для PhpStorm в рамках текущей среды

<p>
Подробнее тут про xDebug 3 и, конкретно, про опции в вашем редакторе и сопутствующих расширениях:
 <a href="https://www.wpdiaries.com/wordpress-with-xdebug-for-docker/#building-an-image" target="_blank">
как добавить XDebug в официальный образ Docker WordPress
</a>
</p>


### Файловая структура

```
tp-wp-site
├── backend
│   └── wp-content
│       └── plugins
|           └── kvasov
|               ├── admin
|               |   ├── css
|               |   |   └── kvasov-admin.css
|               |   ├── js
|               |   |   └── kvasov-admin.js
|               |   ├── partials
|               |   |   └── kvasov-admin-display.php
|               |   ├── class-kvasov-admin.php
|               |   └── index.php
|               ├── build
|               |   ├── index.asset.php
|               |   └── index.js
|               ├── includes
|               |   ├── class-kvasov.php
|               |   ├── class-kvasov-activator.php
|               |   ├── class-kvasov-deactivator.php
|               |   ├── class-kvasov-i18n.php
|               |   ├── class-kvasov-loader.php
|               |   └── index.php
|               ├── languages
|               |   └── kvasov.pot
|               ├── public
|               |   ├── css
|               |   |   └── kvasov-public.css
|               |   ├── js
|               |   |   └── kvasov-public.js
|               |   ├── partials
|               |   |   └── class-kvasov-public.php
|               |   ├── shortcodes
|               |   |   └── shortcode-kvasov-example.php
|               |   ├── class-kvasov-public.php
|               |   └── index.php
|               ├── src
|               |   └── index.js
|               ├── index.php
|               ├── kvasov.php
|               ├── LICENSE.txt
|               ├── package.json
|               ├── README.txt
|               └── uninstall.php
├── config
│   └── php.conf.ini
├── database
│   └── .keep
├── docker
│   ├── .env.example 
│   └── docker-compose.yaml
├── xdebug
|   ├── files-to-copy
|   |   └── usr
|   |       └── local
|   |           └── etc
|   |               └── php
|   |                   └── conf.d
|   |                       └── xdebug.ini
|   └── Dockerfile 
├── .gitignore
└── README.md
```

### Команды

<p>Выполняется в директории ./docker</p>

* ``` cp .env.example .env``` - копировать файл конфигурации среды
* ``` docker-compose up --build ``` или ``` docker-compose up --build -d ``` - запуск контейнера в фоновом режиме
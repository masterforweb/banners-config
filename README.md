# Banners Config

**Wordpress Ads plugin**

**License:** GPLv3  
**License URI:** [GPL-3.0](https://www.gnu.org/licenses/gpl-3.0.html)

## Установка

- Склонировать или распаковать в папку `wp-content/plugins/banners-config`
- Активировать **Banners Config** в разделе плагинов WordPress
- При активации плагина будет создан файл конфигурации в `wp-content/banners-config.php`
- Заполните данные баннера в таком формате:

```php
'test_240x400' => [ # любое удобное название
    'id' => 1, # id в Медиатеке WordPress
    'url' => '', # ссылка для перехода (необязательный)
    'erid' => '', # маркеровка рекламы (необязательный), при заполнении параметра erid в url не указывать
    'width' => 240, # ширина файла (необязательный)
    'height' => 400, # высота файла (необязательный)
    'active' => 1 # 0 - выключить, 1 - включить (необязательный)
],
```

## Использование в коде


#### С проверкой установленного плагина

```php
if (function_exists( 'banners_conf_display' )){
   banners_conf_display( 'test_240x400' );
}
```
#### Более легкий, но небезопасный код. При отключении плагина сайт может выдавать 500 ошибку

```php
<?php banners_conf_display( 'test_240x400' );?>
```

#### Cамый компактный код (небезопасный)
```php
<?banners_conf_display('test_240x400')?>
```

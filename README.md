# Инструкция по настройке проекта

## Все команды выполняются из корнейвой директории

## 1. Установка зависимостей
```bash
composer install
```

## 2. Заполните переменные окружения
* В корне проекта создайте текстовый файл .env без расширения
* Заполните необходимые для подключения к БД данные
* Пример можно найти в файле .env.example

## 3. Настройка MySQL
***Все значения с префиксом DB_ нужно взять из результата предыдущего пункта*** 
```MySQL
CREATE DATABASE 'DB_NAME';
CREATE USER 'DB_USER'@'DB_HOST' IDENTIFIED BY 'DB_PASS';
GRANT ALL PRIVILEGES ON 'DB_NAME'.* TO 'DB_USER'@'DB_HOST';
FLUSH PRIVILEGES;
```

## 4. Создание схемы базы данных
```bash
   php bin/doctrine.php orm:schema-tool:create
```

## 5. Импорт категорий из JSON
```bash
   php bin/import.php
```
## 6. Экспорт категорий
### Тип А:
```bash
   php bin/export.php a text_a.txt
```
### Тип Б:
```bash
   php bin/export.php b text_b.txt
```

## 7. Запуск локального сервера
```bash
   php -S 127.0.0.1:8000
```

## 8. Доступ к меню
Меню в виде списка доступно по адресу:

http://127.0.0.1:8000/list_menu.php
# Инструкция по настройке проекта

## Все команды выполняются из корнейвой директории

## 1. Установка зависимостей
```bash
composer install
```

## 2. Настройка MySQL
```MySQL
CREATE DATABASE vladlink_test;
CREATE USER 'vladlink_test_user'@'localhost' IDENTIFIED BY 'vladlink_test_password';
GRANT ALL PRIVILEGES ON vladlink_test.* TO 'vladlink_test_user'@'localhost';
FLUSH PRIVILEGES;
```

## 3. Создание схемы базы данных
```bash
   php bin/doctrine.php orm:schema-tool:create
```

## 4. Импорт категорий из JSON
```bash
   php bin/import.php
```
## 5. Экспорт категорий
### Тип А:
```bash
   php bin/export.php a text_a.txt
```
### Тип Б:
```bash
   php bin/export.php b text_b.txt
```

## 6. Запуск локального сервера
```bash
   php -S 127.0.0.1:8000
```

## 7. Доступ к меню
Меню в виде списка доступно по адресу:

http://127.0.0.1:8000/list_menu.php
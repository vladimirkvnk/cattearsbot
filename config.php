<?php
/**
 * Файл конфигурации для Cat Tears Bot
 */

// Загрузка переменных окружения
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Данные для подключения к Telegram Bot API
return [
    // Обязательные параметры
    'api_key' => $_ENV['BOT_TOKEN'], // API ключ из .env файла
    
    // Дополнительные параметры
    'bot_username' => $_ENV['BOT_USERNAME'], // Имя бота из .env файла
];
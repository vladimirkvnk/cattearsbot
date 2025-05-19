<?php
/**
 * Файл для запуска бота в режиме getUpdates (опрос сервера Telegram)
 */

// Отключаем вывод предупреждений устаревшего кода
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Подключаем автозагрузчик Composer
require_once __DIR__ . '/vendor/autoload.php';

// Загружаем конфигурацию
$config = require_once __DIR__ . '/config.php';

try {
    // Создаем экземпляр Telegram бота
    $telegram = new Longman\TelegramBot\Telegram($config['api_key'], $config['bot_username']);

    // Выключаем работу с базой данных
    $telegram->useGetUpdatesWithoutDatabase();
    
    // Включаем логирование ошибок (опционально)
    Longman\TelegramBot\TelegramLog::initialize();
    
    // Добавляем путь к пользовательским командам
    $telegram->addCommandsPaths([
        __DIR__ . '/src/Commands',
    ]);
    
    // Отключаем webhook перед использованием getUpdates
    $telegram->deleteWebhook();
    
    echo "Запуск бота в режиме getUpdates...\n";
    echo "Нажмите Ctrl+C для остановки\n";
    
    // Запускаем бота в режиме getUpdates
    while (true) {
        $server_response = $telegram->handleGetUpdates();
        
        if ($server_response->isOk()) {
            $update_count = count($server_response->getResult());
            echo date('Y-m-d H:i:s') . ' - Обработано обновлений: ' . $update_count . "\n";
        } else {
            echo date('Y-m-d H:i:s') . ' - Ошибка: ' . $server_response->getDescription() . "\n";
        }
        
        // Пауза между запросами
        sleep(5);
    }
    
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Логируем ошибки
    echo $e->getMessage() . "\n";
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    // Ошибка при инициализации логирования
    echo $e->getMessage() . "\n";
}
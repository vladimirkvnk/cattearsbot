<?php

namespace CatTearsBot\Commands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Команда Start
 */
class StartCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = "start";

    /**
     * @var string
     */
    protected $description = "Команда Start";

    /**
     * @var string
     */
    protected $usage = "/start";

    /**
     * @var string
     */
    protected $version = "1.0.0";

    /**
     * Выполнение команды
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        // Создаем клавиатуру с основными кнопками
        $keyboard = (new Keyboard())->get();
        $keyboard->setResizeKeyboard(true);

        $text = "Привет! Я бот поддержки. 💖\n";
        $text .=
            "Ты можешь поговорить со мной, получить совет или упражнение для успокоения.";

        $data = [
            "chat_id" => $chat_id,
            "text" => $text,
            "reply_markup" => $keyboard,
        ];

        return $this->replyToChat("", $data);
    }
}

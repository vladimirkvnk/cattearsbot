<?php

namespace CatTearsBot\Commands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Exception\TelegramException;

/**
 * Обработчик обычных текстовых сообщений
 */
class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = "genericmessage";

    /**
     * @var string
     */
    protected $description = "Обработка обычных текстовых сообщений";

    /**
     * @var string
     */
    protected $version = "1.0.0";

    /**
     * Поддерживающие фразы
     * @var array
     */
    private $support_messages = [
        "Ты не одна, я здесь, чтобы помочь тебе. 💖",
        "Ты сильная, и у тебя всё получится. 🌸",
        "Давай сделаем глубокий вдох... Ты справишься! 💫",
        "Ты заслуживаешь заботы и любви. Не забывай об этом. 🌼",
        "Иногда нужно просто выдохнуть. Я рядом. 💕",
    ];

    /**
     * Советы по самопомощи
     * @var array
     */
    private $self_help_tips = [
        "🔹 Попробуй вести дневник: записывай свои мысли и чувства.",
        "🔹 Выдели 10 минут на медитацию или просто тишину.",
        "🔹 Сделай что-то приятное для себя: чай, книга, теплый плед.",
        "🔹 Позвони близкому человеку и поговори о своих переживаниях.",
        "🔹 Пройдись на свежем воздухе, даже если всего 5 минут.",
    ];

    /**
     * Дыхательные упражнения
     * @var array
     */
    private $breathing_exercises = [
        "🌬 4-7-8 дыхание: Вдох на 4 сек → задержка на 7 сек → выдох на 8 сек. Повтори 3 раза.",
        "🌿 Глубокое дыхание: Медленно вдохни через нос, задержка 2 сек, выдох через рот. 5 раз.",
        "🌸 Квадратное дыхание: Вдох 4 сек → пауза 4 сек → выдох 4 сек → пауза 4 сек. 3 цикла.",
    ];

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
        $text = $message->getText();

        // Создаем клавиатуру с основными кнопками
        $keyboard = (new Keyboard())->get();
        $keyboard->setResizeKeyboard(true);

        // Текст с ответом пользователю
        $response = "";

        switch ($text) {
            case SupportButton:
                $response =
                    $this->support_messages[
                        array_rand($this->support_messages)
                    ];
                break;
            case ExercisesButton:
                $response =
                    $this->breathing_exercises[
                        array_rand($this->breathing_exercises)
                    ];
                break;
            case AdvicesButton:
                // Выбираем 3 случайных совета
                $keys = array_rand($this->self_help_tips, 3);
                $selected_tips = [];
                foreach ($keys as $key) {
                    $selected_tips[] = $this->self_help_tips[$key];
                }
                $response = implode("\n", $selected_tips);
                break;
            case EmergencyButton:
                $response =
                    "Если тебе очень тяжело, пожалуйста, обратись за помощью:\n" .
                    "📞 Телефон доверия: 8-800-2000-122 (круглосуточно)\n" .
                    "✉️ Чат психологической помощи: https://www.psychologies.ru/";
                break;
            default:
                // Ответ на неизвестную команду
                $response =
                    "Я не совсем понимаю, но ты можешь нажать на кнопку меню. 💕";
        }

        $data = [
            "chat_id" => $chat_id,
            "text" => $response,
            "reply_markup" => $keyboard,
        ];

        return Request::sendMessage($data);
    }
}

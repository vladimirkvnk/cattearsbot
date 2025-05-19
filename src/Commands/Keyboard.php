<?php

namespace CatTearsBot\Commands;

use Longman\TelegramBot\Entities\Keyboard as TelegramKeyboard;

const SupportButton = "💬 Поддержка";
const ExercisesButton = "🧘‍♀️ Упражнения для успокоения";
const AdvicesButton = "📚 Советы по самопомощи";
const EmergencyButton = "🆘 Срочная помощь";

class Keyboard
{
    private TelegramKeyboard $data;

    public function __construct()
    {
        $this->data = new TelegramKeyboard(
            [SupportButton],
            [ExercisesButton],
            [AdvicesButton],
            [EmergencyButton]
        );
    }

    public function get(): TelegramKeyboard
    {
        return $this->data;
    }
}

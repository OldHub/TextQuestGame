<?php
namespace Modules\Clients\Vk\Bot\BotKeyboard;

class KeyboardFactory
{

    public static function createKeyboard(): Keyboard
    {
        return new Keyboard();
    }

}

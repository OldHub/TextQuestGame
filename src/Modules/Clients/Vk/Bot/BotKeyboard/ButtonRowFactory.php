<?php
namespace Modules\Clients\Vk\Bot\BotKeyboard;

class ButtonRowFactory
{

    public static function createRow(): ButtonRow
    {

        return new ButtonRow();
    }

}

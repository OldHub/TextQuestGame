<?php

namespace Modules\Clients\Vk\Bot\Response;

use Modules\Clients\Vk\Bot\BotKeyboard\Button;
use Modules\Clients\Vk\Bot\BotKeyboard\ButtonRowFactory;
use Modules\Clients\Vk\Bot\BotKeyboard\KeyboardFactory;
use Modules\Vk\Dto\Response\MessageDto;
use VK\Client\VKApiClient;

class ActionResponse
{
    private array $botStandardMessages;
    private array $botButtonLabels;

    public function __construct(
        private MessageDto $dto,
        private VKApiClient $vkApiClient,
        private string $accessToken
    ) {
        $this->botStandardMessages    = config('bot_messages');
        $this->botButtonLabels        = config('bot_button_names');
    }

    public function start(): void
    {
        $btnFaq       = Button::create(['button' => 'faq'], $this->botButtonLabels['faq'], 'primary');
        $btnAbout     = Button::create(['button' => 'about'], $this->botButtonLabels['about'], 'primary');
        $btnMoneyBack = Button::create(['button' => 'reviews'], $this->botButtonLabels['reviews'], 'primary');
        $btnStock     = Button::create(['button' => 'stock'], $this->botButtonLabels['stock'], 'positive');

        $btnRow1 = ButtonRowFactory::createRow()
            ->addButton($btnFaq)
            ->addButton($btnAbout)
            ->getRow();

        $btnRow2 = ButtonRowFactory::createRow()
            ->addButton($btnMoneyBack)
            ->getRow();

        $btnRow3 = ButtonRowFactory::createRow()
            ->addButton($btnStock)
            ->getRow();

        $kb = KeyboardFactory::createKeyboard()
            ->addRow($btnRow1)
            ->addRow($btnRow2)
            ->addRow($btnRow3)
            ->setOneTime(false)
            ->getKeyboardJson();

        $params = [
            'user_id'          => $this->dto->from_id,
            'message'          => $this->botStandardMessages['start_message'],
            'keyboard'         => $kb,
            'random_id'        => random_int(0, 2 ** 31),
            'forward_messages' => $this->dto->id,
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }
}

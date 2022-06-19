<?php

namespace App\VkontakteBot\Response;

use App\VkontakteBot\BotKeyboard\Button;
use App\VkontakteBot\BotKeyboard\ButtonRowFactory;
use App\VkontakteBot\BotKeyboard\KeyboardFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use VK\Client\VKApiClient;

class ActionResponse
{
    private array $botStandardMessages;
    private array $botStandardAttachments;
    private array $botButtonLabels;

    public function __construct(
        private Request $request,
        private VKApiClient $vkApiClient,
        private string $accessToken
    ) {
        $this->botStandardMessages    = config('bot_messages');
        $this->botStandardAttachments = config('bot_vk_media_attachments');
        $this->botButtonLabels        = config('bot_button_names');
    }

    public function start(): bool
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
            'user_id'          => $this->request->object['message']['from_id'],
            'message'          => $this->botStandardMessages['start_message'],
            'keyboard'         => $kb,
            'random_id'        => random_int(0, 2 ** 31),
            'forward_messages' => $this->request->object['message']['id'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);

        return true;
    }

    public function faqClick()
    {
        $userId = $this->request->object['message']['from_id'];

        Cache::put("dialog_step_$userId", 'faq', 5);

        $btnFaqBuy       = Button::create(['button' => 'faq_buy'], $this->botButtonLabels['faq_buy'], 'primary');
        $btnFaqPayment   = Button::create(['button' => 'faq_payment'], $this->botButtonLabels['faq_payment'],
            'primary');
        $btnFaqDelivery  = Button::create(['button' => 'faq_delivery'], $this->botButtonLabels['faq_delivery'],
            'primary');
        $btnFaqMoneyBack = Button::create(['button' => 'faq_money_back'], $this->botButtonLabels['faq_money_back'],
            'primary');
        $btnBackToStart  = Button::create(['button' => 'start'], $this->botButtonLabels['start'], 'negative');

        $btnRow1 = ButtonRowFactory::createRow()
            ->addButton($btnFaqBuy)
            ->addButton($btnFaqPayment)
            ->addButton($btnFaqDelivery)
            ->addButton($btnFaqMoneyBack)
            ->getRow();

        $btnRow2 = ButtonRowFactory::createRow()
            ->addButton($btnBackToStart)
            ->getRow();

        $kb = KeyboardFactory::createKeyboard()
            ->addRow($btnRow1)
            ->addRow($btnRow2)
            ->setOneTime(true)
            ->getKeyboardJson();

        $params = [
            'user_id'   => $userId,
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['faq_message'],
            'keyboard'  => $kb,
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function faqBuyClick()
    {
        $params = [
            'user_id'    => $this->request->object['message']['from_id'],
            'random_id'  => random_int(0, 2 ** 31),
            'message'    => $this->botStandardMessages['faq_buy_message'],
            'attachment' => $this->botStandardAttachments['faq_buy_attachment'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function faqPaymentClick()
    {
        $params = [
            'user_id'    => $this->request->object['message']['from_id'],
            'random_id'  => random_int(0, 2 ** 31),
            'message'    => $this->botStandardMessages['faq_payment_message'],
            'attachment' => $this->botStandardAttachments['faq_payment_attachment'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function faqDeliveryClick()
    {
        $params = [
            'user_id'    => $this->request->object['message']['from_id'],
            'random_id'  => random_int(0, 2 ** 31),
            'message'    => $this->botStandardMessages['faq_delivery_message'],
            'attachment' => $this->botStandardAttachments['faq_delivery_attachment'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function faqMoneyBackClick()
    {
        $params = [
            'user_id'    => $this->request->object['message']['from_id'],
            'random_id'  => random_int(0, 2 ** 31),
            'message'    => $this->botStandardMessages['faq_money_back_message'],
            'attachment' => $this->botStandardAttachments['faq_money_back_attachment'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function aboutClick()
    {
        $userId = $this->request->object['message']['from_id'];

        Cache::put("dialog_step_$userId", 'about', 5);

        $btnAboutShop    = Button::create(['button' => 'about_shop'], $this->botButtonLabels['about_shop'], 'primary');
        $btnAboutWorkers = Button::create(['button' => 'about_workers'], $this->botButtonLabels['about_workers'],
            'primary');
        $btnBackToStart  = Button::create(['button' => 'start'], $this->botButtonLabels['start'], 'negative');

        $btnRow1 = ButtonRowFactory::createRow()
            ->addButton($btnAboutShop)
            ->addButton($btnAboutWorkers)
            ->getRow();

        $btnRow2 = ButtonRowFactory::createRow()
            ->addButton($btnBackToStart)
            ->getRow();

        $kb = KeyboardFactory::createKeyboard()
            ->addRow($btnRow1)
            ->addRow($btnRow2)
            ->setOneTime(true)
            ->getKeyboardJson();

        $params = [
            'user_id'   => $userId,
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['about_message'],
            'keyboard'  => $kb,
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function aboutShopClick()
    {
        $params = [
            'user_id'   => $this->request->object['message']['from_id'],
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['about_shop_message'],
            'lat'       => config('bot_map_coordinates.main_shop.lat'),
            'long'      => config('bot_map_coordinates.main_shop.long'),
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function aboutWorkersClick()
    {
        $params = [
            'user_id'    => $this->request->object['message']['from_id'],
            'random_id'  => random_int(0, 2 ** 31),
            'message'    => $this->botStandardMessages['about_workers_message'],
            'attachment' => $this->botStandardAttachments['about_workers_attachment'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function reviewsClick()
    {
        $userId = $this->request->object['message']['from_id'];

        Cache::put("dialog_step_$userId", 'reviews', 5);

        $params = [
            'user_id'   => $userId,
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['reviews_message'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function stockClick()
    {
        $userId = $this->request->object['message']['from_id'];

        Cache::put("dialog_step_$userId", 'stock', 5);

        $btnStock1      = Button::create(['button' => 'stock_1'], $this->botButtonLabels['stock_1'], 'primary');
        $btnStock2      = Button::create(['button' => 'stock_2'], $this->botButtonLabels['stock_2'], 'primary');
        $btnStock3      = Button::create(['button' => 'stock_3'], $this->botButtonLabels['stock_3'], 'primary');
        $btnStock4      = Button::create(['button' => 'stock_4'], $this->botButtonLabels['stock_4'], 'primary');
        $btnBackToStart = Button::create(['button' => 'start'], $this->botButtonLabels['start'], 'negative');

        $btnRow1 = ButtonRowFactory::createRow()
            ->addButton($btnStock1)
            ->addButton($btnStock2)
            ->getRow();

        $btnRow2 = ButtonRowFactory::createRow()
            ->addButton($btnStock3)
            ->addButton($btnStock4)
            ->getRow();

        $btnRow3 = ButtonRowFactory::createRow()
            ->addButton($btnBackToStart)
            ->getRow();

        $kb = KeyboardFactory::createKeyboard()
            ->addRow($btnRow1)
            ->addRow($btnRow2)
            ->addRow($btnRow3)
            ->setOneTime(true)
            ->getKeyboardJson();

        $params = [
            'user_id'   => $userId,
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['stock_message'],
            'keyboard'  => $kb,
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function stock1Click()
    {
        $params = [
            'user_id'   => $this->request->object['message']['from_id'],
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['stock_1_message'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function stock2Click()
    {
        $params = [
            'user_id'   => $this->request->object['message']['from_id'],
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['stock_2_message'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function stock3Click()
    {
        $params = [
            'user_id'   => $this->request->object['message']['from_id'],
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['stock_3_message'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function stock4Click()
    {
        $userId = $this->request->object['message']['from_id'];

        Cache::put("dialog_step_$userId", 'stock_4_bonus_code_entry', 5);

        $params = [
            'user_id'   => $userId,
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['stock_4_message'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function checkBonusCode()
    {
        $bonusCodes = [
            'bonus10' => '👌Ваш бонус -10% от стоимости товара при покупке.',
            'bonus30' => '👌Ваш бонус -30% на покупку свыше 10 000 попугаев.',
        ];

        $userBonusCode = strtolower($this->request->object['text']);

        $message = array_key_exists($userBonusCode, $bonusCodes)
            ? $bonusCodes[$userBonusCode]
            : $this->botStandardMessages['stock_4_check_bonus_fail_message'];

        $params = [
            'user_id'   => $this->request->object['message']['from_id'],
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $message,
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }

    public function defaultResponse()
    {
        $params = [
            'user_id'   => $this->request->object['message']['from_id'],
            'random_id' => random_int(0, 2 ** 31),
            'message'   => $this->botStandardMessages['default_message'],
        ];

        $this->vkApiClient->messages()->send($this->accessToken, $params);
    }
}

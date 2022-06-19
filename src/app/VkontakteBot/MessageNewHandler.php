<?php

namespace App\VkontakteBot;

use App\VkontakteBot\Response\ActionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use JsonException;
use VK\Client\VKApiClient;

abstract class MessageNewHandler implements RequestTypeHandlerInterface
{

    /**
     * @param Request $request
     * @throws JsonException
     */
    public static function handle(Request $request): void
    {
        $userId = $request->object['message']['from_id'];

        $dialogStep = Cache::remember("dialog_step_$userId", 5,
            static function () {
                return 'start';
            }
        );

        if (isset($request->object['message']['payload'])) {
            $payload = json_decode($request->object['message']['payload'], true, 512, JSON_THROW_ON_ERROR);
            Log::alert($payload);
            if (isset($payload['button'])) {
                $dialogStep = $payload['button'];
            }
        }

        $actionResponse = new ActionResponse(
            $request,
            new VKApiClient(config('vk.api.version')),
            config('vk.secrets.group')
        );

        $map = [
            'start' => fn ($actionResponse) => $actionResponse->start()
        ];

        $map[$dialogStep]($actionResponse);
    }
}

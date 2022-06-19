<?php

namespace App\VkontakteBot;

use App\VkontakteBot\Response\ActionResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use JsonException;
use Modules\Vk\Dto\Response\MessageDto;
use VK\Client\VKApiClient;

class MessageNewHandler
{

    /**
     * @throws JsonException
     */
    public static function handle(MessageDto $dto): void
    {
        $userId = $dto->from_id;

        $dialogStep = Cache::remember("dialog_step_$userId", 5,
            static function () {
                return 'start';
            }
        );

        if (isset($dto->payload)) {
            $payload = json_decode($dto->payload, true, 512, JSON_THROW_ON_ERROR);
            Log::alert($payload);
            if (isset($payload['button'])) {
                $dialogStep = $payload['button'];
            }
        }

        $actionResponse = new ActionResponse(
            $dto,
            new VKApiClient(config('vk.api.version')),
            config('vk.secrets.group')
        );

        $map = [
            'start' => fn ($actionResponse) => $actionResponse->start()
        ];

        $map[$dialogStep]($actionResponse);
    }
}

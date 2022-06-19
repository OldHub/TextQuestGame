<?php

namespace App\Http\Controllers;

use App\VkontakteBot\MessageNewHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JsonException;
use Modules\Vk\Dto\Response\Dto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class VkApiCallbackController extends Controller
{
    /**
     * @throws JsonException
     * @throws UnknownProperties
     */
    public function execute(Request $request): ?string
    {
        $dto = new Dto($request->all());
        dd($dto);

        if ($dto->secret !== config('vk.secrets.callback')) {
            return null;
        }

        if ($dto->type === 'confirmation') {
            return config('vk.secrets.init');
        }

        if ($dto->type === 'message_new') {
            MessageNewHandler::handle($dto->object);
        }

        return null;
    }
}

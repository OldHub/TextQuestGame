<?php

namespace Modules\Clients\Vk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JsonException;
use Modules\Clients\Vk\Bot\MessageNewHandler;
use Modules\Vk\Dto\Response\Dto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CallbackController extends Controller
{
    /**
     * @throws JsonException
     * @throws UnknownProperties
     */
    public function execute(Request $request): ?string
    {
        $dto = new Dto($request->all());

        if ($dto->secret !== config('vk.secrets.callback')) {
            return null;
        }

        if ($dto->type === 'confirmation') {
            return config('vk.secrets.init');
        }

        if ($dto->type === 'message_new') {
            MessageNewHandler::handle($dto->object->message);
        }

        return null;
    }
}

<?php

namespace Modules\Vk\Dto\Response;

use Spatie\DataTransferObject\DataTransferObject;

class ObjectDto extends DataTransferObject
{
    public MessageDto $message;
    public ?array     $client_info;
}

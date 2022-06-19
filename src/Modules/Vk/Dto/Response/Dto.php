<?php

namespace Modules\Vk\Dto\Response;

use Spatie\DataTransferObject\DataTransferObject;

class Dto extends DataTransferObject
{
    public ?int    $group_id;
    public ?string $type;
    public ?string $event_id;
    public ?string $v;
    public ?string $secret;

    public ObjectDto $object;
}

<?php

namespace Modules\Vk\Dto\Response;

use Spatie\DataTransferObject\DataTransferObject;

class MessageDto extends DataTransferObject
{
    public int $from_id;
    public int $id;
    public string $text;
}

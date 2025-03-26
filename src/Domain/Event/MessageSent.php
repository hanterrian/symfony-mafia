<?php

namespace App\Domain\Event;

use App\Domain\Enum\ChatType;
use DateTimeImmutable;

class MessageSent
{
    public function __construct(
        public readonly string            $gameCode,
        public readonly string            $senderName,
        public readonly string            $content,
        public readonly ChatType          $chatType,
        public readonly DateTimeImmutable $timestamp
    )
    {
    }
}

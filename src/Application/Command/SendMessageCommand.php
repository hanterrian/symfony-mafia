<?php

namespace App\Application\Command;

use App\Domain\Enum\ChatType;

class SendMessageCommand
{
    public function __construct(
        public string   $gameCode,
        public string   $senderName,
        public string   $content,
        public ChatType $chatType = ChatType::GENERAL
    )
    {
    }
}

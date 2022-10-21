<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Text;
use Post\CommandModel\UserName;
use Post\CommandModel\Uuid;

final class QuoteCommand
{
    public function __construct(
        public readonly Uuid $targetPostId,
        public readonly UserName $userName,
        public readonly Text $text
    ){
    }
}

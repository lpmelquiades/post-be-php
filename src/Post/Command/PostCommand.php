<?php

declare(strict_types=1);

namespace Post\Command;

use Post\CommandModel\ExceptionReference;
use Post\CommandModel\Text;
use Post\CommandModel\UserName;

final class PostCommand
{
    public function __construct (
        public readonly UserName $userName,
        public readonly Text $text
    ){
    }
}

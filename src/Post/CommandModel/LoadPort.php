<?php

declare(strict_types=1);

namespace Post\CommandModel;

interface LoadPort
{
    public function segment(UserName $userName, Timestamp $begin, Timestamp $end): Segment;

    public function original(Uuid $quote): Original;
}

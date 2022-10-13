<?php

declare(strict_types=1);

namespace Post\CommandModel;

final class Post {
    public function post(){
        return 'post';
    }
    public function repost(){
        return 'repost';
    }
    public function quote(){
        return 'quote';
    }
}
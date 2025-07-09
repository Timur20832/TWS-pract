<?php

namespace App\DTO\Post;

class CreatePostDto
{
    public string $title;
    public string $text;

    public function __construct(string $title, string $text)
    {
        $this->text = $text;
        $this->title = $title;
    }
}

<?php

namespace App\DTO\Post;

class CreatePostDto
{
    public string $title;
    public string $content;

    public function __construct(string $title, string $content)
    {
        $this->content = $content;
        $this->title = $title;
    }
}

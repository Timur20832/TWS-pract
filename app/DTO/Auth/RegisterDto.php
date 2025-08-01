<?php

namespace App\DTO\Auth;

class RegisterDto
{
    public string $name;
    public string $email;
    public string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
    }
}

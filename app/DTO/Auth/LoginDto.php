<?php

namespace App\DTO\Auth;

class LoginDto
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->password = $password;
        $this->email = $email;
    }
    
}

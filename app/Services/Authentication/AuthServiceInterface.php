<?php

namespace App\Services\Authentication;

interface AuthServiceInterface
{
    public function login(array $data);
}
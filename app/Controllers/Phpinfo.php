<?php

namespace App\Controllers;

class Phpinfo extends BaseController
{
    public function index(): string
    {
        return phpinfo();
    }
}

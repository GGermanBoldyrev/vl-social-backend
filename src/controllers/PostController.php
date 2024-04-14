<?php

namespace src\controllers;

use src\interfaces\ControllerInterface;

class PostController implements ControllerInterface
{
    public function index()
    {
        echo "posts";
    }

    public function show()
    {
        echo "show";
    }
}
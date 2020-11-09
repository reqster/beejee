<?php

namespace BeeJee\Controller;

abstract class Controller 
{
    public $renderer;
    public $user;

    public function __construct($container)
    {
        $this->renderer = $container['renderer'];
        $this->user = $container['user'];
    }
}
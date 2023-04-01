<?php

namespace Tests\Interfaces;

interface Mock
{
    public static function create(array $params = []): Object;

    public static function make(array $params = []): Object;
}




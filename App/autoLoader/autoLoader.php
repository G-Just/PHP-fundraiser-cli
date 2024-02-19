<?php

spl_autoload_register('classLoader');

function classLoader($className)
{
    include_once __DIR__ . '/../../' . $className . '.php';
}

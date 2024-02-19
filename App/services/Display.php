<?php

namespace App\services;

class Display
{
    /**
     * Displays a formatted "echo" message
     */
    public static function out(string $data, int $breaks = 2): void
    {
        echo "\n" . $data . str_repeat("\n", $breaks);
    }

    /**
     * Returns a formatted "readline" message
     */
    public static function in(string $data): string
    {
        return readline(" > " . $data . " : ");
    }
}

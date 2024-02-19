<?php

namespace App\services;

class Table
{
    /**
     * Forms and echoes a charity table
     */
    public static function charityTable(array $data): void
    {
        $mask = "|%5.5s |%-40.40s |%-50.50s |\n";
        echo "______________________________________________________________________________________________________\n";
        printf($mask, 'ID', 'Name', 'Email');
        echo "|------|-----------------------------------------|---------------------------------------------------|\n";
        foreach ($data as $charity) {
            printf($mask, $charity->id, $charity->name, $charity->email);
            echo "|______|_________________________________________|___________________________________________________|\n";
        }
        echo "\n";
    }
}

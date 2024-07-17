<?php

namespace App\services;

class Table
{
    /**
     * Forms and displays a charities table
     */
    public static function charityTable(array $data): void
    {;
        // Counts how many properties are in the object
        $propertyCount = count(get_object_vars($data[0])) - 1;

        $mask = "|%5.5s |" . str_repeat("%-30.30s |", $propertyCount) . "\n";
        echo str_repeat('_', $propertyCount * 32 + 8) . "\n";
        printf($mask, 'ID', 'Name', 'Email', 'Donations Collected (in USD)', 'Amount of donations');
        echo "|------|" . str_repeat(str_repeat('-', 31) . '|', $propertyCount) . "\n";
        foreach ($data as $charity) {
            printf(
                $mask,
                $charity->id,
                $charity->name,
                $charity->email,
                '$' . number_format($charity->collected, 2),
                $charity->donationCount
            );
            echo "|______|" . str_repeat(str_repeat('_', 31) . '|', $propertyCount) . "\n";
        }
        echo "\n";
    }
}

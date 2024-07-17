<?php

namespace App\services;

class Table
{
    /**
     * Forms and displays a charity table
     */
    public static function charityTable(array $data): void
    {;
        $properties = [];
        foreach (get_object_vars($data[0]) as $key => $value) {
            array_push($properties, ucfirst(preg_replace('/(?<!\ )[A-Z]/', ' $0', $key)));
        };
        $propertyCount = count($properties) - 1;

        $mask = "|%5.5s |" . str_repeat("%-30.30s |", $propertyCount) . "\n";

        echo str_repeat('_', $propertyCount * 32 + 8) . "\n";
        vprintf($mask, $properties);
        echo "|------|" . str_repeat(str_repeat('-', 31) . '|', $propertyCount) . "\n";
        foreach ($data as $charity) {
            printf(
                $mask,
                $charity->id,
                $charity->name,
                $charity->email,
                '$' . number_format($charity->totalDonationsCollected, 2),
                $charity->donationCount
            );
            echo "|______|" . str_repeat(str_repeat('_', 31) . '|', $propertyCount) . "\n";
        }
        echo "\n";
    }
}

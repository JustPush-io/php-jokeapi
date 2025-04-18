<?php

require_once 'JokeAPI/JokeClient.php';

use JokeAPI\JokeClient;
use JokeAPI\JokeConstants;

// Example 6: Get a specific type of joke (single or twopart)
$client = new JokeClient();
$joke = $client
    ->type(JokeConstants::TYPE_TWOPART)
    ->fetch();
echo "Two-part joke:\n";
printJoke($joke);
echo "\n";

/**
 * Helper function to print a joke
 */
function printJoke($joke) {
    if ($joke === null) {
        echo "Error fetching joke.\n";
        return;
    }

    if (isset($joke['error']) && $joke['error'] === true) {
        echo "API Error: " . ($joke['message'] ?? 'Unknown error') . "\n";
        return;
    }

    if (isset($joke['type']) && $joke['type'] === 'single') {
        echo $joke['joke'] . "\n";
    } elseif (isset($joke['type']) && $joke['type'] === 'twopart') {
        echo "Setup: " . $joke['setup'] . "\n";
        echo "Delivery: " . $joke['delivery'] . "\n";
    } else {
        echo "Unknown joke format.\n";
        print_r($joke);
    }
}
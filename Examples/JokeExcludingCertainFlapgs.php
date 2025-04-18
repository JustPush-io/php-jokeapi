<?php

require_once 'JokeAPI/JokeClient.php';

use JokeAPI\JokeClient;
use JokeAPI\JokeConstants;

// Example 3: Get a joke excluding certain flags
$client = new JokeClient();
$joke = $client
    ->blacklist([
        JokeConstants::FLAG_NSFW,
        JokeConstants::FLAG_RELIGIOUS,
        JokeConstants::FLAG_POLITICAL
    ])
    ->fetch();
echo "Joke without nsfw, religious, or political content:\n";
printJoke($joke);
echo "\n";

// Example 4: Search for jokes containing a specific string
$client = new JokeClient();
$joke = $client
    ->search('programmer')
    ->fetch();
echo "Joke containing 'programmer':\n";
printJoke($joke);
echo "\n";

// Example 5: Get a joke in a different language
$client = new JokeClient();
$joke = $client
    ->language(JokeConstants::LANG_GERMAN)
    ->fetch();
echo "German joke:\n";
printJoke($joke);
echo "\n";

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
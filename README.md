# JokeAPI PHP

A PHP wrapper for the [JokeAPI](https://v2.jokeapi.dev/).

## Installation

Currently, this package is not available on Packagist. To use it, simply clone this repository:

```bash
git clone https://github.com/yourusername/jokeapi-php.git
```

## Usage

```php
<?php

require_once 'path/to/JokeAPI/JokeClient.php';

use JokeAPI\JokeClient;
use JokeAPI\JokeConstants;

// Create a new JokeClient
$client = new JokeClient();

// Get a random joke
$joke = $client->fetch();

// Print the joke
if ($joke['type'] === 'single') {
    echo $joke['joke'];
} else {
    echo "Setup: " . $joke['setup'] . "\n";
    echo "Delivery: " . $joke['delivery'];
}
```

## Features

The JokeAPI PHP client supports all the features of the JokeAPI:

- Multiple categories
- Blacklist flags
- Different formats (JSON, XML)
- Joke types (single, twopart)
- Search functionality
- Specific joke IDs
- Multiple languages
- Safe mode

## Methods

### categories(array $categories)

Set the categories for the jokes.

```php
$client->categories([
    JokeConstants::CATEGORY_PROGRAMMING,
    JokeConstants::CATEGORY_MISC
]);
```

Available categories:
- `CATEGORY_ANY` (default)
- `CATEGORY_MISC`
- `CATEGORY_PROGRAMMING`
- `CATEGORY_DARK`
- `CATEGORY_PUN`
- `CATEGORY_SPOOKY`
- `CATEGORY_CHRISTMAS`

### blacklist(array $flags)

Set blacklist flags to filter jokes.

```php
$client->blacklist([
    JokeConstants::FLAG_NSFW,
    JokeConstants::FLAG_RELIGIOUS
]);
```

Available flags:
- `FLAG_NSFW`
- `FLAG_RELIGIOUS`
- `FLAG_POLITICAL`
- `FLAG_RACIST`
- `FLAG_SEXIST`
- `FLAG_EXPLICIT`

### format(string $format)

Set the response format (json or xml).

```php
$client->format('xml');
```

### type(string $type)

Set the joke type (single or twopart).

```php
$client->type(JokeConstants::TYPE_SINGLE);
```

Available types:
- `TYPE_SINGLE`
- `TYPE_TWOPART`

### search(string $searchString)

Search for jokes containing the specified string.

```php
$client->search('programmer');
```

### id(int $id)

Get a joke by ID.

```php
$client->id(42);
```

### language(string $language)

Set the language for the jokes.

```php
$client->language(JokeConstants::LANG_GERMAN);
```

Available languages:
- `LANG_ENGLISH` (default)
- `LANG_CZECH`
- `LANG_GERMAN`
- `LANG_SPANISH`
- `LANG_FRENCH`
- `LANG_PORTUGUESE`

### safe(bool $safe = true)

Enable safe mode (excludes nsfw jokes).

```php
$client->safe();
```

### fetch()

Fetch a joke from the API.

```php
$joke = $client->fetch();
```

## Chaining

All methods (except `fetch()`) return the client instance for method chaining:

```php
$joke = $client
    ->categories([JokeConstants::CATEGORY_PROGRAMMING])
    ->blacklist([JokeConstants::FLAG_NSFW])
    ->safe()
    ->fetch();
```

## License

MIT

## Credits

This is a PHP port of the [jokeapi Go package](https://github.com/Icelain/jokeapi) by Icelain.
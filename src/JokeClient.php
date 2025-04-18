<?php

namespace JokeAPI;

/**
 * JokeAPI PHP Client
 *
 * A PHP wrapper for the JokeAPI (https://v2.jokeapi.dev/)
 */
class JokeClient
{
    /**
     * Base URL for the JokeAPI
     */
    private string $baseUrl = 'https://v2.jokeapi.dev/joke/';

    /**
     * Categories for the jokes
     */
    private array $categories = [];

    /**
     * Blacklisted flags
     */
    private array $blacklistFlags = [];

    /**
     * Response format (json or xml)
     */
    private string $format = 'json';

    /**
     * Response type (single or twopart)
     */
    private ?string $type = null;

    /**
     * Search string
     */
    private ?string $searchString = null;

    /**
     * ID of the joke
     */
    private ?int $id = null;

    /**
     * Language of the joke
     */
    private string $language = 'en';

    /**
     * Safe mode (excludes nsfw jokes)
     */
    private bool $safe = false;

    /**
     * Constructor initializes the JokeClient with default 'Any' category
     */
    public function __construct()
    {
        $this->categories = ['Any'];
    }

    /**
     * Set the categories for the jokes
     *
     * @param array $categories Array of categories
     * @return JokeClient
     */
    public function categories(array $categories): JokeClient
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * Set blacklist flags to filter jokes
     *
     * @param array $flags Array of flags to blacklist
     * @return JokeClient
     */
    public function blacklist(array $flags): JokeClient
    {
        $this->blacklistFlags = $flags;
        return $this;
    }

    /**
     * Set the response format (json or xml)
     *
     * @param string $format Format for the response
     * @return JokeClient
     */
    public function format(string $format): JokeClient
    {
        $this->format = $format;
        return $this;
    }

    /**
     * Set the joke type (single or twopart)
     *
     * @param string $type Type of joke
     * @return JokeClient
     */
    public function type(string $type): JokeClient
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Search for jokes containing the specified string
     *
     * @param string $searchString String to search for
     * @return JokeClient
     */
    public function search(string $searchString): JokeClient
    {
        $this->searchString = $searchString;
        return $this;
    }

    /**
     * Get a joke by ID
     *
     * @param int $id ID of the joke
     * @return JokeClient
     */
    public function id(int $id): JokeClient
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the language for the jokes
     *
     * @param string $language Language code
     * @return JokeClient
     */
    public function language(string $language): JokeClient
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Enable safe mode (excludes nsfw jokes)
     *
     * @param bool $safe Whether to enable safe mode
     * @return JokeClient
     */
    public function safe(bool $safe = true): JokeClient
    {
        $this->safe = $safe;
        return $this;
    }

    /**
     * Builds the URL for the API request
     *
     * @return string The complete URL
     */
    private function buildUrl(): string
    {
        $url = $this->baseUrl . implode(',', $this->categories);
        $queryParams = [];

        if (!empty($this->blacklistFlags)) {
            $queryParams['blacklistFlags'] = implode(',', $this->blacklistFlags);
        }

        if ($this->format !== 'json') {
            $queryParams['format'] = $this->format;
        }

        if ($this->type !== null) {
            $queryParams['type'] = $this->type;
        }

        if ($this->searchString !== null) {
            $queryParams['contains'] = $this->searchString;
        }

        if ($this->id !== null) {
            $queryParams['idRange'] = $this->id;
        }

        if ($this->language !== 'en') {
            $queryParams['lang'] = $this->language;
        }

        if ($this->safe) {
            $queryParams['safe-mode'] = 'true';
        }

        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        return $url;
    }

    /**
     * Fetch a joke from the API
     *
     * @return array|null The joke data or null on error
     */
    public function fetch(): ?array
    {
        $url = $this->buildUrl();

        $response = $this->makeRequest($url);
        if ($response === false) {
            return null;
        }

        if ($this->format === 'json') {
            return json_decode($response, true);
        }

        // Return raw response for XML format
        return ['raw' => $response];
    }

    /**
     * Make an HTTP request to the API
     *
     * @param string $url URL to request
     * @return string|false Response data or false on failure
     */
    private function makeRequest(string $url)
    {
        $options = [
            'http' => [
                'header' => "Accept: application/" . $this->format . "\r\n",
                'method' => 'GET',
                'timeout' => 30
            ]
        ];

        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }
}
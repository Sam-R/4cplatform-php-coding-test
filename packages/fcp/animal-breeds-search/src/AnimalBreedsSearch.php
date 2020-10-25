<?php

namespace Fcp\AnimalBreedsSearch;

use Exception;
use Illuminate\Support\Facades\Http;

class AnimalBreedsSearch
{
    private $api_key;

    private $endpoint;

    private $version;

    /**
     * AnimalBreedSearch constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setConfig($config, ['api_key', 'endpoint', 'version']);
    }

    /**
     * Setup configuration for the API connection
     * @param  array     $config        Configuration settings for the API call.
     * @param  array     $required_keys Required keys for the API to work.
     * @throws Exception Exception if required key is missing.
     */
    public function setConfig(array $config, array $required_keys): void
    {
        foreach ($required_keys as $required_key) {
            if (array_key_exists($required_key, $config) === true) {
                $this->$required_key = $config[$required_key];
            } else {
                throw new Exception(sprintf('%s required', $required_key), 1);
            }
        }
    }

    /**
     * Search for breeds matching the defined string
     *
     * @param string $search_term Wildcard search string.
     * @throws Exception
     * @return array|mixed Response content as JSON.
     */
    public function search(string $search_term)
    {
        $endpoint = implode(
            '/',
            [
                $this->endpoint,
                $this->version,
                'breeds/search',
            ]
        );

        $response = Http::withHeaders([
            'x-api-key' => $this->api_key
        ])
        ->get(
            $endpoint,
            [
                'q' => $search_term
            ]
        );

        if ($response->successful() === true) {
            return $response->json();
        }

        throw new Exception('Error connecting to 3rd party API', 1);
    }
}

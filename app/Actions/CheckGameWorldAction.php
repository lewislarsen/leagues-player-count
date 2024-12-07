<?php

namespace App\Actions;

use App\Models\GameWorld;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use RuntimeException;

class CheckGameWorldAction {

    public function execute(): void
    {
        // Guzzle client to fetch the page
        $client = new Client();
        $response = $client->get('https://oldschool.runescape.com/slu');

        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException('Failed to fetch data from the server.');
        }

        $html = $response->getBody()->getContents();

        // Parse the HTML
        $dom = new DOMDocument();
        @$dom->loadHTML($html); // Suppress warnings
        $xpath = new DOMXPath($dom);

        // Query all rows of the game worlds table
        $rows = $xpath->query("//tr[@class='server-list__row']");

        foreach ($rows as $row) {
            // Extract data for each column
            $worldLink = $xpath->query(".//a[@class='server-list__world-link']", $row);
            $worldName = $worldLink->item(0)->nodeValue ?? null;
            $worldUrl = $worldLink->item(0)?->getAttribute('href');

            // Extract population (second td element contains player count)
            $populationCell = $xpath->query(".//td[contains(text(), 'players')]", $row);
            $population = $populationCell->item(0) ? (int) filter_var($populationCell->item(0)->nodeValue, FILTER_SANITIZE_NUMBER_INT) : null;

            // Extract country (third td element contains the country)
            $countryCell = $xpath->query(".//td[contains(@class, 'server-list__row-cell--country')]", $row);
            $country = $countryCell->item(0)->nodeValue ?? null;

            // Extract type (fourth td element contains the world type, e.g., "Free")
            $typeCell = $xpath->query(".//td[contains(@class, 'server-list__row-cell--type')]", $row);
            $type = $typeCell->item(0)->nodeValue ?? null;

            // Extract activity (fifth td element contains the activity info, e.g., "750 skill total")
            $activityCell = $xpath->query(".//td[last()]", $row);
            $activity = $activityCell->item(0)->nodeValue ?? null;

            // Insert into the database (create a new record)
            GameWorld::create([
                'world_name' => $worldName,
                'world_url' => $worldUrl,
                'type' => $type,
                'population' => $population,
                'country' => $country,
                'activity' => $activity,
            ]);
        }
    }
}

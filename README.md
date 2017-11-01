SportMonks API Client Library
=============================

[![Build Status](https://travis-ci.org/hristonev/sportmonks-client-bundle.svg?branch=master)](https://travis-ci.org/hristonev/sportmonks-client-bundle)

## API Version support

This API Client supports SportMonks v2.0.

## Requirements

- PHP 5.6 or higher

### Installation

`composer require hristonev/sportmonks-client-bundle`

## Configuration

``` php
// Bootstrap
require 'vendor/autoload.php';

use SportMonks\API\HttpClient as SportMonksAPI;

// Default values. Can be initialized without arguments.
$scheme = 'https';
$hostname = 'sportmonks.com';
$subDomain = 'soccer';
$port = 443;

// Auth.
$token = 'open sesame';

$client = new SportMonksAPI();
// or
//$client = new SportMonksAPI($scheme, $hostname, $subDomain, $port);

// Set auth.
$client->setAuth(Auth::BASIC, [
    'token' => $token
]);
```

## Usage example

### Paginated resource
``` php
$data = [];
do{
    $data = array_merge($data, $client->countries()->findAll());
}while($client->countries()->nextPage());
print_r($data);
```

## Reference

Basic methods find({id}), findAll(), nextPage(). nextPage() is used on paginated response.

- continents
- countries
- leagues
- seasons
    - find(id, true) `Include results.`
    - standings(season_id)
    - standingsLive(season_id)
    - topScorers(season_id)
- fixtures
    - between()->period(from, to, teamId) `Params from and to are DateTime objects, teamId is integer. TeamId is optional.`
    - date()->day(date) `Param is DateTime object.`
    - commentaries(fixture_id)
    - videoHighlights(fixture_id)
    - tvStations(fixture_id)
    - odds(fixture_id)
    - oddsByBookmaker(fixture_id, bookmaker_id)
    - oddsByMarket(fixture_id, market_id)
    - oddsInPlay(fixture_id)
    - `Fixtures does not support findAll method.`
- teams
    - find(id, true) `Include stats.`
    - season(id) `Get teams by season.`
    - `Teams does not support findAll method.`
- head2Head
    - get(array) `Array must contain 2 elements(team1_id,team2_id).`
    - `There is no additional mthods.`
- liveScores
    - today()
    - inPlay()
- highlights
    - `Video haighlights does not support find method. Additional method in fixtures is presented.`
- venues
    - `Venue does not support findAll method.`
- bookmakers
- players
    - `Players does not support findAll method.`
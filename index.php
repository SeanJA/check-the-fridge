<?php

date_default_timezone_set('America/Toronto');

use CheckTheFridge\Client;
use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/vendor/autoload.php';

// Create default HandlerStack
$stack = HandlerStack::create();

// Add this middleware to the top with `push`
$stack->push(
    new CacheMiddleware(
        new GreedyCacheStrategy(
            new DoctrineCacheStorage(
                new FilesystemCache('/tmp/')
            ),
            '1800'
        )
    ),
    'cache'
);

$guzzle = new GuzzleClient(['handler' => $stack]);

$client = new Client($guzzle);

$fridge = $client->checkTheFridge();

$loader = new FilesystemLoader(__DIR__ . '/views');
$twig = new Environment($loader);

if($fridge){
    echo $twig->render('index.twig', [
        'fridge' => $fridge
    ]);
    return;
}

echo $twig->render('error.twig');
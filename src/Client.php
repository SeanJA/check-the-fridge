<?php

namespace CheckTheFridge;

use GuzzleHttp\ClientInterface;

class Client
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Client constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function checkTheFridge()
    {
        $date = (new \DateTimeImmutable())->format('Y-m-d');

        $result = $this->client->request('GET', 'https://api.opencovid.ca/timeseries?date='.$date.'&loc=ON&ymd=true');

        $fridge = new Fridge($result->getBody()->getContents());

        if(!$fridge->empty()){
            return $fridge;
        }

        $date = (new \DateTimeImmutable('-1 day'))->format('Y-m-d');

        $result = $this->client->request('GET', 'https://api.opencovid.ca/timeseries?date='.$date.'&loc=ON&ymd=true');

        $fridge = new Fridge($result->getBody()->getContents());

        return $fridge;

    }
}
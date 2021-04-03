<?php


namespace CheckTheFridge;


use GuzzleHttp\ClientInterface;
use http\Client\Request;

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
        $date = (new \DateTimeImmutable('-1 day'))->format('Y-m-d');

        $result = $this->client->request('GET', 'https://api.opencovid.ca/timeseries?date=2021-04-02&loc=ON&ymd=true');

        return new Fridge($result->getBody()->getContents());
    }
}
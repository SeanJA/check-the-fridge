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

    public function checkTheFridge(): ?Fridge
    {
        $date = new \DateTimeImmutable();
        $loops = 0;
        while(true) {
            if($loops > 4){
                // give up
                return null;
            }
            $formattedDate = $date->format('Y-m-d');
            $result = $this->client->request('GET', 'https://api.opencovid.ca/timeseries?date=' . $formattedDate . '&loc=ON&ymd=true');
            $fridge = new Fridge($result->getBody()->getContents(), $date);
            $date = $date->sub(new \DateInterval('P1D'));
            $loops++;
            if(!$fridge->empty()){
                return $fridge;
            }
        }
    }
}
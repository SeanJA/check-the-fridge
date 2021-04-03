<?php


namespace CheckTheFridge;


class Fridge
{
    /**
     * @var int
     */
    private $administered;

    /**
     * @var int
     */
    private $delivered;

    /**
     * Fridge constructor.
     * @param string $json
     */
    public function __construct(string $json)
    {
        $data = json_decode($json);

        $this->administered = $data->avaccine[0]->cumulative_avaccine;
        $this->delivered = $data->dvaccine[0]->cumulative_dvaccine;
    }

    /**
     * @return int
     */
    public function contents()
    {
        return $this->delivered - $this->administered;
    }

    public function percentNotAdministered()
    {
        return number_format(($this->contents() / $this->delivered) * 100, 2);
    }
}
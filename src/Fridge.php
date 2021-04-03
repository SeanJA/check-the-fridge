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

        $this->administered = $data->avaccine[0]->cumulative_avaccine?? null;
        $this->delivered = $data->dvaccine[0]->cumulative_dvaccine?? null;
    }

    /**
     * @return string
     */
    public function contents(): string
    {
        return number_format($this->delivered - $this->administered);
    }

    /**
     * @return string
     */
    public function percentNotAdministered(): string
    {
        return number_format((($this->delivered - $this->administered) / $this->delivered) * 100, 2);
    }

    /**
     * @return bool
     */
    public function empty(): bool
    {
        return empty($this->delivered);
    }
}
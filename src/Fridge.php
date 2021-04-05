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
     * @var string
     */
    private $date;

    /**
     * Fridge constructor.
     * @param string $json
     * @param \DateTimeImmutable $date
     */
    public function __construct(string $json, \DateTimeImmutable $date)
    {
        $data = json_decode($json);

        $this->date = $date;
        $this->administered = $data->avaccine[0]->cumulative_avaccine ?? null;
        $this->delivered = $data->dvaccine[0]->cumulative_dvaccine ?? null;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getDateText(): string
    {
        return $this->date->format('F jS');
    }

    /**
     * @return int
     */
    public function getAdministered(): ?string
    {
        return $this->administered ? number_format($this->administered, 0) : null;
    }

    /**
     * @return int
     */
    public function getDelivered(): ?string
    {
        return $this->delivered ? number_format($this->delivered, 0) : null;
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
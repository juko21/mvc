<?php

namespace App\Entity;

use App\Repository\PollutionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PollutionRepository::class)]
class Pollution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'float')]
    private $sweden;

    #[ORM\Column(type: 'float')]
    private $global;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getSweden(): ?float
    {
        return $this->sweden;
    }

    public function setSweden(float $sweden): self
    {
        $this->sweden = $sweden;

        return $this;
    }

    public function getGlobal(): ?float
    {
        return $this->global;
    }

    public function setGlobal(float $global): self
    {
        $this->global = $global;

        return $this;
    }

    public function getAll(): ?array
    {
        return [$this->year, $this->sweden, $this->global, $this->sweden + $this->global];
    }
}

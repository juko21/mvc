<?php

namespace App\Entity;

use App\Repository\DemographicsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemographicsRepository::class)]
class Demographics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; /** @phpstan-ignore-line */

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'integer')]
    private $population;

    #[ORM\Column(type: 'float')]
    private $gdp;

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

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): self
    {
        $this->population = $population;

        return $this;
    }

    public function getGdp(): ?float
    {
        return $this->gdp;
    }

    public function setGdp(float $gdp): self
    {
        $this->gdp = $gdp;

        return $this;
    }
}

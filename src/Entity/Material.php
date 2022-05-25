<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; /** @phpstan-ignore-line */

    #[ORM\Column(type: 'integer')]
    private $footprint;

    #[ORM\OneToOne(targetEntity: Demographics::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $demographics;

    #[ORM\Column(type: 'integer')]
    private $year;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFootprint(): ?int
    {
        return $this->footprint;
    }

    public function setFootprint(int $footprint): self
    {
        $this->footprint = $footprint;

        return $this;
    }

    public function getDemographics(): ?Demographics
    {
        return $this->demographics;
    }

    public function setDemographics(Demographics $demographics): self
    {
        $this->demographics = $demographics;

        return $this;
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

    public function getFootprintPerPop(): ?float
    {
        $pop = $this->getDemographics()->getPopulation();
        if ($pop) {
            return round($this->footprint / $pop, 2);
        }
        return 0;
    }

    public function getFootprintPerGdp(): ?float
    {
        $gdp = $this->getDemographics()->getGdp();
        if ($gdp) {
            return round($this->footprint / $gdp, 2);
        }
        return 0;
    }

    public function getAll(): ?array
    {
        return [$this->year, $this->footprint, $this->getFootprintPerPop(), $this->getFootprintPerGdp()];
    }
}

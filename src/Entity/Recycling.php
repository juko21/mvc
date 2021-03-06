<?php

namespace App\Entity;

use App\Repository\RecyclingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecyclingRepository::class)]
class Recycling
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; /** @phpstan-ignore-line */

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'integer')]
    private $recycling;

    #[ORM\Column(type: 'integer')]
    private $other;

    #[ORM\Column(type: 'integer')]
    private $dumping;

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

    public function getRecycling(): ?int
    {
        return $this->recycling;
    }

    public function setRecycling(int $recycling): self
    {
        $this->recycling = $recycling;

        return $this;
    }

    public function getOther(): ?int
    {
        return $this->other;
    }

    public function setOther(int $other): self
    {
        $this->other = $other;

        return $this;
    }

    public function getDumping(): ?int
    {
        return $this->dumping;
    }

    public function setDumping(int $dumping): self
    {
        $this->dumping = $dumping;

        return $this;
    }

    /**
     * Returns array of all column values for entity
     *
     * @return null|array Returns array of all values from entity or null
     */
    public function getAll(): ?array
    {
        return [$this->year, $this->recycling, $this->other, $this->dumping];
    }
}

<?php

namespace App\Entity;

use App\Repository\FoodwasteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodwasteRepository::class)]
class Foodwaste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; /** @phpstan-ignore-line */

    #[ORM\Column(type: 'string', length: 255)]
    private $sector;

    #[ORM\Column(type: 'integer')]
    private $y2012;

    #[ORM\Column(type: 'integer')]
    private $y2014;

    #[ORM\Column(type: 'integer')]
    private $y2016;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSector(): ?string
    {
        return $this->sector;
    }

    public function setSector(string $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    public function getY2012(): ?int
    {
        return $this->y2012;
    }

    public function setY2012(int $y2012): self
    {
        $this->y2012 = $y2012;

        return $this;
    }

    public function getY2014(): ?int
    {
        return $this->y2014;
    }

    public function setY2014(int $y2014): self
    {
        $this->y2014 = $y2014;

        return $this;
    }

    public function getY2016(): ?int
    {
        return $this->y2016;
    }

    public function setY2016(int $y2016): self
    {
        $this->y2016 = $y2016;

        return $this;
    }

    /**
     * Returns array of all column values for entity
     *
     * @return null|array Returns array of all values from entity
     */
    public function getAll(): ?array
    {
        return [$this->sector, $this->y2012, $this->y2014, $this->y2016];
    }
}

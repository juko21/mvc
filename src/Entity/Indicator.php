<?php

namespace App\Entity;

use App\Repository\IndicatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndicatorRepository::class)]
class Indicator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; /** @phpstan-ignore-line */

    #[ORM\Column(type: 'string', length: 255)]
    private $route;

    #[ORM\Column(type: 'integer')]
    private $article_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $header;

    #[ORM\Column(type: 'boolean')]
    private $multiple;

    #[ORM\OneToMany(mappedBy: 'indicator', targetEntity: Chartdata::class)]
    private $chartdatas;

    public function __construct()
    {
        $this->chartdatas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getArticleId(): ?int
    {
        return $this->article_id;
    }

    public function setArticleId(int $article_id): self
    {
        $this->article_id = $article_id;

        return $this;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(string $header): self
    {
        $this->header = $header;

        return $this;
    }

    public function isMultiple(): ?bool
    {
        return $this->multiple;
    }

    public function setMultiple(bool $multiple): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * @return Collection<int, Chartdata>
     */
    public function getChartdatas(): Collection
    {
        return $this->chartdatas;
    }

    public function addChartdata(Chartdata $chartdata): self
    {
        if (!$this->chartdatas->contains($chartdata)) {
            $this->chartdatas[] = $chartdata;
            $chartdata->setIndicator($this);
        }

        return $this;
    }

    public function removeChartdata(Chartdata $chartdata): self
    {
        if ($this->chartdatas->removeElement($chartdata)) {
            // set the owning side to null (unless already changed)
            if ($chartdata->getIndicator() === $this) {
                $chartdata->setIndicator(null);
            }
        }

        return $this;
    }
}

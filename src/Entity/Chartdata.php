<?php

namespace App\Entity;

use App\Repository\ChartdataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChartdataRepository::class)]
class Chartdata
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; /** @phpstan-ignore-line */

    #[ORM\Column(type: 'integer')]
    private $article_id;

    #[ORM\Column(type: 'integer')]
    private $indicator_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Indicator::class, inversedBy: 'chartdatas')]
    #[ORM\JoinColumn(nullable: false)]
    private $indicator;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIndicatorId(): ?int
    {
        return $this->indicator_id;
    }

    public function setIndicatorId(int $indicator_id): self
    {
        $this->indicator_id = $indicator_id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIndicator(): ?Indicator
    {
        return $this->indicator;
    }
    
    public function setIndicator(?Indicator $indicator): self
    {
        $this->indicator = $indicator;

        return $this;
    }
}

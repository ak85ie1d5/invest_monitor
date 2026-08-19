<?php

namespace App\Entity;

use App\Enum\Currency;
use App\Enum\ProductDirection;
use App\Enum\ProductType;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(enumType: ProductType::class)]
    private ?ProductType $productType = null;

    #[ORM\Column(enumType: ProductDirection::class)]
    private ?ProductDirection $productDirection = null;

    #[ORM\Column(length: 12)]
    private ?string $Isin = null;

    #[ORM\Column(nullable: true)]
    private ?float $StopLossLevel = null;

    #[ORM\Column(nullable: true, enumType: Currency::class)]
    private ?Currency $stopLossCurrency = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?float $leverage = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $underlyingName = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $underlyingIsin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getProductType(): ?ProductType
    {
        return $this->productType;
    }

    public function setProductType(ProductType $productType): static
    {
        $this->productType = $productType;

        return $this;
    }

    public function getProductDirection(): ?ProductDirection
    {
        return $this->productDirection;
    }

    public function setProductDirection(ProductDirection $productDirection): static
    {
        $this->productDirection = $productDirection;

        return $this;
    }

    public function getIsin(): ?string
    {
        return $this->Isin;
    }

    public function setIsin(string $Isin): static
    {
        $this->Isin = $Isin;

        return $this;
    }

    public function getStopLossLevel(): ?float
    {
        return $this->StopLossLevel;
    }

    public function setStopLossLevel(?float $StopLossLevel): static
    {
        $this->StopLossLevel = $StopLossLevel;

        return $this;
    }

    public function getStopLossCurrency(): ?Currency
    {
        return $this->stopLossCurrency;
    }

    public function setStopLossCurrency(Currency $stopLossCurrency): static
    {
        $this->stopLossCurrency = $stopLossCurrency;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getLeverage(): ?float
    {
        return $this->leverage;
    }

    public function setLeverage(float $leverage): static
    {
        $this->leverage = $leverage;

        return $this;
    }

    public function getUnderlyingName(): ?string
    {
        return $this->underlyingName;
    }

    public function setUnderlyingName(?string $underlyingName): static
    {
        $this->underlyingName = $underlyingName;

        return $this;
    }

    public function getUnderlyingIsin(): ?string
    {
        return $this->underlyingIsin;
    }

    public function setUnderlyingIsin(?string $underlyingIsin): static
    {
        $this->underlyingIsin = $underlyingIsin;

        return $this;
    }
}

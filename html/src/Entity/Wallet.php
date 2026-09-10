<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantityPurchased = null;

    #[ORM\Column]
    private ?float $purchasePrice = null;

    #[ORM\Column(nullable: true)]
    private ?float $sellingPrice = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantitySold = null;

    #[ORM\Column]
    private ?\DateTime $dateOfPurchase = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateOfSale = null;

    #[ORM\ManyToOne(inversedBy: 'wallets')]
    private ?ArticleArchive $Article = null;

    #[ORM\ManyToOne(inversedBy: 'walletRows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $Product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantityPurchased(): ?int
    {
        return $this->quantityPurchased;
    }

    public function setQuantityPurchased(int $quantityPurchased): static
    {
        $this->quantityPurchased = $quantityPurchased;

        return $this;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(float $purchasePrice): static
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getSellingPrice(): ?float
    {
        return $this->sellingPrice;
    }

    public function setSellingPrice(?float $sellingPrice): static
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    public function getQuantitySold(): ?int
    {
        return $this->quantitySold;
    }

    public function setQuantitySold(int $quantitySold): static
    {
        $this->quantitySold = $quantitySold;

        return $this;
    }

    public function getDateOfPurchase(): ?\DateTime
    {
        return $this->dateOfPurchase;
    }

    public function setDateOfPurchase(\DateTime $dateOfPurchase): static
    {
        $this->dateOfPurchase = $dateOfPurchase;

        return $this;
    }

    public function getDateOfSale(): ?\DateTime
    {
        return $this->dateOfSale;
    }

    public function setDateOfSale(?\DateTime $dateOfSale): static
    {
        $this->dateOfSale = $dateOfSale;

        return $this;
    }

    public function getArticle(): ?ArticleArchive
    {
        return $this->Article;
    }

    public function setArticle(?ArticleArchive $Article): static
    {
        $this->Article = $Article;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): static
    {
        $this->Product = $Product;

        return $this;
    }
}

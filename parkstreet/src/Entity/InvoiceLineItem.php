<?php

namespace App\Entity;

use App\Repository\InvoiceLineItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceLineItemRepository::class)
 */
class InvoiceLineItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $invoice_num;

    /**
     * @ORM\OneToOne(targetEntity=Invoice::class, cascade={"persist", "remove"})
     */
    private $invoice;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $product_id;

    /**
     * @ORM\OneToOne(targetEntity=Invoice::class, inversedBy="invoiceLineItem", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="float")
     */
    private $qty;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceNum(): ?string
    {
        return $this->invoice_num;
    }

    public function setInvoiceNum(string $invoice_num): self
    {
        $this->invoice_num = $invoice_num;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->product_id;
    }

    public function setProductId(string $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getProduct(): ?Invoice
    {
        return $this->product;
    }

    public function setProduct(Invoice $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQty(): ?float
    {
        return $this->qty;
    }

    public function setQty(float $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function toArray()
    {
        return [
            'product_id' => $this->getProductId(),
            'invoice_num' => $this->getInvoiceNum(),
            'qty' => $this->getQty(),
            'price' => $this->getPrice(),
        ];
    }
}

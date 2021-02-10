<?php

namespace App\Entity;

use App\Repository\ViewInvoicesReportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ViewInvoicesReportRepository::class)
 */
class ViewInvoicesReport
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $invoice_num;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $invoice_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_id;

    /**
     * @ORM\Column(type="string", length=255)
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

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    public function getInvoiceNum(): ?string
    {
        return $this->invoice_num;
    }

    
    public function getInvoiceDate(): ?string
    {
        return $this->invoice_date;
    }

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function getProductId(): ?string
    {
        return $this->product_id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function getQty(): ?string
    {
        return $this->qty;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function toArray()
    {
        return [
            'invoice_date' => $this->getInvoiceDate(),
            'invoice_num' => $this->getInvoiceNum(),
            'client_id' => $this->getClientId(),
            'client_name' => $this->getClientName(),
            'product_id' => $this->getProductId(),
            'product' => $this->getProduct(),
            'qty' => $this->getQty(),
            'price' => $this->getPrice(),
            'total' => $this->getTotal(),
        ];
    }

}

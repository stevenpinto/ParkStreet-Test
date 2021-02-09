<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $invoice_date;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $invoice_num;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $client_id;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, inversedBy="invoices", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=InvoiceLineItem::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $invoiceLineItem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceDate(): ?\DateTimeInterface
    {
        return $this->invoice_date;
    }

    public function setInvoiceDate(\DateTimeInterface $invoice_date): self
    {
        $this->invoice_date = $invoice_date;

        return $this;
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

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientId(string $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getInvoiceLineItem(): ?InvoiceLineItem
    {
        return $this->invoiceLineItem;
    }

    public function setInvoiceLineItem(InvoiceLineItem $invoiceLineItem): self
    {
        // set the owning side of the relation if necessary
        if ($invoiceLineItem->getProduct() !== $this) {
            $invoiceLineItem->setProduct($this);
        }

        $this->invoiceLineItem = $invoiceLineItem;

        return $this;
    }

    public function toArray()
    {
        return [
            'invoice_date' => $this->getInvoiceDate(),
            'client_id' => $this->getClientId(),
            'invoice_num' => $this->getInvoiceNum(),
        ];
    }
}

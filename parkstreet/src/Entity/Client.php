<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ORM\Table(name="Clients")
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     */
    private $client_id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $client_name;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="client")
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity=Invoice::class, mappedBy="client", cascade={"persist", "remove"})
     */
    private $invoices;

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientId(string $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): self
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getInvoices(): ?Invoice
    {
        return $this->invoices;
    }

    public function setInvoices(Invoice $invoices): self
    {
        // set the owning side of the relation if necessary
        if ($invoices->getClient() !== $this) {
            $invoices->setClient($this);
        }

        $this->invoices = $invoices;

        return $this;
    }

    public function toArray()
    {
        return [
            'client_id' => $this->getClientId(),
            'client_name' => $this->getClientName(),
            'invoices' => $this->getInvoices(),
        ];
    }
}

<?php

namespace Models;

use DateTime;
use Helpers\ClassHelperTrait;

class Invoice
{
    use ClassHelperTrait;

    public int    $id;
    public string $client;
    public float  $invoiceAmount;
    public float $invoiceAmountPlusVat;
    public float $vatRate;
    public string $invoiceStatus;
    public DateTime $invoiceDate;
    public DateTime $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getClient(): string
    {
        return $this->client;
    }

    /**
     * @param string $client
     */
    public function setClient(string $client): void
    {
        $this->client = $client;
    }

    /**
     * @return float
     */
    public function getInvoiceAmount(): float
    {
        return $this->invoiceAmount;
    }

    /**
     * @param float $invoiceAmount
     */
    public function setInvoiceAmount(float $invoiceAmount): void
    {
        $this->invoiceAmount = $invoiceAmount;
    }

    /**
     * @return float
     */
    public function getInvoiceAmountPlusVat(): float
    {
        return $this->invoiceAmountPlusVat;
    }

    /**
     * @param float $invoiceAmountPlusVat
     */
    public function setInvoiceAmountPlusVat(float $invoiceAmountPlusVat): void
    {
        $this->invoiceAmountPlusVat = $invoiceAmountPlusVat;
    }

    /**
     * @return float
     */
    public function getVatRate(): float
    {
        return $this->vatRate;
    }

    /**
     * @param float $vatRate
     */
    public function setVatRate(float $vatRate): void
    {
        $this->vatRate = $vatRate;
    }

    /**
     * @return string
     */
    public function getInvoiceStatus(): string
    {
        return $this->invoiceStatus;
    }

    /**
     * @param string $invoiceStatus
     */
    public function setInvoiceStatus(string $invoiceStatus): void
    {
        $this->invoiceStatus = $invoiceStatus;
    }

    /**
     * @return DateTime
     */
    public function getInvoiceDate(): DateTime
    {
        return $this->invoiceDate;
    }

    /**
     * @param DateTime $invoiceDate
     */
    public function setInvoiceDate(DateTime $invoiceDate): void
    {
        $this->invoiceDate = $invoiceDate;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}


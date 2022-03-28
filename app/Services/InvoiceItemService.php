<?php

namespace Services;

use Core\Service;
use Repositories\InvoiceItemRepository;

class InvoiceItemService extends Service
{
    private InvoiceItemRepository $invoiceItemRepository;

    public function __construct()
    {
        parent::__construct();
        $this->invoiceItemRepository = $this->serviceManager::getInstance(InvoiceItemRepository::class);
    }

    /**
     * @return string file path to download
     */
    public function createReport(): string
    {
        $tempFileName = sys_get_temp_dir() . '/customer-report.csv';
        $handle       = fopen($tempFileName, 'w');

        fputcsv($handle, ['Invoice ID', 'Company Name', 'Invoice Amount']);
        foreach ($this->invoiceItemRepository->getTransactions() as $items) {
            fputcsv($handle, $items);
        }

        fclose($handle);

        unset($handle);

        return $tempFileName;
    }
}

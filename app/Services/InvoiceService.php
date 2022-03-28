<?php

namespace Services;

use Core\Service;
use Helpers\StringHelperTrait;
use Repositories\InvoiceRepository;

class InvoiceService extends Service
{
    use StringHelperTrait;

    private InvoiceRepository $invoiceRepository;

    public function __construct()
    {
        parent::__construct();
        $this->invoiceRepository = $this->serviceManager::getInstance(InvoiceRepository::class);
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function all(int $page, int $limit): array
    {
        return $this->invoiceRepository->findByFilters($page, $limit);
    }

    /**
     * @param int $id
     * @param string $field
     * @param mixed $value
     *
     * @return bool
     */
    public function patchField(int $id, string $field, mixed $value): bool
    {
        return $this->invoiceRepository->updateField(
            $id,
            $this->camelCaseToUnderScore($field),
            $value
        );
    }

    /**
     * @return string file path to download
     */
    public function createReport(): string
    {
        $tempFileName = sys_get_temp_dir() . '/customer-report.csv';
        $handle       = fopen($tempFileName, 'w');

        fputcsv($handle, ['Company Name', 'Total Invoiced amount', 'Total Amount Paid', 'Total Amount Outstanding']);
        foreach ($this->invoiceRepository->getCustomerInvoiceInsight() as $items) {
            fputcsv($handle, $items);
        }

        fclose($handle);

        unset($handle);

        return $tempFileName;
    }
}

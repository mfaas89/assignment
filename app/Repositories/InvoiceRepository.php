<?php

namespace Repositories;

use Core\Repository;
use Models\Invoice;
use PDO;

class InvoiceRepository extends Repository
{
    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function findByFilters(int $page, int $limit): array
    {
        $offset = $page - 1;
        $stmt   = $this->connection->prepare('SELECT * FROM invoices limit :offset, :limit');

        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Invoice::class);
    }

    /**
     * @param int $id
     * @param string $field
     * @param mixed $value
     *
     * @return bool
     */
    public function updateField(int $id, string $field, mixed $value): bool
    {
        $stmt = $this->connection->prepare("update invoices set $field = :value where id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        match (true) {
            is_string($value) => $stmt->bindParam(':value', $value, PDO::PARAM_STR),
            is_int($value) => $stmt->bindParam(':value', $value, PDO::PARAM_INT),
        };

        return $stmt->execute();
    }

    public function getCustomerInvoiceInsight(): array
    {
        $query = "
            SELECT
                `invoices`.client,
                `invoices`.invoice_amount_plus_vat as total,
                sum(`invoice_items`.amount) as paid,
                (`invoices`.invoice_amount_plus_vat -  sum(`invoice_items`.amount)) as outstanding
            FROM `invoice_items`
            left join `invoices`
                on `invoices`.id = `invoice_items`.invoice_id
            group by `invoices`.id
        ";

        $stmt = $this->connection->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

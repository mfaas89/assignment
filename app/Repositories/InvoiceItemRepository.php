<?php

namespace Repositories;

use Core\Repository;
use PDO;

class InvoiceItemRepository extends Repository
{
    public function getTransactions(): array
    {
        $query = "
            SELECT
                `invoice_items`.invoice_id as id,
                `invoices`.client as name,
                `invoice_items`.amount as amount
            FROM `invoice_items`
            left join `invoices`
                on `invoices`.id = `invoice_items`.invoice_id
        ";

        $stmt = $this->connection->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

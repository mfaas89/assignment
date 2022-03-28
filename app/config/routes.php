<?php

use Controllers\InvoiceController;
use Controllers\InvoiceItemController;

return [
    'v1' => [
        'invoices' => [
            'controller' => InvoiceController::class,
            'methods' => [
                'patch' => 'patch'
            ],
            'get' => 'index',
            'download' => [
                'get' => 'download'
            ],
        ],
        'items' => [
            'controller' => InvoiceItemController::class,
            'download' => [
                'get' => 'download'
            ],
        ],
    ]
];

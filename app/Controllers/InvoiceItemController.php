<?php

namespace Controllers;

use Core\Controller;
use Services\InvoiceItemService;

class InvoiceItemController extends Controller implements ControllerInterface
{
    private InvoiceItemService $invoiceService;

    public function __construct()
    {
        parent::__construct();

        $this->invoiceService = $this->serviceManager::getInstance(InvoiceItemService::class);
    }

    public function download(): void
    {
        $this->downloadResponse($this->invoiceService->createReport());
    }
}

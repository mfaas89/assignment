<?php

namespace Controllers;

use Core\Controller;
use Models\Invoice;
use ReflectionException;
use Services\InvoiceService;

class InvoiceController extends Controller implements ControllerInterface
{
    private InvoiceService $invoiceService;

    public function __construct()
    {
        parent::__construct();

        $this->invoiceService = $this->serviceManager::getInstance(InvoiceService::class);
    }

    public function index()
    {
        $page  = $this->getInput('page', 1);
        $limit = $this->getInput('limit', 5);

        $this->response(200, $this->invoiceService->all($page, $limit));
    }

    /**
     * @throws ReflectionException
     */
    public function patch()
    {
        $id     = $this->getInput('id');
        $field  = $this->getInput('field');
        $value  = $this->getInput('value');

        if (in_array(null, [$id, $field, $value])
            || !$this->validateDataAgainstModel(Invoice::class, $field, $value)
        ) {
            $this->response(422, [
                'id' => $id,
                'field' => $field,
                'value' => $value,
            ], 'Missing data');
            return;
        }

        $isUpdated = $this->invoiceService->patchField($id, $field, $value);

        $isUpdated
            ? $this->response(200, [])
            : $this->response(500, [], 'Something went wrong with updating field ' . $field);
    }

    public function download(): void
    {
        $this->downloadResponse($this->invoiceService->createReport());
    }
}

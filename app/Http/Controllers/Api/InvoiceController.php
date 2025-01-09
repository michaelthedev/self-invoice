<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\InvoiceStatus;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class InvoiceController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->response(
            message: "invoices",
            data: Invoice::with(['client', 'project'])
                ->latest()->paginate()
        );
    }

    public function show(string $uid): JsonResponse
    {
        $invoice = Invoice::with(['client', 'project'])
            ->where('uid', $uid)->firstOrFail();

        return $this->response(
            message: "invoice $uid",
            data: $invoice
        );
    }

    public function store(CreateInvoiceRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $items = $validated['items'];
        // get total amount
        $total = 0;
        foreach ($items as $item) {
            $total += $item['unit'] * $item['quantity'];
        }

        $validated['amount'] = $total;
        unset($validated['items']);

        $invoice = Invoice::create($validated);

        // create invoice items
        $invoice->items()->createMany($items);

        return $this->response(
            status: 201,
            message: "Invoice created",
            data: $invoice
        );
    }

    public function update(UpdateInvoiceRequest $request, string $uid): JsonResponse
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();
        $validated = $request->validated();

        $items = $validated['items'];
        // get total amount
        $total = 0;
        foreach ($items as $item) {
            $total += $item['unit'] * $item['quantity'];
        }

        $validated['amount'] = $total;
        unset($validated['items']);

        $invoice->update($validated);

        // update invoice items
        $invoice->items()->delete();
        $invoice->items()->createMany($items);

        return $this->response(
            message: "invoice $uid updated",
            data: $invoice
        );
    }

    public function destroy(string $uid): JsonResponse
    {
        Invoice::where('uid', $uid)->delete();

        return $this->response(
            message: "invoice $uid deleted"
        );
    }

    public function download(string $uid): JsonResponse
    {
        return $this->response(
            message: "invoice $uid downloaded"
        );
    }

    public function updateStatus(Request $request, string $uid): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'string'],
            'payment_proof' => ['sometimes', 'file', 'mimetypes:application/pdf,image/png,image/jpeg']
        ]);

        $allowedStatuses = [
            InvoiceStatus::UNPAID,
            InvoiceStatus::CANCELLED,
            InvoiceStatus::PAID,
        ];

        if (! in_array($request->status, $allowedStatuses)) {
            return $this->response(
                message: "invalid invoice status",
                status: 422
            );
        }

        return $this->response(
            message: "invoice $uid status updated"
        );
    }
}

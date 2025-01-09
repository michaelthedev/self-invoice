<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ClientController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->response(
            message: "Clients",
            data: Client::with(['projects', 'invoices'])
                ->latest()->paginate()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['sometimes', 'nullable', 'email'],
            'phone' => ['sometimes', 'nullable', 'string'],
            'company' => ['sometimes', 'nullable', 'string'],
            'address' => ['sometimes', 'nullable', 'string'],
        ]);

        $client = Client::create($validated);

        return $this->response(
            status: 201,
            message: "Client created",
            data: $client
        );
    }

    public function show(Client $client): JsonResponse
    {
        // include projects and invoices
        $client->load(['projects', 'invoices']);

        return $this->response(
            message: "Client",
            data: $client
        );
    }

    public function update(Request $request, Client $client): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['sometimes', 'string'],
            'last_name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'nullable', 'email'],
            'phone' => ['sometimes', 'nullable', 'string'],
            'company' => ['sometimes', 'nullable', 'string'],
            'address' => ['sometimes', 'nullable', 'string'],
        ]);

        $client->update($validated);

        return $this->response(
            message: "Client updated",
            data: $client
        );
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return $this->response(
            message: "Client deleted"
        );
    }
}

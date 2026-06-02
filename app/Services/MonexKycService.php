<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonexKycService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $timeout;
    protected int $connectTimeout;

    public function __construct()
    {
        $this->baseUrl        = rtrim(config('services.monex_kyc.base_url'), '/');
        $this->apiKey         = (string) config('services.monex_kyc.api_key');
        $this->timeout        = (int) config('services.monex_kyc.timeout', 30);
        $this->connectTimeout = (int) config('services.monex_kyc.connect_timeout', 10);
    }

    public function nameLookup(string $bankName, string $accountNumber): array
    {
        $payload = [
            'bankName'      => strtoupper(trim($bankName)),
            'accountNumber' => trim($accountNumber),
        ];

        Log::channel('mto')->info('Monex KYC lookup request', [
            'url'     => "{$this->baseUrl}/api/public/v1/namelookup",
            'payload' => $payload,
        ]);

        try {
            $response = Http::withHeaders([
                'x-api-key'    => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])
                ->timeout($this->timeout)
                ->connectTimeout($this->connectTimeout)
                ->retry(2, 500, throw: false)
                ->post("{$this->baseUrl}/api/public/v1/namelookup", $payload);

            $data = $response->json() ?? [];

            Log::channel('mto')->info('Monex KYC lookup response', [
                'status' => $response->status(),
                'body'   => $data,
            ]);

            return [
                'ok'                 => $response->successful() && ($data['success'] ?? false) === true,
                'status'             => $response->status(),
                'success'            => $data['success'] ?? false,
                'name'               => $data['name'] ?? null,
                'charged'            => $data['charged'] ?? false,
                'amount'             => $data['amount'] ?? 0,
                'balance'            => $data['balance'] ?? null,
                'third_party_status' => $data['third_party_status'] ?? null,
                'error'              => $data['error'] ?? null,
                'raw'                => $data,
            ];
        } catch (ConnectionException $e) {
            Log::channel('mto')->error('Monex KYC connection error', [
                'message' => $e->getMessage(),
                'class'   => get_class($e),
                'payload' => $payload,
            ]);

            return [
                'ok'     => false,
                'status' => 504,
                'error'  => 'Upstream connection error: ' . $e->getMessage(),
                'raw'    => null,
            ];
        } catch (RequestException $e) {
            Log::channel('mto')->error('Monex KYC request error', [
                'message' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return [
                'ok'     => false,
                'status' => $e->response?->status() ?? 500,
                'error'  => $e->getMessage(),
                'raw'    => $e->response?->json(),
            ];
        }
    }
}

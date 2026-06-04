<?php

namespace App\Http\Controllers\Mto;

use App\Http\Controllers\Controller;
use App\Models\MtoAccount;
use App\Services\MonexKycService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountLookupController extends Controller
{
    public function __construct(protected MonexKycService $kyc) {}

    public function lookup(Request $request): JsonResponse
    {
        $identifier     = $request->input('identifier');
        $identifierType = $request->input('identifierType');
        $destinationFsp = $request->input('destinationFsp');
        $clientID       = $request->input('clientID');
        $requestID      = $request->input('requestID');

        Log::channel('mto')->info('Account lookup request received', [
            'requestID'      => $requestID,
            'clientID'       => $clientID,
            'identifier'     => $identifier,
            'identifierType' => $identifierType,
            'destinationFsp' => $destinationFsp,
            'ip'             => $request->ip(),
        ]);

        if (empty($identifier) || empty($identifierType)) {
            Log::channel('mto')->warning('Account lookup failed: missing required fields', [
                'requestID'      => $requestID,
                'identifier'     => $identifier,
                'identifierType' => $identifierType,
            ]);

            return response()->json([
                'responsecode'        => '54',
                'responsedescription' => 'Missing required fields: identifier or identifierType',
            ], 400);
        }

        $account = MtoAccount::where('identifier', $identifier)
            ->where('identifier_type', $identifierType)
            ->where('is_active', true)
            ->first();

        if ($account) {
            Log::channel('mto')->info('Account lookup served from local registry', [
                'requestID' => $requestID,
                'clientID'  => $clientID,
                'fspId'     => $account->fsp_id,
            ]);

            return response()->json([
                'responsecode'        => '00',
                'responsedescription' => 'SUCCESS',
                'identifierType'      => $account->identifier_type,
                'identifier'          => $account->identifier,
                'fspId'               => $account->fsp_id,
                'fullName'            => $account->full_name,
                'accountCategory'     => $account->account_category,
                'accountType'         => $account->account_type,
                'identity'            => [
                    'type'  => $account->identity_type,
                    'value' => $account->identity_value,
                ],
            ], 200);
        }

        $bankName = $this->resolveBankName($destinationFsp);

        if (empty($bankName)) {
            Log::channel('mto')->warning('Account lookup failed: unresolved destination FSP', [
                'requestID'      => $requestID,
                'destinationFsp' => $destinationFsp,
            ]);

            return response()->json([
                'responsecode'        => '54',
                'responsedescription' => 'Unsupported or missing destinationFsp',
            ], 400);
        }

        $result = $this->kyc->nameLookup($bankName, $identifier);

        if (!$result['ok'] || empty($result['name'])) {
            Log::channel('mto')->warning('Account lookup failed via upstream KYC', [
                'requestID'          => $requestID,
                'bankName'           => $bankName,
                'status'             => $result['status'] ?? null,
                'third_party_status' => $result['third_party_status'] ?? null,
                'error'              => $result['error'] ?? null,
            ]);

            $thirdPartyStatus = $result['third_party_status'] ?? null;

            if ($thirdPartyStatus && $thirdPartyStatus >= 500) {
                return response()->json([
                    'responsecode'        => '96',
                    'responsedescription' => 'Upstream provider error, please retry',
                ], 502);
            }

            return response()->json([
                'responsecode'        => '54',
                'responsedescription' => 'Account not found',
            ], 404);
        }

        Log::channel('mto')->info('Account lookup successful via upstream KYC', [
            'requestID' => $requestID,
            'clientID'  => $clientID,
            'bankName'  => $bankName,
            'name'      => $result['name'],
            'balance'   => $result['balance'],
        ]);

        return response()->json([
            'responsecode'        => '00',
            'responsedescription' => 'SUCCESS',
            'identifierType'      => $identifierType,
            'identifier'          => $identifier,
            'fspId'               => $destinationFsp,
            'fullName'            => $result['name'],
            'accountCategory'     => null,
            'accountType'         => null,
            'identity'            => [
                'type'  => null,
                'value' => null,
            ],
        ], 200);
    }

    protected function resolveBankName(?string $destinationFsp): ?string
    {
        if (empty($destinationFsp)) {
            return null;
        }

        $map = [
            // numeric codes
            '003' => 'CRDB',
            '004' => 'NMB',
            '013' => 'EXIM',
            '015' => 'NBC',
            '006' => 'STANBIC',
            '011' => 'DTB',
            '009' => 'BOA',
            '020' => 'ABSA',
            '021' => 'IMB',
            '040' => 'ECOBANK',
            '046' => 'AMANA',
            '031' => 'AZANIA',
            '024' => 'DCB',
            '034' => 'BANCABC',
            '039' => 'MKOMBOZI',
            '048' => 'TPB',
            '503' => 'VODACOM',
            '504' => 'AIRTEL',
            '501' => 'TIGO',
            '506' => 'HALOPESA',
            '507' => 'Azampesa',
            // name aliases
            'CRDB'     => 'CRDB',
            'NMB'      => 'NMB',
            'NBC'      => 'NBC',
            'EQUITY'   => 'EQUITY',
            'DTB'      => 'DTB',
            'STANBIC'  => 'STANBIC',
            'AIRTEL'   => 'AIRTEL',
            'TIGO'     => 'TIGO',
            'YAS'      => 'TIGO',
            'VODACOM'  => 'VODACOM',
            'MPESA'    => 'VODACOM',
            'HALOPESA' => 'HALOPESA',
            'HALOTEL'  => 'HALOPESA',
            'AZAMPESA' => 'Azampesa',
            'AZAM'     => 'Azampesa',
        ];

        $key = strtoupper(trim($destinationFsp));

        return $map[$key] ?? null;
    }
}

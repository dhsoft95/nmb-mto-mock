<?php

namespace App\Http\Controllers\Mto;

use App\Http\Controllers\Controller;
use App\Models\MtoAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountLookupController extends Controller
{
    public function lookup(Request $request): JsonResponse
    {
        $identifier     = $request->input('identifier');
        $identifierType = $request->input('identifierType');
        $destinationFsp = $request->input('destinationFsp');
        $clientID       = $request->input('clientID');
        $requestID      = $request->input('requestID');

        if (empty($identifier) || empty($identifierType)) {
            return response()->json([
                'responsecode'        => '54',
                'responsedescription' => 'Missing required fields: identifier or identifierType',
            ], 400);
        }

        $account = MtoAccount::where('identifier', $identifier)
            ->where('identifier_type', $identifierType)
            ->where('is_active', true)
            ->first();

        if (!$account) {
            return response()->json([
                'responsecode'        => '54',
                'responsedescription' => 'Account not found',
            ], 404);
        }

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
}

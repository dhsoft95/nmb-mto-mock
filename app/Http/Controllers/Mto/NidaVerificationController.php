<?php

namespace App\Http\Controllers\Mto;

use App\Http\Controllers\Controller;
use App\Services\MockNidaVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NidaVerificationController extends Controller
{
    protected $nidaService;

    public function __construct(MockNidaVerificationService $nidaService)
    {
        $this->nidaService = $nidaService;
    }

    /**
     * Step 1: User submits NIN, gets verification question
     */
    public function initiate(Request $request): JsonResponse
    {
        $request->validate([
            'nin' => 'required|string|size:20'
        ]);

        $result = $this->nidaService->initiateVerification($request->nin);

        if (!$result['success']) {
            return response()->json([
                'responsecode' => '54',
                'responsedescription' => $result['message']
            ], 404);
        }

        return response()->json([
            'responsecode' => '00',
            'responsedescription' => 'Verification initiated',
            'session_id' => $result['session_id'],
            'question' => $result['question'],
            'remaining_attempts' => $result['remaining_attempts']
        ]);
    }

    /**
     * Step 2: User answers question
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string',
            'answer' => 'required|string'
        ]);

        $result = $this->nidaService->verifyAnswer($request->session_id, $request->answer);

        if (!$result['verified']) {
            $statusCode = isset($result['remaining_attempts']) && $result['remaining_attempts'] == 0 ? 403 : 400;

            return response()->json([
                'responsecode' => '54',
                'responsedescription' => $result['message'],
                'remaining_attempts' => $result['remaining_attempts'] ?? 0
            ], $statusCode);
        }

        return response()->json([
            'responsecode' => '00',
            'responsedescription' => 'NIDA verification successful',
            'user_info' => $result['user_info']
        ]);
    }
}

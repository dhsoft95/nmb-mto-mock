<?php

namespace App\Services;

use App\Models\NidaTestAccount;
use Illuminate\Support\Facades\Cache;

class MockNidaVerificationService
{
    private const MAX_ATTEMPTS = 3;

    /**
     * Start a verification session for a NIN
     */
    public function initiateVerification(string $nin): array
    {
        // Find the test NIN in your database
        $account = NidaTestAccount::where('nin', $nin)->first();

        if (!$account) {
            return [
                'success' => false,
                'message' => 'NIN not found in test database',
                'remaining_attempts' => 0
            ];
        }

        // Create or get existing session
        $sessionId = $this->createSession($nin);

        // Generate a random verification question
        $questions = $this->getQuestions($account);
        $selectedQuestion = $questions[array_rand($questions)];

        // Store the expected answer for this session
        Cache::put("nida_session_{$sessionId}", [
            'nin' => $nin,
            'expected_answer' => $selectedQuestion['answer'],
            'attempts' => 0,
            'question' => $selectedQuestion['question']
        ], now()->addMinutes(10));

        return [
            'success' => true,
            'session_id' => $sessionId,
            'question' => $selectedQuestion['question'],
            'remaining_attempts' => self::MAX_ATTEMPTS
        ];
    }

    /**
     * Verify the answer provided by user
     */
    public function verifyAnswer(string $sessionId, string $userAnswer): array
    {
        $session = Cache::get("nida_session_{$sessionId}");

        if (!$session) {
            return [
                'success' => false,
                'message' => 'Session expired or invalid',
                'verified' => false
            ];
        }

        $attempts = $session['attempts'] + 1;
        $remaining = self::MAX_ATTEMPTS - $attempts;

        // Check if answer matches (case-insensitive)
        if (strtolower(trim($userAnswer)) === strtolower(trim($session['expected_answer']))) {
            // Success! Return user information
            $account = NidaTestAccount::where('nin', $session['nin'])->first();

            // Clear the session
            Cache::forget("nida_session_{$sessionId}");

            return [
                'success' => true,
                'verified' => true,
                'user_info' => [
                    'nin' => $account->nin,
                    'full_name' => $account->full_name,
                    'date_of_birth' => $account->date_of_birth,
                ],
                'message' => 'Verification successful'
            ];
        }

        // Update attempts count
        $session['attempts'] = $attempts;
        Cache::put("nida_session_{$sessionId}", $session, now()->addMinutes(10));

        if ($attempts >= self::MAX_ATTEMPTS) {
            Cache::forget("nida_session_{$sessionId}");
            return [
                'success' => false,
                'verified' => false,
                'message' => 'Maximum attempts exceeded. Verification failed.',
                'remaining_attempts' => 0
            ];
        }

        return [
            'success' => false,
            'verified' => false,
            'message' => 'Incorrect answer',
            'remaining_attempts' => $remaining,
            'question' => $session['question'] // Ask again?
        ];
    }

    /**
     * Get possible verification questions for an account
     */
    private function getQuestions($account): array
    {
        return [
            [
                'question' => "What is your mother's name?",
                'answer' => $account->mother_name
            ],
            [
                'question' => "Where were you born?",
                'answer' => $account->birth_place
            ],
            [
                'question' => "What is your date of birth? (Format: YYYY-MM-DD)",
                'answer' => $account->date_of_birth
            ],
            [
                'question' => "What is the last 4 digits of your NIN?",
                'answer' => substr($account->nin, -4)
            ]
        ];
    }

    private function createSession(string $nin): string
    {
        return uniqid('nida_') . '_' . md5($nin . time());
    }
}

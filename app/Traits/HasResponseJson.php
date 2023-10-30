<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Throwable;

trait HasResponseJson
{
    /**
     * @param mixed|array $payload
     * ['message', 'data', 'meta' => ['limit', 'offset', 'filtered_total','total'], 'errors']
     * @param int $statusCode
     * @param Throwable|null $th
     * @return JsonResponse
     * @throws Throwable
     */
    public function responseJson(array $payload = [], int $statusCode = 200, Throwable $th = null): \Illuminate\Http\JsonResponse
    {
        if ($statusCode >= 200 && $statusCode < 400) {
            if (!empty($payload['meta'])) {
                $payload['meta'] = [
                    'limit'          => (int) $payload['meta']['limit'],
                    'offset'         => (int) $payload['meta']['offset'],
                    'filtered_total' => (int) $payload['meta']['filtered_total'],
                    'total'          => (int) $payload['meta']['total']
                ];
            }
            return response()->json([
                'message'   => $payload['message'] ?? $this->message($statusCode),
                'data'      => $payload['data']    ?? [],
                'meta'      => $payload['meta']    ?? [],
            ], $statusCode);
        } else if ($statusCode >= 400 && $statusCode < 500) {
            return response()->json([
                'message'  => $payload['message']  ?? $this->message($statusCode),
                'errors'   => $payload['errors']   ?? [],
            ], $statusCode);
        } else {
            return response()->json([
                'message'  => $payload['message']  ?? $this->message($statusCode),
            ], $statusCode);
        }
    }

    /**
     * @param int $statusCode
     * @return string $message
     */
    private function message($statusCode)
    {
        return [
            200 => 'OK.',
            201 => 'Created.',
            400 => 'Bad Request.',
            401 => 'Unauthenticated.',
            403 => 'Forbidden.',
            404 => 'Not Found.',
            405 => 'Method Not Allowed.',
            422 => 'Validation Errors.',
            429 => 'Too Many Requests.',
            500 => 'Internal Server Error.',
            501 => 'Not Implemented.',
            502 => 'Bad Gateway.',
            503 => 'Service Unavailable.',
        ][$statusCode];
    }
}

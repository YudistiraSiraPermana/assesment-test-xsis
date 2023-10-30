<?php

namespace App\Exceptions;

/**
 * Handler Response JSON data
 */
class HandlerResponse
{
    /**
     * @param int $status
     * @return string $message
     */
    private static function message($status)
    {
        $message = [
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
        ];

        return $message[$status];
    }

    /**
     * @param  mixed $data 
     * @param  int $status [200, 201, 202, 400, 401, 403, 404, 405, 422, 429, 500]
     * @return \Illuminate\Http\Response
     */
    public static function responseJSON($data = [], $status = 200, \Throwable $th = null): \Illuminate\Http\JsonResponse
    {
        if ($status >= 200 && $status < 400) {
            if (!empty($data['meta'])) {
                $data['meta'] = [
                    'limit'          => (int) $data['meta']['limit'],
                    'offset'         => (int) $data['meta']['offset'],
                    'filtered_total' => (int) $data['meta']['filtered_total'],
                    'total'          => (int) $data['meta']['total']
                ];
            }
            return response()->json([
                'message'   => $data['message'] ?? self::message($status),
                'data'      => $data['data']    ?? [],
                'meta'      => $data['meta']    ?? [],
            ], $status);
        } else if ($status >= 400 && $status < 500) {
            return response()->json([
                'message'  => $data['message']  ?? self::message($status),
                'errors'   => $data['errors']   ?? [],
            ], $status);
        } else {
            if (config('app.env') == true) throw $th;
            return response()->json([
                'message'  => $data['message']  ?? self::message($status),
            ], $status);
        }
    }
}

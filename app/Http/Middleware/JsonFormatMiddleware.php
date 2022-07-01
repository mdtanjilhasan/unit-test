<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonFormatMiddleware
{
    public function handle(Request $request, Closure $next): \Illuminate\Http\JsonResponse
    {
        $response = $next($request);
        $status = $response->getStatusCode();
        $data = $response->getData();
        $message = $response->statusText();
        $success = $status === 200;
        $errors = [];

        if ($status === 422) {
            $message = 'Validation Error.';
            foreach ($data as $key => $value) {
                $errors[$key] = reset($value);
            }
            $data = [];
        }

        if ($success) {
            $data = $data->data ?? $data;
            if (optional($data)->message) {
                $message = $data->message;
                unset($data->message);
            }
        }

        if (($status / 10) == 50) {
            $message = 'Server Error. Please contact Admin';
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => (object)$data, 'errors' => (object)$errors]);
    }
}

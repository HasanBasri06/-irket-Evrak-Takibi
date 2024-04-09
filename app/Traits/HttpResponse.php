<?php

namespace App\Traits;

trait HttpResponse {
    protected function success($data, $message, $code = 200) {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => 'success',
        ], $code);
    }

    protected function error($data, $message, $code) {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => 'error',
        ], $code);
    }

    protected function info($data, $message, $code) {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => 'info',
        ], $code);
    }
}

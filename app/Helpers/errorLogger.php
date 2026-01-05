<?php

namespace App\Helpers;

use Throwable;

class ErrorLogger
{
    public static function log(Throwable $e, string $message = '', array $context = [])
    {
        $errorId = (string) \Str::uuid();

        \Log::error("[$errorId]".$message, array_merge([
            'error_id' => $errorId,
            'exception' => $e,
            'error_msg' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'user_id' => \Auth::id(),
            'url' => request()->fullUrl() ?? null,
            'ip' => request()->header('x-forwarded-for'),
        ], $context));

        return $errorId;
    }
}

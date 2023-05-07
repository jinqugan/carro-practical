<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{

    /**
     * Generate successful response array.
     *
     * @return bool
     */
    public function requestResponses()
    {
        return [
            'data' => NULL,
        ];
    }

    /**
     * Generate fail response array.
     *
     * @param int $code
     * @param string $codeMsg
     * @param string $message
     * @param array $details
     * @return array
     */
    public function responseErrors(int|string $code = null, string $codeMsg = null, string $message = null, array $details = null): array
    {
        if ($code == null) {
            return ['errors' => null];
        }

        return [
            'errors' => [
                'code' => $code,
                'code_msg' => $codeMsg,
                'message' => $message,
                'details' => $details,
            ],
        ];
    }

    public function renderException(\Throwable $exception): ?JsonResponse
    {
        $responses = $this->requestResponses();

        if ($exception instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
            $errorCode = Response::HTTP_TOO_MANY_REQUESTS;

            $result = $responses + $this->responseErrors(
                $errorCode,
                Response::$statusTexts[$errorCode],
                trans('auth.throttle', ['seconds' => 60]),
                ['exception' => $exception->getMessage()],
            );

            return response()->json($result, $errorCode);
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $errorCode = Response::HTTP_UNAUTHORIZED;

            $result = $responses + $this->responseErrors(
                $errorCode,
                Response::$statusTexts[$errorCode],
                trans('auth.unauthenticated_access'),
                ['exception' => $exception->getMessage()],
            );

            return response()->json($result, $errorCode);
        }

        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            $errorCode = Response::HTTP_FORBIDDEN;

            $result = $responses + $this->responseErrors(
                $errorCode,
                Response::$statusTexts[$errorCode],
                trans('auth.unauthorized_access'),
                ['exception' => $exception->getMessage()],
            );

            return response()->json($result, $errorCode);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            $errorCode = Response::HTTP_NOT_FOUND;

            $result = $responses + $this->responseErrors(
                $errorCode,
                Response::$statusTexts[$errorCode],
                trans('auth.http_not_found'),
                ['exception' => $exception->getMessage()],
            );

            return response()->json($result, $errorCode);
        }

        if ($exception instanceof \Symfony\Component\Routing\Exception\MethodNotAllowedException) {
            $errorCode = Response::HTTP_METHOD_NOT_ALLOWED;

            $result = $responses + $this->responseErrors(
                $errorCode,
                Response::$statusTexts[$errorCode],
                trans('auth.method_not_found'),
                ['exception' => $exception->getMessage()],
            );

            return response()->json($result, $errorCode);
        }

        if ($exception instanceof \Throwable) {
            $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR;

            $result = $responses + $this->responseErrors(
                $errorCode,
                Response::$statusTexts[$errorCode],
                trans('auth.unexpected_error_occur'),
                ['exception' => $exception->getMessage()],
            );

            return response()->json($result, $errorCode);
        }

        return null;
    }
}

<?php

namespace App\Support\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseHttp;
use Illuminate\Contracts\Validation\Validator;

class Response
{

    /**
     *  Return a standard JSON success response.
     * @param mixed $data
     * @param int $code
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function success(mixed $data, int $code = ResponseHttp::HTTP_OK, array $headers = []): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => is_string($data) ? $data : 'ok',
            'data'    => is_string($data) ? null : $data,
        ];

        return response()
            ->json($response, $code)
            ->withHeaders($headers);
    }

    /**
     * Return a standard error response.
     * @param \Throwable $error
     *
     * @return JsonResponse
     */
    public static function error(\Throwable $error): JsonResponse
    {
        $statusCode = self::isStandardHttpStatusCode($error->getCode())
            ? $error->getCode()
            : ResponseHttp::HTTP_INTERNAL_SERVER_ERROR;

        if($statusCode == 404) {
            return self::notFound($error->getMessage());
        }

        $response = [
            'success'    => false,
            'message'    => $statusCode === 500
                ? 'Unexpected error occurred. Please try again later or contact support.'
                : 'An error occurred during the process.',
            'error' => [
                'statusCode' => $statusCode,
                'details'    => $error->getMessage(),
            ],
        ];

        return response()->json($response, $statusCode);
    }


    /**
     * Returns a generic error response.
     * @param \Throwable $error
     *
     * @return JsonResponse
     */
    public static function genericError( string $error, int $statusCode ): JsonResponse
    {
        $statusCode = self::isStandardHttpStatusCode($statusCode)
            ? $statusCode
            : ResponseHttp::HTTP_INTERNAL_SERVER_ERROR;
        $response = [
            'success'    => false,
            'message'    => $statusCode === 500
                ? 'Unexpected error occurred. Please try again later or contact support.'
                : 'An error occurred during the process.',
            'error' => [
                'statusCode' => $statusCode,
                'details'    => $error,
            ],
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Return a standard 404 response.
     * @param \Throwable $error
     *
     * @return JsonResponse
     */
    private static function notFound(string $message = 'Resource not found.'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Not found.',
            'errors'  => ['details' => $message],
        ], ResponseHttp::HTTP_NOT_FOUND);
    }

    /**
     * Throw a validation error response.
     * @param array|string $errors
     * @param int $code
     *
     * @return void
     */
    public static function validation(Validator $errors, int $code = ResponseHttp::HTTP_UNPROCESSABLE_ENTITY): void
    {
        throw new HttpResponseException(new JsonResponse([
            'success' => false,
            'message' => 'Validation failed. Please review the input data.',
            'errors'  => $errors->errors(),
        ], $code));
    }

    /**
     * Throw an authorization error response.
     * @param mixed string
     * @param int $code
     *
     * @return void
     */
    public static function forbidden(string $message = 'You do not have permission to perform this action.', int $code = ResponseHttp::HTTP_FORBIDDEN): void
    {
        throw new HttpResponseException(new JsonResponse([
            'success' => false,
            'message' => 'Access denied.',
            'errors'  => ['details' => $message],
        ], $code));
    }


    /**
     * Throw an authentication error response.
     * @param mixed string
     * @param int $code
     *
     * @return void
     */
    public static function unauthenticated(string $message = 'You are not authenticated to access this resource.', int $code = ResponseHttp::HTTP_UNAUTHORIZED): void
    {
        throw new HttpResponseException(new JsonResponse([
            'success' => false,
            'message' => 'Authentication required.',
            'errors'  => ['details' => $message],
        ], $code));
    }


    /**
     * Check if the status code is a valid HTTP status code.
     * @param int $statusCode
     *
     * @return bool
     */
    private static function isStandardHttpStatusCode(int $statusCode): bool
    {
        return isset(ResponseHttp::$statusTexts[$statusCode]);
    }
}

<?php

namespace App\Documentation;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *     response="InternalServerError",
 *     description="Internal Server Error — erro interno no servidor",
 *     @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Unexpected error occurred. Please try again later or contact support."),
 *         @OA\Property(
 *             property="error", type="object",
 *             @OA\Property(property="statusCode", type="integer", example=500),
 *             @OA\Property(property="details", type="string", example="Erro de conexão com o banco de dados")
 *         )
 *     )
 * )
 *
 * @OA\Response(
 *     response="UnauthorizedError",
 *     description="Authentication required",
 *     @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Authentication required."),
 *         @OA\Property(
 *             property="errors", type="object",
 *             @OA\Property(property="details", type="string", example="You are not authenticated to access this resource.")
 *         )
 *     )
 * )
 *
 * @OA\Response(
 *     response="ForbiddenError",
 *     description="Access denied",
 *     @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Access denied."),
 *         @OA\Property(
 *             property="errors", type="object",
 *             @OA\Property(property="details", type="string", example="You do not have permission to perform this action.")
 *         )
 *     )
 * )
 */
class SharedResponses {}

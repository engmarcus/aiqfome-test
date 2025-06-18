<?php
namespace App\Documentation\Annotations\Client;

use Illuminate\Http\JsonResponse;

class FavoriteAnnotation
{
    /**
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT"
     * )
     */
    /**
     * @OA\Get(
     *     path="/api/v1/clients/{clientId}/favorites",
     *     operationId="listFavorites",
     *     tags={"Favorites"},
     *     summary="Lista produtos favoritos do cliente autenticado",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="ID do cliente",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de favoritos retornada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="ok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="product_id", type="integer", example=10),
     *                     @OA\Property(property="client_id", type="integer", example=3),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-18T10:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-18T10:00:00Z"),
     *                 )
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Nenhum favorito encontrado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Requisição inválida",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred during the process."),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="statusCode", type="integer", example=400),
     *                 @OA\Property(property="details", type="string", example="Erro detail")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Authentication required."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="details", type="string", example="You are not authenticated to access this resource.")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acesso negado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Access denied."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="details", type="string", example="You do not have permission to perform this action.")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro inesperado no servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unexpected error occurred. Please try again later or contact support."),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="statusCode", type="integer", example=500),
     *                 @OA\Property(property="details", type="string", example="Mensagem do erro")
     *             )
     *         )
     *     )
     * )
     *
     * Lista os favoritos do cliente autenticado
     *
     * @param  int  $clientId
     * @return JsonResponse
     */
    public function list() {}
}

<?php
namespace App\Documentation\Annotations\Client;

use OpenApi\Annotations as OA;

class FavoriteAnnotation
{
       /**
     * @OA\Get(
     *     path="/api/v1/clients/{clientId}/favorites",
     *     operationId="listFavorites",
     *     tags={"Favorites"},
     *     summary="Lista produtos favoritos do cliente autenticado",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos favoritos",
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
     *                     @OA\Property(property="title", type="string", example="Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops"),
     *                     @OA\Property(property="image", type="string", format="url", example="https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg"),
     *                     @OA\Property(property="price", type="number", format="float", example=109.95),
     *                     @OA\Property(property="review", type="number", format="float", example=3.9),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Sem favoritos - Nenhum conteúdo para mostrar"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedError"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         ref="#/components/responses/ForbiddenError"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         ref="#/components/responses/InternalServerError"
     *     )
     * )
     */
    public function list() {}

    /**
     * @OA\Post(
     *     path="/api/v1/clients/{clientId}/favorites/{productId}",
     *     operationId="addFavorite",
     *     tags={"Favorites"},
     *     summary="Adiciona um produto aos favoritos de um cliente",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="No Content — favorito salvo com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found — produto não localizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred during the process."),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="statusCode", type="integer", example=404),
     *                 @OA\Property(property="details", type="string", example="Product not found: ID 1")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedError"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         ref="#/components/responses/ForbiddenError"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         ref="#/components/responses/InternalServerError"
     *     )
     * )
     */
    public function add() {}
}

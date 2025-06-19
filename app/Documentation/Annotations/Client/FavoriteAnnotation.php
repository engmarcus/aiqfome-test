<?php
namespace App\Documentation\Annotations\Client;

use OpenApi\Annotations as OA;
/**
 * @OA\Tag(
 *     name="Favorites",
 *     description="Endpoints relacionados aos produtos favoritos do cliente e seu gerenciamento"
 * )
 */
class FavoriteAnnotation
{
    /**
     * @OA\Get(
     *     path="/api/v1/clients/{clientId}/favorites",
     *     tags={"Favorites"},
     *     summary="(Privado) Listar produtos favoritos do cliente",
     *     description="Retorna a lista de produtos favoritos do cliente autenticado. Se não houver favoritos, retorna 204.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="ID do cliente",
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de favoritos retornada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="ok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="favorites",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="title", type="string", example="Mens Cotton Jacket"),
     *                         @OA\Property(property="image", type="string", format="uri", example="https://fakestoreapi.com/img/71li-ujtlUL._AC_UX679_.jpg"),
     *                         @OA\Property(property="price", type="number", format="float", example=55.99),
     *                         @OA\Property(property="review", type="number", format="float", example=4.7)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Nenhum produto favorito encontrado (sem conteúdo)"
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
     *     tags={"Favorites"},
     *     summary="(Privado) Adicionar produto aos favoritos",
     *     description="Adiciona um produto aos favoritos do cliente autenticado. Se já estiver adicionado, informa. Em caso de sucesso, retorna header Location para a listagem.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="ID do cliente",
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         description="ID do produto a ser favoritado",
     *         @OA\Schema(type="integer", example=32)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto favoritado ou já existente nos favoritos",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Added to favorited"),
     *             @OA\Property(property="data", type="string", nullable=true, example=null)
     *         ),
     *         @OA\Header(
     *             header="Location",
     *             description="URL para listar os produtos favoritos atualizados",
     *             @OA\Schema(type="string", example="/api/v1/clients/0/favorites")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Not found."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="details", type="string", example="Product not found: ID 32")
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
    /**
     * @OA\Delete(
     *     path="/api/v1/clients/{clientId}/favorites/{productId}",
     *     tags={"Favorites"},
     *     summary="(Privado) Remover produto dos favoritos",
     *     description="Remove o produto dos favoritos do cliente autenticado. Se não existir nos favoritos, retorna erro 404. Em sucesso, retorna 204 e header 'Location' com a lista atualizada.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         required=true,
     *         description="ID do cliente",
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         description="ID do produto a ser removido dos favoritos",
     *         @OA\Schema(type="integer", example=32)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto removido dos favoritos (sem conteúdo)",
     *         @OA\Header(
     *             header="Location",
     *             description="URL para listar os produtos favoritos atualizados",
     *             @OA\Schema(type="string", example="/api/v1/clients/0/favorites")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado nos favoritos",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Not found."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="details", type="string", example="Favorite not found: ID 32")
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
    public function remove() {}


}

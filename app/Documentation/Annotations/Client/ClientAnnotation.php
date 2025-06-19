<?php
namespace App\Documentation\Annotations\Client;

use OpenApi\Annotations as OA;
/**
* @OA\Tag(
*     name="Clients",
*     description="Endpoints relacionados a clientes e seu gerenciamento"
* )
*/
class ClientAnnotation
{
        /**
     * @OA\Get(
     *     path="/api/v1/clients/{clientId}/profile",
     *     tags={"Clients"},
     *     summary="(Privado)Obter perfil do cliente",
     *     description="Retorna os dados do perfil do cliente autenticado pelo ID.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         description="ID do cliente",
     *         required=true,
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Perfil do cliente retornado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="ok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=0),
     *                     @OA\Property(property="name", type="string", example="Ai que fome"),
     *                     @OA\Property(property="email", type="string", example="user@aiqfome.com")
     *                 )
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
     *         response=422,
     *         description="Falha de validação dos campos",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         ref="#/components/responses/InternalServerError"
     *     )
     * )
     */
    public function profile(){}
    /**
     * @OA\Post(
     *     path="/api/v1/clients/register",
     *     tags={"Clients"},
     *     summary="Cadastrar um novo cliente",
     *     description="Cria um novo cliente no sistema. Em caso de sucesso, retorna o cliente criado e o header `Location` com URL para buscar os dados do cliente.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Ai Q Fome"),
     *             @OA\Property(property="email", type="string", format="email", example="user@aiqfome.com"),
     *             @OA\Property(property="password", type="string", format="password", example="senha123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="ok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=0),
     *                 @OA\Property(property="name", type="string", example="user"),
     *                 @OA\Property(property="email", type="string", example="user@email"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-19T16:56:44.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-19T16:56:44.000000Z")
     *             )
     *         ),
     *         @OA\Header(
     *             header="Location",
     *             description="URL para buscar os dados do cliente criado",
     *             @OA\Schema(type="string", example="/api/v1/clients/0/profile")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Falha de validação dos campos",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         ref="#/components/responses/InternalServerError"
     *     )
     * )
    */
    public function create() {}
    /**
     * @OA\Patch(
     *     path="/api/v1/clients/{clientId}",
     *     tags={"Clients"},
     *     summary="(Privado) Atualizar nome do cliente",
     *     description="Atualiza os dados do cliente autenticado. Apenas o campo 'name' pode ser alterado. Retorna os dados atualizados e um header 'Location' com a URL do perfil.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         description="ID do cliente a ser atualizado",
     *         required=true,
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Ai Q Fome marcus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="ok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=0),
     *                 @OA\Property(property="name", type="string", example="Ai Q Fome marcus"),
     *                 @OA\Property(property="email", type="string", example="user@aiqfome.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-17T19:37:06.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-19T17:13:54.000000Z")
     *             )
     *         ),
     *         @OA\Header(
     *             header="Location",
     *             description="URL para o perfil atualizado do cliente",
     *             @OA\Schema(type="string", example="/api/v1/clients/0/profile")
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
     *         response=422,
     *         description="Falha de validação dos campos",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         ref="#/components/responses/InternalServerError"
     *     )
     * )
     */
    public function edit(){}

    /**
     * @OA\Delete(
     *     path="/api/v1/clients/{clientId}",
     *     tags={"Clients"},
     *     summary="(Privado) Deletar cliente",
     *     description="Remove permanentemente o cliente identificado por clientId. A ação é irreversível. Rota protegida.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="path",
     *         description="ID do cliente a ser deletado",
     *         required=true,
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Cliente deletado com sucesso (sem conteúdo)"
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
    public function delete() {}
}

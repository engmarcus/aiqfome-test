<?php
namespace App\Documentation\Annotations\Auth;

/**
* @OA\Tag(
*     name="Auth",
*     description="Endpoints para autenticação e gerenciamento de sessão dos clientes"
* )
*/
class LoginAnnotation
{

    /**
    * @OA\Post(
    *     path="/api/v1/auth/login",
    *     tags={"Auth"},
    *     summary="Autenticar cliente",
    *     description="Realiza a autenticação do cliente e retorna um token JWT válido.",
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"email","password"},
    *             @OA\Property(property="email", type="string", example="user@aiqfome.com"),
    *             @OA\Property(property="password", type="string", example="123456")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Autenticado com sucesso",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="ok"),
    *             @OA\Property(
    *                 property="data",
    *                 type="object",
    *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJh..."),
    *                 @OA\Property(property="tokenType", type="string", example="Bearer"),
    *                 @OA\Property(property="expiresIn", type="integer", example=3600)
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Falha na autenticação",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=false),
    *             @OA\Property(property="message", type="string", example="An error occurred during the process."),
    *             @OA\Property(
    *                 property="error",
    *                 type="object",
    *                 @OA\Property(property="statusCode", type="integer", example=401),
    *                 @OA\Property(property="details", type="string", example="Invalid email or password.")
    *             )
    *         )
    *     )
    * )
    */
    public function login() {}
    /**
    * @OA\Post(
    *     path="/api/v1/auth/reset",
    *     tags={"Auth"},
    *     summary="Resetar a senha de um cliente",
    *     description="Permite que um cliente altere sua senha atual, informando a senha antiga.",
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"email", "password", "newPassword", "newPasswordConfirmed"},
    *             @OA\Property(property="email", type="string", example="user@aiqfome.com"),
    *             @OA\Property(property="password", type="string", example="senhaAtual123"),
    *             @OA\Property(property="newPassword", type="string", example="novaSenha123"),
    *             @OA\Property(property="newPasswordConfirmed", type="string", example="novaSenha123")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Senha atualizada com sucesso",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Password updated successfully."),
    *             @OA\Property(property="data", type="string", nullable=true, example=null)
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         ref="#/components/responses/UnauthorizedError"
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Falha de validação dos campos",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=false),
    *             @OA\Property(property="message", type="string", example="Validation failed. Please review the input data."),
    *             @OA\Property(
    *                 property="errors",
    *                 type="object",
    *                 @OA\Property(
    *                     property="newPasswordConfirmed",
    *                     type="array",
    *                     @OA\Items(type="string", example="The new password confirmed must match new password.")
    *                 )
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         ref="#/components/responses/InternalServerError"
    *     )
    * )
    */
    public function resetPassword(){}
    /**
     * @OA\Get(
     *     path="/api/v1/auth/me",
     *     tags={"Auth"},
     *     summary="Retorna dados do usuário autenticado",
     *     description="Obtém as informações do usuário logado e dados da autenticação atual.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Dados do usuário autenticado retornados com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="ok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=45),
     *                     @OA\Property(property="name", type="string", example="Ai Q Fome"),
     *                     @OA\Property(property="email", type="string", example="user@aiqfome.com"),
     *                     @OA\Property(property="role", type="string", example="user")
     *                 ),
     *                 @OA\Property(
     *                     property="auth",
     *                     type="object",
     *                     @OA\Property(property="type", type="string", example="Bearer"),
     *                     @OA\Property(property="expiresIn", type="integer", example=3600),
     *                     @OA\Property(property="expiresAt", type="string", format="date-time", example="2025-06-19T15:42:44-03:00"),
     *                     @OA\Property(property="authenticatedAt", type="string", format="date-time", example="2025-06-19T14:42:44-03:00")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedError"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         ref="#/components/responses/InternalServerError"
     *     )
     * )
     */
    public function me(){}

    /**
    * @OA\Post(
    *     path="/api/v1/auth/logout",
    *     tags={"Auth"},
    *     summary="Faz logout do usuário autenticado",
    *     description="Encerra a sessão do usuário e invalida o token de autenticação.",
    *     security={{"bearerAuth":{}}},
    *     @OA\Response(
    *         response=200,
    *         description="Logout realizado com sucesso",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="Logged out successfully"),
    *             @OA\Property(property="data", type="string", nullable=true, example=null)
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         ref="#/components/responses/UnauthorizedError"
    *     ),
    *     @OA\Response(
    *         response=500,
    *         ref="#/components/responses/InternalServerError"
    *     )
    * )
    */
    public function logout(){}
}

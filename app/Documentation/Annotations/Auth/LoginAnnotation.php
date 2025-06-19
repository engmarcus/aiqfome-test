<?php
namespace App\Documentation\Annotations\Auth;


class LoginAnnotation
{

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="Login do cliente",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token gerado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="ok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="token", type="string", example="OG123123E......."),
     *                 @OA\Property(property="tokenType", type="string", example="Bearer"),
     *                 @OA\Property(property="expiresIn", type="integer", example=3600)
     *             )
     *         )
     *     )
     * )
     */
    public function login() {}
}

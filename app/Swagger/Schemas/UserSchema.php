<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User schema",
 *     type="object",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="age", type="integer", example=25)
 * )
 */
class UserSchema {}
